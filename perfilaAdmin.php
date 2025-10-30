<?php
session_start();

include("db_konexioa.php");

$erabiltzailea = null;
$zureErabiltzailea = null;

if (!empty($_GET["id"])) {
    $erabiltzaileaId = $_GET["id"];
    $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id_erabiltzailea";
    $stmt = $pdo->prepare($sqlErabiltzailea);
    $stmt->bindParam(':id_erabiltzailea', $erabiltzaileaId);
    $stmt->execute();
    $erabiltzailea = $stmt->fetch();
}

if (!empty($_SESSION['erabiltzailea'])) {
    $zureErabId = $_SESSION["erabiltzailea"];
    $sqlZureErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
    $stmt1 = $pdo->prepare($sqlZureErabiltzailea);
    $stmt1->bindParam(':erabiltzailea', $zureErabId);
    $stmt1->execute();
    $zureErabiltzailea = $stmt1->fetch();
}
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfila Admin</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/style.js"></script>
    
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
            if ($zureErabiltzailea == null) {
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
                        <div>
                            <!-- Kokapena eta bestelakoak -->
                            <div class="bestePerfilInfo">
                                <?php
                                if ($erabiltzailea["kokapena"] != null) {
                                ?>
                                    <div>
                                        <h4>Kokapena:</h4>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="bestePerfilInfo">
                                <?php
                                if ($erabiltzailea["kokapena"] != null) {
                                ?>
                                    <div class="bordeakJarri">
                                        <p><?php echo $erabiltzailea["kokapena"] ?></p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Botoiak -->
                    <?php
                    if ($erabiltzailea["egiaztatua"] != 1 && $erabiltzailea["id_erabiltzailea"] != $zureErabiltzailea["id_erabiltzailea"]) {
                    ?>
                        <div class="botones" id=<?php echo $erabiltzailea["id_erabiltzailea"] ?>>
                            <div>
                                <button type="button" class="botoiakOndo"><img src="media/icons/check.svg" alt="check" class="botoiakOndoImg"></button>
                                <button type="button" class="botoiakTxarto"><img src="media/icons/close.svg" alt="close" class="botoiakTxartoImg"></button>
                            </div>
                        </div>
                    <?php
                    } else {
                        if ($erabiltzailea["id_erabiltzailea"] != $zureErabiltzailea["id_erabiltzailea"]) {
                        ?>
                            <div class="botones" id=<?php echo $erabiltzailea["id_erabiltzailea"] ?>>
                                <div>
                                    <!-- Erabiltzailea ezabatu -->
                                    <button type="button" class="botoiakTxarto btnEzabatu"><img src="media/icons/erabiltzailea_ezabatu.svg" alt="close" class="btnEzabatuImg"></button>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <script>
                    window.addEventListener("load", inicioPerfilAdmin());

                    let pasatuta = false;

                    function inicioPerfilAdmin() {
                        // Gaitu botoiak
                        let botoiakOndo = document.getElementsByClassName("botoiakOndo");
                        for (let i = 0; i < botoiakOndo.length; i++) {
                            botoiakOndo[i].addEventListener("click", gaituAdminPage);
                        }

                        let botoiakOndoImg = document.getElementsByClassName("botoiakOndoImg");
                        for (let i = 0; i < botoiakOndoImg.length; i++) {
                            botoiakOndoImg[i].addEventListener("click", gaituAdminPageImg);
                        }

                        // Ez gaitu botoiak
                        let botoiakTxarto = document.getElementsByClassName("botoiakTxarto");
                        for (let i = 0; i < botoiakTxarto.length; i++) {
                            botoiakTxarto[i].addEventListener("click", ezabatuAdminPage);
                        }

                        let botoiakTxartoImg = document.getElementsByClassName("botoiakTxartoImg");
                        for (let i = 0; i < botoiakTxartoImg.length; i++) {
                            botoiakTxartoImg[i].addEventListener("click", ezabatuAdminPageImg);
                        }

                        // Ezabatu botoiak
                        let btnEzabatu = document.getElementsByClassName("btnEzabatu");
                        for (let i = 0; i < btnEzabatu.length; i++) {
                            btnEzabatu[i].addEventListener("click", ezGaituAdminPage);
                        }

                        let btnEzabatuImg = document.getElementsByClassName("btnEzabatuImg");
                        for (let i = 0; i < btnEzabatuImg.length; i++) {
                            btnEzabatuImg[i].addEventListener("click", ezGaituAdminPageImg);
                        }
                    }

                    function gaituAdminPage(e) {
                        if (!pasatuta) {
                            let id = e.target.parentNode.parentNode.getAttribute("id");
                            location.href = "erabGaitu.php?id=" + id;
                        } else {
                            pasatuta = false;
                        }
                    }

                    function gaituAdminPageImg(e) {
                        if (!pasatuta) {
                            let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
                            pasatuta = true;
                            location.href = "erabGaitu.php?id=" + id;
                        }
                    }

                    function ezGaituAdminPage(e) {
                        if (!pasatuta) {
                            let id = e.target.parentNode.parentNode.getAttribute("id");
                            location.href = "arrazoitu_erab_ez_gaitua.php?id=" + id;
                        } else {
                            pasatuta = false;
                        }
                    }

                    function ezGaituAdminPageImg(e) {
                        if (!pasatuta) {
                            let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
                            pasatuta = true;
                            location.href = "arrazoitu_erab_ez_gaitua.php?id=" + id;
                        }
                    }

                    function ezabatuAdminPage(e) {
                        if (!pasatuta) {
                            let id = e.target.parentNode.parentNode.getAttribute("id");
                            // Enviar correo eliminado
                            location.href = "erabEzGaitu.php?id=" + id;
                        } else {
                            pasatuta = false;
                        }

                    }

                    function ezabatuAdminPageImg(e) {
                        if (!pasatuta) {
                            let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
                            // Enviar correo eliminado
                            pasatuta = true;
                            location.href = "erabEzGaitu.php?id=" + id;
                        }
                    }
                </script>
                <br>
                <hr>
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
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                if ($stmt->rowCount() > 0) {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjeta tarjeta-oscuro-gogokoa' id='" . $iragarkia["id_iragarkia"] . "'>";
                                } else {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 blue-hover tarjeta tarjeta-oscuro' id='" . $iragarkia["id_iragarkia"] . "'>";
                                }
                            } else {
                                if ($stmt->rowCount() > 0) {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjeta' id='" . $iragarkia["id_iragarkia"] . "'>";
                                } else {
                                    echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 blue-hover tarjeta' id='" . $iragarkia["id_iragarkia"] . "'>";
                                }
                            }
                        } else {
                            if ($stmt->rowCount() > 0) {
                                echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 gogokoak-hover tarjeta' id='" . $iragarkia["id_iragarkia"] . "'>";
                            } else {
                                echo "<div class='my-2 mx-auto p-relative bg-white shadow-1 blue-hover tarjeta' id='" . $iragarkia["id_iragarkia"] . "'>";
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
                        echo "<a href='iragarkia.php?id=" . $iragarkia["id_iragarkia"] . "' class='text-uppercase font-weight-medium lts-2px ml-2 mb-2 text-center styled-link'>Informazio Gehiago</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</div>";
                } else {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <p class="text-white"><br>Ez ditu iragarkirik</p>
                            <?php
                        } else {
                            ?>
                            <p><br>Ez ditu iragarkirik</p>
                            <?php
                        }
                    } else {
                        ?>
                        <p><br>Ez ditu iragarkirik</p>
                        <?php
                    }
                }
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