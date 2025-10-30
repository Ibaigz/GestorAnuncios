<?php
require("a/vendor/phpmailer/src/PHPMailer.php");
require("a/vendor/phpmailer/src/SMTP.php");
require("a/vendor/phpmailer/src/Exception.php");

$id = null;
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
}

function email_admin_kendu() {
    include ("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_POST["id"]) && !empty($_POST["mesua"])) {
        $id = $_POST["id"];
        $mesua = $_POST["mesua"];
        $sql = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $erab = $erabiltzailea["erabiltzailea"];
            $posta = $erabiltzailea["posta_elektronikoa"];
            $izena = $erabiltzailea["izena"];
            $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug =PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; 
                    $mail->SMTPDebug = 0;                     
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = 'tradespot.noreply@gmail.com';                    
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                  
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);              
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');
                

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Zure erabiltzailearen kontua administratzaile baimenak kendu dira';
                    $mail->Body    = '<p>Barkatu ' . $izena . ' ' . $abizena .',<br>' 
                                        . $erab . ' erabiltzailearekin duzun kontuari administratzaile bahimenak kendu zaizkio.<br>
                                        Ondorengoak izan dira administratzailearen arrazoiak bahimenak kentzako:<br>
                                        ' . $mesua .' <br>
                                        Ondo izan,<br>
                                        Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: adminKendu.php?id=" . $id);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
        echo "Ezin izan da email-a bidali";
        }
}

function email_cambio_password() {
    include ("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_GET["erab"])) {
        $id = $_GET["erab"];
        $sql = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $erab = $erabiltzailea["erabiltzailea"];
            $posta = $erabiltzailea["posta_elektronikoa"];
            $izena = $erabiltzailea["izena"];
            $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug =PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; 
                    $mail->SMTPDebug = 0;                     
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = 'tradespot.noreply@gmail.com';                    
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                  
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);              
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');
                

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Berrezarri zure pasahitza';
                    $mail->Body    = '<p>Kaixo ' . $izena . ' ' . $abizena .',<br>
                                        Zure pasahitza berrezarri nahi baduzu ondoreko botoiari eman.<br>
                                        <form action="http://localhost/erronka1-gestoanuncios-t3/berrezarri_pasahitza.php" method="post">
                                            <input type="hidden" name="id" value="' . $id . '">
                                            <input type="submit" value="Berrezarri">
                                        </form><br>
                                        Ondo izan,
                                        Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: login.php");
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
        echo "Ezin izan da email-a bidali";
        }
}

function email_erab_admin_permiso() {
    include ("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_GET["erab"])) {
        $id = $_GET["erab"];
        $sql = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $erab = $erabiltzailea["erabiltzailea"];
            $posta = $erabiltzailea["posta_elektronikoa"];
            $izena = $erabiltzailea["izena"];
            $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug =PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; 
                    $mail->SMTPDebug = 0;                     
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = 'tradespot.noreply@gmail.com';                    
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                  
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);              
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');
                

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Zure erabiltzailearen kontua administratzaile baimenak gehitu zaizkio';
                    $mail->Body    = '<p>Zorionak ' . $izena . ' ' . $abizena .',<br>' 
                                        . $erab . ' erabiltzailearekin duzun kontuari administratzaile bahimenak gehitu zaizkio.<br>
                                        Oraindik aurrera administratzaile moduko kontua duzu, kontuz egiten dituzun aldaketekin.<br>
                                        Ondo izan,<br>
                                        Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: adminpage.php");
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
        echo "Ezin izan da email-a bidali";
        }
}

