$("document").ready(function(){
	var urll = $("#urll").attr('class');
	/*                                                                                                                                                                                                                              */
	/*CAMBIAR ESTADO 1-0                                                                                                                                                                           			*/
	/*                                                                                                                                                                                                                              */
	$(".clicki").live("click", function(event){
		event.preventDefault();
		identi = $(this).parent().attr('class');
		datios = identi.split("::");
		/*SI ESTA ACTIVA LA DESACTIVAMOS */
		if ($(this).attr("alt")=="ON")
		{
			$(this).replaceWith('<img src="imagenes/bannear.png" class="clicki" width="16" height="16" alt="OFF" />');
			$.get(""+urll+"jscriptes/ajax_rapidos.php", { tabla: ""+datios[0]+"", id: ""+datios[1]+"", columna: ""+datios[2]+"", valor: 0 });
		}
		/*SI ESTA INACTIVA LA ACTIVAMOS*/
		else
		{
			$(this).replaceWith('<img src="imagenes/ok.png"  class="clicki" width="16" height="16" alt="ON" />');
			$.get(""+urll+"jscriptes/ajax_rapidos.php", { tabla: ""+datios[0]+"", id: ""+datios[1]+"", columna: ""+datios[2]+"", valor: 1 });
		}
	});	
	/*                                                                                                                                                                                                                              */
	/*BORRADO LOGICO                                                                                                                                                                                                           	*/
	/*                                                                                                                                                                                                                              */
	$(".dele").live("click", function(event){
		event.preventDefault();
		identi = $(this).parent().attr('class');
		datios = identi.split("::");
		imageni = $(this).attr('title');
    	if(confirm("¿Seguro que quieres borrarlo?"))
    	{
			$(this).replaceWith('<img src="imagenes/undo.png" class="recu" width="16" height="16" alt="Borrado" title="Recuperar" />');
	        $("#col"+datios[1]+" td").css("text-decoration","line-through");
			$.get(""+urll+"jscriptes/ajax_borrar.php", { tabla: ""+datios[0]+"", id: ""+datios[1]+"", estado: "1"});
		}		
	});
	/*                                                                                                                                                                                                                              */
	/*RECUPERAR BORRADO LOGICO                                                                                                                                                                                               	*/
	/*                                                                                                                                                                                                                              */
	$(".recu").live("click", function(event){
		event.preventDefault();
		identi = $(this).parent().attr('class');
		datios = identi.split("::");
		$(this).replaceWith('<img src="imagenes/borrar.png" class="dele" width="16" height="16" alt="Borrar" title="Borrar" />');
		$("#col"+datios[1]+" td").css("text-decoration","none");
        $.get(""+urll+"jscriptes/ajax_borrar.php", { tabla: ""+datios[0]+"", id: ""+datios[1]+"", estado: "0"});
	});
	/*                                                                                                                                                                                                                              */
	/*BORRADO FISICO                                                                                                                                                                                               			*/
	/*                                                                                                                                                                                                                              */	
	$(".borradof").live("click", function(event){
		identi = $(this).parent().attr('class');
		datios = identi.split("::");
		if(confirm("¿Seguro que quieres borrarlo?"))
		{
	        $.get(""+urll+"jscriptes/ajax_borradof.php", { tabla: ""+datios[0]+"", id: ""+datios[1]+""});
	        alert("Borrado con éxito");
		}
	    else event.preventDefault();
	});
	/*                                                                                                                                                                                                                              */
	/*BORRADO ROL                                                                                                                                                                                               			*/
	/*                                                                                                                                                                                                                              */	
	$(".borradorol").live("click", function(event){
		identi = $(this).parent().attr('class');
		datios = identi.split("::");
		if(datios[1]=="1")
		{
			event.preventDefault();
			alert("No se puede eliminar el rol de Administrador");
		}
		else
		{
			if(confirm("¿Seguro que quieres borrarlo?"))
			{
		       	$.get(""+urll+"jscriptes/ajax_borradorol.php", { id: ""+datios[1]+""});
		       	alert("Borrado con éxito");
			}
		    else event.preventDefault();
		}		
	});
	/*                                                                                                                                                                                                                              */
	/*BORRADO LITERAL                                                                                                                                                                                               			*/
	/*                                                                                                                                                                                                                              */	
	$(".borrarlit").live("click", function(event){
		identi = $(this).parent().attr('class');
		datios = identi.split("::");
		if(confirm("¿Seguro que quieres borrarlo?"))
		{
	        $.get(""+urll+"jscriptes/ajax_borrarlit.php", { id: ""+datios[1]+""});
	        alert("Borrado con éxito");
		}
	    else event.preventDefault();
	});
	/*                                                                                                                                                                                                                              */
	/*DELETEFILE                                                                                                                                                                                                            	*/
	/*                                                                                                                                                                                                                              */
	$(".deletefile").live("click", function(event){		
		identi = $(this).parent().attr('class');
		datios = identi.split("::");		
		if(confirm("¿Seguro que quieres borrar: "+datios[1])) 
		{
			$.get(""+urll+"jscriptes/ajax_deletefile.php", { ruta: ""+datios[0]+"", archivo: ""+datios[1]+""});
			alert("Borrado con éxito");
		}	
		else event.preventDefault();
	
	});
});