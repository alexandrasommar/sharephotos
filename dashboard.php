<?php 
session_start();
$pageTitle = "Välkommen";
include "inc/header.php";
require_once "inc/dbconnect.php";
?>

<main class="container">
	<div class="logout">
		<a href="logout.php">Logga ut</a>
	</div>
	<div class="content">
		<h1>Dela dina upplevelser</h1>
	</div>	

	<div class="wrapper">
		<div class="photo">
			<?php 
			
			if(!isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] != true) {
				header("Location: index.php");
				
			} else {
				
				$username = $_SESSION["currentuser"];

				$query = "SELECT * FROM users WHERE username = '{$username}'";
				$stmt = $conn->stmt_init();
				if($stmt->prepare($query)) {
					$stmt->execute();
					$stmt->bind_result($id, $fi, $la, $em, $username, $password, $userpic);
					$stmt->fetch();

					$_SESSION["logged_in"] = true;
					$_SESSION["photo"] = $userpic;

					?>
					<h3>Välkommen <?php echo $_SESSION["currentuser"]; ?>!</h3>
					
					<?php
					if ($userpic == "") {
						echo "Tyvärr har du ingen profilbild än."; 
					} else { 
						echo "<img src='" . $userpic . "'alt='Profilbild på " . $_SESSION["currentuser"] . "'>"; 
					}
				}
			}

			?>
		</div>
		<div class="form">
			<h3>Välkommen att börja dela med dig, eller byt din nuvarande bild</h3>
			<form method="post" enctype="multipart/form-data" action="dashboard.php">
			
				<p>Ditt foto:</p>
				<input type="file" name="photo">
				<input type="submit" name="upload" value="Ladda upp">
			</form>
			<?php

			/** If the user pressed upload, this block of code checks image file size 
			*	and that it is jpg.
			* 	If everything is correct, move the file to the uploads directory
			*	and rename the file to username.jpg. Refresh the page and display
			*	the new image. If something went wrong, display an error message.
			**/

			if(isset($_POST["upload"])) {

				$userid = $_SESSION["currentuser"];
				$target_folder = "uploads/";
				$target_name = $target_folder . basename($userid . ".jpg");

				if($_FILES["photo"]["size"] > (1024000)) {
					
					echo "Filen är för stor, max-storleken är 1 MB";
					exit;
				} 

				if ($_FILES["photo"]["type"] !== "image/jpeg") { 
					echo "Endast jpg-filer är tillåtna"; 
					exit;
				}	
				
				if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_name)) {
					
					$query = "UPDATE users SET userpic_url = '{$target_name}' WHERE username = '{$userid}'";

					$stmt = $conn->stmt_init();

					if ($stmt->prepare($query)) {
						$stmt->execute();
						
						$_SESSION["photo"] = $target_name;
						header("Refresh: 0; url=dashboard.php");

					} else {
						echo mysqli_error();
					}

				} else {
					echo "Ett fel har uppstått";
				
				}
				$stmt->close();
				$conn->close();
			}
			?>
		</div>	
	</div>
</main>
</body>
</html>