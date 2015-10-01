<?php
$tablaa = "kng_cuentas";

// NUEVO																							
//																								
if ($_GET['arg2']=="nueva")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{

            	/* INSERT */
		$sql = "INSERT INTO ".$tablaa."
		(cuenta, banco, descripcion)
		VALUES ( '".$_POST['cuenta']."', '".$_POST['banco']."', '".$_POST['descripcion']."')";
		mysql_query($sql) or die(mysql_error());
		$id=mysql_insert_id();
		header("Location: ".enlazar("".$_GET['arg1'].""));
	}
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
		header("Location: ".enlazar("".$_GET['arg1'].""));
	}
	else
	{
		?>
 		<div class="infotabla pager">Nueva cuenta</div>
		<form id="vendedor" action="" method="POST" enctype="multipart/form-data">
		<!-- TABLA FORMULARIO DE ALTA -->
			<table class="formulario" width="80%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;" class="tcentrado">
				<tr>
	        			<th>tipo</th>
	        			<td><input type="text" name="banco" style="width: 98%;" /></td>
	    		    	</tr>
				    <tr>
	        			<th>CUENTA y/o info extra</th>
	        			<td><input type="text" name="cuenta" style="width: 98%;" /></td>
	    		    	</tr>				    
				<tr>
	        			<th>DESCRIPCIÓN</th>
	        			<td><input type="text" name="descripcion" style="width: 98%;" /></td>
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
// EDITAR CLIENTES																							
//																										
else if ($_GET['arg2']=="editar")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{
            	$sql = "UPDATE ".$tablaa." SET
            	cuenta='".$_POST['cuenta']."', banco='".$_POST['banco']."', descripcion='".$_POST['descripcion']."'
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
		$sql="SELECT cuenta, banco, descripcion 
		FROM ".$tablaa."
		WHERE id='".$_GET['arg3']."'";
		$res=mysql_query($sql) or die(mysql_error());
		$row=mysql_fetch_array($res);
		?>
		<div class="infotabla pager">Editar Empresa</div>
		<form id="vendedor" action="" method="POST" enctype="multipart/form-data">
			<table class="formulario" width="80%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;" class="tcentrado">
				<tr>
	        			<th>TIPO</th>
	        			<td><input type="text" name="banco" value="<?php echo $row['banco']; ?>" style="width: 98%;" /></td>
	    		    	</tr>
			    	<tr>
	        			<th>CUENTA y/o info extra</th>
	        			<td><input type="text" name="cuenta" value="<?php echo $row['cuenta']; ?>" style="width: 98%;" /></td>
	    		    	</tr>			    	
				<tr>
	        			<th>DESCRIPCIÓN</th>
	        			<td><input type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>" style="width: 98%;" />
        				</td>
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
//GENERAL																								
//																										
else
{
	$sql="SELECT id, cuenta, banco, descripcion
	FROM ".$tablaa."
	WHERE borrado='0'
	ORDER BY cuenta";
	$res=mysql_query($sql) or die(mysql_error());
	$cuantos= mysql_num_rows($res);
	?>
	<div class="infotabla pager">
		Cuentas: <?php echo $cuantos; ?>
	</div>
	<table class="tablesorter">
		<!--  CABECERA TABLA -->
		<thead>
			<tr>
				<!--	  INFO A MOSTRAR -->
				<th style="width: 30%;" class="tcentrado">TIPO</th>
				<th style="width: 30%;" class="tcentrado {sorter: false}">cuenta y/o info extra</th>
				<th style="width: 25%;" class="tcentrado {sorter: false}">descripcion</th>
				<!--	  OPCIONES EDITAR / BORRAR -->
				<th style="width: 5%;" class="tcentrado {sorter: false}">Editar</th>
				<th style="width: 5%;" class="tcentrado {sorter: false}">Borrar</th>
			</tr>
		</thead>
		<tbody>
			<?php
			  while ($row = mysql_fetch_array($res))
			  {
				?>
				<tr id="col<?php echo $row['id']; ?>">
					<!--	  INFO A MOSTRAR -->
					<td class="may"><?php echo $row['banco']; ?></td>
					<td><?php echo $row['cuenta']; ?></td>
					<td><?php echo $row['descripcion']; ?></td>
					<!--	  OPCIONES EDITAR / BORRAR -->
					<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/editar/".$row['id']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
					<td class="tcentrado"><a title="Borrar" href="" class="<?php echo $tablaa.'::'.$row['id']; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="dele" /></a></td>
				</tr>
			  <?php
			  }
			  ?>
		</tbody>
	</table>
	<div style="padding-top: 10px; text-align: center;">
	<!--  BOTON NUEVO -->
            <a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nueva"); ?>">Nueva cuenta</a>
        </div>
    	<?php
        include ("html/paginador.php");
}
?>