function email_erab_ez_gaitu() {
    include ("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_POST["id"]) && !empty($_POST["mesua"])) {
        $id = $_POST["id"];
        $mesua = $_POST["mesua"];
        $sql = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $erab = $erabiltzailea["erabiltzailea"];
            $posta = $erabiltzailea["posta_elektronikoa"];
            $izena = $erabiltzailea["izena"];
            $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug =PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; 
                    $mail->SMTPDebug = 0;                     
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = 'tradespot.noreply@gmail.com';                    
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                  
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);              
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');

                    if (isset($_POST['checkBoxDatos']) && isset($_POST['checkBoxFotos'])) {
                        $motivo = "Hauek izan dira arrazoi nagusiak: <br>
                        1. Sartu duzun daturen bat ez da egokia edota lekuz kanpo dago. <br>
                        2. Sartu duzun perfil argazkia ez da egokia edota lekuz kanpo dago";
                    } else if (isset($_POST['checkBoxDatos'])) {
                        $motivo = "Hau izan da arrazoi nagusia: <br>
                        1. Sartu duzun daturen bat ez da egokia edota lekuz kanpo dago.";
                    } else if (isset($_POST['checkBoxFotos'])) {
                        $motivo = "Hau izan da arrazoi nagusia: <br>
                        1. Sartu duzun perfil argazkia ez da egokia edota lekuz kanpo dago";
                    } else {

                    }

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = $erab .' kontua ez gaitua';
                    $mail->Body    = '<p>Barkatu ' . $izena . ' ' . $abizena .',<br>' 
                                        . $erab . ' erabiltzailearekin duzun kontua ez da gaitua izan.<br>'
                                        . $motivo .
                                        '<br><br>Ondorengoak izan dira administratzaileak idatzitako arrazoiak kontua ez gaitzeko: <br>
                                        ' . $mesua .'<br>
                                        Ondo izan,<br>
                                        Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: erabEzGaitu.php?id=" . $id);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
        echo "Ezin izan da email-a bidali";
        }
}

function email_erab_ezabatu() {
    include ("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_POST["id"]) && !empty($_POST["mesua"])) {
        $id = $_POST["id"];
        $mesua = $_POST["mesua"];
        $sql = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $erab = $erabiltzailea["erabiltzailea"];
            $posta = $erabiltzailea["posta_elektronikoa"];
            $izena = $erabiltzailea["izena"];
            $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug =PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; 
                    $mail->SMTPDebug = 0;                     
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = 'tradespot.noreply@gmail.com';                    
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                  
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);              
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');
                

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Zure erabiltzailearen kontua ezabatu egin da';
                    $mail->Body    = '<p>Barkatu ' . $izena . ' ' . $abizena .',<br>' 
                                        . $erab . ' erabiltzailearekin duzun kontua ezabatu egin da.<br>
                                        Ondorengoak izan dira administratzailearen arrazoiak erabiltzailea ezabatzeko:<br>
                                        ' . $mesua .' <br>
                                        Ondo izan,<br>
                                        Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: erabEzGaitu.php?id=" . $id);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
        echo "Ezin izan da email-a bidali";
        }
}

function email_erab_gaitu() {
    include ("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_GET["erab"])) {
            $id = $_GET["erab"];
            $sql = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $erabiltzailea = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                $erab = $erabiltzailea["erabiltzailea"];
                $posta = $erabiltzailea["posta_elektronikoa"];
                $izena = $erabiltzailea["izena"];
                $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug =PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; 
                    $mail->SMTPDebug = 0;                     
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = 'tradespot.noreply@gmail.com';
                    $mail->Password   = 'fzun ehff ceop fkkp';                               
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                  
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);              
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');
                

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = $erab .' kontua gaitua';
                    $mail->Body    = '<p>Zorionak ' . $izena . ' ' . $abizena .'!<br>' 
                                        . $erab . ' erabiltzailearekin duzun kontua egiaztatu egin da.<br>
                                        Gaurtik aurrera ' . $erab .' erabiltzailea eta kontua sortzean erabili zenuen pasahitzarekin sar zaitezke Tradespot-en.<br>
                                        Ondo izan,<br>
                                        Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: adminpage.php");
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
        echo "Ezin izan da email-a bidali";
        }
}

