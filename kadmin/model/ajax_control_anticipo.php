<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $fecha_hoy = date('Y-m-d');
      
    $sesion 	   =  trim($_SESSION['email']);

    $id            = trim($_GET['id']);
    
    $novedad       = trim($_GET['novedad']);
    
    $accion        = trim($_GET['accion']);
    $tipop         = trim($_GET['tipo']);
    $id_usuarioe   = trim($_GET['id_usuarioe']);
    

    $len = strlen( $novedad );


    $mensaje = 'REVISE LA INFORMACION... DETALLE LA NOVEDAD DEL TRAMITE ('.$novedad .')';

 

    if ( trim($tipop) == 'financiero') {

        if (     $len > 5  ) {

            $detalle  = '... FINANCIERO '.$novedad.' '.$sesion;

            if ( trim($accion) == 'Anular'){
                     $sql_update = "update co_anticipo 
                                    set estado=". $bd->sqlvalue_inyeccion(  'anulados'  ,true).' ,
                                    sesion_fin='. $bd->sqlvalue_inyeccion(  $sesion ,true).' ,
                                    fecha_fin='. $bd->sqlvalue_inyeccion(   $fecha_hoy ,true).' ,
                                    novedad = novedad || '. $bd->sqlvalue_inyeccion( $detalle   ,true).' 
                                    where id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true);

                                    $bd->ejecutar($sql_update);                                    
            }else {

                
           
                
                $sql_update = "update co_anticipo
                               set estado=". $bd->sqlvalue_inyeccion(  'controlprevio'  ,true).' ,
                               sesion_fin='. $bd->sqlvalue_inyeccion(  $sesion ,true).' ,
                               fecha_fin='. $bd->sqlvalue_inyeccion(   $fecha_hoy  ,true).' ,
                               novedad =  novedad || '. $bd->sqlvalue_inyeccion( $detalle   ,true).'
                               where id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true);
                
                $bd->ejecutar($sql_update);
                
                
                /*
                 inserta caso para control previo... revision de informacion... 
                 */
                
                $tiempo = date("H:i:s");
                $hoy= date('Y-m-d');
                $tabla 	     	  = 'flow.wk_proceso_caso';
                $secuencia 	     = 'flow.wk_proceso_caso_idcaso_seq';
                
                $Array = $bd->query_array(
                    'view_nomina_user',
                    'id_departamento',
                    'email='.$bd->sqlvalue_inyeccion( $id_usuarioe ,true)
                    );
                
                $Arrayv = $bd->query_array(
                    'view_anticipo_solicitud',
                    'idprov,documento, funcionario ',
                    'id_anticipo='.$bd->sqlvalue_inyeccion(  $id,true)
                    );
                
                
                $caso =  'Solicitud de Anticipo de Sueldo nro.'.$id.' '.trim($Arrayv['funcionario']).trim($novedad);
          
                
                
                $id_departamento =  $Array['id_departamento'];
                 
                $ATabla = array(
                    array( campo => 'caso',tipo => 'VARCHAR2',id => '0',add => 'S', edit => 'S', valor =>  $caso, key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor =>  $hoy, key => 'N'),
                    array( campo => 'fvencimiento',tipo => 'DATE',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '1', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => $sesion, key => 'N'),
                    array( campo => 'responsable',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idtareactual',tipo => 'NUMBER',id => '6',add => 'S', edit => 'N', valor => '1', key => 'N'),
                    array( campo => 'autorizado',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'N', key => 'N'),
                    array( campo => 'idproceso',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '21', key => 'N'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '9',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor =>  $id_departamento, key => 'N'),
                    array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => $id_usuarioe 	, key => 'N'),
                    array( campo => 'sesion_siguiente',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $id_usuarioe, key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'N', valor => $Arrayv['idprov'], key => 'N'),
                    array( campo => 'hora_in',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
                    array( campo => 'modulo',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => 'C', key => 'N'),
                    array( campo => 'categoria',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'N', valor => 'Anticipo Remuneracion', key => 'N'),
                    array( campo => 'id_tramite',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N')
                );
                
                
                $idcaso = $bd->_InsertSQL($tabla,$ATabla, $secuencia );
                
                
                $tabla 	  	  = 'flow.wk_doc_user';
                $secuencia 	     = 'flow.wk_doc_user_id_user_doc_seq';
                
                $ATabla = array(
                    array( campo => 'id_user_doc',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idcaso, key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor =>  $hoy, key => 'N'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => 'S', key => 'N'),
                    array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $id_usuarioe, key => 'N'),
                    array( campo => 'hora_in',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $sesion, key => 'N')
                );
                
                
                $bd->_InsertSQL($tabla,$ATabla,$secuencia );
                
                
                $sql_update = "update co_anticipo
                               set 
                               idcaso=". $bd->sqlvalue_inyeccion(  $idcaso ,true).' 
                               where id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true);
                
                $bd->ejecutar($sql_update);
                
               
                                              
            }

           

            $mensaje = 'INFORMACION... ENVIADA CON EXITO ' ;
        } 
    } 


 
    
