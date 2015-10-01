<?php
//CONFIGURACION
$tablaa = "zkng_roles";
?>
<script src="<?php echo BASEURL; ?>jscriptes/roles.js" type="text/javascript"></script>
<?php
//NUEVO
if ($_GET['arg2']=="nuevo")
{
    if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
    {
        $sql = "SELECT id
        FROM zkng_roles
        WHERE nombre = '".$_POST['nombre']."'";
        $result = mysql_query($sql);
        if (mysql_num_rows($result)>0)
        echo "Ya existe un Rol con ese nombre: ".$_POST['nombre']."<br />";
        else
        {
            //METEMOS EL NUEVO ROL
            $sql = "INSERT INTO zkng_roles (nombre) VALUES ('".$_POST['nombre']."')";
            mysql_query($sql);
            $id = mysql_insert_id();
            //VEMOS CUANTOS MENUS EXISTEN
            $sql = "SELECT id
            FROM zkng_menu_fac
            WHERE padre='0' ORDER BY id";
            $result = mysql_query($sql);
            //GUARDAMOS SUS NOMBRE
            while ($row = mysql_fetch_array($result))
            {
                if (isset($_POST[$row['id']]) && $_POST[$row['id']]=="on")
                {
                    $sql = "INSERT INTO zkng_rolmenu (rolmenu_rol, rolmenu_menu) VALUES ('".$id."', '".$row['id']."')";
                    mysql_query($sql);
                }
            }
            header("Location: ".enlazar($_GET['arg1']));
        }
    }
    else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    {
        header("Location: ".enlazar($_GET['arg1']));
    }
    ?>
    <form id="rolex" action="<?php echo enlazar($_GET['arg1']."/".$_GET['arg2']); ?>" method="POST">
        <table class="formulario" width="60%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
            <tr>
                <th class="thtit" colspan="2">NUEVO ROL</th>
            </tr>
            <tr>
                <th style="width: 40%; text-align: left; text-indent: 10px;">Nombre</th>
                <td style="width: 60%;"><input class="obligatorio" title="Nombre" style="width: 98%" type="text" name="nombre" /></td>
            </tr>
            <tr>
                <th colspan="2" class="tdlimpio">MENUS ACCESIBLES</th>
            </tr>
            <?php
            $sql = "SELECT es, id
            FROM zkng_menu_fac
            WHERE padre='0'
            AND admin = '1'
            ORDER BY pos";
            $result = mysql_query($sql);
            while ($row=mysql_fetch_array($result))
            {
                ?>
                <tr>
                    <th style="text-align: left;"><?php echo ucfirst(utf8_encode($row['es'])); ?></th>
                    <td><input type="checkbox" name="<?php echo $row['id']; ?>" /></td>
                </tr>
                <?php
            }
            ?>
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
        //BORRAMOS LOS QUE ESTAN GUARDADOS PARA ESE ROL
        $sql = "DELETE FROM zkng_rolmenu WHERE rolmenu_rol = '".$_POST['id']."'";
        mysql_query($sql);
        //VEMOS CUANTOS MENUS EXISTEN
        $sql = "SELECT id FROM zkng_menu WHERE padre='0' ORDER BY id";
        $result = mysql_query($sql);
        //GUARDAMOS SUS NOMBRE
        while ($row = mysql_fetch_array($result))
        {
            if (isset($_POST[$row['id']]) AND $_POST[$row['id']]=="on")
            {
                $sql = "INSERT INTO zkng_rolmenu (rolmenu_rol, rolmenu_menu) VALUES ('".$_POST['id']."', '".$row['id']."')";
                mysql_query($sql);
            }
        }
        header("Location: ".enlazar($_GET['arg1']));
    }
    else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    {
        header("Location: ".enlazar($_GET['arg1']));
    }
    /*LISTAR LOS DATOS DEL ROL*/
    $sql = "SELECT id, nombre
    FROM zkng_roles
    WHERE id='".$_GET['arg3']."'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    ?>
    <form id="rolex" action="" method="POST">
        <table  class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
            <tr>
                <th class="thtit" colspan="2">EDITAR ROL</th>
            </tr>
            <tr>
                <th style="width: 50%; text-align: left; text-indent: 10px;">Nombre</th>
                <td style="width: 50%;"><input class="obligatorio" title="Nombre" disabled="disabled" value="<?php echo $row['nombre']; ?>" style="width: 98%" type="text" name="nombre" /></td>
            </tr>
            <tr>
                <th colspan="2" class="tdlimpio">MENUS ACCESIBLES</th>
            </tr>
            <?php
            $sql2 = "SELECT rolmenu_menu FROM zkng_rolmenu WHERE rolmenu_rol='".$_GET['arg3']."'";
            //echo $sql.'<br />';
            $result2 = mysql_query($sql2);
            $arra = array();
            while ($row2 = mysql_fetch_array($result2)) $arra[$row2['rolmenu_menu']]="1";
            /*echo '<pre>';
            print_r($arra);
            echo '</pre>';*/
            $sql2= "SELECT DISTINCT es, id
            FROM zkng_menu_fac
            WHERE padre='0'
            AND admin='1'
            ORDER BY pos";
            $result2 = mysql_query($sql2);
            while ($row2=mysql_fetch_array($result2))
            {
                ?>
                <tr>
                    <th style="text-align: left;"><?php echo ucfirst($row2['es']); ?></th>
                    <td><input type="checkbox" name="<?php echo $row2['id'];?>" <?php if(isset($arra[$row2['id']]) AND $arra[$row2['id']]=="1") echo 'checked'; ?> /></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td class="tdlimpio" colspan="2" align="center">
                    <input class="bg_rojo" type="submit" name="accion" value="Guardar" id="guardar" title="guardar" />
                    <input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                </td>
            </tr>
        </table>
    </form>
    <?php
}
//GENERAL
else
{
    if ($_GET['arg2']=="error1")
    {
        ?>
        <div style="width: 70%; padding: 10px; background-color: #CC0000; border: 1px solid #FFFFFF; -moz-border-radius: 10px; color: #FFFFFF; text-shadow: none; margin: auto; text-align: center">
            El rol <b>Administrador</b> no se puede eliminar
        </div>
        <?php
    }
    $sql = "SELECT nombre, id
    FROM zkng_roles
    ORDER BY nombre";
    $result = mysql_query($sql);
    $cuantos = mysql_num_rows($result);
    ?>
    <div class="infotabla pager">
        Roles: <?php echo $cuantos; ?>
    </div>
    <table class="tablesorter" style="width: 50%;">
        <thead>
            <tr>
                <th>ROL</th>
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
                    <td><?php echo $row['nombre']; ?></td>
                    <td class="tcentrado"><a href="<?php echo enlazar($_GET['arg1']."/editar/".$row['id']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td>
                    <td class="tcentrado">
                        <?php
                        if($row['id']>1)
                        {
                            ?><a title="Borrar" href="" class="<?php echo $tablaa.'::'.$row['id']; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="borradorol" /></a><?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div style="padding-top: 10px; text-align: center;">
        <a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nuevo rol</a>
    </div>
    <?php
    include ("html/paginador.php");
}
?>
