<?php
ob_start();
include("../config/config.php");
include("../includes/conectar.php");
include("../includes/funciones.php");
$iva = ivafecha(date("Y-m-d"));
//ACCESO A LOS DATOS DE LA FACTURA
//
$sql = "SELECT ps.id, ps.fecha, ps.numero, cl.cif, cl.nombre AS clnombre, cl.direccion, cl.cp, ci.nombre AS cinombre, pr.nombre AS prnombre
FROM kng_presupuestos AS ps
LEFT JOIN kng_clientes AS cl ON cl.id = ps.cliente
LEFT JOIN kng_ciudades AS ci ON ci.id = cl.ciudad
LEFT JOIN kng_provincias AS pr ON pr.id = cl.provincia
WHERE ps.id = '".$_GET['id']."'";
//echo $sql;
$res = mysql_query($sql);
mysql_query ("SET NAMES 'utf8'");
$row = mysql_fetch_array($res);
$vowelspor = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "º", "ç", "Ç", "ü", "Ü", " ");
$vowels = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ntilde;", "&Ntilde;", "&deg;", "&ccedil;", "&Ccedil;", "&uuml;", "&Uuml;", "&nbsp;");
//CREACION DEL PDF
include ("../includes/fpdf17/fpdf.php");
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Write(10,'abcdefghijklmnñopqrstuvwxyzáéíóú');

$pdf->Output();