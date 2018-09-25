<?php
require('functions.php');
    $comments = getAllComments();
    $notice = "";

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
			<h1>Readmsg.php</h1>
            <p>
                <?php foreach($comments as $comment): ?>
                    <p><?= $comment ?></p>
                <?php endforeach; ?>
            </p>
            <hr>
            <p>
                <?= $notice ?>
            </p>
		</p>
	</body>
</html> 