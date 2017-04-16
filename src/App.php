<?php

namespace Sudoku;

use Sudoku\Algorithms\AlgorithmInterface;
use Sudoku\Algorithms\DetermineColumnCandidates;
use Sudoku\Algorithms\DetermineGroupCandidates;
use Sudoku\Algorithms\DetermineRowCandidates;
use Sudoku\Algorithms\SoleCandidate;
use Sudoku\Algorithms\SoleGroupCandidate;
use Sudoku\Algorithms\SoleRowCandidate;
use Sudoku\Algorithms\SoleColumnCandidate;

class App {
	/** @var Board Board */
	protected $board;
	/** @var AlgorithmInterface[] Algorithms */
	protected $algorithms;

	public function __construct( $boardSize = 9, array $known = array() ) {
		$decorator = new HTMLDecorator();

		$this->board = new Board( $boardSize, $known );

		$decorator->decorate( $this->board, false );

		$this->addAlgorithm( new DetermineRowCandidates() );
		$this->addAlgorithm( new DetermineColumnCandidates() );
		$this->addAlgorithm( new DetermineGroupCandidates() );

		$this->addAlgorithm( new SoleCandidate() );
		$this->addAlgorithm( new SoleRowCandidate() );
		$this->addAlgorithm( new SoleColumnCandidate() );
		$this->addAlgorithm( new SoleGroupCandidate() );

		do {
			$oldBoard = BoardHasher::hash( $this->board );
			$this->run();
		} while ( $oldBoard !== BoardHasher::hash( $this->board ) );


		$decorator->decorate( $this->board );
	}

	/**
	 *
	 */
	protected function run() {
		foreach ( $this->board->unfilled() as $coords ) {
			array_map( function ( $algorithm ) use ( $coords ) {
				$cell = $algorithm->run( $coords );
				$this->board->set( $coords, $cell );
			}, $this->algorithms );
		}
	}

	/**
	 * @param AlgorithmInterface $algorithm
	 */
	protected function addAlgorithm( AlgorithmInterface $algorithm ) {
		$algorithm->setBoard( $this->board );
		$this->algorithms[] = $algorithm;
	}
}
