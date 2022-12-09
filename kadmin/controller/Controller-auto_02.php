<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
  
            
            echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="BusquedaGrilla(0,1)"><div class="bloque0" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:16px;color: #ffffff;">Solicitados</span></a>
  		    </div>
         </div>';
       

         
         echo '<div class="col-md-12" style="padding: 2px">
         <a href="#" onClick="BusquedaGrilla(0,4)"> <div class="bloque3" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:16px;color: #ffffff;">Enviados</span></a>
                </div>	 
          </div>	';
   


        
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,2)"> <div class="bloque1" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Autorizados</span></a>
 						</div>	 
 				</div>	';
      
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,3)"> <div class="bloque2" title="Dar un clic para visualizar informacion"> 
				     	<span style="font-size:16px;color: #ffffff;">Anulados</span></a>
 						</div>
 				  </div>';
        
        
        
    
   
 
   

?>