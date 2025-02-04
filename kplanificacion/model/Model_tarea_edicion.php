<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    
    $idtarea = $_POST['idtarea'];  
    
    $recurso        = trim($_POST['recurso']);  
    $responsable    = trim($_POST['responsable']);  
    $clasificador   = trim($_POST['clasificador']);  
    $enlace_pac     = trim($_POST['enlace_pac']);  
    $modulo         = trim($_POST['modulo']);  
     
    
 
    if ( $idtarea > 0 ){
        
        
        $sql = "UPDATE planificacion.sitarea
                   SET   recurso=".$bd->sqlvalue_inyeccion($recurso, true)." ,
                         responsable=".$bd->sqlvalue_inyeccion($responsable, true)." ,
                         clasificador=".$bd->sqlvalue_inyeccion($clasificador, true)." ,
                         enlace_pac=".$bd->sqlvalue_inyeccion($enlace_pac, true)." ,
                         modulo=".$bd->sqlvalue_inyeccion($modulo, true)." 
                 WHERE idtarea=".$bd->sqlvalue_inyeccion($idtarea, true);
        
        $bd->ejecutar($sql);
        
        echo 'INFORMACION ACTUALIZADA CON EXITO...';
    }
    
    
  
           
 
?> 
