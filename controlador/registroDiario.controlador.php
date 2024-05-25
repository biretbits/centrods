<?php
require_once '../modelo/registroDiario.php';
require "sesion.controlador.php";
$ins=new sesionControlador();
$ins->StarSession();
if(isset($_SESSION["tipo_usuario"])==""){
    $ins->Redireccionar_inicio();
}
class RegistroDiarioControlador{

	public function visualizarTablaRegistroDiario(){
		$rdi =new RegistroDiario();
    $listarDeCuanto = 5;$pagina = 1;$buscar = "";$fecha = date('Y-m-d');
    $resultodoUsuarios = $rdi->SelectPorBusquedaRegistroDiario("",false,false,false);
    $num_filas_total = mysqli_num_rows($resultodoUsuarios);
    $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
            //calculamos el registro inicial
    $inicioList = ($pagina - 1) * $listarDeCuanto;
    // Verificar si la consulta devuelve resultados
    $res = $rdi->SelectPorBusquedaRegistroDiario("",$inicioList,$listarDeCuanto,false);
    $resul = $this->Uniendo($res,$rdi);
    require ("../vista/registroDiario/tablaRegistroDiario.php");
  }
  //funciones para encontrar los nombres de los usuarios como doctor y el de admision
  function Uniendo($resul, $rdi) {
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
        ];
        $ar[] = $entry; // Agregar la entrada al array principal
    }
    return $ar; // Devolver el array completo fuera del bucle
}

