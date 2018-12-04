<?php
require('../../../functions.php');

    $notice = null;
    $notice = "";
    $message = "";

    if(isset($_POST['submitMessage'])) {
        if($_POST['comment'] != 'Kirjuta sõnum siia...' && !empty($_POST['comment'])) {
            $message = escapePostData('comment');
            $notice = insertInto('comment', ['comment' => $message]);
        } else {
            $message = "Palun sisesta sõnum.";
        }
    }



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
			<h1>Addmsg.php</h1>
			<hr>
			<form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
				<div class="pictures">
                    <label for="name">Nimi:</label><br>
                    <input type="text" name="name" /><br>

                    <label for="comment">Kommentaar (max 256 märki):</label><br>
                    <textarea type="text" name="comment" rows="4" cols="64" placeholder="Kirjuta sõnum siia...">Kirjuta sõnum siia...</textarea>><br>

					<input type="submit" name="submitMessage" value="Saada sõnum" />
				</div>
            </form>
            <hr>
            <p>
                <?= $notice ?>
            </p>
		</p>
	</body>
</html> 