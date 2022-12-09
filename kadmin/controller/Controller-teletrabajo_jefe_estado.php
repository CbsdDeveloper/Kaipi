<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $sesion 	    =  trim($_SESSION['email']);
    
    $accion         =  $_GET['accion'];
    
    $anio           =  date("Y");  
    
    $Aunidad        = $bd->query_array('view_nomina_user',  'id_departamento,idprov', 'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)   );
   
    $iddepartamento =  $Aunidad['id_departamento'];
     
    $idprov         =  trim($Aunidad['idprov']);
    
 
            
            echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="VerPersonal('."'". $idprov."'".')"><div class="bloque0" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:12px;color: #ffffff;">PERSONAL ASIGNADO</span></a>
  		    </div>
         </div>';
     
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,2)"> <div class="bloque1" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:12px;color: #ffffff;">SEGUIMIENTO DE ACTIVIDADES</span></a>
 						</div>	 
 				</div>	';
     
        
 
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,4)"> 	<div  class="bloque3" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:12px;color: #ffffff;">ACTIVIDADES POR CUMPLIR</span></a>
 						</div>';
 
 
   
 
   

?>