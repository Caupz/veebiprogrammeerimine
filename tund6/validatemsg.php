<?php
  require("../tund4/functions.php");

if(!isset($_SESSION['id'])) {
    header("Location: index2.php");
    exit();
}

if(isset($_GET['accept'])) {
    updateSet('comment', ['field_name' => 'accepted', 'value' => 1], ['field_name' => 'id', 'value' => $_GET['accept']]);
    updateSet('comment', ['field_name' => 'accepted_id', 'value' => $_SESSION['id']], ['field_name' => 'id', 'value' => $_GET['accept']]);
    header("Refresh:0; url=validatemsg.php");
    exit();
}
if(isset($_GET['ban'])) {
    updateSet('comment', ['field_name' => 'accepted', 'value' => -1], ['field_name' => 'id', 'value' => $_GET['ban']]);
    updateSet('comment', ['field_name' => 'accepted_id', 'value' => $_SESSION['id']], ['field_name' => 'id', 'value' => $_GET['ban']]);
    header("Refresh:0; url=validatemsg.php");
    exit();
}

$messages = getAllUnvalidatedComments();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="main.php">Tagasi</a> pealehele!</li>
  <hr>

    <ul>
    <?php foreach($messages as $msg): ?>
        <li><?= $msg['comment'] ?> <a href="?accept=<?= $msg['id'] ?>">Kinnita</a> <a href="?ban=<?= $msg['id'] ?>">Keela</a></li>
    <?php endforeach; ?>
    </li>

</body>
</html>


