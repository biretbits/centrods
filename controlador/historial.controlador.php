<?php
require_once '../modelo/historial.php';
require "sesion.controlador.php";
$ins=new sesionControlador();
$ins->StarSession();
$abi = $ins->verificarSession();
if($abi!='' and $abi=='cerrar'){
  $ins->Destroy();
  $ins->Redireccionar_inicio();
}
class HistorialControlador{
	public function verTablaHistorial($paciente_rd,$cod_rd){
    $rdi =new Historial();
    $listarDeCuanto = 5;$pagina = 1;$buscar = "";$fecha = date('Y-m-d');
    $resultodoUsuarios = $rdi->SelectPorBusquedaHistorial(false,false,false,$paciente_rd,false,false);
    $num_filas_total = mysqli_num_rows($resultodoUsuarios);
    $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
            //calculamos el registro inicial
    $inicioList = ($pagina - 1) * $listarDeCuanto;
    // Verificar si la consulta devuelve resultados
    $res = $rdi->SelectPorBusquedaHistorial(false,false,false,$paciente_rd,false,false);
    $resul = $this->Uniendo($res,$rdi);
    $resul7 = $this->Uniendo($res,$rdi);
    $re = $rdi->selectNombreUsuario($paciente_rd);
    require ("../vista/historial/tablaHistorial.php");
  }
  //funciones para encontrar los nombres de los usuarios como doctor y el de admision
  function Uniendo($resul, $rdi) {
    $ar = [];
    while ($fi = mysqli_fetch_array($resul)) {
      // Añadir cada fila al array con una estructura correcta
        $entry = [
            "cod_his" => $fi["cod_his"],
            "zona_his" => $fi["zona_his"],
            "cod_rd" => $fi["cod_rd"],
            "paciente_rd" => $fi["paciente_rd"],
            "paciente_rd_nombre"=>$rdi->selectDatosUsuarios($fi["paciente_rd"]),
            "cod_cds" => $fi["cod_cds"],
            "cod_responsable_familia_his" => $fi["cod_responsable_familia_his"],
            "datos_responsable_familia" => $rdi->selectDatosUsuarios($fi["cod_responsable_familia_his"]),
            "archivo" => $fi["archivo"],
            "fecha" => $fi["fecha"],
            "hora" => $fi["hora"],
            "estado_h" => $fi["estado"]
          ];

        $ar[] = $entry; // Agregar la entrada al array principal
    }
    return $ar; // Devolver el array completo fuera del bucle
}
  /*function Uniendo($resul, $rdi) {
    $ar = [];
    while ($fi = mysqli_fetch_array($resul)) {
        // Añadir cada fila al array con una estructura correcta
        $entry = [
            "cod_usuario" => $fi["cod_usuario"],
            "ci_usuario" => $fi["ci_usuario"],
            "usuario" => $fi["usuario"],
            "nombre_usuario" => $fi["nombre_usuario"],
            "ap_usuario" => $fi["ap_usuario"],
            "am_usuario" => $fi["am_usuario"],
            "fecha_nac_usuario" => $fi["fecha_nac_usuario"],
            "edad_usuario" => $fi["edad_usuario"],
            "telefono_usuario" => $fi["telefono_usuario"],
            "direccion_usuario" => $fi["direccion_usuario"],
            "profesion_usuario" => $fi["profesion_usuario"],
            "especialidad_usuario" => $fi["especialidad_usuario"],
            "tipo_usuario" => $fi["tipo_usuario"],
            "contrasena_usuario" => $fi["contrasena_usuario"],
            "cod_cds" => $fi["cod_cds"],
            "estado_usuario" => $fi["estado"],
            "cod_rd" => $fi["cod_rd"],
            "fecha_rd" => $fi["fecha_rd"],
            "hora_rd" => $fi["hora_rd"],
            "servicio_rd" => $fi["servicio_rd"],
            "signo_sintomas_rd" => $fi["signo_sintomas_rd"],
            "historial_clinico_rd" => $fi["historial_clinico_rd"],
            "fecha_retorno_historia_rd" => $fi["fecha_retorno_historia_rd"],
            "pe_brinda_atencion_rd" => $fi["pe_brinda_atencion_rd"],
            "medico_nombre" => $rdi->selectNombreUsuario($fi["pe_brinda_atencion_rd"]),
            "resp_admision_rd" => $fi["resp_admision_rd"],
            "admision_nombre" => $rdi->selectNombreUsuario($fi["resp_admision_rd"]),
            "paciente_rd" => $fi["paciente_rd"],
            "cod_cds" => $fi["cod_cds"],
            "estado_rd" => $fi["estado"],
            "cod_his" => $fi["cod_his"],
            "zona_his" => $fi["zona_his"],
            "cod_rd" => $fi["cod_rd"],
            "paciente_rd" => $fi["paciente_rd"],
            "cod_cds" => $fi["cod_cds"],
            "cod_responsable_familia_his" => $fi["cod_responsable_familia_his"],
            "datos_responsable_familia" => $rdi->selectDatosUsuarios($fi["cod_responsable_familia_his"]),
            "estado_h" => $fi["estado"]

        ];
        $ar[] = $entry; // Agregar la entrada al array principal
    }
    return $ar; // Devolver el array completo fuera del bucle
}*/

public function registroDatosResponsablePaciente($Nombre_responsable,$ap_responsable,$am_responsable,$fecha_nacimiento_responsable,$sexo_responsable,
$ocupacion_responsable,$direccion_responsable,$telefono_resposable,$comunidad_responsable,$ci,$n_seguro,$n_carp_fam,$zona_his,$cod_usuario,$paciente_rd,
$cod_rd,$fecha_nacimiento,$sexo,$ocupacion,$fecha_de_consulta,$estado_civil,$escolaridad,$cod_historial){
  $rnp= new historial();
  //echo $cod_usuario;
  $resp = $rnp->insertarNewResponsableyPacientes($Nombre_responsable,$ap_responsable,$am_responsable,$fecha_nacimiento_responsable,$sexo_responsable,
  $ocupacion_responsable,$direccion_responsable,$telefono_resposable,$comunidad_responsable,$ci,$n_seguro,$n_carp_fam,$zona_his,$cod_usuario,$paciente_rd,
  $cod_rd,$fecha_nacimiento,$sexo,$ocupacion,$fecha_de_consulta,$estado_civil,$escolaridad,$cod_historial);
  //echo $cod_usuario;
  if($resp != ""){
      echo "correcto";
  } else{
      echo "error";
  }
}
public function buscarBDpacienteResponsable($nombre){
  $h =new Historial();
  $re = $h->buscarBDpacienteResponsablesql($nombre);
  $datos = array();
  if ($re->num_rows > 0) {
  // Recoger los resultados en un array
    while($row = $re->fetch_assoc()) {
      $datos[] = $row;
    }
      echo json_encode($datos);
  } else {
      echo json_encode([]);
  }
}

public function buscarHistorial($pagina,$listarDeCuanto,$fecha,$paciente_rd,$cod_rd){
  $rdi =new Historial();
  $resultodoUsuarios = $rdi->SelectPorBusquedaHistorial(false,false,$fecha,$paciente_rd,false,false);
  $num_filas_total = mysqli_num_rows($resultodoUsuarios);
  $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
          //calculamos el registro inicial
  $inicioList = ($pagina - 1) * $listarDeCuanto;
  // Verificar si la consulta devuelve resultados
  $res = $rdi->SelectPorBusquedaHistorial($inicioList,$listarDeCuanto,$fecha,$paciente_rd,false,false);
  $resul = $this->Uniendo($res,$rdi);
  echo "<div class='row'>
    <div class='col'>
      <div class='table-responsive'>
      <table class='table'>
        <thead style='font-size:12px'>
          <tr>
            <th>N°</th>
            <th>Fecha</th>
            <th>Zona</th>
            <th>Responsable Familiar</th>
            <th>Paciente</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>";
              if ($resul && count($resul) > 0){
                  $i = 0;
                foreach ($resul as $fi){
                    echo "<tr>";
                      echo "<td>".($i+1)."</td>";
                      echo "<td>".$fi['fecha']."</td>";
                      echo "<td>".$fi['zona_his']."</td>";
                      $datosResponsable = $fi['datos_responsable_familia'];
                      echo "<td>";
                      $nombre_resp= "";$ap_resp = '';$am_resp = '';$cod_resp='';$fecha_nac = '';$sexo_resp = '';$ocupacion_resp='';
                      $direccion_responsable  = '';$telefono_resposable='';$comunidad_responsable='';
                      $ci_resp = '';$nro_seguro_resp='';$nro_car_form_resp='';
                      foreach ($datosResponsable as $resFamiliar) {
                        $cod_resp=$resFamiliar["cod_usuario"];
                        $nombre_resp = $resFamiliar["nombre_usuario_re"];
                        $ap_resp = $resFamiliar["ap_usuario_re"];
                        $am_resp = $resFamiliar["am_usuario_re"];
                        $fecha_nac = $resFamiliar["fn_usuario_re"];
                        $sexo_resp = $resFamiliar["sexo_usuario"];
                        $ocupacion_resp=$resFamiliar["ocupacion_usuario"];$direccion_responsable=$resFamiliar['direccion_usuario_re'];
                        $telefono_resposable=$resFamiliar["telefono_usuario_re"];$comunidad_responsable=$resFamiliar["comunidad_usuario_re"];
                        $ci_resp = $resFamiliar['ci_usuario'];$nro_seguro_resp= $resFamiliar['nro_seguro_usuario'];
                        $nro_car_form_resp= $resFamiliar['nro_car_form_usuario'];
                        echo $resFamiliar["nombre_usuario_re"]." ".$resFamiliar["ap_usuario_re"]." ".$resFamiliar["am_usuario_re"];

                      }
                      echo "</td>";

                      $datospaciente = $fi['paciente_rd_nombre'];
                      echo "<td>";
                      $fecha_nac_paciente = '';$sexo_paciente = '';$ocupacion_paciente='';
                      $estado_civil_paciente = '';$escolaridad_paciente = '';
                      foreach ($datospaciente as $datos) {
                        $fecha_nac_paciente=$datos["fn_usuario_re"];
                        $sexo_paciente=$datos["sexo_usuario"];$ocupacion_paciente=$datos["ocupacion_usuario"];
                        $estado_civil_paciente=$datos["estado_civil_usuario"];$escolaridad_paciente=$datos["escolaridad_usuario"];
                        echo $datos["nombre_usuario_re"]." ".$datos["ap_usuario_re"]." ".$datos["am_usuario_re"];
                      }
                      echo "</td>";

                      echo "<td>";
                        echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                          echo "<button type='button' class='d-sm-inline-block btn btn-sm btn-info shadow-sm' data-bs-toggle='modal' data-bs-target='#ModalRegistro' title='Editar'
                          onclick='ActualizarHistorial(".$fi['cod_his'].",".$fi['cod_rd'].",".$fi['paciente_rd']."
                          ,\"".$nombre_resp."\",\"".$ap_resp."\",\"".$am_resp."\",".$cod_resp.",\"".$fecha_nac."\",\"".$sexo_resp."\"
                          ,\"".$ocupacion_resp."\",\"".$direccion_responsable."\",\"".$telefono_resposable."\",
                          \"".$comunidad_responsable."\",\"".$ci_resp."\",\"".$nro_seguro_resp."\",\"".$nro_car_form_resp."\"
                          ,\"".$fi["zona_his"]."\",
                          \"".$fecha_nac_paciente."\",\"".$sexo_paciente."\",\"".$ocupacion_paciente."\",\"".$estado_civil_paciente."\"
                          ,\"".$escolaridad_paciente."\",\"".$fi["fecha"]."\")'>
                          <img src='../imagenes/edit.ico' height='17' width='17' class='rounded-circle'></button>";
                            echo "<button type='button' class='d-sm-inline-block btn btn-sm btn-warning' title='Imprimir' onclick='imprimir(".$fi['cod_his'].")'><img src='../imagenes/imprimir.png' height='17' width='17' class='rounded-circle'></button>";
                            //echo "<button type='button' class='btn btn-danger' title='Desactivar Usuario' onclick='accionBtnActivar(\"activo\",".$pagina.",".$listarDeCuanto.",".$fi["cod_usuario"].")'><img src='../imagenes/drop.ico' height='17' width='17' class='rounded-circle'></button>";
                        echo "</div>";
                      echo "</td>";

                    echo "</tr>";
                    $i++;
                  }
                }else{
                  echo "<tr>";
                  echo "<td colspan='15' align='center'>No se encontraron resultados</td>";
                  echo "</tr>";
                }

                echo "</tbody>
              </table>
              </div>
            </div>
          </div>";

          if($TotalPaginas!=0){
            $adjacents=1;
            $anterior = "&lsaquo; Anterior";
            $siguiente = "Siguiente &rsaquo;";
        echo "<div class='row'>
              <div class='col'>";

            echo "<div class='d-flex flex-wrap flex-sm-row justify-content-between'>";
              echo '<ul class="pagination">';
                echo "pagina &nbsp;".$pagina."&nbsp;con&nbsp;";
                  $total=$inicioList+$pagina;
                  if($TotalPaginas > $num_filas_total){
                    $TotalPaginas = $num_filas_total;
                  }
                echo '<li class="page-item active"><a class=" href="#"> '.($TotalPaginas).' </a></li> ';
                echo " &nbsp;de&nbsp;".$num_filas_total." registros";
              echo '</ul>';

              echo '<ul class="pagination d-flex flex-wrap">';

              // previous label
              if ($pagina != 1) {
                echo "<li class='page-item'><a class='page-link'  onclick=\"BuscarRegistrosHistorial(1)\"><span aria-hidden='true'>&laquo;</span></a></li>";
              }
              if($pagina==1) {
                echo "<li class='page-item'><a class='page-link text-muted'>$anterior</a></li>";
              } else if($pagina==2) {
                echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"BuscarRegistrosHistorial(1)\" class='page-link'>$anterior</a></li>";
              }else {
                echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"BuscarRegistrosHistorial($pagina-1)\">$anterior</a></li>";

              }
              // first label
              if($pagina>($adjacents+1)) {
                echo "<li class='page-item'><a href='javascript:void(0);' class='page-link' onclick=\"BuscarRegistrosHistorial(1)\">1</a></li>";
              }
              // interval
              if($pagina>($adjacents+2)) {
                echo"<li class='page-item'><a class='page-link'>...</a></li>";
              }

              // pages

              $pmin = ($pagina>$adjacents) ? ($pagina-$adjacents) : 1;
              $pmax = ($pagina<($TotalPaginas-$adjacents)) ? ($pagina+$adjacents) : $TotalPaginas;
              for($i=$pmin; $i<=$pmax; $i++) {
                if($i==$pagina) {
                  echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
                }else if($i==1) {
                  echo"<li class='page-item'><a href='javascript:void(0);' class='page-link'onclick=\"BuscarRegistrosHistorial(1)\">$i</a></li>";
                }else {
                  echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"BuscarRegistrosHistorial(".$i.")\" class='page-link'>$i</a></li>";
                }
              }

              // interval

              if($pagina<($TotalPaginas-$adjacents-1)) {
                echo "<li class='page-item'><a class='page-link'>...</a></li>";
              }
              // last

              if($pagina<($TotalPaginas-$adjacents)) {
                echo "<li class='page-item'><a href='javascript:void(0);'class='page-link ' onclick=\"BuscarRegistrosHistorial($TotalPaginas)\">$TotalPaginas</a></li>";
              }
              // next

              if($pagina<$TotalPaginas) {
                echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"BuscarRegistrosHistorial($pagina+1)\">$siguiente</a></li>";
              }else {
                echo "<li class='page-item'><a class='page-link text-muted'>$siguiente</a></li>";
              }
              if ($pagina != $TotalPaginas) {
                echo "<li class='page-item'><a class='page-link' onclick=\"BuscarRegistrosHistorial($TotalPaginas)\"><span aria-hidden='true'>&raquo;</span></a></li>";
              }

              echo "</ul>";
              echo "</div>";

        echo "</div>
            </div>";

          }

  }

