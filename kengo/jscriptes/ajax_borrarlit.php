<?php
include("../config/config.php");
include("../includes/conectar.php"); 
include("../includes/idiomas.php");
include("../includes/funciones.php");
$sql = "DELETE FROM literales WHERE id = '".$_GET['id']."' LIMIT 1";
mysql_query($sql);
function crear_traducciones()
{
  	//CREAMOS LOS ARCHIVOS DE TRADUCCION
  	global $aidiomas;
	for ($xz=0; $xz<count($aidiomas); $xz++)
  	{
      		$idi = $aidiomas[$xz]['nombre'];
	        $sql2 = "SELECT literal_tit, literal_".$idi."
	        FROM literales
	        WHERE borrado='0' ORDER BY literal_tit ASC";
	        $res2 = mysql_query($sql2);
	        $string = "<?php\n";
	        while ($row2 = mysql_fetch_array($res2))
	        {
	        	$string .= "\$trad_".$row2['literal_tit']." = \"".$row2['literal_'.$idi.'']."\";\n";
	        }
	        $string .= "?>";
	        $fp = fopen("../../traducciones/traduccion_".$idi.".php", "w");
	        $write = fputs($fp, $string);
	        fclose($fp);
	}
}
crear_traducciones();
?>