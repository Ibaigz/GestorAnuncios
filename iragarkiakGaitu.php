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
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iragarkia Gaitu</title>
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
            $id = null;
            if (!empty($_GET['id'])) {
                $id = $_GET['id'];
            }

            if ($erabiltzailea != null && $erabiltzailea["rol"] == 0) {
                $sqlIragarkia = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
                $stmt = $pdo->prepare($sqlIragarkia);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $iragarkia = $stmt->fetch();
                    if ($iragarkia["egiaztatua"] == 0) {
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <h3 class="text-white">Ziur zaude "<a href="iragarkiaAdmin.php?id=<?php echo $iragarkia["id_iragarkia"] ?>" class="linkIragarkia text-white"><?php echo $iragarkia["izena"] ?></a>" izena duen iragarkia gaitu nahi duzula?</h3>
                                <?php
                            } else {
                                ?>
                                <h3>Ziur zaude "<a href="iragarkiaAdmin.php?id=<?php echo $iragarkia["id_iragarkia"] ?>" class="linkIragarkia"><?php echo $iragarkia["izena"] ?></a>" izena duen iragarkia gaitu nahi duzula?</h3>
                                <?php
                            }
                        } else {
                            ?>
                            <h3>Ziur zaude "<a href="iragarkiaAdmin.php?id=<?php echo $iragarkia["id_iragarkia"] ?>" class="linkIragarkia"><?php echo $iragarkia["izena"] ?></a>" izena duen iragarkia gaitu nahi duzula?</h3>
                            <?php
                        }
                        ?>
                        
                        <form method="post" class="iragarkiaGaitu">
                            <input type="submit" name="bai" value="Bai" class="gaitzekoBotoiakOndo">
                            <input type="submit" name="ez" value="Ez" class="gaitzekoBotoiakTxarto">
                        </form>
                        <?php
                        if (isset($_POST["bai"])) {
                            $sqlUpdate = "UPDATE iragarkiak SET egiaztatua = 1 WHERE id_iragarkia = :id";
                            $stmt = $pdo->prepare($sqlUpdate);
                            $stmt->bindParam(':id', $id);
                            $stmt->execute();
                            header("Location: email.php?id=9&irag=" . $id);
                        }

                        if (isset($_POST["ez"])) {
                            header("Location: adminpage.php?id=5");
                        }
                    } else {
                        echo "<h1>Irarkia jadanik gaituta dago</h1>";
                        echo "<a href='adminpage.php?id=5'>Atzera</a>";
                    }
                } else {
                    echo "<h1>Ez da iragarkirik exititzen id honekin</h1>";
                }
            } else {
                echo "<h1>Orrialde hau soilik administratzailei dago baimenduta</h1>";
            }
            ?>
        </div>
    </div>

    <?php
    include("footer.php");
    ?>
    <script>window.addEventListener("load", inicioMenu);</script>
</body>
</html>