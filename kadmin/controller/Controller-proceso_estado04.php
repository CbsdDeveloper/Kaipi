<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
            
            echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="BusquedaGrilla(1)"><div class="bloque0" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:16px;color: #ffffff;">Solicitado</span></a>
  		    </div>
         </div>';
     
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(2)"> <div class="bloque1" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Enviado</span></a>
 						</div>	 
 				</div>	';
     
        
 
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(3)"> 	<div  class="bloque3" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Aprobado</span></a>
 						</div>';
 
 
   
 
   

?>