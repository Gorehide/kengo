<?php
$tablaa = "kng_proformas";
//DATOS VARIOS
$esteanio = date("Y");
//GENERAL
$esteanio = date("Y");
$sql = "SELECT fa.id AS faid, numero, fecha, cl.nombre, cl.id AS clid, presupuesto, titulo, presupuesto
FROM ".$tablaa." AS fa
LEFT JOIN kng_clientes As cl ON cl.id = fa.cliente
WHERE fa.id>0";
if(isset($_POST['accion']) AND $_POST['accion']=="Buscar")
{
	if (isset($_POST['anio']))
	{
	if($_POST['anio']=="0") $esteanio = date("Y");
		else if($_POST['anio']=="all") $esteanio= "%";
		else $esteanio = $_POST['anio'];
		$sql .= " AND fecha LIKE '".$esteanio."-%'";
	}
}
else $sql .= " AND fecha LIKE '".$esteanio."-%'";
if (isset($_POST['trimestre']) AND $_POST['trimestre']>0)
{
	$sql .= " AND (";
	$mesu = (3*($_POST['trimestre']-1))+1;
	for($xc = $mesu; $xc <$mesu+3; $xc++)
	{
	//echo $xc.'<br />';
	$mess = "0".$xc;
		$mess = substr($mess, -2);
		if($xc>$mesu) $sql .=" OR ";
	$sql .= " fecha LIKE '".$esteanio."-".$mess."-%' ";
	}
	$sql .= ")";
}
	if (isset($_POST['cliente']) AND $_POST['cliente']>0) $sql .= " AND cl.id = '".$_POST['cliente']."'";
$sql .= " ORDER by numero DESC";
$sqlExport = base64_encode($sql);
//echo $sql.'<br />';
$result = mysql_query($sql);
$cuantos=mysql_num_rows($result);
?>
<!-- CABECERA -->
<div class="infotabla pager">
	Proformas: <?php echo $cuantos; ?>
</div>
<!-- BUSCADOR -->
<div class="pager buscador">
	<form action="" method="post">
		Año:
		<select name="anio" style="width: auto; padding: 2px 12px;">
			<option value="0">Seleccione año</option>
   	    	<option value="all">Cualquiera</option>
			<?php
			for ($xi=date("Y"); $xi>=2011; $xi--)
			{
				?>
				<option value="<?php echo $xi; ?>"><?php echo $xi; ?></option>";
				<?php
			}
			?>
		</select>
		<select name="trimestre" style="width: auto; padding: 2px 12px;">
			<option value="0">Seleccione trimestre</option>
			<?php
			for ($xi=1; $xi<=4; $xi++)
			{
				?>
				<option value="<?php echo $xi; ?>"><?php echo $xi; ?></option>";
				<?php
			}
			?>
		</select>
		<select name="cliente" style="width: 300px; padding: 2px 12px; text-align: left;">
    		<option value="0">Seleccionar cliente</option>
			<?php
			$sqlcli = "SELECT id, nombre FROM kng_clientes WHERE borrado = '0' ORDER BY nombre";
			$rescli = mysql_query($sqlcli);
			while ($rowcli = mysql_fetch_array($rescli))
			{
				?>
				<option value="<?php echo $rowcli['id']; ?>"><?php echo $rowcli['nombre']; ?></option>
				<?php
			}
			?>
		</select>
		<input type="submit" value="Buscar" name="accion" />
    </form>
