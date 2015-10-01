<?php
$link = mysql_connect($k_pathbd,$k_userbd,$k_passbd) or die(mysql_error());
mysql_select_db($k_bbdd) or die (mysql_error());
?>