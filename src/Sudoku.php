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
use Sudoku\Validators\Validator;

class Sudoku {
	/** @var Board */
	protected $board;
	/** @var Player */
	protected $player;
	/** @var Validator */
	protected $validator;
	/** @var Variations */
	protected $variations;

	/**
	 * Sudoku constructor.
	 *
	 * @param Board $board
	 */
	public function __construct( Board $board ) {
		$this->board      = $board;
		$this->player     = new Player();
		$this->validator  = new Validator();
		$this->variations = new Variations();
		$this->variations->setRunCallback( [ $this, 'run' ] );

		$this->player->addAlgorithm( new DetermineColumnCandidates() );
		$this->player->addAlgorithm( new DetermineRowCandidates() );
		$this->player->addAlgorithm( new DetermineGroupCandidates() );

		$this->player->addAlgorithm( new SoleCandidate() );
		$this->player->addAlgorithm( new SoleRowCandidate() );
		$this->player->addAlgorithm( new SoleGroupCandidate() );
		$this->player->addAlgorithm( new SoleColumnCandidate() );

		$this->player->addAlgorithm( new PairGroupCandidates() );
	}

	/**
	 * Play the game
	 */
	public function play() {
		$board = $this->board;

		$decorator = new HTMLDecorator();
		$decorator->decorate( $board, false );

		$start = microtime( true );

		foreach ( [ 0, 1, 3, 10, 15 ] as $maxDepth ) {
			$this->variations->setMaxDepth( $maxDepth );

			$result = $this->variations->run( $board );
			if ( $result ) {
				$board = $result;
				break;
			}
		}

		$end = microtime( true );

		printf(
			'<p>Algorithm calls: %s<br/>Time (after %d variations): %fs</p>',
			number_format( $this->player->getAlgorithmCalls() ),
			$this->variations->getVariationCount(),
			$end - $start
		);

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
	public function run( Board $board ) {
		$this->player->play( $board );

		return $this->validator->validate( $board );
	}
}
