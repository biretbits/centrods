
<!DOCTYPE html>
<html lang="es">
<head>
    <title></title>

    	<meta charset="utf-8">

     		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script src="activos/jquery-3.5.1.min.js"></script>
        <script src="activos/Chart.min.js"></script>
        <link rel="stylesheet" type="text/css" href="activos/bootstrap/bootstrap.min.css">

        <script src="activos/bootstrap/bootstrap.min.js"></script>
        <script src="activos/sweetAlert2/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="activos/sweetAlert2/sweetalert2.min.css">
        <link href="activos/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="activos/styles.css" rel="stylesheet" />

</head>
<style type="text/css">
html, body {
      height: 100%;
      margin: 0;
      padding: 0;
  }

  body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
  }
  .content {
    flex: 1 0 auto;
  }
  .main-content {
      padding-top: 80px; /* Ajusta este valor según la altura de tu navbar */
  }
  #co{
    color:gray;
    font-size: 17px
  }
  /* Estilo del cuerpo del modal */
  .modal-body {
      height: 100%; /* Ocupa el 100% de la altura del modal */
      overflow: hidden; /* Evita que el contenido haga scroll */
      padding: 0; /* Ajusta el relleno si es necesario */
  }

  /* Contenedor de contenido dentro del modal */
  .wrapper {
      width: 100%;
      background: white;
      border-radius: 5px;
      border: 1px solid lightgrey;
      border-top: 0px;
      height: 100%; /* Ocupa el 100% de la altura del modal */
      box-sizing: border-box; /* Incluye el padding y el borde en el ancho y alto */
  }

  /* Estilo del formulario dentro del contenedor */
  .wrapper .form {
      padding: 30px 15px;
      min-height: 300px;
      max-height: 300px;
      overflow-y: auto; /* Permite el scroll solo si el contenido excede el tamaño */
  }

  /* Estilos para el inbox y otros elementos dentro del formulario */
  .wrapper .form .inbox {
      width: auto;
      display: flex;
      align-items: baseline;
  }

  .wrapper .form .user-inbox {
      justify-content: flex-end;
      margin: 13px 0;
  }

  .wrapper .form .inbox .icon {
      height: 33px;
      width: 33px;
      color: #fff;
      text-align: center;
      line-height: 40px;
      border-radius: 50%;
      font-size: 18px;
      background: red;
  }

  .wrapper .form .inbox .msg-header {
      max-width: 60%;
      margin-left: 10px;
  }

  .wrapper .form .inbox .msg-header p {
      color: #fff;
      background: Teal;
      border-radius: 10px;
      padding: 8px 10px;
      font-size: 14px;
      word-break: break-all;
  }

  .wrapper .form .user-inbox .msg-header p {
      color: #333;
      background: #efefef;
  }


  .titleNew {
      background: Teal;
      color: #fff;
      font-size: 20px;
      font-weight: 500;
      line-height: 60px;
      text-align: center;
      border-bottom: 1px solid lime;
      border-radius: 5px 5px 0 0;
  }

  /* Estilo del botón para abrir el chatbot */
  #openChatbot {
      position: fixed;
      bottom: 5px;
      right: 10px;
      border-radius: 50%;
      background-color: #007bff;
      color: white;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      cursor: pointer;
      z-index: 1051; /* Asegúrate de que esté sobre otros elementos */
  }

  /* Contenedor del chatbot */
  .chatbot-container {
      position: fixed;
      bottom: 80px; /* Ajusta la distancia desde la parte inferior para que aparezca más arriba del botón */
      right: -1px;
      width: 400px;
      height: 400px;
      border: 1px solid lightgrey;
      border-radius: 5px;
      background: white;
      transform: translateY(100%);
      transition: transform 0.3s ease-in-out;
      z-index: 1050; /* Asegúrate de que esté debajo del botón pero sobre otros elementos */
  }

  .chatbot-container.d-block {
      transform: translateY(0);
  }

  /* Estilo del encabezado del chatbot */
  .chatbot-header {
      background: teal;
      color: white;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
  }

  /* Estilo del cuerpo del chatbot */
  .chatbot-body {
      padding: 15px;
      height: calc(100% - 100px); /* Ajusta la altura restante después del header y footer */
  }

  /* Estilo del pie del chatbot */
  .chatbot-footer {
      display: flex;
      align-items: center; /* Alinea verticalmente */
      gap: 1px; /* Espacio entre el input y el botón */
  }

  .chatbot-footer input {
      flex: 1; /* Ocupa el espacio disponible */
  }

  .chatbot-footer button {
      flex-shrink: 0; /* Evita que el botón se reduzca */
      width: auto; /* Ajusta el tamaño del botón automáticamente */
      height: auto; /* Ajusta la altura del botón automáticamente */
      padding: 5px 10px; /* Ajusta el padding del botón para hacerlo más pequeño */
  }
  </style>
