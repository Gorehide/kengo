<?php
include("../config/config.php");
include("../includes/conectar.php"); 
if($_POST['acc']=="add")
{
	$sql = "INSERT INTO kng_conceptos (presupuesto, num, concepto, precio, cantidad) VALUES ('".$_POST['presupuesto']."', '".$_POST['num']."', '".$_POST['concepto']."', '".$_POST['precio']."', '".$_POST['cantidad']."')";
}
else if($_POST['acc']=="dell")
{
	$sql = "DELETE FROM kng_conceptos WHERE num = '".$_POST['id']."' AND presupuesto = '".$_POST['presupuesto']."'";
}
else if($_POST['acc']=="edit")
{
	$sql = "UPDATE kng_conceptos SET concepto = '".$_POST['concepto']."', precio = '".$_POST['precio']."', cantidad = '".$_POST['cantidad']."' WHERE id = '".$_POST['id']."'";
}
mysql_query($sql);
//echo mysql_insert_id();
//echo $sql;
?>