<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	

   $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

   $sesion 	=  trim($_SESSION['email']);

   $array   = $bd->__user(str_replace('@cbsd.gob.ec','',$sesion)) ;

   
  
   $estado = "'solicitado'";
            
            echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="BusquedaGrilla(0,'.$estado.')"><div class="bloque0" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:16px;color: #ffffff;">Solicitados</span></a>
  		    </div>
         </div>';


         $estado = "'autorizado'";
       
        
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,'.$estado.')"> <div class="bloque1" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:16px;color: #ffffff;">Autorizados</span></a>
 						</div>	 
 				</div>	';


             $estado = "'contabilizado'";

                 echo '<div class="col-md-12" style="padding: 2px">
                 <a href="#" onClick="BusquedaGrilla(0,'.$estado.')"> <div class="bloque3" title="Dar un clic para visualizar informacion"> 
                             <span style="font-size:16px;color: #ffffff;">Contabilizado</span></a>
                              </div>	 
                      </div>	';     
      
          $estado = "'anulados'";

            echo '<div class="col-md-12"  style="padding-left: 2px;padding-right: 2px;padding-bottom: 10px;padding-top: 15px">
            <a href="#" onClick="BusquedaGrilla(0,'.$estado.')"> <div class="bloque4" title="Dar un clic para visualizar informacion"> 
				     	<span style="font-size:16px;color: #ffffff;">Anulados</span></a>
 						</div>
 				  </div>';
        
        
            

               $perfil  = trim($array['tipo']);
               
          

               if ( $perfil == 'tthh') {
				
                  $xa = $bd->query_array('co_anticipo', 'count(*) as nn',  'estado='.$bd->sqlvalue_inyeccion('tthh',true)   );
               
                  if ( $xa['nn'] > 0 ) {

                     $estado= "'tthh'";   
                   
                    
                     echo '<div class="col-md-12" style="padding: 2px">
                     <a href="#" onClick="BusquedaGrillaT(0,'.$estado.')"> <div class="bloque2" title="Dar un clic para visualizar informacion"> 
                             <span style="font-size:16px;color: #ffffff;"><b>TALENTO HUMANO Revisar ('.$xa['nn'] .')</b></span></a>
                            </div>
                        </div>';

                  }
                  
            }	
    
                  
            if ( $perfil == 'financiero') {
				
               $xa = $bd->query_array('co_anticipo', 'count(*) as nn',  'estado='.$bd->sqlvalue_inyeccion('financiero',true)   );
            
               if ( $xa['nn'] > 0 ) {

                  $estado= "'financiero'";   
                
                 
                  echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="BusquedaGrillaF(0,'.$estado.')"> <div class="bloque2" title="Dar un clic para visualizar informacion"> 
                          <span style="font-size:16px;color: #ffffff;"><b>FINANCIERO Revisar ('.$xa['nn'] .')</b></span></a>
                         </div>
                     </div>';

               }
                  
         }	
 
               
         $aa = $bd->query_array('co_anticipo', 'count(*) as nn',  
                                'sesion = '.$bd->sqlvalue_inyeccion($sesion,true).' and 
                                 estado='.$bd->sqlvalue_inyeccion('tthh',true));
         
         $bb = $bd->query_array('co_anticipo', 'count(*) as nn',  
                                 'sesion = '.$bd->sqlvalue_inyeccion($sesion,true).' and 
                                  estado='.$bd->sqlvalue_inyeccion('financiero',true));
               
         
         $xx = $bd->query_array('co_anticipo', 'count(*) as nn',
             'sesion = '.$bd->sqlvalue_inyeccion($sesion,true).' and
                                  estado='.$bd->sqlvalue_inyeccion('controlprevio',true));
         
        if (  $aa['nn'] > 0 ) {
            
         echo '<div class="col-md-12" style="padding: 5px"> <div class="row"> <div class="alert alert-warning">
               <strong>ADVERTENCIA!</strong> SU TRAMITE SE ENCUENTRA EN TALENTO HUMANO
            </div></div></div>';
         
        }	                   

        if (  $bb['nn'] > 0 ) {
            
         echo '<div class="col-md-12" style="padding: 5px"> <div class="row"> <div class="alert alert-danger">
         <strong>ADVERTENCIA!</strong> SU TRAMITE SE ENCUENTRA EN FINANCIERO
      </div></div></div>';
   
         
         
        }	    
        
    
        if (  $xx['nn'] > 0 ) {
            
            echo '<div class="col-md-12" style="padding: 5px"> <div class="row"> <div class="alert alert-danger">
         <strong>ADVERTENCIA!</strong> SU TRAMITE SE ENCUENTRA EN FINANCIERO
      </div></div></div>';
            
            
            
        }
        
 
   

?>