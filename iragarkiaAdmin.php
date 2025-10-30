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
    <title>Iragarkia Admin</title>
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
                if (!empty($_GET["id"])) {
                    $id = $_GET["id"];
                }

                if ($id != null) {
                    try {
                        $sqlIragarkia = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
                        $stmt = $pdo->prepare($sqlIragarkia);
                        $stmt->bindParam(':id', $id);
                        $stmt->execute();
                        $iragarkia = $stmt->fetch();
        
                        if ($stmt->rowCount() > 0) {
                            if ($iragarkia["egiaztatua"] != 0 || $erabiltzailea["rol"] == 0) {
                                ?>
                                <br>
                                <?php
                                if (isset($_COOKIE["dark"])) {
                                    if ($_COOKIE["dark"] == "on") {
                                        ?>
                                        <nav class="navIragarkiakOscuro">
                                            <ol>
                                                <li class="navIragarkiaOscuro text-white"><a href="adminpage.php?id=4" class="text-white">AdminPage</a></li>
                                                <li class="navIragarkiaOscuro text-white"><?php echo $iragarkia["izena"] ?></li>
                                            </ol>
                                        </nav>
                                        <?php
                                    } else {
                                        ?>
                                        <nav class="navIragarkiak">
                                            <ol>
                                                <li class="navIragarkia"><a href="adminpage.php?id=4">AdminPage</a></li>
                                                <li class="navIragarkia"><?php echo $iragarkia["izena"] ?></li>
                                            </ol>
                                        </nav>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <nav class="navIragarkiak">
                                        <ol>
                                            <li class="navIragarkia"><a href="adminpage.php?id=4">AdminPage</a></li>
                                            <li class="navIragarkia"><?php echo $iragarkia["izena"] ?></li>
                                        </ol>
                                    </nav>
                                    <?php
                                }
                                ?>
                                <br>
                                <div class="iragarkiaDiv">
                                    <div>
                                        <div class="carousel-container">
                                            <?php if ($iragarkia["bidalketa"] == 1) {
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

                                            $sqlArgazkiak = "SELECT * FROM argazkiak WHERE id_iragarkia = :id";
                                            $stmt = $pdo->prepare($sqlArgazkiak);
                                            $stmt->bindParam(':id', $id);
                                            $stmt->execute();
                                            $argazkiak = $stmt->fetchAll();
                                            if ($stmt->rowCount() > 1) {
                                                ?>
                                                <button id="prevBtn" class="carousel-btn">&#8249;</button>
                                                <?php
                                            }
                                            for ($i = 0; $i < count($argazkiak); $i++) {
                                                echo "<div class='carousel-slide'>";
                                                    $fitxategia = "media/iragarkiak/" . $argazkiak[$i]["id_argazkia"] . "." . $argazkiak[$i]["extensioa"];
                                                    if (file_exists($fitxategia)) {
                                                        echo "<img src='$fitxategia' alt='irudia " . $argazkiak[$i]["id_argazkia"] . "' width='100px'>";
                                                    } else {
                                                        echo "<img src='media/iragarkiak/no-image.png' alt='irudia' width='100px'>";
                                                    }
                                                echo "</div>";
                                            }
                        
                                            if ($stmt->rowCount() > 1) {
                                                ?>
                                                <button id="nextBtn" class="carousel-btn">&#8250;</button>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($_COOKIE["dark"])) {
                                        if ($_COOKIE["dark"] == "on") {
                                            ?>
                                            <div class="testuaIragarkiaDiv testuaIragarkiaDivOscuro" id="<?php echo $iragarkia["id_iragarkia"] ?>">
                                            <?php
                                        } else {
                                            ?>
                                            <div class="testuaIragarkiaDiv" id="<?php echo $iragarkia["id_iragarkia"] ?>">
                                            <?php
                                        }
                                        } else {
                                            ?>
                                            <div class="testuaIragarkiaDiv" id="<?php echo $iragarkia["id_iragarkia"] ?>">
                                            <?php
                                        }
                                    ?>
                                        <h1><?php echo $iragarkia["izena"]; ?></h1>
                                        <h3 class="prezioaIragarkia"><?php echo $iragarkia["prezioa"]; ?>€</h3>
                                        <?php if ($iragarkia["deskribapena"] != null && $iragarkia["deskribapena"] != "") echo "<p><b>Deskribapena:</b><br>" . $iragarkia["deskribapena"] . "</p>"; ?>
                                        <?php if ($iragarkia["kokapena"] != null) echo "<p><b>Kokapena:</b><br>" . $iragarkia["kokapena"] . "</p>" ?>
                                        <?php
                                        $kat = $iragarkia["kategoria_id"];
                                        $sqlKategoria = "SELECT * FROM kategoria WHERE id_kategoria = :kat";
                                        $stmt = $pdo->prepare($sqlKategoria);
                                        $stmt->bindParam(':kat', $kat);
                                        $stmt->execute();
                                        $kategoria = $stmt->fetch();
                                        $kategoria["izena"] = ucfirst($kategoria["izena"]);
                                        echo "<p><b>Kategoria: </b></p>";
                                        echo "<div class='kategoriaDivIragarkia'>";
                                        $fitxategiaKategoria = "media/kategoriak/" . $kategoria["id_kategoria"] . ".svg";
                                            if (file_exists($fitxategiaKategoria)) {
                                                echo "<img src='" . $fitxategiaKategoria . "' alt='" . $kategoria["izena"] . "' width='40px'>";
                                            } else {
                                                echo "<img src='media/kategoriak/kategoriak.svg' alt='" . $kategoria["izena"] . "' width='40px'>";
                                            }
                                            echo "<p>" . $kategoria["izena"] . "</p>";
                                        echo "</div>";
                                        ?>
                                        <?php
                                            if ($iragarkia["data_hasiera"] != null) {
                                                echo "<p><b>Erabilgarri: </b><br>" . $iragarkia["data_hasiera"] . " / " . $iragarkia["data_bukaera"] . "</p>";   
                                            }
                                        ?>
                                        <hr>
                                        <div class="iragarkiarenErabiltzailea">
                                            <?php
                                            $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
                                            $stmt = $pdo->prepare($sqlErabiltzailea);
                                            $stmt->bindParam(':id', $iragarkia["id_erabiltzailea"]);
                                            $stmt->execute();
                                            $erabiltzailea = $stmt->fetch();
                                            $fitxategia = "media/erabiltzaileak/" . $erabiltzailea["id_erabiltzailea"] . "." . $erabiltzailea["extensioa"];
                                            if (file_exists($fitxategia)) {
                                                echo "<img src='" . $fitxategia . "' alt='profila' class='imgBorobila'>";
                                            } else {
                                                echo "<img src='media/erabiltzaileak/perfil.png' alt='profila' class='imgBorobila'>";
                                            }
                                            echo "<p class='text-uppercase'>" . $erabiltzailea["erabiltzailea"] . "</p>";
                                            ?>
                                        </div>
                                        <hr>
                                        <?php
                                        if ($iragarkia["egiaztatua"] == 0) {
                                            ?>
                                            <div class='botoiakGaitzekoIragarkiak'>
                                                <button type='button' class='botoiakOndoIragarkia'><img src='media/icons/check.svg' alt='check' class='iconoOndoIragarkia'></button>
                                                <button type='button' class='botoiakTxartoIragarkia'><img src='media/icons/close.svg' alt='close' class='iconoTxartoIragarkia'></button>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class='botoiakGaitzekoIragarkiak' id="<?php echo $iragarkia["id_iragarkia"] ?>">
                                            <button type='button' class='botoiakEzabatuIragarkia'><img src='media/icons/iragarkiaKendu.svg' alt='iragarkia kendu' class='iconoEzabatuIragarkia'></button>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php 
                            } else {
                                echo "<p>Iragarkia ez dago erabilgarri. Administratzaileak konprobatu behar du.</p>";
                            }
                        }
                    } catch (PDOException $e) {
                        echo "Datu basearekin errore bat egon da.";
                    }
                } else {
                    echo "<p>Ez dago iragarkirik.</p>";
                }

            ?>
        </div>
        <br>

        <script>
            window.addEventListener('load', inicioIragarkiaAdmin);
            window.addEventListener('load', inicioIragarkiaAdmin2);

            function inicioIragarkiaAdmin2() {
                let botoiakOndoIragarkia = document.getElementsByClassName("botoiakOndoIragarkia");
                    for (let i = 0; i < botoiakOndoIragarkia.length; i++) {
                        botoiakOndoIragarkia[i].addEventListener("click", gaituIragarkia);
                    }

                    let iconoOndoIragarkia = document.getElementsByClassName("iconoOndoIragarkia");
                    for (let i = 0; i < iconoOndoIragarkia.length; i++) {
                        iconoOndoIragarkia[i].addEventListener("click", gaituIragarkiaImg);
                    }

                    let botoiakTxartoIragarkia = document.getElementsByClassName("botoiakTxartoIragarkia");
                    for (let i = 0; i < botoiakTxartoIragarkia.length; i++) {
                        botoiakTxartoIragarkia[i].addEventListener("click", ezGaituIragarkia);
                    }

                    let iconoTxartoIragarkia = document.getElementsByClassName("iconoTxartoIragarkia");
                    for (let i = 0; i < iconoTxartoIragarkia.length; i++) {
                        iconoTxartoIragarkia[i].addEventListener("click", ezGaituIragarkiaImg);
                    }

                    let botoiakEzabatuIragarkia = document.getElementsByClassName("botoiakEzabatuIragarkia");
                    for (let i = 0; i < botoiakEzabatuIragarkia.length; i++) {
                        botoiakEzabatuIragarkia[i].addEventListener("click", ezabatuIragarkia);
                    }

                    let iconoEzabatuIragarkia = document.getElementsByClassName("iconoEzabatuIragarkia");
                    for (let i = 0; i < iconoEzabatuIragarkia.length; i++) {
                        iconoEzabatuIragarkia[i].addEventListener("click", ezabatuIragarkiaImg);
                    }
            }

            function inicioIragarkiaAdmin() {
                const slides = document.querySelectorAll('.carousel-slide');
                let currentSlide = 0;
        
                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        if (i === index) {
                            slide.style.display = 'block';
                        } else {
                            slide.style.display = 'none';
                        }
                    });
                }
        
                function nextSlide() {
                    currentSlide++;
                    if (currentSlide >= slides.length) {
                        currentSlide = 0;
                    }
                    showSlide(currentSlide);
                }
        
                function prevSlide() {
                    currentSlide--;
                    if (currentSlide < 0) {
                        currentSlide = slides.length - 1;
                    }
                    showSlide(currentSlide);
                }
        
                // Muestra la primera imagen al cargar la página
                showSlide(currentSlide);
        
                // Controladores de eventos para el carrusel
                document.getElementById('prevBtn').addEventListener('click', prevSlide);
                document.getElementById('nextBtn').addEventListener('click', nextSlide);
            }

            window.addEventListener('load', inicioMenu);
        </script>
    </div>

    <?php
        include("footer.php");
    ?>
</body>
</html>
