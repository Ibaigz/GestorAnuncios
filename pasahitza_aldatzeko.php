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
    <title>Pasahitza aldatu</title>
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

        <div class="info-pass">
        <?php
        if (isset($_COOKIE["dark"])) {
            if ($_COOKIE["dark"] == "on") {
                ?>
                <h2 class="text-white">Zein da zure erabiltzailea?</h2>
                <p class="text-white">Idatzi zure erabiltzailea email bat bidaltzeko pasahitza berrezarritzeko</p><br>
                <?php
            } else {
                ?>
                <h2>Zein da zure erabiltzailea?</h2>
                <p>Idatzi zure erabiltzailea email bat bidaltzeko pasahitza berrezarritzeko</p><br>
                <?php
            }
        } else {
            ?>
            <h2>Zein da zure erabiltzailea?</h2>
            <p>Idatzi zure erabiltzailea email bat bidaltzeko pasahitza berrezarritzeko</p><br>
            <?php
        }
        ?>
        </div>
        <?php
        if (isset($_COOKIE["dark"])) {
            if ($_COOKIE["dark"] == "on") {
                ?>
                <form class="formLog testuaIragarkiaDivOscuro" method="post">
                <?php
            } else {
                ?>
                <form class="formLog" method="post">
                <?php
            }
        } else {
            ?>
            <form class="formLog" method="post">
            <?php
        }
        ?>
        
            <br><label for="erabiltzailea">Erabiltzailea:</label><br>
            <input type="text" name="erabiltzailea" id="erabiltzailea" required><br>
            <span id="erabiltzaileaError"></span>
            <input class="pass-bidali" type="submit" name="bidali" id="bidali" value="Bidali">
        </form>

        <?php
            if (isset($_POST["bidali"])) {
                if (validatuText($_POST["erabiltzailea"])) {
                    $erab = strtolower($_POST["erabiltzailea"]);
                    $sql = "SELECT * FROM erabiltzaileak WHERE erabiltzailea = :erabiltzailea";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':erabiltzailea', $erab);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $erabiltzailea = $stmt->fetch();
                        header("Location: email.php?id=2&erab=" . $erabiltzailea["id_erabiltzailea"]);
                    } else {
                        echo "<script>";
                        echo "erab = document.getElementById('erabiltzailea');";
                        echo "spanErab = document.getElementById('erabiltzaileaError');";
                        echo "erab.style.border = '2px solid red';";
                        echo "mensajeError(spanErab, 'Erabiltzailea ez da existitzen');";
                        echo "erab.focus();";
                        echo "</script>";
                    }
                } else {
                    echo "<script>console.log('Erabiltzailea ez da zuzena');</script>";
                }
            }

            function validatuText($elementua) {
                echo "<script>";
                echo "erab = document.getElementById('erabiltzailea');";
                echo "spanErab = document.getElementById('erabiltzaileaError');";
                if ($elementua == null) {
                    echo "erab.style.border = '2px solid red';";
                    echo "mensajeError(spanErab, 'Eremu hau ezin da hutsik egon');";
                    echo "erab.focus();";
                    echo "</script>";
                    return false;
                } else {
                    echo "erab.style.border = ' ';";
                    echo "mensajeError(spanErab, ' ');";
                    echo "</script>";
                    return true;
                }
            }
        ?>

        <script>
            function inicioPasahitzaAldatzekoErab() {
                let botoia = document.getElementById("bidali");
                botoia.addEventListener("click", validarErabPasahitza, false)
            }

            function validarErabPasahitza(e) {
                let erabiltzailea = document.getElementById("erabiltzailea");
                let erabiltzaileaError = document.getElementById("erabiltzaileaError");
                if (validaText(erabiltzailea, erabiltzaileaError)) {
                    // erabiltzailea sartuta
                } else {
                    e.preventDefault();
                }
            }

            window.addEventListener("load", inicioMenu)
        </script>
    </div>

</body>
</html>