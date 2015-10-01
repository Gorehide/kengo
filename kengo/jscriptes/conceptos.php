<?php
include("../config/config.php");
include("../includes/conectar.php"); 
if($_POST['acc']=="add")
{
	$sql = "INSERT INTO kng_conceptos (factura, num, concepto, precio, cantidad) VALUES ('".$_POST['factura']."', '".$_POST['num']."', '".addslashes($_POST['concepto'])."', '".$_POST['precio']."', '".$_POST['cantidad']."')";
}
else if($_POST['acc']=="dell")
{
	$sql = "DELETE FROM kng_conceptos WHERE num = '".$_POST['id']."' AND factura = '".$_POST['factura']."'";
}
else if($_POST['acc']=="edit")
{
	$sql = "UPDATE kng_conceptos SET concepto = '".$_POST['concepto']."', precio = '".$_POST['precio']."', cantidad = '".$_POST['cantidad']."' WHERE id = '".$_POST['id']."'";
}
mysql_query($sql);
//echo $sql;
?>