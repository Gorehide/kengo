<!-- CALENDARIO -->
<script type="text/javascript" src="<?php echo BASEURLX; ?>dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script>
<link rel="stylesheet" href="<?php echo BASEURLX; ?>dhtmlgoodies_calendar/dhtmlgoodies_calendar_css.php" type="text/css" media="screen" />
<script>
	$(document).ready(function()
	{
		$(function()
		{
  			$("ol.presusi").sortable(
  			{
  				group: 'serialization',
				pullPlaceholder: false,
				// animation on drop
		  		onDrop: function  (item, targetContainer, _super)
		  		{
		    		var clonedItem = $('<li/>').css({height: 500})
		    		item.before(clonedItem)
		    		clonedItem.animate({'height': item.height()})
		    	    item.animate(clonedItem.position(), function()
		    	    {
		      			clonedItem.detach()
		      			_super(item)
		    		})
		  		}
  			});
		})
	});
</script>
