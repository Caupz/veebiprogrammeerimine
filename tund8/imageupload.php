<?php
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

imageUpload();
?>

<h1><?= $title ?></h1>

<div class="form-block">
    <form action="imageupload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</div>

<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
<hr>
<ul>
    <li><a href="?logout=1">Logi välja</a></li>
</ul>

<?= getDirectoryFiles(__DIR__) ?>
<?php require("../views/footer.php"); ?>