echo  $mensaje;

 /*
 asiento contable
 */ 

function _asiento_contable($bd,  $id){
    
    $fecha      =  date('Y-m-d');
    $ruc        =  $_SESSION['ruc_registro'];
    $sesion 	=  trim($_SESSION['email']);


    $aanticipo = $bd->query_array('co_anticipo',
    '*',
    'id_anticipo ='.$bd->sqlvalue_inyeccion( $id,true) 
     );



    $trozos = explode("-", $fecha,3);

    $anio =   $trozos[0];
    
    $mes =    $trozos[1];
      
    $periodo_s = $bd->query_array('co_periodo',
                                        'id_periodo',
                                        'registro ='.$bd->sqlvalue_inyeccion($ruc ,true).' and
                                         mes ='.$bd->sqlvalue_inyeccion($mes,true).' and
                                         anio='.$bd->sqlvalue_inyeccion($anio ,true)
        );
    
 
   $fecha_registro		=  $bd->fecha($fecha);
   $detalle             =  'Solicitud de Anticipo de Remuneracion '.trim($aanticipo['detalle']);
   $documento           =  trim($aanticipo['documento']);
   $idprov              =  trim($aanticipo['idprov']);
   $idprov_ga           =  trim($aanticipo['idprov_ga']);

   $apagar              =  $aanticipo['solicita'];
   $tiempo              =  $aanticipo['plazo'];

   $sql = "INSERT INTO co_asiento(   fecha, registro, anio, mes, detalle, sesion, creacion,
                                         comprobante, estado, tipo, documento,cuentag,apagar,base,idprov_ga,
                               modulo,idprov,estado_pago,id_periodo)
                               VALUES (".$fecha_registro.",".
                               $bd->sqlvalue_inyeccion($ruc, true).",".
                               $bd->sqlvalue_inyeccion($anio, true).",".
                               $bd->sqlvalue_inyeccion($mes, true).",".
                               $bd->sqlvalue_inyeccion($detalle, true).",".
                               $bd->sqlvalue_inyeccion($sesion, true).",".
                               $fecha_registro .",".
                               $bd->sqlvalue_inyeccion('-', true).",".
                               $bd->sqlvalue_inyeccion('solicitado', true).",".
                               $bd->sqlvalue_inyeccion('O', true).",".
                               $bd->sqlvalue_inyeccion($documento, true).",".
                               $bd->sqlvalue_inyeccion('11', true).",".
                               $bd->sqlvalue_inyeccion($apagar, true).",".
                               $bd->sqlvalue_inyeccion($tiempo, true).",".
                               $bd->sqlvalue_inyeccion($idprov_ga, true).",".
                                $bd->sqlvalue_inyeccion('anticipo', true).",".
                               $bd->sqlvalue_inyeccion($idprov, true).",".
                               $bd->sqlvalue_inyeccion('N', true).",".
                               $bd->sqlvalue_inyeccion( $periodo_s['id_periodo'], true).")";
                               
                               $bd->ejecutar($sql);
                               
                               $id_asiento_banco = $bd->ultima_secuencia('co_asiento');
                               
           return $id_asiento_banco;
        
   
   }
    
?>