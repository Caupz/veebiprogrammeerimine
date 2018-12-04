<?php
require("/home/cauphel/functions.php");
$notice = "";
$email = "";
$emailError = "";
$passwordError = "";
$page = 0;
if(isset($_GET['page']) && $_GET['page'] > 0) $page = $_GET['page'];

if(isset($_POST["login"])){
    if (isset($_POST["email"]) and !empty($_POST["email"])){
        $email = escapePostData("email");
    } else {
        $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
    }

    if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
        $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
    }

    if(empty($emailError) and empty($passwordError)){
        $notice = signin($email, $_POST["password"]);
    } else {
        $notice = "Ei saa sisse logida!";
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Katseline veeb</title>
    <link rel="stylesheet" href="http://greeny.cs.tlu.ee/~cauphel/site.css?v=1">
    <script type="text/javascript" src="http://greeny.cs.tlu.ee/~cauphel/main.js?v=1" defer></script>
</head>
<body>
<h1>Teretulemast</h1>
<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
<hr>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>E-mail (kasutajatunnus):</label><br>
    <input type="email" name="email" value="<?php echo $email; ?>">&nbsp;<span><?php echo $emailError; ?></span><br>

    <label>Salasõna:</label><br>
    <input name="password" type="password">&nbsp;<span><?php echo $passwordError; ?></span><br>

    <input name="login" type="submit" value="Logi sisse">&nbsp;<span><?php echo $notice; ?>
</form>
<p><a href="newuser.php">Loo kasutaja</a>!</p>
<hr>
<p><a href="addmsg.php">Lisa sõnum</a>!</p>
<hr>
<div>
    <p>Kinnitatud sõnumid:</p>
    <ul>
        <?php $comments = getAllValidatedComments(); ?>
        <?php foreach($comments as $comment): ?>
            <li><?= $comment['comment'] ?> | <?= $comment['created_at'] ?></li>
        <?php endforeach; ?>
    </ul>

    <?php $pics = getLastPictures(1); ?>
    <?php foreach($pics as $pic): ?>
        <img src="http://greeny.cs.tlu.ee/~cauphel/uploads/<?= $pic['filename'].'_thumbnail.'.$pic['extension'] ?>" alt="<?= $pic['alt'] ?>" />
    <?php endforeach; ?>

    <?php $pics = getAllPublicPictures(); ?>
    <?php foreach($pics as $pic): ?>
        <img src="http://greeny.cs.tlu.ee/~cauphel/uploads/<?= $pic['filename'].'_thumbnail.'.$pic['extension'] ?>" alt="<?= $pic['alt'] ?>" />
    <?php endforeach; ?>

    <div id="modal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImg" alt="" />
        <div id="caption"></div>
    </div>

    <h1>Pildi galerii tund 12 kodune töö</h1>
    <div id="gallery" class="gallery">
        <?php $pics = getPictures($page, 5); ?>
        <?php foreach($pics as $pic): ?>
            <img src="http://greeny.cs.tlu.ee/~cauphel/uploads/<?= $pic['filename'].'_thumbnail.'.$pic['extension'] ?>" alt="<?= $pic['alt'] ?>" data-src="<?= $pic['filename'].'.'.$pic['extension'] ?>" />
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>