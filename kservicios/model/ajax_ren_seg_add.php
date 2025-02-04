<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
$id                 = $_POST['id'] ;

$fecha_seg          = $_POST['fecha_seg'] ;

$hora               = $_POST['hora'] ;

$responsable_seg    = trim( $_POST['responsable_seg'] );

$novedad_seg    = trim( $_POST['novedad_seg'] );

$accion_seg     = trim( $_POST['accion_seg'] ); 

$accion 	    = trim( $_POST['accion'] ); 

$sesion = trim($_SESSION['email']);

$fecha = date('Y-m-d');

$bandera = 0;
 
        if ( $accion  == 'add' )  {  

           if (empty($hora)) {  
            $bandera = 1;
           }      
           if (empty($novedad_seg)) {  
            $bandera = 1;
           } 
           if (empty($accion_seg)) {  
            $bandera = 1;
           }     

 
                $sql = "INSERT INTO rentas.ren_tramite_seg( fecha_seg, hora, id_ren_tramite, responsable_seg, novedad_seg, accion_seg, sesion, fcreacion)
                        VALUES (".$bd->sqlvalue_inyeccion($fecha_seg , true).",".
                        $bd->sqlvalue_inyeccion($hora , true).",".
                        $bd->sqlvalue_inyeccion($id  , true).",".
                        $bd->sqlvalue_inyeccion($responsable_seg, true).",".
                        $bd->sqlvalue_inyeccion($novedad_seg, true).",".
                        $bd->sqlvalue_inyeccion($accion_seg, true).",".
                        $bd->sqlvalue_inyeccion($sesion, true).",".
                         $bd->sqlvalue_inyeccion($fecha, true).")";

                         if ( $bandera  == 0 )  {  

                               $bd->ejecutar($sql);
                               $div_mistareas = ' Datos Actualizados ';
                               echo $div_mistareas;

                            }  else  {  
                                $div_mistareas = ' Revise la informacion.... falta variables de regiatrar ';
                                echo $div_mistareas;
                            }  
        }                  
                 
                
                if ( $accion  == 'visor' )  {  

                    $sql = "SELECT *
                                          FROM rentas.view_ren_seg
                                          where id_ren_tramite = ".$bd->sqlvalue_inyeccion($id,true).' order by fecha_seg desc';
 
      
       
                        $stmt1 = $bd->ejecutar($sql);
                    
                        
                         
                        while ($fila=$bd->obtener_fila($stmt1)){
                            

                            

                            if ( trim($fila['leido']) == 'N' ) {
                                $imagen = 'if_bullet_red_35785.png' ;
                            }else {
                                $imagen = 'if_bullet_green_35779.png' ;
                            }
                             
                            echo '  <div class="media">
                            <div class="media-left">
                              <img src="../../kimages/'.$imagen.'" class="media-object" style="width:35px">
                            </div>
                            <div class="media-body">
 
                              <h4 class="media-heading">'.trim($fila['login']).' <small><i>'.trim($fila['fecha_seg']) .'</i></small></h4>
                              <p>'.trim($fila['detalle']).' ' .trim($fila['novedad_seg']).' .</p>
                         
                          </div>
                        </div>';


                        }
                        

                   


                }          
                        
                    

 

              

?>