<?php
$tablaa = "kng_hojasruta";
//DATOS VARIOS																										
//																													
$esteanio = date("Y");
//NUEVA																												
//																													
if ($_GET['arg2']=="nuevo")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{
		$sql = "INSERT INTO ".$tablaa."
		(artista, fecha, ciudad, produccion, responsable, email_responsable, tlf_resp, resp_produccion, tlf_resp_prod, resp_sonido, tlf_resp_soni, lugar, direccion, soundcheck, actuaciones, observaciones)
		VALUES ('".$_POST['artista']."', '".fechaes($_POST['fecha'])."', '".$_POST['ciudad']."', '".$_POST['produccion']."', '".$_POST['responsable']."', '".$_POST['email']."', '".$_POST['tlf_resp']."', '".$_POST['resp_produccion']."', '".$_POST['tlf_resp_prod']."', '".$_POST['resp_sonido']."', '".$_POST['tlf_resp_soni']."', '".$_POST['lugar']."', '".$_POST['direccion']."','".addslashes($_POST['soundcheck'])."','".addslashes($_POST['actuaciones'])."', '".addslashes($_POST['notas'])."')";
		//echo $sql.'<br /><br />';
		mysql_query($sql);
		header("Location: ".enlazar($_GET['arg1']));
	}
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
		header("Location: ".enlazar($_GET['arg1']));
	}
	?>
	<form id="perfil" action="" method="POST">
		<table class="formulario" width="95%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
			<tr>
				<th class="thtit" colspan="2">NUEVA HOJA DE RUTA</th>
			</tr>
			<tr>
				<th width="300px">ARTISTA / EVENTO</th>
				<td><input type="text" name="artista"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>FECHA</th>
				<td><input class="inputcalendario" type="text" name="fecha" readonly="readonly" onclick="displayCalendar(fecha,'dd-mm-yyyy',this)" style="width:100px; text-align:left" value="<?php echo fechaes(date("Y-m-d")); ?>" /></td>
			</tr>
			<tr>
				<th>CIUDAD</th>
				<td><input type="text" name="ciudad"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>PRODUCCIÓN</th>
				<td><input type="text" name="produccion"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>RESPONSABLE</th>
				<td><input type="text" name="responsable"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>EMAIL DEL RESPONSABLE</th>
				<td><input type="text" name="email"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>TELÉFONO DEL RESPONSABLE</th>
				<td><input type="text" name="tlf_resp"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>RESPONSABLE DE PRODUCCIÓN</th>
				<td><input type="text" name="resp_produccion"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>TELÉFONO DEL RESPONSABLE DE PRODUCCIÓN</th>
				<td><input type="text" name="tlf_resp_prod"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>RESPONSABLE DE SONIDO</th>
				<td><input type="text" name="resp_sonido"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>TELÉFONO DEL RESPONSABLE DE SONIDO</th>
				<td><input type="text" name="tlf_resp_soni"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>LUGAR</th>
				<td><input type="text" name="lugar"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>DIRECCIÓN</th>
				<td><input type="text" name="direccion"  style="width: 98%;"></td>
			</tr>
			<tr>
				<th>SOUNDCHECK</th>
				<td><textarea name="soundcheck" class="notiny tinybasic"></textarea></td>
			</tr>
			<tr>
				<th>ACTUACIONES</th>
				<td><textarea name="actuaciones" class="notiny tinybasic"></textarea></td>
			</tr>
			<tr>
				<th>NOTAS</th>
				<td><textarea name="notas"  style="width: 100%;" class="notiny tinybasic"></textarea></td>
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
//																													
else if ($_GET['arg2']=="editar")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{
		$sql = "UPDATE ".$tablaa." SET
		artista = '".$_POST['artista']."',
		fecha = '".fechaes($_POST['fecha'])."',
		ciudad = '".$_POST['ciudad']."',
		produccion = '".$_POST['produccion']."',
		responsable = '".$_POST['responsable']."',
		email_responsable = '".$_POST['email']."',
		tlf_resp = '".$_POST['tlf_resp']."',
		resp_produccion = '".$_POST['resp_produccion']."',
		tlf_resp_prod = '".$_POST['tlf_resp_prod']."',
		resp_sonido = '".$_POST['resp_sonido']."',
		tlf_resp_soni = '".$_POST['tlf_resp_soni']."',
		lugar = '".$_POST['lugar']."',
		direccion = '".$_POST['direccion']."',
		soundcheck = '".$_POST['soundcheck']."',
		actuaciones = '".$_POST['actuaciones']."',
		observaciones = '".$_POST['notas']."'";
		$sql .= " WHERE id = '".$_GET['arg3']."'";
		//echo $sql.'<br /><br />';
		mysql_query($sql);
		header("Location: ".enlazar($_GET['arg1']));
    }
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
    	header("Location: ".enlazar($_GET['arg1']));
	}
	$sql = "SELECT * FROM ".$tablaa." WHERE id='".$_GET['arg3']."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);    	
	?>
	<form action="" method="post">
		<table class="formulario" width="95%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
			<tr>
				<th class="thtit" colspan="2">EDITAR HOJA DE RUTA</th>
			</tr>
			<tr>
				<th width="300px">ARTISTA / EVENTO</th>
				<td><input type="text" name="artista"  style="width: 98%;" value="<?php echo $row['artista']; ?>"></td>
			</tr>
			<tr>
				<th>FECHA</th>
				<td><input class="inputcalendario" type="text" name="fecha" readonly="readonly" onclick="displayCalendar(fecha,'dd-mm-yyyy',this)" style="width:100px; text-align:left" value="<?php echo fechaes($row['fecha']); ?>" /></td>
			</tr>
			<tr>
				<th>CIUDAD</th>
				<td><input type="text" name="ciudad"  style="width: 98%;" value="<?php echo $row['ciudad']; ?>"></td>
			</tr>
			<tr>
				<th>PRODUCCIÓN</th>
				<td><input type="text" name="produccion"  style="width: 98%;" value="<?php echo $row['produccion']; ?>"></td>
			</tr>
			<tr>
				<th>RESPONSABLE</th>
				<td><input type="text" name="responsable"  style="width: 98%;" value="<?php echo $row['responsable']; ?>"></td>
			</tr>
			<tr>
				<th>EMAIL DEL RESPONSABLE</th>
				<td><input type="text" name="email"  style="width: 98%;" value="<?php echo $row['email_responsable']; ?>"></td>
			</tr>
			<tr>
				<th>TELÉFONO DEL RESPONSABLE</th>
				<td><input type="text" name="tlf_resp"  style="width: 98%;" value="<?php echo $row['tlf_resp']; ?>"></td>
			</tr>
			<tr>
				<th>RESPONSABLE DE PRODUCCIÓN</th>
				<td><input type="text" name="resp_produccion"  style="width: 98%;" value="<?php echo $row['resp_produccion']; ?>"></td>
			</tr>
			<tr>
				<th>TELÉFONO DEL RESPONSABLE DE PRODUCCIÓN</th>
				<td><input type="text" name="tlf_resp_prod"  style="width: 98%;" value="<?php echo $row['tlf_resp_prod']; ?>"></td>
			</tr>
			<tr>
				<th>RESPONSABLE DE SONIDO</th>
				<td><input type="text" name="resp_sonido"  style="width: 98%;" value="<?php echo $row['resp_sonido']; ?>"></td>
			</tr>
			<tr>
				<th>TELÉFONO DEL RESPONSABLE DE SONIDO</th>
				<td><input type="text" name="tlf_resp_soni"  style="width: 98%;" value="<?php echo $row['tlf_resp_soni']; ?>"></td>
			</tr>
			<tr>
				<th>LUGAR</th>
				<td><input type="text" name="lugar"  style="width: 98%;" value="<?php echo $row['lugar']; ?>"></td>
			</tr>
			<tr>
				<th>DIRECCIÓN</th>
				<td><input type="text" name="direccion"  style="width: 98%;" value="<?php echo $row['direccion']; ?>"></td>
			</tr>
			<tr>
				<th>SOUNDCHECK</th>
				<td><textarea name="soundcheck" class="notiny tinybasic"><?php echo $row['soundcheck']; ?></textarea></td>
			</tr>
			<tr>
				<th>ACTUACIONES</th>
				<td><textarea name="actuaciones" class="notiny tinybasic"><?php echo $row['actuaciones']; ?></textarea></td>
			</tr>
			<tr>
				<th>NOTAS</th>
				<td><textarea name="notas"  style="width: 100%;" class="notiny tinybasic"><?php echo $row['observaciones']; ?></textarea></td>
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
//GENERAL																							
//																									
else
{
	$sql = "SELECT id, artista, fecha, ciudad, responsable, resp_produccion, resp_sonido, activo
	FROM ".$tablaa."
	WHERE borrado = '0'";
	if(isset($_POST['accion']) AND $_POST['accion']=="Buscar")
	{
		if (isset($_POST['titulo'])) $sql .= " AND titulo LIKE '%".$_POST['titulo']."%'";
	}    
	$sql .= " ORDER BY fecha DESC";
	//echo $sql.'<br />';
	$result = mysql_query($sql);
	$cuantos=mysql_num_rows($result);
	?>
	<!-- CABECERA -->
	<div class="infotabla pager">
		Eventos: <?php echo $cuantos; ?>
	</div>
	<!-- BUSCADOR -->
	<div class="pager buscador">
		<form action="" method="post">
			<input type="text" name="titulo">
			<input type="submit" value="Buscar" name="accion" />
        </form>
    </div>
    <table class="tablesorter">
    	<thead>
        	<tr>
            	<th>ARTISTA / EVENTO</th>
            	<th>FECHA</th>
            	<th>CIUDAD</th>
            	<th>RESPONSABLE</th>
            	<th>RESPONSABLE PRODUCCIÓN</th>
            	<th>RESPONSABLE SONIDO</th>
            	<th width="1%" class="tcentrado {sorter: false}" >PDF</th>
            	<th width="1%" class="tcentrado {sorter: false}" >ACTIVO</th>
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
                	<td><?php echo $row['artista']; ?></td>
        					<td><?php echo fechaes($row['fecha']); ?></td>
        					<td><?php echo $row['ciudad']; ?></td>
        					<td><?php echo $row['responsable']; ?></td>
        					<td><?php echo $row['resp_produccion']; ?></td>
        					<td><?php echo $row['resp_sonido']; ?></td>
        					<td><a target="_blank" href="<?php echo BASEURL; ?>fac/ruta_pdf.php?id=<?php echo $row['id']; ?>" title=""><img width="16" height="16" alt="pdf" src="imagenes/icono-pdf.png" title=""></a></td>
									<td align="center">
        					<?php
									if ($row['activo']=="1") echo '<a href="" class="'.$tablaa.'::'.$row['id'].'::activo"><img src="imagenes/ok.png" alt="ON" width="16" height="16" class="clicki"/></a>';
                  else echo '<a href="" class="'.$tablaa.'::'.$row['id'].'::activo"><img src="imagenes/bannear.png" alt="OFF" width="16" height="16" class="clicki" /></a>';
									?>
									</td>
                	<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/editar/".$row['id']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
                	<td class="tcentrado"><a title="Borrar" href="" class="<?php echo $tablaa.'::'.$row['id']; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="borradof" /></a></td>
            	</tr>
            	<?php
            }
            ?>
       	</tbody>
    </table>
    	<div style="padding-top: 10px; text-align: center;">
        	<a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nueva hoja de ruta</a>
    	</div>
	<?php
    include ("html/paginador.php");
}
?>