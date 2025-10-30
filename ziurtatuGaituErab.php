<?php
    session_start();

    include("db_konexioa.php");

    $erabiltzailea = null;
    $id = null;

    if(!empty($_SESSION['erabiltzailea'])){
        $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
        $stmt = $pdo->prepare($sqlErabiltzailea);
        $stmt->bindParam(':erabiltzailea', $_SESSION['erabiltzailea']);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
    }

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
    }
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaitu Erabiltzailea</title>
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
                if ($id != null) {
                    $sqlErabiltzaileaAurk = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
                    $stmt = $pdo->prepare($sqlErabiltzaileaAurk);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $erab = $stmt->fetch();
                        if ($erab["egiaztatua"] == 0) {

                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    ?>
                                    <h3 class="text-white">Ziur zaude "<a href="perfilaAdmin.php?id=<?php echo $erab["id_erabiltzailea"] ?>" class="linkIragarkia text-white"><?php echo $erab["erabiltzailea"] ?></a>" izena duen erabiltzailea gaitu nahi duzula?</h3>
                                    <?php
                                } else {
                                    ?>
                                    <h3>Ziur zaude "<a href="perfilaAdmin.php?id=<?php echo $erab["id_erabiltzailea"] ?>" class="linkIragarkia"><?php echo $erab["erabiltzailea"] ?></a>" izena duen erabiltzailea gaitu nahi duzula?</h3>
                                    <?php
                                }
                            } else {
                                ?>
                                <h3>Ziur zaude "<a href="perfilaAdmin.php?id=<?php echo $erab["id_erabiltzailea"] ?>" class="linkIragarkia"><?php echo $erab["erabiltzailea"] ?></a>" izena duen erabiltzailea gaitu nahi duzula?</h3>
                                <?php
                            }
                            ?>
                            <form method="post" class="iragarkiaGaitu">
                                <input type="submit" name="bai" value="Bai" class="gaitzekoBotoiakOndo">
                                <input type="submit" name="ez" value="Ez" class="gaitzekoBotoiakTxarto">
                            </form>
                            <?php
                            if (isset($_POST["bai"])) {
                                header("Location: erabGaitu.php?id=" . $id);
                            }
    
                            if (isset($_POST["ez"])) {
                                header("Location: adminpage.php?id=2");
                            }
                        } else {
                            ?>
                            <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                            <?php
                            echo "Erabiltzailea iada egiaztatuta dago";
                        }
                    } else {
                        ?>
                        <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                        <?php
                        echo "Ez da erabiltzailerik existitzen id horrekin";
                    }
                } else {
                    ?>
                    <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                    <?php
                    echo "Ez duzu erabiltzailea aukeratu";
                }
            } else {
                header("Location: index.php");
            }
            ?>
        </div>
        <script>
            function goBack() {
                location.href = "adminpage.php?id=2";
            }
            window.addEventListener("load", inicioMenu);
        </script>
    </div>
    <?php
    include("footer.php");
    ?>
</body>
</html>