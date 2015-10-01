<?php
include("../config/config.php");
include("../includes/conectar.php"); 
$sql = "DELETE FROM ".$_GET['tabla']." WHERE id = '".$_GET['id']."' LIMIT 1";
mysql_query($sql);
echo $sql;
?>