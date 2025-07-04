<?php require("../librerias/headeradmin1.php"); ?>
<?php $medico=$_SERVER["REQUEST_URI"];
$_SESSION["diario"] = $medico;
?>

<div class="container main-content">
<div class="container">
  <?php
//  echo "<div id='color1'><a href='$medico'id='co'>Registro Diario</a>></div>"; ?>

   <div class="row">
     <div class="col-auto mb-2" style="color:gray">
         <h5>Registro Diario de pacientes del Médico</h5>
     </div>
     <div class="col-3 mb-1">
       <!-- espacio vacío para mantener el diseño intacto -->
     </div>
     <div class="col-auto mb-2">

     </div>

     <div class="col-auto mb-2" title="Registro Diario">
     </div>
     <div class="col-auto mb-2" title="Reporte">
         <input type="date" name="fecha" id="fecha" value="" onchange="BuscarRegistrosDiarios(1)" class="form-control">
     </div>
   </div>
   <div class="row" >
      <div class="col-12">
        <hr>
      </div>
    </div>

  <div class="row align-items-center">
    <label for="selectPage" class="form-label col-auto mb-2">Listar</label>
    <div class="col-auto mb-2">
      <select class="form-select" id="selectList" onchange="BuscarRegistrosDiarios(1)" name="selectList">
        <option>--</option>
        <option>5</option>
        <option>10</option>
        <option>25</option>
        <option>50</option>
        <option>100</option>
        <option>250</option>
        <option>500</option>
        <option>1000</option>
      </select>
    </div>
    <div class="col-4 mb-4">
      <!-- espacio vacío para mantener el diseño intacto -->
    </div>

    <div class="col mb-2">
      <input type="text" class="form-control" placeholder="Buscar..." id='buscaru' onkeyup="BuscarRegistrosDiarios(1)">
    </div>
  </div>
  </div>

