<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


 
 
$bd	   =	new Db;
    

    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    $action		    = $_POST['accion'];

    $idprov      	= trim($_POST['idprov']);
    $vivienda	 	= $_POST['vivienda'];
    $salud   	    = $_POST['salud'];
    $alimentacion	= $_POST['alimentacion'];
    $vestimenta   	= $_POST['vestimenta'];
    $educacion	 	= $_POST['educacion'];
    $turismo   	    = $_POST['turismo'];

    $razon      	= trim($_POST['razon']);
     
    
 
    
   //------------------------------------------------- 
	    if ( $action == 'gastos'){

                        $sql = " UPDATE par_ciu
                        SET vivienda =".$bd->sqlvalue_inyeccion( $vivienda, true).",
                            salud    =".$bd->sqlvalue_inyeccion( $salud, true).",
                            alimentacion =".$bd->sqlvalue_inyeccion($alimentacion, true).",
                            vestimenta   =".$bd->sqlvalue_inyeccion( $vestimenta, true).",
                            educacion    =".$bd->sqlvalue_inyeccion( $educacion, true).",
                             turismo     =".$bd->sqlvalue_inyeccion( $turismo, true)."
                        WHERE idprov     =".$bd->sqlvalue_inyeccion($idprov, true);

            $bd->ejecutar($sql);

            $mensaje =  $razon  .' registro actualizacion de gastos de personal';

            $bd->audita_tthh('GASTOS PERSONAL',$mensaje);

            echo '<h4>DATOS ACTUALIZADOS CON EXITO! '.$razon .' </h4>';
	    }
      
    
    
 
 
  ?> 
								
 
 
 