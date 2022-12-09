<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$obj     = 	new objects;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$accion = trim($_POST["accion"]);

$sesion = trim($_SESSION['email']);

$fecha = date('Y-m-d');

$bandera = 0;



        if ( $accion  == 'aprobar' )  {  

            $id = trim($_POST["id"]);

            $sql = "UPDATE  rentas.ren_serie_espe
                    set estado = 'S'
                   where id_especied = ".$bd->sqlvalue_inyeccion( $id ,true)  ;

                 $bd->ejecutar($sql);
 
        }     


        if ( $accion  == 'secuencia' )  {  

            $id = trim($_POST["id"]);

            $xx = $bd->query_array('rentas.ren_serie_espe',   // TABLA
            'actual',                        // CAMPOS
            "estado = 'S' and idproducto_ser=".$bd->sqlvalue_inyeccion(  $id ,true) // CONDICION
            );
             
 
            echo json_encode( array("a"=>trim($xx['actual'])  )   );

        }     



        

        if ( $accion  == 'anular' )  {  

            $id = trim($_POST["id"]);

            $xx = $this->bd->query_array('rentas.ren_serie_espe',   // TABLA
            'estado',                        // CAMPOS
            'id_especied='.$this->bd->sqlvalue_inyeccion(  $id ,true) // CONDICION
            );

            if (   $xx['estado'] == 'N' )   {  

                    $sql = "delete from   rentas.ren_serie_espe   where id_especied = ".$bd->sqlvalue_inyeccion( $id ,true)  ;

                    $bd->ejecutar($sql);
            }   else {  

                $sql = "UPDATE  rentas.ren_serie_espe
                    set estado = 'N'
                   where id_especied = ".$bd->sqlvalue_inyeccion( $id ,true)  ;

                 $bd->ejecutar($sql);
           }



        }    


        if ( $accion  == 'add' )  {  


            $bandera    = 0;

            $referencia = trim($_POST["referencia"]);
            $detalle    = trim($_POST["detalle"]);

            $inicio =    (int)$_POST["inicio"] ;
            $fin    =    (int)$_POST["fin"];

            $actual    =    (int)$_POST["actual"];

            $lon  = strlen($referencia);
            $lon1 = strlen($detalle);
            
 
           
            if (   $inicio  > $fin ) {  
                $bandera = 1;
               
            }     
 

            if (   $actual > $fin ) {  
                $bandera = 1;
               
            }    

            if (  $lon   <  5 ) {  
                $bandera = 1;
            }  

            if (  $lon1   <  5 ) {  
                $bandera = 1;
            }  

            $ATabla = array(
                array( campo => 'id_especied',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                 array( campo => 'sesion',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $sesion , key => 'N'),
                array( campo => 'sesiona',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $_POST["sesiona"], key => 'N'),
                array( campo => 'inicio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $inicio, key => 'N'),
                array( campo => 'fin',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $fin, key => 'N'),
                array( campo => 'actual',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $_POST["actual"], key => 'N'),
                array( campo => 'detalle',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $detalle, key => 'N'),
                array( campo => 'estado',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor =>'N', key => 'N'),
                array( campo => 'referencia',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $referencia, key => 'N'),
                array( campo => 'idproducto_ser',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => $_POST["idproducto_ser"], key => 'N'),
                array( campo => 'fecha_recepcion',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => $_POST["fecha_recepcion"], key => 'N'),
                array( campo => 'fecha',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor => $_POST["fecha"], key => 'N')
                 );
       

                if ( $bandera == 0 )  {  

                        $bd->_InsertSQL('rentas.ren_serie_espe',$ATabla,'rentas.ren_serie_espe_id_especied_seq' );

                        echo ' <b>DATOS GUARDADOS CON EXITO....</b> ';

                }else    {      
                         echo '<b>VERIFIQUE LA INFORMACION INGRESADA <br>  ESPECIE NRO ('.$inicio.'-'.$fin.'), DETALLE  ('.$lon1 .') Y/O REFERENCIA ('.$lon .') DEL TRAMITE </b>';

                }
      
         }                  
                 
                
          if ( $accion  == 'visor' )  {  


                    $id = trim($_POST["id"]);

                             $anio =      $_SESSION['anio'];
                        
                            $tipo = $bd->retorna_tipo();
            
            
                            $sql = "SELECT  id_especied  || ' ' as  id, fecha_recepcion,completo, referencia ,inicio || ' ' as  inicio ,fin || ' ' as fin ,actual || ' ' as   actual,estado
                                                FROM rentas.view_control_especie
                                                where anio = ".$bd->sqlvalue_inyeccion( $anio ,true) .' and 
                                                     idproducto_ser='.$bd->sqlvalue_inyeccion( $id  ,true) ;


               
                                    
                                $resultado = $bd->ejecutar($sql);
                                
                                $obj->table->table_basic_js($resultado, // resultado de la consulta
                                    $tipo,      // tipo de conexoin
                                    'aprobar',         // icono de edicion = 'editar'
                                    'anular',			// icono de eliminar = 'del'
                                    'proceso_doc-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                                    "Referencia, Fecha,Responsable,Referencia,Inicial,Final,Actual,Activo",  // nombre de cabecera de grill basica,
                                    '12px',      // tamaño de letra
                                    'Caja1'         // id
                                    );

                                    


                }          
                        
                    

 

              

?>