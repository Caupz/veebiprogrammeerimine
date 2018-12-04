<?php
  require("../../../functions.php");
  $entities = getAllValidatedMessagesByUser();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sõnumid</title>
    <link rel="stylesheet" href="http://greeny.cs.tlu.ee/~cauphel/site.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
</head>
<body>
  <h1>Sõnumid</h1>
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
	<li><a href="validatemsg.php">Tagasi</a> sõnumite lehele!</li>
  </ul>
  <hr>

  <?php foreach($entities as $entity): ?>
    <?php if(count($entity['messages'])): ?>
     <p>
        <span><?= $entity['firstname'] ?> <?= $entity['lastname'] ?></span><br>
        <ul>
            <?php foreach($entity['messages'] as $message): ?>
                <li>
                    <span class="color-<?= $message['accepted'] > 0 ? 'green' : 'red' ?>"><?= $message['accepted'] > 0 ? 'Lubatud' : 'Keelatud' ?></span>
                    <span><?= $message['comment'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </p>
  <?php endif; ?>
  <?php endforeach; ?>


</body>
</html>
