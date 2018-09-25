<?php
require("../../../config.php");

function escapePostData($index) {
    $str = '';
    if(isset($_POST[$index])) {
    $str = $_POST[$index];
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    }
    return $str;
}

$connection = null;

function setDbConnection() {
    if(is_null($GLOBALS['connection'])) {
        $GLOBALS['connection'] = new mysqli($GLOBALS['db']['host'], $GLOBALS['db']['user'], $GLOBALS['db']['pass'], $GLOBALS['db']['database']);
    }
}

function getAllComments() {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare('SELECT message FROM comment');
    $stmt->bind_result($msg);
    $stmt->execute();
    $comments = [];

    while($stmt->fetch()) {
        $comments[] = $msg;
    }
    var_dump($comments);
    return $comments;

}

/* WARNING Multi field on veel katki !!!
 *
 * $table - table name in database
 * $values = [
 *      'field_name1' => 'field_value1',
 *      'field_name2' => 'field_value2',
 *      'field_name3' => 'field_value3',
 *      ...
 * ]
 * */
function insertInto($table, $values) {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $sql = "INSERT INTO {$table} (";
    $lastPartOfSql = "";
    $valuesInStr = "";
    $notice = "";
    $_values = [];

    foreach($values as $key => $value) {
        $sql .= $key.',';
        $lastPartOfSql .= '?,';
        $valuesInStr .= $value.',';
        $_values[] = $value;
    }
    $sql = rtrim($sql,",");
    $lastPartOfSql = rtrim($lastPartOfSql,",");
    $sql .= ") VALUES (";
    $sql .= $lastPartOfSql.')';

    var_dump($sql, $values);
    $stmt = $connection->prepare($sql);
    echo $connection->error;
    $paramTypes = "";

    foreach($values as $key => $value) {
        if(is_string($value)) $paramTypes .= "s";
        else if(is_integer($value)) $paramTypes .= "i";
        else if(is_float($value) || is_double($value)) $paramTypes .= "d";
    }
    $stmt->bind_param($paramTypes, $values['comment']);
    //$stmt->bind_param($paramTypes, $values); TODO kuidagi teha et bind_param suudaks multida

    //var_dump($stmt->execute($_values));
    if($stmt->execute()) {
        $notice = "Salvestati: {$valuesInStr}";
    } else {
        $notice = "Tekkis viga: {$stmt->error}";
    }
    $stmt->close();
    $connection->close();
    $connection = null;
    return $notice;
}

?>