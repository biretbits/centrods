<?php
/**
 *
 */

class Farmacia
{

  function __construct()
	{
		require_once("conexion.php");

			//llamando al metodo Conectaras de la clase Conexion para realizar los metodos de insert update delete
			$co=new Conexion();
			$this->con= $co->Conectaras();
	}

  public function SeleccionarNombreGenerico($inicioList=false,$listarDeCuanto=false,$buscar='',$codNombreGenerico=false){
    $sql = "select p.cod_generico,p.codigo,p.nombre,p.enfermedad,p.vitrina,p.stockmin,p.stockmax,p.cod_forma,p.cod_conc,p.cod_usuario,
    p.stock_producto,p.cantidad_total,p.estado,f.cod_forma,f.nombre_forma,c.cod_conc,c.concentracion,u.cod_usuario,u.nombre_usuario,u.ap_usuario,u.am_usuario
     from producto as p inner join forma_presentacion as f on p.cod_forma=f.cod_forma inner join conc_uni_med as c on p.cod_conc=c.cod_conc inner join usuario as u where p.cod_usuario = u.cod_usuario ";
    if($buscar != ''){
       $sql.=" and (LOWER(p.nombre) LIKE '%".$buscar."%' or LOWER(p.codigo) LIKE '%".$buscar."%') ";
    }
    if(is_numeric($inicioList)&&is_numeric($listarDeCuanto)){
      $sql.=" ORDER BY p.cod_generico DESC LIMIT $listarDeCuanto OFFSET $inicioList ";
    }
    $resul = $this->con->query($sql);
    // Retornar el resultado
    if($resul===false){
      return $this->con->error;
    }else{
      return $resul;
    }
    mysqli_close($this->con);
  }

  public function SeleccionarConcentracion($inicioList=false,$listarDeCuanto=false,$buscar=''){
    $sql = "select *from conc_uni_med";
    if($buscar != ''){
       $sql.=" where LOWER(concentracion) LIKE '%".$buscar."%' ";
    }
    if(is_numeric($inicioList)&&is_numeric($listarDeCuanto)){
      $sql.=" ORDER BY cod_conc DESC LIMIT $listarDeCuanto OFFSET $inicioList ";
    }
    $resul = $this->con->query($sql);
    // Retornar el resultado
    return $resul;
    mysqli_close($this->con);
  }

  public function SeleccionarPresentacion($inicioList=false,$listarDeCuanto=false,$buscar=''){
    $sql = "select *from forma_presentacion";
    if($buscar != ''){
       $sql.=" where LOWER(nombre_forma) LIKE '%".$buscar."%' ";
    }
    if(is_numeric($inicioList)&&is_numeric($listarDeCuanto)){
      $sql.=" ORDER BY cod_forma DESC LIMIT $listarDeCuanto OFFSET $inicioList ";
    }
    $resul = $this->con->query($sql);
    // Retornar el resultado
    return $resul;
    mysqli_close($this->con);
  }


  public function InsertarActualizarPresentacion($generico,$cod_generico){
    $sql = '';
    if(is_numeric($cod_generico)){//actualizar
      $sql = "update forma_presentacion set nombre_forma='".$generico."' where cod_forma = $cod_generico";
    }else{//insertar
      $sql = "insert into forma_presentacion(nombre_forma)values('".$generico."');";
    }
    $resul = $this->con->query($sql);
    // Retornar el resultado
    return $resul;
    mysqli_close($this->con);
  }

  public function InsertarActualizarNombreGenerico($generico,$cod_generico,$enfermedad,$vitrina,$stockmin,$stockmax,$cod_forma,$cod_conc,$usuario,$codigo){
    $sql = '';
    if(is_numeric($cod_generico)){//actualizar
      $sql = "update producto set codigo='".$codigo."',nombre='".$generico."',enfermedad='".$enfermedad."',vitrina='".$vitrina."',stockmin=$stockmin,";
      $sql.="stockmax=$stockmax,cod_forma=$cod_forma,cod_conc=$cod_conc,fechaHora=now() where cod_generico = $cod_generico";
    }else{//insertar
      $sql = "insert into producto(codigo,nombre,enfermedad,vitrina,stockmin,stockmax,cod_forma,cod_conc,cod_usuario,fechaHora,estado)values";
      $sql.="('".$codigo."','".$generico."','".$enfermedad."','".$vitrina."',$stockmin,$stockmax,$cod_forma,$cod_conc,$usuario,now(),'activo');";
    }
    $resul = $this->con->query($sql);
    // Retornar el resultado
    return $resul;
    mysqli_close($this->con);
  }

