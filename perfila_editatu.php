<?php
    session_start();

    include("db_konexioa.php");

    $erabiltzailea = null;

    if(!empty($_SESSION['erabiltzailea'])){
        $erabiltzaileaId = $_SESSION['erabiltzailea'];
        $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
        $stmt = $pdo->prepare($sqlErabiltzailea);
        $stmt->bindParam(':erabiltzailea', $erabiltzaileaId);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
    }
?>

<!DOCTYPE html>
<html lang="eu">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfila editatu</title>
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

            <?php 

            $id = $erabiltzailea["id_erabiltzailea"];
            $nombre = $erabiltzailea["izena"];
            $apellido = $erabiltzailea["abizena"];
            $tfno = $erabiltzailea["telefonoa"];
            if($tfno == 0) {
                $tfno = null;
            }
            $email = $erabiltzailea["posta_elektronikoa"];
            $direccion = $erabiltzailea["kokapena"];
            $desc = $erabiltzailea["deskribapena"];

            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <form id="formularioEditarDatos" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formEdit testuaIragarkiaDivOscuro">
                    <?php
                } else {
                    ?>
                    <form id="formularioEditarDatos" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formEdit">
                    <?php
                }
            } else {
                ?>
                <form id="formularioEditarDatos" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formEdit">
                <?php
            }
            ?>
                <h3>Datuak aldatu:</h3><br>
                <label>Izena:</label><br>
                <input type="text" placeholder="<?php echo "$nombre"; ?>" name="nombre"><br><br>
                <label>Abizena:</label><br>
                <input type="text" placeholder="<?php echo "$apellido"; ?>" name="apellido"><br><br>
                <label>Telefonoa:</label><label id="textoErrorTfno" class="errorTextos">Telefono zenbaki egoki bat sartu</label><br>
                <input type="text" id="textTfno" placeholder="<?php echo "$tfno"; ?>" onblur="revisaTfno()" name="telefono"><br><br>
                <label>Helbidea:</label><br>
                <input type="text" placeholder="<?php echo "$direccion"; ?>" name="direccion"><br><br>
                <label>Deskribapena:</label><br>
                <input type="textarea" placeholder="<?php echo "$desc"; ?>" name="descripcion"><br><br>
                <label>Perfil argazkia:</label><br>
                <input type="file" name="image"><br><br>
                <input type="submit" name="envio" value="Datuak gorde" id="btnEdit">
            </form>

            <?php 

            if (isset($_POST["envio"])) {
                $todoCorrecto = true;

                $telefonoa = $_POST["telefono"];
                if (strlen($telefonoa) != 0) {
                    if (!preg_match('/^[0-9]+$/', $telefonoa) && strlen($telefonoa) != 9) {
                        $todoCorrecto = false;
                    }
                }

                $izenBerria = $_POST["nombre"];
                if(strlen($izenBerria) == 0) {
                    $izenBerria = $erabiltzailea["izena"];
                }

                $abizenBerria = $_POST["apellido"];
                if(strlen($abizenBerria) == 0) {
                    $abizenBerria = $erabiltzailea["abizena"];
                }

                $telefonoBerria = $_POST["telefono"];
                if(strlen($telefonoBerria) == 0) {
                    $telefonoBerria = $erabiltzailea["telefonoa"];
                }

                $deskribapenBerria = $_POST["descripcion"];
                if(strlen($deskribapenBerria) == 0) {
                    $deskribapenBerria = $erabiltzailea["deskribapena"];
                }

                $helbideBerria = $_POST["direccion"];
                if(strlen($helbideBerria) == 0) {
                    $helbideBerria = $erabiltzailea["kokapena"];
                }

                $tipo_archivo = $erabiltzailea["extensioa"];

                $tipo_archivo_nuevo = $_FILES['image']['type'];
                if (strpos($tipo_archivo_nuevo, "png")) {
                    $tipoArchivo_nuevo = "png";
                } else if (strpos($tipo_archivo_nuevo, "jpeg")) {
                    $tipoArchivo_nuevo = "jpeg";
                } else if (strpos($tipo_archivo_nuevo, "jpg")) {
                    $tipoArchivo_nuevo = "jpg";
                } else {
                    $tipoArchivo_nuevo = $tipo_archivo;
                }

                $archivo_viejo = "$id" . "." . "tipo_archivo";

                $erabiltzaileID = $erabiltzailea["id_erabiltzaile"];

                if ($todoCorrecto) {
                    $sqlActualiza = "UPDATE `erabiltzaileak` SET izena = '$izenBerria', abizena = '$abizenBerria', telefonoa = '$telefonoBerria', deskribapena = '$deskribapenBerria', kokapena = '$helbideBerria', extensioa = '$tipoArchivo_nuevo' WHERE `id_erabiltzailea` = $id";
                    $stmtActualiza = $pdo->prepare($sqlActualiza);
                    $stmtActualiza->execute();

                    $carpetaDestino = 'media\erabiltzaileak/';
                    $nombreUnico = $erabiltzailea["id_erabiltzailea"] . "." . $tipoArchivo_nuevo;
                    $rutaTemporal = $_FILES['image']['tmp_name'];
                    move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreUnico);
                }

                echo "<script>window.location.href = 'perfila.php';</script>";
            }

            ?>
        </div>
        <?php
        include("footer.php");
        ?>
    </body>
    
    <script>
        function revisaTfno() {
                var patron = /^\d+$/;
                var num = document.getElementById('textTfno').value;

                if (num.length != 0) {
                    if (!patron.test(num) || num.length != 9) {
                        document.getElementById('textoErrorTfno').style.display = "inline-block";
                        document.getElementById('textTfno').style.border = "2px solid red";
                        return true;
                    } else {
                        document.getElementById('textoErrorTfno').style.display = "none";
                        document.getElementById('textTfno').style.border = "2px solid black";
                        return false;
                    }
                } else {
                    document.getElementById('textoErrorTfno').style.display = "none";
                    document.getElementById('textTfno').style.border = "2px solid black";
                    return false;
                }
                
            }

            function revisaEmail() {
                var patron = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

                var emailValido = patron.test(document.getElementById('textEmail').value);

                if (document.getElementById('textEmail').value != 0) {
                    if (emailValido) {
                    document.getElementById('textoErrorEmail').style.display = "none";
                    document.getElementById('textEmail').style.border = "2px solid black";
                    return false;
                    } else {
                        document.getElementById('textoErrorEmail').style.display = "inline-block";
                        document.getElementById('textEmail').style.border = "2px solid red";
                        return true;
                    }
                } else {
                    document.getElementById('textoErrorEmail').style.display = "none";
                    document.getElementById('textEmail').style.border = "2px solid black";
                    return false;
                }
            }

            document.getElementById('formularioEditarDatos').addEventListener('submit', function(event) {
                if (revisaTfno() || revisaEmail()) {
                    event.preventDefault(); // Evita el envío predeterminado del formulario
                }
            });

window.addEventListener("load", inicioMenu);
        </script>    

</html>