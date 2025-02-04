<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
	$anio  = $_SESSION['anio'];
	
 
	
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT   idprov, razon,   id_departamento, id_cargo,   regimen, cargo,  programa,sueldo,discapacidad,fecha
				  FROM view_nomina_rol
				  where upper(razon) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
  
  
  
    $resultado1 = $bd->ejecutar($sql);
    
    $x  = $bd->obtener_array( $resultado1);
    
    $prov = trim($x['idprov']);

     if (  trim($x['discapacidad']) == '-'){
        $discapacidad = 'N';
     }else{
        $discapacidad = 'S';
     }


     $avacacion = $bd->query_array('nom_cvacaciones','dias_pendientes', 
     'idprov='.$bd->sqlvalue_inyeccion($prov,true). " and periodo = ".$bd->sqlvalue_inyeccion($anio,true)
   );

   $pendiente_vacacion =  $avacacion['dias_pendientes'];



 
    
    echo json_encode( array("a"=>$prov, 
                            "b"=> trim($x['regimen']) ,
                            "c"=> trim($x['programa']) ,
                            "d"=> $x['id_departamento'] ,
                            "e"=> $x['id_cargo'] ,
                            "f"=> $x['sueldo'] ,
                            "g"=> $discapacidad  ,
                            "h"=> $x['fecha'] ,
                            "i"=> $pendiente_vacacion 
                       )  
                    );
    
     
    
?>