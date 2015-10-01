$(document).ready(function()
{
	var mos = 1;
	// MOSTRAR U OCULTAR HIJOS DEL MENU
	$(".sele").live("click",function()
	{
    		$(".oculto").slideUp("fast");
        	$(this).parent().next(".oculto").slideToggle("fast");
    	});
    	$(".menubotonsel",$(".menu")).next(".oculto").show();
    	$(".menubotonsel").parents(".oculto").show();
    	
    	//MOSTRAR U OCULTAR EL MENU
    	
	function mosi()
	{		
		if (mos==1)
		{
			$(".contenido").css("margin", "0px");	
			mos=0;
			$("#ocmenu").html('>');
		}
    		else
    		{
    			$(".contenido").css("margin", "0px 0px 0px 265px");
    			mos=1;
    			$("#ocmenu").html('<');
    		}
	}    	
    	$("#ocmenu").live("click",function()
    	{
    		$(".menu").toggle();
    		mosi();
    	});
});