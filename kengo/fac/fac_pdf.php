<?php
ob_start();
include("../config/config.php");
include("../includes/conectar.php");
include("../includes/funciones.php");
$iva = ivafecha(date("Y-m-d"));
//ACCESO A LOS DATOS DE LA FACTURA
//
$sql = "SELECT fa.id, fecha, numero, cif, cl.nombre AS clnombre, direccion, cp, ci.nombre AS cinombre, pr.nombre AS prnombre, cu.cuenta AS cunumero, cu.banco AS cubanco
FROM kng_facturas AS fa
LEFT JOIN kng_clientes AS cl ON cl.id = fa.cliente
LEFT JOIN kng_ciudades AS ci ON ci.id = cl.ciudad
LEFT JOIN kng_provincias AS pr ON pr.id = cl.provincia
LEFT JOIN kng_cuentas AS cu ON cu.id = fa.cuenta
WHERE fa.id = '".$_GET['id']."'";
$res = mysql_query($sql);
mysql_query ("SET NAMES 'utf8'");
$row = mysql_fetch_array($res);

$vowelspor = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "º", "ç", "Ç", "ü", "Ü", " ");
$vowels = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ntilde;", "&Ntilde;", "&deg;", "&ccedil;", "&Ccedil;", "&uuml;", "&Uuml;", "&nbsp;");
//CREACION DEL PDF
//
include ("../includes/pdf/class.ezpdf.php");
$pdf =& new Cezpdf('a4');
$pdf->ezSetMargins(50,50,50,50);
$euro_diff = array(33=>'Euro'); //DECLARAR EL SIMBOLO EURO
$pdf->selectFont('../includes/pdf/fonts/Helvetica.afm', array('encoding'=>'WinAnsiEncoding','differences'=>$euro_diff));
//LOGO
$pdf->addJpegFromFile('../imagenes/logo.jpg',25,770,200);
$pdf->setLineStyle(1);
$pdf->line(20,750,575.28,750);
//TEXTO LATERAL
$pdf->addText(20,200,8,utf8_decode("<b>SONORT</b> | Calle Zubileta 27 Poligono Industrial Ibarreta Pabellon 16 Bajo - 48903 Barakaldo (Bizkaia) <b>CIF:</b> B95292579"),-90);
//INFO FACTURA
$pdf->ezSetY(740);
$pdf->ezText(utf8_decode("<b>CLIENTE: </b>".$row['clnombre']),10);
$pdf->ezText(utf8_decode(str_replace($vowels, $vowelspor, $row['direccion'].' - '.$row['cp'].', '.$row['cinombre'].' ('.$row['prnombre'].')')),10);
$pdf->ezSetY(710);
$pdf->ezText(utf8_decode("<b>NIF / CIF: </b>".$row['cif']),10);
$pdf->ezText(utf8_decode("<b>FECHA: </b>".fechaes($row['fecha'])),10);
$numi = "";
$largura = strlen($row['numero']);
for($xz=$largura; $xz<5; $xz++) $numi .="0";
$pdf->ezText(utf8_decode("<b>FACTURA Nº: </b>SN-".$numi.$row['numero']."/".substr($row['fecha'],0,4)),10);
$pdf->line(20,650,575.28,650);
//CONCEPTOS DE LA FACTURA
$pdf->ezSetY(630);
$sqlc= "SELECT precio, cantidad, concepto
FROM kng_conceptos AS c
WHERE factura = '".$row['id']."'
AND activo = '1'
AND borrado = '0'
ORDER BY id ASC";
$resc = mysql_query($sqlc);
$subtotal = 0;
$data = array();
$xz = 0;
$xzz = 1;
while($rowc = mysql_fetch_array($resc))
{
	$concepto = utf8_decode(str_replace($vowels, $vowelspor, $rowc['concepto']));
	$conceptoo = strip_tags(str_replace("&euro;", " !", $concepto));
	$sub = $rowc['precio']*$rowc['cantidad'];
	$subtotal += $sub;
	$sub = number_format($sub, 2, ',', '.');
	/*TRUCO PARA LOS TITULOS*/
	if($rowc['precio']=="0.00" AND $rowc['cantidad']=="0")
	{
		$precio = "";
		$cantidad = "";
		$sub = "";
		$numm = "";
	}
	else{
		$precio = number_format($rowc['precio'], 2, ',', '.').' !';
		$cantidad = $rowc['cantidad'];
		$sub .= ' !';
		$numm = $xzz;
		$xzz++;
	}
	//echo $precioo = $xz."[".number_format($rowc['precio'], 2, ',', '.')."! x ".$rowc['cantidad']."]  -->  ".$sub ."<br />";
	$data[$xz] = array(utf8_decode("Nº")=>$numm,'CONCEPTO'=>$conceptoo,'PRECIO UD'=>$precio, 'UDS'=>$cantidad, 'TOTAL'=>$sub);
	$xz++;
}

$data[$xz] = array(utf8_decode("Nº")=>'','CONCEPTO'=>'','PRECIO UD'=>'', 'UDS'=>'', 'TOTAL'=>'');$xz++;
$pdf->ezTable($data,'','',array('showHeadings'=>1,'shaded'=>0,'width'=>520, 'left'=>500, 'cols'=>array(utf8_decode("Nº")=>array('justification'=>'center', 'width'=>'25'),'TOTAL'=>array('width'=>100, 'justification'=>'right'))));

$pdf->ezSetDy(-20);
$xz = 0;
$data2 = array();
$data2[$xz] = array('a'=>'BASE IMPONIBLE', 'b'=>number_format($subtotal, 2, ',', '.').' !');
$xz++;
$ivaa = ($subtotal*$iva)/100;
$data2[$xz] = array('a'=>'IVA ('.$iva.'%)', 'b'=>number_format($ivaa, 2, ',', '.').' !');
$xz++;
$data2[$xz] = array('a'=>'TOTAL', 'b'=>number_format($subtotal+$ivaa, 2, ',', '.').' !');
$xz++;

$pdf->ezTable($data2,'','',array('showHeadings'=>0,'shaded'=>0,'width'=>520, 'left'=>500, 'cols'=>array('a'=>array('justification'=>'right'),'b'=>array('width'=>100, 'justification'=>'right'))));

$pdf->ezSetDy(-30);
//INFORMACION PAGO
$pdf->ezText(utf8_decode("<b>FORMAS DE PAGO:</b> ".$row['cubanco']." :: ".$row['cunumero'].""),10);
//$pdf->ezSetDy(-10);
//$pdf->ezText(utf8_decode($row['cubanco']." :: ".$row['cunumero']),10);
//RECTANGULO INFERIOR
$pdf->setColor(0.9,0.0,0.4);
$pdf->filledRectangle(0,0,595.28,50);
$pdf->setColor(1,1,1);
$pdf->addText(40,20,8,utf8_decode("<b>SONORT</b> | Calle Zubileta 27 Poligono Industrial Ibarreta Pabellon 16 Bajo - 48903 Barakaldo (Bizkaia) | <b>Tlf:</b> 627.918.398  | <b>Email:</b> sonort@sonort.com"),0);


//PARA SACARLO POR PANTALLLA
//
$optionss = array('Content-Disposition'=>'SN_'.$numi.$row['numero'].'.pdf');
$pdf->ezStream($optionss);
//PARA ALMACENARLO EN DISCO
//
$pdfcode = $pdf->ezOutput();
$fp=fopen('../facturas/SN_'.$numi.$row['numero'].'.pdf','wb');
fwrite($fp,$pdfcode);
fclose($fp);
?>