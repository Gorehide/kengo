<?php
/*FUNCION QUE DIBUJA EL MENU*/
$contador=1;
function dameMenusAdmin($id_padre=0, $nivel)
{
    $query="SELECT a_nombre, a_id, txt
    FROM zkng_menu_admin
    WHERE a_padre='".$id_padre."'
    AND a_nivel >= '".$nivel."'
    AND activo = '1'
    ORDER BY a_pos";
    $result=mysql_query($query);
    $aRet=array();
    while ($row=mysql_fetch_array($result,MYSQL_ASSOC))
    {
        $ret=array(
            "id_menu"=>$row['a_id'],
            "nombre"=>$row['a_nombre'],
            "icono"=>$row['txt'],
            "menus"=>dameMenusAdmin($row['a_id'], $nivel)
        );
        $aRet[]=$ret;
    }
    return $aRet;
}
/**/
function dameMenusFac($id_padre=0)
{
    $query="SELECT es, id, txt
    FROM zkng_menu_fac
    WHERE padre='".$id_padre."'
    ORDER BY pos";
    $result=mysql_query($query);
    $aRet=array();
    while ($row=mysql_fetch_array($result,MYSQL_ASSOC))
    {
        $ret=array(
            "id_menu"=>$row['id'],
            "nombre"=>$row['es'],
            "icono"=>$row['txt'],
            "menus"=>dameMenusFac($row['id'])
        );
        $aRet[]=$ret;
    }
    return $aRet;
}
/**/
function dameMenusWeb($id_padre=0)
{
    $query="SELECT es, me.id, txt
    FROM zkng_menu AS me
    INNER JOIN zkng_rolmenu AS ro ON rolmenu_menu = me.id
    WHERE me.padre='".$id_padre."'
    AND me.admin = '1'
    AND rolmenu_rol='".$_SESSION['rol']."'
    ORDER BY me.pos";
    $result=mysql_query($query);
    $aRet=array();
    while ($row=mysql_fetch_array($result,MYSQL_ASSOC))
    {
        $ret=array(
            "id_menu"=>$row['id'],
            "nombre"=>$row['es'],
            "icono"=>$row['txt'],
            "menus"=>dameMenusWebHijo($row['id'])
        );
        $aRet[]=$ret;
    }
    return $aRet;
}
/**/
function dameMenusWebHijo($id_padre=0)
{
    $query="SELECT es, id, txt
    FROM zkng_menu
    WHERE padre='".$id_padre."'
    AND admin = '1'
    ORDER BY pos";
    $result=mysql_query($query);
    $aRet=array();
    while ($row=mysql_fetch_array($result,MYSQL_ASSOC))
    {
        $ret=array(
            "id_menu"=>$row['id'],
            "nombre"=>$row['es'],
            "icono"=>$row['txt'],
            "menus"=>dameMenusWebHijo($row['id'])
        );
        $aRet[]=$ret;
    }
    return $aRet;
}
/**/
function dibujaMenus($menu,$nivel)
{
    global $contador;
    if (sizeof($menu)==0) { return; }
    echo "\n";
    $tab = "";
    for ($i=0;$i<$nivel;$i++) $tab .=  "\t";
    echo $tab;
    echo "<div ";
    if ($nivel>0) echo " class=\"oculto\"" ;
    echo ">\n";
    foreach($menu as $m)
    {
        //BOTONES SELECCIONADOS
        if ($_GET['arg1']==$m['nombre'])
        {
            //BOTON SELECCIONADO
            if ($nivel>0)
            {
                ?>
                <div class="menubotonsel mb<?php echo $nivel+1;?>" style="background-image: url(imagenes/iconos/<?php echo $m['icono']; ?>.png);">
                    <div style="width: 225px; float: left;">
                        <a href="<?php echo enlazar($m['nombre']); ?>">
                            <?php echo ucfirst($m['nombre']); ?>
                        </a>
                    </div>
                    <?php if (!empty($m['menus'])) echo "<div class=\"sele\"\"><img src=\"imagenes/plus.png\" width=\"9\" height=\"13\" /></div>"; ?>
                    <div class="finflotar"></div>
                </div>
                <?php
            }
            else
            {
                /*BOTONES PADRE*/
                ?>
                <div class="menubotonsel" style="background-image: url(imagenes/iconos/<?php echo $m['icono']; ?>.png);">
                    <div style="width: 235px; float: left;">
                        <a href="<?php echo enlazar($m['nombre']); ?>">
                            <?php echo ucfirst($m['nombre']); ?>
                        </a>
                    </div>
                    <?php if (!empty($m['menus'])) echo "<div class=\"sele\"\"><img src=\"imagenes/plus.png\" width=\"9\" height=\"13\" /></div>"; ?>
                    <div class="finflotar"></div>
                </div>
                <?php
            }
        }
        else
        {
            /*BOTONES NO SELECCIONADOS*/
            if ($nivel>0)
            {
                ?>
                <div class="menuboton mb<?php echo $nivel+1;?>" style="background-image: url(imagenes/iconos/<?php echo $m['icono']; ?>.png);">
                    <div style="width: 225px; float: left;">
                        <a href="<?php echo enlazar($m['nombre']); ?>">
                            <?php echo ucfirst($m['nombre']); ?>
                        </a>
                    </div>
                    <?php if (!empty($m['menus'])) echo "<div class=\"sele\"><img src=\"imagenes/plus.png\" width=\"9\" height=\"13\" /></div>"; ?>
                    <div class="finflotar"></div>
                </div>
                <?php
            }
            else
            {
                /*BOTONES PADRE*/
                ?>
                <div class="menuboton" style="background-image: url(imagenes/iconos/<?php echo $m['icono']; ?>.png);">
                    <div style="width: 235px; float: left;">
                        <a href="<?php echo enlazar($m['nombre']); ?>">
                            <?php echo ucfirst($m['nombre']); ?>
                        </a>
                    </div>
                    <?php if (!empty($m['menus'])) echo "<div class=\"sele\"><img src=\"imagenes/plus.png\" width=\"9\" height=\"13\" /></div>"; ?>
                    <div class="finflotar"></div>
                </div>
                <?php
            }
        }
        dibujaMenus($m['menus'],($nivel+1));
    }
    echo"</div>\n";
}
/*FIN FUNCION*/
?>
<!-- DIBUJAR LOS MENUS																	 -->
<!--  																			 -->
<div style="text-align: center; padding: 10px 0px; border-bottom: 1px solid #222222;">
    <a href="<?php echo BASEURLX; ?>" target="_blank"><img width="200px" src="<?php echo BASEURL; ?>imagenes/logo.png" alt="Logotipo" /></a>
</div>
<?php
/*SI ES DE ROL ADMINISTRADOR*/
if ($_SESSION['rol']==1)
{
    ?>
    <div class="menubotontit" style="background-image: url(imagenes/iconos/menuadmin.png);">MENÚ ADMIN</div>
    <?php
    if ($_SESSION['nivel']==1) $menus = dameMenusAdmin(0,0); //SI SOY EL ADMIN JEFE
    else $menus = dameMenusAdmin(0,1); //SI TIENE ROL DE ADMINISTRADOR
    dibujaMenus($menus,0);
    ?>
    <div class="menubotontit" style="background-image: url(imagenes/iconos/menuweb.png);">FACTURACIÓN</div>
    <div class="menuweb">
        <?php
        $menus = dameMenusFac();
        dibujaMenus($menus,0);
        ?>
    </div>
    <?php
}
?>
<div class="menubottom"></div>
