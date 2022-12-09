<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
	$monto         =     $_GET["monto"];
    $grupo         =     trim($_GET["grupo"]);
	$fanio         =     $_GET["fanio"];
 
    $ruc_registro     =  $_SESSION['ruc_registro'];


    $sql = "select count(*) as nn, max(id_asiento) as id_asiento
             from co_asiento
            where tipo    = ".$bd->sqlvalue_inyeccion('T' ,true)." and
                  registro=".$bd->sqlvalue_inyeccion($ruc_registro ,true)." and
                  anio    =".$bd->sqlvalue_inyeccion($fanio ,true);

    $resultado1 = $bd->ejecutar($sql);
    $x          = $bd->obtener_array( $resultado1);
    $id_asiento = $x['id_asiento'] ;




  $valida = $bd->query_array('co_asientod',
                    'count(*) as nn',
                    'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true) .' and 
                      cuenta like '.$bd->sqlvalue_inyeccion( $grupo.'%',true)
                    );

 
       
    
    if (   $valida['nn'] > 0) {
            echo 'Cuentas ya generadas...';

       }else   {      

        $aasiento = $bd->query_array('co_asiento',
                    'id_periodo,anio,mes,fecha,creacion,sesion',
                    'id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true)  
                    );

                    $id_periodo =  $aasiento['id_periodo'];
                    $mes        =  $aasiento['mes'];
                    $anio       =  $aasiento['anio'];
                    $fecha      =  $aasiento['fecha'];
                    $sesion     =  trim($aasiento['sesion']);
 
                    $fecha			= $bd->fecha($fecha);

                    $sql = "select  cuenta,sum(debe) as debe, sum(haber) as haber
                    from view_diario_conta
                    where cuenta like ". $bd->sqlvalue_inyeccion($grupo.'%' ,true) ." and 
                            anio =". $bd->sqlvalue_inyeccion($anio -1 ,true) ."  
                    group by cuenta
                    order by cuenta";
                            
                
                
                $resultado  = $bd->ejecutar($sql);
            
                while ($fetch=$bd->obtener_fila($resultado)){


                    $cuenta2 = trim($fetch['cuenta']);

                    $debe  = $fetch['debe'];
                    $haber = $fetch['haber'];

                    $sql_inserta = "INSERT INTO co_asientod (
                        id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
                        sesion, creacion, registro)
                        VALUES (".
                        $bd->sqlvalue_inyeccion($id_asiento , true).",".
                        $bd->sqlvalue_inyeccion( trim($cuenta2), true).",".
                        $bd->sqlvalue_inyeccion( 'N', true).",".
                        $bd->sqlvalue_inyeccion($debe, true).",".
                        $bd->sqlvalue_inyeccion($haber, true).",".
                        $bd->sqlvalue_inyeccion( $id_periodo, true).",".
                        $bd->sqlvalue_inyeccion( $anio, true).",".
                        $bd->sqlvalue_inyeccion( $mes, true).",".
                        $bd->sqlvalue_inyeccion($sesion, true).",".
                        $fecha.",".
                        $bd->sqlvalue_inyeccion( $ruc_registro, true).")";
                        
                        $bd->ejecutar($sql_inserta);

                    
                    
                        echo 'cuenta creada con exito...';
                    }

     }            
    
?>