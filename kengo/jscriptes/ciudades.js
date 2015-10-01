$(document).ready(function()
{
	var urll = $("#urll").attr('class');
	$("#provincia").bind("change",function()
	{
		var cual = $("#provincia option:selected").val(); 
		//var optionis = $.get(urll+"jscriptes/ciudades.php", { id: cual} );
		//$("#ciudad").html('<select name="ciudad" style="width: 98%;">');
		//alert(optionis);
		//$("#ciudad").append(optionis);
		//$("#ciudad").append('</select>');
		$("#ciudad").load(urll+"jscriptes/ciudades.php?id="+cual+"");
	});
});