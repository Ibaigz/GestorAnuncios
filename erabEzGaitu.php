<?php
    include("db_konexioa.php");

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $sqlExistitzenDa = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id_erabiltzailea";
        $stmt = $pdo->prepare($sqlExistitzenDa);
        $stmt->bindParam(':id_erabiltzailea', $id);
        $stmt->execute();
        if ($stmt -> rowCount() > 0) {
            $erab = $stmt->fetch();
            $fitxategia = "media/erabiltzaileak/" . $id . "." . $erab["extensioa"];
            if (file_exists($fitxategia)) {
                unlink($fitxategia);
            }
            $sqlEzabatu = "DELETE FROM erabiltzaileak WHERE id_erabiltzailea = :id_erabiltzailea";
            $stmt = $pdo->prepare($sqlEzabatu);
            $stmt->bindParam(':id_erabiltzailea', $_GET["id"]);
            $stmt->execute();
            header("Location: adminpage.php");
        } else {
            echo "<script>alert('Ez da erabiltzailea sartu 1')</script>";
        }

    } else {
        echo "<script>alert('Ez da erabiltzailea sartu 2')</script>";
    }
?>