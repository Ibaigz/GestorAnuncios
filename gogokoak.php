<?php
    session_start();

    include("db_konexioa.php");

    $id = null;
    $iragarkia = null;

    $erabiltzailea = null;

    if(!empty($_SESSION['erabiltzailea'])){
        $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
        $stmt = $pdo->prepare($sqlErabiltzailea);
        $stmt->bindParam(':erabiltzailea', $_SESSION['erabiltzailea']);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
    }

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }

    if (!empty($_GET["iragarkia"])) {
        $iragarkiaId = $_GET["iragarkia"];
        $sqlIragarkia = "SELECT * FROM iragarkiak WHERE id_iragarkia = :iragarkia";
        $stmt = $pdo->prepare($sqlIragarkia);
        $stmt->bindParam(':iragarkia', $iragarkiaId);
        $stmt->execute();
        $iragarkia = $stmt->fetch();
    }

    if ($id != null && $iragarkia != null && $erabiltzailea != null) {
        if ($id == 1) {
            // gehitu
            $sqlGogokoak = "INSERT INTO gogokoak (id_iragarkia, id_erabiltzailea) VALUES (:iragarkia, :erabiltzailea)";
            $stmt = $pdo->prepare($sqlGogokoak);
            $stmt->bindParam(':iragarkia', $iragarkia["id_iragarkia"]);
            $stmt->bindParam(':erabiltzailea', $erabiltzailea["id_erabiltzailea"]);
            $stmt->execute();
            header("Location: iragarkia.php?id=" . $iragarkia["id_iragarkia"]);
        } else if ($id == 2) {
            // ezabatu
            $sqlGogokoak = "DELETE FROM gogokoak WHERE id_iragarkia = :iragarkia AND id_erabiltzailea = :erabiltzailea";
            $stmt = $pdo->prepare($sqlGogokoak);
            $stmt->bindParam(':iragarkia', $iragarkia["id_iragarkia"]);
            $stmt->bindParam(':erabiltzailea', $erabiltzailea["id_erabiltzailea"]);
            $stmt->execute();
            header("Location: iragarkia.php?id=" . $iragarkia["id_iragarkia"]);
        }
    } else {
        header("Location: index.php");
    }
?>