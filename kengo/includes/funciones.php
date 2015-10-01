<?php
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
PARA REESCRIBIR LAS URLs ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
//GESTOR
function enlazar($cargar = "inicio")
{
    return BASEURL.$cargar.".html";
}
//PARTE PUBLICA
function enlazarx($cargar = "inicio")
{
    return BASEURLX.$cargar.".html";
}
//+IVA :: SUMA EL IVA A AUNA CANTIDAD DADA
function iva2($valor) {
	$precio = $valor + (($valor*18)/100);
	return $precio;
}
function ivafecha($fecha)
{
	$ivaf = "18";
	if($fecha>="2012-09-01") $ivaf = "21";
	//if($fecha>="2012-07-10") $ivaf = "21";
	return $ivaf;
}
function iva($valor, $fecha)
{
	$ivaf = ivafecha($fecha);
	$precio = $valor + (($valor*$ivaf)/100);
  	return $precio;	
}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
TEXTO ALEATORIO :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/**
function texto_aleatorio (integer $long = 5, boolean $lestras_min = true, boolean $letras_max = true, boolean $num = true))
Permite generar contrasenhas de manera aleatoria.
@$long: Especifica la longitud de la contrasenha
@$letras_min: Podra usar letas en minusculas
@$letras_max: Podra usar letas en mayusculas
@$num: Podra usar numeros
return string
*/
function texto_aleatorio ($long = 8, $letras_min = true, $letras_max = true, $num = true)
{
    $salt = $letras_min?'abchefghknpqrstuvwxyz':'';
    $salt .= $letras_max?'ACDEFHKNPRSTUVWXYZ':'';
    $salt .= $num?(strlen($salt)?'2345679':'0123456789'):'';
    if (strlen($salt) == 0)
    {
      return '';
    }
    $i = 0;
    $str = '';
    srand((double)microtime()*1000000);
    while ($i < $long)
    {
        $num = rand(0, strlen($salt)-1);
        $str .= substr($salt, $num, 1);
        $i++;
    }
    return $str;
}

//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Funcion cortar texto sin que corte palabras a medias																				
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

/*$cadena= la variable que contiene el texto completo
$limite =la cantidad de caracteres que queremos extraer de $cadena
$corte = el simbolo, o letra hasta la cual queremos que busque para no cortar ninguna palabra
$pad = lo que queremos que agregue a continuacon del extracto */

function recortar_texto($cadena, $limite, $corte=".", $pad="...") 
{ 
	if(strlen($cadena) <= $limite) 
		return $cadena; 
	if(false !== ($point = strpos($cadena, $corte, $limite))) 
	{ 
		if($point < strlen($cadena) - 1) 
			{ $cadena = substr($cadena, 0, $point) . $pad; } 
	} 
	return $cadena; 
}

/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
BORRAR DIRECTORIO NO VACIO ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function borrardirectorio($dirname) {
   if (is_dir($dirname)) {    //Operate on dirs only
       $result=array();
       if (substr($dirname,-1)!='/') {$dirname.='/';}    //Append slash if necessary
       $handle = opendir($dirname);
       while (false !== ($file = readdir($handle))) {
           if ($file!='.' && $file!= '..') {    //Ignore . and ..
               $path = $dirname.$file;
               if (is_dir($path)) {    //Recurse if subdir, Delete if file
                   $result=array_merge($result,rmdirtree($path));
               }else{
                   unlink($path);
                   $result[].=$path;
               }
           }
       }
       closedir($handle);
       rmdir($dirname);    //Remove dir
       $result[].=$dirname;
       return $result;    //Return array of deleted items
   }else{
       return false;    //Return false if attempting to operate on a file
   }
}

////////////////////////////////////////////////////
//Convierte fecha con hora de mysql a normal
////////////////////////////////////////////////////

