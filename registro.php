<?php
    session_start();

    include("db_konexioa.php");

    $erabiltzailea = null;

    if(!empty($_SESSION['erabiltzailea'])){
        $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = ".$_SESSION['erabiltzailea'];
        $stmt = $pdo->prepare($sqlErabiltzailea);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
    }
?>

<!DOCTYPE html>
<html lang="eu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erregistroa</title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather">
        <link rel="stylesheet" href="assets/style.css">
        <script src="assets/style.js"></script>
        <link rel="shortcut icon" href="media/logo.ico" />

        <script>
            function mostrarVentanaEmergente() {
                var ventanaEmergente = document.getElementById('miVentanaEmergente');
                ventanaEmergente.style.display = 'block';
            }
                
            function ocultarVentanaEmergente() {
                var ventanaEmergente = document.getElementById('miVentanaEmergente');
                ventanaEmergente.style.display = 'none';
                window.location.href = 'login.php';
            }
        </script>
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

            <div class="ventana-emergente" id="miVentanaEmergente">
                <h2>Erregistratu zara!</h2>
                <p>Orain itzaron beharko duzu administratzaileren bat zure erabiltzailea onartzera</p>
                <button onclick="ocultarVentanaEmergente()">Onartu</button>
            </div>
            <?php include("formularioRegistro.php");
            ?>

            <?php
            if (isset($_POST["envio"])) {
                ?>
                <script>window.addEventListener("load", mostrarVentanaEmergente());</script>
                <?php
                $izena = $_POST["izena"];
                $izenaLower = strtolower($izena);

                $abizenak = $_POST["abizenak"];
                $abizenakLower = strtolower($abizenak);

                $telefonoa = $_POST["tfno"];
                
                $helbidea = $_POST["helbidea"];
                $helbideaLower = strtolower($helbidea);

                $deskribapena = $_POST["deskribapena"];
                $deskribapenaLower = strtolower($deskribapena);

                $nan = $_POST["nan"];
                $nanLower = strtolower($nan);

                $adina = $_POST["adina"];
                
                $erabiltzaileIzena = $_POST["erabiltzaileIzena"];
                $erabiltzaileIzenaLower = strtolower($erabiltzaileIzena);

                $pasahitza = $_POST["pasahitza"];

                $pasahitzaRepe = $_POST["pasahitzaRepe"];
                
                $postaElektronikoa = $_POST["email"];
                $postaElektronikoaLower = strtolower($postaElektronikoa);

                $helbidea = $_POST["helbidea"];
                $helbideaLower = strtolower($helbidea);

                $tipo_archivo = $_FILES['image']['type'];
                if (strpos($tipo_archivo, "png")) {
                    $tipoArchivo = "png";
                } else if (strpos($tipo_archivo, "jpeg")) {
                    $tipoArchivo = "jpeg";
                } else if (strpos($tipo_archivo, "jpg")) {
                    $tipoArchivo = "jpg";
                }

                $todoCorrecto = true;

                if (strlen($pasahitza) <= 8 && !preg_match('/^(?=.*[A-Za-z])(?=.*[A-Z]).{9,}$/', $pasahitza)) {
                    $todoCorrecto = false;
                }

                if ($pasahitza != $pasahitzaRepe) {
                    $todoCorrecto = false;
                }

                if (!preg_match('/^[0-9]+$/', $adina)) {
                    $todoCorrecto = false;
                } else if (intval($adina) <= 15) {
                    $todoCorrecto = false;
                }

                if (strlen($telefonoa) != 0) {
                    if (!preg_match('/^[0-9]+$/', $telefonoa) && strlen($telefonoa) != 9) {
                        $todoCorrecto = false;
                    }
                }

                if (!filter_var($postaElektronikoa, FILTER_VALIDATE_EMAIL)) {
                    $todoCorrecto = false;
                }

                if (preg_match('/^\d{8}[A-Za-z]$/', $nan)) {
                    $numero = substr($nan, 0, 8);
                    $letra = strtoupper(substr($nan, 8, 1));

                    $letras_permitidas = "TRWAGMYFPDXBNJZSQVHLCKE";
                    $indice = $numero % 23;

                    if ($letra !== $letras_permitidas[$indice]) {
                        $todoCorrecto = false;
                    }
                } else {
                    $todoCorrecto = false;
                }

                if ($todoCorrecto) {

                    //ERABILTZAILE IZENA ERABILITA BADAGO KONPROBATUKO DUGU
                    $sql1 = "SELECT * FROM erabiltzaileak WHERE erabiltzailea = '$erabiltzaileIzena'";

                    $stmt1 = $pdo->query($sql1);

                    //POSTA ELEKTRONIKOA ERABILITA BADAGO KONPROBATUKO DUGU
                    $sqlEmail = "SELECT * FROM erabiltzaileak WHERE posta_elektronikoa = '$postaElektronikoaLower'";

                    $stmtEmail = $pdo->query($sqlEmail);

                    if ($stmt1->rowCount() > 0) {
                        include("formularioRegistro.php");
                        echo "<script>document.getElementById('textUsuario').style.border = '2px solid red';</script>";
                        echo "<script>document.getElementById('textoErrorNombre').style.display = 'inline-block';</script>";
                    } else if ($stmtEmail->rowCount() > 0) {
                        include("formularioRegistro.php");
                        echo "<script>document.getElementById('textEmail').style.border = '2px solid red';</script>";
                        echo "<script>document.getElementById('textoErrorEmail').innerHTML = 'Sartutako email-a erabilita dago';</script>";
                        echo "<script>document.getElementById('textoErrorEmail').style.display = 'inline-block';</script>";
                    } else {
                        try {

                            $hashedPassword = hash('sha512', $pasahitza);

                            //ERABILTZAILEA DATU BASEAN SARTZEN DUGU
                            $sql = "INSERT INTO `erabiltzaileak` (`erabiltzailea`, `posta_elektronikoa`, `pasahitza`, `izena`, `abizena`, `nan`, `adina`, `extensioa`, `deskribapena`, `telefonoa`, `kokapena`, `rol`, `egiaztatua`) VALUES
                            ('$erabiltzaileIzenaLower', '$postaElektronikoaLower', '$hashedPassword', '$izenaLower', '$abizenakLower', 
                            '$nanLower', '$adina', NULL, '$deskribapenaLower', '$telefonoa', '$helbideaLower', 1, 0)";
            
                            $stmt = $pdo->prepare($sql);
            
                            $stmt->execute();

                            //HEMEN KARGATZEN DUTEN ARGAZKIA GORDEKO DUGU

                            $sqlImage = "SELECT `id_erabiltzailea` FROM erabiltzaileak WHERE erabiltzailea = '$erabiltzaileIzena'";

                            $stmtImage = $pdo->query($sqlImage);

                            $stmtImage->execute();

                            $resultado = $stmtImage->fetchColumn();

                            $carpetaDestino = 'media\erabiltzaileak/';

                            $nombreUnico = $resultado . "." . $tipoArchivo;

                            $rutaTemporal = $_FILES['image']['tmp_name'];

                            move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreUnico);
            
                        } catch (Exception $e) {
                            echo "<a href='registro.php'>Errore bat gertatu da, saiatu berriz</a>";
                        }

                        }

                } else {
                    include("formularioRegistro.php");
                    echo "<h3 style='color: red;'>DATUAK ONDO BETE MESEDEZ!</h3>";
                }
            }
            ?>
                
            <script>window.addEventListener("load", inicioMenu);</script>
        </div>
            <?php
                include("footer.php");
            ?>
    </body>
</html>