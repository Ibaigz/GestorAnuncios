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
    <title>Kontaktua</title>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/style.js"></script>
    <link rel="shortcut icon" href="media/logo.ico" />

</head>



<?php
// Dark mode cookie
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
<!-- Email bidali dela konfirmatu -->
    <div class="margin">
        <?php
        include("menu.php");
        ?> 
        <!-- Info -->
        <div style="text-align: center;"><label id="emailBidalita" style="font-size: 20px; display: none;">Zure kontsulta bidalita izan da emailez!</label></div>
        <div class="divInfo">

            <?php
            
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <form class="formKont testuaIragarkiaDivOscuro" method="post" action="email.php?id=10">
                    <?php
                } else {
                    ?>
                    <form class="formKont" method="post" action="email.php?id=10">
                    <?php
                }
            } else {
                ?>
                <form class="formKont" method="post" action="email.php?id=10">
                <?php
            }
            ?>
            <!-- Kontaktuan jartzeko formularioa -->
            <form class="formKont" method="post" action="email.php?id=10">
                <h1 class="h1Kont">KONTAKTUAN JARRI</h1>
                <hr>

                <label class="labloging" for="lname">Izena: </label><label class="errorTextos" id="errorlname">Errorea! Zure
                    izena idatzi</label>


                <input type="text" id="lname" name="lname"><br><br>




                <label class="labloging" for="mail">Posta Elektronikoa: </label><label class="errorTextos"
                    id="errorEmail">Errorea emaila ondo idatzi mesedez</label>

                <input type="email" id="mail" name="mail" title="Emaila ondo sartu"><br><br>



                <label class="labloging" for="desc">Zure kontsulta: </label><label class="errorTextos"
                    id="errorDesc">Errorea! Zure kontsula idatzi </label>

                <textarea rows="4" cols="50" id="desc" name="desc"></textarea><br><br>



                <input class="botoiak" type="submit" name=bidali id="bidali" value="BIDALI">

            </form>

            
            
            <script>
                window.addEventListener("load", inicioKontaktua());




                function mostrarVentanaEmergente() {
                    var ventanaEmergente = document.getElementById("miVentanaEmergente");
                    ventanaEmergente.style.display = "block";
                }

                function ocultarVentanaEmergente() {
                    var ventanaEmergente = document.getElementById("miVentanaEmergente");
                    ventanaEmergente.style.display = "none";
                }

                function inicioKontaktua() {

                    let checkboton = document.getElementById("bidali");

                    checkboton.addEventListener("click", checkbotonClick, false);


                }

                function checkbotonClick(e) {
                    if (emptyIzena() && revisaEmail() && emptyDesc()) {
                        document.getElementById("emailBidalita").style.display = "block";
                        return true;

                    } else {
                        e.preventDefault();
                        return false;
                    }
                }

                function revisaEmail() {
                    var patron = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                    var emailValido = patron.test(document.getElementById('mail').value);
                    var emailInput = document.getElementById("email");

                    if (emailValido) {
                        document.getElementById('errorEmail').style.display = "none";
                        document.getElementById('mail').style.border = "2px solid green";
                        return true;
                    } else {
                        document.getElementById('errorEmail').style.display = "inline-block";
                        document.getElementById('mail').style.border = "2px solid red";
                        return false;
                    }
                }

                function emptyIzena() {
                    var inputValue = document.getElementById('lname').value;

                    if (inputValue === '') {
                        document.getElementById('errorlname').style.display = "inline-block";
                        document.getElementById('lname').style.border = "2px solid red";
                        return false;

                    } else {
                        document.getElementById('errorlname').style.display = "none";
                        document.getElementById('lname').style.border = "2px solid green";
                        return true;

                    }
                }

                function emptyDesc() {
                    var inputValueDesc = document.getElementById('desc').value;

                    if (inputValueDesc === '') {
                        document.getElementById('errorDesc').style.display = "inline-block";
                        document.getElementById('desc').style.border = "2px solid red";
                        return false;

                    } else {
                        document.getElementById('errorDesc').style.display = "none";
                        document.getElementById('desc').style.border = "2px solid green";
                        return true;

                    }
                }
            </script>








            <?php 
                
                

                if(!isset($_POST["bidali"])){

                    echo "<script>console.log('login');</script>";

                    

                } else {

                    $bool=true;

                    $izena = null;
                    if (!empty($_POST['lname'])) {
                        $izena = $_POST['lname'];
                    }
                    $email = null;
                    if (!empty($_POST['mail'])) {
                        $email = $_POST['mail'];
                    }
                    $deskribapena=$_POST['desc'];
                    

                
                    if($izena == null || $email == null){
                        echo "<script>alert('Error');</script>";
                        login();



                        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo "<script>alert('Error');</script>";
                            login();
                        }
                        else{
                            echo"ondo";
                        }
                    }
                
            ?>

            <?php
                if (!empty($_GET["id"])) {
                    if ($_GET["id"] == "1") {
                        ?>
                        <script>document.getElementById("emailBidalita").style.display = "block";</script>
                        <?php
                    }
                }
            ?>



        </div>
    </div>

    
<?php
    include("footer.php");
?>

<script>window.addEventListener("load", inicioMenu);</script>

</body>


</html>