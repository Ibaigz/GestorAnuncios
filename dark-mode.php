<?php
    $id = null;
    $nora = null;

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        if ($id == 1) {
            // light
            // 30 eguneko cookiea
            setcookie("dark", "off", 2592000 + time(), "/");
            echo '<script>window.history.go(-1);</script>';
        } else {
            // dark
            // 30 eguneko cookiea
            setcookie("dark", "on", 2592000 + time(), "/");
            echo '<script>window.history.go(-1);</script>';
        }
    } else {
        echo '<script>window.history.go(-1);</script>';
    }
?>