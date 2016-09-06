<?php

list($color1, $color2, $color3) = ['green', 'yellow', 'blue'];
var_dump($color1, $color2, $color3);

list($colors[], $colors[], $colors[]) = ['green', 'yellow', 'blue'];
var_dump($colors);


//Output of the preceding code in PHP 5 would result in following.
//string(5) "green" 
//string(6) "yellow" 
//string(4) "blue"
//
//array(3) {
//    [0]=> string(5) "blue" 
//	[1]=> string(6) "yellow" 
//	[2]=> string(4) "green" 
//}
//Output of the preceding code in PHP 7 would result in following.
//string(5) "green" 
//string(6) "yellow" 
//string(4) "blue"
//
//
//array(3) {
//    [0]=> string(5) "green" 
//	[1]=> string(6) "yellow" 
//	[2]=> string(4) "blue" 
//}
