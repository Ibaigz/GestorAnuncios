<?php
session_start();

include("db_konexioa.php");

$erabiltzailea = null;
$nav = null;

if (!empty($_SESSION['erabiltzailea'])) {
    $erabiltzaileaId = $_SESSION['erabiltzailea'];
    $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
    $stmt = $pdo->prepare($sqlErabiltzailea);
    $stmt->bindParam(':erabiltzailea', $erabiltzaileaId);
    $stmt->execute();
    $erabiltzailea = $stmt->fetch();
}

if (!empty($_GET['nav'])) {
    $nav = $_GET['nav'];
} else {
    $nav = 1;
}
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfila</title>
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
            if ($erabiltzailea == null) {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <h1 class="titleError">Erabiltzaileak ikusteko sesioa hasi behar duzu</h1>
                        <?php
                    } else {
                        ?>
                        <h1 class="titleError">Erabiltzaileak ikusteko sesioa hasi behar duzu</h1>
                        <?php
                    }
                } else {
                    ?>
                    <h1 class="titleError">Erabiltzaileak ikusteko sesioa hasi behar duzu</h1>
                    <?php
                }
            } else {
            ?>

                <div class="contenedorPrincipal">
                    <div class="informacion">
                        <div class="perfilHasiera">
                            <!-- Argazkia -->
                            <?php
                            $fitxategia = "media/erabiltzaileak/" . $erabiltzailea["id_erabiltzailea"] . "." . $erabiltzailea["extensioa"];
                            if (file_exists($fitxategia)) {
                                echo "<img class='imgProfila' src='" . $fitxategia . "' alt='profila'>";
                            } else {
                                echo "<img class='imgProfila' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                            }
                            ?>
                            <!-- Izena eta abizena -->
                            <div class="perfilIzena">
                                <div class="bordeakJarri izenPerfilaDiv">
                                    <h3><?php echo $erabiltzailea["izena"]; ?></h3>
                                </div>
                                <br>
                                <div class="bordeakJarri">
                                    <h3><?php echo $erabiltzailea["abizena"]; ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Deskribapena -->
                        <?php
                        if ($erabiltzailea["deskribapena"] != null) {
                        ?>
                            <div class="deskribapenaDiv">
                                <p><?php echo $erabiltzailea["deskribapena"] ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <!-- Botoiak -->
                    <div class="botones">
                        <div>
                            <button type="button" class="botoiak" onclick="location.href='perfila_editatu.php'">Editatu</button>
                            <button type="button" class="botoiak" onclick="location.href='sesioaitxi.php'">Sesioa itxi</button>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <div class="tab1">
                    <button class="tablinks1" onclick="openTabPerfil('Zure Iragarkiak')">Zure Iragarkiak</button>
                    <button class="tablinks1" onclick="openTabPerfil('Gogokoak')">Gogokoak</button>
                </div>
    
                <div id="Zure Iragarkiak" class="tabcontent1">
                    <?php
                    $sqlIragarkiak = "SELECT * FROM iragarkiak WHERE egiaztatua = 1 AND id_erabiltzailea = :id";
                    $stmt = $pdo->prepare($sqlIragarkiak);
                    $stmt->bindParam(':id', $erabiltzailea["id_erabiltzailea"]);
                    $stmt->execute();
                    $iragarkiak = $stmt->fetchAll();
                    if ($stmt->rowCount() > 0) {
                        if ($stmt->rowCount() > 3) {
                            echo "<div class='tarjetas_iragarkiak'>";
                        } else {
                            echo "<div>";
                        }
                        echo "<div class='tarjetas-container'>";
                        foreach ($iragarkiak as $iragarkia) {
                            $sqlgogokoak = "SELECT * FROM gogokoak WHERE id_erabiltzailea = :id AND id_iragarkia = :iragarkia";
                            $stmt = $pdo->prepare($sqlgogokoak);
                            $stmt->bindParam(':id', $erabiltzailea["id_erabiltzailea"]);
                            $stmt->bindParam(':iragarkia', $iragarkia["id_iragarkia"]);
                            $stmt->execute();
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    if ($stmt->rowCount() > 0) {
                                        echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjetaGaitzeko tarjeta-oscuro-gogokoa' id='" . $iragarkia["id_iragarkia"] . "'>";
                                    } else {
                                        echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 blue-hover tarjetaGaitzeko tarjeta-oscuro' id='" . $iragarkia["id_iragarkia"] . "'>";
                                    }
                                } else {
                                    if ($stmt->rowCount() > 0) {
                                        echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjetaGaitzeko' id='" . $iragarkia["id_iragarkia"] . "'>";
                                    } else {
                                        echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 blue-hover tarjetaGaitzeko' id='" . $iragarkia["id_iragarkia"] . "'>";
                                    }
                                }
                            } else {
                                if ($stmt->rowCount() > 0) {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjetaGaitzeko' id='" . $iragarkia["id_iragarkia"] . "'>";
                                } else {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 blue-hover tarjetaGaitzeko' id='" . $iragarkia["id_iragarkia"] . "'>";
                                }
                            }
                            echo "<div class='irudiaErdian'>";
                            echo "<div class='irudiaIragarkia'>";
                            $sqlArgazkia = "SELECT * FROM argazkiak WHERE id_iragarkia = :id";
                            $stmt = $pdo->prepare($sqlArgazkia);
                            $stmt->bindParam(':id', $iragarkia["id_iragarkia"]);
                            $stmt->execute();
                            $argazkia = $stmt->fetch();
                            $fitxategia = "media/iragarkiak/" . $argazkia["id_argazkia"] . "." . $argazkia["extensioa"];
                            if (file_exists($fitxategia)) {
                                echo "<img src='" . $fitxategia . "' alt='argazkia' class='d-block w-full'>";
                            } else {
                                echo "<img src='media/iragarkiak/no-image.png' alt='argazkia' class='d-block w-full'>";
                            }
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='px-2 py-2'>";
                            echo "<div class='kategoriaIragarkiaDiv'>";
                            $sqlKategoria = "SELECT * FROM kategoria WHERE id_kategoria = :id";
                            $stmt = $pdo->prepare($sqlKategoria);
                            $stmt->bindParam(':id', $iragarkia["kategoria_id"]);
                            $stmt->execute();
                            $kategoriaIragarki = $stmt->fetch();
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px text-white'>" . $kategoriaIragarki["izena"] . "</p>";
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px text-white'>" . $iragarkia["prezioa"] . "€</p>";
                                } else {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $kategoriaIragarki["izena"] . "</p>";
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $iragarkia["prezioa"] . "€</p>";
                                }
                            } else {
                                echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $kategoriaIragarki["izena"] . "</p>";
                                echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $iragarkia["prezioa"] . "€</p>";
                            }
                            echo "</div>";
                            echo "<h1 class='font-weight-normal text-black card-heading mt-0 mb-1' style='line-height: 1.25;''>" . $iragarkia["izena"] . "</h1>";
                            echo "<div class='deskribapena'>";
                            echo "<p class='mb-1'>" . $iragarkia["deskribapena"] . "</p>";
                            echo "</div>";
                            $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
                            $stmt = $pdo->prepare($sqlErabiltzailea);
                            $stmt->bindParam(':id', $iragarkia["id_erabiltzailea"]);
                            $stmt->execute();
                            $erabiltzaileaIragarki = $stmt->fetch();
                            echo "<div class='erabiltzaileaIragarkiaDiv'>";
                            $fitxategia = "media/erabiltzaileak/" . $erabiltzaileaIragarki["id_erabiltzailea"] . "." . $erabiltzaileaIragarki["extensioa"];
                            if (file_exists($fitxategia)) {
                                echo "<img src='" . $fitxategia . "' alt='erabiltzailea' class='imgBorobila'>";
                            } else {
                                echo "<img src='media/erabiltzaileak/perfil.png' alt='erabiltzailea' class='imgBorobila'>";
                            }
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px text-white'>" . $erabiltzaileaIragarki["erabiltzailea"] . "</p>";
                                } else {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $erabiltzaileaIragarki["erabiltzailea"] . "</p>";
                                }
                            } else {
                                echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $erabiltzaileaIragarki["erabiltzailea"] . "</p>";
                            }
                            echo "</div>";
                            if ($iragarkia["bidalketa"] == 1) {
                                echo "<div class='borobilaOndo'></div>";
                                echo "<img src='media/icons/bidalketa.svg' alt='bidalketa' class='bidalketa'>";
                                if ($iragarkia["data_hasiera"] != null) {
                                    echo "<div class='borobilaDenboraBidalketa'></div>";
                                    if ($iragarkia["data_hasiera"] <= date("Y-m-d") && $iragarkia["data_bukaera"] >= date("Y-m-d")) {
                                        // hasita
                                        echo "<img src='media/icons/data_hasita.svg' alt='bidalketa' class='hasitaBildaketa'>";
                                    } else if ($iragarkia["data_hasiera"] > date("Y-m-d")) {
                                        // hasi gabe
                                        echo "<img src='media/icons/data_hasi_lehen.svg' alt='bidalketa' class='hasi_gabeBidalketa'>";
                                    } else if ($iragarkia["data_bukaera"] < date("Y-m-d")) {
                                        // bukatuta
                                        echo "<img src='media/icons/data_bukatuta.svg' alt='bidalketa' class='bukatutaBidalketa'>";
                                    }
                                }
                            } else {
                                if ($iragarkia["data_hasiera"] != null) {
                                    echo "<div class='borobilaDenbora'></div>";
                                    if ($iragarkia["data_hasiera"] <= date("Y-m-d") && $iragarkia["data_bukaera"] >= date("Y-m-d")) {
                                        // hasita
                                        echo "<img src='media/icons/data_hasita.svg' alt='bidalketa' class='hasita'>";
                                    } else if ($iragarkia["data_hasiera"] > date("Y-m-d")) {
                                        // hasi gabe
                                        echo "<img src='media/icons/data_hasi_lehen.svg' alt='bidalketa' class='hasi_gabe'>";
                                    } else if ($iragarkia["data_bukaera"] < date("Y-m-d")) {
                                        // bukatuta
                                        echo "<img src='media/icons/data_bukatuta.svg' alt='bidalketa' class='bukatuta'>";
                                    }
                                }
                            }
    
                            echo "</div>";
                            echo "<a href='iragarkia.php?id=" . $iragarkia["id_iragarkia"] . "' class='text-uppercase font-weight-medium lts-2px ml-2 mb-2 text-center styled-link'>Informazio Gehiago</a><br>";
                            echo "<div class='botoiakGaitzekoIragarkiak'>";
                            ?>
                            <button type='button' class='botoiaEditKategoria' onclick="window.location.href='<?php echo 'iragarkiaEditatu.php?id=' . $iragarkia['id_iragarkia']; ?>'"><img src='media/icons/edit.svg' alt='Iragarkia Editatuta' class='iconoEditKategoria'></button>
                        <?php
                            echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
                        echo "</div>";
                    } else {
                        ?>
                        <br>
                        <?php
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>    
                                <p class="text-white"><br>Ez dituzu iragarkirik</p>
                                <?php
                            } else {
                                ?>    
                                <p><br>Ez dituzu iragarkirik</p>
                                <?php
                            }
                        } else {
                            ?>    
                            <p><br>Ez dituzu iragarkirik</p>
                            <?php
                        }
                        ?>
                        <p>Ez dituzu iragarkirik</p>
                    <?php
                    }
                    ?>
                </div>
    
                <div id="Gogokoak" class="tabcontent1">
                    <?php
                    $sqlGogokoak = "SELECT * FROM gogokoak WHERE id_erabiltzailea = :id";
                    $stmt = $pdo->prepare($sqlGogokoak);
                    $stmt->bindParam(':id', $erabiltzailea["id_erabiltzailea"]);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $gogokoak = $stmt->fetchAll();
                        if ($stmt->rowCount() > 3) {
                            echo "<div class='tarjetas_iragarkiak'>";
                        } else {
                            echo "<div>";
                        }
                        echo "<div class='tarjetas-container'>";
                        foreach ($gogokoak as $iragarkia) {
                            $sqlIragarkia = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
                            $stmt = $pdo->prepare($sqlIragarkia);
                            $stmt->bindParam(':id', $iragarkia["id_iragarkia"]);
                            $stmt->execute();
                            $gogokoa = $stmt->fetch();
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjetaGaitzeko tarjeta-oscuro-gogokoa' id='" . $iragarkia["id_iragarkia"] . "'>";
                                } else {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjetaGaitzeko' id='" . $iragarkia["id_iragarkia"] . "'>";
                                }
                            } else {
                                echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjetaGaitzeko' id='" . $iragarkia["id_iragarkia"] . "'>";
                            }
                            echo "<div class='irudiaErdian'>";
                            echo "<div class='irudiaIragarkia'>";
                            $sqlArgazkia = "SELECT * FROM argazkiak WHERE id_iragarkia = :id";
                            $stmt = $pdo->prepare($sqlArgazkia);
                            $stmt->bindParam(':id', $gogokoa["id_iragarkia"]);
                            $stmt->execute();
                            $argazkia = $stmt->fetch();
                            $fitxategia = "media/iragarkiak/" . $argazkia["id_argazkia"] . "." . $argazkia["extensioa"];
                            if (file_exists($fitxategia)) {
                                echo "<img src='" . $fitxategia . "' alt='argazkia' class='d-block w-full'>";
                            } else {
                                echo "<img src='media/iragarkiak/no-image.png' alt='argazkia' class='d-block w-full'>";
                            }
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='px-2 py-2'>";
                            echo "<div class='kategoriaIragarkiaDiv'>";
                            $sqlKategoria = "SELECT * FROM kategoria WHERE id_kategoria = :id";
                            $stmt = $pdo->prepare($sqlKategoria);
                            $stmt->bindParam(':id', $gogokoa["kategoria_id"]);
                            $stmt->execute();
                            $kategoriaIragarki = $stmt->fetch();
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px text-white'>" . $kategoriaIragarki["izena"] . "</p>";
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px text-white'>" . $gogokoa["prezioa"] . "€</p>";
                                } else {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $kategoriaIragarki["izena"] . "</p>";
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $gogokoa["prezioa"] . "€</p>";
                                }
                            } else {
                                echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $kategoriaIragarki["izena"] . "</p>";
                                echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $gogokoa["prezioa"] . "€</p>";
                            }
                            echo "</div>";
                            echo "<h1 class='font-weight-normal text-black card-heading mt-0 mb-1' style='line-height: 1.25;''>" . $gogokoa["izena"] . "</h1>";
                            echo "<div class='deskribapena'>";
                            echo "<p class='mb-1'>" . $gogokoa["deskribapena"] . "</p>";
                            echo "</div>";
                            $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
                            $stmt = $pdo->prepare($sqlErabiltzailea);
                            $stmt->bindParam(':id', $gogokoa["id_erabiltzailea"]);
                            $stmt->execute();
                            $erabiltzaileaIragarki = $stmt->fetch();
                            echo "<div class='erabiltzaileaIragarkiaDiv'>";
                            $fitxategia = "media/erabiltzaileak/" . $erabiltzaileaIragarki["id_erabiltzailea"] . "." . $erabiltzaileaIragarki["extensioa"];
                            if (file_exists($fitxategia)) {
                                echo "<img src='" . $fitxategia . "' alt='erabiltzailea' class='imgBorobila'>";
                            } else {
                                echo "<img src='media/erabiltzaileak/perfil.png' alt='erabiltzailea' class='imgBorobila'>";
                            }
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px text-white'>" . $erabiltzaileaIragarki["erabiltzailea"] . "</p>";
                                } else {
                                    echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $erabiltzaileaIragarki["erabiltzailea"] . "</p>";
                                }
                            } else {
                                echo "<p class='mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px'>" . $erabiltzaileaIragarki["erabiltzailea"] . "</p>";
                            }
                            echo "</div>";
                            if ($gogokoa["bidalketa"] == 1) {
                                echo "<div class='borobilaOndo'></div>";
                                echo "<img src='media/icons/bidalketa.svg' alt='bidalketa' class='bidalketa'>";
                                if ($gogokoa["data_hasiera"] != null) {
                                    echo "<div class='borobilaDenboraBidalketa'></div>";
                                    if ($gogokoa["data_hasiera"] <= date("Y-m-d") && $gogokoa["data_bukaera"] >= date("Y-m-d")) {
                                        // hasita
                                        echo "<img src='media/icons/data_hasita.svg' alt='bidalketa' class='hasitaBildaketa'>";
                                    } else if ($gogokoa["data_hasiera"] > date("Y-m-d")) {
                                        // hasi gabe
                                        echo "<img src='media/icons/data_hasi_lehen.svg' alt='bidalketa' class='hasi_gabeBidalketa'>";
                                    } else if ($gogokoa["data_bukaera"] < date("Y-m-d")) {
                                        // bukatuta
                                        echo "<img src='media/icons/data_bukatuta.svg' alt='bidalketa' class='bukatutaBidalketa'>";
                                    }
                                }
                            } else {
                                if ($gogokoa["data_hasiera"] != null) {
                                    echo "<div class='borobilaDenbora'></div>";
                                    if ($gogokoa["data_hasiera"] <= date("Y-m-d") && $gogokoa["data_bukaera"] >= date("Y-m-d")) {
                                        // hasita
                                        echo "<img src='media/icons/data_hasita.svg' alt='bidalketa' class='hasita'>";
                                    } else if ($gogokoa["data_hasiera"] > date("Y-m-d")) {
                                        // hasi gabe
                                        echo "<img src='media/icons/data_hasi_lehen.svg' alt='bidalketa' class='hasi_gabe'>";
                                    } else if ($gogokoa["data_bukaera"] < date("Y-m-d")) {
                                        // bukatuta
                                        echo "<img src='media/icons/data_bukatuta.svg' alt='bidalketa' class='bukatuta'>";
                                    }
                                }
                            }
    
                            echo "</div>";
                            echo "<a href='iragarkia.php?id=" . $gogokoa["id_iragarkia"] . "' class='text-uppercase font-weight-medium lts-2px ml-2 mb-2 text-center styled-link'>Informazio Gehiago</a><br>";
                            echo "</div>";
                        }
                        echo "</div>";
                        echo "</div>";
    
                    } else {
                        ?>
                        <br>
                        <p>Ez dituzu gogoko iragarkirik</p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <script>
                window.addEventListener("load", nav);
                
                function nav() {
                    let nav = <?php echo $nav ?>;
                    console.log(nav);
                    switch (nav) {
                        case 1:
                            openTabPerfil1(0, "Zure Iragarkiak");
                            break;
                        case 2:
                            openTabPerfil1(1, "Gogokoak");
                            break;
                        default:
                            openTabPerfil1(0, "Zure Iragarkiak");
                            break;
                    }
                }
    
                window.addEventListener("load", inicioMenu);
            </script>
            <?php
            }
            ?>
        </div>
    </div>

        <?php
        include("footer.php");
        ?>
</body>

</html>