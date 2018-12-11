<?php
$currentDir = __DIR__;

$page = 0;
if(isset($_GET['page']) && $_GET['page'] > 0) $page = $_GET['page'];

require("/home/cauphel/functions.php");

if(isset($_GET['logout'])) {
    $_SESSION = null;
    session_destroy();
}

if(!isset($_SESSION['id'])) {
    header("Location: index2.php");
    exit();
}
$users = getUserdatas();
$imageRatings = getAverageImageRatings();
$title = "Galerii";
require("../views/header.php");

imageUpload(600, 400);
?>

<h1><?= $title ?></h1>

<div id="modal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImg" alt="" />
    <div id="caption"></div>
    <div id="rating" class="caption">
        <?php for($i = 1; $i <= 5; $i++): ?>
            <label><input type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>"><?= $i ?></label>
        <?php endfor; ?>
        <input type="button" value="Salvesta hinnang" id="store-rating">
        <span id="average-rating"></span>
    </div>
</div>

<div id="gallery" class="gallery">
    <?php $pics = getPictures($page, 5); ?>
    <?php foreach($pics as $pic): ?>
        <div class="img">
            <img src="http://greeny.cs.tlu.ee/~cauphel/uploads/<?= $pic['filename'].'_thumbnail.'.$pic['extension'] ?>" alt="<?= $pic['alt'] ?>" data-id="<?= $pic['id'] ?>" data-src="<?= $pic['filename'].'.'.$pic['extension'] ?>" />
            <div>
                <?php if(array_key_exists($pic['user_id'], $users)): ?>
                    <?= $users[$pic['user_id']]['firstname'] ?> <?= $users[$pic['user_id']]['lastname'] ?>
                <?php endif; ?>
            </div>
            <div id="score-<?= $pic['id'] ?>">
                <?php if(array_key_exists($pic['id'], $imageRatings)): ?>
                    Hinne:   <?= $imageRatings[$pic['id']]['avg'] ?>
                <?php else: ?>
                    Hinne: puudub
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
<hr>
<ul>
    <li><a href="?logout=1">Logi välja</a></li>
</ul>


<?php require("../views/footer.php"); ?>