public function BuscarRegistrosDiarioTabla($buscar,$pagina,$listarDeCuanto,$fecha){
  $rdi =new RegistroDiario();
  $resultodoUsuarios = $rdi->SelectPorBusquedaRegistroDiario($buscar,false,false,false);
  $num_filas_total = mysqli_num_rows($resultodoUsuarios);
  $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
          //calculamos el registro inicial
  $inicioList = ($pagina - 1) * $listarDeCuanto;
  // Verificar si la consulta devuelve resultad
  $res = $rdi->SelectPorBusquedaRegistroDiario($buscar,$inicioList,$listarDeCuanto,$fecha);
  $resul = $this->Uniendo($res,$rdi);

  echo "
  <div class='row'>
    <div class='col'>
      <div class='table-responsive'>
      <table class='table'>
        <thead style='font-size:12px'>
          <tr>
          <th>N°</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Nombre y Apellidos</th>
          <th>Fecha de Nacimiento</th>
          <th>Edad</th>
          <th>Dirección</th>
          <th>Servicio</th>
          <th>Signos y Sintomas</th>
          <th>Personal que Brinda la atencion</th>
          <th>Hist. clinica</th>
          <th>Resp. Admision</th>
          <th>Fecha de retorno de la Historia</th>
          <th>Acción</th>
          </tr>
        </thead>
      <tbody> ";


      if ($resul && count($resul) > 0) {
          $i = 0;
        foreach ($resul as $fi){
            echo "<tr>";
              echo "<td>".($i+1)."</td>";
              echo "<td>".$fi['fecha_rd']."</td>";
              echo "<td>".$fi['hora_rd']."</td>";
              echo "<td>".$fi['nombre_usuario']." ".$fi['ap_usuario']." ".$fi['am_usuario']."</td>";
              echo "<td>".$fi['fecha_nac_usuario']."</td>";
              echo "<td>".$fi['edad_usuario']."</td>";
              echo "<td>".$fi['direccion_usuario']."</td>";
              echo "<td>".$fi['servicio_rd']."</td>";
              echo "<td>".$fi['signo_sintomas_rd']."</td>";
              echo "<td>".$fi['medico_nombre']."</td>";
              echo "<td>";
              if(isset($fi['historial_clinico_rd']) && $fi['historial_clinico_rd'] == "no"){

                    echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                      echo "<button type='button' class='btn btn-dark' title='Sin historial' style='font-size:10px'>Sin historial</button>";
                    echo "</div>";

              }else{
                echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                  echo "<button type='button' class='btn btn-success' title='Hay historiales del paciente' style='font-size:10px'
                  onclick='accionHitorialVer()'><img src='../imagenes/evaluacion.ico' style='height: 25px;width: 25px;'> His.</button>";
                echo "</div>";
              }
              echo "</td>";

              echo "<td>".$fi['admision_nombre']."</td>";
              echo "<td>".$fi['fecha_retorno_historia_rd']."</td>";
              echo "<td>";
                echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                  echo "<button type='button' class='btn btn-info' title='Editar'><img src='../imagenes/edit.ico' height='17' width='17' class='rounded-circle'></button>";
                  //  echo "<button type='button' class='btn btn-danger' title='Desactivar Usuario' onclick='accionBtnActivar(\"activo\",".$pagina.",".$listarDeCuanto.",".$fi["cod_usuario"].")'><img src='../imagenes/drop.ico' height='17' width='17' class='rounded-circle'></button>";

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
        echo "<li class='page-item'><a class='page-link'  onclick=\"BuscarRegistrosDiarios(1)\"><span aria-hidden='true'>&laquo;</span></a></li>";
      }
      if($pagina==1) {
        echo "<li class='page-item'><a class='page-link text-muted'>$anterior</a></li>";
      } else if($pagina==2) {
        echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"BuscarRegistrosDiarios(1)\" class='page-link'>$anterior</a></li>";
      }else {
        echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"BuscarRegistrosDiarios($pagina-1)\">$anterior</a></li>";

      }
      // first label
      if($pagina>($adjacents+1)) {
        echo "<li class='page-item'><a href='javascript:void(0);' class='page-link' onclick=\"BuscarRegistrosDiarios(1)\">1</a></li>";
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
          echo"<li class='page-item'><a href='javascript:void(0);' class='page-link'onclick=\"BuscarRegistrosDiarios(1)\">$i</a></li>";
        }else {
          echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"BuscarRegistrosDiarios(".$i.")\" class='page-link'>$i</a></li>";
        }
      }

      // interval

      if($pagina<($TotalPaginas-$adjacents-1)) {
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
      }
      // last

      if($pagina<($TotalPaginas-$adjacents)) {
        echo "<li class='page-item'><a href='javascript:void(0);'class='page-link ' onclick=\"BuscarRegistrosDiarios($TotalPaginas)\">$TotalPaginas</a></li>";
      }
      // next

      if($pagina<$TotalPaginas) {
        echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"BuscarRegistrosDiarios($pagina+1)\">$siguiente</a></li>";
      }else {
        echo "<li class='page-item'><a class='page-link text-muted'>$siguiente</a></li>";
      }
      if ($pagina != $TotalPaginas) {
        echo "<li class='page-item'><a class='page-link' onclick=\"BuscarRegistrosDiarios($TotalPaginas)\"><span aria-hidden='true'>&raquo;</span></a></li>";
      }

      echo "</ul>";
      echo "</div>";

      echo "</div>
        </div>";

    }
  }

  public function visualizarFormularioRegistroDiario(){
    require ("../vista/registroDiario/registroDiario.php");
  }
  public function buscarBDpaciente($nombre){
    $rdi =new RegistroDiario();
  	$re = $rdi->buscarPacientesql($nombre);
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
  public function GenerarReportes($fechai,$fechaf,$buscar,$pagina,$listarDeCuanto){

    $rdi =new RegistroDiario();
          //calculamos el registro inicial
    $inicioList = ($pagina - 1) * $listarDeCuanto;
    // Verificar si la consulta devuelve resultados
    $res = $rdi->SelectPorBusquedaRegistroDiario($buscar,$inicioList,$listarDeCuanto,false,$fechai,$fechaf);
    $num_filas_total = mysqli_num_rows($res);
    //echo "numero de fillas".$num_filas_total;
    $resul = $this->Uniendo($res,$rdi);
    require("../vista/registroDiario/reporteRegistroDiario.php");
  }

	public function v_index(){
	    header("location: ../index.php");
	}
}

	$rd=new  RegistroDiarioControlador();

	if(isset($_GET["accion"]) && $_GET["accion"]=="vtd"){
		$rd->visualizarTablaRegistroDiario();
	}
  if(isset($_GET["accion"]) && $_GET["accion"]=="brd"){
		$rd->BuscarRegistrosDiarioTabla($_POST["buscar"],$_POST["page"],$_POST["listarDeCuanto"],$_POST["fecha"]);
	}
  if(isset($_GET["accion"]) && $_GET["accion"]=="vrd"){
		$rd->visualizarFormularioRegistroDiario();
	}
  if(isset($_GET["accion"]) && $_GET["accion"]=="bp"){
		$rd->buscarBDpaciente($_POST['nombre']);
	}
  if(isset($_GET["accion"]) && $_GET["accion"]=="gr"){
		$rd->GenerarReportes($_POST["fechai"],$_POST["fechaf"],$_POST["buscar"],$_POST["paginas"],$_POST["listarDeCuantos"]);
	}


?>
