<?php
$tablaa = "kng_ciudades"; 
// NUEVO																	
//																		
	if ($_GET['arg2']=="nueva")
	{
		if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
		{
		    	$sql = "INSERT INTO ".$tablaa." (provincia, nombre )
		        VALUES ('".$_POST['provincia']."', '".$_POST['nombre']."')";		
			mysql_query($sql) or die(mysql_error());
			header("Location: ".enlazar("".$_GET['arg1'].""));
		}
		else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
		{
			header("Location: ".enlazar("".$_GET['arg1'].""));
		}
		else
		{
			?>
			<div class="infotabla pager">NUEVA CIUDAD</div>
			<form id="vendedor" action="" method="POST" enctype="multipart/form-data">
				<table class="formulario" width="80%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;" class="tcentrado">
					<tr>
		        			<th>PROVINCIA</th>
		        			<td style="width: 70%;">
		                			<select name="provincia" style="width: 98%;" id="provincia">
								<?php
								$sqlcl = "SELECT id, nombre FROM kng_provincias WHERE borrado = '0' ORDER BY nombre ASC";
								$rescl = mysql_query($sqlcl);
								while ($rowcl = mysql_fetch_array($rescl))
								{
									$sell = "";
									if($rowcl['id']=="1") $sell='selected="selected"';
									echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'" '.$sell.'>'.utf8_decode($rowcl['nombre']).'</option>';				
								}
								?>
		                    			</select>
		                		</td>
		    		    	</tr>
					<tr>
		        			<th>NOMBRE</th>
		        			<td><input type="text" name="nombre" style="width: 98%;" /></td>
		    		    	</tr>
					<tr>
		        			<td class="tdlimpio" colspan="2" align="center">
			        			<input class="bg_rojo" type="submit" name="accion" value="Guardar"/>
			        			<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
			        		</td>
			    		</tr>
				</table>
			</form>
	                <?php
	      	}
	}
//#################################### EDITAR MUNICIPIOS ################################################################
else if ($_GET['arg2']=="editar")
{

	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{
	    	$sql = " UPDATE ".$tablaa." SET
	        nombre='".$_POST['nombre']."', provincia='".$_POST['provincia']."'
	        WHERE id = '".$_GET['arg3']."'";
	        mysql_query($sql) or die(mysql_error());
		header("Location: ".enlazar("".$_GET['arg1'].""));
	}
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
		header("Location: ".enlazar("".$_GET['arg1'].""));
	}
	else
	{
		$sql="SELECT id, provincia, nombre
		FROM ".$tablaa." WHERE id='".$_GET['arg3']."'";
		$res=mysql_query($sql) or die(mysql_error());
		$row=mysql_fetch_array($res);
		?>
		<div class="infotabla pager">EDITAR CIUDAD</div>
		<form id="vendedor" action="" method="POST" enctype="multipart/form-data">
			<table class="formulario" width="80%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;" class="tcentrado">
				<tr>
	        			<th>PROVINCIA</th>
	        			<td style="width: 70%;">
	                			<select name="provincia" style="width: 98%;" id="provincia">
							<?php
							$sqlcl = "SELECT id, nombre FROM kng_provincias WHERE borrado = '0' ORDER BY nombre ASC";
							$rescl = mysql_query($sqlcl);
							while ($rowcl = mysql_fetch_array($rescl))
							{
								$sell = "";
								if($rowcl['id']==$row['provincia']) $sell='selected="selected"';
								echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'" '.$sell.'>'.utf8_decode($rowcl['nombre']).'</option>';				
							}
							?>
	                    			</select>
	                		</td>
	    		    	</tr>
				<tr>
	        			<th>NOMBRE</th>
	        			<td><input type="text" name="nombre" style="width: 98%;" value="<?php echo $row['nombre']; ?>" /></td>
	    		    	</tr>
				<tr>
	        			<td class="tdlimpio" colspan="2" align="center">
		        			<input class="bg_rojo" type="submit" name="accion" value="Guardar"/>
		        			<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
		        		</td>
		    		</tr>
			</table>
		</form>
		<?php
	}
}
// GENERAL																
//																		
else
{
  	$sql=" SELECT id, nombre
  	FROM ".$tablaa."
    	WHERE borrado='0'";
    	if(isset($_POST['provincia']) AND $_POST['provincia']!="0") $prov = $_POST['provincia'];
    	else $prov = '1';
    	$sql .= " AND provincia = '".$prov."'";
	if (isset($_POST['nombre']) AND $_POST['nombre']!="") $sql .= " AND nombre LIKE '%".$_POST['nombre']."%' ";
	$sql .= " ORDER BY nombre";
    	$res=mysql_query($sql) or die(mysql_error());
	$cuantos= mysql_num_rows($res);
    	?>
    	<div class="infotabla pager">
		CIUDADES: <?php echo $cuantos; ?>
	</div>
    	<div class="buscador pager">
	        <form action="" method="post">
        		<select name="provincia" style="width: 50%;" id="selprovincias">
				<option value="0">Seleccione una Provincia</option>
				<?php
				$sqlc = "SELECT id, nombre
				FROM kng_provincias
				WHERE borrado='0'
				ORDER BY nombre ASC";
				$resc = mysql_query($sqlc);
				while ($rowc = mysql_fetch_array($resc))
				{
					?>
					<option value="<?php echo $rowc['id']; ?>"><?php echo  $rowc['nombre']; ?></option>			
					<?php
				}
				?>
			</select>
            		<input type="text" name="nombre" style="width: 200px;" <?php if (isset($_POST['nombre']) && $_POST['nombre']!="") echo "value=\"".$_POST['nombre']."\""; ?> />
            		<input class="bg_azul" type="submit" name="accion" value="Buscar" />
        	</form>
    	</div>
    	<div id="cambio">
		<table class="tablesorter">
			<thead>
				<tr>
	                                <th>Nombre</th>
					<th style="width: 5%;" class="tcentrado {sorter: false}">Editar</th>
				</tr>
			</thead>
			<tbody>
				<?php
			  	while ($row = mysql_fetch_array($res))
			  	{
					?>
					<tr id="col<?php echo $row['id']; ?>">
						<td><?php echo utf8_encode($row['nombre']); ?></td>
						<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/editar/".$row['id']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
					</tr>
			  		<?php
			  	}
			  	?>
			</tbody>
		</table>
		<div style="padding-top: 10px; text-align: center;">
			<!--  BOTON NUEVO -->
            		<a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nueva"); ?>">Nueva Ciudad</a>
	        </div>
	    	<?php
	        include ("html/paginador.php");
	        ?>
    	</div>
	<?php	
}
?>  