  public function InsertarActualizarConcentracion($generico,$cod_generico){
    $sql = '';
    if(is_numeric($cod_generico)){//actualizar
      $sql = "update conc_uni_med set concentracion='".$generico."' where cod_conc = $cod_generico";
    }else{//insertar
      $sql = "insert into conc_uni_med(concentracion)values('".$generico."');";
    }
    $resul = $this->con->query($sql);
    // Retornar el resultado
    return $resul;
    mysqli_close($this->con);
  }


  public function p(){
    $sql = "select *from p";
    $resul = $this->con->query($sql);
    // Retornar el resultado
    return $resul;
    mysqli_close($this->con);
  }

  public function SeleccionarProducto($inicioList=false,$listarDeCuanto=false,$buscar='',$fechai=false,$fechaf=false,$estadoProducto=false){
    $sql="select e.cod_entrada,e.cantidad,e.respaldo_cantidad,e.manipulado,e.vencimiento,e.fecha,e.cod_usuario,e.cod_generico,e.estado_producto,e.estado,
    p.codigo,p.nombre,p.cod_forma,p.cod_conc,u.cod_usuario,u.nombre_usuario,u.ap_usuario,u.am_usuario
    from entrada as e inner join producto as p on e.cod_generico=p.cod_generico
    inner join usuario as u where e.cod_usuario=u.cod_usuario ";
    if($estadoProducto != false){
      $sql.=" and e.estado_producto ='$estadoProducto' ";
    }
    if($buscar !=''){
      $sql.=" and (p.nombre LIKE '%$buscar%' or p.codigo like '%$buscar%')";
    }
    if($fechai!=false &&$fechaf!=false){
      $sql.=" and (e.fecha >= '$fechai' and e.fecha <= '$fechaf') ";
    }
    if(is_numeric($inicioList)&&is_numeric($listarDeCuanto)){
      $sql.=" ORDER BY e.cod_entrada DESC LIMIT $listarDeCuanto OFFSET $inicioList ";
    }
    //echo "<br>".$sql;
    $resul = $this->con->query($sql);
    // Retornar el resultado
    if($resul===false){
      return $this->con->error;
    }else{
      return $resul;
    }
    return $resul;
    mysqli_close($this->con);
 }

 public function seleccionarNG(){
   $sql = "select * from producto as p inner join forma_presentacion as f on p.cod_forma=f.cod_forma inner join conc_uni_med as c on p.cod_conc=c.cod_conc and p.estado = 'activo'";
   $resul = $this->con->query($sql);
   // Retornar el resultado
   return $resul;
   mysqli_close($this->con);
 }
 public function seleccionarC(){
   $sql = "select *from conc_uni_med";
   $resul = $this->con->query($sql);
   // Retornar el resultado
   return $resul;
   mysqli_close($this->con);
 }
 public function seleccionarP(){
   $sql = "select *from forma_presentacion";
   $resul = $this->con->query($sql);
   // Retornar el resultado
   return $resul;
   mysqli_close($this->con);
 }
 public function seleccionarCID($id){
   $sql = "select *from conc_uni_med where cod_conc = $id";
   $resul = $this->con->query($sql);
   // Retornar el resultado
   return $resul;
   mysqli_close($this->con);
 }
 public function seleccionarPID($id){
   $sql = "select *from forma_presentacion where cod_forma = $id";
   $resul = $this->con->query($sql);
   // Retornar el resultado
   return $resul;
   mysqli_close($this->con);
 }

 public function InsertEntradaProducto($cantidad,$vencimiento,$fechaActual,$cod_producto,$cod_entrada,$usuario,$hora){
   $sql = "";$uso = '';
   if(is_numeric($cod_entrada)){//update
      $uso = $this->verificarSIcantidadSEuso($cod_entrada);
      if($uso =='no_se_uso'){
        $sql="update entrada set cantidad=$cantidad,respaldo_cantidad=$cantidad,vencimiento='$vencimiento',cod_generico=$cod_producto where cod_entrada = $cod_entrada";
      }
   }else{//insert
      $sql="insert into entrada(cantidad,respaldo_cantidad,vencimiento,fecha,hora,cod_usuario,cod_generico)values($cantidad,$cantidad,'$vencimiento','$fechaActual','$hora',$usuario,$cod_producto)";
   }
   if($uso=='' or $uso=='no_se_uso')
   {
     $resul = $this->con->query($sql);

    if($resul !=''){
      return "correcto";
    }else{
      return "error";
    }
  }else{
    return $uso;
  }
   mysqli_close($this->con);
 }

