<?php
//SETEAMOS LOS ERRORES A VARIO																
$error = "";
//SI SE HA ENVIADO UNA ACCION Y LA ACCION ES OK														
if (isset($_POST['accion']) AND $_POST['accion']=="ok")
{
	
	$sql = "SELECT id, rol
    	FROM zkng_admins
    	WHERE nick='".$_POST['user']."'
    	AND pass='".md5($_POST['pass'])."'
    	AND activo='1'
    	LIMIT 1";
    	$result = mysql_query($sql);
    	$row = mysql_fetch_array($result);
    	if (mysql_num_rows($result)>0)
    	{
        	$_SESSION['admin'] = $_POST['user'];
        	$_SESSION['rol'] = $row['rol'];
        	$_SESSION['nivel'] = $row['id'];
        	header("Location: ".enlazar("gestor"));
    	}
    	else $error = "Los datos introducidos no son correctos.";
    	//echo $_POST['user'].' - '.$_POST['pass'].'<br /><br />';
}
//SI SE HA ENVIADO UNA ACCION Y LA ACCION ES REC													
else if (isset($_POST['accion']) AND $_POST['accion']=="rec")
{
    	$sql = "SELECT id
    	FROM zkng_admins
    	WHERE mail='".$_POST['mail']."'
    	LIMIT 1";
    	$result = mysql_query($sql);
    	if (mysql_num_rows($result)>0)
    	{
        	$row = mysql_fetch_array($result);
	        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	        $cad = "";
	        for($i=0;$i<9;$i++)
	        {
	            $cad .= substr($str,rand(0,62),1);
	        }
	        $sql = "UPDATE zkng_admins SET pass='".md5($cad)."' WHERE id='".$row['admin_id']."'";
	        mysql_query($sql);
	        $sendTo = $_POST['mail'];
	      	$subject = $cliente. ": Nueva contraseña";
	      	$headers = "From: ".$cliente;
	      	$headers .= "<".$k_cliente_mail.">\r\n";
	      	$message = "Esta es su nueva clave: ".$cad."";
	      	mail($sendTo, $subject, $message, $headers);
    	}
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 100%;" align="center">
	<tr><td colspan="3"></td></tr>
    	<tr>
        	<td></td>
        	<td>
        		<div class="gestiform"> 
	        		<form action="<?php echo enlazar("login"); ?>" method="post">
        	                	<table align="center" border="0" cellpadding="0" cellspacing="0" width="85%">
        	                		<tr>
        	                			<td width="50%" ><img src="imagenes/logo_kengo.png" height="67px;" /></td>
        	                			<td colspan="2" align="center" ><img src="imagenes/logo.png" height="50px;" /></td>
        	                		</tr>
        	                		<tr><td>&nbsp;</td></tr>
           					<?php
            					if ((isset($_GET['arg2'])) AND ($_GET['arg2']=="olvido"))
            					{
				                					?>                                   
				                            				<tr>
				                                				<td colspan="2"><input type="text" name="mail" value="Introduzca su email" onclick="if(this.value=='Introduzca su email')this.value='';" /></td>
				                            				</tr>
				                            				<tr>
				                                				<td style="padding-top: 30px; color: #333333"><?php echo $error; ?></td>
				                                				<td style="padding-top: 30px; text-align: right"><input class="bg_lila" type="submit" name="submit" value="solicitar"/></td>
				                            				</tr>
				                            				<tr>
				                                				<td colspan="2" style="padding-top: 30px;"><a class="boton_a bg_lila" href="<?php echo enlazar("login"); ?>">Volver</a></td>
				                            				</tr>
				                        		</table>
				                        		<input type="hidden" name="accion" value="rec" />
				                    		</form>
				                	</div>
				                	<?php
            					}
            					else
            					{
	                					?>                		
	                            				<tr>
	                                				<td width="50%"><input type="text" name="user" value="Usuario" onclick="if(this.value=='Usuario')this.value='';" /></td>
	                                				<td style="color: #FFFFFF; font-size: 20px;">|</td>
	                                				<td width="50%"><input type="password" name="pass" /></td>
	                            				</tr>
	                            				<tr>
	                                				<td colspan="2" style="padding: 30px 0px 0px; color: #CC0000;"><?php echo $error; ?></td>
	                                				<td style="padding-top: 30px; text-align: right"><input class="bg_lila" type="submit" name="submit" value="entrar"/></td>
	                            				</tr>
	                            				<tr>
	                                				<td colspan="3" style="padding-top: 30px;"><a class="boton_a bg_lila" href="<?php echo enlazar("login/olvido"); ?>">¿Olvidastes tu contraseña?</a></td>
	                            				</tr>
	                        			</table>
	                        			<input type="hidden" name="accion" value="ok" />                   
	                				<?php
            					}
            					?>
             			</form>
         		</div>
        	</td>
        	<td></td>
	</tr>
    	<tr><td colspan="3"></td></tr>
</table>