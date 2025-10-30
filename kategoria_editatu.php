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

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoria Editatu</title>
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
       <?php include 'menu.php'; ?>
        <div>
            <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
            <?php 
            if ($erabiltzailea != null && $erabiltzailea["rol"] == 0) {
                if ($id != null) {
                    $sqlKategoria = "SELECT * FROM kategoria WHERE id_kategoria = :id_kategoria";
                    $stmt = $pdo->prepare($sqlKategoria);
                    $stmt->bindParam(':id_kategoria', $id);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $kategoria = $stmt->fetch();
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    ?>
                                    <form method="post" enctype="multipart/form-data" class="formAdminDivOscuro">
                                    <?php
                                } else {
                                    ?>
                                    <form method="post" enctype="multipart/form-data">
                                    <?php
                                }
                            } else {
                                ?>
                                <form method="post" enctype="multipart/form-data">
                                <?php
                            }
                        ?>
                        
                            <label for="izena">Izena:</label><br>
                            <input type="text" id="izena" name="izena" maxLength="20" value="<?php echo $kategoria["izena"] ?>" required><br>
                            <span id="izenaError" class="errorForm"></span><br>
                            <div class="kategoriaEditDiv">
                                <label for="ikonoaAld">Ikonoa aldatu nahi duzu? Gogoratu klikatzean aurreko ikonoa aldatuko dela.</label>
                                <div>
                                    <input type="checkbox" id="ikonoaAld" name="ikonoaAld" value="false" class="checkboxKat">
                                    <p>Bai</p>
                                </div>
                            </div>
                            <label id="ikonoaLabel" for="ikonoa" style="display: none;">Ikonoa:</label><br>
                            <input type="file" id="ikonoa" name="ikonoa" class="irudia" accept=".svg" style="display: none;"><br>
                            <span id="ikonoaError" class="errorForm"></span><br>
                            <input type="submit" name="bidali" id="bidali" value="Bidali" class="gaitzekoBotoiakOndo">
                        </form>
                        <?php
                    } else {
                        echo "<p>Errorea kategoria bilatzean</p>";
                    }
                } else {
                    echo "<p>Errorea kategoria bilatzean</p>";
                }
            } else {
                header("Location: index.php");
            }
            ?>
            

            <?php
            if (isset($_POST["bidali"])) {
                $izena = null;
                if (!empty($_POST["izena"])) {
                    $izena = $_POST["izena"];
                }

                $ikonoa = null;
                if (!empty($_FILES["ikonoa"])) {
                    $ikonoa = true;
                } else {
                    $ikonoa = false;
                }

                $ikonoaAldatu = null;
                if (!empty($_POST["ikonoaAld"])) {
                    $ikonoaAldatu = true;
                } else {
                    $ikonoaAldatu = false;
                }

                if ($ikonoaAldatu) {
                    if (validatuText($izena, "izena", 20) && validarImg($ikonoa, "ikonoa")) {
                        $idKategoria = kategoriaEditatu($izena);
                        argazkiaIgoKategoria($idKategoria);
                        irten();
                    }
                } else {
                    if (validatuText($izena, "izena", 20)) {
                        kategoriaEditatu($izena);
                        irten();
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
                }
            }

            function validarImg($ikonoa, $balioa) {
                if ($balioa == "ikonoa") {
                    echo "<script>";
                    echo "irudia = document.getElementById('ikonoa');";
                    echo "spanIrudia = document.getElementById('ikonoaError');";
                    if ($ikonoa == true) {
                        $tipo_archivo = $_FILES["ikonoa"]['type'];
                        echo "console.log('" . $tipo_archivo . "');";
                        if (!strpos($tipo_archivo, "svg")) {
                            echo "irudia.style.border = '2px solid red';";
                            echo "mensajeError(spanIrudia, 'Irudiak .svg luzapena izan behar du');";
                            echo "irudia.focus();";
                            echo "</script>";
                            return false;
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

            function kategoriaEditatu($izena) {
                include("db_konexioa.php");

                $sqlBilatu = "SELECT * FROM kategoria WHERE id_kategoria = :id";
                $stmt = $pdo->prepare($sqlBilatu);
                $stmt->bindParam(':id', $_GET["id"]);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $izena = strtolower($izena);
                    $sqlKategoria = "UPDATE kategoria SET izena = :izena WHERE id_kategoria = :id";
                    $stmt = $pdo->prepare($sqlKategoria);
                    $stmt->bindParam(':izena', $izena);
                    $stmt->bindParam(':id', $_GET["id"]);
                    $stmt->execute();
                    return $_GET["id"];
                } else {
                    return false;
                }

            }

            function argazkiaIgoKategoria($id) {
                $nombre_archivo = "media/kategoriak/" . $id . ".svg";
                if (move_uploaded_file($_FILES["ikonoa"]['tmp_name'],  $nombre_archivo)){
                    return true;
                } else {
                    return false;
                }
            }

            function irten() {
                header("Location: adminpage.php?id=6");
            }

            ?>
        </div>
    </div>

    <script>

        window.addEventListener("load", inicioKatEdit, false);

        function inicioKatEdit() {
            let botoia = document.getElementById("bidali");
            botoia.addEventListener("click", validatuKatEdit, false);
            
            let ikonoaAldatu = document.getElementById("ikonoaAld");
            ikonoaAldatu.addEventListener("change", ikonoaAldatuF, false);
        }

        function validatuKatEdit(e) {
            let izena = document.getElementById("izena");
            let izenaError = document.getElementById("izenaError");
            let ikonoa = document.getElementById("ikonoa");
            let ikonoaError = document.getElementById("ikonoaError");

            if (validaText(izena, izenaError) && validarImgSvg(ikonoa, ikonoaError)) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        }

        function ikonoaAldatuF() {
            let ikonoaAldatu = document.getElementById("ikonoaAld");
            let ikonoa = document.getElementById("ikonoa");
            let ikonoaLabel = document.getElementById("ikonoaLabel");
            let ikonoaError = document.getElementById("ikonoaError");
            if (ikonoaAldatu.checked) {
                ikonoaLabel.style.display = "block";
                ikonoa.style.display = "block";
                ikonoa.required = true;
            } else {
                ikonoaLabel.style.display = "none";
                ikonoa.style.display = "none";
                ikonoa.required = false;
            }
        }

        function validarImgSvg(elemento, span) {
            if (!elemento.checkValidity()) {
                if (elemento.validity.valueMissing) {
                    elemento.style.border = "2px solid red";
                    mensajeError(span, "Eremu hau ezin da hutsik egon");
                    elemento.focus();
                }

                return false;
            }

            if (elemento.files.length > 0) {
                for(let i = 0; i < elemento.files.length; i++) {
                    let extension = elemento.files[i].name.substring(elemento.files[i].name.lastIndexOf('.') + 1).toLowerCase();
                    if (extension != "svg") {
                        elemento.style.border = "2px solid red";
                        mensajeError(span, "Irudiak .svg luzapena izan behar du");
                        elemento.focus();
                        return false;
                    }
                }
            }

            span.innerHTML = "";
            return true;
        }

        function goBack() {
            location.href = "adminpage.php?id=6";
        }

        window.addEventListener("load", inicioMenu);
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>