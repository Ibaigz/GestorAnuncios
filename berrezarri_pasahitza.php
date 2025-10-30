<?php
include("db_konexioa.php");

$id = null;
$erabiltzailea = null;
if (!empty($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $erabiltzailea = $stmt->fetch();
    }
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

        if ($erabiltzailea == null) {
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <p class="text-white">Errore bat egon da. Berriro klikatu email-eko botoiari pasahitza aldatzeko</p>
                    <?php
                } else {
                    ?>
                    <p>Errore bat egon da. Berriro klikatu email-eko botoiari pasahitza aldatzeko</p>
                    <?php
                }
            } else {
                ?>
                <p>Errore bat egon da. Berriro klikatu email-eko botoiari pasahitza aldatzeko</p>
                <?php
            }
        } else {
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <h2 class="text-white">Pasahitza berrezari</h2>
                    <p class="text-white">Pasahitza berrezartzeko ondorengo formulario bete.</p>
                    <?php
                } else {
                    ?>
                    <h2>Pasahitza berrezari</h2>
                    <p>Pasahitza berrezartzeko ondorengo formulario bete.</p>
                    <?php
                }
            } else {
                ?>
                <h2>Pasahitza berrezari</h2>
                <p>Pasahitza berrezartzeko ondorengo formulario bete.</p>
                <?php
            }

            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <form method="post" class="formAdminDivOscuro">
                    <?php
                } else {
                    ?>
                    <form method="post">
                    <?php
                }
            } else {
                ?>
                <form method="post">
                <?php
            }
        ?>            
                <label for="pass">Pasahitza:</label><br>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="password" name="pass" id="pass" pattern="^(?=.*[A-Za-z])(?=.*[A-Z]).{9,}$" required><br>
                <span id="passwordError"></span>
                <label for="pass2">Pasahitza errepikatu:</label><br>
                <input type="password" name="pass2" id="pass2" pattern="^(?=.*[A-Za-z])(?=.*[A-Z]).{9,}$" required><br>
                <span id="passwordError2"></span>
                <input type="submit" name="aldatu" id="aldatu" value="Berrezarri" class="gaitzekoBotoiakOndo">
            </form>

        <?php
            function pasahitzaValidatu($pasahitza, $zenb)
            {
                echo "<script>";
                sleep(5);
                if ($zenb == 1) {
                    echo "let pasahitza = document.getElementById('pass');";
                    echo "let span = document.getElementById('passwordError');";
                    sleep(5);
                    if (strlen($pasahitza) >= 9) {
                        $patron = "/^(?=.*[A-Za-z])(?=.*[A-Z]).{9,}$/";
                        if (preg_match($patron, $pasahitza)) {
                            echo "pasahitza.style.border = '2px solid black';";
                            echo "span.innerHTML = '';";
                            echo "</script>";
                            return true;
                        } else {
                            echo "pasahitza.style.border = '2px solid red';";
                            echo "mensajeError(span, 'Pasahitzak letra larri bat izan behar du');";
                            echo "</script>";
                            return false;
                        }
                    } else {
                        echo "pasahitza.style.border = '2px solid red';";
                        echo "mensajeError(span, 'Pasahitzak 9 karaktere izan behar ditu');";
                        echo "</script>";
                        return false;
                    }
                } else if ($zenb == 2) {
                    echo "let pasahitza2 = document.getElementById('pass2');";
                    echo "let span2 = document.getElementById('passwordError2');";
                    if (strlen($pasahitza) >= 9) {
                        $patron = "/^(?=.*[A-Za-z])(?=.*[A-Z]).{9,}$/";
                        if (preg_match($patron, $pasahitza)) {
                            echo "pasahitza2.style.border = '2px solid black';";
                            echo "span2.innerHTML = '';";
                            echo "</script>";
                            return true;
                        } else {
                            echo "pasahitza2.style.border = '2px solid red';";
                            echo "mensajeError(span2, 'Pasahitzak letra larri bat izan behar du');";
                            echo "</script>";
                            return false;
                        }
                    } else {
                        echo "pasahitza2.style.border = '2px solid red';";
                        echo "mensajeError(span2, 'Pasahitzak 9 karaktere izan behar ditu');";
                        echo "</script>";
                        return false;
                    }
                }
            }

            function pasahitzaKonp($pasahitza, $pasahitza2)
            {
                echo "<script>";
                echo "let pasahitza = document.getElementById('pass');";
                echo "let span = document.getElementById('passwordError');";
                echo "let pasahitza2 = document.getElementById('pass2');";
                echo "let span2 = document.getElementById('passwordError2');";
                if ($pasahitza == $pasahitza2) {
                    echo "pasahitza.style.border = '2px solid black';";
                    echo "pasahitza2.style.border = '2px solid black';";
                    echo "mensajeError(span, '');";
                    echo "mensajeError(span2, '');";
                    echo "</script>";
                    return true;
                } else {
                    echo "pasahitza.style.border = '2px solid red';";
                    echo "pasahitza2.style.border = '2px solid red';";
                    echo "mensajeError(span, 'Pasahitzak berdinak izan behar dira');";
                    echo "mensajeError(span2, 'Pasahitzak berdinak izan behar dira');";
                    echo "</script>";
                    return false;
                }
            }

            if (isset($_POST["aldatu"])) {
                if (!empty($_POST["pass"]) && !empty($_POST["pass2"])) {
                    $pass = $_POST["pass"];
                    $pass2 = $_POST["pass2"];
                    if (pasahitzaValidatu($pass, 1) && pasahitzaValidatu($pass2, 2) && pasahitzaKonp($pass, $pass2)) {
                        $sql = "UPDATE erabiltzaileak SET pasahitza = :pass WHERE id_erabiltzailea = :id";
                        $stmt = $pdo->prepare($sql);
                        $hashedPassword = hash('sha512', $pass);
                        echo "<script>console.log(" . $hashedPassword . ");</script>";
                        $stmt->bindParam(':pass', $hashedPassword);
                        $stmt->bindParam(':id', $_POST["id"]);
                        $stmt->execute();

                        header("Location: login.php");
                    } else {
                        echo "<script>console.log('Pasahitzak ez dira zuzenak');</script>";
                    }
                }
            }
        }
        ?>

        <script>
            window.addEventListener("load", inicioPasahitzaBerrezarri, false);
            window.addEventListener("load", inicioMenu, false);
        </script>
    </div>
</body>

</html>