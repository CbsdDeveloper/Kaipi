<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  

 
    $obj     = 	new objects;

 
    $bd	   =	new Db ;
  
 
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
 
    
            $xx = $_GET['idplantilla'];
             
        
            $Aexiste = $bd->query_array('flow.wk_doc_modelo',
                                        'formato,esdetalle,vista,variable', 
                                        'id_docmodelo='.$bd->sqlvalue_inyeccion($xx,true)
                                        );
            
            $editor1 =  ($Aexiste['formato']);
            
            //---- ES DETALLE
            
            $detalle_datos    =  $Aexiste['esdetalle'];
            $sql_detalle      =  $Aexiste['vista'];
            $variable_detalle =  $Aexiste['variable'];
            
            
            $cabecera =   ( $editor1 );
            
            
            if (isset($_GET['idproceso']))	{
                
                $idproceso    		= $_GET['idproceso'];
                $idcaso            	= $_GET['idcaso'];
                
                $sql = 'SELECT  variable, valor,    variable_sis
                        FROM flow.view_proceso_caso_var
                        where idcaso= '.$bd->sqlvalue_inyeccion($idcaso, true).'  and 
                              idproceso='.$bd->sqlvalue_inyeccion($idproceso, true).' and valor is not null';
 
 
                $stmtD = $bd->ejecutar($sql);
                
                while ($x=$bd->obtener_fila($stmtD)){
                    
                     $cabecera =  str_replace (trim($x['variable_sis']), trim($x['valor']) , $cabecera);
                    
                    
                }
                
       
                
                $y = $bd->query_array('flow.view_proceso_caso',
                                      'caso, fecha,modulo,unidad,estado, idprov, nombre_solicita, movil_solicita, email_solicita, direccion_solicita, proceso', 
                                      'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true));
                
                
     
                $cabecera =  str_replace ('#CASO', trim($y['caso']) , $cabecera);
                $cabecera =  str_replace ('#FECHA_PROCESO',   $y['fecha']  , $cabecera);
                 $cabecera =  str_replace ('#TRAMITE',   $idcaso  , $cabecera);
                
                
                 



                
                 $cabecera =  str_replace ('#IDENTIFICACION',   $y['idprov']  , $cabecera);
                 $cabecera =  str_replace ('#SOLICITA',   $y['nombre_solicita']  , $cabecera);
                 $cabecera =  str_replace ('#MOVIL',   $y['movil_solicita']  , $cabecera);
                 $cabecera =  str_replace ('#EMAIL',   $y['email_solicita']  , $cabecera);
                 $cabecera =  str_replace ('#DIRECCION',   $y['direccion_solicita']  , $cabecera);
                 $cabecera =  str_replace ('#PROCESO',   $y['proceso']  , $cabecera);
                 $cabecera =  str_replace ('#UNIDAD',   $y['unidad']  , $cabecera);
                
                 $tipo = $bd->retorna_tipo();
                
                 if ( $detalle_datos == 'S'){
                     
                     $cabecera_sql =  str_replace ('#CASO', $idcaso , $sql_detalle);
                     
                     $resultado = $bd->ejecutar($cabecera_sql);
                     
                     $sql_resultado =  $obj->grid->KP_GRID_EXCEL($resultado,$tipo);
                     
                     $cabecera =  str_replace ($variable_detalle,   $sql_resultado  , $cabecera);
                      
                     
                 }
                 
                 ///----------------------------------------------------------------------   
                

                 $x = $bd->query_array('inv_movimiento',   					   // TABLA
                 '*',                        // CAMPOS
                 'idproceso='.$bd->sqlvalue_inyeccion($idcaso,true) 	   // CONDICION
                 );

                 $id_movimiento = $x["id_movimiento"];

            

                 if ( $id_movimiento > 0 ){
					 
                    #DETALLE_MOVIMIENTO
                    $sql_mov = 'Select codigo, producto, unidad,  cantidad 
                                from view_movimiento_det where 
                                id_movimiento='.$bd->sqlvalue_inyeccion($id_movimiento,true);

                    $resultado = $bd->ejecutar($sql_mov);
                     
                     $sql_resultado =  $obj->grid->KP_GRID_PLANTILLA($resultado,$tipo);
                     
                     $cabecera =  str_replace ('#DETALLE_MOVIMIENTO',   $sql_resultado  , $cabecera);

                }   
            }
            
            
 

            
            echo json_encode(    array("a"=> $cabecera    )     );
 
 

?>
 
  