<?php
/*** set the content type header ***/
header("Content-type: text/css");
?>

/*MENU*/

.menu {
  width: 256px;
  float: left;
  -moz-border-radius: 0px 0px 10px 0px;
  -webkit-border-radius: 0px 0px 10px 0px;
  background-color: #333333;
  position: fixed;
  top: 76px;
  z-index: 9;
  border-bottom: 1px solid #000000;
  border-right: 1px solid #000000;
}

.menutop {
  height: 15px;
  font-size: 12px;
  padding: 9px 0px;
  text-indent: 10px;
}

.menubotontit {
  padding: 10px 5px;
  background-color: #333333;
  color: #FFFFFF;
  text-shadow: 1px 1px 0px #111111;
  font-weight: bold;
  letter-spacing: 5px;
  background-repeat: no-repeat;
  background-position: 10px center;
  padding-left: 50px;
}

.menuboton {
  background-color: #9D9D9D;
  border-bottom: 1px solid #333333;
  border-top: 1px solid #CCCCCC;
  text-shadow: #CCCCCC 1px 1px 0px;
  background-repeat: no-repeat;
  background-position: 10px 4px;
}

.mb2 {
  padding-left: 10px;
  background-color: #C0C0C0;
}

.mb3 {
  padding-left: 10px;
  background-color: #E4E4E4;
}

.mb4 {
  padding-left: 10px;
  background-color: #FFFFFF;
}

.mb5 {
  padding-left: 10px;
  background-color: #DCE1FF;
}

.mb6 {
  padding-left: 10px;
  background-color: #B1BDFF;
}

.mb7 {
  padding-left: 10px;
  background-color: #8093FF;
}

.menuboton a {
  padding: 5px 5px 5px 30px;
  display: block;
}

.menuboton:hover {
  background-color: #666666;
  color: #FFFFFF;
  background-position: 10px -17px;
}

.menuboton:hover a {
  color: #FFFFFF;
  text-shadow: -1px -1px 0px #333333;
}

.menubotonsel {
  background-color: <?php echo $colorbase; ?>;
  border-bottom: 1px solid #333333;
  border-top: 1px solid #CCCCCC;
  background-repeat: no-repeat;
  background-position: 10px -17px;
}

.menubotonsel a {
  color: #FFFFFF;
  padding: 5px 5px 5px 30px;
  display: block;
  text-shadow: -1px -1px 0px #333333;
}

.menubottom {
  height: 32px;
}

.oculto {
  display: none;
}

.sele {
  cursor: copy;
  float: left;
  margin-top: 3px;
}