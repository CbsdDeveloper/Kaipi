<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
   
 
    
   
    
    $sql = "SELECT    idprov, razon, direccion, telefono, emaile as correo, movil,
                      idciudad, nombre, apellido, id_departamento
				  FROM view_nomina_rol
				  where upper(razon) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
    
    
    $resultado1 = $bd->ejecutar($sql);
    
    $dataProv  = $bd->obtener_array( $resultado1);
    
 
    
    $nombre   =  trim($dataProv['nombre']);
    $apellido =  trim($dataProv['apellido']);
    
    $alog     = explode(' ', $apellido);
    
    $login = strtolower ( substr($nombre,0,1).trim($alog[0]));
    
    echo json_encode( array("a"=>trim($dataProv['idprov']), 
                            "b"=> trim($apellido),
                            "c"=> trim($nombre),
                            "d"=> trim($dataProv['correo']),
                            "e"=> trim($login),
                            "f"=> ($dataProv['idciudad']),
                            "g"=> trim($dataProv['direccion']),
                            "h"=> trim($dataProv['telefono']),
                            "i"=> trim($dataProv['movil']),
                            "j"=> trim($dataProv['id_departamento']),
                             ) );
    

  
    
?>