<a id="galoculta" href="">Editar la galería de la zección <b><?php echo $_GET['arg1']; ?></b></a>
<div id="galeriaoculta" style="width: 80%; margin: auto;">
<?php 
if(isset($_GET['modus'])) $modus = $_GET['modus'];
else $modus = "lista"; //LOS MODOS DE VISIONADO SON icono O lista
//RURA																				
$rutaarchivos = "../archivos/".$rutag;	
//SUBIR ARCHIVO																		
if (isset($_POST['accion']) AND $_POST['accion']=="subir")
{
    	$ruta=$rutaarchivos;
    	if (is_uploaded_file($_FILES['archivo']['tmp_name']))
    	{
	        move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta.$_FILES['archivo']['name']);
	        chmod($ruta.$_FILES['archivo']['name'], 0777);
    	}
    	echo '<div id="subgal" class="si" style="display: none;"></div>';
}
//GENERAL																		
?>
<div class="buscador pager">
	<table width="100%" >
		<tr>
			<td class="tdlimpio">
				<form action="" method="post" enctype="multipart/form-data">
		            		<input type="file" name="archivo" />
		            		<input type="submit" name="accion" value="subir" />
		        	</form>
			</td>		
		</tr>
	</table>
</div>
<?php
$path=$rutaarchivos;
$filis = scandir($path);
	for($xz=0; $xz<count($filis); $xz++)
    	{
    		if(!is_dir($filis[$xz]))
    		{
    			$archivo = $filis[$xz];
            		$ext = substr(strstr($archivo, '.'),1 ,4);
        		/*SI ESTAMSO FILTRANDO*/
        		if ((isset($_POST['accion'])) AND ($_POST['accion']=="Buscar"))
        		{
            			//echo "busco<br />";
            			if ($_POST['tipo']!="nada")
            			{
                			if (($_POST['texto'])!="")
                			{
                    				//echo "texto y tipo<br />";
                    				if (($ext == $_POST['tipo']) AND (eregi($_POST['texto'], $archivo))) mostri($archivo, $ext);
                			}
                			else
                			{
                    				//echo "tipo<br />";
                    				if ($ext == $_POST['tipo']) mostri($archivo, $ext);
                			}
            			}
            			else
            			{
                			//echo "texto<br />";
                			if ($_POST['texto'] != "")
                			{
                    				if (eregi($_POST['texto'], $archivo))  mostri($archivo, $ext);
                			}
                			else mostri($archivo, $ext);
            			}
        		}
        		/*LISTADO GENERAL*/
        		else mostri($archivo, $ext);
        	}
    	}
    	?>
    	<div class="finflotar"></div>
    	<?php

//FUNCION QUE CREA LAS MINIATURAS PARA LA VISTA DE ICONOS											
function mostri($archivo, $ext)
{
	global $k_cliente;
	global $rutaarchivos;
	global $rutag;
    	?>
    	<div class="archivez" style="background-image: url(<?php echo BASEURLX; ?>minis/timthumb.php?src=<?php echo BASEURLA.$rutag.'/'.$archivo; ?>&h=130&w=100&zc=1);">
        	<div style="height: 100px">
            		<?php
            		if (($ext=="jpg")OR($ext=="png")OR($ext=="gif")) echo "";
            		else echo wordwrap($archivo, 13, "\n", true);
            		?>
        	</div>
        	<div class="archivezfun">
            		<img title="<?php echo $ext;  ?>"  width="16px" height="16px" src="<?php echo BASEURL; ?>imagenes/tipos/<?php echo $ext; ?>.png" />
            		<a title="Borrar" href="" class="<?php echo $rutaarchivos.'::'.$archivo; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="deletefile" /></a>
            		<?php
            		if (($ext=="jpg")OR($ext=="png")OR($ext=="gif"))
            		{
                		?>
                		<a title="<?php echo $archivo; ?>" target="_blank" rel="shadowbox[<?php echo $k_cliente; ?>]" href="<?php echo BASEURLA.$rutag.'/'.$archivo; ?>" >
                    			<img src="imagenes/ver.png" alt="ver" width="16" height="16" />
                		</a>
                		<?php
            		}
            		else
            		{
                		?>
                		<a title="<?php echo $archivo; ?>" target="_blank" href="<?php echo BASEURLA; ?><?php echo $archivo; ?>" >
                    			<img src="imagenes/descargar.png" alt="Descargar" width="16" height="16" />
                		</a>	
                		<?php
            		}
            		?>
        	</div>
    	</div>
    	<?php
}
?>
</div>