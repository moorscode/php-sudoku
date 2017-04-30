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
	protected $tree = [];

	public function __construct( Board $board ) {
		$decorator  = new HTMLDecorator();
		$player     = new Player();
		$validator  = new Validator();
		$variations = new Variations();

		$player->addAlgorithm( new DetermineColumnCandidates() );
		$player->addAlgorithm( new DetermineRowCandidates() );
		$player->addAlgorithm( new DetermineGroupCandidates() );

		$player->addAlgorithm( new SoleCandidate() );
		$player->addAlgorithm( new SoleRowCandidate() );
		$player->addAlgorithm( new SoleGroupCandidate() );
		$player->addAlgorithm( new SoleColumnCandidate() );

		$player->addAlgorithm( new PairGroupCandidates() );

		$decorator->decorate( $board, false );

		$start = microtime( true );

		if ( ! $this->complete( $player, $board, $validator ) ) {
			foreach ( [ 0, 1, 3, 10, 15 ] as $maxDepth ) {
				$this->maxDepth = $maxDepth;

				$result = $this->runVariations( $board, $variations, $player, $validator );
				if ( $result ) {
					$board = $result;
					break;
				}
			}
		}

		printf( '<p>Algorithm calls: %d<br/>Time (after %d variations): %fms</p>', $player->getAlgorithmCalls(), $this->variationCount, microtime( true ) - $start );

		if ( $validator->validate( $board ) ) {
			echo '<p>Solution has been found!</p>';
			$decorator->decorate( $board );
		}
	}

	/**
	 * @param Player    $player
	 * @param Board     $board
	 * @param Validator $validator
	 *
	 * @return bool
	 */
	protected function complete( Player $player, Board $board, Validator $validator ) {
		$player->play( $board );

		return $validator->validate( $board );
	}

	/**
	 * @param Board      $board
	 * @param Variations $variations
	 * @param Player     $player
	 * @param Validator  $validator
	 * @param int        $depth
	 *
	 * @return Board
	 * @throws DepthException
	 */
	protected function runVariations( Board $board, Variations $variations, Player $player, Validator $validator, $depth = 0 ) {
		if ( $depth > $this->maxDepth ) {
			throw new DepthException();
		}

		foreach ( $variations->variation( $board ) as $variation ) {
			$hash = BoardHasher::hash( $variation );
			if ( ! array_key_exists( $hash, $this->boards ) ) {
				$this->variationCount ++;

				if ( $this->complete( $player, $variation, $validator ) ) {
					return $variation;
				}

				$this->boards[ $hash ] = $variation;
			}

			$variation = $this->boards[ $hash ];

			try {
				$test = $this->runVariations( $variation, $variations, $player, $validator, ++ $depth );
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
