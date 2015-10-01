<?php
$tablaa = "kng_presupuestos";
//DATOS VARIOS
$esteanio = date("Y");
//NUEVO
if ($_GET['arg2']=="nuevo")
{
    if (isset($_POST['accion']) and $_POST['accion']=="Guardar")
    {
        $sql = "SELECT numero
        FROM ".$tablaa."
        ORDER BY numero DESC";
        $res = mysql_query($sql);
        $max = mysql_fetch_array($res);
        $numero = $max['numero']+1;
        $sql = "INSERT INTO ".$tablaa."
        (numero, cliente, fecha, titulo, notas)
        VALUES ('".$numero."', '".$_POST['cliente']."', '".date("Y-m-d")."', '".$_POST['titulo']."', '".$_POST['notas']."')";
        mysql_query($sql);
        //echo $sql.'<br /><br />';
        $id = mysql_insert_id();
        header("Location: ".enlazar($_GET['arg1'].'/editar/'.$id));
    }
    else if (isset($_POST['accion']) and $_POST['accion']=="Cancelar")
    {
        header("Location: ".enlazar($_GET['arg1']));
    }
    ?>
    <form id="perfil" action="" method="POST">
        <table class="formulario" width="50%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
            <tr>
                <th class="thtit" colspan="2">NUEVO PRESUPUESTO</th>
            </tr>
            <tr>
                <th>CLIENTE</th>
                <td style="width: 70%;">
                    <select name="cliente" style="width: 100%;">
                        <?php
                        $sqlcl = "SELECT id, nombre FROM kng_clientes WHERE borrado = '0' ORDER BY nombre ASC";
                        $rescl = mysql_query($sqlcl);
                        while ($rowcl = mysql_fetch_array($rescl))
                        {
                            echo '<option style="text-transform: uppercase;" value="'.$rowcl['id'].'">'.$rowcl['nombre'].'</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>TÍTULO</th>
                <td><input type="text" name="titulo"  style="width: 98%;"></td>
            </tr>
            <tr>
                <th>NOTAS</th>
                <td><textarea name="notas"  style="width: 100%;"></textarea></td>
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
else if ($_GET['arg2']=="editar") {
    if (isset($_POST['accion']) AND $_POST['accion']=="Guardar")
    {
        $sql = "UPDATE ".$tablaa." SET
        cliente='".$_POST['cliente']."',
        titulo='".$_POST['titulo']."',
        notas='".$_POST['notas']."'";
        $sql .= " WHERE id = '".$_GET['arg3']."'";
        //echo $sql;
        mysql_query($sql);
        //header("Location: ".enlazar($_GET['arg1']));
        header("Location: ".enlazar($_GET['arg1'].'/editar/'.$_GET['arg3']));
    }
    else if (isset($_POST['accion']) AND $_POST['accion']=="Cancelar")
    {
        header("Location: ".enlazar($_GET['arg1']));
    }
    $sql = "SELECT id, cliente, titulo, notas FROM ".$tablaa." WHERE id='".$_GET['arg3']."'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    ?>
    <form action="" method="post">
        <table class="formulario" width="95%" border="0" cellpadding="0" cellspacing="2" align="center" style="margin-top: 10px;">
            <tr>
                <th class="thtit" colspan="2">EDITAR PRESUPUESTO</th>
            </tr>
            <tr>
                <th>CLIENTE</th>
                <td>
                    <select name="cliente" style="width: 98%;">
                        <?php $sqlcl="SELECT id, nombre FROM kng_clientes WHERE borrado='0' ORDER BY nombre ASC" ;
                        $rescl=mysql_query($sqlcl);
                        while ($rowcl=mysql_fetch_array($rescl)) {
                            $as="";
                            if ($rowcl['id']==$row['cliente']) $as='selected="selected"';
                            echo '<option style="text-transform: uppercase;" '.$as. ' value="'.$rowcl['id']. '">'.$rowcl['nombre']. '</option>';
                        } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>TÍTULO</th>
                <td>
                    <input type="text" name="titulo" style="width: 98%;" value="<?php echo $row['titulo']; ?>">
                </td>
            </tr>
            <tr>
                <th>NOTAS</th>
                <td>
                    <textarea name="notas" style="width: 100%;" class="notiny tinybasic">
                        <?php echo $row[ 'notas']; ?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" class="tdlimpio">
                    <input class="bg_rojo" type="submit" name="accion" value="Guardar" title="guardar" />
                    <input class="bg_rojo" type="submit" name="accion" value="Cancelar" />
                    <a class="boton_a bg_rojo" target="_blank" href="<?php echo BASEURL."fac/pres_pdf_m.php?id=".$_GET['arg3'].""; ?>" target="_blank">Generar Presupuesto</a>
                </td>
            </tr>
            <tr>
                <th class="thtit" colspan="2" id="newcon">
                    <table width="100%">
                        <tr>
                            <td width="5%" class="tdlimpio">CONCEPTO: </td>
                            <td width="50%" class="tdlimpio">
                                <textarea name="concepto" class="notiny tinybasic" id="c1"></textarea>
                            </td>
                            <td width="5%" class="tdlimpio">PRECIO: </td>
                            <td width="10%" class="tdlimpio">
                                <input type="text" name="precio" id="c2" />
                            </td>
                            <td width="5%" class="tdlimpio">CANTIDAD: </td>
                            <td width="10%" class="tdlimpio">
                                <input type="text" name="cantidad" id="c3" />
                            </td>
                            <td width="5%" class="tdlimpio">
                                <div class="newconcepre"><a href="" title="Añadir concepto">+</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    $totalo=0;
                    $num=0;
                    $sql="SELECT id, concepto, precio, cantidad, num FROM kng_conceptos WHERE presupuesto='" .$_GET[ 'arg3']. "' ORDER BY num ASC";
                    $res=mysql_query($sql);
                    ?>
                    <div id="prfa" class="<?php echo $_GET['arg3']; ?>"></div>
                    <div class="conceptos">
                        <ul class="presusi" id="conceptitos">
                            <?php
                            while($row=mysql_fetch_array($res))
                            {
                                $totall=( $row[ 'precio']*$row[ 'cantidad']);
                                ?>
                                <li id="concepto-<?php echo $row['id']; ?>">
                                    <table width="100%" class="cct<?php echo $row['num']; ?> conann">
                                        <tr>
                                            <td width="50%" class="tdlimpio conL">
                                                <?php echo $row[ 'concepto']; ?>
                                            </td>
                                            <td width="5%" class="tdlimpio zz">PRECIO: </td>
                                            <td width="10%" class="tdlimpio zy preL">
                                                <?php echo number_format($row[ 'precio'], 2, ',', '.'); ?>
                                            </td>
                                            <td width="5%" class="tdlimpio zz">CTD: </td>
                                            <td width="5%" class="tdlimpio zy canL">
                                                <?php echo $row[ 'cantidad']; ?>
                                            </td>
                                            <td width="5%" class="tdlimpio zz">TOT: </td>
                                            <td width="10%" class="tdlimpio zy totalL">
                                                <?php echo number_format($totall, 2, ',', '.'); ?>
                                            </td>
                                            <td width="5%" class="tdlimpio">
                                                <ul>
                                                    <li class="editconcepre" id="dc::<?php echo $row['id']; ?>">
                                                        <a href="#" title="Editar concepto">E</a>
                                                    </li>
                                                    <li class="delconcepre" id="dc::<?php echo $row['num']; ?>::<?php echo $totall;  ?>">
                                                        <a href="#" title="Quitar concepto">X</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <?php
                                $totalo +=( $row['precio']*$row['cantidad']);
                                $num=$row['num'];
                            }
                            ?>
                        </ul>
                        <?php
                        $num++;
                        $ivaa=($totalo*$iva)/100;
                        $totaloiva=$totalo+$ivaa;
                        ?>
                        <div id="next" class="<?php echo $num; ?>"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" style="font-size: 20px; font-weight: bold; color: #FFFFFF;" class="thtit">
                    TOTAL: <span id="totall" total="<?php echo $totalo;  ?>"><?php echo number_format($totalo, 2, ',', '.').' € +IVA ('.$iva.'%) '.number_format($ivaa, 2, ',', '.').' € :: '.number_format($totaloiva, 2, ',', '.').' €'; ?> </span>
                </td>
            </tr>
        </table>
    </form>
    <div id="editorlineas">
        <span class="cerrar">x</span>
        <div class="formulario">
            <table width="100%">
                <tr>
                    <td width="70%" class="tdlimpio">
                        <label for="conceptoE">Concepto</label>
                        <textarea class="notiny tinybasic" id="conceptoE"></textarea>
                    </td>
                    <td width="30%" class="tdlimpio">
                        <label for="precioE">Precio (formato 000000.00)</label>
                        <input type="text" id="precioE" value=""></input>
                        <label for="cantidadE">Cantidad</label>
                        <input type="text" id="cantidadE" value=""></input>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="tdlimpio tcentrado" >
                        <input type="hidden" id="idE" value=""></input>
                        <input type="hidden" id="totalE" value=""></input>
                        <input type="submit" name="submit" value="Modificar" class="modificar">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
}
//GENERAL
else
{
    $esteanio = date("Y");
    $sql = "SELECT fa.id AS prid, numero, fecha, nombre, titulo, cl.id AS clid, fa.notas AS notasfa
    FROM ".$tablaa." AS fa
    LEFT JOIN kng_clientes As cl ON cl.id = fa.cliente
    WHERE fa.id>0";
    if(isset($_POST['accion']) AND $_POST['accion']=="Buscar")
    {
        if (isset($_POST['anio']))
        {
            if($_POST['anio']=="0") $esteanio = date("Y");
            else if($_POST['anio']=="all") $esteanio= "%";
            else $esteanio = $_POST['anio'];
            $sql .= " AND fecha LIKE '".$esteanio."-%'";
        }
    }
    else $sql .= " AND fecha LIKE '".$esteanio."-%'";
    if (isset($_POST['fechi']) AND $_POST['fechi']!="") $sql .= " AND fecha >= '".$_POST['fechi']."'";
    if (isset($_POST['fechf']) AND $_POST['fechf']!="") $sql .= " AND fecha <= '".$_POST['fechf']."'";
    if (isset($_POST['cliente']) AND $_POST['cliente']>0) $sql .= " AND cl.id = '".$_POST['cliente']."'";
    $sql .= " ORDER by numero DESC";
    //echo $sql.'<br />';
    $result = mysql_query($sql);
    $cuantos=mysql_num_rows($result);
    ?>
    <!-- CABECERA -->
    <div class="infotabla pager">
        Presupuestos: <?php echo $cuantos; ?>
    </div>
    <!-- BUSCADOR -->
    <div class="pager buscador">
        <form action="" method="post">
            Año:
            <select name="anio" style="width: auto; padding: 2px 12px;">
                <option value="0">Seleccione año</option>
                <option value="all">Cualquiera</option>
                <?php
                for ($xi=date("Y"); $xi>=2010; $xi--)
                {
                    ?>
                    <option value="<?php echo $xi; ?>"><?php echo $xi; ?></option>";
                    <?php
                }
                ?>
            </select>
            <select name="cliente" style="width: 300px; padding: 2px 12px; text-align: left;">
                <option value="0">Seleccionar cliente</option>
                <?php
                $sqlcli = "SELECT id, nombre FROM kng_clientes WHERE borrado = '0' ORDER BY nombre";
                $rescli = mysql_query($sqlcli);
                while ($rowcli = mysql_fetch_array($rescli))
                {
                    ?>
                    <option value="<?php echo $rowcli['id']; ?>"><?php echo $rowcli['nombre']; ?></option>
                    <?php
                }
                ?>
            </select>
            Fecha inicio <input class="inputcalendario" type="text" name="fechi" readonly="readonly" onclick="displayCalendar(fechi,'dd-mm-yyyy',this)" style="width:100px; text-align:left" />
            Fecha fin <input class="inputcalendario" type="text" name="fechf" readonly="readonly" onclick="displayCalendar(fechf,'dd-mm-yyyy',this)" style="width:100px; text-align:left" />
            <input type="submit" value="Buscar" name="accion" />
        </form>
    </div>
    <table class="tablesorter">
        <thead>
            <tr>
                <th width="1%">Nº</th>
                <th width="5%">FECHA</th>
                <th>CLIENTE</th>
                <th>TÍTULO</th>
                <th width="150px" class="{sorter: 'currency'}">IMPORTE</th>
                <th class="tcentrado {sorter: false}">IVA</th>
                <th class="{sorter: 'currency'}">+IVA</th>
                <th width="1%" class="tcentrado {sorter: false}" >PDF</th>
                <th width="1%" class="tcentrado {sorter: false}" >PROFORMA</th>
                <th width="1%" class="tcentrado {sorter: false}" >FACTURA</th>
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
                    <td title="<?php echo strip_tags($row['notasfa']); ?>">
                        <?php
                        $linkfa = "#";
                        $numi = "";
                        $largura = strlen($row['numero']);
                        for($xz=$largura; $xz<5; $xz++) $numi .="0";
                        if (file_exists("presupuestos/SN_".$numi.$row['numero']).".pdf") $linkfa = BASEURL."presupuestos/SN_".$numi.$row['numero'];
                        echo 'SN_'.$numi.$row['numero'].'/'.substr($row['fecha'], 0, 4);
                        ?>
                    </td>
                    <td class="{sorter: 'isoDate'}"><?php echo $row['fecha']; ?></td>
                    <td title="<?php echo $row['nombre']; ?>" class="may" ><?php echo (recortar_texto($row['nombre'], 35, " ", " [+]")); ?></td>
                    <td title="<?php echo $row['titulo']; ?>" class="may" ><?php echo (recortar_texto($row['titulo'], 35, " ", " [+]")); ?></td>
                    <td style="text-align: right; padding-right: 10px;">
                        <?php
                        $sqlc = "SELECT precio, cantidad
                        FROM kng_conceptos
                        WHERE presupuesto = '".$row['prid']."'
                        ";
                        $resc= mysql_query($sqlc);
                        $tutti = 0;
                        while($rowc=mysql_fetch_array($resc))
                        {
                            $tutti += ($rowc['precio']*$rowc['cantidad']);
                        }
                        echo number_format($tutti, 2, ',', '.').' €';
                        ?>
                    </td>
                    <td><?php echo ivafecha($row['fecha']).'%'; ?></td>
                    <td style="text-align: right; padding-right: 10px;">
                        <?php echo number_format(iva($tutti, $row['fecha'] ), 2, ',', '.').' €'; ?>
                    </td>
                    <td class="tcentrado"><a target="_blank" href="<?php echo BASEURL."fac/pres_pdf_m.php?id=".$row['prid'].""; ?>" target="_blank"><img src="imagenes/icono-pdf.png" alt="pdf" width="16" height="16" /></a></td>
                    <td class="tcentrado">
                        <?php
                        //MIRAMOS SI YA EXISTE UNA PROFORMA DE ESTA PROPUESTA
                        $sqlp = "SELECT numero FROM kng_proformas WHERE presupuesto = '".$row['prid']."'";
                        //echo $sqlp.'<br /><br />';
                        $resp = mysql_query($sqlp);
                        if(mysql_num_rows($resp)>0)
                        {
                            $rowp = mysql_fetch_array($resp);
                            ?>
                            <a target="_blank" href="fac/pro_pdf_m.php?id=<?php echo $rowp['numero']; ?>"><img src="imagenes/ok.png" alt="Proforma creada" title="Proforma creada" width="16" height="16" /></a>
                            <?php
                        }
                        else
                        {
                            ?><a href=""><img id="pr::<?php echo $row['prid'].'::'.$row['clid'].'::'.$row['titulo']; ?>" class="crpr" src="imagenes/icono-facturar.png" alt="facturar" title="Crear factura proforma" width="16" height="16" /></a><?php
                        }
                        ?>
                    </td>
                    <td class="tcentrado">
                        <?php
                        //MIRAMSO SI YA EXISTE UNA FACTURA DE ESTA PROPUESTA
                        $sqlp = "SELECT id FROM kng_facturas WHERE presupuesto = '".$row['prid']."'";
                        //echo $sqlp.'<br /><br />';
                        $resp = mysql_query($sqlp);
                        if(mysql_num_rows($resp)>0)
                        {
                            $rowp = mysql_fetch_array($resp);
                            ?>
                            <a target="_blank" href="fac/fac_pdf_m.php?id=<?php echo $rowp['id']; ?>"><img src="imagenes/ok.png" alt="Factura creada" title="Factura creada" width="16" height="16" /></a>
                            <?php
                        }
                        else
                        {
                            ?><a href=""><img id="pr::<?php echo $row['prid'].'::'.$row['clid'].'::'.$row['titulo']; ?>" class="crfa" src="imagenes/icono-facturar.png" alt="facturar" title="Crear factura" width="16" height="16" /></a><?php
                        }
                        ?>
                    </td>
                    <td class="tcentrado" id="ed<?php echo $row['numero']; ?>">
                        <?php
                        if(mysql_num_rows($resp)==0)
                        {
                            ?><a href="<?php echo enlazar($_GET['arg1']."/editar/".$row['prid']); ?>"><img src="imagenes/editar.png" alt="editar" width="16" height="16" /></a></td><?php
                        }
                        ?>
                        <td class="tcentrado"><a title="Borrar" href="" class="<?php echo $tablaa.'::'.$row['prid']; ?>"><img src="imagenes/borrar.png" alt="Borrar" width="16" height="16" class="borradof" /></a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <div style="padding-top: 10px; text-align: center;">
            <a class="boton_a bg_rojo" href="<?php echo enlazar($_GET['arg1']."/nuevo"); ?>">Nuevo presupuesto</a>
        </div>
        <?php
        include ("html/paginador.php");
    }
