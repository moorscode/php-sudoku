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
$final = $sudoko->play();

if ( $final instanceof BoardHistoryInterface ) {
	$decorator->showHistory( $final );
} else {
	$decorator->decorate( $final );
}

$decorator->toes();