function cambiafh_a_normal($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]." ".$mifecha[4].":".$mifecha[5].":".$mifecha[5];
    return $lafecha;
}
////////////////////////////////////////////////////
//Convierte fecha de mysql a normal
////////////////////////////////////////////////////

function cambiaf_a_normal($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

////////////////////////////////////////////////////
//Convierte fecha de normal a mysql
////////////////////////////////////////////////////

function cambiaf_a_mysql($fecha){
    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}





/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
FORMATO FECHAS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function fechaes($fecha)
{
    return implode("-", array_reverse( preg_split("/\D/", $fecha) ) );
}

function fechalarga()
{
    if (!isset($_GET['arg1'])) $idioma = "es";
    else $idioma = $_GET['arg1'];
    if ($idioma == "es")
    {
      return dia().", ".date("j")." de ".mes()." de ".date("Y");
    }
    if ($idioma == "eus")
    {
      return dia().", ".date("Y").".-eko ".mes()."k  ".date("j");
    }
}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
MES :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function mes()
{
    if (!isset($_GET['arg1'])) $idioma = "es";
    else $idioma = $_GET['arg1'];
    $mes = date("m");
    if ($idioma=="es")
    {
        switch($mes)
        {
        	case 1: $mesn = "Enero"; break;
        	case 2: $mesn = "Febrero"; break;
        	case 3: $mesn = "Marzo"; break;
        	case 4: $mesn = "Abril"; break;
        	case 5: $mesn = "Mayo"; break;
        	case 6: $mesn = "Junio"; break;
        	case 7: $mesn = "Julio"; break;
            case 8: $mesn = "Agosto"; break;
            case 9: $mesn = "Septiembre"; break;
            case 10: $mesn = "Octubre"; break;
            case 11: $mesn = "Noviembre"; break;
            case 12: $mesn = "Diciembre"; break;
        }
    }
    else if ($idioma=="eus")
    {
        switch($mes)
        {
        	case 1: $mesn = "Urtarrila"; break;
        	case 2: $mesn = "Otsaila"; break;
        	case 3: $mesn = "Martxoa"; break;
        	case 4: $mesn = "Apirila"; break;
        	case 5: $mesn = "Maiatza"; break;
        	case 6: $mesn = "Ekaina"; break;
        	case 7: $mesn = "Uztaila"; break;
            case 8: $mesn = "Abuztua"; break;
            case 9: $mesn = "Iraila"; break;
            case 10: $mesn = "Urria"; break;
            case 11: $mesn = "Azaroa"; break;
            case 12: $mesn = "Abendua"; break;
        }
    }
    return $mesn ;
}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
DIA DE LA SEMANA ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function dia()
{
    if (!isset($_GET['arg1'])) $idioma = "es";
    else $idioma = $_GET['arg1'];
    $dia = date("w");
    if ($idioma=="es")
    {
        switch($dia)
        {
        	case 1: $dian = "Lunes"; break;
        	case 2: $dian = "Martes"; break;
        	case 3: $dian = "Mi&eacute;rcoles"; break;
        	case 4: $dian = "Jueves"; break;
        	case 5: $dian = "Viernes"; break;
        	case 6: $dian = "S&aacute;bado"; break;
        	case 0: $dian = "Domingo"; break;
        }
    }
    else if ($idioma=="eus")
    {
        switch($dia)
        {
        	case 1: $dian = "Astelehena"; break;
        	case 2: $dian = "Asteartea"; break;
        	case 3: $dian = "Asteazkena"; break;
        	case 4: $dian = "Osteguna"; break;
        	case 5: $dian = "Ostirala"; break;
        	case 6: $dian = "Larunbata"; break;
        	case 0: $dian = "Lgandea"; break;
        }
    }
    return $dian ;
}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
QUITAR TILDES :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function sintildes($texto)
{
    return strtr(utf8_decode($texto), "????????????", "aeiouAEIOUnN");
}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
SUBIR ARCHIVOS NEW ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function subir_archivo_new($archivo,$ruta,$nombre)
{
        if(is_uploaded_file($archivo))
        {
      	    $destino=$ruta.$nombre;
      	    move_uploaded_file($archivo,$destino);
            chmod($destino,0777);
            return true;
        }
        else
        {
                return "El archivo: ".$nombre." no ha subido con exito.";
        }

}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
SUBIR ARCHIVOS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function subir_archivo($archivo,$archivo1, $ruta,$nombre,$tipo)
{
    if (strpos($archivo1,$tipo) === false)
	{
		return "El archivo no es del tipo deseado: ".$tipo.".";
	}
	else
	{
        if(is_uploaded_file($archivo))
        {
      	    $destino=$ruta.$nombre;
      	    move_uploaded_file($archivo,$destino);
            chmod($destino,0777);
            return true;
        }
        else
        {
			return "El archivo: ".$tipo." no ha subido con exito.";
        }
	}

}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
COMPROBAR EMAIL :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function comprobar_email($email)
{
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminaci?n del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
REDIMENSIONAR IMAGENES ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/**
  * Image Resizer.
* @author : Harish Chauhan
* @copyright : Freeware
* About :This PHP script will resize the given image and can show on the fly or save as image file.*/
	define("HAR_AUTO_NAME",1);
	Class RESIZEIMAGE
	{
		var $imgFile="";
		var $imgWidth=0;
		var $imgHeight=0;
		var $imgType="";
		var $imgAttr="";
		var $type=NULL;
		var $_img=NULL;
		var $_error="";
/**
* Constructor
* @param [String $imgFile] Image File Name
* @return RESIZEIMAGE (Class Object)*/
		function RESIZEIMAGE($imgFile="")
		{
			if (!function_exists("imagecreate"))
			{
				$this->_error="Error: GD Library is not available.";
				return false;
			}

			$this->type=Array(1 => 'GIF', 2 => 'JPG', 3 => 'PNG', 4 => 'SWF', 5 => 'PSD', 6 => 'BMP', 7 => 'TIFF', 8 => 'TIFF', 9 => 'JPC', 10 => 'JP2', 11 => 'JPX', 12 => 'JB2', 13 => 'SWC', 14 => 'IFF', 15 => 'WBMP', 16 => 'XBM');
			if(!empty($imgFile))
				$this->setImage($imgFile);
		}
/**
* Error occured while resizing the image.
* @return String*/
		function error()
		{
			return $this->_error;
		}
/**
* Set image file name
* @param String $imgFile
* @return void*/
		function setImage($imgFile)
		{
			$this->imgFile=$imgFile;
			return $this->_createImage();
		}
/**
* @return void*/
		function close()
		{
			return @imagedestroy($this->_img);
		}
/**
* Resize a image to given width and height and keep it's current width and height ratio
* @param Number $imgwidth
* @param Numnber $imgheight
* @param String $newfile*/
		function resize_limitwh($imgwidth,$imgheight,$newfile=NULL)
		{
			list($width, $height, $type, $attr) = @getimagesize($this->imgFile);
			if($width > $imgwidth)
				$image_per = floor(($imgwidth * 100) / $width);

			if(floor(($height * $image_per)/100)>$imgheight)
				$image_per = floor(($imgheight * 100) / $height);

			$this->resize_percentage($image_per,$newfile);

		}
/**
* Resize an image to given percentage.
* @param Number $percent
* @param String $newfile
* @return Boolean*/
		function resize_percentage($percent=100,$newfile=NULL)
		{
			$newWidth=($this->imgWidth*$percent)/100;
			$newHeight=($this->imgHeight*$percent)/100;
			return $this->resize($newWidth,$newHeight,$newfile);
		}
/**
* Resize an image to given X and Y percentage.
* @param Number $xpercent
* @param Number $ypercent
* @param String $newfile
* @return Boolean*/
		function resize_xypercentage($xpercent=100,$ypercent=100,$newfile=NULL)
		{
			$newWidth=($this->imgWidth*$xpercent)/100;
			$newHeight=($this->imgHeight*$ypercent)/100;
			return $this->resize($newWidth,$newHeight,$newfile);
		}
/**
* Resize an image to given width and height
* @param Number $width
* @param Number $height
* @param String $newfile
* @return Boolean*/
		function resize($width,$height,$newfile=NULL)
		{
			if(empty($this->imgFile))
			{
				$this->_error="File name is not initialised.";
				return false;
			}
			if($this->imgWidth<=0 || $this->imgHeight<=0)
			{
				$this->_error="Could not resize given image";
				return false;
			}
			if($width<=0)
				$width=$this->imgWidth;
			if($height<=0)
				$height=$this->imgHeight;
    		return $this->_resize($width,$height,$newfile);
		}
/**
* Get the image attributes
* @access Private*/
		function _getImageInfo()
		{
			@list($this->imgWidth,$this->imgHeight,$type,$this->imgAttr)=@getimagesize($this->imgFile);
			$this->imgType=$this->type[$type];
		}
/**
* Create the image resource
* @access Private
* @return Boolean*/
		function _createImage()
		{
			$this->_getImageInfo($imgFile);
			if($this->imgType=='GIF')
			{
				$this->_img=@imagecreatefromgif($this->imgFile);
			}
			elseif($this->imgType=='JPG')
			{
				$this->_img=@imagecreatefromjpeg($this->imgFile);
			}
			elseif($this->imgType=='PNG')
			{
				$this->_img=@imagecreatefrompng($this->imgFile);
			}
			if(!$this->_img || !@is_resource($this->_img))
			{
				$this->_error="Error loading ".$this->imgFile;
				return false;
			}
			return true;
		}
/**
* Function is used to resize the image
* @access Private
* @param Number $width
* @param Number $height
* @param String $newfile
* @return Boolean*/
		function _resize($width,$height,$newfile=NULL)
		{
			if (!function_exists("imagecreate"))
			{
				$this->_error="Error: GD Library is not available.";
				return false;
			}

			$newimg=@imagecreatetruecolor($width,$height);
			@imagecopyresampled ( $newimg, $this->_img, 0,0,0,0, $width, $height, $this->imgWidth,$this->imgHeight);
			if($newfile===HAR_AUTO_NAME)
			{
				if(@preg_match("/\..*+$/",@basename($this->imgFile),$matches))
			   		$newfile=@substr_replace($this->imgFile,"_har",-@strlen($matches[0]),0);
			}
			elseif(!empty($newfile))
			{
				if(!@preg_match("/\..*+$/",@basename($newfile)))
				{
					if(@preg_match("/\..*+$/",@basename($this->imgFile),$matches))
					   $newfile=$newfile.$matches[0];
				}
			}

			if($this->imgType=='GIF')
			{
				if(!empty($newfile))
					@imagegif($newimg,$newfile);
				else
				{
					@header("Content-type: image/gif");
					@imagegif($newimg);
				}
			}
			elseif($this->imgType=='JPG')
			{
				if(!empty($newfile))
					@imagejpeg($newimg,$newfile);
				else
				{
					@header("Content-type: image/jpeg");
					@imagejpeg($newimg);
				}
			}
			elseif($this->imgType=='PNG')
			{
				if(!empty($newfile))
					@imagepng($newimg,$newfile);
				else
				{
					@header("Content-type: image/png");
					@imagepng($newimg);
				}
			}
			@imagedestroy($newimg);
		}
	}
/*:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
DEVOLVER DESCRIPCION ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function descripcion($tabla, $campoid, $valorid, $campo)
{
    $sql = "SELECT ".$campo." FROM ".$tabla." WHERE ".$campoid." = ".$valorid." ";
    $res=mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($res);
    return $row[$campo];
}
?>
