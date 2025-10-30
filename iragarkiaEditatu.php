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

    $id = null;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    
    if ($id != null) {
        $sqlIragarkia = "SELECT * FROM iragarkiak WHERE id_iragarkia = $id";
        $stmtIragarkia = $pdo->prepare($sqlIragarkia);
        $stmtIragarkia->execute();
        $iragarkia = $stmtIragarkia->fetch();

        $izena = $iragarkia["izena"];
        $deskribapena = $iragarkia["deskribapena"];
        $prezioa = $iragarkia["prezioa"];
        $bidalketa = $iragarkia["bidalketa"];
        $dataHasiera = null;
        $dataBukaera = null;
        if ($iragarkia["data_hasiera"] != null) {
            $dataHasiera = $iragarkia["data_hasiera"];
            $dataBukaera = $iragarkia["data_bukaera"];
        }
        $kategoriaMarcada = $iragarkia["kategoria_id"];
    }
?>

<!DOCTYPE html>
<html lang="eu">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iragarkia Editatu</title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather">
        <link rel="stylesheet" href="assets/style.css">
        <link rel="shortcut icon" href="media/logo.ico" />
        <script src="assets/style.js"></script>
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
            if (isset($_POST['envio'])) {
                $todoCorrecto = true;

                $prezioBerria = $_POST["precioEditIragarkia"];
                if (strlen($prezioBerria) != 0) {
                    if (!preg_match('/^[0-9]+$/', $prezioBerria)) {
                        $todoCorrecto = false;
                    }
                } else {
                    $prezioBerria = $prezioa;
                }

                $izenBerria = $_POST["nombreEditIragarkia"];
                if ($izenBerria == null) {
                    $izenBerria = $izena;
                }    

                $deskribapenBerria = $_POST["descripcionEditIragarkia"];
                if ($deskribapenBerria == null) {
                    $deskribapenBerria = $deskribapena;
                }

                $bidalketaBerria = 0;
                if (isset($_POST["checkBoxBidalketa"])) {
                    $bidalketaBerria = 1;
                }

                if (!empty($_POST["ekitaldiak"])) {
                    $dataHasieraBerria = $_POST["data_hasiera"];
                    $dataBukaeraBerria = $_POST["data_bukaera"];
                } else {
                    $dataHasieraBerria = null;
                    $dataBukaeraBerria = null;
                }

                $kategoriaBerria = $_POST["kategoriaRadio"];

                if ($todoCorrecto) {
                    $sqlActualiza = "UPDATE `iragarkiak` SET izena = '$izenBerria', deskribapena = '$deskribapenBerria', prezioa = '$prezioBerria', bidalketa = '$bidalketaBerria', kategoria_id = '$kategoriaBerria', data_hasiera = '$dataHasieraBerria', data_bukaera = '$dataBukaeraBerria' WHERE `id_iragarkia` = $id";
                    $stmtActualiza = $pdo->prepare($sqlActualiza);
                    $stmtActualiza->execute();
                    header("Location: perfila.php");
                }
            }


            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <form id="formularioIragarkiaEditatu" method="post" enctype="multipart/form-data" class="editIragForm testuaIragarkiaDivOscuro">
                    <?php
                } else {
                    ?>
                    <form id="formularioIragarkiaEditatu" method="post" enctype="multipart/form-data" class="editIragForm">
                    <?php
                }
            } else {
                ?>
                <form id="formularioIragarkiaEditatu" method="post" enctype="multipart/form-data" class="editIragForm">
                <?php
            }
            ?>

            
                <h1>Iragarkia Editatu</h1>
                <hr>
                <label>Izena:</label>
                <input type="text" class="textNombre" id="nombreText" value="<?php echo "$izena"; ?>" name="nombreEditIragarkia" onblur="revisaNombreNuevo()"><br><br>
                <label>Deskribapena:</label>
                <input type="text" class="textDesc" id="descText" value="<?php echo "$deskribapena"; ?>" name="descripcionEditIragarkia" onblur="revisaDescNueva()"><br><br>
                <label>Prezioa:</label><br>
                <input type="text" class="textPrecio" id="precioText" value="<?php echo "$prezioa"; ?>" name="precioEditIragarkia" onblur="revisaPrecioNuevo()">
                <label class="editatu-bidalketa">Bidalketa?</label>
                <input type="checkbox" id="checkboxBidalketa" name="checkBoxBidalketa"<?php if($bidalketa == 1) echo "checked"; ?>>
                <label>Bai</label><br>
                <label id="textoErrorPrecio" class="errorTextos">Prezio egoki bat sartu</label><br>
                <div class="ira-ediContainer">
                    <div class="kategoria-editatu">
                        <label>Kategoria:</label><br><br>
                        <?php
                        $sqlKategoriak = "SELECT * FROM kategoria";
                        $stmt = $pdo->prepare($sqlKategoriak);
                        $stmt->execute();
                        $kategoriak = $stmt->fetchAll();
                        $total = $stmt->rowCount();
                        $primeraColumna = ceil($total / 2);
                        $segundaColumna = floor($total / 2);
                        echo "<div style='display: inline-block;'>";
                        $contador = 0;
                        foreach ($kategoriak as $kategoria) {
                            if($contador < $primeraColumna) {
                            ?>
                            <label>
                            <?php $numOp = $contador + 1; ?>
                            <input class="kategoria-radio" type="radio" name="kategoriaRadio" value="<?php echo "$numOp"; ?>" <?php if($kategoriaMarcada == $contador + 1) echo "checked"; ?>> <?php echo $kategoria["izena"] ?>
                            </label><br>
                            <?php
                            }
                            $contador++;
                        }
                        echo "</div>";
                        echo "<div style='display: inline-block; margin-left: 3%;'>";
                        $contador = 0;
                        foreach ($kategoriak as $kategoria) {
                            if($contador >= $total - $segundaColumna) {
                            ?>
                            <label>
                            <input class="kategoria-radio" type="radio" name="kategoriaRadio" value="<?php echo "$contador"; ?>"  <?php if($kategoriaMarcada == $contador + 1) echo "checked"; ?>> <?php echo $kategoria["izena"] ?>
                            </label><br>
                            <?php
                            }
                            $contador++;
                        }
                        echo "</div>";    
                        ?>
                    </div>
                </div>

                <br>

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
                            <input type="date" id="data_hasiera" name="data_hasiera" value="<?php echo $dataHasiera ?>">
                            <span id="data_hasieraError" class="errorForm"></span>
                        </div>
                        <div>
                            <label for="data_bukaera">Data bukaera: </label>
                            <input type="date" id="data_bukaera" name="data_bukaera" value="<?php echo $dataBukaera ?>">
                            <span id="data_bukaeraError" class="errorForm"></span>
                        </div>
                    </div>
                </div>
                <br>

                <input type="submit" name="envio" value="Edizioak gorde" style="margin: auto; margin-left: 45%; margin-top: 1%; width: fit-content;" class="botoiak">

            </form>
        </div>

        <?php
            include("footer.php");
        ?>

    </body>

    <script>

        let nomViejo;
        let descVieja;
        window.addEventListener("load", inicioEditIragarkia);

        function inicioEditIragarkia() {
            let ekitaldiak = document.getElementsByName("ekitaldiak");
            for (let i = 0; i < ekitaldiak.length; i++) {
                ekitaldiak[i].addEventListener("click", function () {
                datakErakutzi(ekitaldiak[i].value);
                });
            }
            nomViejo = document.getElementById('nombreText').value;
            descVieja = document.getElementById('descText').value;
            document.getElementById('formularioIragarkiaEditatu').addEventListener('submit', function(event) {
            if (revisaPrecio()) {
                event.preventDefault(); // Evita el envío predeterminado del formulario
            }
        });
        }

        function revisaNombreNuevo() {
            var nom = document.getElementById('nombreText').value;
            if (nom.length == 0) {
                document.getElementById('nombreText').value = nomViejo;
            }
        }

        function revisaDescNueva() {
            var desc = document.getElementById('descText').value;

            if (desc.length == 0) {
                document.getElementById('descText').value = descVieja;
            }
        }

        function revisaPrecioNuevo() {
            var patron = /^\d+$/;
            var num = document.getElementById('precioText').value;

            if (num.length != 0) {
                if (!patron.test(num)) {
                    document.getElementById('textoErrorPrecio').style.display = "inline-block";
                    document.getElementById('precioText').style.border = "2px solid red";
                    return true;
                } else {
                    document.getElementById('textoErrorPrecio').style.display = "none";
                    document.getElementById('precioText').style.border = "2px solid black";
                    return false;
                }
            } else {
                document.getElementById('precioText').value = <?php echo "$prezioa"; ?>;
                document.getElementById('textoErrorPrecio').style.display = "none";
                document.getElementById('precioText').style.border = "2px solid black";
                return false;
            }
                
        }

        window.addEventListener("load", inicioMenu);
    </script>

</html>