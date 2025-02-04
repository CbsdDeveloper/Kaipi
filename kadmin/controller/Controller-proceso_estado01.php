<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $sesion 	    =  trim($_SESSION['email']);
    
    $accion         =  $_GET['accion'];
    
    $anio           =  date("Y");  
    
    $Aunidad        = $bd->query_array('par_usuario',  'id_departamento', 'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)   );
   
    $iddepartamento =  $Aunidad['id_departamento'];
     
     
            
            echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="BusquedaGrilla(0,1)"><div class="bloque0" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:16px;color: #ffffff;">Por Enviar</span></a>
  		    </div>
         </div>';
     
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,2)"> <div class="bloque1" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Enviados</span></a>
 						</div>	 
 				</div>	';
     
        
 
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,4)"> 	<div  class="bloque3" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Terminada</span></a>
 						</div>';
 
 
   
 
   

?>