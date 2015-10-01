$(document).ready(function()
{
	var iva = $("#urll").attr("iva");
	var urll = $("#urll").attr('class');
	var qua = $("#next").attr('class');
	var subtotal = parseFloat($("#totall").attr('total'));
	var id = $("#prfa").attr("class");
	//console.log('IVA: '+iva+'\nURLL: '+urll+'\nQUA: '+qua+'\nSUBTOTAL: '+subtotal+'\nID: '+id);
	//DELIMITAMOS ESTOS INPUTS A SOLO NUMEROS
	$("#c2").format({type:"numi"});
	$("#c3").format({type:"numi"});
	//$("#precioE").format({type:"numi"});
	$("#cantidadE").format({type:"numi"});

	// PONER DECIMALES EN LOS NUMEROS
	function CurrencyFormatted(amount)
	{
	    var i = parseFloat(amount);
	    if(isNaN(i)) { i = '0,00'; }
	    var minus = '';
	    if(i < 0) { minus = '-'; }
	    i = Math.abs(i);
	    i = parseInt((i + .005) * 100);
	    i = i / 100;
	    s = new String(i);
	    if(s.indexOf('.') < 0) { s += ',00'; }
	    if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
		s = s.replace(".",",");
	    s = minus + s;
	    return s;
	}
	// PONER SEPARADORES DE MILES EN LOS NUMEROS
	function CommaFormatted(amount)
	{
		var delimiter = "."; // replace comma if desired
		var a = amount.split(',',2)
		var d = a[1];
		var i = parseInt(a[0]);
		if(isNaN(i)) { return ''; }
		var minus = '';
		if(i < 0) { minus = '-'; }
		i = Math.abs(i);
		var n = new String(i);
		var a = [];
		while(n.length > 3)
		{
			var nn = n.substr(n.length-3);
			a.unshift(nn);
			n = n.substr(0,n.length-3);
		}
		if(n.length > 0) { a.unshift(n); }
		n = a.join(delimiter);
		if(d.length < 1) { amount = n; }
		else { amount = n + ',' + d; }
		amount = minus + amount;
		return amount;
	}
	/*========================================================================================================================================*/
	/*PARA LAS FACTURAS=======================================================================================================================*/
	/*========================================================================================================================================*/
	// AÑADIR CONCEPTO
	$(".newconce").bind("click", function(event)
	{
		event.preventDefault();
		var content = tinyMCE.activeEditor.getContent(); // get the content
    	$('#c1').val(content); // put it in the textarea
		if(content!="" && $("#c2").val()!="" && $("#c3").val()!="")
		{
			//var concepto = $("#newcon #c1").attr("value");
            var concepto = content;
			//var precio = $("#newcon #c2").attr("value");
            var precio = $("#newcon #c2").val();
			//var cantidad = $("#newcon #c3").attr("value");
            var cantidad = $("#newcon #c3").val();
			var total = precio*cantidad;
        	//$(".conceptos .presusi").append('<li><table width="100%" class="cct'+qua+' conann"><tr><td width="50%" class="tdlimpio">'+concepto+'</td><td width="5%" class="tdlimpio zz">PRECIO: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(precio))+'</td><td width="5%" class="tdlimpio zz">CTD: </td><td width="5%" class="tdlimpio zy">'+cantidad+'</td><td width="5%" class="tdlimpio zz">TOT: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(total))+'</td><td width="5%" class="tdlimpio"><div id="dc::'+qua+'::'+id+'" class="delconcepre"><a title="Quitar concepto" href="">X</a></div></td></tr></table></li>');
        	$(".conceptos .presusi").append('<li><table width="100%" class="cct'+qua+' conann"><tr><td width="50%" class="tdlimpio">'+concepto+'</td><td width="5%" class="tdlimpio zz">PRECIO: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(precio))+'</td><td width="5%" class="tdlimpio zz">CTD: </td><td width="5%" class="tdlimpio zy">'+cantidad+'</td><td width="5%" class="tdlimpio zz">TOT: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(total))+'</td><td width="5%" class="tdlimpio"></td></tr></table></li>');
        	subtotal = parseFloat(subtotal+total);
        	$("#totall").html(CommaFormatted(CurrencyFormatted(subtotal)));
        	$("#totall").append(" € +IVA ("+iva+"%) ");
        	subiva = (subtotal*iva)/100;
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	subiva = subtotal+subiva;
        	$("#totall").append(" € :: ");
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	$("#totall").append(" €");
        	$.post(""+urll+"jscriptes/conceptos.php", { acc: "add", tabla: "kng_conceptos", factura: ""+id+"", num: ""+qua+"", concepto: ""+concepto+"", precio: ""+precio+"", cantidad: ""+cantidad+""});
        	qua++;
        	tinyMCE.getInstanceById("c1").setContent('');
        	$("#c2").attr('value', '');
        	$("#c3").attr('value', '');
		}
		else alert("No has rellenado todos los campos");
	});
	//BORRAR CONCEPTO
	$(".delconce").live("click", function(event)
	{
		event.preventDefault();
		if(confirm("¿Seguro que quieres borrar este concepto?\n\r"))
		{
			var iddell = $(this).attr("id");
			iddell = iddell.split("::");
			$.post(""+urll+"jscriptes/conceptos.php", { acc: "dell", id: ""+iddell[1]+"", factura: ""+id+""});
        	$(".cct"+iddell[1]+"").hide();
        	subtotal = parseFloat(subtotal-iddell[2]);
        	$("#totall").html(CommaFormatted(CurrencyFormatted(subtotal)));
        	$("#totall").append(" € +IVA ("+iva+"%) ");
        	subiva = (subtotal*iva)/100;
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	subiva = subtotal+subiva;
        	$("#totall").append(" € :: ");
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	$("#totall").append(" €");
		}
	});
	//EDITAR CONCEPTO
	$(".editconce").live("click", function(event)
	{
		event.preventDefault();

		var iddell = $(this).attr("id");
		iddell = iddell.split("::");
		$("#editorlineas").slideDown();
		var concepto = $(this).parents("td").siblings(".conL").html();
		var precio = $(this).parents("td").siblings(".preL").html();
		var cantidad = $(this).parents("td").siblings(".canL").html();
		var total = $(this).parents("td").siblings(".totalL").html();
		tinyMCE.activeEditor.setContent(concepto);
		precio = precio.toString();
		//LO PONEMOS EN FORMATO QUE PUEDA OPERAR (LOS PUNTOS SON LOS DECIMALES Y QUITAMOS LOS MILLARES)
		precio = precio.replace(".","");
		precio = precio.replace(",",".");
		total = total.replace(".","");
		total = total.replace(",",".");
		$("#precioE").val($.trim(precio));
		$("#cantidadE").val($.trim(cantidad));
		$("#idE").val($.trim(iddell[1]));
		$("#totalE").val($.trim(total));
	});
	/*========================================================================================================================================*/
	/*PARA LOS PRESUPUESTOS===================================================================================================================*/
	/*========================================================================================================================================*/
    //AÑADIR CONCEPTO
	$(".newconcepre").bind("click", function(event)
	{
		event.preventDefault();
		var content = tinyMCE.activeEditor.getContent(); // get the content
        $('#c1').val(content); // put it in the textarea
		if(content!="" && $("#c2").val()!="" && $("#c3").val()!="")
		{
			//var concepto = $("#newcon #c1").attr("value");
            var concepto = content;
			//var precio = $("#newcon #c2").attr("value");
            var precio = $("#newcon #c2").val();
			//var cantidad = $("#newcon #c3").attr("value");
            var cantidad = $("#newcon #c3").val();
			var total = precio*cantidad;
            //console.log(concepto+' - '+precio+' - '+cantidad+' - '+total);
        	//$(".conceptos .presusi").append('<li><table width="100%" class="cct'+qua+' conann"><tr><td width="50%" class="tdlimpio">'+concepto+'</td><td width="5%" class="tdlimpio zz">PRECIO: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(precio))+'</td><td width="5%" class="tdlimpio zz">CTD: </td><td width="5%" class="tdlimpio zy">'+cantidad+'</td><td width="5%" class="tdlimpio zz">TOT: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(total))+'</td><td width="5%" class="tdlimpio"><div id="dc::'+qua+'::'+id+'" class="delconcepre"><a title="Quitar concepto" href="">X</a></div></td></tr></table></li>');
        	$(".conceptos .presusi").append('<li><table width="100%" class="cct'+qua+' conann"><tr><td width="50%" class="tdlimpio">'+concepto+'</td><td width="5%" class="tdlimpio zz">PRECIO: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(precio))+'</td><td width="5%" class="tdlimpio zz">CTD: </td><td width="5%" class="tdlimpio zy">'+cantidad+'</td><td width="5%" class="tdlimpio zz">TOT: </td><td width="10%" class="tdlimpio zy">'+CommaFormatted(CurrencyFormatted(total))+'</td><td width="5%" class="tdlimpio"></td></tr></table></li>');
        	subtotal = parseFloat(subtotal+total);
        	$("#totall").html(CommaFormatted(CurrencyFormatted(subtotal)));
        	$("#totall").append(" € +IVA ("+iva+"%) ");
        	subiva = (subtotal*iva)/100;
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	subiva = subtotal+subiva;
        	$("#totall").append(" € :: ");
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	$("#totall").append(" €");
        	$.post(""+urll+"jscriptes/conceptospre.php", { acc: "add", tabla: "kng_conceptos", presupuesto: ""+id+"", num: ""+qua+"", concepto: ""+concepto+"", precio: ""+precio+"", cantidad: ""+cantidad+""});
        	qua++;
        	tinyMCE.getInstanceById("c1").setContent('');
        	//$("#c2").attr('value', '');
            $("#c2").val('');
        	//$("#c3").attr('value', '');
            $("#c3").val('');
		}
		else alert("No has rellenado todos los campos");
	});
	//BORRAR CONCEPTO
	$(".delconcepre").live("click", function(event)
	{
		event.preventDefault();
		if(confirm("¿Seguro que quieres borrar este concepto?\n\r"))
		{
			var iddell = $(this).attr("id");
			iddell = iddell.split("::");
			$.post(""+urll+"jscriptes/conceptospre.php", { acc: "dell", id: ""+iddell[1]+"", presupuesto: ""+id+""});
        	$(".cct"+iddell[1]+"").hide();
        	subtotal = parseFloat(subtotal-iddell[2]);
        	$("#totall").html(CommaFormatted(CurrencyFormatted(subtotal)));
        	$("#totall").append(" € +IVA ("+iva+"%) ");
        	subiva = (subtotal*iva)/100;
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	subiva = subtotal+subiva;
        	$("#totall").append(" € :: ");
        	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
        	$("#totall").append(" €");
		}
	});
	//EDITAR CONCEPTO
	$(".editconcepre").live("click", function(event)
	{
		event.preventDefault();

		var iddell = $(this).attr("id");
		iddell = iddell.split("::");
		$("#editorlineas").slideDown();
		var concepto = $(this).parents("td").siblings(".conL").html();
		var precio = $(this).parents("td").siblings(".preL").html();
		var cantidad = $(this).parents("td").siblings(".canL").html();
		var total = $(this).parents("td").siblings(".totalL").html();
		tinyMCE.activeEditor.setContent(concepto);
		precio = precio.toString();
		//LO PONEMOS EN FORMATO QUE PUEDA OPERAR (LOS PUNTOS SON LOS DECIMALES Y QUITAMOS LOS MILLARES)
		precio = precio.replace(".","");
		precio = precio.replace(",",".");
		total = total.replace(".","");
		total = total.replace(",",".");
		$("#precioE").val($.trim(precio));
		$("#cantidadE").val($.trim(cantidad));
		$("#idE").val($.trim(iddell[1]));
		$("#totalE").val($.trim(total));
	});
	/*========================================================================================================================================*/
	/*GENERAL=================================================================================================================================*/
	/*========================================================================================================================================*/
	//CERRAR EL EDITOR DE LIENAS
	$("#editorlineas .cerrar").live("click", function(event){
		$("#editorlineas").slideUp();
	});
	//AL GUARDAR EL EDITOR DE LINEAS
	$("#editorlineas .modificar").live("click", function(event){
		event.preventDefault();
		idE = $("#idE").val();
		precio = $("#precioE").val();
		cantidad = $("#cantidadE").val();
		total = $("#totalE").val();
		concepto = tinyMCE.activeEditor.getContent();

		$.post(""+urll+"jscriptes/conceptos.php", { acc: "edit", id: ""+idE+"", concepto: ""+concepto+"", precio: ""+precio+"", cantidad: ""+cantidad+""});
		$.post(""+urll+"jscriptes/conceptospre.php", { acc: "edit", id: ""+idE+"", concepto: ""+concepto+"", precio: ""+precio+"", cantidad: ""+cantidad+""});

    	subtotal = parseFloat(subtotal-total);
    	subtotal = parseFloat(subtotal+(precio*cantidad));

    	$("#totall").html(CommaFormatted(CurrencyFormatted(subtotal)));
    	$("#totall").append(" € +IVA ("+iva+"%) ");
    	subiva = (subtotal*iva)/100;
    	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
    	subiva = subtotal+subiva;
    	$("#totall").append(" € :: ");
    	$("#totall").append(CommaFormatted(CurrencyFormatted(subiva)));
    	$("#totall").append(" €");

    	$("#concepto-"+idE+" .conL").html(concepto);
		$("#concepto-"+idE+" .preL").html(CommaFormatted(CurrencyFormatted(precio)));
    	$("#concepto-"+idE+" .canL").html(cantidad);
		$("#concepto-"+idE+" .totalL").html(CommaFormatted(CurrencyFormatted(precio*cantidad)));

		$("#editorlineas").slideUp();
	});
    //PARA HACER ORDENABLES LOS CONCEPTOS
    $("#conceptitos").sortable({
        axis: 'y',
        stop: function( event, ui )
        {
			var data = $(this).sortable('serialize');
			$.ajax(
			{
				data: data,
				type: 'POST',
				url: urll+"jscriptes/ordenarConceptos.php"
            });
        }
    });
    $( ".presusi" ).disableSelection();
});
