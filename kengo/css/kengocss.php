<?php
include ("../config/config.php");
/*** set the content type header ***/
header("Content-type: text/css");
function HexToRGB($hex)
{
	$hex = ereg_replace("#", "", $hex);
	$color = array();
	if(strlen($hex) == 3) {
		$color['r'] = hexdec(substr($hex, 0, 1) . $r);
		$color['g'] = hexdec(substr($hex, 1, 1) . $g);
		$color['b'] = hexdec(substr($hex, 2, 1) . $b);
	}
	else if(strlen($hex) == 6) {
		$color['r'] = hexdec(substr($hex, 0, 2));
		$color['g'] = hexdec(substr($hex, 2, 2));
		$color['b'] = hexdec(substr($hex, 4, 2));
	}
	echo $color['r'].','.$color['g'].','.$color['b'];
}
function borderr($radios)
{
	echo '-moz-border-radius: '.$radios.';';
	echo '-webkit-border-radius: '.$radios.';';
	echo 'border-radius: '.$radios.';';
}
function boxs($sombra)
{
	echo '-moz-box-shadow: '.$sombra.';';
	echo '-webkit-box-shadow: '.$sombra.';';
	echo 'box-shadow: '.$sombra.';';
}
function gradi($color1, $color2, $grad="0")
{
	echo 'background-color: '.$color1.';';
	//chrome 10+, safari 5.1+
	echo 'background-image: -webkit-linear-gradient('.$grad.'deg,'.$color1.','.$color2.');';
	//firefox; multiple color stops
	echo 'background-image:-moz-linear-gradient('.$grad.'deg,'.$color1.', '.$color2.');';
	//ie10
	echo 'background-image: -ms-linear-gradient('.$grad.'deg,'.$color1.' 0%,'.$color2.' 100%);';
	//opera 11.1
	echo 'background-image: -o-linear-gradient('.$grad.'deg,'.$color1.', '.$color2.');';
	//The "standard"
	echo 'background-image: linear-gradient('.$grad.'deg,'.$color1.', '.$color2.');';
}
?>
html {
	height: 100%;
	z-index: 1;
}
body {
	height: 100%;
	margin: 0px;
	padding: 0px;
	font-family: Verdana, Arial, "daniel";
	font-size: <?php echo $letratam; ?>;
	color: <?php echo $colorletra; ?>;
	text-shadow: 1px 1px 0px #CCCCCC;
	background-color: <?php echo $bgcolor; ?>;
	cursor: default;
	text-align: left;
}
.circulos {
	<?php gradi($colorprimario, $colorsecundario); ?>
	text-shadow: 0px 0px 2px #000000;
	color: #FFFFFF;
}
.circulos td, .circulos th {
	border: none;
}
.circulos a {
	color: #FFFFFF !important;
}
.todo {
	width: 100%;
	height: auto;
	min-height: 100%;
}
.inicio {
	text-align: center;
}
/*TOP*/
.top {
	width: 100%;
	height: 66px;
	<?php gradi($colorprimario, $colorsecundario); ?>
	border-top: 10px solid #AAAAAA;
	border-bottom: 1px solid #000000;
	position: fixed;
	top: 0px;
	z-index: 10;
	<?php boxs('5px 5px 10px #000000'); ?>
	color:#DDDDDD;
	text-shadow:0px 0px 3px #000000;
}
.top .logokengo{
	float: left;
	width:25%;
}
.top .logokengo a{
	color: #FFF;
	display: block;
	padding: 1em;
	font-size: 1em;
	letter-spacing: 0.1em;
}
.top .logokengo a b{
	font-size: 3em;
	letter-spacing: 0em;
}
.top .tittop {
	float: left;
	font-size: 16px;
	padding-top: 30px;
	text-align: center;
	text-transform: uppercase;
	width: 50%;
}
.top .men {
	float: left;
	width: 25%;
	padding-top: 30px;
	text-align: right;
}
.top .men a{
	cursor: pointer;
}
/*CENTRO*/
.centro {
	padding: 0px 0px 85px 0px;
	margin-top: 76px;
}
/*CONTENIDO*/
.contenido {
	margin : 0px 0px 0px 265px;
	background-color: <?php echo $colorprimario; ?>;
	<?php borderr('0px 0px 0px 10px'); ?>
}
.contenidotop {
	height: 15px;
	font-size: 12px;
	font-weight: bold;
	padding: 9px 0px;
	text-align: center;
	text-transform: uppercase;
	border-bottom: 1px solid #666666;
	color: #FFFFFF;
	text-shadow: -1px -1px 0px #111111;
}
.contenidobottom {
	height: 32px;
	border: 1px solid #000000;
	border-top: none;
	<?php borderr('0px 0px 0px 10px'); ?>
}
.contenidocentro {
	padding: 10px;
	/*border-top: 1px solid #CCCCCC;
	border-bottom: 1px solid #FFFFFF;*/
	background-color: #CCCCCC;
	border: 1px solid #000000;
	border-bottom: none;
}
.explicacion {
	text-align: center;
	color: #FFFFFF;
	border: 1px solid #333333;
	padding: 10px;
	background-color: #698AAF;
}
.filer {
	background-color: #9188FF;
	border: 1px solid #FFFFFF;
	color: #FFFFFF;
	text-shadow: none;
	padding: 10px;
	margin-bottom: 10px;
	<?php borderr('5px'); ?>
	<?php boxs('0px 0px 5px #000000'); ?>
}
.buscador {
	padding: 10px !important;
	background-color: <?php echo $colorprimario; ?> !important;
	text-align: center !important;
	color: #FFFFFF;
	text-shadow: 0px 0px 2px #000000;
	margin-bottom: 5px;
	text-transform: uppercase;
	font-weight: bold;
}
#ocultar, #galoculta {
	padding: 5px 10px;
	display: block;
	background-color: <?php echo $colorprimario; ?>;
	<?php borderr('5px'); ?>
	<?php boxs('0px 0px 5px #000000'); ?>
	border: 1px solid #FFFFFF;
	margin: auto;
	margin-top: 10px;
	width: 80%;
	text-align: center;
	color: #FFFFFF;
	text-shadow: 0px 0px 2px #000000;
}
#capaoculta, #galeriaoculta {
	/*background-color: #993366;
	<?php borderr('10px'); ?>
	padding: 10px;*/
	margin-top: 10px;
}
/*LOGIN*/
.gestiform {
	width: 550px;
	height: 240px;
	margin: auto;
	padding-top: 12px;
	background-image: url("../imagenes/login.png");
	background-repeat: no-repeat;
	text-shadow: none;
	color: #333333;
	text-shadow: 0px 0px 2px #666666;
}
.gestiform td {
	padding: 0px;
	padding-left: 15px;
	border: none;
}
.gestiform td input[type="text"], .gestiform td input[type="password"] {
	background-color: transparent;
	width: 200px;
	color: #FFFFFF;
	text-shadow: 0px 0px 2px #000000;
	border: none;
}
.gestiform td input[type="image"] {
	margin-top: 30px;
}
.gestiform a {
	color: #333333;
	text-shadow: 0px 0px 2px #666666;
}
.gestiform tr:hover {
	background-color: transparent;
}
/*USERNAME*/
.messagebox{
	border:1px solid #c93;
	background:#ffc;
	padding:3px;
	margin-top: 4px;
	<?php borderr('5px'); ?>
}
.messageboxok{
	border:1px solid #349534;
	background:#C9FFCA;
	padding:3px;
	font-weight:bold;
	color:#008000;

}
.messageboxerror{
	border:1px solid #FF0000;
	background:#F7CBCA;
	padding:3px;
	font-weight:bold;
	color: #FF0000;
}
/*PIE*/
.pie {
	width: 100%;
	/*background-image: url("imagenes/top_bgr.png");
	background-repeat: repeat-x;*/
	background-image: -moz-linear-gradient(65% 79% 90deg, <?php echo $colorsecundario; ?>, <?php echo $colorprimario; ?>) !important;
	<?php gradi($colorsecundario, $colorprimario); ?>
	padding: 15px 0px;
	border-top: 10px solid #AAAAAA;
	text-align: center;
	color: #FFFFFF;
	text-shadow: -1px -1px 0px #333333;
	position: fixed;
	bottom: 0px;
	z-index: 2;
	<?php boxs('0px -5px 10px #000000'); ?>
}
.pie a {
	color: #FFFFFF;
}
/*LINKS*/
a {
	color: #111111;
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
/*INPUTS*/
input[type="text"], input[type="password"] {
	border: 1px solid #666666;
	background-color: #FFFFFF;
	<?php borderr('5px'); ?>
	padding: 3px;
}
.gestiform input[type="text"], .gestiform input[type="password"] {
	background-color: transparent !important;
}
input[type="submit"]{
	border: none;
	background-image: url("../imagenes/btn_stretch.png");
	background-repeat: repeat-x;
	background-position: center;
	background-color: <?php echo $colorprimario; ?> !important;
	padding: 2px 10px;
	border: 1px solid #CCCCCC;
	<?php borderr('5px'); ?>
	color: #FFFFFF;
	text-shadow: 0px 0px 2px #000000;
	<?php boxs('0px 0px 3px #000000'); ?>
	cursor: pointer;
	margin: 3px;
	font-size: 11px;
}
input[type="submit"]:hover {
	background-image: none;
}
select {
	background-color: #FFFFFF;
	padding: 3px;
	<?php borderr('5px'); ?>
}
select option {
	background-color: #CCCCCC;
	border: none;
	border-top: 1px solid #CCCCCC;
	border-bottom: 1px solid #333333;
	color: #333333;
}
textarea {
	border: 1px solid #666666;
	background-color: #FFFFFF;
	width:100%
}
.inputcalendario {
	background-image: url("imagenes/paginadorcal_bgr.png") !important;
	background-repeat: no-repeat !important;
	background-position: 95% center !important;
}
/*ARCHIVOS*/
.archivez {
	float: left;
	width: 100px;
	border: 1px solid #333333;
	margin-right: 5px;
	margin-bottom: 5px;
	<?php borderr('5px'); ?>
	background-color: #FFFFFF;
	background-repeat: no-repeat;
	background-position: center center;
}
.archivezfun {
	background-color: rgba(0, 0, 0, 0.8);
	<?php borderr('5px'); ?>
	padding: 4px;
	text-align: center;
	width: 90%;
	border: 1px solid #FFFFFF;
}
.archivezfun:hover {
	background-color: rgba(0, 0, 0, 1);
	-moz-box-shadow: 0px 0px 10px #FF0000;
	<?php boxs('0px 0px 10px '.$colorprimario); ?>
}
/*GRAFICAS*/
.grafica{

}
.grafica table{

}
.grafica table th{
	width: 350px;
	background-color: transparent;
	border: none;
	border-bottom: 1px solid #FFFFFF;
	<?php borderr('0px'); ?>
	font-weight: normal;
	text-shadow: 0px 1px 0px #FFFFFF;
	color: #333333;

}
.grafica table td{
	background-color: transparent;
	border: none;
	border-bottom: 1px solid #FFFFFF;
	<?php borderr('0px'); ?>
}
.grafica table td .lingraph{
	height: 20px;
	<?php gradi($colorprimario, "#ffc000", "0"); ?>
	<?php borderr('4px'); ?>
}
.grafica table td .lingraph div{
	position: relative;
	top: 4px;
	left: 10px;
	color: #FFFFFF;
	text-shadow: 0px 1px 0px rgba(0,0,0,0.5);
}
.grafica table tr:hover th, .grafica table tr:hover td{
	background-color: #666666;
	color: #FFFFFF;
	text-shadow: 0px -1px 0px rgba(0,0,0,0.5);
}
/*VARIOS*/
.aviso1{
	width: 50%;
	text-align: center;
	<?php borderr('5px'); ?>
	border: 1px solid #FFFFFF;
	<?php boxs('0px 0px 3px #000000'); ?>
	background-color: <?php echo $colorprimario; ?>;
	color: #FFFFFF;
	padding: 5px 0px;
	margin: 10px auto;
	text-shadow: 0px 0px 5px #000000;
	font-weight: bold;
}
.visualizar{
	padding: 0px 10px;
}
.boton_a {
	border: none;
	background-image: url("../imagenes/btn_stretch.png");
	background-repeat: repeat-x;
	background-position: center;
	background-color: <?php echo $colorprimario; ?> !important;
	padding: 4px 12px;
	border: 1px solid #CCCCCC;
	<?php borderr('5px'); ?>
	color: #FFFFFF;
	text-shadow: 0px 0px 2px #000000;
	<?php boxs('0px 0px 3px #000000'); ?>
	cursor: pointer;
	margin: 3px;
	font-size: 11px;
}
.boton_a:hover {
	background-image: none;
}
.finflotar {
	clear: both;
}
.botonton {
	border: none;
	cursor: pointer;
	padding: 6px 20px 7px 10px;
	background-color: #333333;
	background-image: url("imagenes/submit.png");
	background-repeat: no-repeat;
	background-position: right 0px;
	color: #CCCCCC;
}
img {
	border: none;
	outline: none;
}
.separador {
	width: 90%;
	margin: auto;
	margin-top: 10px;
	padding-bottom: 10px;
	background-image: url("imagenes/separador.png");
	background-repeat: repeat-x;
}
/*TEXTOS*/
.tcentrado {
	text-align: center;
}
.tjustificado {
	text-align: justify;
}
.tderecha {
	text-align: right;
}
.tizquierda {
	text-align: left;
}
.negrita {
	font-weight: bold;
}
.l10 {
	font-size: 10px;
}
.l12 {
	font-size: 12px;
}
.l14 {
	font-size: 14px;
}
.l16 {
	font-size: 16px;
}
.l18 {
	font-size: 18px;
}
.l20 {
	font-size: 20px;
}
.may {
	text-transform: uppercase;
}
/*TABLAS*/
table {
}
th {
	background-color: #666666;
	color: #FFFFFF;
	text-shadow: none;
	text-transform: uppercase;
	border: 1px solid #FFFFFF;
	font-size: 8pt;
	padding: 8px 4px;
	<?php borderr('5px'); ?>
}
td {
	padding:4px;
	<?php borderr('5px'); ?>
	border: 1px solid #666666;
}
.tablesorter tr:hover td, .resalt tr:hover td  {
	background-color: <?php echo $colorprimario; ?> !important;
	color: #FFFFFF !important;
	text-shadow: 0px 0px 2px #000000 !important;
	/*background-image: url("../imagenes/btn_stretch.png");
	background-repeat: repeat-x;
	background-position: center;*/
	<?php gradi($colorprimario, $colorsecundario); ?>
	/*font-weight: bold;*/
}
.tablesorter tr:hover td a, .resalt tr:hover td a {
	color: #FFFFFF !important;
}
.par0 {
	background-color: #FFFFFF;
	font-weight: bold;
	text-transform: uppercase;
}
.inpar0 {
	background-color: #F0F0F6;
	font-weight: bold;
	text-transform: uppercase;
}
.par1 {
	background-color: #FFD9E2;
}
.inpar1 {
	background-color: #FFA8BB;
}
.par2 {
	background-color: #CAEEB9;
}
.inpar2 {
	background-color: #A3E184;
}
.par3 {
	background-color: #FFF3C6;
}
.inpar3 {
	background-color: #FFEA97;
}
.formulario {
	padding: 10px;
	background-color: #333333;
	<?php borderr('10px'); ?>
	<?php boxs('0px 0px 10px #000000'); ?>
	border: 1px solid #CCCCCC;
}
.formulario th {
	background-color: #666666;
	color: #FFFFFF;
	border: 1px solid #999999;
	<?php borderr('5px'); ?>
	text-shadow: -1px -1px 0px #333333;
}
.formulario td {
	background-color: #CCCCCC;
	color: #333333;
	<?php borderr('5px'); ?>
	text-shadow: none;
}
.formulario .thtit {
	background-color: <?php echo $colorprimario; ?>;
	padding: 10px;
	text-align: center;
	<?php borderr('10px'); ?>
}
.tdlimpio {
	background-color: transparent !important;
	background-image: none !important;
	border: none !important;
}
.formulario input[type="text"], .formulario input[type="password"], .formulario select {
	border: none;
	/*background-color: transparent;*/
}
.infotabla {
	padding: 10px !important;
	text-align: center;
	margin-bottom: 5px;
	color: #EBEBEB;
	text-transform: uppercase;
	font-weight: bold;
	text-shadow: -1px -1px 0px #333333;
}
/*IFRAME*/
iframe {
	/*border: 2px solid <?php echo $colorprimario; ?>;*/
	<?php boxs('0px 0px 10px #000000'); ?>
}
.mceLast iframe {
	<?php boxs('none'); ?>
}
/*COLORES*/
.bg_rojo {
	background-color: <?php echo $bg_rojo; ?>;
}
.bg_verde {
	background-color: <?php echo $bg_verde; ?>;
}
.bg_azul {
	background-color: <?php echo $bg_azul; ?>;
}
.bg_gris {
	background-color: <?php echo $bg_gris; ?>;
}
.bg_azulgrad {
	<?php gradi("#59799A", "#1C344D"); ?>
}
.bg_rojograd {
	<?php gradi("#CC0000", "#530000"); ?>
}
.bg_verdegrad {
	<?php gradi("#6C9855", "#2E4024"); ?>
}
/*MENU*/
.menu {
	width: 256px;
	float: left;
	<?php borderr('0px 0px 10px 0px'); ?>
	background-color: #333333;
	/*position: fixed;*/
	top: 76px;
	z-index: 9;
	border-bottom: 1px solid #000000;
	border-right: 1px solid #000000;
}
.menutop {
	height: 15px;
	font-size: 12px;
	padding: 9px 0px;
	text-indent: 10px;
}
.menubotontit {
	padding: 10px 5px;
	background-color: #333333;
	color: #FFFFFF;
	text-shadow: 1px 1px 0px #111111;
	font-weight: bold;
	letter-spacing: 5px;
	background-repeat: no-repeat;
	background-position: 10px center;
	padding-left: 50px;
}
.menuboton {
	background-color: #9D9D9D;
	border-bottom: 1px solid #333333;
	border-top: 1px solid #CCCCCC;
	text-shadow: #CCCCCC 1px 1px 0px;
	background-repeat: no-repeat;
	background-position: 6px 4px;
}
.mb2 {
	padding-left: 10px;
	background-color: #C0C0C0;
}
.mb3 {
	padding-left: 10px;
	background-color: #E4E4E4;
}
.mb4 {
	padding-left: 10px;
	background-color: #FFFFFF;
}
.mb5 {
	padding-left: 10px;
	background-color: #DCE1FF;
}
.mb6 {
	padding-left: 10px;
	background-color: #B1BDFF;
}
.mb7 {
	padding-left: 10px;
	background-color: #8093FF;
}
.menuboton a {
	padding: 5px 5px 5px 30px;
	display: block;
}
.menuboton:hover {
	background-color: #666666;
	color: #FFFFFF;
	/*background-position: 10px -17px;*/
}
.menuboton:hover a {
	color: #FFFFFF;
	text-shadow: -1px -1px 0px #333333;
}
.menubotonsel {
	background-color: <?php echo $colorprimario; ?>;
	border-bottom: 1px solid #333333;
	border-top: 1px solid #CCCCCC;
	background-repeat: no-repeat;
	background-position: 6px 4px;
	/*background-position: 10px -17px;*/
}
.menubotonsel a {
	color: #FFFFFF;
	padding: 5px 5px 5px 30px;
	display: block;
	text-shadow: -1px -1px 0px #333333;
}
.menubottom {
	height: 32px;
	background-color: <?php echo $colorprimario; ?>;
	<?php borderr('0px 0px 10px 0px'); ?>
}
.oculto {
	display: none;
}
.sele {
	cursor: copy;
	float: left;
	margin-top: 3px;
}
#ocmenu{
	<?php borderr('0px 20px 20px 20px'); ?>
	<?php boxs('0px 0px 10px #000000'); ?>
	background-color: <?php echo $colorprimario ?>;
	border: 1px solid #EEEEEE;
	color: #EEEEEE;
	font-size: 14px;
	font-weight: bold;
	left: 0px;
	padding: 0 6px 2px;
	position: fixed;
	text-shadow: none;
	top: 80px;
	z-index: 20;
	cursor: pointer;
}
.faccli {
	padding: 10px;
	margin: auto;
	margin-top: 20px;
	width: 90%;
	background-color: #333333;
	<?php borderr('10px'); ?>
	<?php boxs('0px 0px 10px #000000'); ?>
	border: 1px solid #CCCCCC;
	overflow: hidden;
	color: #FFFFFF;
	text-shadow: none;
}
.cajaround {
	<?php borderr('10px'); ?>
	<?php boxs('0px 0px 10px #000000'); ?>
	padding: 20px 5px;
	float: left;
	width: 30%;
	margin-left: 1.7%;
	font-size: 12px;
	text-align: center;
	text-shadow: 0px 0px 2px #000000;
	color: #FFFFFF;
}
.cajaerror{
	border:1px solid #FF0000;
	background:#F7CBCA;
	width: 50%;
	margin: auto;
	text-align: center;
	padding:10px;
	font-weight:bold;
	color: #FF0000;
	<?php borderr('5px'); ?>
}
.mceEditor *{
	<?php borderr('0px !important'); ?>
	<?php boxs('none !important'); ?>
}
/*FACTURACION*/
.newconce, .newconcepre{
	float: right;
	padding: 0px 5px 2px 5px;
	font-size: 14px;
	cursor: pointer;
	border: 1px solid #FFFFFF;
	<?php borderr('20px'); ?>
	background-color: #555555;
}
.delconce,
.delconcepre,
.editconce,
.editconcepre{
	padding: 0px 5px 2px 5px;
	margin: 5px;
	font-size: 14px;
	cursor: pointer;
	border: 1px solid #FFFFFF;
	<?php borderr('20px'); ?>
	background-color: #DC0066;
	color: #FFFFFF;
}
.delconce a,
.delconcepre a,
.editconce a,
.editconcepre a{
	color: #FFFFFF;
}
#editorlineas{
	display: none;
	background: #FFF none repeat scroll 0 0;
	border: 4px solid #DC0066;
	height: 300px;
	width: 50%;
	left: calc(50% - 25%);
	top: calc(50% - 150px);
	margin: auto;
	position: fixed;
	<?php boxs("0 0 60px rgba(0, 0, 0, 1), 10px 10px 10px rgba(0, 0, 0, 0.5)"); ?>
}
#editorlineas .cerrar{
	width: 100%;
	padding: 10px;
	box-sizing: border-box;
	background: #DC0066;
	color: #FFF;
	font-size: 2em;
	text-align: right;
	display: inline-block;
	text-shadow: none;
	cursor: pointer;
}
#editorlineas .formulario{
	width: 95%;
	margin: 15px auto;
}
#editorlineas .formulario label{
	color: #FFF;
	text-transform: uppercase;
	text-shadow: none;
	font-weight: bold;
	display: block;
	margin-bottom: 10px;
}
#editorlineas .formulario input[type="text"]{
	width: 100%;
	display: block;
	margin-bottom: 10px;
}
#editorlineas .formulario label textarea{
	width: 100%;
}
.savconce{
	float: right;
	padding: 0px 5px 2px 5px;
	font-size: 14px;
	cursor: pointer;
	border: 1px solid #FFFFFF;
	<?php borderr('20px'); ?>
	background-color: green;
	color: #FFFFFF;
}
.concc{
	width: 90%;
	text-align: center;
	margin: 2px auto;
	padding: 4px;
	background-color: #CCCCCC;
	border: 1px solid <?php echo $colorprimario; ?>;
	<?php borderr('5px'); ?>
}
.conceptos{
}
.conceptos ul{
	list-style: none;
	margin: 0px auto;
	padding: 0px;
}
.conceptos ul ul, .conceptos ul ol{
	list-style: disc;
	margin: 0px auto;
	padding: 0px 0px 0px 25px;
}
.conceptos ul ol{
	list-style: number;
}
.conceptos .placeholder{
	background-color: #dc0066;
	border-radius: 5px;
	margin: 5px auto;
	height: 35px;
}
#newcon td{
	color: #FFFFFF;
}
#newcon input[type="text"], .conceptos input[type="text"]{
	width: 100%;
}
.conann{
	border: 1px solid #DC0066;
	margin: 5px auto;
	background-color: #EEEEEE;
	<?php borderr('5px'); ?>
}
.conann .zz{
	border: 1px solid #000000 !important;
	background-color: #D46C9D !important;
	color: #FFFFFF;
	font-weight: bold;
}
.conann .zy{
	border: 1px solid #000000 !important;
	background-color: #DC0066 !important;
	color: #FFFFFF;
	font-weight: bold;
}
.conann td:last-child ul{
	margin: auto;
	padding: 0px;
	list-style: none;
	text-align: right;
}
.conann td:last-child ul li{
	margin: 5px;
	display: inline-block;
	padding: 3px 6px;
}
/*IMPORTANDO*/
@import url("paginador.css") all;
/*=================================================================================================================================*/
/*MEDIA QUERIES====================================================================================================================*/
/*=================================================================================================================================*/
@media screen and (max-width: 1024px) {
	.todo{
		box-sizing: border-box;
	}
	.todo .top{
		position: relative;
	}
	#ocmenu{
		width: 100%;
		<?php
		boxs('0px 0px 0px #000000');
		borderr('0px');
		?>
		border: none;
		/*position: relative;
		top: 77px;*/
		padding: 10px;
		text-align: center;
		display: none;
	}
	#ocmenu:after{content: " OCULTAR / MOSTRAR MENÚ";}
	.todo .centro{
		margin-top: 0px;
		padding: 0px;
	}
    .todo .centro .menu{
		float: none;
		width: 100%;
		font-size: 4em;
	}
	.todo .centro .menu > div > a > img{
		width: 75%;
	}
	.todo .centro .menu .menubotontit,
	.todo .centro .menu .menuboton,
	.todo .centro .menu .menubotonsel{
		background-image: none !important;
		text-align: center;
	}
	.todo .centro .menu .menuboton > div,
	.todo .centro .menu .menubotonsel > div{
		width: auto !important;
		float: none !important;
	}
	.todo .centro .menu .menuboton a{
		display: block;
	}
	.todo .centro .menu .menubottom{
		<?php borderr('0px'); ?>
	}
	.todo .centro .contenido{
		margin: auto;
		max-width: 100%;
		overflow: hidden;
	}
	.todo .centro .contenido .buscador{
		font-size: 4em;
	}
	.todo .centro .contenido .buscador select{height: 2em;}
	.todo .centro .contenido .buscador select,
	.todo .centro .contenido .buscador input{
		width: 100% !important;
		display: block;
		box-sizing: border-box;
		margin: 10px auto;
		font-size: 1em;
		line-height: normal;
	}
	input[type="submit"]{
		background-size: contain;
	}
	a.boton_a{
		width: 75%;
		display: block;
		margin: 1em auto;
		background-size: contain;
		font-size: 4em;
	}
}
