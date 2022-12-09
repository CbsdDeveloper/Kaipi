<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $sql ="select * from co_plan_ctas b where anio='2020'" ;
 
    $stmt = $bd->ejecutar($sql);
    
    $i = 1;
    while ($x=$bd->obtener_fila($stmt)){
        
       //   agregar($bd, $x);
    //     agregarDetalle($bd, $x);
        pone_cuenta($bd, $x);
         
        echo trim($x["cuenta"]).' Detalle -  '.$i.'<br> ';
        
        $i++;
        
    }
 //----------------------------------------------------------
  
 //---------------------------
    function agregarDetalle( $bd, $dx ){
        
        
        $x = $bd->query_array('co_asiento',
            '*',
            'id_asiento='.$bd->sqlvalue_inyeccion(1,true)
            );
        
            
        $id_asiento = 1 ;
        $ruc        = $_SESSION['ruc_registro'];
        $sesion     = $x["sesion"] ;
        $fecha      = $x["Fecha_Asiento"] ;
        
        

        
        $id_periodo=$x["id_periodo"];
        $mes  			= $x["mes"];
        $anio  			= $x["anio"];
        
             
                 
                 $cuenta = trim($dx["final"]);
                 
                 
                 $datosaux  = $bd->query_array('co_plan_ctas',
                     'aux,partida_enlace, debito,credito ',
                     'cuenta='.$bd->sqlvalue_inyeccion($cuenta,true).' and
					  registro ='.$bd->sqlvalue_inyeccion($ruc,true)
                     );
                 
                 $aux		            = $datosaux['aux'];
                 
                 
                      $debe  = $dx["debe"] ;
                      $haber = $dx["haber"];
                  
                      $item = '-';
                 
                  
                 $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta,item, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id_asiento , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta), true).",".
								$bd->sqlvalue_inyeccion( trim($item), true).",".
								$bd->sqlvalue_inyeccion( $aux, true).",".
								$bd->sqlvalue_inyeccion($debe, true).",".
								$bd->sqlvalue_inyeccion($haber, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion , true).",".
								$bd->sqlvalue_inyeccion($fecha , true).",".
								$bd->sqlvalue_inyeccion( $ruc, true).")";
								
								$bd->ejecutar($sql_inserta);
                
  

 
    }
    //---------------------------
    function pone_cuenta( $bd, $x ){
        
        $datosaux  = $bd->query_array('co_plan_ctas',
            'cuenta,cuentas,detalle,tipo,aux,tipo_cuenta,nivel,deudor_acreedor ',
            'cuenta='.$bd->sqlvalue_inyeccion(trim($x['cuenta']),true).' and
					  anio ='.$bd->sqlvalue_inyeccion('2019',true)
            );
        
         
          
             
            
        $sql_inserta = "update co_plan_ctas 
                         set detalle    = ".$bd->sqlvalue_inyeccion(trim($datosaux["detalle"]) , true)." ,
                            deudor_acreedor         = ".$bd->sqlvalue_inyeccion(trim($datosaux["deudor_acreedor"]) , true)." ,
                            tipo_cuenta = ".$bd->sqlvalue_inyeccion(trim($datosaux["tipo_cuenta"]) , true)." 
                         where anio = '2020' and 
                              cuenta = ".$bd->sqlvalue_inyeccion(trim($x["cuenta"]) , true) ;

     	$bd->ejecutar($sql_inserta);
     	
     	
    }
    
?>
 
  