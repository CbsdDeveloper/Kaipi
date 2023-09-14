<?php 
session_start( );     
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
$bd	   = 	new Db ;
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	if (isset($_GET["fecha2"]))	{
	    
	    $result_cxcpago = '<b>TRANSACCION YA REALIZADA </b>';
	    $f1 			    =     $_GET["fecha1"];
	    $f2 				=     $_GET["fecha2"];
 
	    $monto = valida_envio($bd, $f1,$f2 );

		echo $monto.'<br>';
	    
	    if ( $monto > 0){
	        
	        $id =  nuevo($bd, $f1,$f2);
	        
	        actualiza_inventarios($bd, $f1,$f2,$id );
	        
	        $result_cxcpago = '<b>TRANSACCION REALIZADA CON EXITO Asiento : ' .$id.'</b>';
	        
	    }
 
	    
	}
	
	
echo $result_cxcpago;

//--- funciones grud	 
function nuevo($bd, $f1,$f2 ){
 	   
    
    $ruc       =  trim($_SESSION['ruc_registro']);
    $sesion    =  trim($_SESSION['email']);
    
    $total_apagar     =  '0';
     
    $estado           =  'digitado';
    $fecha		      =  $bd->fecha($f2);
    $hoy 	          =  $bd->hoy();
    $cuenta           = '-';
    
    $array_fecha   = explode("-", $f2);
    $mes           = $array_fecha[1];
    $anio          = $array_fecha[0];
    
    $id_asiento_ref =0;
    $secuencial     = '000-'.$anio;
    $cuenta='-';
    
    $idmovimiento = '1';
     
    $detalle = 'Registro de egresos de existencias - Modulo Inventarios '.
        ' correspondientes al periodo  ('.$f1.' al '.$f2.'). usuario: '.$sesion;
    
    //------------ seleccion de periodo
    $periodo_s = $bd->query_array('co_periodo',
        'id_periodo',
        'registro ='.$bd->sqlvalue_inyeccion($ruc ,true).' and
                                         anio ='.$bd->sqlvalue_inyeccion($anio ,true).' and
                                         mes='.$bd->sqlvalue_inyeccion($mes ,true)
        );
    $id_periodo = $periodo_s['id_periodo'];
    
    
    //------------------------------------------------------------
    $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                					comprobante, estado, tipo, documento,idprov,cuentag,
                                    estado_pago,apagar, idmovimiento,
                                    id_asiento_ref,id_periodo)
										        VALUES (".$fecha.",".
										        $bd->sqlvalue_inyeccion($ruc, true).",".
										        $bd->sqlvalue_inyeccion($anio, true).",".
										        $bd->sqlvalue_inyeccion($mes, true).",".
										        $bd->sqlvalue_inyeccion( $detalle, true).",".
										        $bd->sqlvalue_inyeccion($sesion, true).",".
										        $hoy.",".
										        $bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $bd->sqlvalue_inyeccion('-', true).",".
										        $bd->sqlvalue_inyeccion($estado, true).",".
										        $bd->sqlvalue_inyeccion('I', true).",".
										        $bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $bd->sqlvalue_inyeccion(trim($ruc), true).",".
										        $bd->sqlvalue_inyeccion(trim($cuenta), true).",".
										        $bd->sqlvalue_inyeccion( 'S', true).",".
										        $bd->sqlvalue_inyeccion( $total_apagar, true).",".
										        $bd->sqlvalue_inyeccion( $idmovimiento, true).",".
										        $bd->sqlvalue_inyeccion( $id_asiento_ref, true).",".
										        $bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        $bd->ejecutar($sql);
										        
   $idAsiento =  $bd->ultima_secuencia('co_asiento');
   
   agrega_detalle($bd, $idAsiento,$f1,$f2,$id_periodo,$mes,$anio,$ruc,$id_asiento_ref);
		
   
   return $idAsiento;
    
 }
 //-------------------
 function valida_envio($bd, $f1,$f2 ){
     
	$sql1 ="select a.cuenta_gas as inventario, b.detalle,
	sum(a.total) as debe ,
	0 as haber
	FROM view_movimiento_det_cta a, co_plan_ctas b
	where a.estado = 'aprobado' and coalesce(a.id_asiento_ref,0) = 0 and
		  a.tipo= 'E' and trim(a.cuenta_gas) = trim(b.cuenta) and
		  a.anio::character varying::text = b.anio and
		   (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and  a.cuenta_gas <> '-' 
group by a.cuenta_gas, b.detalle
union
select a.cuenta_inv as inventario, b.detalle, 0 as debe,
	sum(a.total) as haber
	FROM view_movimiento_det_cta a, co_plan_ctas b
	where a.estado = 'aprobado' and coalesce(a.id_asiento_ref,0) = 0 and
		  a.tipo= 'E' and trim(a.cuenta_inv) = trim(b.cuenta) and
		  a.anio::character varying::text = b.anio and
		   (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and a.cuenta_inv <> '-' 
group by a.cuenta_inv, b.detalle";
     
 
     
     $stmt  = $bd->ejecutar($sql1);
     
      
     $monto   = 0;
     while ($x=$bd->obtener_fila($stmt)){
         
         $monto   =  $monto + $x['debe'];
         
     }
     
     return $monto;
     
 }
 //------------------------
 function agrega_detalle($bd, $idAsiento,$f1,$f2,$id_periodo,$mes,$anio,$idprov,$id_asiento_ref){
     
     $sql1 ="select a.cuenta_gas as inventario, b.detalle,
 		sum(a.total) as debe ,
 		0 as haber
 		FROM view_movimiento_det_cta a, co_plan_ctas b
 		where a.estado = 'aprobado' and coalesce(a.id_asiento_ref,0) = 0 and
 			  a.tipo= 'E' and trim(a.cuenta_gas) = trim(b.cuenta) and
 			  a.anio::character varying::text = b.anio and
 			   (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and  a.cuenta_gas <> '-' 
 group by a.cuenta_gas, b.detalle
 union
 select a.cuenta_inv as inventario, b.detalle, 0 as debe,
 		sum(a.total) as haber
 		FROM view_movimiento_det_cta a, co_plan_ctas b
 		where a.estado = 'aprobado' and coalesce(a.id_asiento_ref,0) = 0 and
 			  a.tipo= 'E' and trim(a.cuenta_inv) = trim(b.cuenta) and
 			  a.anio::character varying::text = b.anio and
 			   (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and a.cuenta_inv <> '-' 
 group by a.cuenta_inv, b.detalle";
     
     
     $ruc       =  $_SESSION['ruc_registro'];
     $sesion    =  $_SESSION['email'];
     $hoy 	    =  $bd->hoy();
     
     
     $stmt  = $bd->ejecutar($sql1);
 
     while ($x=$bd->obtener_fila($stmt)){
         
         $cuenta = trim($x['inventario']) ;
         $partida= '-';
         
         $item     = '-';
         $programa = '-';
         
         $debe = $x['debe'];
         $haber = $x['haber'];
         
         $sql = "INSERT INTO co_asientod(
        								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
        								sesion, creacion, principal,partida,item,programa,registro)
        								VALUES (".
        								$bd->sqlvalue_inyeccion($idAsiento , true).",".
        								$bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
        								$bd->sqlvalue_inyeccion( 'N', true).",".
        								$bd->sqlvalue_inyeccion($debe, true).",".
        								$bd->sqlvalue_inyeccion($haber, true).",".
        								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
        								$bd->sqlvalue_inyeccion( $anio, true).",".
        								$bd->sqlvalue_inyeccion( $mes, true).",".
        								$bd->sqlvalue_inyeccion($sesion , true).",".
        								$hoy.",".
        								$bd->sqlvalue_inyeccion( 'N', true).",".
        								$bd->sqlvalue_inyeccion( $partida, true).",".
        								$bd->sqlvalue_inyeccion( $item, true).",".
        								$bd->sqlvalue_inyeccion( $programa, true).",".
        								$bd->sqlvalue_inyeccion( $ruc, true).")";
        								
        								$bd->ejecutar($sql);
         
     }
     
      
 }
 //------------------------------------
 function actualiza_inventarios($bd, $f1,$f2,$idasiento ){
     
     $sql2 ="select  id_movimiento 
                from view_movimiento_det_cta 
                where tipo='E' and 
                      estado = 'aprobado' and 
                      id_asiento_ref is null and 
                      (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                group by id_movimiento"; 

 
     
     
     $stmt2  = $bd->ejecutar($sql2);
     
 
     while ($x=$bd->obtener_fila($stmt2)){
         
         $id_movimiento   =    $x['id_movimiento'];
         
         $sqleditar = "update inv_movimiento 
                          set id_asiento_ref = ".$bd->sqlvalue_inyeccion( $idasiento, true)."
                        where id_asiento_ref is null and 
                              id_movimiento =".$bd->sqlvalue_inyeccion( $id_movimiento, true);
         
         $bd->ejecutar($sqleditar);
     }
     
     
 }
    
?>
 
  