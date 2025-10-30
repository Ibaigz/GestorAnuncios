<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");

?>
<html>
    <head>
        <title>Logout</title>
    </head>
    <body>
        <script>
            window.localStorage.removeItem("erab");
        </script>
    </body>
</html>