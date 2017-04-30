<?php

namespace Sudoku;

require dirname( __DIR__ ) . 'vendor/autoload.php';

error_reporting( -1 );
ini_set( 'display_errors', 'on' );

$loader = new Loader();

$board = new Board( $loader->load( '9-1') );

new App( $board );