 function verificarSIcantidadSEuso($cod_entrada){
   $lis = "select *from entrada where cantidad=respaldo_cantidad and cod_entrada = $cod_entrada";
   $resul = $this->con->query($lis);
   $si = 'no_se_uso';
   if($resul->num_rows > 0){
      $si='no_se_uso';//si es mayor a cero esto quiere decir que hay una fila osea esta intacto sin usar
   }else{
     $si='ya_se_uso';//no esta intacto ya se utilizo la cantidad
   }
   return $si;
 }

 public function buscarProductoFar($nombre_producto){
   $nombre_producto = strtolower($nombre_producto);
   $lis = "select *from producto as p inner join forma_presentacion as f on p.cod_forma=f.cod_forma inner join conc_uni_med as c on p.cod_conc=c.cod_conc WHERE p.estado='activo' and LOWER(p.nombre) LIKE '%$nombre_producto%' LIMIT 5 OFFSET 0;";
   $resul = $this->con->query($lis);
   return $resul;
   mysqli_close($this->con);
 }
//funcion para seleccionar de tabla salida
 public function SeleccionarSalida($inicioList=false,$listarDeCuanto=false,$buscar='',$fechai=false,$fechaf=false){
     $sql="select *from salida as s inner join producto as p where s.cod_generico=p.cod_generico";
     if($buscar !=''){
       $sql.=" and (p.nombre LIKE '%$buscar%' or p.codigo LIKE '%$buscar%')";
     }
     if($fechai!=false &&$fechaf!=false){
       $sql.=" and (s.fecha >= '$fechai' and s.fecha <= '$fechaf') ";
     }
     if(is_numeric($inicioList)&&is_numeric($listarDeCuanto)){
       $sql.=" ORDER BY s.cod_salidad DESC LIMIT $listarDeCuanto OFFSET $inicioList ";
     }
     //echo $sql;
     $resul = $this->con->query($sql);
     // Retornar el resultado
     return $resul;
     mysqli_close($this->con);

 }

 public function UpdateNG($accion,$cod_generico){
   if($accion == 'activo'){
       $sql = "update producto set estado = 'desactivo' where cod_generico=".$cod_generico;
   }else{
       $sql = "update producto set estado = 'activo' where cod_generico=".$cod_generico;
   }
   $resul = $this->con->query($sql);
   // Retornar el resultado
   return $resul;
   mysqli_close($this->con);
 }

 public function UpdateEF($accion,$cod_entrada){
   $uso='';
   $uso=$this->verificarSIcantidadSEuso($cod_entrada);
   if($uso == "ya_se_uso")
   {
     return $uso;
   }else{
     if($accion == 'activo'){
         $sql = "update entrada set estado = 'desactivo' where cod_entrada=".$cod_entrada;
     }else{
         $sql = "update entrada set estado = 'activo' where cod_entrada=".$cod_entrada;
     }
     $resul = $this->con->query($sql);
     // Retornar el resultado
     if($resul != ''){
       return "correcto";
     }else{
       return "error";
     }
   }
   mysqli_close($this->con);
 }

 public function buscarPacienteFar($nombre_paciente){
   $nombre_paciente = strtolower($nombre_paciente);
   $lis = "select *from usuario WHERE (LOWER(nombre_usuario) LIKE '%$nombre_paciente%' or LOWER(ap_usuario) like '%$nombre_paciente%') and tipo_usuario='paciente' and estado='activo' LIMIT 5 OFFSET 0;";
   $resul = $this->con->query($lis);
   return $resul;
   mysqli_close($this->con);
 }


   public function entradaTodo($fechaActual,$cod_generico){
     $sql = "select *from entrada where vencimiento >= '$fechaActual' and cod_generico=$cod_generico and estado = 'activo' order by vencimiento asc";
     $resul = $this->con->query($sql);
     // Retornar el resultado
     return $resul;
     mysqli_close($this->con);
   }

   public function actualizarCantidad($nueva_cantidad,$cod_entrada){
     //echo $nueva_cantidad."  =  ".$cod_entrada."<br>";
     $sql = "update entrada set cantidad = $nueva_cantidad where cod_entrada=".$cod_entrada;
     $this->con->query($sql);
    // mysqli_close($this->con);
   }

   public function seleccionarEntradas(){
     $select="select *from entrada where estado = 'activo'";
     $resul = $this->con->query($select);
     // Retornar el resultado
     return $resul;
   }

   public function ProductoVencido($cod_entrada){
     $select="update entrada set estado_producto='vencido' where cod_entrada=".$cod_entrada."";
     $resul = $this->con->query($select);
     // Retornar el resultado
     return $resul;
   }

   public function SeleccionarProductosTodo(){
     $select="select *from producto where estado='activo'";
     $resul = $this->con->query($select);
     // Retornar el resultado
     return $resul;
   }