<body  id="page-top">

  <button type="button" class="btn btn-primary" id="openChatbot">💬</button>

  <div class="content">

  <?php
  $name = "";
  if(isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] != ""){
    $name = $_SESSION["usuario"];
  }

  echo "<nav style=' border-bottom: 1px solid silver;' class='navbar navbar-expand-lg navbar-light fixed-top shadow-sm' id='mainNav'>
    <div class='container px-5'>
        <a href='#' class='navbar-brand fw-bold'><img src='imagenes/cds.ico' height='30' width='30' class='rounded-circle'> Centro De Salud</a>

        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarResponsive' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            Menu <span class='navbar-toggler-icon'></span>
        </button>
          <div class='collapse navbar-collapse' id='navbarResponsive'>
            <ul class='navbar-nav ms-auto me-4 my-3 my-lg-0'>
                <li class='nav-item' title='Inicio'>
                  <a class='nav-link btn btn-outline-warning' href='controlador/logeo.controlador.php?accion=ix'><img src='imagenes/house.ico'style='height: 25px;width: 25px;'></a>
                </li>";
              if(isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] == "admin"){
              echo "
                <li class='nav-item' title='Usuarios'>
                    <a class='nav-link btn btn-outline-warning' href='controlador/usuario.controlador.php?accion=vut'><img src='imagenes/admin.ico'style='height: 25px;width: 25px;'></a>
                </li>";
                echo "
                  <li class='nav-item' title='Servicios'>
                      <a class='nav-link btn btn-outline-warning' href='controlador/servicio.controlador.php?accion=rsr'><img src='imagenes/servicio.ico'style='height: 25px;width: 25px;'></a>
                  </li>";
                echo "
                  <li class='nav-item' title='ChatBot'>
                      <a class='nav-link btn btn-outline-warning' href='controlador/chat.controlador.php?accion=tcb'><img src='imagenes/robot.png'style='height: 25px;width: 25px;'></a>
                  </li>";

              }else if(isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] == "admision"){
                echo "
                  <li class='nav-item' title='Registro diario'>
                      <a class='nav-link btn btn-outline-warning' href='controlador/registroDiario.controlador.php?accion=vtd'><img src='imagenes/archivo.ico'style='height: 25px;width: 25px;'></a>
                  </li>";
                echo "<li class='nav-item dropdown' title='Reportes'>
                    <a class='nav-link dropdown-toggle btn btn-outline-warning' href='#' id='navbarDropdown2' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                      <img src='imagenes/reporte.ico'style='height: 25px;width: 25px;'> Reportes
                    </a>
                    <ul class='dropdown-menu' aria-labelledby='navbarDropdown2'>";
                echo "<li class='nav-item' title='Pacientes atendidos por servicio'>
                        <a class='nav-link btn btn-outline-warning' href='controlador/servicio.controlador.php?accion=vTs'><img src='imagenes/servicio.ico'style='height: 25px;width: 25px;'> Pacientes atendidos</a>
                      </li>
                      ";
                echo "<li class='nav-item' title='Pacientes atendidos por servicio por sexo'>
                        <a class='nav-link btn btn-outline-warning' href='controlador/servicio.controlador.php?accion=rtsx'><img src='imagenes/servicio.ico'style='height: 25px;width: 25px;'> Pacientes atendidos por sexo</a>
                      </li>
                      ";

                echo "<li class='nav-item' title='Pacientes atendidos por servicio por edad'>
                        <a class='nav-link btn btn-outline-warning' href='controlador/servicio.controlador.php?accion=rGE'><img src='imagenes/servicio.ico'style='height: 25px;width: 25px;'> Pacientes atendidos por edad</a>
                      </li>
                      ";
              echo "</ul>
              </li>";
              }

            if(isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] == "farmacia"){
              echo "<li class='nav-item dropdown' title='Farmacia'>
                <a class='nav-link dropdown-toggle btn btn-outline-warning' href='#' id='navbarDropdown2' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                  <img src='imagenes/farmacia.ico'style='height: 25px;width: 25px;'> Farmacia
                </a>
                <ul class='dropdown-menu' aria-labelledby='navbarDropdown2'>";
              echo "
                <li class='nav-item' title='Productos Farmacéuticos'>
                    <a class='nav-link btn btn-outline-warning' href='controlador/farmacia.controlador.php?accion=ngf'>Productos Farmacéuticos</a>
                </li>";
                echo "
                  <li class='nav-item' title='Concentración Unidad de medida'>
                      <a class='nav-link btn btn-outline-warning' href='controlador/farmacia.controlador.php?accion=vtf'>Concentración</a>
                  </li>";
                  echo "
                    <li class='nav-item' title='Forma de presentación'>
                        <a class='nav-link btn btn-outline-warning' href='controlador/farmacia.controlador.php?accion=vfp'>Presentación</a>
                    </li>";
                  echo "
                    <li class='nav-item' title='Entrada'>
                        <a class='nav-link btn btn-outline-warning' href='controlador/farmacia.controlador.php?accion=vpf'>Entrada</a>
                    </li>";
                  echo "
                    <li class='nav-item' title='Salida'>
                        <a class='nav-link btn btn-outline-warning' href='controlador/farmacia.controlador.php?accion=vsf'>Salida</a>
                    </li>";
                echo "</ul>
                </li>";
            }
             if(isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] != ""){
              echo "<li class='nav-item dropdown' title='Nombre Usuario'>
                <a class='nav-link dropdown-toggle btn btn-outline-success' href='#' id='navbarDropdown2' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    hola ".$name."
                </a>
                <ul class='dropdown-menu' aria-labelledby='navbarDropdown2'>
                    <li class='nav-item ' title='Cerrar sesión' style='color:green'>
                      <a class='nav-link text-info btn btn-outline-warning' href='#'>Editar</a>
                    </li>
                    <li><hr class='dropdown-divider'></li>
                    <li class='nav-item ' title='Cerrar sesión' style='color:green'>
                      <a class='nav-link text-primary btn btn-outline-danger' href='controlador/logeo.controlador.php?accion=salir'><img src='imagenes/apagar.ico'style='height: 25px;width: 25px;'></a>
                    </li>
                </ul>
                </li>";
            }else{
              echo "
                  <li class='nav-item'>
                      <a class='nav-link btn btn-outline-secondary' href='controlador/logeo.controlador.php?accion=is'>Iniciar sesión</a>
                  </li>";
            }
      echo "</ul>
        </div>
    </div>
