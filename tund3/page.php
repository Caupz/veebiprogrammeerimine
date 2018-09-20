<?php
	$firstName = "Tundmatu";
	$lastName = "Kodanik";
	$birthyear = 1999;
	$month = intval(date('m'));
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
					<select name="birthMonth">
						<option <?= $month == 1 ? 'selected':'' ?> value="1">jaanuar</option>
						<option <?= $month == 2 ? 'selected':'' ?> value="2">veebruar</option>
						<option <?= $month == 3 ? 'selected':'' ?> value="3">märts</option>
						<option <?= $month == 4 ? 'selected':'' ?> value="4">aprill</option>
						<option <?= $month == 5 ? 'selected':'' ?> value="5">mai</option>
						<option <?= $month == 6 ? 'selected':'' ?> value="6">juuni</option>
						<option <?= $month == 7 ? 'selected':'' ?> value="7">juuli</option>
						<option <?= $month == 8 ? 'selected':'' ?> value="8">august</option>
						<option <?= $month == 9 ? 'selected':'' ?> value="9">september</option>
						<option <?= $month == 10 ? 'selected':'' ?> value="10">oktoober</option>
						<option <?= $month == 11 ? 'selected':'' ?> value="11">november</option>
						<option <?= $month == 12 ? 'selected':'' ?> value="12">detsember</option>
					</select><br>
					
					<input type="submit" name="submitUserData" value="Saada andmed" />
				</div>
			</form>
			
			<?php if(isset($_POST['birthyear'])): ?>
			<hr>
			<h1>Olete survivinud järgnevatel aastatel: </h1>
			<ol>
					<?php for($i = $_POST['birthyear']; $i <= date('Y'); $i++): ?>
						<li><?= $i ?></li>
					<?php endfor; ?>
			</ol>
			<?php endif; ?>
		</p>
	</body>
</html> 