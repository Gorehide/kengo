<?php
include ("../config/config.php");
include ("../includes/conectar.php");
$sql = "SELECT numero, titulo
FROM kng_proformas
ORDER BY numero DESC";
$res = mysql_query($sql);
$max = mysql_fetch_array($res);
$numero = $max['numero']+1; 
$row = mysql_fetch_array($res);
echo $numero.'<br /><br />';
//ALMACENAMOS LA PROFORMA											
$sql = "INSERT INTO kng_proformas
(numero, cliente, fecha, presupuesto, titulo)
VALUES ('".$numero."', '".$_GET['cliente']."', '".date("Y-m-d")."', '".$_GET['presu']."', '".$_GET['titulo']."')";
mysql_query($sql);
$id = mysql_insert_id();
//BUSCAMOS LOS CONCEPTOS DEL PRESU Y LOS CREAMSO PARA LA PROFORMA		
$sql = "SELECT concepto, precio, cantidad, num
FROM kng_conceptos
WHERE activo = '1'
AND borrado = '0'
AND presupuesto = '".$_GET['presu']."'
ORDER BY num";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res))
{
	$sql2 = "INSERT INTO kng_conceptos
	(proforma, num, concepto, precio, cantidad)
	VALUES ('".$id."', '".$row['num']."', '".$row['concepto']."', '".$row['precio']."', '".$row['cantidad']."')";
	mysql_query($sql2);	
}
//echo "Lista la factura del presupuesto ".$_GET['presu'];
?>