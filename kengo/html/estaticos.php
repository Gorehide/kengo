<?php
if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
{
	$columnas = $datiums = "";
	if($_POST['existe']=='1')
	{
		for ($xz=0; $xz<count($aidiomas); $xz++)
		{
			$datiums .= "".$aidiomas[$xz]['nombre']."='".$_POST[$aidiomas[$xz]['nombre']]."', ";	
		}
		$sql = "UPDATE zkng_estaticos SET
	    	".$datiums."
	    	 menu = '".$_POST['id']."'
	    	WHERE menu = '".$_POST['id']."'";
	}	
	else
	{
		for ($xz=0; $xz<count($aidiomas); $xz++)
	      	{
	        	$columnas .= "".$aidiomas[$xz]['nombre'].", ";
	                $datiums .= "'".$_POST[''.$aidiomas[$xz]['nombre'].'']."', ";
	      	}
		$sql = "INSERT INTO zkng_estaticos (".$columnas." menu)
		VALUES (".$datiums." '".$_POST['id']."')";
	}
    	mysql_query($sql);
    	//echo $sql;
}
$sql = "SELECT *
FROM zkng_estaticos
WHERE menu = '".$rowzona['id']."'
LIMIT 1";
$result = mysql_query($sql);
//echo $sql;
$row = mysql_fetch_array($result);
?>
<form action="" method="POST" enctype="multipart/form-data">
    	<table class="formulario" width="100%" border="0" cellpadding="0" cellspacing="2" align="center">
	    	<tr>
	    		<td>
		                <?php
		                for ($xz=0; $xz<count($aidiomas); $xz++)
		                {
		                	?>
	                    		<a style="display: block; text-transform: uppercase; text-align: center;" href="" class="infotabla pager ocultaridioma idi<?php echo $xz; ?>" cual="idi<?php echo $xz; ?>"><?php echo $aidiomas[$xz]['descripcion']; ?></a>
		                    	<div class="capaocultaidioma" cual="ocidi<?php echo $xz; ?>">
		                    		<textarea style="width: 100%; height: 300px;" name="<?php echo $aidiomas[$xz]['nombre']; ?>"><?php echo $row[''.$aidiomas[$xz]['nombre'].'']; ?></textarea>
		                    	</div>		                    	
		                    	<?php
		                }
		                ?>
	    		</td>
	    	</tr>
	        <tr>
	  		<td class="tdlimpio" colspan="2" align="center">
	  			<input type="submit" class="bg_rojo" name="accion" value="Guardar"/>
	  			<input type="submit" class="bg_rojo" name="accion" value="Cancelar" />
	                	<input type="hidden" name="id" value="<?php echo $rowzona['id']; ?>" />
	                	<?php
	                	if (mysql_num_rows($result)>0) echo '<input type="hidden" name="existe" value="1" />';
	                	else echo '<input type="hidden" name="existe" value="0" />';
	                	?>
	  		</td>
	        </tr>
	</table>
</form>