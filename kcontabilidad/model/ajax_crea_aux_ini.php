<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
	$monto         =     $_GET["monto"];
    $idprov        =     trim($_GET["idprov"]);
    $id_asientod   =     $_GET["id_asientod"];

    $accion        =     trim($_GET["accion"]);
       
    
    if (   $accion  == 'add') {

                    $asiento_detalle = $bd->query_array('co_asientod',
                    'cuenta,id_asiento,debe,haber',
                    'id_asientod='.$bd->sqlvalue_inyeccion($id_asientod,true) 
                    );
                    
                    $cuenta1    = trim($asiento_detalle['cuenta']);
                    $id_asiento = $asiento_detalle['id_asiento'];

                    $estado_periodo = $bd->query_array('co_asiento',
                        'mes,anio,id_periodo,estado,fecha',
                        'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true) 
                        );

                        $anio = $estado_periodo['anio'];

                        if ( $asiento_detalle['debe'] > 0 ){
                            $debe    =	$monto;
                            $haber   = 0;
                        }else{
                            $debe    = 0;
                            $haber   = 	$monto;
                        }
                        $total       = $debe + $haber ;
                        $dato        = strlen($idprov);
                        $ruc         =  trim($_SESSION['ruc_registro']);
                        $sesion 	 =  trim($_SESSION['email']);

                        $resultado = 'NO SE GENERO LA INFORMACION...';    
                        //------------------------------------------------------------
                        $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, fecha,fechap,cuenta, debe, haber,parcial, id_periodo,
                                                                                anio, mes, sesion, creacion, registro) VALUES (".
                                                                                $bd->sqlvalue_inyeccion($id_asientod  , true).",".
                                                                                $bd->sqlvalue_inyeccion($id_asiento, true).",".
                                                                                $bd->sqlvalue_inyeccion(trim($idprov) , true).",".
                                                                                $bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
                                                                                $bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
                                                                                $bd->sqlvalue_inyeccion($cuenta1 , true).",".
                                                                                $bd->sqlvalue_inyeccion($debe , true).",".
                                                                                $bd->sqlvalue_inyeccion($haber , true).",".
                                                                                $bd->sqlvalue_inyeccion($total , true).",".
                                                                                $bd->sqlvalue_inyeccion($estado_periodo["id_periodo"], true).",".
                                                                                $bd->sqlvalue_inyeccion($anio, true).",".
                                                                                $bd->sqlvalue_inyeccion($estado_periodo["mes"] , true).",".
                                                                                $bd->sqlvalue_inyeccion($sesion 	, true).",".
                                                                                $bd->sqlvalue_inyeccion($estado_periodo["fecha"] , true).",".
                                                                                $bd->sqlvalue_inyeccion( $ruc  , true).")";
                                                                                
                                                                                 if ( $total > 0 )     {
                                                                                    if ($dato > 6 ){
                                                                                        $bd->ejecutar($sql);
                                                                                        $resultado = 'DATOS CREADOS CON EXITO';    
                                                                                    }
                                                                                }
                 
                                                                                echo $resultado;    

               }else   {      
                $id_asiento_aux   = $_GET["id_asiento_aux"];
                $sql              = "delete from co_asiento_aux where id_asiento_aux = ".  $bd->sqlvalue_inyeccion( $id_asiento_aux  , true);
                $bd->ejecutar($sql);
                $resultado = 'DATOS ELIMINADOS CON EXITO...';    
                echo $resultado;    
            }
    
?>