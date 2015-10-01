<?php
include ("../kengo/config/config.php");
/*$colorprimario = '#A2C931';
$colordia = "#C3D48F";*/
/*** set the content type header ***/
header("Content-type: text/css");
?>
#calendarDiv{
	position:absolute;
	width:205px;
	border:3px solid <?php echo $colorprimario; ?>;
	padding:1px;
	background-color: #FFFFFF;
	padding-bottom:20px;
	visibility:hidden;
    	color: Black;
    	-moz-border-radius: 5px;
    	-moz-box-shadow: 0px 0px 10px #000000;
    	text-shadow: none;
}

#calendarDiv span,#calendarDiv img{
	float:left;
}

#calendarDiv .selectBox,#calendarDiv .selectBoxOver{
	line-height:12px;
	padding:1px;
	cursor:pointer;
	padding-left:2px;
}

#calendarDiv .selectBoxTime,#calendarDiv .selectBoxTimeOver{	
	line-height:12px;
	padding:1px;
	cursor:pointer;
	padding-left:2px;
}

#calendarDiv td{
	padding:3px;
    	width: 15px;
    	height: 15px;
    	text-align: center;
	margin:0px;
	font-size:10px;
    	cursor:pointer;
    	border: none
}

#calendarDiv td:hover {
  	background-color: <?php echo $colordia; ?>;
  	font-weight: bold;
}

#calendarDiv .selectBox{
	color: #333333;
	position:relative;
}

#calendarDiv .selectBoxOver{
	position:relative;
}

#calendarDiv .selectBoxTime{
	color: #333333;
	position:relative;
}

#calendarDiv .selectBoxTimeOver{
	color: #000000;
	position:relative;
}

#calendarDiv .topBar{
	height:16px;
	padding:2px;
	border-bottom: 1px solid <?php echo $colorprimario; ?>;
}

#calendarDiv .activeDay{
    	border: 1px solid <?php echo $colorprimario; ?>;
    	background-color: <?php echo $colordia; ?>;
    	font-weight: bold;
    	color: #FFFFFF;
}

#calendarDiv .todaysDate{
	padding:2px;
	text-align:center;
	position:absolute;
	bottom:0px;
	width:201px;
    	border-top: 1px solid <?php echo $colorprimario; ?>;
    	margin
}

#calendarDiv .todaysDate div{
	float:left;
}
	
#calendarDiv .timeBar{
	height:17px;
	line-height:17px;
	background-color: #F5A7FE;
	width:72px;
	color:#FFF;
	position:absolute;
	right:0px;
}

#calendarDiv .timeBar div{
	float:left;
	margin-right:1px;
}

#calendarDiv .monthYearPicker{
	background-color: #FFFFFF;
    	-moz-box-shadow: 0px 0px 10px #000000;
    	-webkit-box-shadow: 0px 0px 10px #000000;
    	box-shadow: 0px 0px 10px #000000;
	border:1px solid <?php echo $colorprimario; ?>;
	position:absolute;
	color: #333333;
	left:0px;
	top:15px;
	z-index:1000;
	display:none;
}

#calendarDiv #monthSelect{
	width:70px;
}

#calendarDiv .monthYearPicker div{
	float:none;
	clear:both;	
	padding:1px;
	margin:1px;	
	cursor:pointer;
}

#calendarDiv .monthYearActive{
	background-color:<?php echo $colorprimario; ?> !important;
	color: #FFFFFF !important;
}

#calendarDiv .topBar img{
	cursor:pointer;
}

#calendarDiv .topBar div{
	float:left;
	margin-right:1px;	
}

.calendar_week_row td{
	border-bottom: 1px solid <?php echo $colorprimario; ?> !important;
	-moz-border-radius: 0px !important;
	-webkit-border-radius: 0px !important;
	border-radius: 0px !important;
}

.calendar_week_row td:hover{
	background-color: transparent !important;
	font-weight: normal !important;	
}