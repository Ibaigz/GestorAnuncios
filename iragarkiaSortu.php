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
    <title>Iragarkia Sortu</title>
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
                            <h1 class="text-white">Erabiltzaile batekin sartu behar zara iragarki bat sortzeko</h1>
                            <?php
                        } else {
                            ?>
                            <h1>Erabiltzaile batekin sartu behar zara iragarki bat sortzeko</h1>
                            <?php
                        }
                    } else {
                        ?>
                        <h1>Erabiltzaile batekin sartu behar zara iragarki bat sortzeko</h1>
                        <?php
                    }
                    ?>
                    
                    <?php
                } else {
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <form class="formProba testuaIragarkiaDivOscuro" method="post" enctype="multipart/form-data">
                            <?php
                        } else {
                            ?>
                            <form class="formProba" method="post" enctype="multipart/form-data">
                            <?php
                        }
                    } else {
                        ?>
                        <form class="formProba" method="post" enctype="multipart/form-data">
                        <?php
                    }
                    ?>
                    
                    
                        <h1>Iragarkia Sortu</h1>
                        <hr>
                        <label for="izena">Izena: </label>
                        <input class="input-IraSor" type="text" id="izena" name="izena" maxLength="50" required>
                        <span id="izenaError" class="errorForm"></span>
                        <label for="deskribapena">Deskribapena: </label>
                        <textarea id="deskribapena" name="deskribapena" rows="4" cols="50" maxlength="200"></textarea>
                        <span id="deskribapenaError" class="errorForm"></span>
                        <div class="divPrezioa">
                            <div>
                                <label for="prezioa">Prezioa: </label>
                                <input type="text" id="prezioa" name="prezioa" pattern="^(?=.*[0-9])[0-9]*[.,]?[0-9]{1,2}$">
                            </div>
                            <div>
                                <label for="bidalketa">Bidalketa: </label>
                                <input class="input-irasor" type="checkbox" id="bidalketa" name="bidalketa">Bai?
                            </div>
                        </div>
                        <div class="divPrezioa">
                            <div>
                                <span id="prezioaError" class="errorForm"></span>
                            </div>
                            <div></div>
                        </div>
        
                        <label for="kategoria">Kategoria: </label>
                        <select name="kategoria" id="kategoria" class="selectKat">
                            <?php
                                $sqlKategoria = "SELECT * FROM kategoria";
                                $stmt = $pdo->prepare($sqlKategoria);
                                $stmt->execute();
                                $kategoria = $stmt->fetchAll();
        
                                foreach($kategoria as $kat) {
                                    // primera letra en mayuscula
                                    $kat["izena"] = ucfirst($kat["izena"]);
                                    echo "<option value='" . $kat["id_kategoria"] . "'>" . $kat["izena"] . "</option>";
                                }
                            ?>
                        </select>
                        <span id="kategoriaError" class="errorForm"></span>
                        <span id="kokapenaError" class="errorForm"></span>
                        <label for="ekitaldiak">Ekitaldiak: </label>
                        <div class="divEkitaldiak">
                            <div>
                                <input class="input-irasor" type="radio" name="ekitaldiak" value="1" >Bai
                            </div>
                            <div>
                                <input class="input-irasor" type="radio" name="ekitaldiak" value="0" checked>Ez
                            </div>
                        </div>
                        <div id="datakView" style="display: none;">
                            <label for="data">Data: </label><br>
                            <div class="divDatak">
                                <div>
                                    <label for="data_hasiera">Data hasiera: </label>
                                    <input type="date" id="data_hasiera" name="data_hasiera">
                                    <span id="data_hasieraError" class="errorForm"></span>
                                </div>
                                <div>
                                    <label for="data_bukaera">Data bukaera: </label>
                                    <input type="date" id="data_bukaera" name="data_bukaera">
                                    <span id="data_bukaeraError" class="errorForm"></span>
                                </div>
                            </div>
                        </div>
                        <label for="irudia">Irudia: </label>
                        <input type="file" id="irudia" name="irudia[]" class="irudia" accept=".png, .jpg, .jpeg" multiple required>
                        <span id="irudiaError" class="errorForm"></span>
                        <div class="iragarkiaGaitu">
                            <input type="submit" name="sortu" id="sortu" value="Sortu" class="botoiak text-uppercase">
                            <input type="reset" name="reset" id="ezabatu" value="Ezabatu" class="gaitzekoBotoiakTxarto text-uppercase">
                        </div>
        
                    </form>
                    <?php
                }

                if (isset($_POST["sortu"])) {
                    $izena = null;
                    if (!empty($_POST["izena"])) {
                        $izena = $_POST["izena"];
                    }
                    $deskribapena = null;
                    if (!empty($_POST["deskribapena"])) {
                        $deskribapena = $_POST["deskribapena"];
                    }
                    $prezioa = null;
                    if (!empty($_POST["prezioa"])) {
                        $prezioa = $_POST["prezioa"];
                    }
                    $bidalketa = false;
                    if (!empty($_POST["bidalketa"])) {
                        $bidalketa = true;
                    }
                    $kategoria = null;
                    if (!empty($_POST["kategoria"])) {
                        $kategoria = $_POST["kategoria"];
                    }
                    $kokapena = null;
                    if (!empty($_POST["kokapena"])) {
                        $kokapena = $_POST["kokapena"];
                    }
                    $ekitaldiak = null;
                    if (!empty($_POST["ekitaldiak"])) {
                        $ekitaldiak = $_POST["ekitaldiak"];
                    }
                    $dataHasiera = null;
                    if (!empty($_POST["data_hasiera"])) {
                        $dataHasiera = $_POST["data_hasiera"];
                    }
                    $dataBukaera = null;
                    if (!empty($_POST["data_bukaera"])) {
                        $dataBukaera = $_POST["data_bukaera"];
                    }
                    $irudia = null;
                    if (!empty($_FILES["irudia"])) {
                        $irudia = count($_FILES["irudia"]["name"]);
                    }

                    if ($ekitaldiak) {
                        if (validatuText($izena, "izena", 50) && validatuText($deskribapena, "deskribapena", 200) && floatTextValidatu($prezioa, "prezioa") && validarKategoria($kategoria) && validatuText($kokapena, "kokapena", 100) && validatuDatak($dataHasiera, "data_hasiera") && validatuDatak($dataBukaera, "data_bukaera") && validatuDatakKomp($dataHasiera, $dataBukaera) && validarImg($irudia, "irudia")) {
                            $id = igoIragarkia($izena, $deskribapena, $prezioa, $bidalketa, $kategoria, $kokapena, $dataHasiera, $dataBukaera);
                            argazkiakIgo($irudia, $id);
                            // denaEzabatu();
                        } else {
                            echo "<script>console.log('Errorea 1');</script>";
                        }

                    } else {
                        if (validatuText($izena, "izena", 50) && validatuText($deskribapena, "deskribapena", 200) && floatTextValidatu($prezioa, "prezioa") && validarKategoria($kategoria) && validatuText($kokapena, "kokapena", 100) && validarImg($irudia, "irudia")) {
                            $id = igoIragarkia($izena, $deskribapena, $prezioa, $bidalketa, $kategoria, $kokapena);
                            echo "<script>console.log('Id: " . $id . "');</script>";
                            argazkiakIgo($irudia, $id);
                            // denaEzabatu();
                        } else {
                            echo "<script>console.log('Errorea 2');</script>";
                        }
                    }
                }

                function validatuText($elementua, $balioa, $luzeera) {
                    if ($balioa == "izena") {
                        echo "<script>";
                        echo "iz = document.getElementById('izena');";
                        echo "spanIz = document.getElementById('izenaError');";
                        if ($elementua == null) {
                            echo "iz.style.border = '2px solid red';";
                            echo "mensajeError(spanIz, 'Eremu hau ezin da hutsik egon');";
                            echo "iz.focus();";
                            echo "</script>";
                            return false;
                        } else if (strlen($elementua) > $luzeera) {
                            echo "iz.style.border = '2px solid red';";
                            echo "mensajeError(spanIz, 'Eremu hau luzeegia da');";
                            echo "iz.focus();";
                            echo "</script>";
                            return false;
                        } else {
                            echo "iz.style.border = ' ';";
                            echo "mensajeError(spanIz, ' ');";
                            echo "</script>";
                            return true;
                        }
                    } else if ($balioa == "deskribapena") {
                        echo "<script>";
                        echo "desk = document.getElementById('deskribapena');";
                        echo "spanDesk = document.getElementById('deskribapenaError');";
                        if (strlen($elementua) > $luzeera) {
                            echo "desk.style.border = '2px solid red';";
                            echo "mensajeError(spanDesk, 'Eremu hau luzeegia da');";
                            echo "desk.focus();";
                            echo "</script>";
                            return false;
                        } else {
                            echo "desk.style.border = '  ';";
                            echo "mensajeError(spanDesk, ' ');";
                            echo "</script>";
                            return true;
                        }
                    } else if ($balioa == "kokapena") {
                        echo "<script>";
                        echo "kok = document.getElementById('kokapena');";
                        echo "spanKok = document.getElementById('kokapenaError');";
                        if (strlen($elementua) > $luzeera) {
                            echo "kok.style.border = '2px solid red';";
                            echo "mensajeError(spanKok, 'Eremu hau luzeegia da');";
                            echo "kok.focus();";
                            echo "</script>";
                            return false;
                        } else {
                            echo "kok.style.border = '  ';";
                            echo "mensajeError(spanKok, ' ');";
                            echo "</script>";
                            return true;
                        }
                    }
                    
                    
                }
                
                function floatTextValidatu($elementua, $balioa) {
                    if ($balioa == "prezioa") {
                        echo "<script>";
                        echo "pre = document.getElementById('prezioa');";
                        echo "spanPre = document.getElementById('prezioaError');";
                        if ($elementua == null) {
                            echo "pre.style.border = '  ';";
                            echo "mensajeError(spanPre, ' ');";
                            echo "</script>";
                            return true;
                        } else if (validarFloat($elementua)) {
                            echo "pre.style.border = '  ';";
                            echo "mensajeError(spanPre, ' ');";
                            echo "</script>";
                            return true;
                        } else {
                            echo "pre.style.border = '2px solid red';";
                            echo "mensajeError(spanPre, 'Zenbakia 0 edo handiagoa izan behar da eta gehienez 2 hamartar onartzen dira');";
                            echo "pre.focus();";
                            echo "</script>";
                            return false;
                        }
                    }
                }

                function validarFloat($zenb) {
                    $patron = "/^(?=.*[0-9])[0-9]*[.,]?[0-9]{1,2}$/";
                    if (preg_match($patron, $zenb)) {
                        return true;
                    } else {
                        return false;
                    }
                }

                function validarKategoria($kategoriaErantzuna) {
                    include ("db_konexioa.php");
                    echo "<script>";
                    echo "kat = document.getElementById('kategoria');";
                    echo "spanKat = document.getElementById('kategoriaError');";

                    if ($kategoriaErantzuna == null) {
                        echo "kat.style.border = '2px solid red';";
                        echo "mensajeError(spanKat, 'Eremu hau ezin da hutsik egon');";
                        echo "kat.focus();";
                        echo "</script>";
                        return false;
                    } else {
                        $sqlkategoriakId = "SELECT * FROM kategoria";
                        $stmt = $pdo->prepare($sqlkategoriakId);
                        $stmt->execute();
                        $kategoriaId = $stmt->fetchAll();
                        $kategoriaEgokia = false;
                        foreach($kategoriaId as $kat) {
                            if ($kat["id_kategoria"] == $kategoriaErantzuna) {
                                $kategoriaEgokia = true;
                            }
                        }
                        if (!$kategoriaEgokia) {
                            echo "kat.style.border = '2px solid red';";
                            echo "mensajeError(spanKat, 'Eremu honetan kateroia bat aukeratu behar duzu');";
                            echo "kat.focus();";
                            echo "</script>";
                            return false;
                        } else {
                            echo "kat.style.border = '  ';";
                            echo "mensajeError(spanKat, ' ');";
                            echo "</script>";
                            return true;
                        }
                    }
                }

                function validatuDatak($elementua, $balioa) {
                    if ($balioa == "data_hasiera") {
                        echo "<script>";
                        echo "dataHasiera = document.getElementById('data_hasiera');";
                        echo "spanDataHas = document.getElementById('data_hasieraError');";
                        if ($elementua == null) {
                            echo "dataHasiera.style.border = '2px solid red';";
                            echo "mensajeError(spanDataHas, 'Eremu hau ezin da hutsik egon');";
                            echo "dataHasiera.focus();";
                            echo "</script>";
                            return false;
                        } else {
                            echo "dataHasiera.style.border = '  ';";
                            echo "mensajeError(spanDataHas, ' ');";
                            echo "</script>";
                            return true;
                        }
                    } else if ($balioa == "data_bukaera") {
                        echo "<script>";
                        echo "dataBukaera = document.getElementById('data_bukaera');";
                        echo "spanDataBuk = document.getElementById('data_bukaeraError');";
                        if ($elementua == null)  {
                            echo "dataBukaera.style.border = '2px solid red';";
                            echo "mensajeError(spanDataBuk, 'Eremu hau ezin da hutsik egon');";
                            echo "dataBukaera.focus();";
                            echo "</script>";
                            return false;
                        } else {
                            echo "dataBukaera.style.border = '  ';";
                            echo "mensajeError(spanDataBuk, ' ');";
                            echo "</script>";
                            return true;
                        }
                    }
                }

                function validatuDatakKomp($dataHasiera, $dataBukaera) {
                    if ($dataBukaera < $dataHasiera) {
                        echo "<script>";
                        echo "dataHasiera = document.getElementById('data_hasiera');";
                        echo "spanDataHas = document.getElementById('data_hasieraError');";
                        echo "dataBukaera = document.getElementById('data_bukaera');";
                        echo "spanDataBuk = document.getElementById('data_bukaeraError');";
                        echo "dataHasiera.style.border = '2px solid red';";
                        echo "mensajeError(spanDataHas, 'Hasierako data ezin da bukaerako data baino handiagoa izan');";
                        echo "dataBukaera.style.border = '2px solid red';";
                        echo "mensajeError(spanDataBuk, 'Bukaerako data ezin da hasierakoa baino txikiagoa izan');";
                        echo "dataBukaera.focus();";
                        echo "</script>";
                        return false;
                    } else {
                        echo "<script>";
                        echo "dataHasiera = document.getElementById('data_hasiera');";
                        echo "spanDataHas = document.getElementById('data_hasieraError');";
                        echo "dataBukaera = document.getElementById('data_bukaera');";
                        echo "spanDataBuk = document.getElementById('data_bukaeraError');";
                        echo "dataHasiera.style.border = '  ';";
                        echo "mensajeError(spanDataHas, ' ');";
                        echo "dataBukaera.style.border = '  ';";
                        echo "mensajeError(spanDataBuk, ' ');";
                        echo "</script>";
                        return true;
                    }
                }

                function validarImg($irudiak, $balioa) {
                    if ($balioa == "irudia") {
                        echo "<script>";
                        echo "irudia = document.getElementById('irudia');";
                        echo "spanIrudia = document.getElementById('irudiaError');";
                        if ($irudiak > 0) {
                            for($i = 0; $i < $irudiak; $i++) {
                                $tipo_archivo = $_FILES["irudia"]['type'][$i];
                                echo "console.log('" . $tipo_archivo . "');";
                                if (strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg")) {
                                    
                                } else {
                                    echo "irudia.style.border = '2px solid red';";
                                    echo "mensajeError(spanIrudia, 'Irudiak .png, .jpg edo .jpeg luzapena izan behar du');";
                                    echo "irudia.focus();";
                                    echo "</script>";
                                    return false;
                                }
                            }
                            echo "irudia.style.border = ' ';";
                            echo "mensajeError(spanIrudia, ' ');";
                            echo "</script>";
                            return true;
                        } else {
                            echo "irudia.style.border = '2px solid red';";
                            echo "mensajeError(spanIrudia, 'Eremu hau ezin da hutsik egon');";
                            echo "irudia.focus();";
                            echo "</script>";
                            return false;
                        }
                    }
                }

                function igoIragarkia($izena, $deskribapena, $prezioa, $bidalketa, $kategoria_id, $kokapena, $dataHasiera = null, $dataBukaera = null) {
                    include ("db_konexioa.php");

                    $sqlIragarkiakId = "SELECT * FROM iragarkiak";
                    $stmt = $pdo->prepare($sqlIragarkiakId);
                    $stmt->execute();
                    $azkenId = null;
                    if ($stmt->rowCount() > 0) {
                        $sqlIragarkiakId = "SELECT * FROM iragarkiak";
                        $stmt = $pdo->prepare($sqlIragarkiakId);
                        $stmt->execute();
                        $idIragarki = $stmt->fetchAll();
                        if ($stmt->rowCount() == 1) {
                            $azkenId = $idIragarki[0]["id_iragarkia"];
                        } else {
                            for ($i = 0; $i < count($idIragarki); $i++) {
                                if ($i == count($idIragarki) - 1) {
                                    $azkenId = $idIragarki[$i]["id_iragarkia"];
                                }
                            }
                        }
                    }

                    echo "<script>console.log('Proba: " . $azkenId . "');</script>";
                        $sqlIgoIragarkia = "INSERT INTO iragarkiak (id_iragarkia, id_erabiltzailea, izena, deskribapena, prezioa, bidalketa, kategoria_id, kokapena, data_hasiera, data_bukaera, egiaztatua) VALUES (:id_iragarkia, :id_erabiltzailea, :izena, :deskribapena, :prezioa, :bidalketa, :kategoria_id, :kokapena, :data_hasiera, :data_bukaera, :egiaztatua)";
                        $stmt = $pdo->prepare($sqlIgoIragarkia);
                        if ($azkenId == null) {
                            $azkenId = 1;
                            $stmt->bindParam(':id_iragarkia', $azkenId);
                        } else {
                            $azkenId++;
                            $stmt->bindParam(':id_iragarkia', $azkenId);
                        }
                        $stmt->bindParam(':id_erabiltzailea', $_SESSION['erabiltzailea']);
                        $stmt->bindParam(':izena', $izena);
                        $stmt->bindParam(':deskribapena', $deskribapena);
                        if ($prezioa == null) {
                            $prezioa = 0;
                        }
                        $stmt->bindParam(':prezioa', $prezioa);
                        $stmt->bindParam(':bidalketa', $bidalketa);
                        $stmt->bindParam(':kategoria_id', $kategoria_id);
                        $stmt->bindParam(':kokapena', $kokapena);
                        $stmt->bindParam(':data_hasiera', $dataHasiera);
                        $stmt->bindParam(':data_bukaera', $dataBukaera);
                        $stmt->bindValue(':egiaztatua', 0);
                        $stmt->execute();
                        return $azkenId;
                }

                function argazkiakIgo($irudiak, $id) {
                    include ("db_konexioa.php");

                    for ($i = 0; $i < $irudiak; $i++) {
                        $sqlArgazkiak = "SELECT * FROM argazkiak";
                        $stmt = $pdo->prepare($sqlArgazkiak);
                        $stmt->execute();
                        $azkenId = null;
                        if ($stmt->rowCount() > 0) {
                            $sqlArgazkiak = "SELECT * FROM argazkiak";
                            $stmt = $pdo->prepare($sqlArgazkiak);
                            $stmt->execute();
                            $idArgazki = $stmt->fetchAll();
                            if ($stmt->rowCount() == 1) {
                                $azkenId = $idArgazki[0]["id_argazkia"];
                            } else {
                                for ($j = 0; $j < count($idArgazki); $j++) {
                                    if ($j == count($idArgazki) - 1) {
                                        $azkenId = $idArgazki[$j]["id_argazkia"];
                                    }
                                }
                            }
                        }

                        echo "<script>console.log('Argazkia: " . $azkenId . "');</script>";

                        try {
                            $sqlIgoArgazkia = "INSERT INTO argazkiak (id_argazkia, id_iragarkia, extensioa) VALUES (:id_argazkia, :id_iragarkia, :extensioa)";
                            $stmt = $pdo->prepare($sqlIgoArgazkia);
                            if ($azkenId == null) {
                                $azkenId = 1;
                                $stmt->bindParam(':id_argazkia', $azkenId);
                            } else {
                                $azkenId++;
                                $stmt->bindParam(':id_argazkia', $azkenId);
                            }
                            echo "<script>console.log('ArgazkiaId-jarrita: " . $azkenId . "');</script>";
                            $stmt->bindParam(':id_iragarkia', $id);
                            $extension = null;
                            if ($irudiak == 1) {
                                if (strpos($_FILES["irudia"]['type'][0], "png")) {
                                    $extension = "png";
                                    $stmt->bindValue(':extensioa', "png");
                                } else if (strpos($_FILES["irudia"]['type'][0], "jpg")) {
                                    $extension = "jpg";
                                    $stmt->bindValue(':extensioa', "jpg");
                                } else if (strpos($_FILES["irudia"]['type'][0], "jpeg")) {
                                    $extension = "jpeg";
                                    $stmt->bindValue(':extensioa', "jpeg");
                                }
                            } else {
                                if (strpos($_FILES["irudia"]['type'][$i], "png")) {
                                    $extension = "png";
                                    $stmt->bindValue(':extensioa', "png");
                                } else if (strpos($_FILES["irudia"]['type'][$i], "jpg")) {
                                    $extension = "jpg";
                                    $stmt->bindValue(':extensioa', "jpg");
                                } else if (strpos($_FILES["irudia"]['type'][$i], "jpeg")) {
                                    $extension = "jpeg";
                                    $stmt->bindValue(':extensioa', "jpeg");
                                }
                            }
                            $stmt->execute();

                            
                            if (gordeArgazkiak($i, $azkenId, $extension)) {
                                echo "<script>console.log('Argazkia igo da');</script>";
                            } else {
                                echo "<script>console.log('Argazkia ez da igo');</script>";
                            }
                            
                        } catch (Exception $e) {
                            $i--;
                        }
                        
                    }
                }

                function gordeArgazkiak($i, $id, $extension) {
                    $nombre_archivo = "media/iragarkiak/" . $id . "." . $extension;
                    if (move_uploaded_file($_FILES["irudia"]['tmp_name'][$i],  $nombre_archivo)){
                        return true;
                    } else {
                        return false;
                    }
                }

                function denaEzabatu() {
                    echo "<script>";
                    echo "window.location.href='iragarkiaSortu.php'";
                    echo "</script>";
                }

                ?>
            <script>
                window.addEventListener("load", inicioIragarkiaSortu);
                window.addEventListener("load", inicioMenu);
            </script>
        </div>
    </div>
    <br>
    <?php
        include("footer.php");
    ?>
</body>
</html>