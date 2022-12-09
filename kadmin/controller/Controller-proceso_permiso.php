<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
            if ( $i == 1){
                $clase='bloque1';
            }    
            if ( $i == 1){
                $clase='bloque1';
            }    
            if ( $i == 2){
                $clase='bloque0';
            }    
            if ( $i == 3){
                $clase='bloque3';
            }  

        
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla('.$secuencia .')"> <div class="'. $clase.'" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">'.$cnombre .'</span></a>
 						</div>	 
 				</div>	';
            
       
         
 
 
   

?>