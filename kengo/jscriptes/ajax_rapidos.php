<?php
include("../config/config.php");
include("../includes/conectar.php"); 
$sql = "UPDATE ".$_GET['tabla']." SET ".$_GET['columna']." = '".$_GET['valor']."' WHERE id = '".$_GET['id']."'";
mysql_query($sql);
?>