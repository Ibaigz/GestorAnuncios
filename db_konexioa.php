<?php

    $hostDB = "localhost";
    // $hostDB = "db-erronka1t2.cnjga4jusy3a.us-east-1.rds.amazonaws.com";
    $izenaDB = "db_erronka1";
    // $izenaDB = "db_erronka1";
    $erabiltzaileaDB = "root";
    // $erabiltzaileaDB = "admin";
    $pasahitzaDB = "";
    // $pasahitzaDB = "Txurdinaga123";

    try {

        $hostPDO = "mysql:host=$hostDB;dbname=$izenaDB;charset=utf8mb4";
        $pdo = new PDO($hostPDO, $erabiltzaileaDB, $pasahitzaDB);

    } catch(PDOException $e) {
        echo "Ezin izan da datu basera konektatu<br>";
        exit;
    }
?>

