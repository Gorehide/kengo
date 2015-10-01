$(document).ready(function()
{
	// $("#perfil").bind("submit",function()
    	$("#guardar").bind("click",function()
    	{
        	var error = -1;
    		var errorStr = "Los siguientes campos deben contener alg\xfan valor:\n";
    		for (var i=0;(i<$(".obligatorio",$("#perfil")).length);i++)
        	{
    	    		var o = $(".obligatorio:eq("+i+")",$("#perfil"));
            		if (o.val()=="")
            		{
       	        		if (error == -1)
       		    		error =  i;
            			errorStr += "\t"+o.attr("title")+"\n";
            			o.css("background-color","#FF0000");
            			o.css("color","#FFFFFF");
           		}
            		else
            		{
       	    			o.css("background-color","#CCCCCC");
                		o.css("color","#333333");
            		}
        	}
        	if (error!=-1)
        	{
            		alert(errorStr+"Por favor, compl\xe9telos y pruebe de nuevo.");
            		$(".obligatorio:eq("+error+")",$("#perfil")).focus();
            		return false;
        	}
        	//contraseñas coinciden------------------
        	if ($("#pass").val()!=$("#pass2").val())
        	{
        		alert("Las contrase\xf1as no coinciden!!");
            		$("#pass").focus();
            		return false;
        	}
        	//validar e-mail--------------------------------------
        	var email=$("#mail").val();
        	if (!(/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(email)))
        	{
            		alert("La direcci\xf3n de email " + email    + " es incorrecta.");
            		$("#mail").focus();
            		$("#mail").css("background-color","#FF0000");
            		$("#mail").css("color","#FFFFFF");
            		return (false)
        	}
        	//TLF correcto------------------------
        	/*var telefono=$("#telefono").val();
        	if( !(/^\d{9}$/.test(telefono)) )
        	{
            		alert("Has introducido un tel\xe9fono inv\xe1lido");
            		$("#telefono").focus();
            		return false;
        	}*/
        	return (true);
    	});
});