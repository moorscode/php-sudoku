<?php

namespace Sudoku;

use Sudoku\Exceptions\DepthException;
use Sudoku\Exceptions\InvalidMoveException;

class Variations {
	protected $maxDepth = 0;
	protected $runCallback;

	protected $boards = [];

	protected $variationMetric;
	protected $depthMetric;

	/**
	 * Variations constructor.
	 *
	 * @param StatisticsInterface|null $statistics
	 */
	public function __construct( StatisticsInterface $statistics ) {
		$this->variationMetric = $statistics->register( 'variations', 'Variations: %d', 0 );
		$this->depthMetric     = $statistics->register( 'depth', 'Max depth: %d', 0 );
	}

	/**
	 * @param BoardInterface $board
	 * @param int            $depth
	 *
	 * @return BoardInterface
	 * @throws DepthException
	 */
	public function run( BoardInterface $board, $depth = 0 ) {
		$this->depthMetric->max( $depth );
		if ( $depth > $this->maxDepth ) {
			throw new DepthException();
		}

		foreach ( $this->variation( $board, $depth === 0 ) as $variation ) {
			$hash = BoardHasher::hash( $variation );
			if ( ! array_key_exists( $hash, $this->boards ) ) {
				$this->variationMetric->increase();

				try {
					// Callback will return when the board is solved.
					if ( call_user_func( $this->runCallback, $variation ) ) {
						return $variation;
					}
				} catch ( InvalidMoveException $e ) {
				}

				$this->boards[ $hash ] = $variation;
			}

			$variation = $this->boards[ $hash ];

			try {
				$test = $this->run( $variation, $depth + 1 );
				if ( null !== $test ) {
					return $test;
				}
			} catch ( DepthException $e ) {
			} catch ( InvalidMoveException $e ) {
			}
		}

		return null;
	}

	/**
	 * @param BoardInterface $board
	 *
	 * @param bool           $includeSource
	 *
	 * @return \Generator
	 */
	public function variation( BoardInterface $board, $includeSource = false ) {
		if ( $includeSource ) {
			yield $board;
		}

		$boardSize = $board->getSize();

		// Start with lowest number of options left.
		foreach ( range( 2, 9 ) as $optionCount ) {
			foreach ( range( 0, $boardSize - 1 ) as $x ) {
				foreach ( range( 0, $boardSize - 1 ) as $y ) {
					$coords = new Coords( $x, $y );

					$options = $board->get( $coords )->getOptions();
					if ( count( $options ) !== $optionCount ) {
						continue;
					}

					foreach ( $options as $option ) {
						$variation = clone $board;

						$cell = $variation->get( $coords )->set( $option );
						$variation->set( $coords, $cell );

						yield $variation;
					}
				}
			}
		}
	}

	/**
	 * @return int
	 */
	public function getMaxDepth() {
		return $this->maxDepth;
	}

	/**
	 * @param int $maxDepth
	 */
	public function setMaxDepth( $maxDepth ) {
		$this->maxDepth = $maxDepth;
	}

	/**
	 * @param callable $callback
	 */
	public function setRunCallback( $callback ) {
		$this->runCallback = $callback;
	}
}
