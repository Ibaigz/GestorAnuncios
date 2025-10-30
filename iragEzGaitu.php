<?php
    include("db_konexioa.php");

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $sqlExistitzenDa = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
        $stmt = $pdo->prepare($sqlExistitzenDa);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt -> rowCount() > 0) {
            $sqlArgazkiak = "SELECT * FROM argazkiak WHERE id_iragarkia = :id";
            $stmt = $pdo->prepare($sqlArgazkiak);
            $stmt->bindParam(':id', $_GET["id"]);
            $stmt->execute();
            $argazkiak = $stmt->fetchAll();
            foreach ($argazkiak as $argazkia) {
                $fitxategia = "media/iragarkiak/" . $argazkia["id_argazkia"] . "." . $argazkia["extensioa"];
                if (file_exists($fitxategia)) {
                    unlink($fitxategia);
                }
            }
            $sqlEzabatu = "DELETE FROM iragarkiak WHERE id_iragarkia = :id";
            $stmt = $pdo->prepare($sqlEzabatu);
            $stmt->bindParam(':id', $_GET["id"]);
            $stmt->execute();

            header("Location: adminpage.php");
        } else {
            echo "<script>alert('Ez da iragarkia sartu 1')</script>";
        }

    } else {
        echo "<script>alert('Ez da iragarkia sartu 2')</script>";
    }
?>