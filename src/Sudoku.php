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
	 * @param BoardInterface           $board
	 * @param StatisticsInterface|null $statistics
	 */
	public function __construct( BoardInterface $board, StatisticsInterface $statistics = null ) {
		$this->statistics = $statistics ?: new NullStatistics();

		$this->board      = $board;
		$this->player     = new Player( $this->statistics );
		$this->variations = new Variations( $this->statistics );
		$this->variations->setRunCallback( [ $this, 'run' ] );

		$this->validator  = new Validator();

		$this->player->addAlgorithm( new DetermineRowCandidates() );
		$this->player->addAlgorithm( new DetermineColumnCandidates() );
		$this->player->addAlgorithm( new DetermineGroupCandidates() );

		$this->player->addAlgorithm( new SoleCandidate() );
		$this->player->addAlgorithm( new SoleRowCandidate() );
		$this->player->addAlgorithm( new SoleGroupCandidate() );
		$this->player->addAlgorithm( new SoleColumnCandidate() );

		$this->player->addAlgorithm( new PairGroupCandidates() );
	}

	/**
	 * Play the game
	 *
	 * @return BoardInterface
	 */
	public function play() {
		$board = clone $this->board;

		$results = new Result( $this->board );
//		$saved   = $results->load();
		$saved = null;

		if ( ! $saved ) {
			$start = microtime( true );

			foreach ( [ 0, 1, 3, 10, 15 ] as $maxDepth ) {
				$this->variations->setMaxDepth( $maxDepth );

				try {
					$result = $this->variations->run( $board );
				} catch ( \Exception $e ) {
					$result = null;
				}

				if ( $result instanceof BoardInterface ) {
					$board = $result;
					break;
				}
			}

			$end = microtime( true );

			if ( ! $this->validator->validate( $board ) ) {
				return $this->board;
			}

			$results->save( $board );

			$this->statistics->register( 'time', 'Time: %fs' );
			$this->statistics->set( 'time', $end - $start );

			$this->statistics->display();
		} else {
			$board = $saved;
		}

		echo '<p>Solution has been found!</p>';

		return $board;
	}

	/**
	 * @param BoardInterface $board
	 *
	 * @return bool
	 */
	public function run( BoardInterface $board ) {
		$this->player->play( $board );

		return $this->validator->validate( $board );
	}
}
