<?php
ob_start();
include("../config/config.php");
include("../includes/conectar.php");
include("../includes/funciones.php");
$iva = ivafecha(date("Y-m-d"));
//ACCESO A LOS DATOS DE LA FACTURA
$sql = "SELECT fa.id, fecha, numero, cif, cl.nombre AS clnombre, direccion, cp, ci.nombre AS cinombre, pr.nombre AS prnombre, cu.cuenta AS cunumero, cu.banco AS cubanco
FROM kng_proformas AS fa
LEFT JOIN kng_clientes AS cl ON cl.id = fa.cliente
LEFT JOIN kng_ciudades AS ci ON ci.id = cl.ciudad
LEFT JOIN kng_provincias AS pr ON pr.id = cl.provincia
LEFT JOIN kng_cuentas AS cu ON cu.id = fa.cuenta
WHERE fa.id = '".$_GET['id']."'";
$res = mysql_query($sql);
mysql_query ("SET NAMES 'utf8'");
$row = mysql_fetch_array($res);
//NUMERO FACTURA
$numi = "";
$largura = strlen($row['numero']);
for($xz=$largura; $xz<5; $xz++) $numi .="0";
$numpresupuesto = "SN-".$numi.$row['numero']."/".substr($row['fecha'],0,4);
include("../includes/mpdf60/mpdf.php");

$mpdf=new mPDF('win-1252','A4','','',0,0,30,25,0,0);
$mpdf->useOnlyCoreFonts = true;    // false is default
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("EMRPESA - Factura proforma");
$mpdf->SetAuthor("EMPRESA");
$mpdf->SetWatermarkText("PROFORMA");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.05;
$mpdf->SetDisplayMode('fullpage');

