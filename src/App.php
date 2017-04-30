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

class App {
	public function __construct( Board $board ) {
		$decorator = new HTMLDecorator();
		$player    = new Player();
		$validator = new Validator();

		$player->addAlgorithm( new DetermineColumnCandidates() );
		$player->addAlgorithm( new DetermineRowCandidates() );
		$player->addAlgorithm( new DetermineGroupCandidates() );

		$player->addAlgorithm( new SoleCandidate() );
		$player->addAlgorithm( new SoleGroupCandidate() );
		$player->addAlgorithm( new SoleRowCandidate() );
		$player->addAlgorithm( new SoleColumnCandidate() );

		$player->addAlgorithm( new PairGroupCandidates() );

		$decorator->decorate( $board, false );

		$start = microtime( true );

		$variations = 0;
		if ( ! $this->run( $player, $board, $validator ) ) {
			$boardVariations = new BoardVariations( $board );
			foreach ( $boardVariations->next() as $variation ) {
				$variations ++;

				if ( $this->run( $player, $variation, $validator ) ) {
					$board = $variation;
					break;
				}
			}
		}

		printf( '<p>Algorithm calls: %d<br/>Time (after %d variations): %fms</p>', $player->getAlgorithmCalls(), $variations, microtime( true ) - $start );

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
	protected function run( Player $player, Board $board, Validator $validator ) {
		$player->play( $board );

		return $validator->validate( $board );
	}
}
