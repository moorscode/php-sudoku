<?php

namespace Sudoku;

use Sudoku\Algorithms\AlgorithmInterface;
use Sudoku\Collectors\CollectorInterface;
use Sudoku\Collectors\ColumnCollector;
use Sudoku\Collectors\RowCollector;

class Player {
	/** @var AlgorithmInterface[] Algorithms */
	protected $algorithms;

	/** @var int Number of algorithm calls */
	protected $algorithmCalls = 0;

	/**
	 * @param AlgorithmInterface $algorithm
	 */
	public function addAlgorithm( AlgorithmInterface $algorithm ) {
		$this->algorithms[] = $algorithm;
	}

	/**
	 * @param BoardInterface $board
	 *
	 * @return BoardInterface
	 */
	public function play( BoardInterface $board ) {
		do {
			$boardHash = BoardHasher::hash( $board );
			foreach ( $this->unfilled( $board ) as $coords ) {
				$this->applyAlgorithms( $board, $coords );
			}
		} while ( $boardHash !== BoardHasher::hash( $board ) );
	}

	/**
	 * @return int
	 */
	public function getAlgorithmCalls() {
		return $this->algorithmCalls;
	}

	/**
	 * @param BoardInterface $board
	 *
	 * @return \Generator
	 */
	protected function unfilled( BoardInterface $board ) {
		$boardSize = $board->getSize();
		$positions = range( 0, $boardSize - 1 );

		foreach ( $positions as $x ) {
			foreach ( $positions as $y ) {
				$coords = new Coords( $x, $y );
				if ( null === $board->get( $coords )->get() ) {
					yield $coords;
				}
			}
		}
	}

	/**
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 */
	protected function applyAlgorithms( BoardInterface $board, Coords $coords ) {
		foreach ( $this->algorithms as $algorithm ) {
			if ( $this->applyAlgorithm( $board, $coords, $algorithm ) ) {
				break;
			}
		}
	}

	/**
	 * @return CollectorInterface[] Collectors.
	 */
	protected function getCollectors() {
		return [
			new ColumnCollector(),
			new RowCollector(),
		];
	}

	/**
	 * @param array          $collectors
	 * @param BoardInterface $board
	 * @param Coords         $coords
	 */
	protected function runRelatedCells( array $collectors, BoardInterface $board, Coords $coords ) {
		$changed = $board->get( $coords );

		foreach ( $collectors as $collector ) {
			$relatedCoords = $collector->getCoords( $board, $coords );

			array_map( function ( $coords ) use ( $board, $changed ) {
				$cell = $board->get( $coords );
				$cell->removeOption( $changed->get() );
				if ( null === $cell->get() ) {
					$this->applyAlgorithms( $board, $coords );
				}
			}, $relatedCoords );
		}
	}

	/**
	 * @param BoardInterface     $board
	 * @param Coords             $coords
	 * @param AlgorithmInterface $algorithm
	 *
	 * @return bool
	 */
	protected function applyAlgorithm( BoardInterface $board, Coords $coords, AlgorithmInterface $algorithm ) {
		$this->algorithmCalls ++;

		// Run the algorithm on the cell.
		$cell = $algorithm->run( $board, $coords );

		// Update the cell on the board.
		$board->set( $coords, $cell );

		if ( null !== $cell->get() ) {
			$this->runRelatedCells( $this->getCollectors(), $board, $coords );

			return true;
		}

		return false;
	}
}
