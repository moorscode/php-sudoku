<?php

namespace Sudoku;

use Sudoku\Algorithms\DetermineColumnCandidates;
use Sudoku\Algorithms\DetermineGroupCandidates;
use Sudoku\Algorithms\DetermineRowCandidates;
use Sudoku\Algorithms\PairGroupCandidates;
use Sudoku\Algorithms\SoleCandidate;
use Sudoku\Algorithms\SoleGroupCandidate;
use Sudoku\Algorithms\SoleRowCandidate;
use Sudoku\Algorithms\SoleColumnCandidate;
use Sudoku\Exceptions\DepthException;
use Sudoku\Exceptions\InvalidMoveException;
use Sudoku\Validators\Validator;

class App {
	protected $variationCount = 0;
	protected $boards = [];

	public function __construct( Board $board ) {
		$decorator = new HTMLDecorator();

		$this->player     = new Player();
		$this->validator  = new Validator();
		$this->variations = new Variations();

		$this->player->addAlgorithm( new DetermineColumnCandidates() );
		$this->player->addAlgorithm( new DetermineRowCandidates() );
		$this->player->addAlgorithm( new DetermineGroupCandidates() );

		$this->player->addAlgorithm( new SoleCandidate() );
		$this->player->addAlgorithm( new SoleRowCandidate() );
		$this->player->addAlgorithm( new SoleGroupCandidate() );
		$this->player->addAlgorithm( new SoleColumnCandidate() );

		$this->player->addAlgorithm( new PairGroupCandidates() );

		$decorator->decorate( $board, false );

		$start = microtime( true );

		if ( ! $this->complete( $board ) ) {
			foreach ( [ 0, 1, 3, 10, 15 ] as $maxDepth ) {
				$this->maxDepth = $maxDepth;

				$result = $this->runVariations( $board );
				if ( $result ) {
					$board = $result;
					break;
				}
			}
		}

		printf( '<p>Algorithm calls: %d<br/>Time (after %d variations): %fms</p>', $this->player->getAlgorithmCalls(), $this->variationCount, microtime( true ) - $start );

		if ( $this->validator->validate( $board ) ) {
			echo '<p>Solution has been found!</p>';
			$decorator->decorate( $board );
		}
	}

	/**
	 * @param Board $board
	 *
	 * @return bool
	 */
	protected function complete( Board $board ) {
		$this->player->play( $board );

		return $this->validator->validate( $board );
	}

	/**
	 * @param Board $board
	 * @param int   $depth
	 *
	 * @return Board
	 * @throws DepthException
	 */
	protected function runVariations( Board $board, $depth = 0 ) {
		if ( $depth > $this->maxDepth ) {
			throw new DepthException();
		}

		foreach ( $this->variations->variation( $board ) as $variation ) {
			$hash = BoardHasher::hash( $variation );
			if ( ! array_key_exists( $hash, $this->boards ) ) {
				$this->variationCount ++;

				if ( $this->complete( $variation ) ) {
					return $variation;
				}

				$this->boards[ $hash ] = $variation;
			}

			$variation = $this->boards[ $hash ];

			try {
				$test = $this->runVariations( $variation, ++ $depth );
				if ( null !== $test ) {
					return $test;
				}
			} catch ( DepthException $e ) {
			} catch ( InvalidMoveException $e ) {
			}
		}

		return null;
	}
}
