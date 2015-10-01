//<!-------------------------------------------------------+
//  Developed by Roshan Bhattarai
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
// -------------------------------------------------------->
$(document).ready(function()
{
	var urll = $("#urll").attr('class');
	$("#username").blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#msgbox").removeClass().addClass('messagebox').text('Comprobando...').fadeIn("slow");
		//check the username exists or not from ajax
		$.post(""+urll+"jscriptes/username.php",{ user_name:$(this).val() } ,function(data)
        	{
			if(data=='no') //if username not avaiable
		  	{
            			visii = document.getElementById("guardar");
            			visii.style.display = "none";
		  		$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
				{
			  		//add message and change the class of the box and start fading
			  		$(this).html('Ya existe un usuario con ese Nick').addClass('messageboxerror').fadeTo(900,1);
				});
          		}
		  	else
		  	{
		    		visii = document.getElementById("guardar");
            			visii.style.display = "inline";
		  		$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
				{
			  		//add message and change the class of the box and start fading
			  		$(this).html('El nick es correcto').addClass('messageboxok').fadeTo(900,1);
				});
		  	}
		});
	});
});