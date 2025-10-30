<div class="infoAdmin">
    <?php
    if (isset($_COOKIE["dark"])) {
            if ($_COOKIE["dark"] == "on") {
                ?>
                <h3 class="text-white">Gaitzeko Erabiltzaileak</h3>
                <div class="icon-container">
                    <img src="media/icons/info.svg" alt="Información" id="info-icon" class="bilatuIcon">
                </div>
                <?php
            } else {
                ?>
                <h3>Gaitzeko Erabiltzaileak</h3>
                <div class="icon-container">
                    <img src="media/icons/info.svg" alt="Información" id="info-icon">
                </div>
                <?php
            }
    } else {
        ?>
        <h3>Gaitzeko Erabiltzaileak</h3>
        <div class="icon-container">
            <img src="media/icons/info.svg" alt="Información" id="info-icon">
        </div>
        <?php
    }
    ?>
</div>
<?php
if ($id == 2) { // Nabegazioa
?>
    <form method="get">
        <div class="search-container">
            <input type="hidden" name="id" value="2">
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
            $sqlErabiltzaileak = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0 AND erabiltzailea LIKE '%$bilatu%' LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlErabiltzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $erabiltzaileak = $stmt->fetchAll();
                foreach ($erabiltzaileak as $erab) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="erabiltzailea-admin border-white" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                        <?php
                    }
                        $fitxategia = "media/erabiltzaileak/" . $erab["id_erabiltzailea"] . ".png";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                        } else {
                            echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                        }
                        ?>
                        <p class="divP"><?php echo $erab["erabiltzailea"] ?></p>
                        <div>
                            <button type="button" class="botoiakOndo"><img src="media/icons/check.svg" alt="check" class="iconoOndo"></button>
                            <button type="button" class="botoiakTxarto"><img src="media/icons/close.svg" alt="close" class="iconoTxarto"></button>
                        </div>
                    </div>
                <?php
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

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0 AND erabiltzailea LIKE '%$bilatu%'";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=2&pagination=$i&bilatu=$bilatu'>";
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
            $sqlErabiltzaileak = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0 LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlErabiltzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $erabiltzaileak = $stmt->fetchAll();
                foreach ($erabiltzaileak as $erab) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="erabiltzailea-admin border-white" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                        <?php
                    }
                        $fitxategia = "media/erabiltzaileak/" . $erab["id_erabiltzailea"] . ".png";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                        } else {
                            echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                        }
                        ?>
                        <p class="divP"><?php echo $erab["erabiltzailea"] ?></p>
                        <div>
                            <button type="button" class="botoiakOndo"><img src="media/icons/check.svg" alt="check" class="iconoOndo"></button>
                            <button type="button" class="botoiakTxarto"><img src="media/icons/close.svg" alt="close" class="iconoTxarto"></button>
                        </div>
                    </div>
                <?php
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

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=2&pagination=$i'>";
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
            $sqlErabiltzaileak = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0 AND erabiltzailea LIKE '%$bilatu%' LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlErabiltzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $erabiltzaileak = $stmt->fetchAll();
                foreach ($erabiltzaileak as $erab) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="erabiltzailea-admin border-white" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                        <?php
                    }
                        $fitxategia = "media/erabiltzaileak/" . $erab["id_erabiltzailea"] . ".png";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                        } else {
                            echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                        }
                        ?>
                        <p class="divP"><?php echo $erab["erabiltzailea"] ?></p>
                        <div>
                            <button type="button" class="botoiakOndo"><img src="media/icons/check.svg" alt="check" class="iconoOndo"></button>
                            <button type="button" class="botoiakTxarto"><img src="media/icons/close.svg" alt="close" class="iconoTxarto"></button>
                        </div>
                    </div>
                <?php
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

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0 AND erabiltzailea LIKE '%$bilatu%'";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=2&pagination=$i&bilatu=$bilatu'>";
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
            $sqlErabiltzaileak = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0 LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlErabiltzaileak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $erabiltzaileak = $stmt->fetchAll();
                foreach ($erabiltzaileak as $erab) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="erabiltzailea-admin border-white" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="erabiltzailea-admin" id="<?php echo $erab["id_erabiltzailea"] ?>">
                        <?php
                    }
                        $fitxategia = "media/erabiltzaileak/" . $erab["id_erabiltzailea"] . ".png";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgBorobila divImg' src='" . $fitxategia . "' alt='profila'>";
                        } else {
                            echo "<img class='imgBorobila divImg' src='media/erabiltzaileak/perfil.png' alt='profila'>";
                        }
                        ?>
                        <p class="divP"><?php echo $erab["erabiltzailea"] ?></p>
                        <div>
                            <button type="button" class="botoiakOndo"><img src="media/icons/check.svg" alt="check" class="iconoOndo"></button>
                            <button type="button" class="botoiakTxarto"><img src="media/icons/close.svg" alt="close" class="iconoTxarto"></button>
                        </div>
                    </div>
            <?php
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

            $sqlTotala = "SELECT * FROM erabiltzaileak WHERE egiaztatua = 0";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);

            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=2&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=2&pagination=$i'>";
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