function email_irag_ez_gaitu() {
    include("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_POST["id"]) && !empty($_POST["mesua"])) {
        $id = $_POST["id"];
        $mesua = $_POST["mesua"];
        $sql = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $iragarkiak = $stmt->fetch();
            $erabId = $iragarkiak["id_erabiltzailea"];
            $sqlErab = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
            $stmt = $pdo->prepare($sqlErab);
            $stmt->bindParam(':id', $erabId);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $erabiltzailea = $stmt->fetch();
                $irag = $iragarkiak["izena"];
                $posta = $erabiltzailea["posta_elektronikoa"];
                $izena = $erabiltzailea["izena"];
                $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'tradespot.noreply@gmail.com';
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');

                    if (isset($_POST['checkBoxDatos']) && isset($_POST['checkBoxFotos'])) {
                        $motivo = "Hauek izan dira arrazoi nagusiak: <br>
                            1. Sartu duzun daturen bat ez da egokia edota lekuz kanpo dago. <br>
                            2. Sartu duzun iragarkiaren argazkia ez da egokia edota lekuz kanpo dago";
                    } else if (isset($_POST['checkBoxDatos'])) {
                        $motivo = "Hau izan da arrazoi nagusia: <br>
                            1. Sartu duzun daturen bat ez da egokia edota lekuz kanpo dago.";
                    } else if (isset($_POST['checkBoxFotos'])) {
                        $motivo = "Hau izan da arrazoi nagusia: <br>
                            1. Sartu duzun iragarkiaren argazkia ez da egokia edota lekuz kanpo dago";
                    } else {
                    }

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = $irag . ' izeneko iragarkia ez da gaitu';
                    $mail->Body    = '<p>Barkatu ' . $izena . ' ' . $abizena . ',<br>'
                        . $irag . ' izenarekin duzun iragarkia ez da gaitua izan.<br>'
                        . $motivo .
                        '<br><br>Ondorengoak izan dira administratzaileak idatzitako arrazoiak iragarkia ez gaitzeko: <br>
                                            ' . $mesua . ' <br>
                                            Ondo izan,<br>
                                            Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: iragEzGaitu.php?id=" . $id);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
            echo "Ez da iragarki hori existitzen";
        }
    } else {
        echo "Ezin izan da email-a bidali";
    }
}

function email_irag_ezabatu() {
    include("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_POST["id"]) && !empty($_POST["mesua"])) {
        $id = $_POST["id"];
        $mesua = $_POST["mesua"];
        $sql = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $iragarkiak = $stmt->fetch();
            $erabId = $iragarkiak["id_erabiltzailea"];
            $sqlErab = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
            $stmt = $pdo->prepare($sqlErab);
            $stmt->bindParam(':id', $erabId);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $erabiltzailea = $stmt->fetch();
                $irag = $iragarkiak["izena"];
                $posta = $erabiltzailea["posta_elektronikoa"];
                $izena = $erabiltzailea["izena"];
                $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'tradespot.noreply@gmail.com';
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');

                    if (isset($_POST['checkBoxDatos']) && isset($_POST['checkBoxFotos'])) {
                        $motivo = "Hauek izan dira arrazoi nagusiak: <br>
                            1. Sartu duzun daturen bat ez da egokia edota lekuz kanpo dago. <br>
                            2. Sartu duzun iragarkiaren argazkia ez da egokia edota lekuz kanpo dago";
                    } else if (isset($_POST['checkBoxDatos'])) {
                        $motivo = "Hau izan da arrazoi nagusia: <br>
                            1. Sartu duzun daturen bat ez da egokia edota lekuz kanpo dago.";
                    } else if (isset($_POST['checkBoxFotos'])) {
                        $motivo = "Hau izan da arrazoi nagusia: <br>
                            1. Sartu duzun iragarkiaren argazkia ez da egokia edota lekuz kanpo dago";
                    } else {
                    }

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = $irag . ' izeneko iragarkia ezabatu da';
                    $mail->Body    = '<p>Barkatu ' . $izena . ' ' . $abizena . ',<br>'
                        . $irag . ' izenarekin duzun iragarkia ezabatu da.<br>'
                        . $motivo .
                        '<br><br>Ondorengoak izan dira administratzaileak idatzitako arrazoiak iragarkia ezabatzeko: <br>
                                            ' . $mesua . '<br>
                                            Ondo izan,<br>
                                            Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: iragEzGaitu.php?id=" . $id);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
            echo "Ez da iragarki hori existitzen";
        }
    } else {
        echo "Ezin izan da email-a bidali";
    }
}

function email_irag_gaitu() {
    include("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_GET["irag"])) {
        $id = $_GET["irag"];
        $sql = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $iragarkiak = $stmt->fetch();
            $erabId = $iragarkiak["id_erabiltzailea"];
            $sqlErab = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
            $stmt = $pdo->prepare($sqlErab);
            $stmt->bindParam(':id', $erabId);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $erabiltzailea = $stmt->fetch();
                $irag = $iragarkiak["izena"];
                $posta = $erabiltzailea["posta_elektronikoa"];
                $izena = $erabiltzailea["izena"];
                $abizena = $erabiltzailea["abizena"];
                try {
                    //Server settings
                    $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'tradespot.noreply@gmail.com';
                    $mail->Password   = 'fzun ehff ceop fkkp';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    //Recipients
                    $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail->addAddress($posta, $izena . " " . $abizena);
                    $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = $irag . ' izeneko iragarkia Tradespot-era igo da';
                    $mail->Body    = '<p>Zorionak ' . $izena . ' ' . $abizena . '!<br>'
                                    . $irag . ' izenarekin duzun iragarkia Tradespot-era igo da.<br>
                                    Eskerrik asko!<br>
                                    Ondo izan,<br>
                                    Tradespot-eko administratzailea</p>';

                    $mail->send();
                    echo 'Message has been sent';
                    header("Location: adminpage.php?id=4");
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Ez da erabiltzaile hori existitzen";
            }
        } else {
            echo "Ez da iragarki hori existitzen";
        }
    } else {
        echo "Ezin izan da email-a bidali";
    }
}

