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

    $len = strlen($novedad );


    $mensaje = 'REVISE LA INFORMACION... DETALLE LA NOVEDAD DEL TRAMITE ('.$novedad .')';

    if ( trim($tipop) == 'tthh') {

        if (     $len > 5  ) {

            $novedad  = 'TTHH '.$novedad.' '.$sesion;

            if ( trim($accion) == 'Anular'){
                     $sql_update = "update co_anticipo 
                                    set estado=". $bd->sqlvalue_inyeccion(  'anulados'  ,true).' ,
                                    sesion_tthh='. $bd->sqlvalue_inyeccion(  $sesion ,true).' ,
                                    fecha_tth='. $bd->sqlvalue_inyeccion(   $fecha_hoy ,true).' ,
                                    novedad ='. $bd->sqlvalue_inyeccion( $novedad   ,true).' 
                                    where id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true);
            }else {
                $sql_update = "update co_anticipo 
                               set estado=". $bd->sqlvalue_inyeccion(  'financiero'  ,true).' ,
                               sesion_tthh='. $bd->sqlvalue_inyeccion(  $sesion ,true).' ,
                               fecha_tth='. $bd->sqlvalue_inyeccion(   $fecha_hoy ,true).' ,
                               novedad ='. $bd->sqlvalue_inyeccion( $novedad   ,true).' 
                               where id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true);
            }

            $bd->ejecutar($sql_update);

            $mensaje = 'INFORMACION... ENVIADA CON EXITO ' ;
        } 
    } 


    if ( trim($tipop) == 'financiero') {

        if (     $len > 5  ) {

            $novedad  = '... FINANCIERO '.$novedad.' '.$sesion;

            if ( trim($accion) == 'Anular'){
                     $sql_update = "update co_anticipo 
                                    set estado=". $bd->sqlvalue_inyeccion(  'anulados'  ,true).' ,
                                    sesion_fin='. $bd->sqlvalue_inyeccion(  $sesion ,true).' ,
                                    fecha_fin='. $bd->sqlvalue_inyeccion(   $fecha_hoy ,true).' ,
                                    novedad = novedad || '. $bd->sqlvalue_inyeccion( $novedad   ,true).' 
                                    where id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true);

                                    $bd->ejecutar($sql_update);                                    
            }else {

                $id_asiento =  _asiento_contable($bd,  $id)   ;           

                $sql_update = "update co_anticipo 
                               set estado=". $bd->sqlvalue_inyeccion(  'autorizado'  ,true).' ,
                               sesion_fin='. $bd->sqlvalue_inyeccion(  $sesion ,true).' ,
                               id_asiento='. $bd->sqlvalue_inyeccion(  $id_asiento ,true).' ,
                               fecha_fin='. $bd->sqlvalue_inyeccion(   $fecha_hoy  ,true).' ,
                               novedad =  novedad || '. $bd->sqlvalue_inyeccion( $novedad   ,true).' 
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