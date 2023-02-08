<?php
    $ipServerSQL ="localhost";
    $NomBase = "Shop";
    $UserBDD = "root";
    $PassBDD = "root";
    try {
        $BasePDO = new PDO('mysql:host='.$ipServerSQL.';dbname='.$NomBase.';port=3306',$UserBDD, $PassBDD);
    }catch (Exception $e) {
        echo $e->getMessage();
        }
    ?>