/*CABECERA Y ESTILOS*/
$html = "
<html>
	<head>
		<style>
			body{
				/*font-family: sans-serif;*/
				font-family: DejaVuSansCondensed;
    			font-size: 10pt;
			}
			.cabecera,
			.cliente,
			.contenido,
			.row{
				padding: 0px 20px 0px 20px;
			}
			.cabecera{padding-top: 15px;}
			.cliente{padding:5px 50px;}
			.contenido{padding: 0px 35px;}
			.pie{
				background: #E5008F;
				color: #FFFFFF;
				font-size: 10px;
				text-align: center;
				padding: 10px; 
			}
			hr{
				color: #E5008F;
				background-color: #E5008F;
				height: 1px;
			}
			p{
				margin: 0px;
			}
			span.icono{font-size: 14px;}
			td{
				vertical-align: top;
			}
			.items td
			{
    			border-left: 0.1mm solid #000000;
    			border-right: 0.1mm solid #000000;
			}
			.items td.zebra{
				background: #EEE;
			}
			.items td.titulor{
				background: #E5008F;
				color: #FFF;
			}
			.items td.blanktotal
			{
    			background-color: #FFFFFF;
    			border: 0mm none #000000;
    			border-top: 0.1mm solid #000000;
    			border-right: 0.1mm solid #000000;
			}
			table thead td
			{
				background-color: #EEE;
    			text-align: center;
    			border: 0.1mm solid #000000;
			}			
			td.totals
			{
    			text-align: right;
    			background: #EEE;
    			border: 0.1mm solid #000000;
			}
			.lateral {
				position: absolute; 
				overflow: auto; 
				left: 0;
				bottom: 20mm; 
				width: 250mm; 
				padding: 10px 0px 0px 0px; 
				font-family:sans; 
				margin: 0px;
				rotate: -90;
				text-align: center;
				font-size: 8px;
			}
			.email{color:#FFF; text-decoration: none;}
			.paginador{text-align: right; font-size: 8px;}
			.formaspago{margin-top: 25px; padding: 10px;}
		</style>
	</head>";
//DEFINICION CABECERA Y PIE
$html .= '
	<body>
		<!--mpdf
			<htmlpageheader name="myheader">
				<div class="cabecera">
					<table width="100%">
						<tr>
							<td width="40%"><img src="'.BASEURL.'/imagenes/logo.jpg" style="width:275px" /></td>
							<td width="60%" style="text-align: right; vertical-align: middle;">
								<barcode color="#E5008F" code="'.$numi.$row['numero']."/".substr($row['fecha'],0,4).'" type="IMB" /><br>
								<div style="font-size: 8px;">SN-'.$numi.$row['numero']."/".substr($row['fecha'],0,4).'</div> 
							</td>
						</tr>
					</table>	
					<hr>
				</div>								
			</htmlpageheader>
			<htmlpagefooter name="myfooter">
				<div class="pie">
					<div><b>EMPRESA</b> | Calle de la empresaF - 40000 Bilabo (Bizkaia) | <span class="icono">&#9990;</span> 600.000.000 | <span class="icono">&#9993;</span> <a class="email" href="mailto:facturacion@empresa.com">facturacion@empresa.com</a></div>
					<div class="paginador"><br>Página {PAGENO} de {nb}</div>
				</div>
			</htmlpagefooter>
			<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
			<sethtmlpagefooter name="myfooter" value="on" />
		mpdf-->';
//INFO CLIENTE
$html .= '
		<div class="cliente">
			<b>CLIENTE: </b>'.$row["clnombre"].'<br>
			'.$row["direccion"].' - '.$row["cp"].', '.$row["cinombre"].' ('.$row["prnombre"].')<br>
			<b>NIF / CIF: </b>'.$row["cif"].'<br>
			<b>FECHA: </b>'.fechaes($row['fecha']).'<br>
			<b>FACTURA PROFORMA N<sup>o</sup></b>: '.$numpresupuesto.'
		</div>
		<div class="row"><hr></div>';

//INFO CONTENIDO
$html .='	
		<div class="contenido">			
			<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
				<thead>
					<tr>
					<td width="5%">N<sup>o</sup></td>
					<td width="55%">CONCEPTO</td>
					<td width="14%">PRECIO UNIDAD</td>
					<td width="16%">UNIDADES</td>
					<td width="15%">TOTAL</td>
					</tr>
				</thead>
				<tbody>';

//CONTENIDO DE LA BBDD
$sqlc= "SELECT precio, cantidad, concepto
FROM kng_conceptos AS c
WHERE proforma = '".$row['id']."'
AND activo = '1'
AND borrado = '0'
ORDER BY num ASC";
$resc = mysql_query($sqlc);
$subtotal = 0;
$data = array();
$xz = 0;
$xzz = 0;
$titulor = 0;
while($rowc = mysql_fetch_array($resc))
{
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
        $concepto = '<b>'.$rowc['concepto'].'</b>';
        $titulor = 1;
	}
	else{
		$precio = number_format($rowc['precio'], 2, ',', '.').' &euro;';
		$cantidad = $rowc['cantidad'];
		$sub .= ' &euro;';
		$numm = $xzz;
		$xzz++;
		$concepto = $rowc['concepto'];
	}
	$zebra="";
	if(($xzz % 2)==0) $zebra="zebra";
	
	if($titulor){
		$html .= '<tr><td class="titulor" align="center" colspan="5">'.$concepto.'</td></tr>';
	} 
	else $html .= '
					<tr>
						<td class="'.$zebra.'" align="center">'.$xzz.'</td>
						<td class="'.$zebra.'">'.$concepto.'</td>
						<td class="'.$zebra.'" align="right">'.$precio.'</td>
						<td class="'.$zebra.'" align="right">'.$cantidad.'</td>
						<td class="'.$zebra.'" align="right">'.$sub.'</td>
					</tr>';
	$titulor = 0;
}
$ivaa = ($subtotal*$iva)/100;
//PIE INFO CONTENIDOS
$html .= '
					<tr>
						<td class="blanktotal" colspan="3" rowspan="6"></td>
						<td class="totals"><b>BASE IMPONIBLE</b></td>
						<td class="totals">'.number_format($subtotal, 2, ',', '.').'&euro;</td>
					</tr>
					<tr>
						<td class="totals"><b>IVA</b> ('.$iva.'%)</td>
						<td class="totals">'.number_format($ivaa, 2, ',', '.').'&euro;</td>
					</tr>
					<tr>
					<td class="totals"><b>TOTAL</b></td>
					<td class="totals">'.number_format($subtotal+$ivaa, 2, ',', '.').'&euro;</td>
					</tr>			
				</tbody>
			</table>
			';
//INFORMACION DE PAGO
$html .= '
			<div class="formaspago"><b>FORMAS DE PAGO: </b>'.$row['cubanco'].' :: '.$row['cunumero'].'</div>';
//CIERRE DEL CONTENIDO
$html .= '
		</div>';
//LATERAL
$html .= '<div class="lateral"><b>Nombre de la empresa</b> | Calle de la empresa - 40000 Bilbao (Bizkaia) | <b>CIF:</b> B0000000</div>';

//CIERRE DEL HTML
$html .="
	</body>
</html>";

$mpdf->WriteHTML($html);

$mpdf->Output(); exit;

exit;

?>
