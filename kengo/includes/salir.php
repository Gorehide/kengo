<?php
$_SESSION['admin']="";
session_destroy();
session_unset();
header("Location: ".enlazar("login"));
?>