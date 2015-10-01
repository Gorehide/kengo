$(document).ready(function()
{
	var urll = $("#urll").attr('class');
	$(".crfa").live("click", function(event)
	{		
		event.preventDefault();
		if(confirm("¿Crear factura basada en este presupuesto?\n\r"))
		{			
			var ccual = $(this).attr("id");
			ccual = ccual.split("::");
			//alert("FACTURA CREADA: "+ccual[1]+"");
			//$(this).attr("src", "imagenes/icono-pdf.png");
			//$(this).parent().css("background", "red");
			$("#ed"+ccual[1]).html('');
			//alert("#ed"+ccual[1]);
			$(this).parent().parent().html('<img src="imagenes/ok.png" width="16" height="16" title="Factura creada" />');
			$(this).removeClass("crfa");
			$.get(""+urll+"jscriptes/crearfactura.php", { presu: ""+ccual[1]+"", cliente: ""+ccual[2]+"", titulo: ""+ccual[3]+""});
			alert("Factura creada con éxito");
		}
	});
	$(".crfa2").live("click", function(event)
	{		
		event.preventDefault();
		if(confirm("¿Crear factura basada en esta proforma?\n\r"))
		{			
			var ccual = $(this).attr("id");
			ccual = ccual.split("::");
			//alert("FACTURA CREADA: "+ccual[1]+"");
			//$(this).attr("src", "imagenes/icono-pdf.png");
			//$(this).parent().css("background", "red");
			$("#ed"+ccual[1]).html('');
			//alert("#ed"+ccual[1]);
			$(this).parent().parent().html('<img src="imagenes/ok.png" width="16" height="16" title="Factura creada" />');
			$(this).removeClass("crfa");
			$.get(""+urll+"jscriptes/crearfactura.php", { presu: ""+ccual[1]+"", cliente: ""+ccual[2]+"", titulo: ""+ccual[3]+""});
			alert("Factura creada con éxito");
		}
	});
	$(".crpr").live("click", function(event)
	{		
		event.preventDefault();
		if(confirm("¿Crear factura proforma basada en este presupuesto?\n\r"))
		{			
			var ccual = $(this).attr("id");
			ccual = ccual.split("::");
			//alert("FACTURA CREADA: "+ccual[1]+"");
			//$(this).attr("src", "imagenes/icono-pdf.png");
			//$(this).parent().css("background", "red");
			$("#ed"+ccual[1]).html('');
			//alert("#ed"+ccual[1]);
			$(this).parent().parent().html('<img src="imagenes/ok.png" width="16" height="16" title="Factura creada" />');
			$(this).removeClass("crfa");
			$.get(""+urll+"jscriptes/crearproforma.php", { presu: ""+ccual[1]+"", cliente: ""+ccual[2]+"", titulo: ""+ccual[3]+""});
			alert("Factura proforma creada con éxito");
		}
	});
});