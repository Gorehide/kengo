<?php
  //includes
  include("../config/config.php");
  include("../includes/conectar.php");
  include("../includes/funciones.php");
  // nombre del fichero
  $filename = "facturas_sonort_".date('d_m_Y').".xls";
  //cabeceras
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv; charset=UTF-8");
  header("Content-Type: application/vnd.ms-excel");
  header("Pragma: no-cache"); 
  header("Expires: 0");
  //columnas
  $colnames = array(
    'numero' => "Nº",
    'presupuesto' => "Presupuesto",    
    'tipo' => "Tipo",
    'fecha' => "Fecha",
    'cliente' => "Cliente",
    'titulo' => "Título",
    'importe' => "Importe",
    'iva' => "IVA",
    'total' => "TOTAL"  
  );
  //SQL QUE PILLAMSO DE LA URL
  $sql = base64_decode($_GET['q']);
  $res = mysql_query($sql);
  $tabla = "<table>";
  $tabla .= "<tr>";
  foreach ($colnames as $col)
  {
    $tabla .= "<th>".$col."</th>";
  }
  $tabla .= "</tr>";
  
  while($row = mysql_fetch_array($res))
  {
    $numi = "";
    $largura = strlen($row['numero']);
    for($xz=$largura; $xz<5; $xz++) $numi .="0";
    $numi = 'SN_'.$numi.$row['numero'].'/'.substr($row['fecha'], 0, 4);

    $sqlc = "SELECT precio, cantidad
    FROM kng_conceptos
    WHERE factura = '".$row['faid']."'
    ";
    $resc= mysql_query($sqlc);
    $tutti = 0;
    while($rowc=mysql_fetch_array($resc))
    {
      $tutti += ($rowc['precio']*$rowc['cantidad']);
    }    

    $tabla .="<tr>";
      $tabla .="<td>".$numi."</td>";
      $tabla .="<td>".$row['presupuesto']."</td>";      
      $tabla .="<td>".$row['titipo']."</td>";
      $tabla .="<td>".fechaes($row['fecha'])."</td>";
      $tabla .="<td>".$row['nombre']."</td>";      
      $tabla .="<td>".$row['titulo']."</td>";
      $tabla .="<td>".number_format($tutti, 2, ',', '.')."</td>";
      $tabla .="<td>".ivafecha($row['fecha'])."%</td>";
      $tabla .="<td>".number_format(iva($tutti, $row['fecha']), 2, ',', '.')."</td>";
      
      
      
    $tabla .="</tr>";
  }
  
  $tabla .= "</table>";
  echo $tabla;
  exit;
?>