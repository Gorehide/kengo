<?php
include("../config/config.php");
include("../includes/conectar.php"); 
unlink ('../'.$_GET['ruta'].$_GET['archivo']);
?>