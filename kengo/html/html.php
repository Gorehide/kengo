<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
	<?php include("html/head.php"); ?>
</head>
<body onLoad="ini(); unFocusA()" class="<?php echo $estilou; ?>">
	<div id="urll" style="display: none; width: 0px; height: 0px;" class="<?php echo BASEURL; ?>" idioma="es" iva="<?php echo $iva; ?>"></div>
    		<?php
			if (!isset($_SESSION['admin'])) include ("includes/login.php");
    		else
    		{
    			$patharch="cli/";
        		if (!isset($_SESSION['admin'])) header("Location: ".enlazar("login"));
        		//SI NO SE HA PASADO UN PRIMER ARGUMENTO SE LLAMA AL GESTOR GENERICO
        		if(!isset($_GET['arg1']) OR $_GET['arg1']=="html") header("Location: ".enlazar("gestor"));
        		//BUSCAMOS EL ARCHIVO QUE LE CORRESPONDE EN LA BBDD SEGUN EL PRIMER ARGUMENTO
        		//PRIMERO BUSCAMOS EN LA TABLA DE LOS MENUS NORMALES
        		$sqlzona = "SELECT txt, estatico, id, galeria
        		FROM zkng_menu
        		WHERE es = '".$_GET['arg1']."'";
        		$rezona = mysql_query($sqlzona);
        		//SI NO ENCONTRAMOS RESULTADOS BUSCAMOS EN LA TABLA DE MENUS DE ADMIN
        		if (mysql_num_rows($rezona)==0)
        		{
            			$sqlzona = "SELECT txt
            			FROM zkng_menu_admin
            			WHERE a_nombre = '".$_GET['arg1']."'
            			LIMIT 1";
            			$rezona = mysql_query($sqlzona);
            			$patharch="adm/";
            			//SI NO ENCONTRAMOS RESULTADOS BUSCAMOS EN LA TABLA DE MENUS DE FACTURACION
	        		if (mysql_num_rows($rezona)==0)
	        		{
	            			$sqlzona = "SELECT txt, id
	            			FROM zkng_menu_fac
	            			WHERE es = '".$_GET['arg1']."'
	            			LIMIT 1";
	            			$rezona = mysql_query($sqlzona);
	            			$patharch="fac/";
	        		}
        		}
        		$rowzona = mysql_fetch_array($rezona);
        		?>
        		<div id="ocmenu" title="Mostrar u ocultar el menú"><</div>
        		<div class="todo">
            			<div class="top"><?php include ("html/top.php"); ?></div>
            			<div class="centro">
                			<div class="menu"><?php include ("html/menus.php"); ?></div>
                			<div class="contenido">
                    				<div class="contenidocentro">
                        				<?php
                        				if (file_exists($patharch.$rowzona['txt'].".php"))
                        				{
                            					include($patharch.$rowzona['txt'].".php");
                            					//INCLUIMOS EL EDITOR DE SECCION ESTATICA SOLO SI ES UN MENU DE NO ADMIN
                            					if($patharch=="cli/")
                            					{
                            						if (($rowzona['estatico']=="1") AND ($_GET['arg2']=="html"))
	                            					{
	                                					?>
	                                					<a id="ocultar" href="#">Editar sección estática de la zona <b><?php echo $_GET['arg1']; ?></b></a>
	                                					<div id="capaoculta">
	                                    					<?php
	                                    					include ("html/estaticos.php");
	                                    					?>
	                                					</div>
	                                					<?php
	                            					}
	                            					//CREAMOS LA ZONA DE LA GALERIA
                                                    if (($rowzona['galeria']=="1") AND ($_GET['arg2']=="html"))
	                            					{
	                            						$rutag = 'galeriasg/'.$rowzona['id'].'/';
	                            						include("html/galerias.php");
	                            					}
                            					}
                        				}
                        				else if (file_exists("includes/".$_GET['arg1'].".php")) include ("includes/".$_GET['arg1'].".php");
                        				else include ("html/gestor.php");
                        				?>
                    				</div>
                    				<div class="contenidobottom"></div>
                			</div>
                			<div class="finflotar"></div>
            			</div>
            			<div class="pie"><?php include ("html/pie.php"); ?></div>
        		</div>
        		<?php
    		}
    		include("html/scripts_pie.php");
    		?>
	</body>
</html>
