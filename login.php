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
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/style.js"></script>
    <script src="assets/erabiltzailea.js"></script>
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
            function login() {
        ?>
        
        <?php
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <form class="formLog testuaIragarkiaDivOscuro" method="post">
                    <?php
                } else {
                    ?>
                    <form class="formLog"method="post">
                    <?php
                }
            } else {
                ?>
                <form class="formLog"method="post">
                <?php
            }
        ?>
            <label class="labloging" for="lname">Erabiltzailea</label><br>
            <input type="text" id="lname" name="lname" required><br><br>

            <label class="labloging" for="pass">Pasahitza</label><br>
            <input type="password" id="pass" name="pass" required><br><br>

            <input class="botoiak" type="submit" name=bidali value="Sartu">
            <?php
                if (isset($_COOKIE["dark"])) {
                    if ($_COOKIE["dark"] == "on") {
                        ?>
                        <a class="registro-egin text-white" href="registro.php" style="margin-top: 25px;">Ez daukat konturik: Erregistratu</a>
                        <a class="pass-aldatu text-white" href="pasahitza_aldatzeko.php" style="margin-top: 20px;">Pasahitza ahaztu dut: Aldatu</a>
                        <?php
                    } else {
                        ?>
                        <a class="registro-egin" href="registro.php" style="margin-top: 25px;">Ez daukat konturik: Erregistratu</a>
                        <a class="pass-aldatu" href="pasahitza_aldatzeko.php" style="margin-top: 20px;">Pasahitza ahaztu dut: Aldatu</a>
                        <?php
                    }
                } else {
                    ?>
                    <a class="registro-egin" href="registro.php" style="margin-top: 25px;">Ez daukat konturik: Erregistratu</a>
                    <a class="pass-aldatu" href="pasahitza_aldatzeko.php" style="margin-top: 20px;">Pasahitza ahaztu dut: Aldatu</a>
                    <?php
                }
            ?>
            

        </form>
        <br>
        

        <?php 
            }

            if(!isset($_POST["bidali"])){

                login();

            } else {

                $posta = NULL;
            
                if(!empty($_POST['lname']) && !empty($_POST['pass']) ){
                    $erab = strtolower($_POST["lname"]);
                    $pass = $_POST["pass"];

                    try {
                        $sqlposta = "SELECT * FROM erabiltzaileak WHERE erabiltzailea = :erab AND pasahitza = :pass";
                        $hashedPassword = hash('sha512', $_POST["pass"]);
                        $stmt = $pdo->prepare($sqlposta);
                        $stmt->bindParam(":erab", $erab);
                        $stmt->bindParam(":pass", $hashedPassword);
                        $stmt->execute();

                        if($stmt->rowCount() == 1){
                            $posta = $stmt->fetch();

                            if ($posta["egiaztatua"] == 0) {
                                login();
                                echo "Erabiltzailea ez dago egiaztatuta";
                            } elseif ($posta["egiaztatua"] == 1) {

                                $_SESSION["erabiltzailea"] = $posta["id_erabiltzailea"];
                                ?>
                                <script>
                                    console.log("Erabiltzailea sartu da");
                                    let erab = new Erabiltzailea(<?php 
                                        echo $posta["id_erabiltzailea"] . ", '" . 
                                        $posta["erabiltzailea"] . "', '" .
                                        $posta["posta_elektronikoa"] . "', '" .
                                        $posta["izena"] . "', '" .
                                        $posta["abizena"] . "', '" .
                                        $posta["nan"] . "', " .
                                        $posta["adina"]
                                        ?>);
                                    window.localStorage.setItem("erab", JSON.stringify(erab));
                                </script>
                                <?php
                                header("Location: index.php");
                            }

                        } else{
                            login();
                            echo"Erabiltzailea edo pasahitza ez dira egokiak";
                        }

                    } catch (PDOException $e) {
                        login();
                        echo"Errore bat egon da datu basearekin,. Berriro zailatu";
                    }
                }else{
                    echo"ERROR";
                }
            }
        ?>
    </div>
    <script>window.addEventListener("load", inicioMenu);</script>
    <?php
        include("footer.php");
    ?>
</body>
</html>