<?php
//ob_start();
$cliente = "";
$factura = "";
$concepto = "";
$total = "";

include("../config/config.php");
include("../includes/conectar.php");
include("../includes/funciones.php");

$iva = ivafecha(date("Y-m-d"));

//ACCESO A LOS DATOS DE LA FACTURA
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

//CREACION DEL PDF
require("../includes/fpdf/fpdf.php");
require("../includes/fpdf/fpdf_bikuma.php");
require('../includes/fpdf/htmlparser.inc');

//NUMERO DE LA FACTURA
$numi = "";
$largura = strlen($row['numero']);
for($xz=$largura; $xz<5; $xz++) $numi .="0";
$numfactura = "SN-".$numi.$row['numero']."/".substr($row['fecha'],0,4);

//DATOS DEL CLIENTE
$cliente .= "<hr><b>CLIENTE</b><br>";
$cliente .= "<b>NOMBRE:</b> ".$row['clnombre']."<br>";
$cliente .= "<b>DIRECCIÓN:</b> ".$row['direccion']." - ".$row['cp'].", ".$row['cinombre']." (".$row['prnombre'].")<br>";
$cliente .= "<b>NIF / CIF: </b>".$row['cif']."<br>";
$cliente .= "<b>FECHA: </b>".fechaes($row['fecha'])."<br><hr>";

//DATOS DE LA FACTURA
$factura .= "<b>FACTURA Nº: </b>";//.$numfactura."<br><hr>";

//DATOS DE LOS CONCEPTOS
$concepto .= '
<table>
	<tr>
		<td width="30" height="30">Nº</td>
		<td width="450" height="30">CONCEPTO</td>
		<td width="80" height="30">PRECIO UD</td>
		<td width="80" height="30">UDS</td>
		<td width="80" height="30">TOTAL</td>
	</tr>
';
$sqlc= "SELECT precio, cantidad, concepto
FROM kng_conceptos AS c
WHERE factura = '".$row['id']."'
AND activo = '1'
AND borrado = '0'
ORDER BY id ASC";
$resc = mysql_query($sqlc);
$subtotal = 0;
$xz = 1;
$xzz = 1;
while($rowc = mysql_fetch_array($resc))
{
	/*
	$conce = str_replace($vowels, $vowelspor, $rowc['concepto']);
	$conce = strip_tags(str_replace("&euro;", " !", $conce));
	*/
	$sub = $rowc['precio']*$rowc['cantidad'];
	$subtotal += $sub;
	$sub = number_format($sub, 2, ',', '.');
	//TRUCO PARA LOS TITULOS
	if($rowc['precio']=="0.00" AND $rowc['cantidad']=="0")
	{
		$precio = "";
		$cantidad = "";
		$sub = "";
		$numm = "";
	}
	else{
		$precio = number_format($rowc['precio'], 2, ',', '.').' $';
		$cantidad = $rowc['cantidad'];
		$sub .= ' $';
		$numm = $xzz;
		$xzz++;
	}
	$concepto .= '
		<tr>
			<td width="30" height="30">'.$xz.'</td>
			<td width="450" height="30">'.$rowc['concepto'].'</td>
			<td width="80" height="30">'.number_format($rowc['precio'], 2, ',', '.').' $</td>
			<td width="80" height="30">'.$rowc['cantidad'].'</td>
			<td width="80" height="30">'.$sub.'</td>
		</tr>
	';
	$xz++;
}
$concepto .= '</table>';
$ivaa = ($subtotal*$iva)/100;
$total .= '
<table>
	<tr>
		<td width="30" height="30">BASE IMPONIBLE</td>
		<td width="450" height="30">IVA</td>
		<td width="80" height="30">TOTAL</td>		
	</tr>
	<tr>
		<td width="30" height="30">'.number_format($subtotal, 2, ',', '.').' $</td>
		<td width="450" height="30">'.number_format($ivaa, 2, ',', '.').' $</td>
		<td width="80" height="30">'.number_format($subtotal+$ivaa, 2, ',', '.').' $</td>		
	</tr>
</table>
';

/*
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
*/




/*
$concepto .= 'Ahora puede imprimir fácilmente texto mezclando diferentes estilos: <b>negrita</b>, <i>itálica</i>,
<u>subrayado</u>, o y <b><i><u>todos a la vez</u></i></b>!<br><br>También puede incluir enlaces en el
texto, como <a href="http://www.sonort.com">www.sonort.com</a>, o en una imagen: pulse en el logotipo.<br>
<table border="1">
	<tr>
		<td width="20" height="30">1</td>
		<td width="200" height="30">cell 1</td>
		<td width="200" height="30" bgcolor="#D0D0FF">cell 2</td>
	</tr>
	<tr>
		<td width="20" height="30">2</td>
		<td width="200" height="30">cell 3</td>
		<td width="200" height="30">cell 4</td>
	</tr>
</table>';
*/

$pdf = new PDF_HTML();
$pdf->SetTitle("Factura ".$numfactura." SONORT", true);
$pdf->SetAuthor("SONORT", true);
$pdf->SetSubject("Factura ".$numfactura." SONORT", true);
$pdf->SetMargins(15,35,15,35);
$pdf->SetFont('Helvetica','',10);
// Primera página
$pdf->AddPage();
$pdf->SetLink($link);
$pdf->Image('../imagenes/logo.jpg',15,10,80,0,"",'http://www.sonort.com');
$pdf->SetFontSize(6);
$pdf->RotatedText(10,220,"SONORT | Calle Zubileta 27 Poligono Industrial Ibarreta Pabellon 16 Bajo - 48903 Barakaldo (Bizkaia) CIF: B95292579",90);
$pdf->SetFontSize(8);
$pdf->WriteHTML($cliente);
$pdf->SetXY(110, 40);
$pdf->WriteHTML($factura);
$pdf->Code39(111,46,$numfactura,1,6);
$pdf->SetXY(15, 70);
$pdf->WriteHTML($concepto);
$pdf->WriteHTML($total);
//INFORMACION PAGO
$pdf->WriteHTML("<b>FORMAS DE PAGO:</b> ".$row['cubanco']." :: ".$row['cunumero']);
//RECTANGULO INFERIOR
$pdf->SetLineWidth(0.1);
//$pdf->SetDrawColor(255,0,0);
$pdf->SetFillColor(198,0,92);
$pdf->Rect(0,265,210,40, "F");
$pdf->setTextColor(255,255,255);
$pdf->SetXY(15, 270);
$pdf->SetFontSize(6);
$pdf->WriteHTML("<b>SONORT</b> | Calle Zubileta 27 Poligono Industrial Ibarreta Pabellon 16 Bajo - 48903 Barakaldo (Bizkaia) | <b>Tlf:</b> 627.918.398  | <b>Email:</b> sonort@sonort.com");
$pdf->Output();

/*FIN NUEVO*/

/*


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

*/
?>