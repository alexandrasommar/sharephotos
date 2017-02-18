<?php
session_start();

// this unsets the session and destroys the cookie
$_SESSION["logged_in"] = false;
unset($_SESSION["currentuser"]);
unset($_SESSION["photo"]);

setcookie("username", $un, time() - (2500));
session_destroy();

//redirect the user to the start page
header("Location: index.php?logout=true");
?>