<input type="hidden" name="paginas" id='paginas' value="">
  <!-- Modal -->
  <div class="modal fade" id="medicoModal" tabindex="-1" aria-labelledby="medicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="medicoModalLabel">REGISTRO DIARIO DE PACIENTES</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form style="padding:10px">
            <div class="row">
              <input type="hidden" name="cod_rd" id="cod_rd">
              <input type="hidden" name="cod_usuario" id="cod_usuario">
              <input type="hidden" name="cd_admision" id="cd_admision">
              <input type="hidden" name="cd_medico" id="cd_medico">

              <!-- Campos de datos personales -->
              <div class="col-md-4 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre" onkeyup="buscarExitepaciente()" autocomplete="off" style="text-transform: capitalize;">
                <div id="resultado" align="left" class="alert alert-light mb-0 py-0 border-0 encimaElTexto"></div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="ap_usuario" class="form-label">Apellido paterno</label>
                <input type="text" class="form-control" id="ap_usuario" placeholder="Ingresa Apellido paterno" style="text-transform: capitalize;">
              </div>
              <div class="col-md-4 mb-3">
                <label for="am_usuario" class="form-label">Apellido materno</label>
                <input type="text" class="form-control" id="am_usuario" placeholder="Ingresa Apellido materno" style="text-transform: capitalize;">
              </div>
              <div class="col-md-4 mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" onchange="calcularEdad()">
              </div>
              <div class="col-md-4 mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" class="form-control" id="edad" placeholder="Ingresa Tu Edad">
              </div>
              <div class="col-md-4 mb-3">
                <label for="direccion_usuario" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion_usuario" placeholder="Ingresa Tu Dirección" style="text-transform: capitalize;">
              </div>

              <!-- Campos adicionales -->
              <div class="col-md-4 mb-3">
                <label for="servicio" class="form-label">Servicio</label>
                <select class="form-select"  id="servicio" name="servicio">
                  <option value="">Seleccione servicio</option>
                  <?php while ($row = mysqli_fetch_array($servicios)) {
                    echo "<option value='".trim($row['cod_servicio'])."'>".trim($row['nombre_servicio'])."</option>";
                  } ?>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="signos_sintomas" class="form-label">Signos y Sintomas</label>
                <select id="signos_sintomas" class="form-select">
                  <option value="">Seleccione</option>
                  <option value="si">Si</option>
                  <option value="no">No</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="personalatencion" class="form-label">Personal que brinda la atención</label>
                <input type="text" class="form-control" id="personalatencion" placeholder="personal que brinda la atención" onkeyup="atencionMedico()" autocomplete="off">
                <div id="resultadomedico" align="left" class="alert alert-light mb-0 py-0 border-0 encimaElTexto"></div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="respadmision" class="form-label">Responsable de admisión</label>
                <input type="text" class="form-control" id="respadmision" placeholder="responsable de admisión" onkeyup="buscarResponsableAdmision()" autocomplete="off">
                <div id="resultadoadmision" align="left" class="alert alert-light mb-0 py-0 border-0 encimaElTexto"></div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="fechaderetornodeHistoria" class="form-label">Fecha de retorno de Historia</label>
                <input type="date" class="form-control" id="fechaderetornodeHistoria">
              </div>
              <div class="col-md-4 mb-3">
                <label for="Historia clinica" class="form-label"></label>
                <input type="hidden" class="form-control" id="historiaclinica" placeholder="Historia clinica">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="insertardatosus()">Registrar</button>

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- modal para generar fechas desde seleccionar fechas -->
  <?php
  // Obtener la fecha actual en formato YYYY-MM-DD
    $fechaActual = date('Y-m-d');
  ?>
  <div class="modal fade" id="ModalReportePorFecha" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel">Selección de fechas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Contenido del modal -->
        <div class="modal-body">
          <form class="form-inline" >
            <input type="hidden" name="pagina1" id='pagina1' value="">
            <div class="row mb-3">
              <label for="fecha1" class="form-label">Fecha inicio</label>
              <div class="input-group">
                <input type="date" id="fecha1" name="fecha1" value="<?php echo $fechaActual; ?>" class="form-control">
              </div>
            </div>
            <div class="row mb-3">
              <label for="fecha1" class="form-label">Fecha final</label>
              <div class="input-group">
                <input type="date" id="fecha2" name="fecha2" value="<?php echo $fechaActual; ?>" class="form-control">
              </div>
            </div>
            <div class="for-control alert alert-light">
              Nota:
              Seleccione de que fecha a que fecha quiere generar reporte
            </div>
          </form>
        </div>
        <!-- Pie de página del modal -->
        <div class="modal-footer">
          <button type="button"  class="btn btn-success" title = 'Generar reporte' onclick="GenerarReporte()"><img src='../imagenes/aceptar.ico' style='height: 25px;width: 25px;'> Generar</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><img src='../imagenes/drop.ico' style='height: 25px;width: 25px;'></button>
        </div>

      </div>
    </div>
  </div>

  <div class="verDatos" id="verDatos">
    <div class="row">
      <div class="col">
        <div class="table-responsive">
        <table class="table" style="font-size:12px">
          <thead>
            <tr>
              <th>N°</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Nombres y Apellidos</th>
              <th>Fecha de Nacimiento</th>
              <th>Edad</th>
              <th>Dirección</th>
              <th>Servicio</th>
              <th>Signos y Síntomas</th>
              <th>Personal que Brinda la atención</th>
              <!--<th>Historial Clínica</th>-->
              <th>Responsable de Admisión</th>
              <th>Fecha de retorno de la Historia</th>
            </tr>
          </thead>
          <tbody>
      <?php
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
              }*/
              echo "</td>";

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
          $resul = 'No se encontro resultados';
          echo $resul;
        }
         ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
  <?php
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
   ?>
 </div>
 </div>
 <!-- modal de seleccion de fechas-->


