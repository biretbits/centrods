<?php require("../librerias/headeradmin1.php"); ?>

<div class="container main-content">
<div class="container">
  <?php
  /*echo "<div id='color1'><a href='$diario'id='co'>Registro Diario</a>><a href='#'
   onclick='accionHitorialVer($paciente_rd,$cod_rd)'
   id='co'>Historial</a>></div>"; */

   ?>

<h4>Entrada de Productos Farmacéuticos</h4>
<div class="row" >
     <div class="col-12">
       <hr>
     </div>
   </div>
          <div class="row">
              <div class="col-lg-12">
                  <!-- Masthead device mockup feature-->
                  <div class="masthead-device-mockup">
                    <input type="hidden" name="cod_generico" id="cod_generico" value="<?php $ms = (isset($paciente_rd) && is_numeric($paciente_rd))? $paciente_rd:""; echo $ms; ?>">
                    <input type="hidden" name="paginas" id='paginas' value="">
                    <div class="row align-items-center">
                      <label for="selectPage" class="form-label col-auto mb-2">Pagina</label>
                      <div class="col-auto mb-2">
                        <select class="form-select" id="selectList" name="selectList" onchange="Buscar(1)">
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
                      <div class="col-auto mb-2">
                        fecha inicio
                        <input type="date" class="form-control" name="fechai"id='fechai'onchange="Buscar(1)" value="">
                        fecha final
                        <input type="date" class="form-control" name="fechaf"id='fechaf' onchange="Buscar(1)"value="">
                      </div>

                      <div class="col-auto mb-2" title="Reporte">
                        <button type="button" class="d-sm-inline-block btn btn-sm btn-warning shadow-sm" onclick="reporte()">
                          <img src='../imagenes/reporte.ico' style='height: 25px;width: 25px;'>
                        </button>
                      </div>
                      <div class="col-auto mb-2" title="Registrar o Actualizar">
                        <button type="button" class="d-sm-inline-block btn btn-sm btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#ModalRegistro" onclick="ActualizarEntrada('','','','','')">
                          <img src='../imagenes/new.ico' style='height: 25px;width: 25px;'>
                        </button>
                      </div>

                      <div class="col-auto mb-2">
                          <select class="form-select" id="estadoProducto" name="estadoProducto" onchange="Buscar(1)">
                              <option value=''>E. Producto</option>
                              <option value='activo'>Activos</option>
                              <option value='vencido'>Vencidos</option>
                            </select>
                      </div>
                      <div class="col mb-2">
                        <input type="text" name="buscar" id='buscar'class="form-control" placeholder="Buscar....." onkeyup="Buscar(1)">
                      </div>
                    </div>
                    </div>
                    <!-- modal para generar fechas desde seleccionar fechas -->
                    <?php
                    // Obtener la fecha actual en formato YYYY-MM-DD
                      $fechaActual = date('Y-m-d');
                    ?>
                    <div class="modal fade" id="ModalRegistro" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h6 class="modal-title" id="miModalRegistro">Registro o Actualización, Entrada de productos farmaceuticos</h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Contenido del modal -->
                        <div class="modal-body">
                          <div class="card shadow-lg">
                           <div class="card-body">
                             <form>
                               <input type="hidden" name="cod_producto"id='cod_producto' value="">
                               <input type="hidden" name="cod_entrada" id='cod_entrada' value="">
                               <div class="mb-3">
                                 <label for="cod_producto" class="form-label">Producto farmaceutico</label>
                                 <input type="text" class="form-control" id="nombre_producto" placeholder="Busque el producto" onkeyup="buscarProductoNuevo()" autocomplete="off">
                                 <div id="resultadoProducto" align='left' class='alert alert-light mb-0 py-0 border-0'>
                                 </div>
                               </div>

                               <div class="mb-3">
                                 <label for="name" class="form-label">Nro de lote</label>
                                 <input type="number" class="form-control" id="lote" name='lote' placeholder="Nro de lote">
                               </div>
                               <div class="mb-3">
                                 <label for="name" class="form-label">Cantidad</label>
                                 <input type="number" class="form-control" id="cantidad" name='cantidad' min='1' value='1' placeholder="Cantidad">
                               </div>
                               <div class="mb-3">
                                 <label for="name" class="form-label">Costo Unitario</label>
                                 <input type="number" class="form-control" id="unitario" name='unitario' placeholder="Costo unitario">
                               </div>
                               <div class="mb-3">
                                 <label for="name" class="form-label">Costo Total</label>
                                 <input type="number" class="form-control" id="total" name='total' placeholder="Costo Total">
                               </div>
                               <div class="mb-3">
                                 <label for="vencimiento" class="form-label">Vencimiento</label>
                                 <input type="date" class="form-control" id="vencimiento" name='vencimiento' placeholder="Vencimiento">
                               </div>

                             </form>
                           </div>
                         </div>
                        <!-- Pie de página del modal -->
                      </div>
                        <div class="modal-footer">
                          <button title='Guardar'type="button" class="btn btn-primary" onclick="registrar()"><img src='../imagenes/guardar.ico' style='height: 25px;width: 25px;'></button>
                         <button title='cerrar'type="button" class="btn btn-danger" data-bs-dismiss="modal"><img src='../imagenes/drop.ico' style='height: 25px;width: 25px;'></button>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="row" >
                         <div class="col-12">
                           <hr>
                         </div>
                       </div>
                    <div class="verDatos" id="verDatos">
                      <div class="row">
                        <div class="col">
                          <div class="table-responsive">
                          <table class="table">
                            <thead style="font-size:12px">
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
                                <th>Acción</th>
                              </tr>
                            </thead>
                            <tbody>

                        <?php
                        if ($resul && count($resul) > 0) {
                          $i = $inicioList;
                          foreach ($resul as $fi){
                              echo "<tr>";
                                echo "<td>".($i+1)."</td>";
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
                                echo "<td>";
                                  echo "<div class='btn-group' role='group' aria-label='Basic mixed styles example'>";
                                  echo "<button type='button' class='btn btn-info' title='$title' onclick='ActualizarEntrada(".$fi['cod_entrada'].",".$fi['cantidad'].",\"".$fi['vencimiento']."\",".$fi['cod_generico'].",\"".$unir."\")' data-bs-toggle='modal' data-bs-target='#ModalRegistro' $enable><img src='../imagenes/edit.ico' height='17' width='17' class='rounded-circle'></button>";
                                  if($fi["estado"] == "activo"){
                                    echo "<button type='button' class='btn btn-danger' title='Desactivar' onclick='accionBtnActivar(\"activo\",".$pagina.",".$listarDeCuanto.",\"".$buscar."\",".$fi['cod_entrada'].",\"".$fechai."\",\"".$fechaf."\")'><img src='../imagenes/drop.ico' height='17' width='17' class='rounded-circle'></button>";
                                  }else{
                                    echo "<button type='button' class='btn' style='background-color:#f1948a' title='Activar' onclick='accionBtnActivar(\"desactivo\",".$pagina.",".$listarDeCuanto.",\"".$buscar."\",".$fi['cod_entrada'].",\"".$fechai."\",\"".$fechaf."\")'><img src='../imagenes/activar.ico' height='17' width='17' class='rounded-circle'></button>";
                                 }
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
                          echo "<li class='page-item'><a class='page-link'  onclick=\"Buscar(1)\"><span aria-hidden='true'>&laquo;</span></a></li>";
                        }
                        if($pagina==1) {
                          echo "<li class='page-item'><a class='page-link text-muted'>$anterior</a></li>";
                        } else if($pagina==2) {
                          echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"Buscar(1)\" class='page-link'>$anterior</a></li>";
                        }else {
                          echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"Buscar($pagina-1)\">$anterior</a></li>";

                        }
                        // first label
                        if($pagina>($adjacents+1)) {
                          echo "<li class='page-item'><a href='javascript:void(0);' class='page-link' onclick=\"Buscar(1)\">1</a></li>";
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
                            echo"<li class='page-item'><a href='javascript:void(0);' class='page-link'onclick=\"Buscar(1)\">$i</a></li>";
                          }else {
                            echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"Buscar(".$i.")\" class='page-link'>$i</a></li>";
                          }
                        }

                        // interval

                        if($pagina<($TotalPaginas-$adjacents-1)) {
                          echo "<li class='page-item'><a class='page-link'>...</a></li>";
                        }
                        // last

                        if($pagina<($TotalPaginas-$adjacents)) {
                          echo "<li class='page-item'><a href='javascript:void(0);'class='page-link ' onclick=\"Buscar($TotalPaginas)\">$TotalPaginas</a></li>";
                        }
                        // next

                        if($pagina<$TotalPaginas) {
                          echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"Buscar($pagina+1)\">$siguiente</a></li>";
                        }else {
                          echo "<li class='page-item'><a class='page-link text-muted'>$siguiente</a></li>";
                        }
                        if ($pagina != $TotalPaginas) {
                          echo "<li class='page-item'><a class='page-link' onclick=\"Buscar($TotalPaginas)\"><span aria-hidden='true'>&raquo;</span></a></li>";
                        }

                        echo "</ul>";
                        echo "</div>";

                  echo "</div>
                      </div>";

                    }
                     ?>
                   </div>

                  </div>
              </div>
          </div>
      </div>
      <style media="screen">
      .colorful-text {
           font-size: 4em;
           font-weight: bold;
           background: linear-gradient(45deg, #f06, #4a90e2, #50e3c2, #f5a623);
           background-clip: text;
           color: transparent;
           text-shadow: 1px 2px 4px rgba(50, 0, 100, 0.3);
           animation: textAnimation 3s infinite linear;

       }
      </style>


 <!-- modal de seleccion de fechas-->
<script type="text/javascript">
function Buscar(page){
    var obt_lis = document.getElementById("selectList").value;
    var listarDeCuanto = verificarList(obt_lis);
    var buscar = document.getElementById("buscar").value;
    document.getElementById("paginas").value=page;
    var fechai=document.getElementById("fechai").value;
    var fechaf=document.getElementById("fechaf").value;
    var estadoProducto=document.getElementById("estadoProducto").value;
    //alert(buscar);
    //ponerFechactualAlModalDeReporte(listarDeCuanto,buscar,page,fecha);
    var datos = new FormData(); // Crear un objeto FormData vacío
    datos.append('pagina', page);
    datos.append('listarDeCuanto',listarDeCuanto);
    datos.append("buscar",buscar);
    datos.append("fechai",fechai);
    datos.append("fechaf",fechaf);
    datos.append("estadoProducto",estadoProducto);
      $.ajax({
        url: "../controlador/farmacia.controlador.php?accion=bft",
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

  function registrar(){
    var cod_producto = document.getElementById("cod_producto").value;
    var cantidad = document.getElementById("cantidad").value;
    var vencimiento = document.getElementById("vencimiento").value;
    var cod_entrada = document.getElementById("cod_entrada").value;
    if(cod_producto == "" || cantidad == "" ||vencimiento==""){
      Vacio();
      return;
    }
    var datos = new FormData(); // Crear un objeto FormData vacío
    datos.append("cod_producto",cod_producto);
    datos.append("cantidad",cantidad);
    datos.append("vencimiento",vencimiento);
    datos.append("cod_entrada",cod_entrada);
      $.ajax({
        url: "../controlador/farmacia.controlador.php?accion=rpe",
        type: "POST",
        data: datos,
        contentType: false, // Deshabilitar la codificación de tipo MIME
        processData: false, // Deshabilitar la codificación de datos
        success: function(data) {
        //alert(data+"dasdas");
          if(data == 'ya_se_uso'){
            usado();
          }else if(data == 'correcto'){
            Correcto();
          }else if(data == 'error'){
            Error1();
          }else{
            cod_entrada='';
          }
          IRalLink(cod_entrada);
        }
      });
  }

    function usado(){
      Swal.fire({
       icon: 'info',
       title: '¡Información!',
       text: '¡No se pudo actualizar porque ya se utilizo, le pido que registre como nuevo!',
       showConfirmButton: false,
       timer: 3000
     });
    }

      function usado2(){
          Swal.fire({
           icon: 'info',
           title: '¡Información!',
           text: '¡No se pudo Desactivar, porque ya se uso la cantidad registrada!',
           showConfirmButton: false,
           timer: 3000
         });
        }
  function Correcto(){
    Swal.fire({
     icon: 'success',
     title: '¡Correcto!',
     text: '¡La acción se realizo correctamente!',
     showConfirmButton: false,
     timer: 1500
   });
  }
  function Error1(){
    Swal.fire({
     icon: 'error',
     title: '¡Error!',
     text: '¡Ocurrio algun error!',
     showConfirmButton: false,
     timer: 1500
   });
  }
  function Vacio(){
    Swal.fire({
     icon: 'error',
     title: '¡Error!',
     text: '¡Campo vacio!',
     showConfirmButton: false,
     timer: 1500
   });
  }

  function IRalLink(cod_entrada){
    if(cod_entrada!=''){
      setTimeout(() => {
        var pagina = document.getElementById("paginas").value;
        if(pagina==''){pagina=1;}
        Buscar(pagina);
        document.getElementById("cod_entrada").value='';
        document.getElementById("cod_producto").value='';
        document.getElementById("cantidad").value='';
        document.getElementById("vencimiento").value='';
        $('#ModalRegistro').modal('hide');
      }, 1500);
    }else{
      setTimeout(() => {
        location.href="../controlador/farmacia.controlador.php?accion=vpf";
        $('#ModalRegistro').modal('hide');
      }, 1500);
    }
  }
  function ActualizarEntrada(cod_entrada,cantidad,vencimiento,cod_generico,nombre_producto){
    document.getElementById('cod_entrada').value=cod_entrada;
    document.getElementById("cantidad").value=cantidad;
    document.getElementById("vencimiento").value=vencimiento;
    document.getElementById("cod_producto").value=cod_generico;
    document.getElementById("nombre_producto").value=nombre_producto;
  }


  function buscarProductoNuevo() {
          //vaciarDESPUESdeUNtiempoAdmision();
          var nombre_producto = document.getElementById("nombre_producto").value;
          if (nombre_producto != "") {
              $.ajax({
                  url: "../controlador/farmacia.controlador.php?accion=bcp",
                  type: "POST",
              		data: {cod_producto:nombre_producto},
              		dataType: "json",
                  success: function(data) {
                    //alert(data);
                    if(data!=""){
                      var unir="";
                      for (let i = 0; i < data.length; i++) {
                        var usuario = data[i];

                        unir+="<div>";
                        unir+="<div id='u' style=' display: inline-block;display:none;'>"+(data[i].cod_generico)+"</div> ";
                        unir+="<div id='u' style=' display: inline-block;'>"+(data[i].codigo)+"</div> ";
                        unir+="<div id='u' style=' display: inline-block;'>"+(data[i].nombre)+"</div> ";
                        unir+="<div id='ap' style=' display: inline-block;'> "+(data[i].nombre_forma)+"</div> ";
                        unir+="<div id='am' style=' display: inline-block;'> "+(data[i].concentracion)+"</div></div>";

                      }

                      visualizarProducto(unir);
                      $('#resultadoProducto div').on('click', function() {
                              //obtenemos los datos del usuario div resultado
                        var cod_producto = $(this).children().eq(0).text();
                        var codigo = $(this).children().eq(1).text();
                        var nombre = $(this).children().eq(2).text();
                        var nombre_forma = $(this).children().eq(3).text();
                        var concentracion = $(this).children().eq(4).text();
                          //dentro de los id de la vista mostramos los datos que estan en el div resultado
                          if(nombre != ""){
                            document.getElementById("nombre_producto").value = (nombre)+" "+(nombre_forma)+" "+(concentracion);
                            document.getElementById("cod_producto").value = cod_producto;
                            $('#resultadoProducto').html(""); //para vaciar
                          }
                      });
                    }else{
                      $('#resultadoProducto').html("<div class='alert alert-light' role='alert'>No se encontro resultados</div>");
                    }

              		}
              	});
              }else{
                $('#resultadoProducto').html("");
                document.getElementById("cod_producto").value='';
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

              function visualizarProducto(unir){

              $('#resultadoProducto').html(unir);
              //colocamos un color de css
              $('#resultadoProducto').css({
               'cursor': 'pointer',
               'font-size':'15px'
               });
      }


        function accionBtnActivar(accion,pagina,listarDeCuanto,buscar,cod_entrada,fechai,fechaf){
          var estadoProducto=document.getElementById("estadoProducto").value;
          var buscar = document.getElementById("buscar").value;
          var datos = new FormData(); // Crear un objeto FormData vacío
          datos.append('accion', accion);
          datos.append("pagina",pagina);
          datos.append("listarDeCuanto",listarDeCuanto);
          datos.append("buscar",buscar);
          datos.append("fechai",fechai);
          datos.append("fechaf",fechaf);
          datos.append("estadoProducto",estadoProducto);
          datos.append("cod_entrada",cod_entrada);
          //alert(accion+"   "+buscar+"    "+cod_generico);
          $.ajax({
            url: "../controlador/farmacia.controlador.php?accion=dbe",
            type: "POST",
            data: datos,
            contentType: false, // Deshabilitar la codificación de tipo MIME
            processData: false, // Deshabilitar la codificación de datos
            success: function(data) {
        //alert(data+"dasdas");
              data=$.trim(data);
              if(data == "error"){
                error();
              }else if(data == 'ya_se_uso'){
                usado2();
              }else{
                $("#verDatos").html(data);
              }
            }
          });
        }

      function error(){
        Swal.fire({
         icon: 'error',
         title: '¡Error!',
         text: '¡Ocurrio un error!',
         showConfirmButton: false,
         timer: 1500
       });
      }
      function reporte(){
        var buscar = document.getElementById("buscar").value;
        var fechai = document.getElementById("fechai").value;
        var fechaf = document.getElementById("fechaf").value;
        var estadoProducto = document.getElementById("estadoProducto").value;
        var form = document.createElement('form');
         form.method = 'post';
         form.action = '../controlador/farmacia.controlador.php?accion=rpng'; // Coloca la URL de destino correcta
         // Agregar campos ocultos para cada dato
         var datos = {
           buscar:buscar,
           fechai:fechai,
           fechaf:fechaf,
           estadoProducto:estadoProducto
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

</script>
<?php require("../librerias/footeruni.php"); ?>
