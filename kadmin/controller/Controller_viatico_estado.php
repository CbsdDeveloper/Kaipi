<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
            
            echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="BusquedaGrilla('."'solicitado'".')"><div class="bloque0" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:16px;color: #ffffff;">Solicitado</span></a>
  		    </div>
         </div>';
            
            
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla ('."'enviado'".')"> <div class="bloque4" title="Dar un clic para visualizar informacion">
                        <span style="font-size:16px;color: #ffffff;">Enviado</span></a>
 						</div>
 				</div>	';
         
            
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla ('."'informe'".')"> <div class="bloque2" title="Dar un clic para visualizar informacion">
                        <span style="font-size:16px;color: #ffffff;">Informe Viatico</span></a>
 						</div>
 				</div>	';
            
           echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla('."'autorizado'".') "> <div class="bloque1" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Contabilidad</span></a>
                  </div>    
            </div>   ';
            
 
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla('."'liquidado'".')"> 	<div  class="bloque3" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Liquidado</span></a>
 						</div>';
 
 
   
 
   

?>