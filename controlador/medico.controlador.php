<?php
require '../modelo/registroDiario.php';
require '../modelo/servicio.php';
require "sesion.controlador.php";
$ins=new sesionControlador();
$ins->StarSession();
$abi = $ins->verificarSession();
if($abi!='' and $abi=='cerrar'){
  $ins->Destroy();
  $ins->Redireccionar_inicio();
}

class MedicoControlador{

  	public function visualizarTablaRegistroDiario(){
  		$rdi =new RegistroDiario();
      $listarDeCuanto = 5;$pagina = 1;$buscar = "";$fecha = date('Y-m-d');
      $resultodoUsuarios = $rdi->SelectPorBusquedaRegistroDiario("",false,false,false,false,false,$_SESSION["cod_usuario"]);
      $num_filas_total = mysqli_num_rows($resultodoUsuarios);
      $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
              //calculamos el registro inicial
      $inicioList = ($pagina - 1) * $listarDeCuanto;
      // Verificar si la consulta devuelve resultados
      $res = $rdi->SelectPorBusquedaRegistroDiario("",$inicioList,$listarDeCuanto,false,false,false,$_SESSION["cod_usuario"]);
      $resul = $this->Uniendo($res,$rdi);
      $ser = new Servicio();
     $servicios = $ser->Selecionar_servicios();
      require ("../vista/medico/medico.php");
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
              "cod_servicio"=>$fi["servicio_rd"],
              "servicio_rd" => $rdi->selectServicio($fi["servicio_rd"]),
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
    $resultodoUsuarios = $rdi->SelectPorBusquedaRegistroDiario($buscar,false,false,$fecha,false,false,$_SESSION["cod_usuario"]);
    $num_filas_total = mysqli_num_rows($resultodoUsuarios);
    $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
            //calculamos el registro inicial
    $inicioList = ($pagina - 1) * $listarDeCuanto;
    // Verificar si la consulta devuelve resultad
    $res = $rdi->SelectPorBusquedaRegistroDiario($buscar,$inicioList,$listarDeCuanto,$fecha,false,false,$_SESSION["cod_usuario"]);
    $resul = $this->Uniendo($res,$rdi);
    echo "
    <div class='row'>
      <div class='col'>
        <div class='table-responsive'>
        <table class='table' style='font-size:12px'>
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
            <th>Resp. Admision</th>
            <th>Fecha de retorno de la Historia</th>
            </tr>
          </thead>
        <tbody> ";
        if($resul && count($resul) > 0) {
              $i = $inicioList;
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
                  /*echo "<td>";
                  if(isset($fi['historial_clinico_rd']) && $fi['historial_clinico_rd'] == "no"){
                        echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                          echo "<button type='button' class='btn btn-dark' title='Sin historial' style='font-size:10px' onclick='accionHitorialVer(".$fi["paciente_rd"].",".$fi["cod_rd"].")'>Sin historial</button>";
                        echo "</div>";
                  }else{
                    echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                      echo "<button type='button' class='btn btn-success' title='Hay historiales del paciente' style='font-size:10px'
                      onclick='accionHitorialVer(".$fi["paciente_rd"].",".$fi["cod_rd"].")'><img src='../imagenes/evaluacion.ico' style='height: 25px;width: 25px;'> His.</button>";
                    echo "</div>";
                  }
                  echo "</td>";*/
                  echo "<td>".$fi['admision_nombre']."</td>";
                  if($fi["fecha_retorno_historia_rd"]=='0000-00-00'){
                    echo "<td style='font-size:13px;color:blue'>Sin fecha de retorno</td>";
                  }else{
                    echo "<td>".$fi['fecha_retorno_historia_rd']."</td>";
                  }

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
      $ser = new Servicio();
      $servicios = $ser->Selecionar_servicios();
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
      //echo $buscar." ".$listarDeCuanto." ".$fechai." ".$fechaf;
      $rdi =new RegistroDiario();
            //calculamos el registro inicial
      $inicioList = ($pagina - 1) * $listarDeCuanto;
      // Verificar si la consulta devuelve resultados
      $res = $rdi->SelectPorBusquedaRegistroDiario($buscar,false,false,false,$fechai,$fechaf,$_SESSION["cod_usuario"]);
      $num_filas_total = mysqli_num_rows($res);
      //echo "numero de fillas".$num_filas_total;
      $resul = $this->Uniendo($res,$rdi);
      require("../vista/medico/reporteMedico.php");
    }
    public function buscarBDrespAdmision($respadmision){
          $rdi =new RegistroDiario();
         $re = $rdi->buscarrespAdmisionsql($respadmision);
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
      public function buscapbridaAtencion($personalquebrindalaatencion){
          $rdi =new RegistroDiario();
         $re = $rdi->buscarpersonalAtencionsql($personalquebrindalaatencion);
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

    public function insertarNewpaciente($cod_rd,$cod_usuario,$nombre,$ap_usuario,$am_usuario,$fecha_nacimiento,$edad,$direccion_usuario,$servicio,
    $historiaclinica,$signo_sintomas,$personalatencion,$respadmision,$fechaderetornodeHistoria){
      $rnp= new RegistroDiario();
      //echo $cod_usuario;
      $resp = $rnp->insertarNewpacientes($cod_rd,$cod_usuario,ucfirst($nombre),ucfirst($ap_usuario),ucfirst($am_usuario),$fecha_nacimiento,$edad,$direccion_usuario,$servicio,
      $historiaclinica,$signo_sintomas,$personalatencion,$respadmision,$fechaderetornodeHistoria);
      //echo $cod_usuario;
      if($resp != ""){
          echo "correcto";
      } else{
          echo "error";
      }
    }


    //despues de actualizar los datos llamamos esta funcion
    public function visualizarTablaUsuarios($pagina,$listarDeCuanto,$buscar){
      if(!is_numeric($pagina) && !is_numeric($listarDeCuanto)){
          $this->v_index();
      }
      $u = new Usuario();
      $resultodoUsuarios = $u->SelectPorBusqueda("",false,false);
      $num_filas_total = mysqli_num_rows($resultodoUsuarios);
      $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
              //calculamos el registro inicial
      $inicioList = ($pagina - 1) * $listarDeCuanto;
      // Verificar si la consulta devuelve resultados
      $resul = $u->SelectPorBusqueda("",$inicioList,$listarDeCuanto);
      require("../vista/admin/tablaUsuarios.php");
    }

    //funcion pra modificar los datos del usuario
    public function modificarUsuario($cod_usuario){
      $usu = new Usuario();
      $re = $usu->selectDatosUsuario($cod_usuario);
      if ($re && $re->num_rows > 0) {//se encontro el usuario buscado ahora lo mostramos en el formulario de registro
        echo "correcto";
      }else{
        echo "error";
      }
    }
    //visulizar formulario de acturalizar registros con los datos del cod_usuario buscado
    public function visualizarFormPaciente($cod_rd,$paciente_rd,$buscar,$pagina,$listarDeCuanto,$fecha){
      $s = new RegistroDiario();
      $resul = $s->seleccionarDatos($cod_rd,$paciente_rd);
      if(isset($resul) && $resul->num_rows > 0){
        $fe = mysqli_fetch_array($resul);//si hay entonces guardamos los datos en una variable
      }
      $nombreP = $s->selectNombreUsuario($fe["pe_brinda_atencion_rd"]);
      $nombreR = $s->selectNombreUsuario($fe["resp_admision_rd"]);
      $ser = new Servicio();
      $servicios = $ser->Selecionar_servicios();
      require("../vista/registroDiario/ActualizarregistroDiario.php");
    }


    public function BuscarRegistrosDiarioTablaDespuesDeActualizar($buscar,$pagina,$listarDeCuanto,$fecha){
      $rdi =new RegistroDiario();
      $resultodoUsuarios = $rdi->SelectPorBusquedaRegistroDiario("",false,false,false,false,false,$_SESSION["cod_usuario"]);
      $num_filas_total = mysqli_num_rows($resultodoUsuarios);
      $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
              //calculamos el registro inicial
      $inicioList = ($pagina - 1) * $listarDeCuanto;
      // Verificar si la consulta devuelve resultados
      $res = $rdi->SelectPorBusquedaRegistroDiario("",$inicioList,$listarDeCuanto,false,false,false,$_SESSION["cod_usuario"]);
      $resul = $this->Uniendo($res,$rdi);
      require ("../vista/registroDiario/tablaRegistroDiario.php");
    }
    public function v_index(){
        header("location: ../index.php");
    }

    public function reportesRegistroDiario(){
      $rdi =new RegistroDiario();
      $listarDeCuanto = 5;$pagina = 1;$buscar = "";$fecha = date('Y-m-d');
      $resultodoUsuarios = $rdi->SelectPorBusquedaRegistroDiario("",false,false,false,false,false,$_SESSION["cod_usuario"]);
      $num_filas_total = mysqli_num_rows($resultodoUsuarios);
      $TotalPaginas = ceil($num_filas_total / $listarDeCuanto);//obtenenemos el total de paginas a mostrar
              //calculamos el registro inicial
      $inicioList = ($pagina - 1) * $listarDeCuanto;
      // Verificar si la consulta devuelve resultados
      $res = $rdi->SelectPorBusquedaRegistroDiario("",$inicioList,$listarDeCuanto,false,false,false,$_SESSION["cod_usuario"]);
      $resul = $this->Uniendo($res,$rdi);
      $resultado = $rdi->seleccionarServicios();
      require("../vista/registroDiario/reportesDiario.php");
    }

    public function BuscarMotivoConsulta($motivo_consulta){
      $h =new RegistroDiario();
      $re = $h->buscarMotivo_Consulta_sql($motivo_consulta);
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

    public function MostrarPatologiasPorPatologias(){
      $h =new RegistroDiario();
      //$resul = $ch->SeleccionarPatoligias($buscar,false,false);
      $resul = $h->seleccionarPatologias();
      $resul1 = $h->seleccionarPatologias();
      $fechaActual = date('Y-m-d');
      $resulHistorialDato = $h->seleccionarHisotialDatoTodo($fechaActual,$fechaActual);
      $resultadoTotal = $this->contarPacientesPorEnfermedad($resul,$resulHistorialDato);
      require("../vista/patologia/reportePorPatologia.php");
    }

    public function BuscarPacientePorEnfermedadReporte($fechai,$fechaf){
        $h =new RegistroDiario();
        //$resul = $ch->SeleccionarPatoligias($buscar,false,false);
        $resul = $h->seleccionarPatologias();
        $resul1 = $h->seleccionarPatologias();
        $resulHistorialDato = $h->seleccionarHisotialDatoTodo($fechai,$fechaf);
        $resultadoTotal = $this->contarPacientesPorEnfermedad($resul,$resulHistorialDato);
        require("../vista/patologia/ReporteEnfermedad.php");
    }

    private function contarPacientesPorEnfermedad($resul,$resulHistorialDato){
      $en = array();
      while($fi = mysqli_fetch_array($resul)){
        $en[$fi["cod_pat"]] = array('contar' =>0 ,'patologias'=> $fi['nombre'],'descripcion'=> $fi['descripcion'],'sintomas'=> $fi['sintomas']);
      }
      if($resulHistorialDato != ''){
        while($fi=mysqli_fetch_array($resulHistorialDato)){
          $en[$fi['cod_patologia']]['contar']+=1;
        }
        return $en;
      }else{
        return $en;
      }
    }

    public function BuscarPacientePorEnfermedad($fechainicio,$fechafinal){
      $h =new RegistroDiario();
      //$resul = $ch->SeleccionarPatoligias($buscar,false,false);
      $resul = $h->seleccionarPatologias();
      $resul1 = $h->seleccionarPatologias();
      $resulHistorialDato = $h->seleccionarHisotialDatoTodo($fechainicio,$fechafinal);
      $resultadoTotal = $this->contarPacientesPorEnfermedad($resul,$resulHistorialDato);
      echo "<div class='table-responsive' style='width: 60%; margin: auto;'>
      <table class='table table-bordered' style='font-size: 12px;' >
        <thead style='text-align:center'>
          <tr>
            <th>N°</th>
            <th>Enfermedad</th>
            <th>Contar</th>
          </tr>
        </thead>
        <tbody>";
          $k = 1;
          $suma = 0;
          while ($fi = mysqli_fetch_array($resul1)) {
            echo "<tr>";
            echo "<td>" . $k . "</td>";
            echo "<td>" . $resultadoTotal[$fi['cod_pat']]['patologias'] . "</td>";
            echo "<td style='text-align:right'>" . $resultadoTotal[$fi['cod_pat']]['contar'] . "</td>";
            $suma += $resultadoTotal[$fi['cod_pat']]['contar'];
            echo "</tr>";
            $k += 1;
          }
          echo "<tr>";
          echo "<td align='center' colspan='2'>Total</td>";
          echo "<td style='text-align:right'>" . $suma . "</td>";
          echo "</tr>";
        echo "</tbody>
      </table>
    </div>";
    }
}
$rd=new MedicoControlador();

if(isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"]=='medico')
{
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
if(isset($_GET["accion"]) && $_GET["accion"]=="bra"){
  $rd->buscarBDrespAdmision($_POST['respadmision']);
}
if(isset($_GET["accion"]) && $_GET["accion"]=="bpba"){
  $rd->buscapbridaAtencion($_POST['personalquebrindalaatencion']);
}

if(isset($_GET["accion"]) && $_GET["accion"]=="rNp"){
        $rd->insertarNewpaciente(
          $_POST["cod_rd"],
          $_POST["cod_usuario"],
          $_POST["nombre"],
          $_POST["ap_usuario"],
          $_POST["am_usuario"],
          $_POST["fecha_nacimiento"],
          $_POST["edad"],
          $_POST["direccion_usuario"],
          $_POST["servicio"],
          $_POST["historiaclinica"],
          $_POST["signos_sintomas"],
          $_POST["personalatencion"],
          $_POST["respadmision"],
          $_POST["fechaderetornodeHistoria"]
          );
        }

  if(isset($_GET["accion"]) && $_GET["accion"]=="fa"){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       // Guardar los datos en la sesión en lugar de pasarlos por la URL
         $_SESSION["cod_rd"]=$_POST["cod_rd"];
         $_SESSION["paciente_rd"]=$_POST["paciente_rd"];
         $_SESSION["buscar"]=$_POST["buscar"];
         $_SESSION["pagina"]=$_POST["pagina"];
         $_SESSION["listarDeCuanto"]=$_POST["listarDeCuanto"];
         $_SESSION["fecha"]=$_POST["fecha"];

         // Redirigir a la misma página sin pasar datos sensibles en la URL
         header("Location: registroDiario.controlador.php?accion=fa");
         exit();
     }

     // Recuperar los datos desde la sesión cuando se llega mediante GET
     if ($_SERVER['REQUEST_METHOD'] == 'GET') {
         if (isset($_SESSION["cod_rd"])&&
              isset($_SESSION["paciente_rd"])&&
              isset($_SESSION["buscar"])&&
              isset($_SESSION["pagina"])&&
              isset($_SESSION["listarDeCuanto"])&&
              isset($_SESSION["fecha"])) {
             // Usar los datos almacenados en la sesión
             $cod_rd=$_SESSION["cod_rd"];
              $paciente_rd=$_SESSION["paciente_rd"];
              $buscar=$_SESSION["buscar"];
              $pagina=$_SESSION["pagina"];
              $listarDeCuanto=$_SESSION["listarDeCuanto"];
              $fecha=$_SESSION["fecha"];
             // Llamar a la función que genera el reporte
             $rd->visualizarFormPaciente($cod_rd,$paciente_rd,$buscar,$pagina,$listarDeCuanto,$fecha);
         } else {
             echo "Error: No hay datos para redireccionarles al formulario que esta solicitando.";
         }
     }
    }


  if(isset($_GET["accion"]) && $_GET["accion"]=="rpd"){
    $rd->reportesRegistroDiario();
  }

  if(isset($_GET["accion"]) && $_GET["accion"]=="BmC"){
    $rd->BuscarMotivoConsulta($_POST["motivo_consulta"]);
  }

  if(isset($_GET["accion"]) && $_GET["accion"]=="patPac"){
    $rd->MostrarPatologiasPorPatologias();
  }
  if(isset($_GET["accion"]) && $_GET["accion"]=="bpen"){
    $rd->BuscarPacientePorEnfermedad($_POST["fechai"],$_POST["fechaf"]);
  }

  if(isset($_GET["accion"]) && $_GET["accion"]=="grpp"){
    $rd->BuscarPacientePorEnfermedadReporte($_POST["fechai"],$_POST["fechaf"]);
  }



}else{
$ins->Redireccionar_inicio();
}


 ?>
