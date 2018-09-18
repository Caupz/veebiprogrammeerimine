<?php
	$firstName = "Tundmatu";
	$lastName = "Kodanik";
	$birthyear = 1999;
	
	if(isset($_POST['firstname'])) $firstName = $_POST['firstname'];
	if(isset($_POST['lastname'])) $lastName = $_POST['lastname'];
	if(isset($_POST['birthyear'])) $birthyear = $_POST['birthyear'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>IF18 praktikum</title>
		<link rel="stylesheet" href="http://greeny.cs.tlu.ee/~cauphel/site.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet"> 
	</head>

	<body>
		<p>
			<h1>Page.php</h1>
			<?= $firstName ?> <?= $lastName ?> <?= $birthyear ?>
			
			<hr>
			<form method="POST">
				<div class="pictures">
					<label for="firstname">Eesnimi:</label><br>
					<input type="text" name="firstname" /><br>
					<label for="lastname">Perenimi</label><br>
					<input type="text" name="lastname" /><br>
					<label for="year">Sünniaasta</label><br>
					<input type="number" min="1914" max="2000"  value="1999" name="birthyear" /><br>
					
					<input type="submit" name="submitUserData" value="Saada andmed" />
				</div>
			</form>
			
			<hr>
			<h1>Olete survivinud järgnevatel aastatel: </h1>
			<ol>
				<?php if($_POST['birthyear']): ?>
					<?php for($i = $_POST['birthyear']; $i <= date('Y'); $i++): ?>
						<li><?= $i ?></li>
					<?php endfor; ?>
				<?php endif; ?>
			</ol>
		</p>
	</body>
</html> 