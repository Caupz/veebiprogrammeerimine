<?php
require("../../../config.php");
session_start();

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
    if(is_null($GLOBALS['connection']) or !isset($GLOBALS['connection'])) {
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
    $stmt->close();
    $connection->close();
    $connection = null;
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
    $stmt->close();
    $connection->close();
    $connection = null;
    return $entities;
}

function getAllUnvalidatedComments() {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare('SELECT id, user_id, comment, created_at FROM comment WHERE accepted = 0 AND accepted_id = 0 ORDER BY id DESC');
    $id = "";
    $user_id = "";
    $comment = "";
    $created_at = "";
    $stmt->bind_result($id, $user_id, $comment, $created_at);
    $stmt->execute();
    $entities = [];

    while($stmt->fetch()) {
        $entities[] = [
            'id' => $id,
            'user_id' => $user_id,
            'comment' => $comment,
            'created_at' => $created_at
        ];
    }
    $stmt->close();
    $connection->close();
    $connection = null;
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
 * $value = [
 *      'field_name' => 'field_name',
 *      'value' => 'value'
 * ]
 * $condition = [
 *      'field_name' => 'field_name',
 *      'value' => 'value'
 * ]
 * */
function updateSet($table, $value, $condition) {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    //var_dump($connection);die;
    $fieldName = $value['field_name'];
    $condName = $condition['field_name'];
    $stmt = $connection->prepare("UPDATE {$table} SET {$fieldName} = ? WHERE {$condName} = ?");
    //var_dump($stmt);die;
    echo $connection->error;
    $stmt->bind_param("ss", $value['value'], $condition['value']);

    //$stmt->bindParam(':fieldVal', $value['value'], PDO::PARAM_STR);
    //$stmt->bindParam(':condVal', $condition['value'], PDO::PARAM_STR);

    $notice = "";

    if($stmt->execute()) {
        $notice = "Kasutajat ei leitud.";
    } else {
        $notice = "Päringu tegemisel viga.";
    }

    return $notice;
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


function signIn($email, $password) {
    setDbConnection();
    $connection = $GLOBALS['connection'];
    $stmt = $connection->prepare("SELECT id, firstname, lastname, password_hash FROM vpusers WHERE email = ? LIMIT 1");
    echo $connection->error;
    $stmt->bind_param("s", $email);
    $resultPassword = "";
    $id = "";
    $firstname = "";
    $lastname = "";
    $stmt->bind_result($id, $firstname, $lastname, $resultPassword);
    $notice = "";

    if($stmt->execute()) {
        if($stmt->fetch()) {
            if(password_verify($password, $resultPassword)) {
                $notice = "Sisselogimine õnnestus.";
                $stmt->close();
                $connection->close();
                $connection = null;
                $_SESSION['id'] = $id;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                header("Location: main.php");
                exit();
            } else {
                $notice = "Parool ei klapi.";
            }
        } else {
            $notice = "Kasutajat ei leitud.";
        }
    } else {
        $notice = "Päringu tegemisel viga.";
    }

    $stmt->close();
    $connection->close();
    $connection = null;

    return $notice;
}
?>