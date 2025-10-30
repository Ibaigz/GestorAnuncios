<?php
    include("db_konexioa.php");

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $sqlExistitzenDa = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id_erabiltzailea";
        $stmt = $pdo->prepare($sqlExistitzenDa);
        $stmt->bindParam(':id_erabiltzailea', $id);
        $stmt->execute();
        if ($stmt -> rowCount() > 0) {
            $sqlUpdate = "UPDATE erabiltzaileak SET rol = 1 WHERE id_erabiltzailea = :id_erabiltzailea";
            $stmt = $pdo->prepare($sqlUpdate);
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