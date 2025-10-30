<div class="infoAdmin">
    <?php
    if (isset($_COOKIE["dark"])) {
            if ($_COOKIE["dark"] == "on") {
                ?>
                <h3 class="text-white">Administratzaileak</h3>
                <div class="icon-container">
                    <img src="media/icons/info.svg" alt="Información" id="info-icon" class="bilatuIcon">
                </div>
                <?php
            } else {
                ?>
                <h3>Administratzaileak</h3>
                <div class="icon-container">
                    <img src="media/icons/info.svg" alt="Información" id="info-icon">
                </div>
                <?php
            }
    } else {
        ?>
        <h3>Administratzaileak</h3>
        <div class="icon-container">
            <img src="media/icons/info.svg" alt="Información" id="info-icon">
        </div>
        <?php
    }
    ?>
</div>
<?php
if ($id == 3) { // Nabegazioa
?>
    <form method="get">
        <div class="search-container">
            <input type="hidden" name="id" value="3">
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
            // Testua bilatzean
            $bilatu = $_GET["bilatu"];
            $bakoitzeko = 10;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlAdministratzaileak = "SELECT * FROM erabiltzaileak WHERE rol = 0 AND erabiltzailea LIKE '%$bilatu%' LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlAdministratzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $administratzailea = $stmt->fetchAll();
                foreach ($administratzailea as $admin) {
                    if ($stmt->rowCount() == 1 && $admin["erabiltzailea"] == $erabiltzailea["erabiltzailea"]) {
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <p class="text-white"><br>Ez daude erabiltzailerik</p>
                                <?php
                            } else {
                                ?>
                                <p><br>Ez daude erabiltzailerik</p>
                                <?php
                            }
                        } else {
                            ?>
                            <p><br>Ez daude erabiltzailerik</p>
                            <?php
                        }
                    } else {
                        if ($admin["erabiltzailea"] != $erabiltzailea["erabiltzailea"]) {
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    ?>
                                    <div class="erabiltzailea-admin border-white" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php
                                } else {
                                    ?>
                                    <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php 
                                }
                            } else {
                                ?>
                                <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                <?php
                            }
                                $fitxategia = "media/erabiltzaileak/" . $admin["id_erabiltzailea"] . ".png";
                                if (file_exists($fitxategia)) {
                                    echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                                } else {
                                    echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                                }
                                ?>
                                <p class="divP"><?php echo $admin["erabiltzailea"] ?></p>
                                <div>
                                            <button type="button" class="botoiaEzabatuAdmin"><img src="media/icons/erabiltzailea_admin_ezabatu.svg" alt="Erabiltzailea admin modetik kendu" class="iconoEzabatuAdmin"></button>
                                        </div>
                            </div>
                        <?php
                        }
                    }
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude erabiltzailerik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude erabiltzailerik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude erabiltzailerik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE rol = 0 AND id_erabiltzailea != " . $erabiltzailea["id_erabiltzailea"] . " AND erabiltzailea LIKE '%$bilatu%'";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=3&pagination=$i&bilatu=$bilatu'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        } else {
            // Testua ez bilatzean
            $bakoitzeko = 10;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlAdministratzaileak = "SELECT * FROM erabiltzaileak WHERE rol = 0 LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlAdministratzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $administratzailea = $stmt->fetchAll();
                foreach ($administratzailea as $admin) {
                    if ($stmt->rowCount() == 1 && $admin["erabiltzailea"] == $erabiltzailea["erabiltzailea"]) {
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <p class="text-white"><br>Ez daude adminsitratzailerik zutaz gain</p>
                                <?php
                            } else {
                                ?>
                                <p><br>Ez daude adminsitratzailerik zutaz gain</p>
                                <?php
                            }
                        } else {
                            ?>
                            <p><br>Ez daude adminsitratzailerik zutaz gain</p>
                            <?php
                        }
                    } else {
                        if ($admin["erabiltzailea"] != $erabiltzailea["erabiltzailea"]) {
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    ?>
                                    <div class="erabiltzailea-admin border-white" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php
                                } else {
                                    ?>
                                    <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php 
                                }
                            } else {
                                ?>
                                <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                <?php
                            }
                                $fitxategia = "media/erabiltzaileak/" . $admin["id_erabiltzailea"] . ".png";
                                if (file_exists($fitxategia)) {
                                    echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                                } else {
                                    echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                                }
                                ?>
                                <p class="divP"><?php echo $admin["erabiltzailea"] ?></p>
                                <div>
                                            <button type="button" class="botoiaEzabatuAdmin"><img src="media/icons/erabiltzailea_admin_ezabatu.svg" alt="Erabiltzailea admin modetik kendu" class="iconoEzabatuAdmin"></button>
                                        </div>
                            </div>
                        <?php
                        }
                    }
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude erabiltzailerik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude erabiltzailerik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude erabiltzailerik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE rol = 0 AND id_erabiltzailea != " . $erabiltzailea["id_erabiltzailea"];
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=3&pagination=$i'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        }
    } else {
        // Botoia ez klikatzean
        if (!empty($_GET["bilatu"])) {
            // Testua bilatzean
            $bilatu = $_GET["bilatu"];
            $bakoitzeko = 10;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlAdministratzaileak = "SELECT * FROM erabiltzaileak WHERE rol = 0 AND erabiltzailea LIKE '%$bilatu%' LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlAdministratzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $administratzailea = $stmt->fetchAll();
                foreach ($administratzailea as $admin) {
                    if ($stmt->rowCount() == 1 && $admin["erabiltzailea"] == $erabiltzailea["erabiltzailea"]) {
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <p class="text-white"><br>Ez daude erabiltzailerik</p>
                                <?php
                            } else {
                                ?>
                                <p><br>Ez daude erabiltzailerik</p>
                                <?php
                            }
                        } else {
                            ?>
                            <p><br>Ez daude erabiltzailerik</p>
                            <?php
                        }
                    } else {
                        if ($admin["erabiltzailea"] != $erabiltzailea["erabiltzailea"]) {
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    ?>
                                    <div class="erabiltzailea-admin border-white" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php
                                } else {
                                    ?>
                                    <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php 
                                }
                            } else {
                                ?>
                                <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                <?php
                            }
                                $fitxategia = "media/erabiltzaileak/" . $admin["id_erabiltzailea"] . ".png";
                                if (file_exists($fitxategia)) {
                                    echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                                } else {
                                    echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                                }
                                ?>
                                <p class="divP"><?php echo $admin["erabiltzailea"] ?></p>
                                <div>
                                            <button type="button" class="botoiaEzabatuAdmin"><img src="media/icons/erabiltzailea_admin_ezabatu.svg" alt="Erabiltzailea admin modetik kendu" class="iconoEzabatuAdmin"></button>
                                        </div>
                            </div>
                        <?php
                        }
                    }
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude erabiltzailerik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude erabiltzailerik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude erabiltzailerik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE rol = 0 AND id_erabiltzailea != " . $erabiltzailea["id_erabiltzailea"] . " AND erabiltzailea LIKE '%$bilatu%'";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=3&pagination=$i&bilatu=$bilatu'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        } else {
            // Testua ez bilatzean
            $bakoitzeko = 10;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlAdministratzaileak = "SELECT * FROM erabiltzaileak WHERE rol = 0 LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlAdministratzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $administratzailea = $stmt->fetchAll();
                foreach ($administratzailea as $admin) {
                    if ($stmt->rowCount() == 1 && $admin["erabiltzailea"] == $erabiltzailea["erabiltzailea"]) {
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <p class="text-white"><br>Ez daude adminsitratzailerik zutaz gain</p>
                                <?php
                            } else {
                                ?>
                                <p><br>Ez daude adminsitratzailerik zutaz gain</p>
                                <?php
                            }
                        } else {
                            ?>
                            <p><br>Ez daude adminsitratzailerik zutaz gain</p>
                            <?php
                        }
                    } else {
                        if ($admin["erabiltzailea"] != $erabiltzailea["erabiltzailea"]) {
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    ?>
                                    <div class="erabiltzailea-admin border-white" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php
                                } else {
                                    ?>
                                    <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                    <?php 
                                }
                            } else {
                                ?>
                                <div class="erabiltzailea-admin" id="<?php echo $admin["id_erabiltzailea"] ?>">
                                <?php
                            }
                                $fitxategia = "media/erabiltzaileak/" . $admin["id_erabiltzailea"] . ".png";
                                if (file_exists($fitxategia)) {
                                    echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                                } else {
                                    echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                                }
                                ?>
                                <p class="divP"><?php echo $admin["erabiltzailea"] ?></p>
                                <div>
                                            <button type="button" class="botoiaEzabatuAdmin"><img src="media/icons/erabiltzailea_admin_ezabatu.svg" alt="Erabiltzailea admin modetik kendu" class="iconoEzabatuAdmin"></button>
                                        </div>
                            </div>
                        <?php
                        }
                    }
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude erabiltzailerik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude erabiltzailerik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude erabiltzailerik</p>
                    <?php
                }
            }
            echo "<br>";

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE rol = 0 AND id_erabiltzailea != " . $erabiltzailea["id_erabiltzailea"];
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=3&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=3&pagination=$i'>";
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