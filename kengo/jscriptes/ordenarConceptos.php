<?php
include("../config/config.php");
include("../includes/conectar.php"); 
var_dump($_POST['concepto']);
$numi = 1;

foreach($_POST['concepto'] AS $cpt)
{
    $sql = "UPDATE kng_conceptos SET num = '".$numi."' WHERE id = '".$cpt."'";
    mysql_query($sql);
    $numi++;
}
?>