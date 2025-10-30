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

    $id = null;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erabiltzailea ez gaitua</title>
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
        ?>

        <div>
            <?php
            if ($erabiltzailea == null || $erabiltzailea["rol"] != 0) {
                header("Location: index.php");
            } else {
                if ($id == null) {
                    ?>
                    <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                    <?php
                    if (isset($_COOKIE["dark"])) {
                        if ($_COOKIE["dark"] == "on") {
                            ?>
                            <p class="text-white"><br>Erabiltzailea ez da existitzen</p>
                            <?php
                        } else {
                            ?>
                            <p><br>Erabiltzailea ez da existitzen</p>
                            <?php
                        }
                    } else {
                        ?>
                        <p><br>Erabiltzailea ez da existitzen</p>
                        <?php
                    }
                } else {
                    $sqlErabAurk = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
                    $stmt = $pdo->prepare($sqlErabAurk);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $erab = $stmt->fetch();
                        if ($erab["egiaztatua"] != 0) {
                            ?>
                            <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                            <?php
                            echo "Erabiltzailea iada egiaztatuta dago";
                        } else {
                            ?>
                            <button onclick="goBack()" class="atzeraBotoia">&#8249;</button>
                            <?php
                                if (isset($_COOKIE["dark"])) {
                                    if ($_COOKIE["dark"] == "on") {
                                        ?>
                                        <h3 class="text-white">Arrazoitu erabiltzailearen ez gaitzea:</h3>
                                        <form action="email.php?id=4" method="post" class="formAdmin formAdminDivOscuro" onsubmit="validaCheckBox()">
                                        <?php
                                    } else {
                                        ?>
                                        <h3>Arrazoitu erabiltzailearen ez gaitzea:</h3>
                                        <form action="email.php?id=4" method="post" class="formAdmin" onsubmit="validaCheckBox()">
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h3>Arrazoitu erabiltzailearen ez gaitzea:</h3>
                                    <form action="email.php?id=4" method="post" class="formAdmin" onsubmit="validaCheckBox()">
                                    <?php
                                }
                            ?>
                            
                                <div class="flexCheckBox">
                                    <input type="checkbox" class="checkBox" name="checkBoxDatos" style="width: 24px">
                                    <label>Daturen bat desegokia da</label>
                                </div>
                                <div class="flexCheckBox">
                                    <input type="checkbox" class="checkBox" name="checkBoxFotos" style="width: 24px">
                                    <label>Argazkia desegokia da</label>
                                </div>
                                <?php
                                    if (isset($_COOKIE["dark"])) {
                                        if ($_COOKIE["dark"] == "on") {
                                            ?>
                                            <textarea name="mesua" id="mesua" rows="8" cols="50" maxlength="150" placeholder="Arrazoiak" class="textareaForm border-white" requiredstyle="resize: none;"></textarea>
                                            <?php
                                        } else {
                                            ?>
                                            <textarea name="mesua" id="mesua" rows="8" cols="50" maxlength="150" placeholder="Arrazoiak" class="textareaForm" required style="resize: none;"></textarea>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <textarea name="mesua" id="mesua" rows="8" cols="50" maxlength="150" placeholder="Arrazoiak" class="textareaForm" required style="resize: none;"></textarea>
                                        <?php
                                    }
                                ?>
                                
                                <span id="mezuaErrorea"></span><br>
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <div class="iragarkiaGaitu">
                                    <input type="submit" id="bidali" value="Bidali" class="gaitzekoBotoiakOndo">
                                    <input type="submit" name="itzuli" value="Itzuli" class="gaitzekoBotoiakTxarto">
                                </div>
                                </form>
                                <br>
                                <?php
                                if (isset($_POST["itzuli"])) {
                                    header("Location: adminpage.php?id=2");
                                }
                            }
                        } else {
                        ?>
                        <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                        <?php
                        echo "Erabiltzailea ez da existitzen";
                    }
                }
            }
            ?>
        </div>
        <script>
            window.addEventListener("load", inicioErabEzGaitu, false);
            window.addEventListener("load", inicioMenu, false);

            function inicioErabEzGaitu() {
                let botoia = document.getElementById("bidali");
                botoia.addEventListener("click", validatuEzGaitua, false);
            }

            function validatuEzGaitua(e) {
                let mesua = document.getElementById("mesua").value;
                let spanMesua = document.getElementById("mezuaErrorea");
                if (validaText(mesua, spanMesua) && confirm("Ziur zaude erabiltzailea ez gaitu nahi duzula?")) {
                    // Bidalita
                } else {
                    e.preventDefault();
                }
            }

            function goBack() {
                location.href = "adminpage.php?id=2";

            }
        </script>
    </div>
    <?php
    include("footer.php");
    ?>
</body>


</html>