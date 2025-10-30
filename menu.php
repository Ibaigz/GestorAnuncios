<link rel="stylesheet" href="assets/style.css">


<div class="container">
    <div class="Logoa">
        <img src="media/logo.png" alt="Logo" width="150px">
    </div>
    <div class="Nav">
        <nav class="normal">
            <ul>
                <li><a href="index.php">Iragarkiak</a></li>
                <?php
                        if ($erabiltzailea != null) {
                            if ($erabiltzailea["rol"] == 0) {
                                echo "<li><a href='adminpage.php'>Admin</a></li>";
                            }
                        }
                        ?>
                <li><a href="iragarkiaSortu.php">Iragarkia sortu</a></li>
                <li><a href="kontaktua.php">Kontaktua</a></li>
                <?php
                        if ($erabiltzailea != null) {
                            $fitxategia = "media/erabiltzaileak/" . $erabiltzailea["id_erabiltzailea"] . "." . $erabiltzailea["extensioa"];
                            if (file_exists($fitxategia)) {
                                echo "<li><a href='perfila.php'><img class='imgBorobila' src='" . $fitxategia . "' alt='profila'></a></li>";
                            } else {
                                echo "<li><a href='perfila.php'><img class='imgBorobila' src='media/erabiltzaileak/perfil.png' alt='profila'></a></li>";
                            }
                        } else {
                            echo "<li><a href='login.php'>Sartu</a></li>";
                        }

                        if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                echo "<li id='lightli'><img src='media/icons/light_mode.svg' alt='light' id='light' class='bilatuIcon'></li>";
                                echo "<li id='darkli' style='display: none'><img src='media/icons/dark_mode.svg' alt='dark' id='dark'></li>";
                            } else {
                                echo "<li id='lightli' style='display: none'><img src='media/icons/light_mode.svg' alt='light' id='light' class='bilatuIcon'></li>";
                                echo "<li id='darkli'><img src='media/icons/dark_mode.svg' alt='dark' id='dark'></li>";
                            }
                        } else {
                            echo "<li id='lightli' style='display: none'><img src='media/icons/light_mode.svg' alt='light' id='light' class='bilatuIcon'></li>";
                            echo "<li id='darkli'><img src='media/icons/dark_mode.svg' alt='dark' id='dark'></li>";
                        }
                        ?>
            </ul>
        </nav>



        <div class="burger">
            <?php
            if (isset($_COOKIE["dark"])) {
                if ($_COOKIE["dark"] == "on") {
                    ?>
                    <div class="hamburger-menu-icon" onclick="toggleMenu()"><img class="burger-icon bilatuIcon" src="media/icons/menu-icon.svg" alt=""></div>
                    <?php
                } else {
                    ?>
                    <div class="hamburger-menu-icon" onclick="toggleMenu()"><img class="burger-icon" src="media/icons/menu-icon.svg" alt=""></div>
                    <?php
                }
            } else {
                ?>
                <div class="hamburger-menu-icon" onclick="toggleMenu()"><img class="burger-icon" src="media/icons/menu-icon.svg" alt=""></div>
                <?php
            }
            ?>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Iragarkiak</a></li>
                    <?php
                    if ($erabiltzailea != null) {
                        if ($erabiltzailea["rol"] == 0) {
                            echo "<li><a href='adminpage.php'>Admin</a></li>";
                        }
                    }
                    ?>
                    <li><a href="iragarkiaSortu.php">Iragarkia sortu</a></li>
                    <li><a href="kontaktua.php">Kontaktua</a></li>
                    <?php
                    if ($erabiltzailea != null) {
                        $fitxategia = "media/erabiltzaileak/" . $erabiltzailea["id_erabiltzailea"] . "." . $erabiltzailea["extensioa"];
                        if (file_exists($fitxategia)) {
                            echo "<li><a href='perfila.php'><img class='imgBorobila' src='" . $fitxategia . "' alt='profila'></a></li>";
                        } else {
                            echo "<li><a href='perfila.php'><img class='imgBorobila' src='media/erabiltzaileak/perfil.png' alt='profila'></a></li>";
                        }
                    } else {
                        echo "<li><a href='login.php'>Sartu</a></li>";
                    }

                    if (isset($_COOKIE["dark"])) {
                            if ($_COOKIE["dark"] == "on") {
                                echo "<li id='lightli1'><img src='media/icons/light_mode.svg' alt='light' id='light1'></li>";
                                echo "<li id='darkli1' style='display: none'><img src='media/icons/dark_mode.svg' alt='dark' id='dark1'></li>";
                            } else {
                                echo "<li id='lightli1' style='display: none'><img src='media/icons/light_mode.svg' alt='light1' id='light'></li>";
                                echo "<li id='darkli1'><img src='media/icons/dark_mode.svg' alt='dark' id='dark1'></li>";
                            }
                        } else {
                            echo "<li id='lightli1' style='display: none'><img src='media/icons/light_mode.svg' alt='light1' id='light'></li>";
                            echo "<li id='darkli1'><img src='media/icons/dark_mode.svg' alt='dark' id='dark1'></li>";
                        }

                    ?>
                </ul>
            </div>

        </div>
    </div>

</div>





<script>
    function toggleMenu() {
        var menu = document.querySelector('.menu');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
</script>