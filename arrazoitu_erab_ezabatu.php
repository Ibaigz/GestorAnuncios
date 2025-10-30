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
    <title>Erabiltzailea Ezabatu</title>
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
            if ($erabiltzailea != null && $erabiltzailea["rol"] == 0) {
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
                    $sqlErabAuk = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :id";
                    $stmt = $pdo->prepare($sqlErabAuk);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $erab = $stmt->fetch();
                        if ($erab["egiaztatua"] == 0) {
                            ?>
                            <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                            <?php
                            if (isset($_COOKIE["dark"])) {
                                if ($_COOKIE["dark"] == "on") {
                                    ?>
                                    <p class="text-white"><br>Erabiltzailea ez dago egiaztatuta</p>
                                    <?php
                                } else {
                                    ?>
                                    <p><br>Erabiltzailea ez dago egiaztatuta</p>
                                    <?php
                                }
                            } else {
                                ?>
                                <p><br>Erabiltzailea ez dago egiaztatuta</p>
                                <?php
                            }
                        } else {
                            if ($erab["id_erabiltzailea"] == $erabiltzailea["id_erabiltzailea"]) {
                                ?>
                                <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                                <?php
                                if (isset($_COOKIE["dark"])) {
                                    if ($_COOKIE["dark"] == "on") {
                                        ?>
                                        <p class="text-white"><br>Ezin duzu zure erabiltzailea ezabatu</p>
                                        <?php
                                    } else {
                                        ?>
                                        <p><br>Ezin duzu zure erabiltzailea ezabatu</p>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <p><br>Ezin duzu zure erabiltzailea ezabatu</p>
                                    <?php
                                }
                            } else {
                                ?>
                                <button onclick="goBack()" class="atzeraBotoia">&#8249;</button><br>
                                <?php
                                if (isset($_COOKIE["dark"])) {
                                    if ($_COOKIE["dark"] == "on") {
                                        ?>
                                        <h3 class="text-white">Arrazoitu "<a href="perfilaAdmin.php?id=<?php echo $erab["id_erabiltzailea"] ?>"  class="linkIragarkia text-white"><?php echo $erab["erabiltzailea"] ?></a>" erabiltzailearen ezabatzea:</h3>
                                        <?php
                                    } else {
                                        ?>
                                        <h3>Arrazoitu "<a href="perfilaAdmin.php?id=<?php echo $erab["id_erabiltzailea"] ?>"  class="linkIragarkia"><?php echo $erab["erabiltzailea"] ?></a>" erabiltzailearen ezabatzea:</h3>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h3>Arrazoitu "<a href="perfilaAdmin.php?id=<?php echo $erab["id_erabiltzailea"] ?>"  class="linkIragarkia"><?php echo $erab["erabiltzailea"] ?></a>" erabiltzailearen ezabatzea:</h3>
                                    <?php
                                }
                                ?>
                                
                                <form action="email.php?id=5" method="post">
                                    <?php
                                        if (isset($_COOKIE["dark"])) {
                                            if ($_COOKIE["dark"] == "on") {
                                                ?>
                                                <textarea name="mesua" id="mesua" rows="4" cols="50" maxlength="150" placeholder="Arrazoiak" class="textareaForm border-white" required></textarea>
                                                <?php
                                            } else {
                                                ?>
                                                <textarea name="mesua" id="mesua" rows="4" cols="50" maxlength="150" placeholder="Arrazoiak" class="textareaForm" required></textarea>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <textarea name="mesua" id="mesua" rows="4" cols="50" maxlength="150" placeholder="Arrazoiak" class="textareaForm" required></textarea>
                                            <?php
                                        }
                                    ?>
                                    
                                    <span id="mezuaErrorea"></span>
                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                    <input type="submit" id="bidali" value="Bidali" class="gaitzekoBotoiakOndo">
                                </form>
                                <?php
    
                            }
                        }
                    } else {
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
                    }
            ?>
        </div>
        <?php
                }
            } else {
                header("Location: index.php");
            }
        ?>
        <script>
            window.addEventListener("load", inicioErabEzab, false);
            window.addEventListener("load", inicioMenu, false);

            function inicioErabEzab() {
                let botoia = document.getElementById("bidali");
                botoia.addEventListener("click", validatuErabEzab, false);
            }

            function validatuErabEzab(e) {
                let mesua = document.getElementById("mesua").value;
                let spanMesua = document.getElementById("mezuaErrorea");
                if (validaText(mesua, spanMesua) && confirm("Ziur zaude erabiltzailea ezabatu nahi duzula?")) {
                    // Bidalita
                } else {
                    e.preventDefault();
                }
            }

            function goBack() {
                location.href = "adminpage.php?id=1";
            }
        </script>
    </div>
    <?php
    include("footer.php");
    ?>
</body>
</html>