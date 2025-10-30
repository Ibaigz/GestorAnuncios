<?php
    session_start();

    include("db_konexioa.php");

    $erabiltzailea = null;

    if(!empty($_SESSION['erabiltzailea'])){
        $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
        $stmt = $pdo->prepare($sqlErabiltzailea);
        $stmt->bindParam(':erabiltzailea', $_SESSION['erabiltzailea']);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
    }

    $id = null;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoria Ezabatu</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/style.js"></script>
    <link rel="shortcut icon" href="media/logo.ico" />

</head>
<?php
    if (isset($_COOKIE["dark"])) {
        if ($_COOKIE["dark"] == "on") {
            ?>
            <body class="dark-mode">
            <?php
        } else {
            ?>
            <body>
            <?php
        }
    } else {
        ?>
        <body>
        <?php
    }
?>
    <div class="margin">
       <?php
       include("menu.php");
    ?>

        <div>
            <?php
            if ($erabiltzailea != null && $erabiltzailea["rol"] == 0) {
                if ($id == null) {
                    ?>
                    <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                    <?php
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <p class="text-white">Kategoria ez da existitzen</p>
                            <?php
                        } else {
                            ?>
                            <p>Kategoria ez da existitzen</p>
                            <?php
                        }
                    } else {
                        ?>
                        <p>Kategoria ez da existitzen</p>
                        <?php
                    }
                } else {
                    $sqlKategoria = "SELECT * FROM kategoria WHERE id_kategoria = :id";
                    $stmt = $pdo->prepare($sqlKategoria);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $kategoria = $stmt->fetch();
                    if ($kategoria == null) {
                        ?>
                        <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                        <?php
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <p class="text-white">Kategoria ez da existitzen</p>
                                <?php
                            } else {
                                ?>
                                <p>Kategoria ez da existitzen</p>
                                <?php
                            }
                        } else {
                            ?>
                            <p>Kategoria ez da existitzen</p>
                            <?php
                        }
                    } else {
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <h3 class="text-white">Ziur zaude "<?php echo ucfirst($kategoria["izena"]) ?>" kategoria ezabatu nahi duzula?</h3>
                                <?php
                            } else {
                                ?>
                                <h3>Ziur zaude "<?php echo ucfirst($kategoria["izena"]) ?>" kategoria ezabatu nahi duzula?</h3>
                                <?php
                            }
                        } else {
                            ?>
                            <h3>Ziur zaude "<?php echo ucfirst($kategoria["izena"]) ?>" kategoria ezabatu nahi duzula?</h3>
                            <?php
                        }
                        ?>
                        <form method="post" class="iragarkiaGaitu">
                            <input type="submit" name="bai" value="Bai" class="gaitzekoBotoiakOndo">
                            <input type="submit" name="ez" value="Ez" class="gaitzekoBotoiakTxarto">
                        </form>
                        <?php
                        if (isset($_POST["bai"])) {
                            $sqlKategoriaKonp = "SELECT * FROM iragarkiak WHERE kategoria_id = :id";
                            $stmt = $pdo->prepare($sqlKategoriaKonp);
                            $stmt->bindParam(':id', $id);
                            $stmt->execute();
                            if ($stmt->rowCount() > 0) {
                                if (isset($_COOKIE["dark"])) {
                                    if ($_COOKIE["dark"] == "on") {
                                        ?>
                                        <p class="text-white">Ezin da kategoria ezabatu iragarki batzuk kategoria honekin daudelako</p>
                                        <?php
                                    } else {
                                        ?>
                                        <p>Ezin da kategoria ezabatu iragarki batzuk kategoria honekin daudelako</p>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <p>Ezin da kategoria ezabatu iragarki batzuk kategoria honekin daudelako</p>
                                    <?php
                                }
                            } else {
                                $fitxategia = "media/kategoriak/" . $kategoria["id_kategoria"] . ".svg";
                                if (file_exists($fitxategia)) {
                                    unlink($fitxategia);
                                }
                                $sqlEzabatu = "DELETE FROM kategoria WHERE id_kategoria = :id";
                                $stmt = $pdo->prepare($sqlEzabatu);
                                $stmt->bindParam(':id', $id);
                                $stmt->execute();
                                header("Location: adminpage.php?id=6");
                            }
                        }

                        if (isset($_POST["ez"])) {
                            header("Location: adminpage.php?id=6");
                        }
                    }
                }
            } else {
                header("Location: index.php");
            }
            ?>
        </div>
    </div>
    <script>
        function goBack() {
            location.href = "adminpage.php?id=6";
        }
        window.addEventListener("load", inicioMenu);
    </script>
    <?php
    include("footer.php");
    ?>
</body>
</html>