$(document).ready(function()
{
    $("#guardar").bind("click",function()
    {
        var error = -1;
    	var errorStr = "Los siguientes campos deben contener alg\xfan valor:\n";
    	for (var i=0;(i<$(".obligatorio",$("#perfil")).length);i++)
        {
    	    var o = $(".obligatorio:eq("+i+")",$("#rolex"));
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
            $(".obligatorio:eq("+error+")",$("#rolex")).focus();
            return false;
        }
        return (true);
    });

});