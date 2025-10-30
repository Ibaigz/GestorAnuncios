<?php
session_start();

include("db_konexioa.php");

$erabiltzailea = null;
$pagination = null;

if (!empty($_SESSION['erabiltzailea'])) {
    $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
    $stmt = $pdo->prepare($sqlErabiltzailea);
    $stmt->bindParam(':erabiltzailea', $_SESSION['erabiltzailea']);
    $stmt->execute();
    $erabiltzailea = $stmt->fetch();
}

if (!empty($_GET["pagination"])) {
    $pagination = $_GET["pagination"];
} else {
    $pagination = 1;
}
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tradespot</title>
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
                <?php include('menu.php') ?>
                <!-- Info -->

                <div id="help-modal" class="modal">
                    <?php
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <div class="modal-content info-modal-oscuro">
                                <?php
                            } else {
                                ?>
                                <div class="modal-content">
                                <?php
                            }
                        } else {
                            ?>
                            <div class="modal-content">
                            <?php
                        }
                    ?>
                        <p>Ondorengo ikonoek ekitaldia edo iragarkiaren informazioa ematen dute:</p>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/bidalketa.svg' alt='bidalketa'>
                            </div>
                            <p>Bidalketa gaituta badago</p>
                        </div>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/data_hasi_lehen.svg' alt='Ekitaldia hasi gabe' class='hasi_gabeInfo'>
                            </div>
                            <p>Ekitaldia hasi gabe badago</p>
                        </div>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/data_hasita.svg' alt='Ekitaldia hasita' class='hasitaInfo'>
                            </div>
                            <p>Ekitaldia hasita badago</p>
                        </div>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/data_bukatuta.svg' alt='Ekitaldia bukatuta' class='bukatutaInfo'>
                            </div>
                            <p>Ekitaldia bukatuta badago</p>
                        </div>
                        <button id="close-modal-help" class="botoiaGorriaInfoItxi">ITXI</button>
                    </div>
                </div>
                
                <form class="bilatzailea" method="get">
                    <?php
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <input type="text" placeholder="Iragarkiak bilatu" name="bilatu" class="bilatzaile-text border-white">
                            <button type="submit" name="bilatuButton" value="" class="bilatzaile-botoi argazkiaSubmit border-white">
                                <img src="media/icons/bilatu.svg" alt="bilatzaileaIcon" class="bilatuIcon">
                            </button>
                            <?php
                        } else {
                            ?>
                            <input type="text" placeholder="Bilatu..." name="bilatu">
                            <button type="submit" name="bilatuButton" value="" class="bilatzaile-botoi argazkiaSubmit">
                                <img src="media/icons/bilatu.svg" alt="bilatzaileaIcon" class="bilatuIcon">
                            </button>
                            <?php
                        }
                    } else {
                        ?>
                        <input type="text" placeholder="Bilatu..." name="bilatu">
                        <button type="submit" name="bilatuButton" value="" class="bilatzaile-botoi argazkiaSubmit">
                            <img src="media/icons/bilatu.svg" alt="bilatzaileaIcon" class="bilatuIcon">
                        </button>
                        <?php
                    }
                    ?>
                    <div class="container-filtro" id="containerFiltro">
                        <?php
                        $sql = "SELECT * FROM kategoria";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        while ($fila = $stmt->fetch()) {
                            echo "<div class='filtro-checkbox'>";
                            echo "<input class='checkbox' type='checkbox' name='kategoriak[]' value='" . $fila["id_kategoria"] . "'>";
                            echo '<label>' . ucfirst($fila['izena']) . '</label>';
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <button type="button" class="filtro" onclick="muestraCategorias()">
                        <img class="filtro-img" src="./media/icons/filtro.svg" alt="">
                    </button>
                </form>
                <?php
                    include("bilatzailea.php");
                ?>
            </div>
    <script>
        window.addEventListener("load", inicioMenu);
        
        window.addEventListener("load", dialog);

        function muestraCategorias() {
            if (window.getComputedStyle(document.getElementById("containerFiltro")).display === 'none') {
                document.getElementById("containerFiltro").style.display = "block";
            } else if (window.getComputedStyle(document.getElementById("containerFiltro")).display === 'block') {
                document.getElementById("containerFiltro").style.display = "none";
            }
        }
    </script>
    <?php
    include("footer.php");
    ?>
</body>

</html>