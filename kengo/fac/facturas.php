<?php
$tablaa = "kng_facturas";
//DATOS VARIOS
$esteanio = date("Y");
//NUEVA
if ($_GET['arg2']=="nuevo")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{
		$sql = "SELECT numero
		FROM kng_facturas
		ORDER BY numero DESC";
		$res = mysql_query($sql);
		$max = mysql_fetch_array($res);
		$numero = $max['numero']+1;
		if(isset($_POST['formacion'])) $formacion = 1; else $formacion = 0;
		$sql = "INSERT INTO kng_facturas
		(numero, cliente, fecha, cuenta, titulo, notas)
		VALUES ('".$numero."', '".$_POST['cliente']."', '".fechaes($_POST['fecha'])."', '".$_POST['cuenta']."', '".$_POST['titulo']."', '".addslashes($_POST['notas'])."')";
		mysql_query($sql);
		$id = mysql_insert_id();
		header("Location: ".enlazar($_GET['arg1'].'/editar/'.$id));
	}
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
		header("Location: ".enlazar($_GET['arg1']));
	}
	?>
	<form id="perfil" action="" method="POST">
		<table class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
			<tr>
				<th class="thtit" colspan="2">NUEVA FACTURA</th>
			</tr>
			<tr>
				<th>CLIENTE</th>
				<td style="width: 70%;">
					<select name="cliente" style="width: 100%;">
						<?php
						$sqlcl = "SELECT id, nombre FROM kng_clientes WHERE borrado = '0' ORDER BY nombre ASC";
						$rescl = mysql_query($sqlcl);
						while ($rowcl = mysql_fetch_array($rescl))
						{
							echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'">'.$rowcl['nombre'].'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>CUENTA</th>
				<td>
					<select name="cuenta" style="width: 100%;">
						<?php
						$sqlcl = "SELECT id, descripcion FROM kng_cuentas ORDER BY descripcion ASC";
						$rescl = mysql_query($sqlcl);
						while ($rowcl = mysql_fetch_array($rescl))
						{
							echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'">'.$rowcl['descripcion'].'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>FECHA</th>
				<td><input value="<?php echo date("d-m-Y"); ?>" class="inputcalendario" type="text" name="fecha" readonly="readonly" onclick="displayCalendar(fecha,'dd-mm-yyyy',this)" style="width:100px; text-align:left" /></td>
			</tr>
			<tr>
				<th>TÍTULO</th>
				<td><input type="text" name="titulo"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>NOTAS</th>
				<td><textarea name="notas"  style="width: 100%;"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="tdlimpio">
					<input class="bg_rojo" type="submit" name="accion" value="Guardar" title="guardar" />
					<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
				</td>
			</tr>
		</table>
	</form>
	<?php
}
//EDITAR
else if ($_GET['arg2']=="editar")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{
		if(isset($_POST['formacion'])) $formacion = 1; else $formacion = 0;
		$sql = "UPDATE ".$tablaa." SET
		tipo='".$_POST['tipo']."',
		cliente='".$_POST['cliente']."',
		cuenta='".$_POST['cuenta']."',
		titulo='".$_POST['titulo']."',
		notas='".addslashes($_POST['notas'])."'";
		$sql .= " WHERE id = '".$_GET['arg3']."'";
		//echo $sql;
		mysql_query($sql);
		header("Location: ".enlazar($_GET['arg1']));
		header("Location: ".enlazar($_GET['arg1'].'/editar/'.$_GET['arg3']));
	}
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
		header("Location: ".enlazar($_GET['arg1']));
	}
	$sql = "SELECT id, cliente, cuenta, titulo, notas, tipo FROM ".$tablaa." WHERE id='".$_GET['arg3']."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	?>
	<form action="" method="post">
		<table class="formulario" width="95%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
			<tr>
				<th class="thtit" colspan="2">EDITAR FACTURA</th>
			</tr>
			<tr>
				<th >CLIENTE</th>
				<td >
					<select name="cliente" style="width: 98%;">
						<?php
						$sqlcl = "SELECT id, nombre FROM kng_clientes WHERE borrado='0' ORDER BY nombre ASC";
						$rescl = mysql_query($sqlcl);
						while ($rowcl = mysql_fetch_array($rescl))
						{
							$as="";
							if ($rowcl['id']==$row['cliente']) $as = 'selected="selected"';
							echo '<option style="text-transform: uppercase;" '.$as.' value="'.$rowcl['id'].'">'.$rowcl['nombre'].'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>CUENTA</th>
				<td>
					<select name="cuenta" style="width: 98%;">
						<?php
						$sqlcl = "SELECT id, descripcion, cuenta FROM kng_cuentas WHERE borrado='0' ORDER BY descripcion ASC";
						$rescl = mysql_query($sqlcl);
						while ($rowcl = mysql_fetch_array($rescl))
						{
							$as="";
							if ($rowcl['id']==$row['cuenta']) $as = 'selected="selected"';
							echo '<option style="text-transform: uppercase;" '.$as.' value="'.$rowcl['id'].'">'.$rowcl['descripcion'].' ['.$rowcl['cuenta'].']</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>TÍTULO</th>
				<td><input type="text" name="titulo"  style="width: 98%;" value="<?php echo $row['titulo']; ?>"></td>
			</tr>
			<tr>
				<th>TIPO</th>
				<td>
					<select name="tipo" style="width: 98%;">
						<?php
						$sqlcl = "SELECT id, nombre FROM kng_tiposfactura ORDER BY nombre ASC";
						$rescl = mysql_query($sqlcl);
						while ($rowcl = mysql_fetch_array($rescl))
						{
							$as="";
							if ($rowcl['id']==$row['tipo']) $as = 'selected="selected"';
							echo '<option style="text-transform: uppercase;" '.$as.' value="'.$rowcl['id'].'">'.$rowcl['nombre'].'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>NOTAS</th>
				<td><textarea name="notas"  style="width: 100%;" class="notiny tinybasic"><?php echo $row['notas']; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="tdlimpio">
					<input class="bg_rojo" type="submit" name="accion" value="Guardar" title="guardar" />
					<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
					<a class="boton_a bg_rojo" target="_blank" href="<?php echo BASEURL."fac/fac_pdf_m.php?id=".$_GET['arg3'].""; ?>" target="_blank">Generar factura</a>
				</td>
			</tr>
			<tr>
				<th class="thtit" colspan="2" id="newcon">
					<table width="100%" >
						<tr>
							<td width="5%" class="tdlimpio">CONCEPTO: </td>
							<td width="50%" class="tdlimpio"><textarea name="concepto" class="notiny tinybasic" id="c1"></textarea></td>
							<td width="5%" class="tdlimpio">PRECIO: </td>
							<td width="10%" class="tdlimpio"><input type="text" name="precio" id="c2" /></td>
							<td width="5%" class="tdlimpio">CANTIDAD: </td>
							<td width="10%" class="tdlimpio"><input type="text" name="cantidad" id="c3" /></td>
							<td width="5%" class="tdlimpio"><div class="newconce"><a href="" title="Añadir concepto">+</a></div></td>
						</tr>
					</table>
				</th>
			</tr>
			<tr>
				<td colspan="2">
					<?php
					$totalo = 0;
					$num = 0;
					$sql = "SELECT id, concepto, precio, cantidad, num FROM kng_conceptos WHERE factura='".$_GET['arg3']."' ORDER BY num ASC";
					$res = mysql_query($sql);
					?>
					<div id="prfa" class="<?php echo $_GET['arg3']; ?>"></div>
					<div class="conceptos">
						<ul class="presusi" id="conceptitos">
							<?php
							while($row=mysql_fetch_array($res))
							{
								$totall=( $row[ 'precio']*$row[ 'cantidad']);
								?>
								<li id="concepto-<?php echo $row['id']; ?>">
									<table width="100%" class="cct<?php echo $row['num']; ?> conann">
										<tr>
											<td width="50%" class="tdlimpio conL">
												<?php echo $row[ 'concepto']; ?>
											</td>
											<td width="5%" class="tdlimpio zz">PRECIO: </td>
											<td width="10%" class="tdlimpio zy preL">
												<?php echo number_format($row[ 'precio'], 2, ',', '.'); ?>
											</td>
											<td width="5%" class="tdlimpio zz">CTD: </td>
											<td width="5%" class="tdlimpio zy canL">
												<?php echo $row[ 'cantidad']; ?>
											</td>
											<td width="5%" class="tdlimpio zz">TOT: </td>
											<td width="10%" class="tdlimpio zy totalL">
												<?php echo number_format($totall, 2, ',', '.'); ?>
											</td>
											<td width="5%" class="tdlimpio">
												<ul>
													<li class="editconce" id="dc::<?php echo $row['id']; ?>">
														E
													</li>
													<li class="delconce" id="dc::<?php echo $row['num']; ?>::<?php echo $totall;  ?>">
														X
													</li>
												</ul>
											</td>
										</tr>
									</table>
								</li>
								<?php
								$totalo +=( $row['precio']*$row['cantidad']);
								$num=$row['num'];
							}
							?>
						</ul>
						<?php
						$num++;
						$ivaa = ($totalo*$iva)/100;
						$totaloiva = $totalo+$ivaa;
						?>
						<div id="next" class="<?php echo $num; ?>"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="font-size: 20px; font-weight: bold; color: #FFFFFF;" class="thtit">
					TOTAL: <span id="totall" total="<?php echo $totalo;  ?>"><?php echo number_format($totalo, 2, ',', '.').' € +IVA ('.$iva.'%) '.number_format($ivaa, 2, ',', '.').' € :: '.number_format($totaloiva, 2, '.', ',').' €'; ?> </span>
				</td>
			</tr>
		</table>
	</form>
	<div id="editorlineas">
		<span class="cerrar">x</span>
		<div class="formulario">
			<table width="100%">
				<tr>
					<td width="70%" class="tdlimpio">
						<label for="conceptoE">Concepto</label>
						<textarea class="notiny tinybasic" id="conceptoE"></textarea>
					</td>
					<td width="30%" class="tdlimpio">
						<label for="precioE">Precio (formato 000000.00)</label>
						<input type="text" id="precioE" value=""></input>
						<label for="cantidadE">Cantidad</label>
						<input type="text" id="cantidadE" value=""></input>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="tdlimpio tcentrado" >
						<input type="hidden" id="idE" value=""></input>
						<input type="hidden" id="totalE" value=""></input>
						<input type="submit" name="submit" value="Modificar" class="modificar">
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
}
//GESTION DE PAGOS
else if ($_GET['arg2']=="pago")
{
	//NUEVO PAGO
	if($_GET['arg4']=="nuevo")
	{
		if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
		{
			$sql = "INSERT INTO kng_pagos (fecha, cantidad, factura)
			VALUES ('".fechaes($_POST['fecha'])."', '".$_POST['cantidad']."', '".$_GET['arg3']."')";
			echo $sql;
			mysql_query($sql);
			header("Location: ".enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3']));
		}
		else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
		{
			header("Location: ".enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3']));
		}
		?>
		<form id="perfil" action="" method="POST">
			<table class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
				<tr>
					<th class="thtit" colspan="2">NUEVO PAGO</th>
				</tr>
				<tr>
					<th>FECHA</th>
					<td align="center">
						<input class="inputcalendario" type="text" name="fecha" onclick="displayCalendar(fecha,'dd-mm-yyyy',this)" style="width:100px; text-align:left" />
					</td>
				</tr>
				<tr>
					<th>CANTIDAD</th>
					<td><input title="cantidad" style="width: 98%" type="text" name="cantidad" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="tdlimpio">
						<input class="bg_rojo" type="submit" name="accion" value="Guardar" title="guardar" />
						<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	//EDITAR PAGO
	else if($_GET['arg4']=="editar")
	{
		if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
		{
			$sql = "UPDATE kng_pagos
			SET fecha='".fechaes($_POST['fecha'])."', cantidad = '".$_POST['cantidad']."'
			WHERE id = '".$_GET['arg5']."'";
			mysql_query($sql);
			//echo $sql;
			header("Location: ".enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3']));
		}
		else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
		{
			header("Location: ".enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3']));
		}
		$sql = "SELECT * FROM kng_pagos WHERE id = '".$_GET['arg5']."'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		?>
		<form id="perfil" action="" method="POST">
			<table class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
				<tr>
					<th class="thtit" colspan="2">EDITAR PAGO</th>
				</tr>
				<tr>
					<th>FECHA</th>
					<td align="center">
						<input class="inputcalendario" type="text" name="fecha" onclick="displayCalendar(fecha,'dd-mm-yyyy',this)" style="width:100px; text-align:left"  value="<?php echo fechaes($row['fecha']); ?>"/>
					</td>
				</tr>
				<tr>
					<th>CANTIDAD</th>
					<td><input title="cantidad" style="width: 98%" type="text" name="cantidad" value="<?php echo $row['cantidad']; ?>" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center" class="tdlimpio">
						<input class="bg_rojo" type="submit" name="accion" value="Guardar" title="guardar" />
						<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	else
	{
		$esteanio = date("Y");
		$sql = "SELECT pa.id AS paid, pa.fecha as pafe, pa.cantidad as paca
		FROM kng_pagos AS pa
		LEFT JOIN kng_facturas AS fa ON fa.id = pa.factura
		WHERE pa.borrado = '0' AND factura = '".$_GET['arg3']."'";
		$sql .= " ORDER by pa.fecha DESC";
		//echo $sql;
		$result = mysql_query($sql);
		$cuantos=mysql_num_rows($result);
		?>
		<!-- CABECERA -->
		<div class="infotabla pager">
			Pagos: <?php echo $cuantos; ?>
		</div>
		<table class="tablesorter">
			<thead>
				<tr>
					<th>FECHA</th>
					<th width="100px" class="{sorter: 'currency'}">IMPORTE</th>
					<th width="5%;" class="tcentrado {sorter: false}" width="65px">EDITAR</th>
					<th width="5%;" class="tcentrado {sorter: false}" width="65px">BORRAR</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysql_fetch_array($result))
				{
					?>
					<tr id="col<?php echo $row['paid']; ?>">
						<td  class="{sorter: 'idoDate'}"><?php echo $row['pafe']; ?></td>
						<td style="text-align: right; padding-right: 10px;">
							<?php
							echo number_format($row['paca'], 2, '.', ',');
							?> €
						</td>
						<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3']."/editar/".$row['paid']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
						<td class="tcentrado"><a title="Borrar" href="" class="<?php echo 'kng_pagos::'.$row['paid']; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="dele" /></a></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<div style="padding-top: 10px; text-align: center;">
			<a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3']."/nuevo"); ?>">Nuevo pago</a>
		</div>
		<?php
		include ("html/paginador.php");
	}
}
//VER GRAFICAS
else if ($_GET['arg2']=="grafica")
{
	$esteanio = date("Y");
	$sql = "SELECT SUM(precio*cantidad) AS precio, nombre
	FROM kng_facturas AS fa
	LEFT JOIN kng_conceptos AS co ON co.factura = fa.id
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
			$mess = "0".$xc;
			$mess = substr($mess, -2);
			if($xc>$mesu) $sql .=" OR ";
			$sql .= " fecha LIKE '".$esteanio."-".$mess."-%' ";
		}
		$sql .= ")";
	}
	if (isset($_POST['fechi']) AND $_POST['fechi']!="") $sql .= " AND fecha >= '".$_POST['fechi']."'";
	if (isset($_POST['fechf']) AND $_POST['fechf']!="") $sql .= " AND fecha <= '".$_POST['fechf']."'";
	if (isset($_POST['cliente']) AND $_POST['cliente']>0) $sql .= " AND cl.id = '".$_POST['cliente']."'";
	$sql .= " GROUP BY nombre ORDER by precio DESC";
	//echo $sql.'<br />';
	$result = mysql_query($sql);
	$cuantos=mysql_num_rows($result);
	?>
	<!-- CABECERA -->
	<div class="infotabla pager">
		CLIENTES: <?php echo $cuantos; ?>
	</div>
	<!-- BUSCADOR -->
	<div class="pager buscador">
		<form action="" method="post">
			Año:
			<select name="anio" style="width: auto; padding: 2px 12px;">
				<option value="0">Seleccione año</option>
				<option value="all">Cualquiera</option>
				<?php
				for ($xi=date("Y"); $xi>=2010; $xi--)
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
			<input type="submit" value="Buscar" name="accion" />
		</form>
	</div>
	<div class="grafica">
		<table width="100%" border="0" cellpadding="0"cellspacing="0" >
			<?php
			$xx = 0;
			$porcen = 0;
			while($row = mysql_fetch_array($result))
			{
				if($xx==0)
				{
					$mayor = $row['precio'];
					$porcen = $row['precio']/100;
				}
				$anchura = (($row['precio']/$porcen)*8)+100;
				?>
				<tr>
					<th><?php echo $row['nombre']; ?></th>
					<td><div class="lingraph" style="width: <?php echo $anchura; ?>px"><div><?php echo number_format($row['precio'], 2, ',', '.').'€ ['.number_format(ivafecha($row['precio']), 2, ',', '.').' €]'; ?></div></div></td>
				</tr>
				<?php
				$xx++;
			}
			?>
		</table>
	</div>
	<?php
}
//GENERAL
else
{
	$esteanio = date("Y");
	$sql = "SELECT fa.id AS faid, numero, fecha, cl.nombre, presupuesto, titulo, ti.nombre AS titipo
	FROM ".$tablaa." AS fa
	LEFT JOIN kng_clientes As cl ON cl.id = fa.cliente
	LEFT JOIN kng_tiposfactura As ti ON ti.id = fa.tipo
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
	if (isset($_POST['tipo']) AND $_POST['tipo']>0) $sql .= " AND tipo = '".$_POST['tipo']."'";
	else $sql .= " AND tipo > '0'";
	$sql .= " ORDER by numero DESC";
	$sqlExport = base64_encode($sql);
	//echo $sql.'<br />';
	$result = mysql_query($sql);
	$cuantos=mysql_num_rows($result);
	?>
	<!-- CABECERA -->
	<div class="infotabla pager">
		Facturas: <?php echo $cuantos; ?>
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
			<select name="tipo" style="width: 300px; padding: 2px 12px; text-align: left;">
				<option value="0">Seleccionar tipo</option>
				<?php
				$sqlcli = "SELECT id, nombre FROM kng_tiposfactura WHERE borrado = '0' ORDER BY nombre";
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
				<th width="1%">Nº</th>
				<th width="5%">Tipo</th>
				<th width="100px">PRESUPUESTO</th>
				<th width="5%">FECHA</th>
				<th>CLIENTE</th>
				<th>TÍTULO</th>
				<th class="{sorter: 'currency'}">IMPORTE</th>
				<th class="tcentrado {sorter: false}">IVA</th>
				<th class="{sorter: 'currency'}">+IVA</th>
				<th class="{sorter: 'currency'}">PAGADO</th>
				<th class="{sorter: 'currency'}">PENDIENTE</th>
				<th width="1%" class="tcentrado {sorter: false}" >PAGO</th>
				<th width="1%" class="tcentrado {sorter: false}" >PDF</th>
				<!--<th width="5%;" class="tcentrado {sorter: false}" width="65px">ENVIAR</th>-->
				<th width="1%" class="tcentrado {sorter: false}" >EDITAR</th>
				<th width="1%" class="tcentrado {sorter: false}" >BORRAR</th>
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
						<?php echo $row['titipo']; ?>
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
						WHERE factura = '".$row['faid']."'
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
					<td style="text-align: right; padding-right: 10px;" >
						<?php
						$sql2 = "SELECT SUM(cantidad) AS total
						FROM kng_pagos
						WHERE borrado = '0' AND factura = '".$row['faid']."'
						GROUP BY factura ";
						$res2 = mysql_query($sql2);
						$row2 = mysql_fetch_array($res2);
						echo number_format($row2['total'], 2, ',', '.');
						?> €
					</td>
					<?php
					//PARA MARCAR EL CUADRO EN ROJO SI NO ESTA PAGADA
					$resto = round(iva($tutti, $row['fecha']),2)-$row2['total'];
					$clasu = '';
					if($resto>0) $clasu ='border: 1px solid red; background-color: #FFDDDD;';
					else $clasu ='border: 1px solid green; background-color: #DDFFDD;';
					?>
					<td style="text-align: right; padding-right: 10px; <?php echo $clasu; ?>">
						<?php
						//cho 'T_'.round(iva($tutti, $row['fecha']),2).'<br>';
						//echo 'P_'.$row2['total'].'<br>';
						if($resto < 0) $resto = 0;
						//echo round($resto,2).' €';
						echo number_format($resto, 2, ',', '');
						//echo number_format($resto, 2, '.', ',');
						?>
					</td>
					<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/pago/".$row['faid']); ?>"><img src="imagenes/icono-pago.png" alt="pago" width="16" height="16" /></a></td>
					<!--<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/pdf/generar/".$row['faid']); ?>"><img src="imagenes/icono-pdf.png" alt="pdf" width="16" height="16" /></a></td>-->
					<td class="tcentrado"><a href="<?php echo BASEURL."fac/fac_pdf_m.php?id=".$row['faid'].""; ?>" target="_blank"><img src="imagenes/icono-pdf.png" alt="pdf" width="16" height="16" /></a></td>
					<!--<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/enviar/".$row['faid']); ?>"><img src="imagenes/enviar.png" alt="enviar" width="16" height="16" /></a></td>-->
					<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/editar/".$row['faid']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
					<td class="tcentrado"><a title="Borrar" href="" class="<?php echo $tablaa.'::'.$row['faid']; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="borradof" /></a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<div style="padding-top: 10px; text-align: center;">
		<a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nueva factura</a>
		<a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/grafica"); ?>">Gráfica de ventas</a>
		<?php //$sqlExport = serialize($sqlExport); ?>
		<a class="boton_a bg_rojo" href="<?php echo BASEURL.'fac/exportar.php?q='.$sqlExport; ?>">Exportar</a>
	</div>
	<?php
	include ("html/paginador.php");
	include ("globales.php");
}
?>
