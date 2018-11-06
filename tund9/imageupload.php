<?php
$currentDir = __DIR__;

require("/home/cauphel/functions.php");

if(isset($_GET['logout'])) {
    $_SESSION = null;
    session_destroy();
}

if(!isset($_SESSION['id'])) {
    header("Location: index2.php");
    exit();
}
$title = "Piltide üleslaadimine";
require("../views/header.php");

imageUpload(600, 400);
?>

<h1><?= $title ?></h1>

<div class="form-block">
    <form action="imageupload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br><br>
        <label>Pildi kirjeldus</label><br>
        <input type="text" name="alt"><br>
        <br>
        <label>Kasutusõigus</label><br>
        <input id="imagePrivacyPublic" type="radio" name="privacy" value="1"><label for="imagePrivacyPublic">Avalik</label><br>
        <input id="imagePrivacyLoggedIn" type="radio" name="privacy" value="2"><label for="imagePrivacyLoggedIn">Sisseloginud kasutajad</label><br>
        <input id="imagePrivacyPrivate" type="radio" name="privacy" value="3" checked><label for="imagePrivacyPrivate">Privaatne</label><br>
        <br>

        <input type="submit" value="Upload Image" name="submit">
    </form>
</div>

<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
<hr>
<ul>
    <li><a href="?logout=1">Logi välja</a></li>
</ul>


<?php require("../views/footer.php"); ?>
