<?php
    session_start();

    include("db_konexioa.php");

    $erabiltzailea = null;
    $id = null;
    $pagination = null;

    if(!empty($_SESSION['erabiltzailea'])){
        $sqlErabiltzailea = "SELECT * FROM erabiltzaileak WHERE id_erabiltzailea = :erabiltzailea";
        $stmt = $pdo->prepare($sqlErabiltzailea);
        $stmt->bindParam(':erabiltzailea', $_SESSION['erabiltzailea']);
        $stmt->execute();
        $erabiltzailea = $stmt->fetch();
    }

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 1;
    }

    if (!empty($_GET["pagination"])) {
        $pagination = $_GET["pagination"];
    } else {
        $pagination = 1;
    }
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administratzaileen orrialdea</title>
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
        <div>
            <?php
            if ($erabiltzailea != null && $erabiltzailea["rol"] == 0) {
                ?>
                <div class="tab">
                    <button class="tablinks" onclick="openTab('Erabiltzaileak')">Erabiltzaileak</button>
                    <button class="tablinks" onclick="openTab('Gaitzeko erabiltzaileak')">Gaitzeko Erabiltzaileak</button>
                    <button class="tablinks" onclick="openTab('Administratzaileak')">Administratzaileak</button>
                    <button class="tablinks" onclick="openTab('Iragarkiak')">Iragarkiak</button>
                    <button class="tablinks" onclick="openTab('Gaitzeko Iragarkiak')">Gaitzeko Iragarkiak</button>
                    <button class="tablinks" onclick="openTab('Kategoriak')">Kategoriak</button>
                </div>

                <div id="info-modal" class="modal">
                    <?php
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <div class="modal-content info-modal-oscuro">
                                <?php
                            } else {
                                ?>
                                <div class="modal-content">
                                <?php
                            }
                        } else {
                            ?>
                            <div class="modal-content">
                            <?php
                        }
                    ?>
                        <p>Ondorengoak dira botoien funtzioak:</p>
                        <div class="botoiak-dialog">
                            <button type="button" class="botoiaGorriaInfo"><img src="media/icons/erabiltzailea_ezabatu.svg" alt="Erabiltzailea Ezabatzeko"></button>
                            <p>Erabiltzailea ezabatzeko botoia</p>
                        </div>
                        <div class="botoiak-dialog">
                            <button type="button" class="botoiaBerdeaInfo"><img src="media/icons/erabiltzailea_admin_gehitu.svg" alt="Erabiltzailea admin modura gehitu"></button>
                            <p>Administratzaile bahimenak emateko botoia</p>
                        </div>
                        <div class="botoiak-dialog">
                            <button type="button" class="botoiaGorriaInfo"><img src="media/icons/erabiltzailea_admin_ezabatu.svg" alt="Erabiltzailea admin modetik kendu"></button>
                            <p>Administratzaile bahimenak kentzeko botoia</p>
                        </div>
                        <div class="botoiak-dialog">
                            <button type="button" class="botoiaBerdeaInfo"><img src="media/icons/check.svg" alt="check"></button>
                            <p>Erabiltzaileak edo iragarkiak gaitzeko botoia</p>
                        </div>
                        <div class="botoiak-dialog">
                            <button type="button" class="botoiaGorriaInfo"><img src="media/icons/close.svg" alt="close"></button>
                            <p>Erabiltzaileak edo iragarkiak ez gaitzeko botoia edo kategoria ezabatzeko botoia</p>
                        </div>
                        <div class="botoiak-dialog">
                            <button type='button' class='botoiaGorriaInfo'><img src='media/icons/iragarkiaKendu.svg' alt='iragarkia kendu'></button>
                            <p>Iragarkia ezabatzeko botoia</p>
                        </div>
                        <div class="botoiak-dialog">
                            <button type="button" class="botoiaUrdinaInfo"><img src="media/icons/edit.svg" alt="Kategoria Editatuta"></button>
                            <p>Iragarkia editatzeko botoia</p>
                        </div>
                        <div class="botoiak-dialog">
                            <button type="button" class="botoiaBerdeaInfo"><img src="media/icons/add.svg" alt="Kategoria Gehitu"></button>
                            <p>Iragarkia gehitzeko botoia</p>
                        </div>
                        <button id="close-modal" class="botoiaGorriaInfoItxi">ITXI</button>
                    </div>
                </div>

                <div id="help-modal" class="modal">
                    <?php
                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                ?>
                                <div class="modal-content info-modal-oscuro">
                                <?php
                            } else {
                                ?>
                                <div class="modal-content">
                                <?php
                            }
                        } else {
                            ?>
                            <div class="modal-content">
                            <?php
                        }
                    ?>
                        <p>Ondorengo ikonoek ekitaldia edo iragarkiaren informazioa ematen dute:</p>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/bidalketa.svg' alt='bidalketa'>
                            </div>
                            <p>Bidalketa gaituta badago</p>
                        </div>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/data_hasi_lehen.svg' alt='Ekitaldia hasi gabe' class='hasi_gabeInfo'>
                            </div>
                            <p>Ekitaldia hasi gabe badago</p>
                        </div>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/data_hasita.svg' alt='Ekitaldia hasita' class='hasitaInfo'>
                            </div>
                            <p>Ekitaldia hasita badago</p>
                        </div>
                        <div class="botoiak-dialog">
                            <div class="borobilakInfo">
                                <img src='media/icons/data_bukatuta.svg' alt='Ekitaldia bukatuta' class='bukatutaInfo'>
                            </div>
                            <p>Ekitaldia bukatuta badago</p>
                        </div>
                        <button id="close-modal-help" class="botoiaGorriaInfoItxi">ITXI</button>
                    </div>
                </div>

                <div id="Erabiltzaileak" class="tabcontent">
                    <?php
                    include("adminPageErabiltzaileak.php");
                    ?>
                </div>

                <div id="Gaitzeko erabiltzaileak" class="tabcontent">
                    <?php
                    include("adminPageGaitzekoErab.php");
                    ?>
                </div>

                <div id="Administratzaileak" class="tabcontent">
                    <?php
                    include("adminPageAdminsitratzaileak.php");
                    ?>
                </div>

                <div id="Iragarkiak" class="tabcontent">
                    <?php
                    include("adminPageIragarkiak.php");
                    ?>
                </div>

                <div id="Gaitzeko Iragarkiak" class="tabcontent">
                    <?php
                    include("adminPageGaitzekoIragarkiak.php");
                    ?>
                </div>

                <div id="Kategoriak" class="tabcontent">
                    <?php
                    include("adminPageKategoriak.php");
                    ?>
                </div>

                <div id="kategoriaAdd" class="kategoriaAdd" style="display: none;">
                    <button class="botoiaKategoriaGehitu"><img src="media/icons/add.svg" alt="Kategoria Gehitu" class="iconoKategoriaGehitu"></button>
                </div>

                <?php
            } else {
                header("Location: index.php");
            }
            ?>
            <script>
                window.addEventListener("load", inicioAdminPage);
                window.addEventListener("load", nav);
                window.addEventListener("load", dialog);
                window.addEventListener("load", inicioMenu);

                function nav() {
                    let id = <?php echo $id ?>;
                    switch (id) {
                        case 1:
                            openTab1(0, "Erabiltzaileak");
                            break;
                        case 2:
                            openTab1(1, "Gaitzeko erabiltzaileak");
                            break;
                        case 3:
                            openTab1(2, "Administratzaileak");
                            break;
                        case 4:
                            openTab1(3, "Iragarkiak");
                            break;
                        case 5:
                            openTab1(4, "Gaitzeko Iragarkiak");
                            break;
                        case 6:
                            openTab1(5, "Kategoriak");
                            break;
                        default:
                            openTab1(0, "Erabiltzaileak");
                            break;
                    }
                }

            </script>
        </div>
    </div>
    <?php
        include("footer.php");
    ?>

    <script>
        window.addEventListener("load", inicioMenu);
    </script>
</body>
</html>