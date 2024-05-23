<?php
/**
 *
 */

class RegistroDiario
{

  function __construct()
	{
		require_once("conexion.php");

			//llamando al metodo Conectaras de la clase Conexion para realizar los metodos de insert update delete
			$co=new Conexion();
			$this->con= $co->Conectaras();
	}

  public function SelectDatosRegistroDiario() {
    $lis = "select *from registro_diario where estado='activo'";
    $resul = $this->con->query($lis);
    return $resul;
    mysqli_close($this->con);
  }

  public function SelectPorBusquedaRegistroDiario($buscar,$inicioList,$listarDeCuanto){
    // Verificar si $buscar tiene contenido
    $sql = "SELECT * FROM usuario as u inner join registro_diario as rd on u.cod_usuario = rd.paciente_rd where u.tipo_usuario = 'paciente' and rd.estado = 'activo'";
    if ($buscar != "" && $buscar != null) {
        // Convertir $buscar a minúsculas
        $buscar = strtolower($buscar);
        $sql.=" and LOWER(u.nombre_usuario) LIKE '%".$buscar."%'
        OR LOWER(u.ap_usuario) LIKE '%".$buscar."%' OR LOWER(u.am_usuario) LIKE '%".$buscar."%' ";
    }
    if(is_numeric($inicioList)&&is_numeric($listarDeCuanto)){
      $sql.=" ORDER BY rd.cod_rd DESC LIMIT $listarDeCuanto OFFSET $inicioList ";
    }

    $resul = $this->con->query($sql);
    // Retornar el resultado
    return $resul;
    mysqli_close($this->con);
  }

  public function selectNombreUsuario($id){
    $sql = "select nombre_usuario,ap_usuario,am_usuario from usuario where cod_usuario = $id";
    $resul = $this->con->query($sql);
    // Retornar el resultado
    $fi = mysqli_fetch_array($resul);
    return $fi["nombre_usuario"]." ".$fi["ap_usuario"]." ".$fi["am_usuario"];
    mysqli_close($this->con);
  }


  public function buscarPacientesql($nombre){
    $nombre = strtolower($nombre);
    $lis = "select *from usuario where LOWER(nombre_usuario) like '%$nombre%'";
    $resul = $this->con->query($lis);
    return $resul;
    mysqli_close($this->con);
  }
}



 ?>