function email_kontaktua() {
    include("db_konexioa.php");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require 'a/vendor/autoload.php';

    //Create an instance; passing true enables exceptions
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    $mail1 = new PHPMailer\PHPMailer\PHPMailer;

    if (!empty($_POST["mail"])) {
        $posta = $_POST["mail"];
        $erab = $_POST["lname"];
        $desk = $_POST["desc"];
        

        try {
            //Server settings
            $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tradespot.noreply@gmail.com';
            $mail->Password   = 'fzun ehff ceop fkkp';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            //Recipients
            $mail->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
            $mail->addAddress($posta, $erab);
            $mail->addReplyTo('tradespot.noreply@gmail.com', 'Information');
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);
            $mail->Subject = $erab . ' kontsulta bidalita';
            $mail->Body    = '<p>Kaixo ' . $erab . '!<br><br>'
                . ' Zure kasua gure administratzaileei reportea ailegatu da!.<br><br>
                                        Ahalik eta azkarren zurekin kontaktuan jarriko gara. Mila esker eta barkatu eragozpenagatik.<br><br><br>
                                        Zure kontzulta :<br>'.$desk.'<br><br>

                                        Tradespot-eko administratzailea</p>';

            $mail->send();
            echo 'Message has been sent';
            // header("Location: kontaktua.php?id=1");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $sql="SELECT * from erabiltzaileak WHERE rol=0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount()>0){
            $admin=$stmt->fetchAll();
            for($i=0; $i<count($admin);$i++){
                try {
                    //Server settings
                    $mail1->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
                    $mail1->SMTPDebug = 0;
                    $mail1->isSMTP();
                    $mail1->Host       = 'smtp.gmail.com';
                    $mail1->SMTPAuth   = true;
                    $mail1->Username   = 'tradespot.noreply@gmail.com';
                    $mail1->Password   = 'fzun ehff ceop fkkp';
                    $mail1->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    $mail1->Port       = 465;
                    //Recipients
                    $mail1->setFrom('tradespot.noreply@gmail.com', 'Admin TradeSpot');
                    $mail1->addAddress($admin[$i]["posta_elektronikoa"], $admin[$i]["izena"]." ".$admin[$i]["abizena"]);
                    $mail1->addReplyTo('tradespot.noreply@gmail.com', 'Information');
                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
                    //Content
                    $mail1->isHTML(true);
                    $mail1->Subject = 'Kontsulta berri bat';
                    $mail1->Body    = '<p>Kontsulta berri bat ailegatu da!!<br><br>'
                        . ' Bezeroa '.$erab.' deitzen da.<br><br>
                        
                                                Bere kontzulta hau da :<br>'.$desk.'<br><br>
        
                                                Tradespot-eko administratzailea</p>';
        
                    $mail1->send();
                    echo 'Message has been sent';
                    header("Location: kontaktua.php?id=1");
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail1->ErrorInfo}";
                }
            }
        }

    } else {
        echo "Ezin izan da email-a bidali";
    }

}

if ($id != null) {
    if ($id == 1) {
        email_admin_kendu();
    } else if ($id == 2) {
        email_cambio_password();
    } else if ($id == 3) {
        email_erab_admin_permiso();
    } else if ($id == 4) {
        email_erab_ez_gaitu();
    } else if ($id == 5) {
        email_erab_ezabatu();
    } else if ($id == 6) {
        email_erab_gaitu();
    } else if ($id == 7) {
        email_irag_ez_gaitu();
    } else if ($id == 8) {
        email_irag_ezabatu();
    } else if ($id == 9) {
        email_irag_gaitu();
    } else if ($id == 10) {
        email_kontaktua();
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
?>