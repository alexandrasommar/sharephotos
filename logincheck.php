<?php
$pageTitle = "Logga in";
include "inc/header.php";
require_once "inc/dbconnect.php"; 
 ?>

<main class="container">
	<div class="content">
<?php

/**
*	If the user pressed register, this block of code checks if all 
*	fields are filled out.
*
*	If one of the fields are empty, an error message will be displayed
*	on the index.php-page.
**/


$nameErr = $lastErr = $emailErr = $userErr = $passErr = "";

if (isset($_POST["register"])) {
		
	if (empty($_POST["firstname"])) {
			$nameErr = "<p class='error'>Du måste fylla i förnamn</p>";
	}

	if (empty($_POST["lastname"])) {
		$lastErr = "<p class='error'>Du måste fylla i efternamn</p>";
	}
	if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
		$emailErr = "<p class='error'>Du måste fylla i en giltig epostadress</p>";
	}

	if (empty($_POST["username"])) {
		$userErr = "<p class='error'>Du måste fylla i ett användarnamn</p>";
	}

	if (empty($_POST["password"])) {
		$passErr = "<p class='error'>Du måste fylla i ett lösenord</p>";
	} 

} 


/**
*	This block of code executes if all fields are filled out 
*	correctly. Then the user is inserted into the database.
**/

$registerSuccess = ""; //message that is displayed if the registration is successfull

if (isset($_POST["register"])) {
	if (!empty($_POST["firstname"]) 
		&& !empty($_POST["lastname"]) 
		&& !empty($_POST["mail"]) 
		&& !empty($_POST["username"]) 
		&& !empty($_POST["password"])) {
		
		$fi = strip_tags($_POST["firstname"]);
		$la = strip_tags($_POST["lastname"]);
		$ma = strip_tags($_POST["mail"]);
		$un = strip_tags($_POST["username"]);
		$up = strip_tags($_POST["password"]);

		$up = password_hash($up, PASSWORD_DEFAULT); //hashes the user password

		$query = "INSERT INTO users 
		VALUES (NULL, '$fi', '$la', '$ma', '$un', '$up', NULL)";
		mysqli_query($conn, $query);
		$registerSuccess = "<p class='register'>Användaren är registrerad. Nu kan du logga in!</p><br>";	

	}  
}

/*	If the user pressed log in, this block of code checks
*	if username and password are set, then cleans them
*	from tags. Then the password is checked against the
* 	hashed password. If everything is correct, the user
* 	is redirected to the dashboard.php-age. Else an error
* 	message is displayed.
*/	

if(isset($_POST["login"])) {
	
	if (!empty($_POST["user"]) && !empty($_POST["pass"])) {
		
		$user = mysqli_real_escape_string($conn, $_POST["user"]);
		$pass = mysqli_real_escape_string($conn, $_POST["pass"]);

		$stmt = $mysqli->stmt_init();
		$query = "SELECT * FROM users WHERE username = '{$user}'";
		
		if($stmt->prepare($query)) {
			$stmt->execute();

			$stmt->bind_result($userid, $fi, $la, $em, $un, $up, $pic);

			$stmt->fetch();
			
			if($userid != 0 && password_verify($pass, $up)) {
				setcookie("username", $un, time() + (2500));
				session_start();
				$_SESSION["currentuser"] = $_POST["user"];
				$username = $_SESSION["currentuser"];
				$_SESSION["logged_in"] = true;
				header("Location: dashboard.php");
			} 
		} 
		$stmt->close();
		$conn->close();
		} 
		echo "Du har angivit fel användarnamn eller lösenord. Gå tillbaka till " . "<a href='index.php'>startsidan</a>";
	
}

?>

	</div>
</main>
</body>
</html>