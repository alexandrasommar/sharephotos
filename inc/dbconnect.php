<?php

//define connection specifications
define("DB_HOST", "dynweb-inl2-219661.mysql.binero.se");
define("DB_USER", "219661_yb12410");
define("DB_PASS", "bukefalos4547");
define("DB_NAME", "219661-dynweb-inl2");

//make a variable that can be used throughout the pages
$conn = mysqli_connect("dynweb-inl2-219661.mysql.binero.se", "219661_yb12410", "bukefalos4547", "219661-dynweb-inl2");

//connect to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($mysqli->connect_errno) {
	echo "fail";
}

?>