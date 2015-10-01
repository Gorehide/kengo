<?php
ob_start();
include("../config/config.php");
include("../includes/conectar.php");
include("../includes/funciones.php");
//ACCESO A LOS DATOS DE LA FACTURA
//
$sql = "SELECT *
FROM kng_hojasruta
WHERE id = '".$_GET['id']."'";
$res = mysql_query($sql);
mysql_query ("SET NAMES 'utf8'");
$row = mysql_fetch_array($res);

$vowelspor = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "º", "ç", "Ç", "ü", "Ü", " ");
$vowels = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ntilde;", "&Ntilde;", "&deg;", "&ccedil;", "&Ccedil;", "&uuml;", "&Uuml;", "&nbsp;");
//CREACION DEL PDF
//
//include ("../includes/pdf/class.ezpdf.php");
include ("../includes/pdf/Cezpdf.php");
$pdf =& new Cezpdf('a4');
$pdf->ezSetMargins(50,50,50,50);
$euro_diff = array(33=>'Euro'); //DECLARAR EL SIMBOLO EURO
$pdf->selectFont('../includes/pdf/fonts/Helvetica.afm', array('encoding'=>'WinAnsiEncoding','differences'=>$euro_diff));
//LOGO
$pdf->addJpegFromFile('../imagenes/logo.jpg',25,770,200);
$pdf->setLineStyle(1);
$pdf->line(50,750,575.28,750);
//TEXTO LATERAL
$pdf->addText(30,200,8,utf8_decode("<b>SONORT</b> | Calle Zubileta 27 Poligono Industrial Ibarreta Pabellon 16 Bajo - 48903 Barakaldo (Bizkaia) <b>CIF:</b> B95292579"),-90);
//INFO
$pdf->ezSetY(740);
$pdf->ezText("<b>Artista / Evento: </b>".$row['artista'],10);
$pdf->ezSetY(720);
$pdf->ezText("<b>Fecha: </b>".fechaes($row['fecha']),10);
$pdf->ezSetY(700);
$pdf->ezText("<b>Ciudad: </b>".$row['ciudad'],10);
$pdf->line(50,680,575.28,680);
$pdf->ezSetY(660);
$pdf->ezText("<b>Producción: </b>".$row['produccion'],10);
$pdf->ezSetY(640);
$pdf->ezText("<b>Responsable: </b>".$row['responsable']." - ".$row['tlf_resp']." (".$row['email_responsable'].")",10);
$pdf->ezSetY(620);
$pdf->ezText("<b>Responsable de producción: </b>".$row['resp_produccion']." - ".$row['tlf_resp_prod'],10);
$pdf->ezSetY(600);
$pdf->ezText("<b>Responsable de sonido: </b>".$row['resp_sonido']." - ".$row['tlf_resp_soni'],10);
$pdf->line(50,580,575.28,580);
$pdf->ezSetY(560);
$pdf->ezText("<b>Lugar: </b>".$row['lugar'],10);
$pdf->ezSetY(540);
$pdf->ezText("<b>Dirección: </b>".$row['direccion'],10);
$pdf->line(50,520,575.28,520);
$pdf->ezSetY(500);

$data = array();
$soundcheck = str_replace($vowels, $vowelspor, $row['soundcheck']);
$soundcheckk = strip_tags(str_replace("&euro;", " !", $soundcheck),'<strong>');
$actuaciones = str_replace($vowels, $vowelspor, $row['actuaciones']);
$actuacioness = strip_tags(str_replace("&euro;", " !", $actuaciones),'<strong>');
$data[1] = array(utf8_decode("<b>SOUNDCHECK</b>")=>str_replace('strong>', 'b>',$soundcheckk), utf8_decode("<b>ACTUACIONES</b>")=>str_replace('strong>', 'b>',$actuacioness));

$pdf->ezTable($data,'','',array('xPos'=>'center','showLines'=>'4', 'showHeadings'=>1,'shaded'=>0,'width'=>500,'maxWidth'=>'500', 'cols'=>array('Soundcheck'=>array('width'=>'250', 'justification'=>'left'),'ACTUACIONES'=>array('justification'=>'right'))));
$pdf->ezSetDy(-20);
$observaciones = str_replace($vowels, $vowelspor, $row['observaciones']);
$observacioness = strip_tags(str_replace("&euro;", " !", $observaciones),'<strong>');
$pdf->ezText("<b>Observaciones:</b>",10);
$pdf->ezSetDy(-20);
$pdf->ezText(str_replace('strong>', 'b>',$observacioness),10);

//RECTANGULO INFERIOR
$pdf->setColor(0.9,0.0,0.4);
$pdf->filledRectangle(0,0,595.28,50);
$pdf->setColor(1,1,1);
$pdf->addText(40,20,8,utf8_decode("<b>SONORT</b> | Calle Zubileta 27 Poligono Industrial Ibarreta Pabellon 16 Bajo - 48903 Barakaldo (Bizkaia) | <b>Tlf:</b> 627.918.398  | <b>Email:</b> sonort@sonort.com"),0);


//PARA SACARLO POR PANTALLLA
//
$optionss = array('Content-Disposition'=>'SN_ruta_'.$row['id'].'.pdf');
$pdf->ezStream($optionss);
//PARA ALMACENARLO EN DISCO
//
$pdfcode = $pdf->ezOutput();
$fp=fopen('../rutas/SN_ruta_'.$row['id'].'.pdf','wb');
fwrite($fp,$pdfcode);
fclose($fp);
?>