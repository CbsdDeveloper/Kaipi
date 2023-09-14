<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
	$anio  = $_SESSION['anio'];
	
 
	
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $tipo_dias = trim($_GET['tipo']);

    $prov      = trim($_GET['idprov']);

    $sql = "SELECT   idprov, razon,   id_departamento, id_cargo,   regimen, cargo,  programa,sueldo,discapacidad,fecha
    FROM view_nomina_rol
    where trim(idprov) =".$bd->sqlvalue_inyeccion($prov,true) ;
      
    $resultado1 = $bd->ejecutar($sql);
    
    $datos  = $bd->obtener_array( $resultado1);
    

    $acargo = $bd->query_array('nom_cargo',
                                  'tipo, sigla, dia_max, hora_max, dias_vacacion, dias_acumula, dia_vaca, dia_permiso', 
                                  'id_cargo='.$bd->sqlvalue_inyeccion($datos['id_cargo'],true)
                                );

   if ( trim($tipo_dias) == 'vacaciones'){
        $dia_valida =  $acargo['dia_vaca']; 
   }                         

   if ( trim($tipo_dias) == 'permiso_hora'){
        $dia_valida =  $acargo['dia_permiso']; 
   }     
   if ( trim($tipo_dias) == 'permiso_dia'){
      $dia_valida =  $acargo['dia_permiso']; 
    }     

    $dia_max   =  $acargo['dia_max']; 
    $hora_max  =  $acargo['hora_max']; 
 

    echo json_encode( array("a"=>$dia_valida, 
                            "b"=> trim(  $dia_max ) ,
                            "c"=> trim(  $hora_max) 
                             
                       )  
                    );
    
     
    
?>