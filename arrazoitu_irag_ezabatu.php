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
    <title>Iragarkia ezabatu</title>
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
                    echo "Iragarkia ez da existitzen";
                } else {
                    $sqlIragarkia = "SELECT * FROM iragarkiak WHERE id_iragarkia = :id";
                    $stmt = $pdo->prepare($sqlIragarkia);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $iragarkia = $stmt->fetch();
                        ?>
                        <button onclick="goBack()" class="atzeraBotoia">&#8249;</button>
                        <?php
                                if (isset($_COOKIE["dark"])) {
                                    if ($_COOKIE["dark"] == "on") {
                                        ?>
                                        <h3 class="text-white">Arrazoitu "<a href="iragarkiaAdmin.php?id=<?php echo $iragarkia["id_iragarkia"] ?>"  class="linkIragarkia text-white"><?php echo $iragarkia["izena"] ?></a>" izeneko iragarkia ezabatzea:</h3>
                                        <form action="email.php?id=8" method="post" class="formAdmin formAdminDivOscuro" onsubmit="validaCheckBox()">
                                        <?php
                                    } else {
                                        ?>
                                        <h3>Arrazoitu "<a href="iragarkiaAdmin.php?id=<?php echo $iragarkia["id_iragarkia"] ?>"  class="linkIragarkia"><?php echo $iragarkia["izena"] ?></a>" izeneko iragarkia ezabatzea:</h3>
                                        <form action="email.php?id=8" method="post" class="formAdmin" onsubmit="validaCheckBox()">
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h3>Arrazoitu "<a href="iragarkiaAdmin.php?id=<?php echo $iragarkia["id_iragarkia"] ?>"  class="linkIragarkia"><?php echo $iragarkia["izena"] ?></a>" izeneko iragarkia ezabatzea:</h3>
                                    <form action="email.php?id=8" method="post" class="formAdmin" onsubmit="validaCheckBox()">
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
                            <input type="submit" id="bidali" value="Bidali" class="gaitzekoBotoiakOndo">
                        </form>
                        <?php
                    } else {
                        ?>
                        <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                        <?php
                        echo "Iragarkia ez da existitzen";
                    }
                    ?>
        </div>
        <?php
                }
            }
        ?>
        <script>
            window.addEventListener("load", inicioErabEzGaitu, false);

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
                location.href = "adminpage.php?id=4";
            }

        window.addEventListener("load", inicioMenu);

        </script>
    </div>

    <?php
        include("footer.php");
    ?>
</body>



</html>