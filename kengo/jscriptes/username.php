<?php
include ("../config/config.php");
include ("../includes/conectar.php");

$sql="SELECT nick
FROM admins
WHERE nick = '".$_POST['user_name']."'
LIMIT 1";
$res = mysql_query($sql);
if (mysql_num_rows($res)>0)
{
	//user name is not availble
	echo "no";
}
else
{
	//user name is available
	echo "yes";
} 
?>