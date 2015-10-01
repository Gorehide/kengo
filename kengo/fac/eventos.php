<?php
$tablaa = "kng_eventos";
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
		(titulo, fecha, precio, notas)
		VALUES ('".$_POST['titulo']."', '".fechaes($_POST['fecha'])."', '".$_POST['precio']."', '".addslashes($_POST['notas'])."')";
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
            	<th class="thtit" colspan="2">NUEVO EVENTO</th>
        	</tr>
        	<tr>
            	<th>TÍTULO</th>
            	<td><input type="text" name="titulo"  style="width: 98%;"></td>
        	</tr>
        	<tr>
        		<th>FECHA</th>
            	<td>
	            	<input class="inputcalendario" type="text" name="fecha" readonly="readonly" onclick="displayCalendar(fecha,'dd-mm-yyyy',this)" style="width:100px; text-align:left" value="<?php echo fechaes(date("Y-m-d")); ?>" />
          		</td>
        	</tr>
        	<tr>
            	<th>PRECIO</th>
            	<td><input type="text" name="precio"  style="width: 98%;"></td>
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
		titulo = '".$_POST['titulo']."',
		fecha = '".fechaes($_POST['fecha'])."',
		precio = '".$_POST['precio']."',
		notas = '".addslashes($_POST['notas'])."'";
		$sql .= " WHERE id = '".$_GET['arg3']."'";
		//echo $sql.'<br /><br />';
		mysql_query($sql);
		header("Location: ".enlazar($_GET['arg1']));
    }
	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
	{
    	header("Location: ".enlazar($_GET['arg1']));
	}
	$sql = "SELECT id, titulo, fecha, precio, notas FROM ".$tablaa." WHERE id='".$_GET['arg3']."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);    	
	?>
	<form action="" method="post">
    	<table class="formulario" width="95%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
        	<tr>
            	<th class="thtit" colspan="2">EDITAR EVENTO</th>
        	</tr>
        	<tr>
            	<th>TÍTULO</th>
            	<td><input type="text" name="titulo"  style="width: 98%;"  value="<?php echo $row['titulo']; ?>"></td>
        	</tr>
        	<tr>
        		<th>FECHA</th>
            	<td>
	            	<input class="inputcalendario" type="text" name="fecha" readonly="readonly" onclick="displayCalendar(fecha,'dd-mm-yyyy',this)" style="width:100px; text-align:left" value="<?php echo fechaes($row['fecha']); ?>" />
          		</td>
        	</tr>
        	<tr>
            	<th>PRECIO</th>
            	<td><input type="text" name="precio"  style="width: 98%;" value="<?php echo $row['precio']; ?>"></td>
        	</tr>
        	<tr>
            	<th>NOTAS</th>
            	<td><textarea name="notas"  style="width: 100%;" class="notiny tinybasic"><?php echo $row['notas']; ?></textarea></td>
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
	$sql = "SELECT id, fecha, titulo, precio, activo, notas
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
            	<th width="100px">FECHA</th>
            	<th>TITULO</th>
            	<th>NOTAS</th>
            	<th width="5%">PRECIO</th>
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
                	<td><?php echo $row['fecha']; ?></td>
        			<td><?php echo $row['titulo']; ?></td>
        			<td><?php echo strip_tags($row['notas']); ?></td>
        			<td><?php echo $row['precio']; ?>€</td>
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
        	<a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nuevo evento</a>
    	</div>
	<?php
    include ("html/paginador.php");
}
?>