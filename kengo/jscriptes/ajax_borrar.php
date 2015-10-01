<?php
include("../config/config.php");
include("../includes/conectar.php"); 
$sql = "UPDATE ".$_GET['tabla']." SET borrado='".$_GET['estado']."' WHERE id = '".$_GET['id']."'";
echo $sql;
mysql_query($sql);
?>