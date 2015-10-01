<script src="<?php echo BASEURL; ?>jscriptes/ciudades.js" type="text/javascript"></script>
<?php
$tablaa = "kng_clientes";
// NUEVO																							
//																								
if ($_GET['arg2']=="nueva")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{

            	/* INSERT */
		$sql = "INSERT INTO ".$tablaa."
		(cif, nombre, web, direccion, cp, ciudad, provincia, pais, telefono, fax, email)
		VALUES ( '".$_POST['cif']."', '".$_POST['nombre']."', '".$_POST['web']."', '".$_POST['direccion']."', '".$_POST['cp']."', '".$_POST['ciudad']."'
		, '".$_POST['provincia']."', '".$_POST['pais']."', '".$_POST['telefono']."', '".$_POST['fax']."', '".$_POST['email']."')";
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
 		<div class="infotabla pager">Nueva Empresa</div>
		<form id="vendedor" action="<?php echo enlazar($_GET['arg1']."/nueva"); ?>" method="POST" enctype="multipart/form-data">
		<!-- TABLA FORMULARIO DE ALTA -->
			<table class="formulario" width="80%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;" class="tcentrado">
				    <tr>
	        			<th>CIF</th>
	        			<td><input type="text" name="cif" style="width: 98%;" /></td>
	    		    	</tr>
				    <tr>
	        			<th>NOMBRE</th>
	        			<td><input type="text" name="nombre" style="width: 98%;" /></td>
	    		    	</tr>
				    <tr>
	        			<th>WEB</th>
	        			<td><input type="text" name="web" style="width: 98%;" />
        				</td>
	    		    	</tr>
	    		    	<tr>
					<th>DIRECCION</th>
					<td><input type="text" name="direccion" style="width: 98%;" /></td>	    		    	
	    		    	</tr>
	    		    	<tr>
					<th>CP</th>
					<td><input type="text" name="cp" style="width: 98%;" /></td>
	    		    	</tr>
	    		    	<tr>
					<th>PROVINCIA</th>
					<td style="width: 70%;">
	                			<select name="provincia" style="width: 98%;" id="provincia">
	                				<option value="0">Seleccione una provincia</option>
							<?php
							$sqlcl = "SELECT id, nombre FROM kng_provincias WHERE borrado = '0' ORDER BY nombre ASC";
							$rescl = mysql_query($sqlcl);
							while ($rowcl = mysql_fetch_array($rescl))
							{
								echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'">'.utf8_decode($rowcl['nombre']).'</option>';				
							}
							?>
	                    			</select>
	                		</td>	    		    	
	    		    	</tr>
	    		    	<tr>
					<th>POBLACION</th>					
	                		<td style="width: 70%;" id="ciudad">
	                			<select name="ciudad" style="width: 98%;" >
							<option value="0">Seleccione una provincia previamente</option>
	                    			</select>
	                		</td>
	    		    	</tr>	    		    	
	    		    	<tr>
					<th>PAIS</th>					
					<td><input type="text" name="pais" style="width: 98%;" /></td>    		    	
	    		    	</tr>
	    		    	<tr>
					<th>TELEFONO</th>					
					<td><input type="text" name="telefono" style="width: 98%;" /></td>    		    	
	    		    	</tr>
	    		    	<tr>
					<th>FAX</th>					
					<td><input type="text" name="fax" style="width: 98%;" /></td>	    		    	
	    		    	</tr>
	    		    	<tr>
					<th>EMAIL</th>					
					<td><input type="text" name="email" style="width: 98%;" /></td>    		    	
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
// EDITAR																											
//																												
else if ($_GET['arg2']=="editar")
{
	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
	{
        	/* UPDATE */
            	$sql = "UPDATE ".$tablaa." SET
            	cif='".$_POST['cif']."', 
            	nombre='".$_POST['nombre']."', 
            	web='".$_POST['web']."',
            	direccion='".$_POST['direccion']."', 
            	cp='".$_POST['cp']."', 
            	ciudad='".$_POST['ciudad']."',
		provincia='".$_POST['provincia']."',
		pais='".$_POST['pais']."',
		telefono='".$_POST['telefono']."',
		fax='".$_POST['fax']."',
            	email='".$_POST['email']."' WHERE id = '".$_GET['arg3']."'";
		mysql_query($sql) or die(mysql_error());        
        
		header("Location: ".enlazar("".$_GET['arg1'].""));
	}
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
		header("Location: ".enlazar("".$_GET['arg1'].""));
	}
	else
	{
		$sql = "SELECT cif, cl.nombre AS clnombre, web, direccion, cp, telefono, fax, email, pa.id AS paid, pa.nombre AS panombre, pr.id AS prid, pr.nombre AS prnombre, ci.id AS ciid, ci.nombre AS cinombre
		FROM ".$tablaa." AS cl
		LEFT JOIN kng_paises AS pa ON pa.id = cl.pais
		LEFT JOIN kng_provincias AS pr ON pr.id = cl.provincia
		LEFT JOIN kng_ciudades AS ci ON ci.id = cl.ciudad
		WHERE cl.id='".$_GET['arg3']."'
		";		
	
		$res=mysql_query($sql) or die(mysql_error());
		$row=mysql_fetch_array($res);
		?>
		<div class="infotabla pager">Editar Empresa</div>
		<form id="vendedor" action="<?php echo enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3'].""); ?>" method="POST" enctype="multipart/form-data">
 			<table class="formulario" width="80%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;" class="tcentrado">
			    	<tr>
	        			<th>CIF</th>
	        			<td><input type="text" name="cif" value="<?php echo $row['cif']; ?>" style="width: 98%;" /></td>
	    		    	</tr>
			    	<tr>
	        			<th>NOMBRE</th>
	        			<td><input type="text" name="nombre" value="<?php echo $row['clnombre']; ?>" style="width: 98%;" /></td>
	    		    	</tr>
				    <tr>
	        			<th>WEB</th>
	        			<td><input type="text" name="web" value="<?php echo $row['web']; ?>" style="width: 98%;" />
        				</td>
	    		    	</tr>
	    		    	<tr>
					<th>DIRECCION</th>
					<td><input type="text" name="direccion" value="<?php echo $row['direccion']; ?>" style="width: 98%;" /></td>
	    		    	</tr>
	    		    	<tr>
					<th>CP</th>					
					<td><input type="text" name="cp" value="<?php echo $row['cp']; ?>" style="width: 98%;" /></td>  		    	
	    		    	</tr>
	    		    	<tr>
					<th>PROVINCIA</th>
					<td style="width: 70%;">
	                			<select name="provincia" style="width: 98%;" id="provincia">
	                				<option value="0">Seleccione una provincia</option>
							<?php
							$sqlcl = "SELECT id, nombre FROM kng_provincias WHERE borrado = '0' ORDER BY nombre ASC";
							$rescl = mysql_query($sqlcl);
							while ($rowcl = mysql_fetch_array($rescl))
							{
								$sell = "";
								if($rowcl['id']==$row['prid']) $sell = 'selected="true"';
								echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'" '.$sell.'>'.utf8_decode($rowcl['nombre']).'</option>';				
							}
							?>
	                    			</select>
	                		</td>	    		    	
	    		    	</tr>
	    		    	<tr>
					<th>POBLACIÓN</th>					
	                		<td style="width: 70%;" id="ciudad">
						<select name="ciudad" style="width: 98%;">
							<?php
							$sqlcl = "SELECT id, nombre FROM kng_ciudades WHERE borrado = '0' AND provincia = '".$row[prid]."' ORDER BY nombre ASC";
							$rescl = mysql_query($sqlcl);
							while ($rowcl = mysql_fetch_array($rescl))
							{
								$sell = "";
								if($rowcl['id']==$row['ciid']) $sell = 'selected="true"';
								echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'" '.$sell.'>'.utf8_decode($rowcl['nombre']).'</option>';				
							}
							?>
	                    			</select>                		
	                		</td>
	    		    	</tr>
	    		    	<tr>
					<th>PAIS</th>
					<td style="width: 70%;">
	                			<select name="pais" style="width: 98%;">
							<?php
							$sqlcl = "SELECT id, nombre FROM kng_paises WHERE borrado = '0' ORDER BY nombre ASC";
							$rescl = mysql_query($sqlcl);
							while ($rowcl = mysql_fetch_array($rescl))
							{
								$sell = "";
								if($rowcl['id']==$row['paid']) $sell = 'selected="true"';
								echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'" '.$sell.'>'.utf8_encode($rowcl['nombre']).'</option>';				
							}
							?>
	                    			</select>
	                		</td>    		    	
	    		    	</tr>
	    		    	<tr>
					<th>TELEFONO</th>					
					<td><input type="text" name="telefono" value="<?php echo $row['telefono']; ?>" style="width: 98%;" /></td>
	    		    	</tr>
	    		    	<tr>
					<th>FAX</th>					
					<td><input type="text" name="fax" value="<?php echo $row['fax']; ?>" style="width: 98%;" /></td>	    		    	
	    		    	</tr>
	    		    	<tr>
					<th>EMAIL</th>					
					<td><input type="text" name="email" value="<?php echo $row['email']; ?>" style="width: 98%;" /></td>    		    	
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
// MOSTRAR CONTACTOS																											
//																															
else if ($_GET['arg2']=="mostrar")
{
	/* SELECT */
	$sql="SELECT id, empresa, nombre, apellido1, apellido2, email, movil, telefono, extension
	FROM kng_contactos
	WHERE borrado='0'
     	AND empresa = ".$_GET['arg3']."";
     
	if (isset($_POST['nombre']) AND $_POST['nombre']!="") $sql .= " AND
		nombre LIKE '%".$_POST['nombre']."%' OR
		apellido1 LIKE '%".$_POST['nombre']."%' OR
		apellido2 LIKE '%".$_POST['nombre']."%' OR
		movil LIKE '%".$_POST['nombre']."%' OR
		telefono LIKE '%".$_POST['nombre']."%' OR
		extension LIKE '%".$_POST['nombre']."%'";     
     
	$sql .= " ORDER BY nombre";

   	$res=mysql_query($sql) or die(mysql_error());
	$cuantos= mysql_num_rows($res);

    ?>
	<div class="infotabla pager">
		Contactos: <?php echo $cuantos; ?>
	</div>
	<div class="buscador pager">
            <form action="" method="post">

                Busqueda
                <input type="text" name="nombre" style="width: 200px;" <?php if ($_POST['nombre']!="") echo "value=\"".$_POST['nombre']."\""; ?> />
                <input class="bg_azul" type="submit" name="accion" value="Buscar" />

            </form>
    </div>
	<table class="tablesorter">
		<!--  CABECERA TABLA -->
		<thead>
			<tr>
				<!--	  INFO A MOSTRAR -->
				<th style="" class="tcentrado {sorter: true}">cliente</th>
				<th style="" class="tcentrado {sorter: true}">nombre</th>
                <th style="" class="tcentrado {sorter: true}">primer apellido</th>
                <th style="" class="tcentrado {sorter: true}">segundo apellido</th>
                <th style="" class="tcentrado {sorter: false}">email</th>
				<th style="" class="tcentrado {sorter: false}">movil</th>
				<th style="" class="tcentrado {sorter: false}">telefono</th>
				<th style="" class="tcentrado {sorter: false}">extension</th>
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
					<td class="tcentrado"><?php echo descripcion("clientes","id",$row['cliente'],"nombre"); ?></td>
					<td class="tcentrado"><?php echo $row['nombre']; ?></td>
					<td class="tcentrado"><?php echo $row['apellido1']; ?></td>
					<td class="tcentrado"><?php echo $row['apellido2']; ?></td>
					<td class="tcentrado"><?php echo $row['email']; ?></td>
					<td class="tcentrado"><?php echo $row['movil']; ?></td>
					<td class="tcentrado"><?php echo $row['telefono']; ?></td>
					<td class="tcentrado"><?php echo $row['extension']; ?></td>
					<!--	  OPCIONES EDITAR / BORRAR -->
<!--
					<td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/editar/".$row['id']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
-->
					<td class="tcentrado"><a href="<?php echo enlazar("Contactos/editar/".$row['id']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
					<td class="tcentrado"><a title="Borrar" href="#" class="contacto::s::<?php echo $row['id']; ?>" ><img src="imagenes/borrar.png" alt="borrar" width="16" height="16" class="dele" title="<?php echo $row['nombre']; ?>" /></a></td>
				</tr>
			  <?php
			  }
			  ?>
		</tbody>
	</table>
	<div style="padding-top: 10px; text-align: center;">
	<!--  BOTON NUEVO -->
            <a class="boton_a bg_rojo" href="<?php echo enlazar("contacto/nuevo"); ?>">Nuevo contacto</a>
        </div>
    	<?php
        include ("html/paginador.php");

}
//GENERAL																								
//																										
else
{
	$sql="SELECT id, cif, nombre, web, telefono
	FROM ".$tablaa."
	WHERE borrado='0'";
	if (isset($_POST['nombre']))
	{	
		$sql .= " AND cif LIKE '%".$_POST['nombre']."%' OR nombre LIKE '%".$_POST['nombre']."%' OR web LIKE '%".$_POST['nombre']."%' OR telefono LIKE '%".$_POST['nombre']."%'";
	}
	$sql .= " ORDER BY nombre";
	$res=mysql_query($sql) or die(mysql_error());
	$cuantos= mysql_num_rows($res);
	?>
	<div class="infotabla pager">
		Clientes: <?php echo $cuantos; ?>
	</div>
	<div class="buscador pager">
        	<form action="" method="post">
                	Búsqueda 
                	<input type="text" name="nombre" style="width: 200px;" <?php if (isset($_POST['nombre']) && $_POST['nombre']!="") echo "value=\"".$_POST['nombre']."\""; ?> />
                	<input class="bg_azul" type="submit" name="accion" value="Buscar" />
            	</form>
        </div>
	<table class="tablesorter">
		<!--  CABECERA TABLA -->
		<thead>
			<tr>
				<!--	  INFO A MOSTRAR -->
				<th style="width: 30%;" class="tcentrado">nombre</th>
				<th style="width: 30%;" class="tcentrado {sorter: false}">web</th>
				<th style="width: 25%;" class="tcentrado {sorter: false}">telefono</th>
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
					<td class="may"><?php echo $row['nombre']; ?></td>
					<td><a href="http://<?php echo $row['web']; ?>" target="_BLANK" ><?php echo $row['web']; ?></a></td>
					<td><?php echo $row['telefono']; ?></td>
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
            <a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nueva"); ?>">Nuevo cliente</a>
        </div>
    	<?php
        include ("html/paginador.php");
}
?>