  public function actualizarDatosHistorial($paciente_rd,$cod_rd,$cod_his,$listarDeCuanto,$pagina,$fecha){
    $rdi =new Historial();
    $resultado = $rdi->seleccionarHistorial($paciente_rd,$cod_rd,$cod_his);
    $resul = $this->Uniendo2($resultado,$rdi);
    require("../vista/historial/ActualizarHistorial.php");
  }
  function Uniendo2($resul, $rdi) {
    $ar = [];
    while ($fi = mysqli_fetch_array($resul)) {
      // Añadir cada fila al array con una estructura correcta
        $entry = [
            "cod_his" => $fi["cod_his"],
            "zona_his" => $fi["zona_his"],
            "cod_rd" => $fi["cod_rd"],
            "paciente_rd" => $fi["paciente_rd"],
            "paciente_rd_nombre"=>$rdi->selectDatosUsuarios($fi["paciente_rd"]),
            "cod_cds" => $fi["cod_cds"],
            "cod_responsable_familia_his" => $fi["cod_responsable_familia_his"],
            "datos_responsable_familia" => $rdi->selectDatosUsuarios($fi["cod_responsable_familia_his"]),
            "archivo" => $fi["archivo"],
            "fecha" => $fi["fecha"],
            "hora" => $fi["hora"],
            "estado_h" => $fi["estado"]
          ];
        $ar[] = $entry; // Agregar la entrada al array principal
    }
    return $ar; // Devolver el array completo fuera del bucle
  }

