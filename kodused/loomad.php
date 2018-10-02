<?php
require('../tund4/functions.php');
$notice = "";
$title = "IF18 praktikum";
$entities = getAllAnimals();
$animalTypes = [ 'Koer', 'Kass', 'Lind', 'Kuldkala', 'Kilpkonn' ];

if(count($_POST)) {
    $animalName = escapePostData('animalName');
    $color = escapePostData('color');
    $tail = floatval(escapePostData('tail'));
    $animalType = escapePostData('animalType');

    if(strlen($animalName) > 0 && strlen($color) > 0 && strlen($animalType) > 0) {
        $notice = insertInto('animal', [
            'name' => $animalName,
            'color' => $color,
            'tail_length' => $tail,
            'type' => $animalType
        ]);
        header("Refresh:0");
    } else {
        $notice = "Looma nimi, värvus või tüüp on märkimata!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="http://greeny.cs.tlu.ee/~cauphel/site.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
</head>

<body>
    <h1><?= basename(__FILE__) ?></h1>

    <div class="center">
        <p><?= $notice ?></p>
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <label for="animalName">Nimi:</label><br>
                <input type="text" name="animalName" /><br>

                <label for="color">Värvus:</label><br>
                <input type="text" name="color" /><br>

                <label for="tail">Saba pikkus (cm):</label><br>
                <input type="text" name="tail" /><br>

                <select name="animalType">
                <?php foreach($animalTypes as $animalType): ?>
                    <option value="<?= $animalType ?>"><?= $animalType ?></option>
                <?php endforeach; ?>
                </select><br>

                <input type="submit" name="submitData" value="Saada andmed" />
        </form>

        <p>
            <?php foreach($entities as $entity): ?>
                <?= $entity['id'] ?> <?= $entity['name'] ?> <?= $entity['type'] ?> <?= $entity['color'] ?> <?= $entity['tail_length'] ?><br>
            <?php endforeach; ?>
        </p>
    </div>

    <hr>
</body>
</html>