<?php
$k_desarrollo = 1;
date_default_timezone_set("Europe/Madrid");
//KENGO
$k_url = "http://www.kengocms.com";
$k_version = "0.5";
$k_mail = "mikel@bikuma.com";
$k_description = "";
$k_keywords = "";
//PROJECTO
$k_cliente = "Nombre de la empresa";
$k_cliente_mail = "admin@yoursite.com";
//BBDD
$k_pathbd = "";
$k_userbd = "";
$k_passbd = "";
$k_bbdd = "";
//ESTILOS KENGO
$colorprimario = '#DC0066';
$colorsecundario = '#9C0D67';
$letratam = '10px'; //TAMANO BASE DE LA FUENTE
$colorletra = '#333333'; //COLOR GENERAL DE LA FUENTE
$bgcolor = '#000F0E'; //COLOR DEL FONDO DEL GESTOR
//VARIOS COLORES GENERICOS USADOS
$bg_rojo = '#CC0000';
$bg_verde = '#66CC33';
$bg_azul = '#0066CC';
$bg_gris = '#999999';
//CALENDARIO
$colordia = "#D8E4B2";
//RUTAS
$k_pathkol = "http://www.yoursite.com/"; // LA RUTA A LA WEB EN LOCAL O HTTP://WWW.LOQUESEA.COM/
//PARA ESTADO EN DESARROLLO
if($k_desarrollo == 1)
{
	$k_cliente_mail = "";
	$k_pathbd = "";
	$k_userbd = "";
	$k_passbd = "";
	$k_bbdd = "";
	$k_pathkol = "";
}
//DEFINICION DE CONSTANTES
define("BASEURL","".$k_pathkol."kengo/");
define("BASEURLX","".$k_pathkol."");
define("BASEURLA","".$k_pathkol."archivos/");
define("BASEURLM","".$k_pathkol."minis/");
?>
