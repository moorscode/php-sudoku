<?php

namespace Sudoku;

require dirname( __DIR__ ) . '/vendor/autoload.php';

error_reporting( E_ALL );
ini_set( 'display_errors', 'on' );
ini_set( 'memory_limit', '-1' );

define( 'SUDOKU_ROOT', dirname( __DIR__ ) );

$loader = new Loader();
$board  = new Board( $loader->load( filter_input( INPUT_GET, 'game', FILTER_SANITIZE_STRING ) ) );
$board  = new BoardHistory( $board );

$decorator = new HTMLDecorator();
$decorator->head();
$decorator->decorate( $board, false );

$sudoko = new Sudoku( $board );

/** @var BoardHistory $final */
$final = $sudoko->play();

$final->rewind();
$final->getHistorySteps();

// Toggle showing solution or not.
echo '<div style="height: 3em; overflow: hidden; cursor: pointer;" onclick="this.style.height = this.style.height === \'auto\' ? \'3em\' : \'auto\';">';
echo '<p>Show solution.</p>';

foreach ( range( 0, $final->getHistorySteps() - 1 ) as $step ) {
	$final->historyStep();
	$decorator->decorate( $final, false, [ $final->lastCell()->coords ] );
}

echo '</div>';

$decorator->toes();
