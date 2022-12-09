<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = new Db ;
	
	$id     = $_SESSION['ruc_registro'];
	
	$anio   = $_SESSION['anio'];
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $idprov = trim($_GET['idprov']);
    
     
    $sql = "SELECT   sum(haber)  as haber 
                FROM view_aux
                where idprov = ". $bd->sqlvalue_inyeccion($idprov , true).' and
                       estado = '. $bd->sqlvalue_inyeccion('aprobado' , true).' and
                       pago= '. $bd->sqlvalue_inyeccion('N' , true).' and
                       bandera= '. $bd->sqlvalue_inyeccion('1' , true);
    
     
 
		 $resultado1 = $bd->ejecutar($sql);
		 $datos_sql   = $bd->obtener_array( $resultado1);
		 $total           = $datos_sql['haber'] ;
         
        
		
		 echo '<h4><b>Total a pagar '.$total.'</b></h4>';
    
  	 
?>