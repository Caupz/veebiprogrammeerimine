<?php
	$firstName = "Caupo";
	$lastName = "Helvik";
	$dirToRead = "../../pics/*.jpg";
	$allFiles = glob($dirToRead);
	//var_dump($allFiles);
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
			<h1>Photo.php</h1>
			<?= $firstName ?> <?= $lastName ?>
			<div class="pictures">
			<?php foreach($allFiles as $key => $file): ?>
				<img class="pic" src="<?= $file ?>" alt="mingi pilt <?= $key ?>" />
			<?php endforeach;?>
			</div>
		</p>
	</body>
</html> 