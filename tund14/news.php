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
$title = "Uudised";
require("../views/header.php");

?>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'textarea#newsEditor',
        plugins: "link",
        menubar: 'edit',
    });
</script>

<div class="container">
    Uudise lisamise vorm:
    <form id="newsForm" method="POST" action="http://greeny.cs.tlu.ee/~cauphel/router.php?action=postNews">
        <label>Uudise pealkiri:</label><br><input type="text" name="newsTitle" id="newsTitle" style="width: 100%;" value=""><br>
        <label>Uudise sisu:</label><br>
        <textarea name="newsEditor" id="newsEditor"></textarea>
        <br>
        <label>Uudis nähtav kuni (kaasaarvatud)</label>
        <input type="date" name="expiredate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?= $expiredate = date("Y-m-d"); ?>">

        <input name="newsBtn" id="newsBtn" type="submit" value="Salvesta uudis!">
    </form>

    <div id="news">
    </div>
</div>
<?php require("../views/footer.php"); ?>