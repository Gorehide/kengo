<div class="logokengo">
	<a href="<?php echo $k_url; ?>" target="_BLANK"><b>Kengo</b><br/>Facturación v<?php echo $k_version; ?></a>
</div>
<div class="tittop">
	<?php echo $_GET['arg1']; ?> 
</div>
<div class="men">
    	Bienvenid@ <?php echo $_SESSION['admin']; ?>
    	&nbsp;&nbsp;
    	<a href="<?php echo enlazar("gestor"); ?>" alt="Inicio" title="Inicio">
	        <img src="imagenes/iconos/gestor.png" width="15px" />
    	</a>
    	&nbsp;&nbsp;
    	<a href="<?php echo enlazar("perfil"); ?>" alt="Perfil" title="Perfil">
        	<img src="imagenes/iconos/perfil.png" width="15px" />
    	</a>
    	&nbsp;&nbsp;
    	<a href="<?php echo enlazar("salir"); ?>" alt="Salir" title="Salir">
        	<img src="imagenes/iconos/salir.png" width="15px" />
    	</a>
    	&nbsp;&nbsp;
</div>
<div class="finflotar"></div>