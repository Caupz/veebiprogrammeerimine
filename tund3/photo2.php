<?php
	$firstName = "Caupo";
	$lastName = "Helvik";
	$dirToRead = "../../pics/*.jpg";
	$allFiles = glob($dirToRead);
	$rand = rand(0, max(array_keys($allFiles)));
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
			<h1>Photo2.php</h1>
			<?= $firstName ?> <?= $lastName ?>
			<div class="pictures">
				<img class="pic" src="<?= $allFiles[$rand] ?>" alt="mingi pilt <?= $rand ?>" />
			</div>
		</p>
	</body>
</html> 