   public function actualizarCantidadNuevo($si,$cantidad_total,$cod_generico){
     $sql= "update producto set stock_producto='$si',cantidad_total=".$cantidad_total." where cod_generico=".$cod_generico."";
     $this->con->query($sql);
   }

   public function insertarNuevoRegistroSalida($cod_producto,$cantidad,$cod_salida,$id_paciente,$codigos,$usuario,$fechaActual,$cat_res,$hora){
     $select = '';
     if(is_numeric($cod_salida)){//actualizar
       $select="update salida set cantidad_salida=$cantidad,codigos_entrada='$codigos',cantidadRestado='$cat_res',cod_generico=$cod_producto,
       cod_usuario=$usuario,cod_paciente=$id_paciente where cod_salidad = $cod_salida";
     }else{//insertar
       $select="insert into salida(cantidad_salida,codigos_entrada,cantidadRestado,cod_generico,cod_usuario,cod_paciente,fecha,hora)
       values($cantidad,'$codigos','$cat_res',$cod_producto,$usuario,$id_paciente,'$fechaActual','$hora')";
    }
    //echo $select;
     $resul = $this->con->query($select);
     // Retornar el resultado
     return $resul;
     mysqli_close($this->con);
   }

   public function actualizar_datos_entrada($cod_salida){
     $resultado = $this->SeleccionarSalidaID($cod_salida);
     $fila = mysqli_fetch_array($resultado);
     $codigos = $fila["codigos_entrada"];
     $cantidad_resta = $fila["cantidadRestado"];
     $separar = explode(',', $codigos);
     $sepa = explode(',',$cantidad_resta);
     //primero verificamos si uno de los productos ya vencio o no vencio
     $re= '';
     $re=$this->verificarVencimientoPrimero($separar);
     if($re==0){
        return $re;
      }else{
        return $re;
      }
   }

   function verificarVencimientoPrimero($codigos_sep) {
     $c = 0;
     for ($i = 0; $i < count($codigos_sep); $i++) {
         $select = "SELECT * FROM entrada WHERE cod_entrada = $codigos_sep[$i] AND estado_producto = 'vencido' AND estado = 'activo'";
         $resul = $this->con->query($select);
         if ($resul) {
             if (mysqli_num_rows($resul) > 0) {
                 $c = 1;
                 break;
             }
         }
     }
     return $c;
 }

   public function SeleccionarSalidaID($cod_salida){
     $select="select *from salida where cod_salidad = $cod_salida";
     $resul = $this->con->query($select);
     // Retornar el resultado
     return $resul;
   }

   public function actualizarCantidadEntradaDesdeSalida($nueva_cantidad,$cod_entrada){
    $re = $this->detectarMayor($cod_entrada);
    $c = $re[0];
    $cantOLD = $re[1];
    //echo $c."   ".$cantOLD;
    if($c == 'si'){
      //echo "lleggooooooooo";
      $sql = "update entrada set cantidad = $cantOLD where cod_entrada=".$cod_entrada;
    }else{
      $sql = "update entrada set cantidad = (cantidad+$nueva_cantidad) where cod_entrada=".$cod_entrada;
    }
    $this->con->query($sql);
   }

   function detectarMayor($cod_entrada){
     $sql = "select *from entrada where cantidad>=respaldo_cantidad and cod_entrada = $cod_entrada and estado = 'activo'";
     $resul = $this->con->query($sql);
     $c = "no";
     $cantOLD = "";
     if($resul){
       if(mysqli_num_rows($resul)>0){
         $fi = mysqli_fetch_array($resul);
         $cantOLD = $fi['respaldo_cantidad'];
        $c="si";
       }
     }
     return array($c,$cantOLD);
   }

   public function seleccionarCantEntrada($cod_salida){
     $resultado = $this->SeleccionarSalidaID($cod_salida);
     $fila = mysqli_fetch_array($resultado);
     $codigos = $fila["codigos_entrada"];
     $cantidad_resta = $fila["cantidadRestado"];
     $separar = explode(',', $codigos);
     $sepa = explode(',',$cantidad_resta);
     return array($separar,$sepa);
   }

   public function SumasActualizar($codigos,$cantiEntra){
     for ($i = 0; $i < count($codigos); $i++) {
       $this->actualizarCantidadEntradaDesdeSalida($cantiEntra[$i],$codigos[$i]);
     }
   }

   public function eliminarRegistro($cod_salida){
     $select="delete from salida where cod_salidad = $cod_salida";
     $resul = $this->con->query($select);
     // Retornar el resultado
     return $resul;
   }

}



 ?>
