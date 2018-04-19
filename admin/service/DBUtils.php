<?php

define("DB_UTILS", "hihi");

function getConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chat";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
    return $conn;
}

function closeConnection($conn){
    $conn = null;
}
