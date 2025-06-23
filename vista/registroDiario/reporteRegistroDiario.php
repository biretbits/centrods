<?php
//PARA MOSTRAR IMAGENES extension=gd SE DEBE HABILITAR ESTO extension=gd Y ESO SE DEBE REALIZAR EN XAMPP SI SE ESTA TRABAJANDO CON XAMMP PARA PPHP
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

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Report Box</title>
    <style media="screen">

    </style>
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
        width: 30px;
      }
      table td:nth-child(2) {
        text-align: center;
        width: 60px;
      }
      table td:nth-child(3) {
        width: 30px;
      }
      table td:nth-child(4) {
        width: 80px;
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

  </head>
  <body>
      <div align='center'>
          <font class="subtitulo"><b>REGISTRO DIARIO</b></font><br>
          <font class="subtitulo3">
          Llallagua, <?php
              list($año1, $mes1, $dia1) = explode('-', $fechai);
              list($año2, $mes2, $dia2) = explode('-', $fechaf);
              if ($fechai == $fechaf) {
                  echo $dia1 . " de " . mesEnTexto($mes1) . " " . $año1;
              } else {
                  echo "$dia1 de " . mesEnTexto($mes1) . " $año1 al $dia2 de " . mesEnTexto($mes2) . " $año2";
              }
          ?>
          </font>
      </div>
      <br>

      <table>
          <thead>
              <tr>
                  <th>N°</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Nombre y Apellidos</th>
                  <th>Fecha de Nacimiento</th>
                  <th>Edad</th>
                  <th>Dirección</th>
                  <th>Servicio</th>
                  <th>Signos y Síntomas</th>
                  <th>Personal que atiende</th>
                  <th>Historial Clínica</th>
                  <th>Responsable de Admisión</th>
                  <th>Fecha de Retorno</th>
              </tr>
          </thead>
          <tbody>
              <?php
              if ($resul && count($resul) > 0) {
                  $i = 0;
                  foreach ($resul as $fi) {
                      echo "<tr>";
                      echo "<td>" . ($i + 1) . "</td>";
                      echo "<td>" . $fi['fecha_rd'] . "</td>";
                      echo "<td>" . $fi['hora_rd'] . "</td>";
                      echo "<td>" . $fi['nombre_usuario'] . " " . $fi['ap_usuario'] . " " . $fi['am_usuario'] . "</td>";
                      echo "<td>" . $fi['fecha_nac_usuario'] . "</td>";
                      echo "<td>" . $fi['edad_usuario'] . "</td>";
                      echo "<td>" . $fi['direccion_usuario'] . "</td>";
                      echo "<td>" . $fi['servicio_rd'] . "</td>";
                      echo "<td>" . $fi['signo_sintomas_rd'] . "</td>";
                      echo "<td>" . $fi['medico_nombre'] . "</td>";
                      echo "<td>" . $fi['historial_clinico_rd'] . "</td>";
                      echo "<td>" . $fi['admision_nombre'] . "</td>";
                      echo "<td>" . (($fi['fecha_retorno_historia_rd'] == '0000-00-00' || $fi['fecha_retorno_historia_rd'] == '') ? '' : $fi['fecha_retorno_historia_rd']) . "</td>";
                      echo "</tr>";
                      $i++;
                  }
              } else {
                  echo "<tr><td colspan='13' align='center'>No se encontraron resultados</td></tr>";
              }
              ?>
          </tbody>
      </table>
  </body>
  </html>

  <?php
  // Obtener el HTML generado
  $html = ob_get_clean();

  // Incluir Dompdf
  require_once '../librerias/dompdf/autoload.inc.php';
  use Dompdf\Dompdf;

  // Crear instancia
  $dompdf = new Dompdf();

  // Configurar opciones
  $options = $dompdf->getOptions();
  $options->set('isRemoteEnabled', true);
  $options->setIsHtml5ParserEnabled(true);
  $dompdf->setOptions($options);

  // Cargar HTML y renderizar
  $dompdf->loadHtml($html);
  $dompdf->setPaper('letter');
  $dompdf->render();

  // Mostrar en el navegador (Attachment: false = mostrar en línea)
  $dompdf->stream("reporte.pdf", ["Attachment" => false]);
  ?>
