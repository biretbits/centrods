<?php
ob_end_clean();
// Iniciar el almacenamiento en búfer de salida
ob_start();

// Verificar que no haya salida antes de las cabeceras
// Generar el contenido del PDF aquí

// Ajustar las cabeceras
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="reporte.pdf"');

  include("../librerias/globales.php");
 //echo $fechai."fi   ".$fechaf."ff   ".$buscar."b   ".$pagina."p   ".$listarDeCuanto."ldc" ; ?>
<style media="screen">
table {
    border-collapse: collapse;
    width: 100%;
    font-family: Arial, sans-serif;
    font-size: 14px;
    text-align: left;
  }

  table th {
    border: 1px solid black;
    font-size: 10px;
  }
  table td {
    padding: 1px;
    border: 1px solid black;
    font-size: 11px; /* Ajusta el ancho máximo de la celda según tus necesidades */

  }
  table td:nth-child(1) {
    text-align: center;
    width: 10px;
  }
  table td:nth-child(2) {
    text-align: center;
    width: 40px;
  }
  table td:nth-child(3) {
    width: 90px;
  }
  table td:nth-child(4) {
    width: 125px;
  }
  table td:nth-child(10) {
    width: 80px;
  }
  table td:nth-child(13) {
    width: 65px;
  }

  table th {
    background-color: #f2f2f2;
    font-weight: bold;
    color: #444;
  }

  table tr:hover {
    background-color: #ddd;
  }
  thead {
  page-break-before: always;
  page-break-inside: avoid;
}
th:last-child {
  page-break-after: avoid;
}
td,th{
  text-align: center
}

    .tituloU{
      font-size: 28px;
      font: serif
    }
    .subtitulo{
      font-size: 20px;
    }
    .subtitulo2{
      font-size: 16px;
    }
    .subtitulo3{
      font-size: 15px;
    }
    .subtitulo4{
      font-size: 13px;
    }
    .reciboTitulo{
      font-size: 35px;
    }
    .reciboTitulo b{
       padding-bottom: -40px;
       border-bottom: 1px solid black;
    }
    .fila{
      width:65%;
      height: 15%;
      background-color:red;

    }

     .linea{
       display: inline-block;
     }
</style>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Report Box</title>
    <style media="screen">

    </style>
  </head>
  <body>
    <?php
     ?>
    <div class="">
          <div   style='width:100%;' align='center'>

            <font class="subtitulo"><b>ENTRADA DE PRODUCTOS FARMACEUTICOS</b></font><br>

            <font class="subtitulo3">Llallagua , <?php
            list($año1, $mes1, $dia1) = explode('-', $fechai);
            list($año2, $mes2, $dia2) = explode('-', $fechaf);
            if($fechai == $fechaf){
              echo $dia1." de ".mesEnTexto($mes1)." ".$año1;
            }else{
              echo "".$dia1." de ".mesEnTexto($mes1)." ".$año1." al ".$dia2." de ".mesEnTexto($mes2)." ".$año2;
            }
            ?>
          </font>
          </div>
          <br>
      </div>
        <div style="clear:both;"></div>
        <table>
            <thead style="display: table-row-group;">
              <tr>
                <th>N°</th>
                <th>Codigo</th>
                <th>Nombre Generico</th>
                <th>Forma presentación</th>
                <th>Concentración unidad medida</th>
                <th>Cantidad</th>
                <th>vencimiento</th>
                <th>Fecha</th>
                <th>Estado producto</th>
                <th>Encargado</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($resul &&count($resul) > 0) {
                $i = 1;
                foreach ($resul as $fi){
                    echo "<tr>";
                      echo "<td>".($i)."</td>";
                      echo "<td>".$fi['codigo']."</td>";
                      echo "<td>".$fi['nombre']."</td>";

                      $forma = $fi['nombre_forma'];
                      $formaa = "";
                      echo "<td>";
                      foreach ($forma as $form) {
                        echo $form["nombre_forma"];
                        $formaa=$form["nombre_forma"];
                      }
                      echo "</td>";
                      $concentracion = $fi['concentracion'];
                      $concentra = "";
                      echo "<td>";
                      foreach ($concentracion as $conc) {
                        echo $conc["concentracion"];
                        $concentra =$conc['concentracion'];
                      }
                      echo "</td>";

                      echo "<td>".$fi['cantidad']."</td>";
                      echo "<td>".$fi['vencimiento']."</td>";
                      echo "<td>".$fi['fecha']."</td>";

                      if($fi['estado_producto'] == 'activo'){
                        echo "<td style='color:green;background-color:#dbffaf;text-align:center'>".$fi['estado_producto']."</td>";
                      }else if($fi['estado_producto'] == 'vencido'){
                        echo "<td style='color:red;background-color:#ffc8af;text-align:center'>".$fi['estado_producto']."</td>";
                      }
                      echo "<td>".$fi['nombre_usuario']." ".$fi["ap_usuario"]."</td>";

                      $unir = $fi['nombre']." ".$formaa." ".$concentra;
                      $enable = '';$title='Editar';
                      if($fi['estado_producto']=='vencido'){
                          $enable='disabled';
                          $title='El producto esta vencido';
                      }
                      if($fi['manipulado'] == 'si'){
                        $enable = 'disabled';
                        $title='El producto ya se uso';
                      }

                    echo "</tr>";
                    $i++;
                  }
                }else{
                  echo "<tr>";
                  echo "<td colspan='15' align='center'>No se encontraron resultados</td>";
                  echo "</tr>";
                }

                 ?>

            </tbody>
        </table>
  <style media="screen">
    /*eliminando borde izquierdo dercho y de abajo*/
    #bor{
      border-bottom: none;border-right: none; border-left: none;
    }
  </style>




  </body>

</html>

<?php
//https://parzibyte.me/blog/2019/12/25/generar-pdf-php-dompdf/ 9:00pm a 11:30pm
//https://programmerclick.com/article/89841075890/
$html=ob_get_clean();
//$html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" ...>';
//$html = file_get_contents(__DIR__ . '/hoja.php');
//echo $html;
//sudo apt-get install php7.0-mbstring
//apt-get install php7.2-xml

//require '../vendor/autoload.php';
require_once '../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

//use Dompdf\Options;//nueva
//$options=new Options();
//$options->setchroot(__DIR__);
//$options->set('isRemoteEnebled',TRUE);

$dompdf=new Dompdf();

//https://noviello.it/es/como-instalar-composer-en-ubuntu-20-04-lts/
$options=$dompdf->getOptions();
$options->set(array('isRemoteEnebled'=>true));
$dompdf->setOptions($options);
$options->setIsHtml5ParserEnabled(true);
//$dompdf->loadHtml($html);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();
$type=false;
if(!isset($_GET["id"]))
  $type=false;
$dompdf->stream("archivo_.pdf",array("Attachment"=>$type));


?>
