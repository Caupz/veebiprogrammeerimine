<?php
require("../../../config.php");

function escapePostData($index) {
    $str = '';
    if(isset($_POST[$index])) {
        $str = escapeStr($_POST[$index]);
    }
    return $str;
}

function escapeStr($str) {
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
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
    $stmt = $connection->prepare('SELECT comment FROM comment');
    $msg = "";
    $stmt->bind_result($msg);
    $stmt->execute();
    $comments = [];

    while($stmt->fetch()) {
        $comments[] = $msg;
    }
    return $comments;
}

function getAllAnimals() {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare('SELECT * FROM animal ORDER BY id DESC');
    $id = "";
    $name = "";
    $color = "";
    $tail_length = "";
    $type = "";
    $stmt->bind_result($id, $name, $color, $tail_length, $type);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'name' => $name,
            'color' => $color,
            'tail_length' => $tail_length,
            'type' => $type,
        ];
    }
    return $entities;
}

function getAllUsersWithEmail($email) {
    setDbConnection();
    $email = escapeStr($email);

    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare("SELECT id, firstname, lastname, email, gender, birthdate, created_at FROM vpusers WHERE email = '{$email}'");
    $id = "";
    $firstname = "";
    $lastname = "";
    $email = "";
    $gender = "";
    $birthdate = "";
    $created_at = "";
    $stmt->bind_result($id, $firstname, $lastname, $email, $gender, $birthdate, $created_at);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'gender' => $gender,
            'birthdate' => $birthdate,
            'created_at' => $created_at,
        ];
    }

    return $entities;
}

/*
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
    $_values = [];
    $paramTypes = "";

    if($table == 'vpusers' && isset($values['email'])) {
        $usersWithSameEmail = getAllUsersWithEmail($values['email']);
        if(count($usersWithSameEmail) > 0) {
            $connection->close();
            $connection = null;
            return "Sellise emailiga kasutaja on juba olemas.";
        }
    }

    foreach($values as $key => $value) {
        if(is_string($value)) $paramTypes .= "s";
        else if(is_integer($value)) $paramTypes .= "i";
        else if(is_float($value) || is_double($value)) $paramTypes .= "d";
    }
    $_values[] = & $paramTypes;
    foreach($values as $key => $value) {
        $sql .= $key.',';
        $lastPartOfSql .= '?,';
        $valuesInStr .= $value.',';
        $_values[] = & $values[$key];
    }
    $sql = rtrim($sql,",");
    $lastPartOfSql = rtrim($lastPartOfSql,",");
    $sql .= ") VALUES (";
    $sql .= $lastPartOfSql.')';

    $stmt = $connection->prepare($sql);
    echo $connection->error;
    call_user_func_array(array($stmt, 'bind_param'), $_values);

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

function GetFieldValue($index) {
    if(isset($GLOBALS['fields'][$index])) return $GLOBALS['fields'][$index];
    return '';
}

function ShowError($index) {
    if(isset($GLOBALS['errors'][$index])) return $GLOBALS['errors'][$index];
    return '';
}

?>