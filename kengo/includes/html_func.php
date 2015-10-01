<?php
//BOTON PARA CREAR NUEVAS ENTRADAS EN LAS TABLAS																										
function boton_nuevo($avartabl)
{
	?>
	<div style="padding-top: 10px; text-align: center;">
        	<a class="boton_a" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nuev<?php echo $avartabl['sexo'].' '.$avartabl['titulo']; ?></a>
    	</div>
	<?php
	//Ej: boton_nuevo();
}
//BOTON PARA CANCELAR																																
function boton_cancelar()
{
	?><input type="submit" name="accion" value="Cancelar" /><?php
	//Ej: boton_cancelar();
}		
//BOTON PARA ENVIAR																																
function boton_enviar($nombre, $accion, $visible=1)
{
	?>
		<input type="submit" name="subit" value="<?php echo $nombre ?>" id="<?php echo $nombre ?>" title="<?php echo $nombre ?>" <?php if($visible==0) echo 'style="display: none;"'; ?> />
		<input type="hidden" name="accion" value="<?php echo $accion ?>"/>
	<?php
	//Ej: boton_enviar("Enviaré", "enviar", 1);
}
//CREACION DE LA TABLA DE GESTION																													
function tablages($cuantos, $res, $avartabl)
{
	?>
	<div class="infotabla pager">
		<?php echo $avartabl['titulo'].$avartabl['plural'].': '.$cuantos; ?>
    	</div>
	<table class="tablesorter">
    		<thead>
	            	<tr>
	            		<?php
	            		//COLUMNA DE IMAGEN																								
	            		if($avartabl['imagen']=="1") echo '<th width="5%" class="tcentrado {sorter: false}">Imagen</th>';
	            		//COLUMNAS DATOS																									
	            		for($i=0;$i<count($avartabl['titulos']);$i++)
      				echo '<th>'.$avartabl['titulos'][$i].'</th>';
	            		?>
	            		<?php
	            		//COLUMNAS OPCIONES																								
	            		for($i=0;$i<count($avartabl['titulos_op']);$i++)
      				echo '<th width="5%" class="tcentrado {sorter: false}">'.$avartabl['titulos_op'][$i].'</th>';
	            		?>
				<?php
	            		//COLUMNAS ACCIONES																								
	            		//EDITAR																											
	            		if ($avartabl['editable']==1) echo '<th width="5%" class="tcentrado {sorter: false}">Editar</th>';
	            		//BORRAR																											
	            		if ($avartabl['borrable']==1) echo '<th width="5%" class="tcentrado {sorter: false}">Borrar</th>';
	            		?>	
	            	</tr>
        	</thead>
        	<tbody>
            		<?php
            		while ($row = mysql_fetch_array($res))
            		{
                		?>
                		<tr id="col<?php echo $row['aid'] ?>">
                    			<?php
                    			//COLUMNA DE IMAGEN																								
	            			if($avartabl['imagen']=="1") echo '<td  class="tcentrado"><img src="'.BASEURLX.$avartabl['imagen_url'].$row[$avartabl['imagen_file']].'.png" /></td>';
                    			//DATOS																										
		            		for($i=0;$i<count($avartabl['cols']);$i++)
		            		{
	      					echo '<td>'.$row[$avartabl['cols'][$i]].'</td>';
	      				}
		            		//OPCIONES																									
	            			for($i=0;$i<count($avartabl['cols_op']);$i++)
	            			{
	            				?>
	            				<td align="center">
        						<?php
        						if ($row[$avartabl['cols_op'][$i]]=="1") echo '<a href="#" title="'.$avartabl['titulos_op'][$i].'" class="'.$avartabl['name'].'::'.$row['aid'].'::'.$avartabl['cols_op'][$i].'"><img src="'.BASEURL.'imagenes/ok.png" alt="ON" width="16" height="16" class="clicki" alt="ON" / ></a>';
        						else echo '<a href="#" title="'.$avartabl['titulos_op'][$i].'"  class="'.$avartabl['name'].'::'.$row['aid'].'::'.$avartabl['cols_op'][$i].'"><img src="'.BASEURL.'imagenes/bannear.png" alt="OFF" width="16" height="16"  class="clicki" alt="OFF" /></a>';
        						?>
        					</td>
        					<?php
	            			}      						
	            			//ACCIONES																									
	            			//EDITAR																										
	            			if ($avartabl['editable']==1) echo '<td class="tcentrado"><a href="'.enlazar($_GET['arg1'].'/editar/'.$row['aid']).'"><img src="'.BASEURL.'imagenes/editar.png" alt="editar" title="Editar" width="16" height="16" /></a></td>';
	            			//BORRAR																											
	            			if ($avartabl['borrable']==1) echo '<td class="tcentrado"><a title="Borrar" href="#" class="'.$avartabl['name'].'::'.$row['aid'].'" ><img src="'.BASEURL.'imagenes/borrar.png" alt="borrar" width="16" height="16" class="dele" /></a></td>';
	            			?>	            		                    			         			
                		</tr>
                		<?php
            		}
            		?>
        	</tbody>
    	</table>
    	<?php
    	boton_nuevo($avartabl);
    	include ("html/paginador.php");
}
?>