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
    <title>Kategoria Sortu</title>
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
            if ($erabiltzailea != null && $erabiltzailea["rol"] == 0) {
                ?>
                <button onclick="goBack()" class="atzeraBotoia">&#8249;</button>
                <?php
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
                    <input type="text" id="izena" name="izena" maxLength="20" required><br>
                    <span id="izenaError" class="errorForm"></span><br>
                    <label for="ikonoa">Ikonoa:</label><br>
                    <input type="file" id="ikonoa" name="ikonoa" class="irudia" accept=".svg" required><br>
                    <span id="ikonoaError" class="errorForm"></span><br>
                    <input type="submit" name="bidali" id="bidali" value="Bidali" class="gaitzekoBotoiakOndo">
                </form>

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

                    if (validatuText($izena, "izena", 20) && validarImg($ikonoa, "ikonoa")) {
                        $idKategoria = kategoriaSortu($izena);
                        argazkiaIgoKategoria($idKategoria);
                        header("Location: adminpage.php?id=6");
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

                function kategoriaSortu($izena) {
                    include("db_konexioa.php");
                    
                    $izena = strtolower($izena);

                    $sqlKategoria = "INSERT INTO kategoria (izena) VALUES (:izena)";
                    $stmt = $pdo->prepare($sqlKategoria);
                    $stmt->bindParam(':izena', $izena);
                    $stmt->execute();
                    $sqlBilatu = "SELECT * FROM kategoria WHERE izena = :izena";
                    $stmt = $pdo->prepare($sqlBilatu);
                    $stmt->bindParam(':izena', $izena);
                    $stmt->execute();
                    $kategoria = $stmt->fetch();
                    $id = $kategoria["id_kategoria"];
                    return $id;

                }

                function argazkiaIgoKategoria($id) {
                    $nombre_archivo = "media/kategoriak/" . $id . ".svg";
                    if (move_uploaded_file($_FILES["ikonoa"]['tmp_name'],  $nombre_archivo)){
                        return true;
                    } else {
                        return false;
                    }
                }
                
            } else {
                header("Location: index.php");
            }
            ?>
        </div>

    </div>

    <script>
        function inicioKatGehitu() {
            let botoia = document.getElementById("bidali");
            botoia.addEventListener("click", validatuKatGehitu(), false);
        }

        function validatuKatGehitu(e) {
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
    <?php
    include("footer.php");
    ?>
</body>
</html>