<script type="text/javascript">
function BuscarRegistrosDiarios(page){
    var obt_lis = document.getElementById("selectList").value;
    var listarDeCuanto = verificarList(obt_lis);
    var buscar = document.getElementById("buscaru").value;
    var fecha = document.getElementById("fecha").value;
    document.getElementById("paginas").value=page;
    ponerFechactualAlModalDeReporte(listarDeCuanto,buscar,page,fecha);
    var datos = new FormData(); // Crear un objeto FormData vacío
    datos.append('buscar', buscar);
    datos.append('page', page);
    datos.append('listarDeCuanto',listarDeCuanto);
    datos.append('fecha',fecha);
      $.ajax({
        url: "../controlador/medico.controlador.php?accion=brd",
        type: "POST",
        data: datos,
        contentType: false, // Deshabilitar la codificación de tipo MIME
        processData: false, // Deshabilitar la codificación de datos
        success: function(data) {
      //alert(data+"dasdas");
          $("#verDatos").html(data);
        }
      });
  }

  function verificarList(valor){
    if(valor != "" && valor != "--"){
      return valor;
    }else{
      return 5;
    }
  }

  function visualizarmedico(){
     location.href="../controlador/medico.controlador.php?accion=vrd";
   }

   function error(){
  	 Swal.fire({
  		icon: 'error',
  		title: '¡Error!',
  		text: '¡No se pudo realizar la acción !',
  		showConfirmButton: false,
  		timer: 1500
  	});
   }
   //funcion para ingresar los datos al formulario modal para poder realizar luego el submit
   function   ponerFechactualAlModalDeReporte(listarDeCuanto,buscar,page,fecha){
      if(fecha != ""){
        document.getElementById("fecha1").value=fecha;
        document.getElementById("fecha2").value=fecha;
      }
      document.getElementById("pagina1").value=page;

   }
   function GenerarReporte(){
     var fecha1 = document.getElementById("fecha1").value;
     var fecha2 = document.getElementById("fecha2").value;
     var buscar = document.getElementById("buscaru").value;
     var pagina = document.getElementById("pagina1").value
     if(pagina == ""){pagina = 1;}
     var obt_lis = document.getElementById("selectList").value;
     var listarDeCuanto = verificarList(obt_lis);
     var form = document.createElement('form');
      form.method = 'post';
      form.action = '../controlador/medico.controlador.php?accion=gr'; // Coloca la URL de destino correcta
      // Agregar campos ocultos para cada dato
      var datos = {
        fechai:fecha1,
        fechaf:fecha2,
        buscar:buscar,
        paginas:pagina,
        listarDeCuantos:listarDeCuanto
      };
      for (var key in datos) {
          if (datos.hasOwnProperty(key)) {
              var input = document.createElement('input');
              input.type = 'hidden';
              input.name = key;
              input.value = datos[key];
              form.appendChild(input);
          }
      }
    // Agregar el formulario al cuerpo del documento y enviarlo
    document.body.appendChild(form);
    form.submit();
   }
   //funcion para ver el historial del paciente
   function accionHitorialVer(paciente_rd,cod_rd){
       var form = document.createElement('form');
        form.method = 'post';
        form.action = '../controlador/historial.controlador.php?accion=vht'; // Coloca la URL de destino correcta
        // Agregar campos ocultos para cada dato
        var datos = {
            paciente_rd:paciente_rd,
            cod_rd:cod_rd
        };
        for (var key in datos) {
            if (datos.hasOwnProperty(key)) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = datos[key];
                form.appendChild(input);
            }
        }
      // Agregar el formulario al cuerpo del documento y enviarlo
      document.body.appendChild(form);
      form.submit();
   }
   function editarpaciente(cod_rd,paciente_rd,nombre_usuario,ap_usuario,am_usuario,fecha_nac_usuario,edad_usuario,direccion_usuario,servicio_rd
     ,signo_sintomas,historiaclinica,pe_brinda_atencion_rd,resp_admision_rd,fecha_retorno_historia_rd,medico_nombre,admision){
      document.getElementById("cod_rd").value = cod_rd;
      document.getElementById("cod_usuario").value = paciente_rd;
      document.getElementById("nombre").value = nombre_usuario;
      document.getElementById("ap_usuario").value = ap_usuario;
      document.getElementById("am_usuario").value = am_usuario;
      document.getElementById("fecha_nacimiento").value = fecha_nac_usuario;
      document.getElementById("edad").value = edad_usuario;
      document.getElementById("direccion_usuario").value = direccion_usuario;
      document.getElementById("servicio").value=servicio_rd;
      document.getElementById("signos_sintomas").value = signo_sintomas;
      document.getElementById("historiaclinica").value = historiaclinica;
      document.getElementById("cd_medico").value = pe_brinda_atencion_rd;
      document.getElementById("cd_admision").value = resp_admision_rd;
      document.getElementById("fechaderetornodeHistoria").value = fecha_retorno_historia_rd;
      document.getElementById("personalatencion").value=medico_nombre;
      document.getElementById("respadmision").value=admision;
   }

   //todo de abajo son para el elregistro de nuevo paciente


     function buscarExitepaciente(){
       vaciarDESPUESdeUNtiempo();
       var nombre = document.getElementById("nombre").value;
       if(nombre != ""){
       $.ajax({
     		url: "../controlador/medico.controlador.php?accion=bp",
     		type: "POST",
     		data: {nombre:nombre},
     		dataType: "json",
         success: function(data) {
           if(data!=""){
             var unir="";
             for (let i = 0; i < data.length; i++) {
               var usuario = data[i];
               unir+="<div><div id='u' style=' display: inline-block;'>"+Convertir(data[i].nombre_usuario)+"</div> ";
               unir+="<div id='ap' style=' display: inline-block;'> "+Convertir(data[i].ap_usuario)+"</div> ";
               unir+="<div id='am' style=' display: inline-block;'> "+Convertir(data[i].am_usuario)+"</div> ";
               unir+="<div id='fn' style=' display: inline-block;'> "+data[i].fecha_nac_usuario+"</div>";
               unir+="<div id='ed' style=' display: inline-block;display:none;'>"+data[i].edad_usuario+"</div>";
               unir+="<div id='d' style=' display: inline-block;display:none;'>"+data[i].direccion_usuario+"</div>";
               unir+="<div id='c' style=' display: inline-block;display:none;'>"+data[i].cod_usuario+"</div></div>";

             }

             visualizarUser(unir);
             $('#resultado div').on('click', function() {
                     //obtenemos los datos del usuario div resultado
               var nombre = $(this).children().eq(0).text();
               var ap = $(this).children().eq(1).text();
               var am = $(this).children().eq(2).text();
               var fn = $(this).children().eq(3).text();
               var ed = $(this).children().eq(4).text();
               var d = $(this).children().eq(5).text();
               var c = $(this).children().eq(6).text();

                 //dentro de los id de la vista mostramos los datos que estan en el div resultado
                 if(nombre != ""){
                   document.getElementById("nombre").value = nombre;
                   if(nombre != ''){
                     document.getElementById("nombre").disabled = true;
                   }
                   document.getElementById("ap_usuario").value = ap;
                   if(ap != ''){
                     document.getElementById("ap_usuario").disabled = true;
                   }
                   document.getElementById("am_usuario").value = am;
                   if(am!=''){
                     document.getElementById("am_usuario").disabled = true;
                   }
                   var fecha = new Date(fn); // Puedes modificar esta fecha según tus necesidades

                   // Formatear la fecha como una cadena para asignarla al campo de tipo date
                   var fechaFormateada = fecha.toISOString().split('T')[0];
                   document.getElementById("fecha_nacimiento").value = fechaFormateada;
                   if(fechaFormateada == null || fechaFormateada=='0000-00-00'){
                     document.getElementById("fecha_nacimiento").disabled = false;
                   }else{
                     document.getElementById("fecha_nacimiento").disabled = true;
                   }
                   document.getElementById("edad").value = ed;
                   if(ed == 0){
                     document.getElementById("edad").disabled = false;
                   }else{
                     document.getElementById("edad").disabled = true;
                   }
                   document.getElementById("direccion_usuario").value = d;
                   if(d == ''){
                     document.getElementById("direccion_usuario").disabled = false;
                   }else {
                     document.getElementById("direccion_usuario").disabled = true;
                   }
                   document.getElementById("cod_usuario").disabled = true;
                   document.getElementById("cod_usuario").value = c;
                   $('#resultado').html(""); //para vaciar

                 }
             });
           }else{
             $('#resultado').html("<div class='alert alert-light' role='alert'>No se encontro resultados</div>");
           }

     		}
     	});
     }else{
       $('#resultado').html("");
     }
   }
   function Convertir(t){
     let palabras = t.split(" ");
     let nombreConInicialesMayusculas = "";
      for (let i = 0; i < palabras.length; i++) {
        nombreConInicialesMayusculas += palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1) + " ";
       }
        return nombreConInicialesMayusculas.trim();
    }

     function visualizarUser(unir){

     $('#resultado').html(unir);
     //colocamos un color de css
     $('#resultado').css({
      'cursor': 'pointer',
      'font-size':'15px'
      });
      // Obtener el elemento div con el id "results"
     /* const divResults = document.getElementById('results');   // Cambiar la clase del div
     divResults.setAttribute('class', 'alert alert-primary mb-0 py-0 border-0');
   */
   }


   function buscarResponsableAdmision() {
           //vaciarDESPUESdeUNtiempoAdmision();
           var respadmision = document.getElementById("respadmision").value;
           if (respadmision != "") {
               $.ajax({
                   url: "../controlador/medico.controlador.php?accion=bra",
                   type: "POST",
               		data: {respadmision:respadmision},
               		dataType: "json",
                   success: function(data) {
                     if(data!=""){
                       var unir="";
                       for (let i = 0; i < data.length; i++) {
                         var usuario = data[i];

                         unir+="<div><div id='u' style=' display: inline-block;'>"+Convertir(data[i].nombre_usuario)+"</div> ";
                         unir+="<div id='ap' style=' display: inline-block;'> "+Convertir(data[i].ap_usuario)+"</div> ";
                         unir+="<div id='am' style=' display: inline-block;'> "+Convertir(data[i].am_usuario)+"</div> ";
                         unir+="<div id='p' style=' display: inline-block;display:none;'> "+Convertir(data[i].tipo_usuario)+"</div> ";
                         unir+="<div id='c' style=' display: inline-block;display:none;'>"+data[i].cod_usuario+"</div></div>";

                       }

                       visualizarResponsableAdmision(unir);
                       $('#resultadoadmision div').on('click', function() {
                               //obtenemos los datos del usuario div resultado
                         var respadmision = $(this).children().eq(0).text();
                         var ap = $(this).children().eq(1).text();
                         var am = $(this).children().eq(2).text();
                         var c = $(this).children().eq(4).text();
                         var p = $(this).children().eq(3).text();

                           //dentro de los id de la vista mostramos los datos que estan en el div resultado
                           if(respadmision != ""){
                             //document.getElementById("respadmision").disabled = true;
                             document.getElementById("respadmision").value = Convertir(respadmision)+" "+Convertir(ap)+" "+Convertir(am);
                             document.getElementById("cd_admision").value = c;
                             $('#resultadoadmision').html(""); //para vaciar

                           }
                       });
                     }else{
                       $('#resultadoadmision').html("<div class='alert alert-light' role='alert'>No se encontro resultados</div>");
                     }

               		}
               	});
               }else{
                 $('#resultadoadmision').html("");
               }
             }
             function Convertir(t){
               let palabras = t.split(" ");
               let nombreConInicialesMayusculas = "";
                for (let i = 0; i < palabras.length; i++) {
                  nombreConInicialesMayusculas += palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1) + " ";
                 }
                  return nombreConInicialesMayusculas.trim();
              }

               function visualizarResponsableAdmision(unir){

               $('#resultadoadmision').html(unir);
               //colocamos un color de css
               $('#resultadoadmision').css({
                'cursor': 'pointer',
                'font-size':'15px'
                });
                // Obtener el elemento div con el id "results"
               /* const divResults = document.getElementById('results');   // Cambiar la clase del div
               divResults.setAttribute('class', 'alert alert-primary mb-0 py-0 border-0');
             */

       }
       function atencionMedico() {
        // vaciarDESPUESdeUNtiempoMedico();
               var personalquebrindalaatencion = document.getElementById("personalatencion").value;
               if ( personalquebrindalaatencion != "") {
                   $.ajax({
                       url: "../controlador/medico.controlador.php?accion=bpba",
                       type: "POST",
                   		data: {personalquebrindalaatencion:personalquebrindalaatencion},
                   		dataType: "json",
                       success: function(data) {
                         if(data!=""){
                           var unir="";
                           for (let i = 0; i < data.length; i++) {
                             var usuario = data[i];

                             unir+="<div><div id='u' style=' display: inline-block;'>"+Convertir(data[i].nombre_usuario)+"</div> ";
                             unir+="<div id='ap' style=' display: inline-block;'> "+Convertir(data[i].ap_usuario)+"</div> ";
                             unir+="<div id='am' style=' display: inline-block;'> "+Convertir(data[i].am_usuario)+"</div> ";
                             unir+="<div id='p' style=' display: inline-block;display:none;'> "+Convertir(data[i].profesion_usuario)+"</div> ";
                             unir+="<div id='c' style=' display: inline-block;display:none;'>"+data[i].cod_usuario+"</div></div>";

                           }

                           personalquebrindaatencion(unir);

                           $('#resultadomedico div').on('click', function() {
                                   //obtenemos los datos del usuario div resultado
                             var personalquebrindalaatencion = $(this).children().eq(0).text();
                             var ap = $(this).children().eq(1).text();
                             var am = $(this).children().eq(2).text();
                             var c = $(this).children().eq(4).text();
                             var p = $(this).children().eq(3).text();
                   //dentro de los id de la vista mostramos los datos que estan en el div resultado
                               if(personalquebrindalaatencion != ""){
                                 //document.getElementById("personalatencion").disabled = true;
                                 document.getElementById("personalatencion").value = Convertir(personalquebrindalaatencion)+" "+Convertir(ap)+" "+Convertir(am);
                                 document.getElementById("cd_medico").value = c;
                                 $('#resultadomedico').html(""); //para vaciar

                               }
                           });
                         }else{
                           $('#resultadomedico').html("<div class='alert alert-light' role='alert'>No se encontro resultados</div>");
                         }

                   		}
                   	});
                   }else{
                     $('#resultadomedico').html("");
                   }
                 }
                 function Convertir(t){
                   let palabras = t.split(" ");
                   let nombreConInicialesMayusculas = "";
                    for (let i = 0; i < palabras.length; i++) {
                      nombreConInicialesMayusculas += palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1) + " ";
                     }
                      return nombreConInicialesMayusculas.trim();
                  }

                   function personalquebrindaatencion(unir){

                   $('#resultadomedico').html(unir);
                   //colocamos un color de css
                   $('#resultadomedico').css({
                    'cursor': 'pointer',
                    'font-size':'15px'
                    });
                    // Obtener el elemento div con el id "results"
                   /* const divResults = document.getElementById('results');   // Cambiar la clase del div
                   divResults.setAttribute('class', 'alert alert-primary mb-0 py-0 border-0');
                 */

           }

           function insertardatosus(){
             var cod_rd = document.getElementById("cod_rd").value;
             var cod_usuario = document.getElementById("cod_usuario").value;
           	 var nombre = document.getElementById("nombre").value;
           	 var ap_usuario = document.getElementById("ap_usuario").value;
           	 var am_usuario = document.getElementById("am_usuario").value;
           	 var fecha_nacimiento = document.getElementById("fecha_nacimiento").value;
             var edad = parseInt(document.getElementById("edad").value);

           	 var direccion_usuario = document.getElementById("direccion_usuario").value;
           	 var servicio = document.getElementById("servicio").value;
             var signos_sintomas = document.getElementById("signos_sintomas").value;
             var historiaclinica = document.getElementById("historiaclinica").value;

           	var cd_atencion = document.getElementById("cd_medico").value;
           	var cd_admision = document.getElementById("cd_admision").value;

            var fechaderetornodeHistoria = document.getElementById("fechaderetornodeHistoria").value;

             if(signos_sintomas == ''){
               seleccione();
               return;
             }

             const hoy = new Date();
             const fechaNacimiento = new Date(document.getElementById("fecha_nacimiento").value);
             if (!fechaNacimiento.getTime()) {
                 fECHAnOVALIDO();
                 return;
             }
             if (fechaNacimiento > hoy) {
                 fECHAnOVALIDO();
                 return;
             }

             // Mostrar el resultado
             if(edad < 0){
               fECHAnOVALIDO();
               return;
             }
            	if(nombre==""||ap_usuario==""||am_usuario==""||fecha_nacimiento==""||direccion_usuario==""
             ||signos_sintomas==""||personalatencion==""||respadmision==""){
           		ingreseNPdatos();
           		return;
           	}

             if(servicio == "Seleccione servicio" || servicio == ""){
               seleccione();
               return
             }
           	var datos = new FormData(); // Crear un objeto FormData vacío
            datos.append("cod_rd",cod_rd);
           	datos.append("cod_usuario",cod_usuario);
           	datos.append("nombre",nombre);
           	datos.append("ap_usuario",ap_usuario);
           	datos.append("am_usuario",am_usuario);
           	datos.append("fecha_nacimiento",fecha_nacimiento);
           	datos.append("edad",edad);
           	datos.append("direccion_usuario",direccion_usuario);
           	datos.append("servicio",servicio);
           	datos.append("signos_sintomas",signos_sintomas);
           	datos.append("historiaclinica",historiaclinica);
           	datos.append("personalatencion",cd_atencion);
           	datos.append("respadmision",cd_admision);
           	datos.append("fechaderetornodeHistoria",fechaderetornodeHistoria);
       /*      alert(
     "Código de Usuario: " + cod_usuario + "\n" +
     "Nombre: " + nombre + "\n" +
     "Apellido Paterno: " + ap_usuario + "\n" +
     "Apellido Materno: " + am_usuario + "\n" +
     "Fecha de Nacimiento: " + fecha_nacimiento + "\n" +
     "Edad: " + edad + "\n" +
     "Dirección: " + direccion_usuario + "\n" +
     "Servicio: " + servicio + "\n" +
     "Signos y Síntomas: " + signos_sintomas + "\n" +
     "Historia Clínica: " + historiaclinica + "\n" +
     "Código de Atención: " + cd_atencion + "\n" +
     "Código de Admisión: " + cd_admision + "\n" +
     "Fecha de Retorno: " + fechaderetornodeHistoria
   );*/

             $.ajax({
               url: "../controlador/medico.controlador.php?accion=rNp",
               type: "POST",
               data: datos,
               contentType: false, // Deshabilitar la codificación de tipo MIME
               processData: false, // Deshabilitar la codificación de datos
               success: function(data) {
               //alert(data+"dasdas");
                 data=$.trim(data);
                 if(data == "correcto"){

                   //if(accion == 1){
                     //  alertCorrectoUp();
                       // close(pagina,listarDeCuanto,buscar);
                   //}else{
                     alertCorrecto();
                   //}
                   IRalLinkTablamedico(cod_rd);
                 }else {
                   Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '¡Ocurrio un problema!',
                    showConfirmButton: false,
                    timer: 1500
                  });
                 }
               },error:function(r){
                 alert("Ocurrió un error: " + JSON.stringify(r));
               }
             });
           }
           function seleccione(){
             Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: '¡Seleccione!',
              showConfirmButton: false,
              timer: 1500
            });
           }

           //funcion para ir al index cuando ingrese un usuario del sistema
           function vaciarDESPUESdeUNtiempo(){
             setTimeout(() => {
               $('#resultado').html("");
             }, 5000);
           }
           function vaciarDESPUESdeUNtiempoMedico(){
             setTimeout(() => {
               $('#resultadomedico').html("");
             }, 5000);
           }
           function vaciarDESPUESdeUNtiempoAdmision(){
             setTimeout(() => {
               $('#resultadoadmision').html("");
             }, 5000);
           }

           function IRalLinkTablamedico(cod_rd){
             //alert(cod_rd);
             if(cod_rd!=''){
               setTimeout(() => {
                 var pagina = document.getElementById("paginas").value;
                 if(pagina==''){pagina=1;}
                 BuscarRegistrosDiarios(pagina);
                 $('#medicoModal').modal('hide');
               }, 1500);
             }else{
               setTimeout(() => {
                 $('#medicoModal').modal('hide');
                 location.href="../controlador/medico.controlador.php?accion=vtd";
               }, 1500);
             }
           }

           function alertCorrectoUp(){
             Swal.fire({
              icon: 'success',
              title: '¡Correcto!',
              text: '¡Actualización correcta!',
              showConfirmButton: false,
              timer: 1500
            });
           }

           function ingresedatosPro(){
             Swal.fire({
              icon: 'info',
              title: '¡Información!',
              text: '¡Es necesario la Profesión y la Especialidad!',
              showConfirmButton: false,
              timer: 2000
            });
           }
           function ingreseNPdatos(){
             Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: '¡Ingrese los Datos!',
              showConfirmButton: false,
              timer: 1500
            });
           }
           function selectUsuario(){
             Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: '¡Por favor seleccione!',
              showConfirmButton: false,
              timer: 1500
            });
           }
            function confirmarcontrasena(){
              Swal.fire({
               icon: 'error',
               title: '¡Error!',
               text: '¡Confirmación de Contraseña incorrecta !',
               showConfirmButton: false,
               timer: 1500
             });
            }

           //funcion para mostrar un aler de bienvenido cuando ingreso un usuario del sistema existente
             function alertCorrecto(){
               Swal.fire({
                icon: 'success',
                title: '¡Correcto!',
                text: '¡Acción realizado con éxito!',
                showConfirmButton: false,
                timer: 1500
              });
              //IRalLink();
             }
             //funcion para ir al index cuando ingrese un usuario del sistema


   //funcion que permite calcular la edad del paciente en tiempo real cuando seleccione su fecha de nacimiento
   function calcularEdad(){
     const hoy = new Date();
     // Obtener la fecha de nacimiento del usuario
     const fechaNacimiento = new Date(document.getElementById("fecha_nacimiento").value);

     if (!fechaNacimiento.getTime()) {
         fECHAnOVALIDO();
         return;
     }
     if (fechaNacimiento > hoy) {
         fECHAnOVALIDO();
         return;
     }
     // Calcular la diferencia en años
     let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
     const mes = hoy.getMonth() - fechaNacimiento.getMonth();

     // Ajustar la edad si la fecha de cumpleaños aún no ha pasado este año
     if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
         edad--;
     }
     // Mostrar el resultado
     if(edad <0){
       fECHAnOVALIDO();
       return;
     }
     document.getElementById('edad').value = edad;
   }

   function fECHAnOVALIDO(){
     document.getElementById("fecha_nacimiento").value='';
     Swal.fire({
      icon: 'info',
      title: '¡Error!',
      text: '¡Por favor, selecciona una fecha de nacimiento válida.!',
      showConfirmButton: false,
      timer: 2000
    });
   }
</script>
<?php require("../librerias/footeruni.php"); ?>
