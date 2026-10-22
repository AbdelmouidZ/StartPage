<?php
include("parts/credentials.php");
include("parts/connect.php");
include("parts/funcs.php");
include("parts/vars.php");
include("parts/protocol.php");
?>
<html>
    <head>
        <title>Welcome</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            include("tronc/$protocol.php");
        ?>
    </body>
</html>
