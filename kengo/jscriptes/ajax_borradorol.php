<?php
if ($_GET['id']>"1")
{
	include("../config/config.php");
	include("../includes/conectar.php");
	$sql = "DELETE FROM zkng_roles WHERE id = '".$_GET['id']."' LIMIT 1";
        mysql_query($sql);
        $sql = "DELETE FROM zkng_rolmenu WHERE rolmenu_rol = '".$_GET['id']."'";
        mysql_query($sql);
}
?>