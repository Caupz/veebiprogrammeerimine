<?php
	$firstName = "Tundmatu";
	$lastName = "Kodanik";
	$birthyear = 1999;
	$month = intval(date('m'));
	
	$firstName = escapePostData('firstname');
	$lastName = escapePostData('lastname');
	$birthyear = escapePostData('birthyear');
	$birthMonth = escapePostData('birthMonth');
	
	function escapePostData($index) {
		$str = '';
		if(isset($_POST[$index])) {
			$str = $_POST[$index];
			$str = trim($str);
			$str = stripslashes($str);
			$str = htmlspecialchars($str);
		}
		return $str;
	}

	$months = [
		'et' => [
			1 => 'Jaanuar',
			2 => 'Veebruar',
			3 => 'Märts',
			4 => 'Aprill',
			5 => 'Mai',
			6 => 'Juuni',
			7 => 'Juuli',
			8 => 'August',
			9 => 'September',
			10 => 'Oktoober',
			11 => 'November',
			12 => 'Detsember',
		]
	];
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
			<?= $firstName ?> <?= $lastName ?> <?= $birthyear ?> <?= $month ?>
			
			<hr>
			<form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
				<div class="pictures">
					<label for="firstname">Eesnimi:</label><br>
					<input type="text" name="firstname" /><br>
					<label for="lastname">Perenimi</label><br>
					<input type="text" name="lastname" /><br>
					<label for="year">Sünniaasta</label><br>
					<input type="number" min="1914" max="2000"  value="1999" name="birthyear" /><br>
					<select name="birthMonth">
						<?php foreach($months['et'] as $key => $m): ?>
							<option <?= $month == $key ? 'selected':'' ?> value="<?= $key ?>"><?= $m ?></option>
						<?php endforeach; ?>
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