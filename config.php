<?php

// ühendus andmebaasiga
$kasutaja = "nop";
$dbserver = "localhost";
$andmebaas = "tallinna_maraton";
$pw = "parool";

$conn = mysqli_connect($dbserver, $kasutaja, $pw, $andmebaas);
if(!$conn){
    // echo "jama majas";
    die("Sa jälle ebaõnnestusid!");
} 

?>