<?php
//CONFIGURACION																	
$tablaa = "zkng_idiomas";
?>
<?php
//NUEVO																		
if ($_GET['arg2']=="nuevo")
{
    	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
    	{
        	$sql = "SELECT id
        	FROM zkng_idiomas
        	WHERE nombre = '".$_POST['nombre']."'";
        	$result = mysql_query($sql);
        	if (mysql_num_rows($result)>0) echo '<div class="aviso1">Ya existe el idioma : '.$_POST['idioma'].'</div>';
        	else
        	{
            		mysql_query("INSERT INTO zkng_idiomas (nombre, descripcion, posicion) VALUES ('".$_POST['nombre']."', '".$_POST['descripcion']."', '99')");
            		header("Location: ".enlazar($_GET['arg1']));
        	}
    	}
    	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    	{
	        header("Location: ".enlazar($_GET['arg1']));
    	}
    	?>
	<form id="rolex" action="<?php echo enlazar($_GET['arg1']."/".$_GET['arg2']); ?>" method="POST">
        	<table class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
	            	<tr>
	                	<th class="thtit tcentrado" colspan="2">NUEVO IDIOMA</th>
	            	</tr>
	            	<tr>
		            	<th colspan="2" class="thtit">Cuando se inserta un nuevo idioma hay que crear las nuevas columnas en las tablas que así lo requieran para poder almacenar los contenidos en el nuevo idioma.</th>
	            	</tr>
	            	<tr>
	                	<th style="width: 25%; text-align: left; text-indent: 10px;">Nombre</th>
	                	<td style="width: 75%;"><input class="obligatorio" title="Nombre" style="width: 98%" type="text" name="nombre" /></td>
	            	</tr>
	            	<tr>
	                	<th style="width: 25%; text-align: left; text-indent: 10px;">Descripción</th>
	                	<td style="width: 75%;"><input class="obligatorio" title="Descripcion" style="width: 98%" type="text" name="descripcion" /></td>
	            	</tr>
	            	<tr>
		                <td class="tdlimpio" colspan="2" align="center">
	                    		<input class="bg_rojo" type="submit" name="accion" value="Guardar" id="guardar" title="guardar" />
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
            	$sql = "UPDATE zkng_idiomas SET
         	descripcion='".$_POST['descripcion']."'
            	WHERE id = '".$_GET['arg3']."'";
            	mysql_query($sql);
            	header("Location: ".enlazar($_GET['arg1']));
    	}
    	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    	{
	        header("Location: ".enlazar($_GET['arg1']));
    	}
    	$sql = "SELECT nombre, descripcion, posicion
    	FROM zkng_idiomas
    	WHERE id = '".$_GET['arg3']."'
    	LIMIT 1";
    	$res = mysql_query($sql);
    	$row = mysql_fetch_array($res);
    	?>
	<form id="rolex" action="" method="POST">
        	<table class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
	            	<tr>
	                	<th class="thtit tcentrado" colspan="2">EDITAR IDIOMA</th>
	            	</tr>
	            	<tr>
	                	<th style="width: 25%; text-align: left; text-indent: 10px;">Nombre</th>
	                	<td style="width: 75%;"><input class="obligatorio" title="Nombre" style="width: 98%" type="text" name="nombre" value="<?php echo $row['nombre']; ?>" readonly="true" disabled="true" /></td>
	            	</tr>
	            	<tr>
	                	<th style="width: 25%; text-align: left; text-indent: 10px;">Descripción</th>
	                	<td style="width: 75%;"><input class="obligatorio" title="Descripcion" style="width: 98%" type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>" /></td>
	            	</tr>
	            	<tr>
		                <td class="tdlimpio" colspan="2" align="center">
	                    		<input class="bg_rojo" type="submit" name="accion" value="Guardar" id="guardar" title="guardar" />
	                    		<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
	                	</td>
	            	</tr>
        	</table>
    	</form>
    	<?php	
}
//ORDENAR 																		
else if ($_GET['arg2']=="ordenar")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
    	{
        	$sql = "SELECT id
        	FROM zkng_idiomas
        	ORDER BY posicion ASC";
	    	$result = mysql_query($sql);
        	while ($row = mysql_fetch_array($result))
        	{
            		$sql2 = "UPDATE zkng_idiomas SET
   			posicion='".$_POST['posicion'.$row['id'].'']."'
			WHERE id = '".$row['id']."'";
			mysql_query($sql2);
        	}
        	header("Location: ".enlazar($_GET['arg1']));
    	}
    	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    	{
    		header("Location: ".enlazar($_GET['arg1']));
    	}
        $sql = "SELECT id, descripcion, nombre, posicion
        FROM zkng_idiomas
        ORDER BY posicion ASC";
	$res = mysql_query($sql);
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
        	<table class="formulario" width="40%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
                	<tr>
	                    	<th colspan="2" class="thtit tcentrado">ORDENAR IDIOMAS</th>
                	</tr>
                	<tr>
        			<th>NOMBRE</th>
        			<th>POSICIÓN</th>
        		</tr>
                	<?php
                	while($row = mysql_fetch_array($res))
                	{
                		?>
                		<tr>
					<th><?php echo $row['descripcion'].' ['.$row['nombre'].']'; ?></th>
					<td align="center" width="55px"><input style="width: 50px;" type="text" name="posicion<?php echo $row['id']; ?>" value="<?php echo $row['posicion']; ?>" /></td>                		
                		</tr>
                		<?php
                	}
                	?>
                      	<tr>
                    		<td class="tdlimpio" colspan="2" style="text-align: center;">
                        		<input class="bg_rojo" type="submit" name="accion" value="Guardar" />
                        		<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
                    		</td>
                	</tr>
            	</table>
        </form>
	<?php
}
//GENERAL																		
else
{
	$sql = "SELECT id, nombre, descripcion, activo
	FROM zkng_idiomas
	ORDER BY posicion, nombre";
    	$result = mysql_query($sql);
    	$cuantos = mysql_num_rows($result);
    	?>
    	<div class="infotabla pager">
        	Idiomas: <?php echo $cuantos; ?>
    	</div>
    	<table class="tablesorter" style="width: 50%;">
        	<thead>
	            	<tr>
	            		<th>NOMRE</th>
	                	<th>DESCRIPCIÓN</th>
	                	<th width="5%" class="tcentrado {sorter: false}">ACTIVO</th>
	                	<th width="5%" class="tcentrado {sorter: false}">EDITAR</th>
	                	<th width="5%" class="tcentrado {sorter: false}">BORRAR</th>
	            	</tr>
        	</thead>
        	<tbody>
            		<?php
            		while ($row = mysql_fetch_array($result))
            		{
                		?>
                		<tr>
                			<td><?php echo strtoupper($row['nombre']); ?></td>
                    			<td><?php echo ucfirst($row['descripcion']); ?></td>
                    			<td class="tcentrado">
	                        		<?php
	                        		if ($row['activo']=="1") echo '<a href="" class="'.$tablaa.'::'.$row['id'].'::activo"><img src="imagenes/ok.png" alt="ON" width="16" height="16" class="clicki" /></a>';
	                        		else echo '<a href="" class="'.$tablaa.'::'.$row['id'].'::activo"><img src="imagenes/bannear.png" alt="OFF" width="16" height="16"  class="clicki" /></a>';
	                        		?>
	                    		</td>
                    			<td class="tcentrado"><a title="Editar" href="<?php echo enlazar($_GET['arg1']."/editar/".$row['id']); ?>"><img src="imagenes/editar.png" alt="Editar" width="16" height="16" /></a></td>
                    			<td class="tcentrado"><a title="Borrar" href="" class="<?php echo $tablaa.'::'.$row['id']; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="borradof" /></a></td>
                		</tr>
                		<?php
            		}
            		?>
        	</tbody>
    	</table>
    	<div style="padding-top: 10px; text-align: center;">
	        <a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nuevo idioma</a>
	        <a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/ordenar"); ?>">Reordenar</a>
    	</div>
	<?php
    	include ("html/paginador.php");
}
?>