</div>
<table class="tablesorter">
	<thead>
    	<tr>
        	<th width="3%">Nº</th>
        	<th width="100px">PRESUPUESTO</th>
        	<th width="5%">FECHA</th>
            <th>CLIENTE</th>
            <th width="50%">TÍTULO</th>
            <th class="{sorter: 'currency'}">IMPORTE</th>
            <th width="1%" class="tcentrado {sorter: false}">IVA</th>
            <th class="{sorter: 'currency'}">+IVA</th>
            <th width="1%" class="tcentrado {sorter: false}" >FACTURA</th>
            <th width="1%" class="tcentrado {sorter: false}" >PDF</th>
    	</tr>
	</thead>
    <tbody>
    	<?php
        while ($row = mysql_fetch_array($result))
        {
        	?>
            <tr>
            	<td>
                	<?php
        			$linkfa = "#";
        			$numi = "";
					$largura = strlen($row['numero']);
					for($xz=$largura; $xz<5; $xz++) $numi .="0";
        			if (file_exists("facturas/SN_".$numi.$row['numero']).".pdf") $linkfa = BASEURL."facturas/SN_".$numi.$row['numero'];
     				echo 'SN_'.$numi.$row['numero'].'/'.substr($row['fecha'], 0, 4);
     				?>
    			</td>
    			<td>
    				<?php
    				if($row['presupuesto']>0)
    				{
    					$sqlpre = "SELECT id, numero FROM kng_presupuestos WHERE id = '".$row['presupuesto']."'";
    					$respre = mysql_query($sqlpre);
    					$rowpre = mysql_fetch_array($respre);
    					$numi = "";
						$largura = strlen($rowpre['numero']);
						for($xz=$largura; $xz<5; $xz++) $numi .="0";
    					//echo 'SN_'.$numi.$rowpre['numero'];
						echo '<a target="_blank" href="fac/pres_pdf_m.php?id='.$rowpre['id'].'">SN_'.$numi.$rowpre['numero'].'</a>';
    				}
    				?>
    			</td>
    			<td  class="{sorter: 'idoDate'}"><?php echo $row['fecha']; ?></td>
    			<td title="<?php echo $row['nombre']; ?>" class="may" ><?php echo (recortar_texto($row['nombre'], 35, " ", " [+]")); ?></td>
    			<td title="<?php echo $row['titulo']; ?>" class="may" ><?php echo (recortar_texto($row['titulo'], 35, " ", " [+]")); ?></td>
    			<td style="text-align: right; padding-right: 10px;">
            		<?php
					$sqlc = "SELECT precio, cantidad
					FROM kng_conceptos
					WHERE proforma = '".$row['faid']."'
					";
					$resc= mysql_query($sqlc);
					$tutti = 0;
					while($rowc=mysql_fetch_array($resc))
					{
						$tutti += ($rowc['precio']*$rowc['cantidad']);
					}
            		echo number_format($tutti, 2, ',', '.').' €';
            		?>
            	</td>
            	<td><?php echo ivafecha($row['fecha']).'%'; ?></td>
            	<td style="text-align: right; padding-right: 10px;"><?php echo number_format(iva($tutti, $row['fecha']), 2, ',', '.').' €'; ?>  </td>
            	<td class="tcentrado">
                    <?php
                    //MIRAMSO SI YA EXISTE UNA FACTURA DE ESTA PROFORMA
                    $sqlp = "SELECT id FROM kng_facturas WHERE presupuesto = '".$row['presupuesto']."'";
                    //echo $sqlp.'<br /><br />';
                    $resp = mysql_query($sqlp);
                    if(mysql_num_rows($resp)>0)
                    {
						$rowp = mysql_fetch_array($resp);
						?>
						<a target="_blank" href="fac/fac_pdf_m.php?id=<?php echo $rowp['id']; ?>"><img src="imagenes/ok.png" alt="Factura creada" title="Factura creada" width="16" height="16" /></a>
						<?php
                    }
                    else
                    {
                        ?><a href=""><img id="pr::<?php echo $row['presupuesto'].'::'.$row['clid'].'::'.$row['titulo']; ?>" class="crfa2" src="imagenes/icono-facturar.png" alt="facturar" title="Crear factura" width="16" height="16" /></a><?php
                    }
                    ?>
                </td>
				<td class="tcentrado"><a href="<?php echo BASEURL."fac/pro_pdf_m.php?id=".$row['faid'].""; ?>" target="_blank"><img src="imagenes/icono-pdf.png" alt="pdf" width="16" height="16" /></a></td>
			</tr>
        	<?php
        }
        ?>
   	</tbody>
</table>
<?php
include ("html/paginador.php");
?>