  public function visualizarGeneradorDeReporte($fecha1,$fecha2,$paciente_rd,$cod_his,$cod_rd){
    $rdi =new Historial();
    $res = $rdi->SelectHistorialTodo($paciente_rd,$fecha1,$fecha2,$cod_his);
    $resul = $this->Uniendo($res,$rdi);
    require("../vista/historial/HistorialGenerarReporte.php");
  }
  public function ImprimirReporte($fecha1,$fecha2,$paciente_rd,$cod_his,$cod_rd){
    $rdi =new Historial();
    $res = $rdi->SelectHistorialTodo($paciente_rd,$fecha1,$fecha2,$cod_his);
    $resul = $this->Uniendo($res,$rdi);
    require("../vista/historial/ReporteHistorial.php");
  }
}

  $hc = new HistorialControlador();
if(isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"]=='admision')
{
  if(isset($_GET["accion"]) && $_GET["accion"]=="vht"){

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         // Guardar los datos en la sesión en lugar de pasarlos por la URL
         $_SESSION['paciente_rd'] = $_POST["paciente_rd"];
         $_SESSION['cod_rd'] = $_POST["cod_rd"];

         // Redirigir a la misma página sin pasar datos sensibles en la URL
         header("Location: historial.controlador.php?accion=vht");
         exit();
     }

     // Recuperar los datos desde la sesión cuando se llega mediante GET
     if ($_SERVER['REQUEST_METHOD'] == 'GET') {
         if (isset($_SESSION['paciente_rd'])  && isset($_SESSION['cod_rd'])) {
             // Usar los datos almacenados en la sesión
             $paciente_rd = $_SESSION['paciente_rd'];
             $cod_rd = $_SESSION['cod_rd'];

             // Llamar a la función que genera el reporte
             $hc->verTablaHistorial($paciente_rd,$cod_rd);
         } else {
             echo "Error: No hay datos para redireccionarles al formulario que esta solicitando.";
         }
     }
	}

  if(isset($_GET["accion"]) && $_GET["accion"]=="rhRyP"){
    $hc->registroDatosResponsablePaciente(
      $_POST["Nombre_responsable"],
      $_POST["ap_responsable"],
      $_POST["am_responsable"],
      $_POST["fecha_nacimiento_responsable"],
      $_POST["sexo_responsable"],
      $_POST["ocupacion_responsable"],
      $_POST["direccion_responsable"],
      $_POST["telefono_resposable"],
      $_POST["comunidad_responsable"],
      $_POST["ci"],
      $_POST["n_seguro"],
      $_POST["n_carp_fam"],
      $_POST["zona_his"],
      $_POST["cod_usuario"],
      $_POST["paciente_rd"],
      $_POST["cod_rd"],
      $_POST["fecha_nacimiento"],
      $_POST["sexo"],
      $_POST["ocupacion"],
      $_POST["fecha_de_consulta"],
      $_POST["estado_civil"],
      $_POST["escolaridad"],
      $_POST["cod_historial"]
    );
  }
  if(isset($_GET["accion"]) && $_GET["accion"]=="rbph"){
    $hc->buscarBDpacienteResponsable($_POST['nombre']);
  }
  if(isset($_GET["accion"]) && $_GET["accion"]=="bht"){
    $hc->buscarHistorial($_POST["pagina"],$_POST["listarDeCuanto"],$_POST["fecha"],$_POST["paciente_rd"],$_POST["cod_rd"]);
  }
  if(isset($_GET["accion"]) && $_GET["accion"]=="aht"){
    $hc->actualizarDatosHistorial($_POST["paciente_rd"],$_POST["cod_rd"],$_POST["cod_his"],$_POST["listarDeCuanto"],$_POST["pagina"],$_POST["fecha"]);
  }
  if(isset($_GET["accion"]) && $_GET["accion"] == 'grh'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       // Guardar los datos en la sesión en lugar de pasarlos por la URL
       $_SESSION['fecha1'] = $_POST["fecha1"];
       $_SESSION['fecha2'] = $_POST["fecha2"];
       $_SESSION['paciente_rd'] = $_POST["paciente_rd"];
       $_SESSION['cod_historial'] = $_POST["cod_historial"];
       $_SESSION['cod_rd'] = $_POST["cod_rd"];

       // Redirigir a la misma página sin pasar datos sensibles en la URL
       header("Location: historial.controlador.php?accion=grh");
       exit();
   }

   // Recuperar los datos desde la sesión cuando se llega mediante GET
   if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       if (isset($_SESSION['fecha1']) && isset($_SESSION['fecha2']) && isset($_SESSION['paciente_rd']) && isset($_SESSION['cod_historial']) && isset($_SESSION['cod_rd'])) {
           // Usar los datos almacenados en la sesión
           $fecha1 = $_SESSION['fecha1'];
           $fecha2 = $_SESSION['fecha2'];
           $paciente_rd = $_SESSION['paciente_rd'];
           $cod_historial = $_SESSION['cod_historial'];
           $cod_rd = $_SESSION['cod_rd'];

           // Llamar a la función que genera el reporte
           $hc->visualizarGeneradorDeReporte($fecha1, $fecha2, $paciente_rd, $cod_historial, $cod_rd);
       } else {
           echo "Error: No hay datos para redireccionarles al formulario que esta solicitando.";
       }
   }
  }
  if(isset($_GET["accion"]) && $_GET["accion"] == 'grnth'){
    $hc->ImprimirReporte($_POST["fecha1"],$_POST["fecha2"],$_POST["paciente_rd"],$_POST["cod_historial"],$_POST["cod_rd"]);
  }

  if(isset($_GET["accion"]) && $_GET["accion"] == 'ihu'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       // Guardar los datos en la sesión en lugar de pasarlos por la URL

       $_SESSION['paciente_rd'] = $_POST["paciente_rd"];
       $_SESSION['cod_historial'] = $_POST["cod_historial"];
       $_SESSION['cod_rd'] = $_POST["cod_rd"];

       // Redirigir a la misma página sin pasar datos sensibles en la URL
       header("Location: historial.controlador.php?accion=ihu");
       exit();
   }

   // Recuperar los datos desde la sesión cuando se llega mediante GET
   if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       if (isset($_SESSION['paciente_rd']) && isset($_SESSION['cod_historial']) && isset($_SESSION['cod_rd'])) {
           // Usar los datos almacenados en la sesión

           $paciente_rd = $_SESSION['paciente_rd'];
           $cod_historial = $_SESSION['cod_historial'];
           $cod_rd = $_SESSION['cod_rd'];
           // Llamar a la función que genera el reporte
           $hc->visualizarGeneradorDeReporte(false,false,$paciente_rd, $cod_historial, $cod_rd);
       } else {
           echo "Error: No hay datos para redireccionarles al formulario que esta solicitando.";
       }
   }
  }
}else{
  $ins->Redireccionar_inicio();
}
?>
