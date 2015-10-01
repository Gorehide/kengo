<title><?php echo $k_cliente; ?> :: Kengo CMS v<?php echo $k_version; ?></title>
<!-- METAS -->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="title" content="<?php echo $k_cliente; ?> :: Kengo CMS v<?php echo $k_version; ?>" />
<meta name="description" content="<?php echo $k_description; ?>" />
<meta name="keywords" content="<?php echo $k_keywords; ?>" />
<meta name="robots" content="all" />
<meta name="language" content="es" />
<meta name="author" content="Gorehide" />
<meta name="Copyright" content="Bikuma Global Services" />
<link rel="Index" href="index.html" />
<link rel="shortcut icon" href="<?php echo BASEURL; ?>imagenes/favicon.png" />
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>css/cssreset.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>css/kengocss.php">

<!-- JAVASCRIPT -->
<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-1.4.4.min.js" type="text/javascript"></script>
<!-- JQUERY UI -->
<script src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js" type="text/javascript"></script>
<!-- NUMEROS -->
<script src="<?php echo BASEURL; ?>jscriptes/numeros.js" type="text/javascript"></script>
<!-- AJAX RAPIDOS -->
<script src="<?php echo BASEURL; ?>jscriptes/ajax_rapidos.js" type="text/javascript"></script>
<!-- MENU -->
<script src="<?php echo BASEURL; ?>jscriptes/menu.js" type="text/javascript"></script>
<!-- OCULTAR -->
<script src="<?php echo BASEURL; ?>jscriptes/ocultar.js" type="text/javascript"></script>
<!-- CONCEPTOS -->
<script src="<?php echo BASEURL; ?>jscriptes/conceptos.js" type="text/javascript"></script>
<!-- PRESUS -->
<script src="<?php echo BASEURL; ?>jscriptes/presus.js" type="text/javascript"></script>
<!-- LIBRERIAS -->
<!-- SHADOWBOX -->
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>jscriptes/shadowbox/shadowbox.css">
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init({
        	language:   "es",
        	players: ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv']
    	});
</script>
<!-- TAB EN TEXTAREA -->
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/jquery.textarea.js"></script>
<!-- COLOR PICKER -->
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo BASEURL; ?>css/colorpicker.css" />
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/colorpicker.js"></script>
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/color.js"></script>
<!-- INLINE EDIT -->
<!-- <script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/jquery.jeditable.js"></script> -->
<!-- TABLESORTER -->
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>css/sorter.css">
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/jquery.metadata.js"></script>
<script language="JavaScript" type="text/javascript">
	$(document).ready(function()
	{
		$("#myTable").tablesorter();
	        $("table")
	        .tablesorter({widthFixed: true, widgets: ['zebra']})
	        .tablesorterPager({container: $("#pager")});
	});
</script>
<!-- TOOLTIP -->
<script type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/easyTooltip.js"></script>
<script>
	$(document).ready(function()
	{
	 	$("a").easyTooltip();
	 	$("img").easyTooltip();
    });
</script>
<!-- TINY MCE -->
<script language="javascript" type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init(
	{
		language : "es",
		mode : "specific_textareas",
        	editor_deselector : "notiny",
		theme : "advanced",
		skin : "default",
    		inline_styles : "true",
    		dialog_type: "window",
    		document_base_url : "<?php echo BASEURLX; ?>archivos/",
 		relative_urls : false,

		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,autosave,advlist,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,imagemanager,filemanager",

		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
		theme_advanced_buttons2 : "cut,copy,pastetext,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,styleprops,attribs,template",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,|,fullscreen",
		theme_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : "none",
		theme_advanced_resizing : true,

		content_css : "<?php echo BASEURL; ?>css/editortiny.css?ver=01",
		autosave_ask_before_unload : false
	});

	tinyMCE.init({
		mode : "specific_textareas",
		editor_selector : "tinybasic",
		theme : "advanced",
		skin : "default",
        inline_styles : "true",
    	dialog_type: "window",
    	document_base_url : "<?php echo BASEURLX; ?>archivos/",
 		relative_urls : false,
 		plugins : "safari,paste,fullscreen",
 		theme_advanced_buttons1 : "undo,redo,|,pastetext,|,bold,italic,underline,forecolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,code,|,fullscreen",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
 		theme_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : "none",
		theme_advanced_resizing : true,

		content_css : "<?php echo BASEURL; ?>css/editortiny.css?ver=01",
		autosave_ask_before_unload : false
	});
</script>
<!-- [if lt IE 7.]>
	<script defer type="text/javascript" src="<?php echo BASEURL; ?>jscriptes/pngfix.js"></script>
<![endif] -->
<!-- QUITAR CUADRO DE SELECCION DE LOS LINKS (USO DE TABULADOR) -->
<script>
	function unFocusA()
    {
    	anclas=document.getElementsByTagName("a").length;
    	for (i=0;i<anclas;i++) document.getElementsByTagName("a").item(i).onfocus=new Function("if(this.blur)this.blur()")
    }
</script>
<!-- TIEMPO DE CARGA DE LA PAGINA -->
<script>
	var inicio=new Date();
    inicio=inicio.getTime();
    function ini()
    {
        fin=new Date();
        fin=fin.getTime();
        tiempo=(fin-inicio)/1000;
        $("#tmp").html(tiempo);
    }
</script>
