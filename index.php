<?php
header('Content-type: text/html; charset=utf-8');

require_once __DIR__ . '/vendor/autoload.php';

use BemPHP\BemPHP;
use BemPHP\Tree;

BemPHP::includeBlocksList('*');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
        <title>BemPHP - v1.1</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

        <?php
            echo "<style>
                    body{
                        background-color: #000000;
                        color: #ffffff;
                    }";
            print_r(BemPHP::getCss());
            echo "</style>";
        ?>
</head>
<body>
v1.1

    <?php

       echo Tree::html('b-bemphp-logo');
       echo BemPHP::showLogger();
    ?>

<script >
    $(document).ready(function(){

        <?php
            print_r(BemPHP::getJs());
         ?>

    });
</script>
</body>
</html>