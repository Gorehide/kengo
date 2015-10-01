<?php
//CONFIGURACION																	
$tablaa = "zkng_admins";
?>
<script src="<?php echo BASEURL; ?>jscriptes/perfil.js" type="text/javascript"></script>
<script src="<?php echo BASEURL; ?>jscriptes/username.js" type="text/javascript"></script>
<?php
// NUEVO																																				
if ($_GET['arg2']=="nuevo")
{
    	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
    	{
        	$sql = "SELECT id, nick, mail
        	FROM zkng_admins
        	WHERE nick = '".$_POST['nombre']."'
		OR mail = '".$_POST['mail']."'        	
        	";
        	$res = mysql_query($sql);
        	if (mysql_num_rows($res)>0)
        	{
        		?><div class="aviso1"><?php
        		$row = mysql_fetch_array($res);
        		if($row['nick']==$_POST['nombre']) echo "Ya existe un administrador con ese Nick: ".$_POST['nombre']."<br />";
        		else if($row['mail']==$_POST['mail']) echo "Ya existe un administrador con ese Mail: ".$_POST['mail']."<br />";
        		?></div><?php
        	}
        	else
        	{
            		$sql = "INSERT INTO zkng_admins (nick, pass, mail, rol)
            		VALUES ('".$_POST['nombre']."', '".md5($_POST['pass'])."','".$_POST['mail']."','".$_POST['rol']."')";
            		mysql_query($sql);
            		header("Location: ".enlazar($_GET['arg1']));
        	}
    	}
    	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    	{
        	header("Location: ".enlazar($_GET['arg1']));
    	}
    	?>
    	<form id="perfil" action="<?php echo enlazar($_GET['arg1']."/".$_GET['arg2']); ?>" method="POST">
        	<table class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
            		<tr>
                		<th class="thtit" colspan="2">NUEVO ADMINISTRADOR</th>
            		</tr>
            		<tr>
                		<th style="width: 30%; text-align: left; text-indent: 10px;">Nick</th>
                		<td style="width: 70%;">
                    			<input class="obligatorio" id="username" title="Nick" style="width: 98%" type="text" name="nombre" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" />
                    			<div id="msgbox" style="text-align: center;"></div>
                		</td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">contraseña</th>
                		<td><input id="pass" class="obligatorio" title="Contraseña" style="width: 98%" type="password" name="pass" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">contraseña (rep)</th>
                		<td><input id="pass2" class="obligatorio" title="Contraseña (rep)" style="width: 98%" type="password" name="pass2" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">e-mail</th>
                		<td><input id="mail" class="obligatorio" title="e-mail" style="width: 98%" type="text" name="mail" value="<?php if(isset($_POST['mail'])) echo $_POST['mail']; ?>" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">rol</th>
                		<td>
                    			<select class="obligatorio" name="rol" title="Rol" style="width: 98%;">
                        			<?php
                        			$sql = "SELECT id, nombre
                        			FROM zkng_roles
                        			ORDER BY nombre";
                        			$result = mysql_query($sql);
                        			while ($row=mysql_fetch_array($result))
                        			{
                        				?>
                            				<option value="<?php echo $row['id']; ?>" <?php if(isset($_POST['rol']) AND $row['id']==$_POST['rol']) echo 'selected'; ?>><?php echo $row['nombre']; ?></option>
                            				<?php
				            	}
                        			?>
                    			</select>
                		</td>
            		</tr>
            		<tr>
                		<td colspan="2" align="center" class="tdlimpio">
                    			<input class="bg_rojo" type="submit" name="accion" value="Guardar" id="guardar" title="guardar" style="display: none;" />
                    			<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
                		</td>
            		</tr>
        	</table>
    	</form>
    	<?php
}
// EDITAR																																					
else if ($_GET['arg2']=="editar")
{
    	if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
    	{
        	$sql = "SELECT pass
        	FROM zkng_admins
        	WHERE id='".$_GET['arg3']."'";
        	$result = mysql_query($sql);
        	$row = mysql_fetch_array($result);
        	if ($row['pass']== md5($_POST['passold']))
        	{
            		$sql = "UPDATE zkng_admins SET
            		mail='".$_POST['mail']."', rol='".$_POST['rol']."'";
            		if ($_POST['pass']!="") $sql .= ", pass='".md5($_POST['pass'])."'";
            		$sql .= " WHERE id = '".$_GET['arg3']."'";
            		mysql_query($sql);
            		header("Location: ".enlazar($_GET['arg1']));
        	}
        	else
        	{
             		header("Location: ".enlazar($_GET['arg1']."/".$_GET['arg2']."/".$_GET['arg3']."/error1"));
        	}
    	}
    	else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    	{
        	header("Location: ".enlazar($_GET['arg1']));
    	}
    	$sql = "SELECT nick, mail, rol
    	FROM zkng_admins
    	WHERE id='".$_GET['arg3']."'";
    	$result = mysql_query($sql);
    	$row = mysql_fetch_array($result);
    	if ($_GET['arg4']=="error1") echo '<div class="cajaerror">La contraseña introducida no es correcta</div>';
    	?>
    	<form id="perfil" action="" method="post">
        	<table class="formulario" width="60%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
            		<tr>
                		<th class="thtit" colspan="2">EDITAR ADMINISTRADOR</th>
            		</tr>
            		<tr>
                		<th style="width: 40%; text-align: left; text-indent: 10px;">Nick</th>
                		<td style="width: 60%;"><input class="obligatorio" title="Nick" style="width: 98%" type="text" name="nombre" disabled="disabled" value="<?php echo $row['nick']; ?>" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">contraseña antigua</th>
                		<td><input class="obligatorio" title="Contraseña antigua" style="width: 98%" type="password" name="passold" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">contraseña nueva</th>
                		<td><input id="pass" title="Contraseña" style="width: 98%" type="password" name="pass" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">contraseña nueva (rep)</th>
                		<td><input id="pass2" title="Contraseña (rep)" style="width: 98%" type="password" name="pass2" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">e-mail</th>
                		<td><input id="mail" class="obligatorio" title="e-mail" style="width: 98%" type="text" name="mail" value="<?php echo $row['mail']; ?>" /></td>
            		</tr>
            		<tr>
                		<th style="text-align: left; text-indent: 10px;">rol</th>
                		<td>
                    			<select name="rol" title="Rol" style="width: 98%;">
                        			<?php
                        			$sql2 = "SELECT id, nombre
                        			FROM zkng_roles
                        			ORDER BY nombre";
                        			$result2 = mysql_query($sql2);
                        			while ($row2=mysql_fetch_array($result2))
                        			{
                            				if ($row['rol']==$row2['id']) echo "<option selected=\"selected\" value=\"".$row2['id']."\">".$row2['nombre']."</option>";
                        				else echo "<option value=\"".$row2['id']."\">".$row2['nombre']."</option>";
                        			}
                        			?>
                    			</select>
                		</td>
            		</tr>
            		<tr>
                		<td colspan="2" align="center" class="tdlimpio">
                    			<input class="bg_rojo" type="submit" name="accion" value="Guardar" id="guardar" title="guardar" />
                    			<input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
                		</td>
            		</tr>
        	</table>
    	</form>
    	<?php
}
// GENERAL																																			
else
{
	$sql = "SELECT ad.id, ad.nick, ad.mail, ad.activo, ro.nombre
	FROM zkng_admins AS ad
    	INNER JOIN zkng_roles AS ro ON ro.id = ad.rol
    	WHERE ad.id>1 ORDER BY ad.nick";
    	$result = mysql_query($sql);
    	$cuantos=mysql_num_rows($result);
    	?>
    	<div class="infotabla pager">
        	Administradores: <?php echo $cuantos; ?>
    	</div>
    	<table class="tablesorter">
        	<thead>
            		<tr>
                		<th>NICK</th>
                		<th>MAIL</th>
                		<th>ROL</th>
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
                    			<td><?php echo $row['nick']; ?></td>
                    			<td><?php echo $row['mail']; ?></td>
                    			<td><?php echo $row['nombre']; ?></td>
                    			<td class="tcentrado">
                        			<?php
                        			if ($row['activo']=="1") echo '<a href="" class="'.$tablaa.'::'.$row['id'].'::activo"><img src="imagenes/ok.png" alt="ON" width="16" height="16" class="clicki" /></a>';
	                        		else echo '<a href="" class="'.$tablaa.'::'.$row['id'].'::activo"><img src="imagenes/bannear.png" alt="OFF" width="16" height="16"  class="clicki" /></a>';
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
        	<a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nuevo administrador</a>
    	</div>
	<?php
    	include ("html/paginador.php");
}
?>