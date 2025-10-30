<?php
    include("db_konexioa.php");

    if (!empty($_GET["id"])) {
        // update a la tabla erabiltzaileak
        $id = $_GET["id"];
        $sqlExistitzenDa = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id_erabiltzailea";
        $stmt = $pdo->prepare($sqlExistitzenDa);
        $stmt->bindParam(':id_erabiltzailea', $id);
        $stmt->execute();
        if ($stmt -> rowCount() > 0) {
            $sqlUpdate = "UPDATE erabiltzaileak SET egiaztatua = 1 WHERE id_erabiltzailea = :id_erabiltzailea";
            $stmt = $pdo->prepare($sqlUpdate);
            $stmt->bindParam(':id_erabiltzailea', $_GET["id"]);
            $stmt->execute();
            // Email bidali
            header("Location: email.php?id=6&erab=" . $id);
        } else {
            echo "<script>alert('Ez da erabiltzailea sartu')</script>";
        }
    } else {
        echo "<script>alert('Ez da erabiltzailea sartu')</script>";
        header("Location: adminpage.php");
    }


?>