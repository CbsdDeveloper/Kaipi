<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $id            		= $_GET['id'];
    
    
    
    $x = $bd->query_array('flow.view_proceso',   // TABLA
        '*',                        // CAMPOS
        'idproceso='.$bd->sqlvalue_inyeccion($id,true) // CONDICION
        );
    
   
 
    $DibujoFlujo = '<div class="container">
          <div class="jumbotron">
            <h2>'.$x['nombre'].'</h2>      
            <p  style="font-size: 13px">'.$x['objetivo'].'</p>
          </div>
          <p  style="font-size: 14px"><b>Unidad Responsable: '.$x['unidad'].'</b></p>      
          <p  style="font-size: 14px"><b>PROCEDIMIENTO</b></p>      
          <p  style="font-size: 14px">'.$x['procedimiento'].'</p>      
</div>';
  
    
    echo $DibujoFlujo ;

?>
