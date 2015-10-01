$("document").ready(function(){
	$('#colorpickerHolder').ColorPicker({flat: true});
	$('#colorpickerField1').ColorPicker(
	{
		onSubmit: function(hsb, hex, rgb, el)
		{
			$(el).val(hex);
			$(el).ColorPickerHide();
			$(el).css("background-color", "#"+hex+"");
			$(el).css("color", "#"+hex+"");
			//alert(hex);
		},
		onBeforeShow: function ()
		{
			$(this).ColorPickerSetColor(this.value);
		}
	}).bind('keyup', function()
	{
		$(this).ColorPickerSetColor(this.value);
	});
});

