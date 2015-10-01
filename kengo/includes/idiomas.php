<?php
$sqlidiomas = "SELECT nombre, descripcion
FROM zkng_idiomas
WHERE activo = '1'";
$residiomas = mysql_query($sqlidiomas);
$contadoridiomas = 0;
while($rowidiomas = mysql_fetch_array($residiomas))
{
	$aidiomas[$contadoridiomas]['nombre'] = $rowidiomas['nombre'];
	$aidiomas[$contadoridiomas]['descripcion'] = $rowidiomas['descripcion'];
	$contadoridiomas++;
}  
?>