$(document).ready(function()
{
	//PARA LA ZONA DE ESTATICOS						
	$("#capaoculta").hide();
	$(".ocultarcapaoculta").hide();
    	$("#ocultar").click(function(event)
    	{
        	event.preventDefault();
        	$("#capaoculta").toggle("fast");        	
    	});
    	$(".capaocultaidioma").hide();
    	$(".capaocultaidioma:eq(0)").show();
    	$(".ocultaridioma").click(function(event)
   	{    		
        	event.preventDefault();
        	$(".capaocultaidioma").slideUp("fast");
        	$(this).next(".capaocultaidioma").slideDown();
    	});
    	//PARA LA ZONA DE GALERIAS							
    	var dato = $("#subgal").attr("class");
    	if(dato!="si") $("#galeriaoculta").hide();
	$("#galoculta").click(function(event)
    	{
        	event.preventDefault();
        	$("#galeriaoculta").toggle("fast");        	
    	});
});