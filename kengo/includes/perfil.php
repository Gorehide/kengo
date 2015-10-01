<script src="jscriptes/perfil.js" type="text/javascript"></script>
<?php
if (isset($_POST['accion']) AND $_POST['accion']=="modificar")
{
	$sql2 = "Select pass
	FROM zkng_admins
	WHERE id = '".$_POST['id']."'";
        $result2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($result2);
        if (md5($_POST['passold'])==$row2['pass'])
        {
        	$sqlperfil = "UPDATE zkng_admins
            	SET mail='".$_POST['mail']."', rol='".$_POST['rol']."'";
            	if ($_POST["pass"]!="")
            	{
                	$sqlperfil .= ", pass='".md5($_POST['pass'])."'";
            	}
            	$sqlperfil .= " WHERE id = '".$_POST['id']."'";
            	mysql_query($sqlperfil);
            	$aviso = "El perfil se ha modificado correctamente";
        }
        else $aviso = "La contrase&ntilde;a actual no es la correcta";
        ?>
        	<div class="aviso1"><?php echo $aviso; ?></div>
        <?php
}
$sqlperfil = "SELECT *
FROM zkng_admins
WHERE nick = '".$_SESSION['admin']."'
LIMIT 1";
$resultperfil = mysql_query($sqlperfil);
$rowperfil =mysql_fetch_array($resultperfil)
?>
<form id="perfil" action="<?php echo enlazar($_GET['arg1']); ?>" method="post">
	<table class="formulario" align="center" cellpadding="0" cellspacing="2" border="0" width="50%">
        	<tr>
                	<th>NICK</th>
                	<td><?php echo $rowperfil['nick']; ?></td>
            	</tr>
            	<tr>
                	<th>CONTRASE&Ntilde;A ACTUAL</th>
                	<td><input title="Contrase&ntilde;a antigua" class="obligatorio" type="password" name="passold" value="" style="width: 98%;"  /></td>
            	</tr>
            	<tr>
                	<th>NUEVA CONTRASE&Ntilde;A</th>
                	<td><input id="pass" title="contrase&ntilde;a" type="password" name="pass" style="width: 98%;"  /></td>
            	</tr>
            	<tr>
                	<th>NUEVA CONTRASE&Ntilde;A (rep)</th>
	                <td><input id="pass2" title="contrase&ntilde;a rep" type="password" name="pass2" style="width: 98%;"  /></td>
        	</tr>
            	<tr>
                	<th>MAIL</th>
                	<td><input id="mail" title="email" class="obligatorio" type="text" name="mail" value="<?php echo $rowperfil['mail']; ?>" style="width: 98%;" ></td>
            	</tr>
            	<?php
            	if ($_SESSION['rol']=="1")
            	{
                	?>
                	<tr>
                    		<th>ROL</th>
                    		<td>
                        		<select name="rol" style="width: 100%;">
                            			<?php
                            			$sqlrol = "SELECT id, nombre
                            			FROM zkng_roles
                            			ORDER BY nombre";
                            			$resultrol = mysql_query($sqlrol);
                            			while ($rowrol=mysql_fetch_array($resultrol))
                            			{
                                			if ($rowperfil['rol']==$rowrol['id']) echo "<option selected=\"selected\" value=\"".$rowrol['id']."\">".$rowrol['nombre']."</option>";
                                			else echo "<option value=\"".$rowrol['id']."\">".$rowrol['nombre']."</option>";
                            			}
                            			?>
                        		</select>
                    		</td>
                	</tr>
                	<?php
            	}
            	else echo "<input type=\"hidden\" name=\"rol\" value=\"".$rowperfil['admin_rol']."\" />";
            	?>
            	<tr >
                	<td class="tdlimpio" colspan="2" align="center">
                    		<input class="bg_rojo" type="submit" name="submit" value="Guardar" id="guardar" />
                    		<input type="hidden" name="accion" value="modificar" />
				<input type="hidden" name="id" value="<?php echo $rowperfil['id']; ?>" />
                	</td>
            	</tr>
        </table>        
</form>