</nav>
";


?>
<!-- Modal del Chatbot -->
<div id="chatbotContainer" class="chatbot-container d-none">
      <div class="chatbot-header">
          <h5>Chatbot</h5>
          <button type="button" class="btn-close" id="closeChatbot"></button>
      </div>
      <div class="chatbot-body">
          <div class="wrapper">
              <div class="form">
                  <div class="bot-inbox inbox">
                      <div class="icon">
                          <i class="fas fa-user"></i>
                      </div>
                      <div class="msg-header">
                          <p>Hola, Bienvenido</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="chatbot-footer">
          <input id="data" class='form-control' type="text" onkeydown="checkEnter(event)" placeholder="Escriba su consulta">
          <button id="send-btn" width='20px' height='20px'class='btn btn-primary' onclick="enviar()" style='background:Teal'>Enviar</button>
      </div>
  </div>

<script type="text/javascript">
function checkEnter(event) {
    if (event.key === 'Enter') {
            enviar();
    }
}
function alertInfo(){
  Swal.fire({
   icon: 'info',
   title: '¡Información!',
   text: '¡Ponga algo para realizar su consulta!',
   showConfirmButton: false,
   timer: 1500
 });
}
function enviar(){
    var va=document.getElementById("data").value;
    if(va == ''){
      alertInfo();
      return;
    }
    var msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + va + '</p></div></div>';
    $(".form").append(msg);
    $("#data").val('');
    var datos=new  FormData();
    datos.append("mensaje",va);
    //alert(va);
    $.ajax({
      cache: false, //important or else you might get wrong data returned to you
      url: 'controlador/chat.controlador.php?accion=msu',
      datatype: "html",
      type: 'POST',
      data: datos,
      contentType:false,
      processData:false,
      success: function(result) {
      //  alert(result);
          var replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' + result + '</p></div></div>';
          $(".form").append(replay);
              // cuando el chat baja, la barra de desplazamiento llega automáticamente al final
              $(".form").scrollTop($(".form")[0].scrollHeight);
          }
      });
  }

  // script.js
  document.addEventListener('DOMContentLoaded', function () {
      const openButton = document.getElementById('openChatbot');
      const closeButton = document.getElementById('closeChatbot');
      const chatbotContainer = document.getElementById('chatbotContainer');

      // Función para abrir el chatbot
      openButton.addEventListener('click', function () {
          chatbotContainer.classList.remove('d-none');
          chatbotContainer.classList.add('d-block');
      });

      // Función para cerrar el chatbot
      closeButton.addEventListener('click', function () {
          chatbotContainer.classList.remove('d-block');
          chatbotContainer.classList.add('d-none');
      });

      // También puedes hacer que el chatbot se cierre si se hace clic fuera de él, si así lo deseas
      document.addEventListener('click', function (event) {
          if (!chatbotContainer.contains(event.target) && !openButton.contains(event.target)) {
              chatbotContainer.classList.remove('d-block');
              chatbotContainer.classList.add('d-none');
          }
      });
  });

</script>
