<?php
	$firstName = "Caupo";
	$lastName = "Helvik";
	$date = date("d.m.Y");
	$hourNow = date("G");
	$weekdayToday = date("N");
	$monthNumber = intval(date("m"));
	$partOfDay = "";
	
	if($hourNow < 8) $partOfDay = "Varajane hommik";
	elseif($hourNow >= 8 && $hourNow < 16) $partOfDay = "Lõuna";
	elseif($hourNow >= 16) $partOfDay = "Õhtupoolik";
	
	$picUrl = 'http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_';
	$memePicUrl = '../../meme';
	$picIndex = mt_rand(2,43);
	$memeIndex = mt_rand(1,3);
	$picExt = '.jpg';
	$picDir = $picUrl.$picIndex.$picExt;
	$memePicDir = $memePicUrl.$memeIndex.$picExt;
	
	$months = [
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
	];
	
	$weekdays = [
		'et' => [
			1 => 'Esmaspäev',
			2 => 'Teisipäev',
			3 => 'Kolmapäev',
			4 => 'Neljapäev',
			5 => 'Reede',
			6 => 'Laupäev',
			7 => 'Pühapäev',
		],
		'en' => [
			1 => 'Monday',
			2 => 'Tuesday',
			3 => 'Wednesday',
			4 => 'Thursday',
			5 => 'Friday',
			6 => 'Saturday',
			7 => 'Sunday',
		],
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
		<h1>asdasda</h1>
		<div class="center">
		
			<p>
				<?= 'Tere tulemast: '.$firstName.' '.$lastName ?><br>
				Tänane kuupäev on: <strong><?= $date ?></strong><br>
				Tänane nädalapäev on: <strong><?= $weekdays['et'][$weekdayToday] ?></strong><br>
				Hetkene kuu: <strong><?= $months[$monthNumber] ?></strong><br>
				Lehe avanemise hetkel oli: <strong><?= $partOfDay ?> | <?= date('H:i:s') ?></strong>
			</p>
			<p>
				Teised lehed<br>
				<a href="photo.php">photo.php</a>
				<a href="page.php">page.php</a>
			</p>
		
			<div class="pictures">
				<img class="pic" src="../../asd.jpg" alt="asd">
				<img class="pic" src="../../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="Happy 911">
				<img class="pic" src="<?= $picDir ?>" alt="Yay">
				<img class="pic" src="<?= $memePicDir ?>" alt="Yay">
			</div>
			<p>Siin on minu <a target="_blank" href="http://tlu.ee">TLÜ</a> õppetöö</p>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			
			<div class="btn-container">
				<a class="btn btn-right" target="_blank" href="../../../../~robiran/">Paremal Robin teeb ka veebi ></a>
				<a class="btn btn-left" target="_blank" href="../../../../~danilat/">< Vasakul Daniil teeb ka veebi</a>
			</div>
		</div>
	</body>
</html> 