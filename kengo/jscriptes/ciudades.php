<select name="ciudad" style="width: 98%;">
	<?php
	include ("../config/config.php");
	include ("../includes/conectar.php");
	
	$sql="SELECT nombre, id
	FROM kng_ciudades
	WHERE provincia = '".$_GET['id']."'
	ORDER BY nombre ASC";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res))
	{
		echo '<option value="'.$row['id'].'">'.utf8_encode($row['nombre']).'</option>';
		echo $row['nombre'];
	}
	?>
</select>