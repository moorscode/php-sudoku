<?php

namespace Sudoku;

require '../vendor/autoload.php';

// determine board specifications
// get known values

// find by lines
// find by box
// find by blocked lines in other boxes

// every time a number is found, just continue the cycle

// when nothing was found in the last cycle stop; everything should be filled

$known = [
	[ 1, 0, 6, 3, 0, 0, 0, 0, 2 ],
	[ 3, 5, 0, 1, 0, 2, 0, 4, 6 ],
	[ 2, 0, 4, 0, 9, 0, 3, 0, 0 ],
	[ 0, 1, 0, 0, 0, 3, 0, 2, 0 ],
	[ 5, 0, 0, 0, 0, 0, 0, 0, 8 ],
	[ 0, 3, 0, 7, 0, 0, 0, 5, 0 ],
	[ 0, 0, 3, 0, 5, 0, 2, 0, 4 ],
	[ 4, 6, 0, 2, 0, 9, 0, 8, 7 ],
	[ 8, 0, 0, 0, 0, 7, 1, 0, 3 ],
];

new App( 9, $known );
