<div class="faccli">
	<?php
	$st = 0;	
	$s1= "SELECT c.precio AS pprecio, c.cantidad AS ccantidad, f.id, f.fecha
	FROM kng_facturas AS f 
	LEFT JOIN kng_conceptos AS c ON f.id = c.factura	
	LEFT JOIN kng_clientes AS l ON l.id = f.cliente
	WHERE f.id>0";
	/*	
	if(isset($_POST['accion']) AND $_POST['accion']=="Buscar")
    {
    	if (isset($_POST['anio']) AND $_POST['anio']>0)  $esteanio=$_POST['anio'];
    	$s1 .= " WHERE fecha LIKE '".$esteanio."-%'";
    	if (isset($_POST['fechi']) AND $_POST['fechi']!="") $s1 .= " AND fecha >= '".$_POST['fechi']."'";
    	if (isset($_POST['fechf']) AND $_POST['fechf']!="") $s1 .= " AND fecha <= '".$_POST['fechf']."'";
    	if (isset($_POST['cliente']) AND $_POST['cliente']>0) $s1 .= " AND l.id = '".$_POST['cliente']."'";
    }
    */
	if(isset($_POST['accion']) AND $_POST['accion']=="Buscar")
	{
		if (isset($_POST['anio']))
		{
		if($_POST['anio']=="0") $esteanio = date("Y");
			else if($_POST['anio']=="all") $esteanio= "%";
			else $esteanio = $_POST['anio'];
			$s1 .= " AND f.fecha LIKE '".$esteanio."-%'";
		}
	}    
	else $s1 .= " AND f.fecha LIKE '".$esteanio."-%'";
	if (isset($_POST['trimestre']) AND $_POST['trimestre']>0)
	{
		$s1 .= " AND (";
		$mesu = (3*($_POST['trimestre']-1))+1;
		for($xc = $mesu; $xc <$mesu+3; $xc++)
		{
			$mess = "0".$xc;
			$mess = substr($mess, -2);
			if($xc>$mesu) $s1 .=" OR "; 
			$s1 .= " fecha LIKE '".$esteanio."-".$mess."-%' ";    		
		}
		$s1 .= ")";
	}	
	if (isset($_POST['cliente']) AND $_POST['cliente']>0) $s1 .= " AND l.id = '".$_POST['cliente']."'";
	//echo $s1.'<br /><br />';//QUERY S1
	$r1 = mysql_query($s1);
	if(mysql_num_rows($r1)>0)
	{
		while($t1 = mysql_fetch_array($r1))
		{
			$st += $t1['pprecio']*$t1['ccantidad'];	
		}      
	}

	$s2 = "SELECT SUM(cantidad) AS TOTAL
	FROM kng_facturas AS fa
	LEFT JOIN kng_pagos AS pa ON fa.id = pa.factura    
	LEFT JOIN kng_clientes AS cl ON cl.id = fa.cliente
	WHERE fa.id>0";
    /*
    if(isset($_POST['accion']) AND $_POST['accion']=="Buscar")
	{
		if (isset($_POST['anio']) AND $_POST['anio']>0)  $esteanio=$_POST['anio'];
		$s2 .= " WHERE fa.fecha LIKE '".$esteanio."-%'";
		if (isset($_POST['fechi']) AND $_POST['fechi']!="") $s2 .= " AND fecha >= '".$_POST['fechi']."'";
   		if (isset($_POST['fechf']) AND $_POST['fechf']!="") $s2 .= " AND fecha <= '".$_POST['fechf']."'";
   		if (isset($_POST['cliente']) AND $_POST['cliente']>0) $s2 .= " AND cl.id = '".$_POST['cliente']."'";
	}
	else $s2 .=" WHERE fa.fecha LIKE '".$esteanio."-%'";
	*/
	if(isset($_POST['accion']) AND $_POST['accion']=="Buscar")
	{
		if (isset($_POST['anio']))
		{
		if($_POST['anio']=="0") $esteanio = date("Y");
			else if($_POST['anio']=="all") $esteanio= "%";
			else $esteanio = $_POST['anio'];
			$s2 .= " AND fa.fecha LIKE '".$esteanio."-%'";
		}
	}    
	else $s2 .= " AND fa.fecha LIKE '".$esteanio."-%'";
	if (isset($_POST['trimestre']) AND $_POST['trimestre']>0)
	{
		$s2 .= " AND (";
		$mesu = (3*($_POST['trimestre']-1))+1;
		for($xc = $mesu; $xc <$mesu+3; $xc++)
		{
		//echo $xc.'<br />';
			$mess = "0".$xc;
			$mess = substr($mess, -2);
			if($xc>$mesu) $s2 .=" OR "; 
		$s2 .= " fa.fecha LIKE '".$esteanio."-".$mess."-%' ";    		
		}
		$s2 .= ")";
	}	
   	if (isset($_POST['cliente']) AND $_POST['cliente']>0) $s2 .= " AND cl.id = '".$_POST['cliente']."'";	
	$s2 .= " AND pa.borrado = '0'";
    //echo $s2.'<br /><br />';//QUERY S2
    $r2= mysql_query($s2);
    $t2 = mysql_fetch_array($r2);
    //MOSTRAMOS LOS DAOTOS
    ?>
    <div style="width: 90%; padding: 10px 0px; text-align: center; color: #FFFFFF; margin: auto; text-shadow: none; font-weight: bold; font-size: 12px;"><?php if($esteanio=="%") echo "TOTAL"; else echo $esteanio; ?></div>
    <div class="cajaround bg_azulgrad">
        <?php echo "Facturado: ".number_format(iva($st, date("Y-m-d")), 2, ',', '.')." €<br />Sin IVA: ".number_format($st, 2, ',', '.')." €"; ?>
    </div>
    <div class="cajaround bg_verdegrad">
        <?php echo "Pagado: ".number_format($t2['TOTAL'], 2, ',', '.')." €<br /><br />"; ?>
    </div>
    <div class="cajaround bg_rojograd">
        <?php echo "Pendiente: ".number_format(iva($st, date("Y-m-d"))-$t2['TOTAL'], 2, ',', '.')." €<br /><br />"; ?>
    </div>
    <div class="finflotar"></div>
</div>