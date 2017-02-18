<?php
$pageTitle = "Dela med dig";

include "inc/header.php";
include "logincheck.php";

?>
<main class="container">
	<div class="content">
		<h1>Dela dina upplevelser</h1>
	</div>
	<div class="wrapper">
		<div class="form">
			<h3>Bli medlem idag och börja dela med dig.</h3>
			<?php echo $registerSuccess; ?>	
			<form method="post" action="index.php">
				<label for="firstname">Förnamn:</label>
				<?php echo $nameErr; ?>
				<input type="text" name="firstname" placeholder="Förnamn">
				<label for="lastname">Efternamn:</label>
				<?php echo $lastErr; ?>
				<input type="text" name="lastname" placeholder="Efternamn">
				<label for="mail">E-post:</label>
				<?php echo $emailErr; ?>
				<input type="email" name="mail" placeholder="E-post">
				<label for="username">Användarnamn:</label>
				<?php echo $userErr; ?>
				<input type="text" name="username" placeholder="Användarnamn">
				<label for="password">Lösenord:</label>
				<?php echo $passErr; ?>
				<input type="password" name="password" placeholder="Lösenord">
				<input type="submit" value="Bli medlem" name="register">
			</form>
		</div>
		<div class="form">
			<h3>Redan medlem? Logga in nedan</h3>
			<form method="post" action="logincheck.php">
				<label for="user">Användarnamn:</label>
				<input type="text" name="user" placeholder="Användarnamn">
				<label for="pass">Lösenord:</label>
				<input type="password" name="pass" placeholder="Lösenord">
				<input type="submit" value="Logga in" name="login">
			</form>
		</div>
	</div>
</main>
</body>
</html>