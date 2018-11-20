<?php
require("../../router.php");

if(!isLoggedIn()) goHome();
if(!isset($_SESSION['description'])) $_SESSION['description'] = "";
if(!isset($_SESSION['bg_color'])) $_SESSION['bg_color'] = "#FFFFFF";
if(!isset($_SESSION['txt_color'])) $_SESSION['txt_color'] = "#000000";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kasutaja profiil</title>
    <link rel="stylesheet" href="http://greeny.cs.tlu.ee/~cauphel/site.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
</head>
<body>

<div class="center">
<form method="POST" action="../../router.php?action=userProfileSave" enctype="multipart/form-data">

    <h1>Profiil: <?= getUserFullname() ?></h1>
    <?php $avatar = getUserAvatar(); ?>
    <?php if(isset($avatar[1]) && isset($avatar[1]['filename'])): ?>
        <img src="../../uploads/<?= $avatar[1]['filename'].'.'.$avatar[1]['extension'] ?>" alt="Kasutaja profiil" />
    <?php elseif(isset($avatar[0]) && isset($avatar[0]['url'])): ?>
        <img src="<?= $avatar[0]['url'] ?>" alt="Kasutaja profiil"/>
    <?php endif; ?>


    <label>Kirjeldus:</label>
    <textarea rows="10" cols="80" name="description"><?= $_SESSION['description']; ?></textarea><br>
    <label>Taustavärv:</label>
    <input name="bg_color" type="color" value="<?= $_SESSION['bg_color']; ?>"><br>
    <label>Tekstivärv:</label>
    <input name="txt_color" type="color" value="<?= $_SESSION['txt_color']; ?>"><br>
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <input name="submit" type="submit" value="Salvesta profiil"><br>
</form>
</div>

<style>
    body {
        background: <?= getProfileData('bg_color') ?>;
        color: <?= getProfileData('txt_color') ?>;
    }
</style>

</body>
</html>