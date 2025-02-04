<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
	$bd	   = new Db ;
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $tipo              =  trim($_GET['tipo']);
    $uso               =  trim($_GET['uso']);
    $sesion 	       =  trim($_SESSION['email']);
    $documento_array   =  $bd->__user( $sesion );
    $unidad            =  $documento_array['id_departamento'];
    $siglas            =  $documento_array['siglas'];
    
    $idcaso              =  trim($_GET['idcaso']);
    

    $anio  = date('Y');


    $datos_busqueda = $bd->_busca_documento($unidad,$idcaso,$anio,$sesion,$tipo);

    if ( $datos_busqueda['secuencia'] > 0 )  {
        $datos  =  $datos_busqueda ;
     }else {
        $datos  = $bd->__documento_secuencia($anio,$tipo,$unidad,0);
        $valida = $bd->__documento_reserva($unidad,$datos['secuencia'], $sesion,$tipo ,$anio , $idcaso  ,$datos['documento']  );
    }
    
    echo json_encode(
        array("a"=>$datos['documento']  , 
              "b"=>$datos['secuencia'] 
             )
        );
  
?>