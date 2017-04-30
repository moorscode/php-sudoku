<?php

namespace Sudoku;

use Sudoku\Algorithms\AlgorithmInterface;
use Sudoku\Algorithms\DetermineColumnCandidates;
use Sudoku\Algorithms\DetermineGroupCandidates;
use Sudoku\Algorithms\DetermineRowCandidates;
use Sudoku\Algorithms\PairColumnCandidates;
use Sudoku\Algorithms\PairRowCandidates;
use Sudoku\Algorithms\PairGroupCandidates;
use Sudoku\Algorithms\SoleCandidate;
use Sudoku\Algorithms\SoleGroupCandidate;
use Sudoku\Algorithms\SoleRowCandidate;
use Sudoku\Algorithms\SoleColumnCandidate;
use Sudoku\Validators\Validator;

class App {
	/** @var AlgorithmInterface[] Algorithms */
	protected $algorithms;

	protected $algorithmCalls = 0;
	protected $successfulAlgorithmCalls = 0;
	protected $success = [];

	public function __construct( $boardSize = 9, array $known = array() ) {
		$decorator = new HTMLDecorator();

		$board = new Board( $boardSize, $known );
		$decorator->decorate( $board, false );

		$this->addAlgorithm( new DetermineColumnCandidates() );
		$this->addAlgorithm( new DetermineRowCandidates() );
		$this->addAlgorithm( new DetermineGroupCandidates() );

		$this->addAlgorithm( new SoleCandidate() );
		$this->addAlgorithm( new SoleRowCandidate() );
		$this->addAlgorithm( new SoleColumnCandidate() );
		$this->addAlgorithm( new SoleGroupCandidate() );

		$this->addAlgorithm( new PairGroupCandidates() );
//		$this->addAlgorithm( new PairColumnCandidates() );
//		$this->addAlgorithm( new PairRowCandidates() );

		$start = microtime( true );

		$this->tryAllMoves( $board );

		$initial = microtime( true );

		$triedVariations = 0;
		if ( ! $board->done() ) {
			foreach ( $this->getVariation( clone $board ) as $variation ) {
				$triedVariations ++;
				$this->tryAllMoves( $variation );
				if ( $variation->done() ) {
					$board = $variation;
					break;
				}
			}
		}

		$validator = new Validator();
		if ( $validator->validate( $board ) ) {
			echo '<p>Solution has been found!</p>';
			$decorator->decorate( $board );
		}


		printf( '<p>Algorithm calls: %d</p>', $this->algorithmCalls );
		printf( '<p>Initial: %fms<br/>Total (after %d variations): %fms</p>', $initial - $start, $triedVariations, microtime( true ) - $start );
	}

	/**
	 * @param Board $board
	 *
	 * @return \Generator
	 */
	protected function getVariation( Board $board ) {
		$boardSize = $board->getSize();

		// Start with lowest number of options left.
		foreach ( range( 2, 9 ) as $optionCount ) {
			foreach ( range( 0, $boardSize - 1 ) as $y ) {
				foreach ( range( 0, $boardSize - 1 ) as $x ) {
					$coords = new Coords( $x, $y );

					$cell    = $board->get( $coords );
					$options = $cell->getOptions();
					if ( count( $options ) !== $optionCount ) {
						continue;
					}

					foreach ( $options as $option ) {
						$variationCell = clone $cell;
						$variationCell->set( $option );

						$variation = clone $board;
						$variation->set( $coords, $variationCell );

						yield $variation;
					}
				}
			}
		}
	}

	/**
	 *
	 */
	protected function run( Board $board ) {
		foreach ( $this->unfilled( $board ) as $coords ) {
			foreach ( $this->algorithms as $algorithm ) {
				++ $this->algorithmCalls;

				$cell = $algorithm->run( $board, $coords );
				$board->set( $coords, $cell );
				if ( null !== $cell->get() ) {
					$this->registerSuccess( $algorithm );
					break;
				}
			}
		}
	}

	/**
	 * @param Board $board
	 *
	 * @return \Generator
	 */
	public function unfilled( Board $board ) {
		$boardSize = $board->getSize();
		/**
		 * @var int   $x
		 * @var array $_x
		 */
		foreach ( range( 0, $boardSize - 1 ) as $x ) {
			/**
			 * @var int  $y
			 * @var Cell $cell
			 */
			foreach ( range( 0, $boardSize - 1 ) as $y ) {
				$coords = new Coords( $x, $y );
				$cell   = $board->get( $coords );
				if ( null === $cell->get() ) {
					yield $coords;
				}
			}
		}
	}

	/**
	 * @param AlgorithmInterface $algorithm
	 */
	protected function addAlgorithm( AlgorithmInterface $algorithm ) {
		$this->algorithms[] = $algorithm;
	}

	/**
	 * @param Board $board
	 *
	 * @return Board
	 */
	protected function tryAllMoves( Board $board ) {
		do {
			$oldBoard = BoardHasher::hash( $board );
			$this->run( $board );
		} while ( $oldBoard !== BoardHasher::hash( $board ) );
	}

	private function registerSuccess( $algorithm ) {
		@ $this->success[ get_class( $algorithm ) ] ++;
	}
}
