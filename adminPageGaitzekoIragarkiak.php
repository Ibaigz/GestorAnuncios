<div class="infoAdmin">
    <?php
    if (isset($_COOKIE["dark"])) {
            if ($_COOKIE["dark"] == "on") {
                ?>
                <h3 class="text-white">Gaitzeko Iragarkiak</h3>
                <div class="iconosIragarkiakAdmin">
                    <div class="icon-container">
                        <img src="media/icons/info.svg" alt="Información" id="info-icon" class="bilatuIcon">
                    </div>
                    <div class="icon-help-container">
                        <img src="media/icons/help.svg" alt="Ayuda" class="bilatuIcon">
                    </div>
                </div>
                <?php
            } else {
                ?>
                <h3>Gaitzeko Iragarkiak</h3>
                <div class="iconosIragarkiakAdmin">
                    <div class="icon-container">
                        <img src="media/icons/info.svg" alt="Información" id="info-icon">
                    </div>
                    <div class="icon-help-container">
                        <img src="media/icons/help.svg" alt="Ayuda">
                    </div>
                </div>
                <?php
            }
    } else {
        ?>
        <h3>Gaitzeko Iragarkiak</h3>
        <div class="iconosIragarkiakAdmin">
            <div class="icon-container">
                <img src="media/icons/info.svg" alt="Información" id="info-icon">
            </div>
            <div class="icon-help-container">
                <img src="media/icons/help.svg" alt="Ayuda">
            </div>
        </div>
        <?php
    }
    ?>
</div>
<?php
if ($id == 5) { // Nebegazioa
?>
    <form method="get">
        <div class="search-container">
            <input type="hidden" name="id" value="5">
            <?php
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <input type="text" placeholder="Bilatu..." name="bilatu" class="border-white">
                    <button type="submit" name="bilatuBotoia" value="" class="bilatzaile-botoi argazkiaSubmit border-white">
                        <img src="media/icons/bilatu.svg" alt="bilatzaileaIcon" class="bilatuIcon">
                    </button>
                    <?php
                } else {
                    ?>
                    <input type="text" placeholder="Bilatu..." name="bilatu">
                    <button type="submit" name="bilatuBotoia" value="" class="bilatzaile-botoi argazkiaSubmit">
                        <img src="media/icons/bilatu.svg" alt="bilatzaileaIcon" class="bilatuIcon">
                    </button>
                    <?php
                }
            } else {
                ?>
                <input type="text" placeholder="Bilatu..." name="bilatu">
                <button type="submit" name="bilatuBotoia" value="" class="bilatzaile-botoi argazkiaSubmit">
                    <img src="media/icons/bilatu.svg" alt="bilatzaileaIcon" class="bilatuIcon">
                </button>
                <?php
            }
            ?>
        </div>
    </form>
<?php
    if (isset($_GET["bilatuBotoia"])) {
        // Botoia klikatzean
        if (!empty($_GET["bilatu"])) {
            // testua bilatzean
            $bilatu = $_GET["bilatu"];
            $bakoitzeko = 9;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlIragarkiak = "SELECT * FROM iragarkiak WHERE egiaztatua = 0 AND izena LIKE '%$bilatu%' LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlIragarkiak);
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
                    echo "<a href='iragarkiaAdmin.php?id=" . $iragarkia["id_iragarkia"] . "' class='text-uppercase font-weight-medium lts-2px ml-2 mb-2 text-center styled-link'>Informazio Gehiago</a>";
                    echo "<div class='botoiakGaitzekoIragarkiak'>";
                    echo "<button type='button' class='botoiakOndoIragarkia'><img src='media/icons/check.svg' alt='check' class='iconoOndoIragarkia'></button>";
                    echo "<button type='button' class='botoiakTxartoIragarkia'><img src='media/icons/close.svg' alt='close' class='iconoTxartoIragarkia'></button>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude iragarkirik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude iragarkirik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude iragarkirik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM iragarkiak WHERE egiaztatua = 0 AND izena LIKE '%$bilatu%'";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=5&pagination=$i&bilatu=$bilatu'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        } else {
            // Bilatzailean bilatutakoa utzik badago
            $bakoitzeko = 9;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlIragarkiak = "SELECT * FROM iragarkiak WHERE egiaztatua = 0 LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlIragarkiak);
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
                    echo "<a href='iragarkiaAdmin.php?id=" . $iragarkia["id_iragarkia"] . "' class='text-uppercase font-weight-medium lts-2px ml-2 mb-2 text-center styled-link'>Informazio Gehiago</a>";
                    echo "<div class='botoiakGaitzekoIragarkiak'>";
                    echo "<button type='button' class='botoiakOndoIragarkia'><img src='media/icons/check.svg' alt='check' class='iconoOndoIragarkia'></button>";
                    echo "<button type='button' class='botoiakTxartoIragarkia'><img src='media/icons/close.svg' alt='close' class='iconoTxartoIragarkia'></button>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude iragarkirik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude iragarkirik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude iragarkirik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM iragarkiak WHERE egiaztatua = 0";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=5&pagination=$i'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        }
    } else {
        // botoia ez klikatzean
        if (!empty($_GET["bilatu"])) {
            // testua bilatzean botoia klikatu gabe
            $bilatu = $_GET["bilatu"];
            $bakoitzeko = 9;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlIragarkiak = "SELECT * FROM iragarkiak WHERE egiaztatua = 0 AND izena LIKE '%$bilatu%' LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlIragarkiak);
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
                    echo "<a href='iragarkiaAdmin.php?id=" . $iragarkia["id_iragarkia"] . "' class='text-uppercase font-weight-medium lts-2px ml-2 mb-2 text-center styled-link'>Informazio Gehiago</a>";
                    echo "<div class='botoiakGaitzekoIragarkiak'>";
                    echo "<button type='button' class='botoiakOndoIragarkia'><img src='media/icons/check.svg' alt='check' class='iconoOndoIragarkia'></button>";
                    echo "<button type='button' class='botoiakTxartoIragarkia'><img src='media/icons/close.svg' alt='close' class='iconoTxartoIragarkia'></button>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude iragarkirik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude iragarkirik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude iragarkirik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM iragarkiak WHERE egiaztatua = 0 AND izena LIKE '%$bilatu%'";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=5&pagination=$i&bilatu=$bilatu'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        } else {
            // Ezer ez bilatzean
            $bakoitzeko = 9;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlIragarkiak = "SELECT * FROM iragarkiak WHERE egiaztatua = 0 LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlIragarkiak);
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
                    echo "<a href='iragarkiaAdmin.php?id=" . $iragarkia["id_iragarkia"] . "' class='text-uppercase font-weight-medium lts-2px ml-2 mb-2 text-center styled-link'>Informazio Gehiago</a>";
                    echo "<div class='botoiakGaitzekoIragarkiak'>";
                    echo "<button type='button' class='botoiakOndoIragarkia'><img src='media/icons/check.svg' alt='check' class='iconoOndoIragarkia'></button>";
                    echo "<button type='button' class='botoiakTxartoIragarkia'><img src='media/icons/close.svg' alt='close' class='iconoTxartoIragarkia'></button>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude iragarkirik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude iragarkirik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude iragarkirik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM iragarkiak WHERE egiaztatua = 0";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=5&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=5&pagination=$i'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        }
    }
}
?>