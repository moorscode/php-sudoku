<?php

namespace Sudoku;

require dirname( __DIR__ ) . '/vendor/autoload.php';

error_reporting( E_ALL );
ini_set( 'display_errors', 'on' );
ini_set( 'memory_limit', '-1' );

$loader = new Loader();
$board = new Board( $loader->load( '9-4') );

$sudoko = new Sudoku( $board );
$sudoko->play();
