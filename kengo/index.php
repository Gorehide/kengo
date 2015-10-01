<?php
ob_start();
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$estilou="";
if(!isset($_SESSION['admin'])) $estilou="circulos";
include ("config/config.php");
include ("includes/funciones.php");
include ("includes/html_func.php");
include ("includes/conectar.php");
include ("includes/idiomas.php");
include ("includes/iva.php");
include ("includes/krumo/class.krumo.php");
//CARGA DE LA ESTRUCTURA DEL KENGO
include ("html/html.php");
?>
