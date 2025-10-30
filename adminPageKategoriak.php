<div class="infoAdmin">
<?php
    if (isset($_COOKIE["dark"])) {
            if ($_COOKIE["dark"] == "on") {
                ?>
                <h3 class="text-white">Kategoriak</h3>
                <div class="icon-container">
                    <img src="media/icons/info.svg" alt="Información" id="info-icon" class="bilatuIcon">
                </div>
                <?php
            } else {
                ?>
                <h3>Kategoriak</h3>
                <div class="icon-container">
                    <img src="media/icons/info.svg" alt="Información" id="info-icon">
                </div>
                <?php
            }
    } else {
        ?>
        <h3>Kategoriak</h3>
        <div class="icon-container">
            <img src="media/icons/info.svg" alt="Información" id="info-icon">
        </div>
        <?php
    }
    ?>
</div>
<?php
if ($id == 6) { // Nabegazioa
    ?>
    <form method="get">
        <div class="search-container">
            <input type="hidden" name="id" value="6">
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
            $sqlKategoriak = "SELECT * FROM kategoria WHERE izena LIKE '%$bilatu%' ORDER BY id_kategoria ASC LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlKategoriak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $kategoriak = $stmt->fetchAll();
                foreach ($kategoriak as $kategoria) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="kategoria-admin border-white" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                        <?php
                    }
                        $fitxategia = "media/kategoriak/" . $kategoria["id_kategoria"] . ".svg";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgKategoria' src='" . $fitxategia . "' alt='" . $kategoria["izena"] . "'>";
                        } else {
                            echo "<img class='imgKategoria' src='media/kategoriak/kategoriak.svg' alt='" . $kategoria["izena"] . "'>";
                        }
                        ?>
                        <p><?php echo ucfirst($kategoria["izena"]) ?></p>
                        <div>
                            <button type="button" class="botoiaEditKategoria"><img src="media/icons/edit.svg" alt="Kategoria Editatuta" class="iconoEditKategoria"></button>
                            <button type="button" class="botoiaKategoriaKendu"><img src="media/icons/close.svg" alt="Kategoria Kendu" class="iconoKategoriaKendu"></button>
                        </div>
                    </div>
                <?php
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude kategoriarik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude kategoriarik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude kategoriarik</p>
                    <?php
                }
            }
            echo "<br>";
        
            $sqlTotala = "SELECT * FROM kategoria";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);
        
            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=6&pagination=$i&bilatu=$bilatu'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        } else {
            // Testua utzik egotean
            $bakoitzeko = 10;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlKategoriak = "SELECT * FROM kategoria ORDER BY id_kategoria ASC LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlKategoriak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $kategoriak = $stmt->fetchAll();
                foreach ($kategoriak as $kategoria) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="kategoria-admin border-white" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                        <?php
                    }
                        $fitxategia = "media/kategoriak/" . $kategoria["id_kategoria"] . ".svg";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgKategoria' src='" . $fitxategia . "' alt='" . $kategoria["izena"] . "'>";
                        } else {
                            echo "<img class='imgKategoria' src='media/kategoriak/kategoriak.svg' alt='" . $kategoria["izena"] . "'>";
                        }
                        ?>
                        <p><?php echo ucfirst($kategoria["izena"]) ?></p>
                        <div>
                            <button type="button" class="botoiaEditKategoria"><img src="media/icons/edit.svg" alt="Kategoria Editatuta" class="iconoEditKategoria"></button>
                            <button type="button" class="botoiaKategoriaKendu"><img src="media/icons/close.svg" alt="Kategoria Kendu" class="iconoKategoriaKendu"></button>
                        </div>
                    </div>
                <?php
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude kategoriarik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude kategoriarik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude kategoriarik</p>
                    <?php
                }
            }
            echo "<br>";
        
            $sqlTotala = "SELECT * FROM kategoria";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);
        
            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=6&pagination=$i'>";
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
            // Testua bilatu bada
            $bilatu = $_GET["bilatu"];
            $bakoitzeko = 10;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlKategoriak = "SELECT * FROM kategoria WHERE izena LIKE '%$bilatu%' ORDER BY id_kategoria ASC LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlKategoriak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $kategoriak = $stmt->fetchAll();
                foreach ($kategoriak as $kategoria) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="kategoria-admin border-white" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                        <?php
                    }
                        $fitxategia = "media/kategoriak/" . $kategoria["id_kategoria"] . ".svg";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgKategoria' src='" . $fitxategia . "' alt='" . $kategoria["izena"] . "'>";
                        } else {
                            echo "<img class='imgKategoria' src='media/kategoriak/kategoriak.svg' alt='" . $kategoria["izena"] . "'>";
                        }
                        ?>
                        <p><?php echo ucfirst($kategoria["izena"]) ?></p>
                        <div>
                            <button type="button" class="botoiaEditKategoria"><img src="media/icons/edit.svg" alt="Kategoria Editatuta" class="iconoEditKategoria"></button>
                            <button type="button" class="botoiaKategoriaKendu"><img src="media/icons/close.svg" alt="Kategoria Kendu" class="iconoKategoriaKendu"></button>
                        </div>
                    </div>
                <?php
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude kategoriarik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude kategoriarik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude kategoriarik</p>
                    <?php
                }
            }
            echo "<br>";
        
            $sqlTotala = "SELECT * FROM kategoria";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);
        
            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i&bilatu=$bilatu'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i&bilatu=$bilatu'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=6&pagination=$i&bilatu=$bilatu'>";
                    echo "<div>";
                    echo $i;
                    echo "</div>";
                    echo "</a>";
                }
            }
            echo "</div>";
        } else {
            // Testua ez bada bilatu
            $bakoitzeko = 10;
            $inicioPag = ($pagination - 1) * $bakoitzeko;
            $sqlKategoriak = "SELECT * FROM kategoria ORDER BY id_kategoria ASC LIMIT $inicioPag, $bakoitzeko";
            $stmt = $pdo->prepare($sqlKategoriak);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $kategoriak = $stmt->fetchAll();
                foreach ($kategoriak as $kategoria) {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <div class="kategoria-admin border-white" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php
                        } else {
                            ?>
                            <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                            <?php 
                        }
                    } else {
                        ?>
                        <div class="kategoria-admin" id="<?php echo $kategoria["id_kategoria"] ?>">
                        <?php
                    }
                        $fitxategia = "media/kategoriak/" . $kategoria["id_kategoria"] . ".svg";
                        if (file_exists($fitxategia)) {
                            echo "<img class='imgKategoria' src='" . $fitxategia . "' alt='" . $kategoria["izena"] . "'>";
                        } else {
                            echo "<img class='imgKategoria' src='media/kategoriak/kategoriak.svg' alt='" . $kategoria["izena"] . "'>";
                        }
                        ?>
                        <p><?php echo ucfirst($kategoria["izena"]) ?></p>
                        <div>
                            <button type="button" class="botoiaEditKategoria"><img src="media/icons/edit.svg" alt="Kategoria Editatuta" class="iconoEditKategoria"></button>
                            <button type="button" class="botoiaKategoriaKendu"><img src="media/icons/close.svg" alt="Kategoria Kendu" class="iconoKategoriaKendu"></button>
                        </div>
                    </div>
                <?php
                }
            } else {
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <p class="text-white"><br>Ez daude kategoriarik</p>
                        <?php
                    } else {
                        ?>
                        <p><br>Ez daude kategoriarik</p>
                        <?php
                    }
                } else {
                    ?>
                    <p><br>Ez daude kategoriarik</p>
                    <?php
                }
            }
            echo "<br>";
        
            $sqlTotala = "SELECT * FROM kategoria";
            $stmt = $pdo->prepare($sqlTotala);
            $stmt->execute();
            $totala = $stmt->rowCount();
            $totala = ceil($totala / $bakoitzeko);
        
            echo "<div class='pagination'>";
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i'>";
                        echo "<div class='pag-border-white'>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    for ($i = 1; $i <= $totala; $i++) {
                        echo "<a href='adminpage.php?id=6&pagination=$i'>";
                        echo "<div>";
                        echo $i;
                        echo "</div>";
                        echo "</a>";
                    }
                }
            } else {
                for ($i = 1; $i <= $totala; $i++) {
                    echo "<a href='adminpage.php?id=6&pagination=$i'>";
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