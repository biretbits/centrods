<br><br><br><br>
<?php
require "controlador/sesion.controlador.php";
$ins=new sesionControlador();
$ins->StarSession();
    require_once("librerias/headeradmin.php");
    
    require('vista/principal/sql.php');
    include('vista/principal/principalClinica.php');


?>


<?php
    require_once "librerias/footeruni.php";
?>
<style type="text/css">

  #grafica{

    max-width: 500px;

    max-height: 500px

  }

</style>
