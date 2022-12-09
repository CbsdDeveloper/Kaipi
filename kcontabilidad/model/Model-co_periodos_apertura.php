<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$ruc_registro     =  $_SESSION['ruc_registro'];
$fanio            =  $_GET['fanio'];
$accion           =  $_GET['accion'];
$parametro        =  $_GET['parametro'];
$sesion 	      =  $_SESSION['email'];


$sql = "select count(*) as nn, max(id_asiento) as id_asiento
             from co_asiento
            where tipo    = ".$bd->sqlvalue_inyeccion('T' ,true)." and
                  registro=".$bd->sqlvalue_inyeccion($ruc_registro ,true)." and
                  anio    =".$bd->sqlvalue_inyeccion($fanio ,true);

$resultado1 = $bd->ejecutar($sql);

$x          = $bd->obtener_array( $resultado1);

$id_asiento = $x['id_asiento'] ;

if ( $accion == 1 ){
    
    asiento_contable($bd ,$ruc_registro,$fanio,$id_asiento);
    
}else {
    
    if ( $parametro == 1){

        if ( $x['nn']  > 0 ){
            $data = 'ASIENTO DE APERTURA YA GENERADO!!! DEL PERIODO '.$fanio;
        }else{
            // AGREGA ASIENTO RESUMEN PARA INICIAL
            $id_asiento = agregar($bd ,$ruc_registro,$fanio,$sesion);

            $data = 'ASIENTO DE APERTURA GENERADO!!! DEL PERIODO '.$fanio.' - NRO. ASIENTO GENERADO '.$id_asiento;
        }
        
    }elseif ( $parametro == 2){

        agregar_resultado($bd ,$ruc_registro,$fanio,$sesion,$id_asiento);
        
    }elseif ( $parametro == 3){

        $id           =  $_GET['id'];
        eliminar_detalle($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,$id);

    }elseif ( $parametro == 4){

        agregar_orden($bd ,$ruc_registro,$fanio,$sesion,$id_asiento);

    }elseif ( $parametro == 7){

        aprobar_asiento($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,'aprobado');

    }elseif ( $parametro == 8){

        aprobar_asiento($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,'digitado');

    }elseif ( $parametro == 9){
        $id           =  $_GET['id'];
        $cuenta1      =  trim($_GET['cuenta1']);
        $cuenta2      =  trim($_GET['cuenta2']);
        $montoi       =  $_GET['montoi'];
        
        costos_asiento($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,$cuenta1,$cuenta2,$montoi);
    }
    
    asiento_contable($bd ,$ruc_registro,$fanio,$id_asiento);
        
}



echo $data;
//-------------
function aprobar_asiento($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,$estado ){
            
        $sql = "update co_asiento 
                  set estado =" .$bd->sqlvalue_inyeccion($estado, true)."
			    WHERE id_asiento=".$bd->sqlvalue_inyeccion($id_asiento, true);
        
        $bd->ejecutar($sql);
        
 
}

//-------------------------
function eliminar_detalle($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,$id_asientod){
    
    $sql = "SELECT *
    	            FROM co_asiento
                    where id_asiento = ".$bd->sqlvalue_inyeccion($id_asiento ,true);
    
    $resultado = $bd->ejecutar($sql);
    
    $datos1 = $bd->obtener_array( $resultado);
    
    // parametros kte
    $estado     = $datos1["estado"];
    
    if (trim($estado) == 'digitado'){
        
        $sql = 'delete from co_asientod
			    				 WHERE id_asientod='.$bd->sqlvalue_inyeccion($id_asientod, true);
        
        $bd->ejecutar($sql);
        
        $sql = 'delete from co_asiento_aux
			    				 WHERE id_asientod='.$bd->sqlvalue_inyeccion($id_asientod, true);
        
        $bd->ejecutar($sql);
    } 
}
/*
GENERA ASIENTO INCIAL DE INFORMACION....
*/
function agregar($bd ,$ruc_registro,$fanio,$sesion){
    
    $estado         = 'digitado';

    $finicio        =  $fanio.'-01-01';

    $fecha			= $bd->fecha($finicio);
    
    $documento = $fanio.'-001';
    
    //------------ seleccion de periodo

    $periodo_s = $bd->query_array('co_periodo',
        'id_periodo, mes, anio',
        'registro ='.$bd->sqlvalue_inyeccion($ruc_registro ,true).' and
         anio ='.$bd->sqlvalue_inyeccion($fanio ,true).' and
         mes ='.$bd->sqlvalue_inyeccion(1 ,true)
        );
    
    $mes  			= $periodo_s["mes"];
    $anio  			= $periodo_s["anio"];
    $id_periodo  	= $periodo_s["id_periodo"];
    $detalle        = 'Asiento de apertura correspondiente al periodo '.$fanio;
    
    $comprobante    = '-';
    //------------------------------------------------------------
    $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,
                						comprobante, estado, tipo, documento,modulo,id_periodo)
										        VALUES (".$fecha.",".
										        $bd->sqlvalue_inyeccion($ruc_registro, true).",".
										        $bd->sqlvalue_inyeccion($anio, true).",".
										        $bd->sqlvalue_inyeccion($mes, true).",".
										        $bd->sqlvalue_inyeccion($detalle, true).",".
										        $bd->sqlvalue_inyeccion($sesion, true).",".
										        $fecha.",".
										        $bd->sqlvalue_inyeccion($comprobante, true).",".
										        $bd->sqlvalue_inyeccion($estado, true).",".
										        $bd->sqlvalue_inyeccion('T', true).",".
										        $bd->sqlvalue_inyeccion($documento, true).",".
										        $bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        
										        $bd->ejecutar($sql);
										        
										        $idAsiento =  $bd->ultima_secuencia('co_asiento');
										        
									         agregarActivos($bd,$ruc_registro,$anio,$idAsiento,$id_periodo,$mes,$sesion,$fecha);
										        
										     agregarPasivos($bd,$ruc_registro,$anio,$idAsiento,$id_periodo,$mes,$sesion,$fecha);
										        
									         agregarPatrimonio($bd,$ruc_registro,$anio,$idAsiento,$id_periodo,$mes,$sesion,$fecha);
										        
										        
 										        
										        return 	$idAsiento;
										        
}
//----------------------------;
function costos_asiento($bd ,$ruc_registro,$fanio,$sesion,$id_asiento,$cuenta1,$cuenta2,$montoi){
    
    $finicio        =  $fanio.'-01-01';
    $fecha			= $bd->fecha($finicio);
    
    
    //------------ seleccion de periodo
    $periodo_s = $bd->query_array('co_periodo',
        'id_periodo, mes, anio',
        'registro ='.$bd->sqlvalue_inyeccion($ruc_registro ,true).' and
         anio ='.$bd->sqlvalue_inyeccion($fanio ,true).' and
         mes ='.$bd->sqlvalue_inyeccion(1 ,true)
        );
    
    $mes  			= $periodo_s["mes"];
    $anio  			= $periodo_s["anio"];
    $id_periodo  	= $periodo_s["id_periodo"];
    
    $bandera = 0;
    
    $lent1 = strlen($cuenta1);
    $lent2 = strlen($cuenta2);
    
    if ( $lent1 > 3  ){
        $bandera = 1;
    }
    if ( $lent2 > 3){
        $bandera = 1;
    }
    
     
    if ( $bandera == 1 ){
    
         
    $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id_asiento , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta2), true).",".
								$bd->sqlvalue_inyeccion( 'N', true).",".
								$bd->sqlvalue_inyeccion($montoi, true).",".
								$bd->sqlvalue_inyeccion('0.00', true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $ruc_registro, true).")";
								
								$bd->ejecutar($sql_inserta);
								
	//-------------------------------------------------------------------------							
	
								$sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id_asiento , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta1), true).",".
								$bd->sqlvalue_inyeccion( 'N', true).",".
								$bd->sqlvalue_inyeccion('0.00', true).",".
								$bd->sqlvalue_inyeccion($montoi, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $ruc_registro, true).")";
								
								$bd->ejecutar($sql_inserta);
								
    }
	 return 	$id_asiento;
    
}
//----------------------------------------------
function agregar_resultado($bd ,$ruc_registro,$fanio,$sesion,$idAsiento){
    
    $finicio        =  $fanio.'-01-01';
    $fecha			= $bd->fecha($finicio);
    
     
    //------------ seleccion de periodo
    $periodo_s = $bd->query_array('co_periodo',
        'id_periodo, mes, anio',
        'registro ='.$bd->sqlvalue_inyeccion($ruc_registro ,true).' and
         anio ='.$bd->sqlvalue_inyeccion($fanio ,true).' and
         mes ='.$bd->sqlvalue_inyeccion(1 ,true)
        );
    
    $mes  			= $periodo_s["mes"];
    $anio  			= $periodo_s["anio"];
    $id_periodo  	= $periodo_s["id_periodo"];
 										        
	agregarResultados($bd,$ruc_registro,$anio,$idAsiento,$id_periodo,$mes,$sesion,$fecha);
										        
	return 	$idAsiento;
										        
}
//-----------------
function agregar_orden($bd ,$ruc_registro,$fanio,$sesion,$idAsiento){
    
    $finicio        =  $fanio.'-01-01';
    $fecha			= $bd->fecha($finicio);
    
    
    //------------ seleccion de periodo
    $periodo_s = $bd->query_array('co_periodo',
        'id_periodo, mes, anio',
        'registro ='.$bd->sqlvalue_inyeccion($ruc_registro ,true).' and
         anio ='.$bd->sqlvalue_inyeccion($fanio ,true).' and
         mes ='.$bd->sqlvalue_inyeccion(1 ,true)
        );
    
    $mes  			= $periodo_s["mes"];
    $anio  			= $periodo_s["anio"];
    $id_periodo  	= $periodo_s["id_periodo"];
    
    agregarResultadosOrden($bd,$ruc_registro,$anio,$idAsiento,$id_periodo,$mes,$sesion,$fecha);
    
    return 	$idAsiento;
    
}
//------------------------------------------
function agregarDetalle($bd, $id,$cuenta,$id_periodo,$anio,$mes,$registro,$sesion,$debe,$haber,$fecha,$aux,$tipo_cuenta){
    
    
    
    $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id , true).",".
								$bd->sqlvalue_inyeccion( ltrim(rtrim($cuenta)), true).",".
								$bd->sqlvalue_inyeccion( $aux, true).",".
								$bd->sqlvalue_inyeccion($debe, true).",".
								$bd->sqlvalue_inyeccion($haber, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $registro, true).")";
								
								$bd->ejecutar($sql_inserta);
								
								$total = $debe + $haber;
								
								if ( $total <> 0 ) {
								    
								    $id_asientod =  $bd->ultima_secuencia('co_asientod');
								    
								    if ( $aux == 'S'){
								        if ( $tipo_cuenta <> 'B')
								            agregar_detalle_aux($bd,$id,$id_asientod,$cuenta,$registro,$debe,$anio,$mes,$id_periodo,$sesion,$fecha);
								            
								    }
								}
								
								
}
//-------------------------
function agregarDetallea($bd, $id,$cuenta,$id_periodo,$anio,$mes,$registro,$sesion,$debe,$haber,$fecha,$aux,$tipo_cuenta){
    
    
    
    $anio1 = $anio - 1 ;
    
    $sql_det = "select cuenta,idprov, sum(debe) debe, sum(haber) haber,sum(debe) - sum(haber) saldo
                    FROM public.view_diario_aux
                    where registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                          anio= ".$bd->sqlvalue_inyeccion($anio1, true)." and
                          cuenta = ".$bd->sqlvalue_inyeccion($cuenta, true)."
                    group by cuenta,idprov";
    
    
 
    
    $stmt14 = $bd->ejecutar($sql_det);
    
    while ($y=$bd->obtener_fila($stmt14)){
        
        $debe   =  $y["saldo"];
        $haber  =  0 ;
        $idprov =  trim($y["idprov"]);
        
        $total = $debe + $haber;
        
        if ( $total <> 0 ) {
            
            $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta), true).",".
								$bd->sqlvalue_inyeccion( $aux, true).",".
								$bd->sqlvalue_inyeccion($debe, true).",".
								$bd->sqlvalue_inyeccion($haber, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $registro, true).")";
								
								$bd->ejecutar($sql_inserta);
								
								
								$id_asientod =  $bd->ultima_secuencia('co_asientod');
								
								agregar_detalle_aux_solo($bd,$id,$id_asientod,$cuenta,$registro,$debe,$anio,$mes,$id_periodo,$sesion,$fecha,$idprov);
        }
    }
    
    
    
    
}
//------------------------
function agregarResultadosOrden($bd,$registro,$anio,$id,$id_periodo,$mes,$sesion,$fecha){
    
    $anio1 = $anio - 1 ;
    
    $sql_det = "SELECT  anio, cuenta, debe, haber, saldo, registro
                    FROM view_diario_anual
                    where anio     = ".$bd->sqlvalue_inyeccion($anio1, true)."  and
                          registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                          cuenta like '9%' and saldo <> 0
                    order by cuenta";
    
    
    
    $stmt13 = $bd->ejecutar($sql_det);
    
    while ($x=$bd->obtener_fila($stmt13)){
        
        if ( $x["saldo"] > 0 ){
            $debe   =  $x["saldo"];
            $haber  =  0 ;
        }else{
            $debe   =  0;
            $haber  =  $x["saldo"] * -1;
        }
        
        
        
        $cuenta = trim($x["cuenta"]);
        
        //-------------------------------------------------------------------------------
        $datosaux  = $bd->query_array('co_plan_ctas',
            'aux,tipo_cuenta',
            'cuenta='.$bd->sqlvalue_inyeccion($cuenta,true).' and
            registro ='.$bd->sqlvalue_inyeccion( $registro ,true). 'and
                anio='.$bd->sqlvalue_inyeccion( $anio ,true)
            );
        $aux		        = $datosaux['aux'];
        //-------------------------------------------------------------------------------
        
        $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta), true).",".
								$bd->sqlvalue_inyeccion( $aux, true).",".
								$bd->sqlvalue_inyeccion($debe, true).",".
								$bd->sqlvalue_inyeccion($haber, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $registro, true).")";
								
								$bd->ejecutar($sql_inserta);
								
    }
}
//------------------------------------------------------------------------------------------------
function agregarActivos($bd,$registro,$anio,$id,$id_periodo,$mes,$sesion,$fecha){
    
    $anio1 = $anio - 1 ;
    
    $sql_det = "SELECT  anio, cuenta, debe, haber, saldo, registro
                    FROM view_diario_anual
                    where anio     = ".$bd->sqlvalue_inyeccion($anio1, true)."  and
                          registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                          cuenta like '1%' and saldo <> 0
                    order by cuenta";
    

    
    $stmt13 = $bd->ejecutar($sql_det);
    
    while ($x=$bd->obtener_fila($stmt13)){
        
        if ( $x["saldo"] > 0 ){
            $debe   =  $x["saldo"];
            $haber  =  0 ;
        }else{
            $debe   =  0;
            $haber  =  $x["saldo"] * -1;
        }
        
        
        
        $cuenta = trim($x["cuenta"]);
        
        //-------------------------------------------------------------------------------
        $datosaux  = $bd->query_array('co_plan_ctas',
            'aux,tipo_cuenta',
            'cuenta='.$bd->sqlvalue_inyeccion($cuenta,true).' and
            registro ='.$bd->sqlvalue_inyeccion( $registro ,true). 'and 
                anio='.$bd->sqlvalue_inyeccion( $anio ,true)
            );
        $aux		        = $datosaux['aux'];
         //-------------------------------------------------------------------------------
        
        $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta), true).",".
								$bd->sqlvalue_inyeccion( $aux, true).",".
								$bd->sqlvalue_inyeccion($debe, true).",".
								$bd->sqlvalue_inyeccion($haber, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $registro, true).")";
								
								$bd->ejecutar($sql_inserta);
        
    }

    $sql_inserta ="delete from co_asientod where cuenta like '15%' and id_asiento=".$bd->sqlvalue_inyeccion($id , true);
    $bd->ejecutar($sql_inserta);


}
//----------------------------------------------
function agregarPasivos($bd,$registro,$anio,$id,$id_periodo,$mes,$sesion,$fecha){
    
    
    $anio1 = $anio - 1 ;
    
    $sql_det = "SELECT  anio, cuenta, debe, haber, saldo, registro
                    FROM view_diario_anual
                    where anio     = ".$bd->sqlvalue_inyeccion($anio1, true)."  and
                          registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                          cuenta like '2%' and saldo <> 0
                    order by cuenta";
    
    
    
    $stmt13 = $bd->ejecutar($sql_det);
    
    while ($x=$bd->obtener_fila($stmt13)){
        
        $saldo = $x["saldo"]  ;
 
            $debe   =  0;
            $haber  = $saldo *-1;
         
        
        
        $cuenta = trim($x["cuenta"]);
        
        //-------------------------------------------------------------------------------
        $datosaux  = $bd->query_array('co_plan_ctas',
            'aux,tipo_cuenta',
            'cuenta='.$bd->sqlvalue_inyeccion($cuenta,true).' and
                 registro ='.$bd->sqlvalue_inyeccion( $registro ,true). 'and
                anio='.$bd->sqlvalue_inyeccion( $anio ,true)
            );
        $aux		        = $datosaux['aux'];
         //-------------------------------------------------------------------------------
        
       
        $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta), true).",".
								$bd->sqlvalue_inyeccion( $aux, true).",".
								$bd->sqlvalue_inyeccion($debe, true).",".
								$bd->sqlvalue_inyeccion($haber, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $registro, true).")";
								
								$bd->ejecutar($sql_inserta);
        
        
        
    }
    
    
}
//--------------------------
function agregarPatrimonio($bd,$registro,$anio,$id,$id_periodo,$mes,$sesion,$fecha){
    
    $anio1 = $anio - 1 ;
    
    $sql_det = "SELECT  anio, cuenta, debe, haber, saldo, registro
                    FROM view_diario_anual
                    where anio     = ".$bd->sqlvalue_inyeccion($anio1, true)."  and
                          registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                          cuenta like '61%'  and saldo <> 0
                    order by cuenta";
    
    
    
    $stmt13 = $bd->ejecutar($sql_det);
    
    while ($x=$bd->obtener_fila($stmt13)){
        
        $saldo = $x["debe"] - $x["haber"];
        
        if ( $saldo > 0 ){
            $debe   =  $saldo;
            $haber  = 0;
        }else{
            $debe   =   0;
            $haber  =   $saldo * -1;
        }
        
        
        
        $cuenta = trim($x["cuenta"]);
        
        //-------------------------------------------------------------------------------
        $datosaux  = $bd->query_array('co_plan_ctas',
            'aux,tipo_cuenta',
            'cuenta='.$bd->sqlvalue_inyeccion($cuenta,true).' and
                 registro ='.$bd->sqlvalue_inyeccion( $registro ,true). 'and
                anio='.$bd->sqlvalue_inyeccion( $anio ,true)
            );
        $aux		        = $datosaux['aux'];
         //-------------------------------------------------------------------------------
        
        $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$bd->sqlvalue_inyeccion($id , true).",".
								$bd->sqlvalue_inyeccion( trim($cuenta), true).",".
								$bd->sqlvalue_inyeccion( $aux, true).",".
								$bd->sqlvalue_inyeccion($debe, true).",".
								$bd->sqlvalue_inyeccion($haber, true).",".
								$bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$bd->sqlvalue_inyeccion( $anio, true).",".
								$bd->sqlvalue_inyeccion( $mes, true).",".
								$bd->sqlvalue_inyeccion($sesion, true).",".
								$fecha.",".
								$bd->sqlvalue_inyeccion( $registro, true).")";
								
								$bd->ejecutar($sql_inserta);
        
    }
    
}
//-------------------------
//--------------------------
function agregarResultados($bd,$registro,$anio,$id,$id_periodo,$mes,$sesion,$fecha){
    
    $anio1 = $anio - 1 ;
    
    $sql_det = " SELECT coalesce (sum(saldo),0) as monto
                      FROM view_diario_anual
                     where registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                            anio= ".$bd->sqlvalue_inyeccion($anio1, true)." and cuenta like '62%' ";
    
    $stmt13 = $bd->ejecutar($sql_det);
    while ($x=$bd->obtener_fila($stmt13)){
        $ingresos  =  $x["monto"]  * - 1;
    }
    //-----------------------
    $sql_det = " SELECT coalesce (sum(saldo),0) as monto
                      FROM view_diario_anual
                     where registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                            anio= ".$bd->sqlvalue_inyeccion($anio1, true)." and cuenta like '63%' ";
    
    $stmt14 = $bd->ejecutar($sql_det);
    
    while ($x=$bd->obtener_fila($stmt14)){
        $gastos  =  $x["monto"] ;
    }
    //--------------------------------
    $resultado = $ingresos -  $gastos;
    
    //--------------------------------------------
    $y = $bd->query_array('co_plan_ctas',
        'cuenta',
        'registro='.$bd->sqlvalue_inyeccion($registro,true). ' and
            tipo_cuenta='.$bd->sqlvalue_inyeccion('E',true). 'and
                anio='.$bd->sqlvalue_inyeccion( $anio ,true)
        );
    
    
    $cuenta =$y["cuenta"];
    
    //------------------------------------------------
    $aux = 'N';
    $tipo_cuenta = '-';
    
    
    
    if (!empty($cuenta) ){
        $debe   =  0;
        $haber  =  $resultado ;
         
        
        agregarDetalle($bd, $id,$cuenta,$id_periodo,$anio,$mes,$registro,$sesion,$debe,$haber,$fecha,$aux,$tipo_cuenta);
        
    }
    
}
//------------------
function agregar_detalle_aux($bd,$id_asiento,$id_asientod,$cuenta,$registro,$debe,$anio,$mes,$id_periodo,$sesion,$fecha){
    
    $anio1 = $anio - 1 ;
    
    $saldo = 0;
    
    $bandera = 0;
    
    if ( $debe > 0 ){
        
        $sql_det = "SELECT idprov, sum(debe) - sum(haber) as saldo
                    FROM view_aux
                    where anio     = ".$bd->sqlvalue_inyeccion($anio1, true)."  and
                          registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                          cuenta  = ".$bd->sqlvalue_inyeccion($cuenta, true)." and
                          estado  = ".$bd->sqlvalue_inyeccion('aprobado', true)."
                    group by idprov";
        
        $bandera = 0;
    }else{
        
        $sql_det = "SELECT idprov, sum(haber) - sum(debe) as saldo
                    FROM view_aux
                    where anio     = ".$bd->sqlvalue_inyeccion($anio1, true)."  and
                          registro = ".$bd->sqlvalue_inyeccion($registro, true)." and
                          cuenta  = ".$bd->sqlvalue_inyeccion($cuenta, true)." and
                          estado  = ".$bd->sqlvalue_inyeccion('aprobado', true)."
                    group by idprov";
        $bandera = 1;
    }
    
    
    
    
    $stmt13 = $bd->ejecutar($sql_det);
    
    while ($x=$bd->obtener_fila($stmt13)){
        
        $idprov = $x["idprov"];
        
        if ( $bandera == 0 ){
            $debe  = $x["saldo"];
            $haber = 0;
        }else{
            $debe  = 0;
            $haber = $x["saldo"];
        }
        
        $total = $debe + $haber ;
        
        $dato = strlen($idprov);
        
        //------------------------------------------------------------
        $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, registro) VALUES (".
    		              									  $bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $bd->sqlvalue_inyeccion(trim($idprov) , true).",".
    		              									  $bd->sqlvalue_inyeccion($cuenta , true).",".
    		              									  $bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $bd->sqlvalue_inyeccion($saldo , true).",".
    		              									  $bd->sqlvalue_inyeccion($id_periodo, true).",".
    		              									  $bd->sqlvalue_inyeccion($anio, true).",".
    		              									  $bd->sqlvalue_inyeccion($mes , true).",".
    		              									  $bd->sqlvalue_inyeccion($sesion 	, true).",".
    		              									  $fecha.",".
    		              									  $bd->sqlvalue_inyeccion( $registro , true).")";
        
    		              									  if ( $total > 0 )     {
    		              									      if ($dato > 6 ){
    		              									          $bd->ejecutar($sql);
    		              									      }
     		              									      
    		              									  }
    }
}
//----------------------------------
//------------------
function agregar_detalle_aux_solo($bd,$id_asiento,$id_asientod,$cuenta,$registro,$debe,$anio,$mes,$id_periodo,$sesion,$fecha,$idprov){
    
    
    $dato = strlen($idprov);
    
    $haber = 0;
    
    $total = $debe + $haber ;
    //------------------------------------------------------------
    $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, registro) VALUES (".
    		              									  $bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $bd->sqlvalue_inyeccion(trim($idprov) , true).",".
    		              									  $bd->sqlvalue_inyeccion($cuenta , true).",".
    		              									  $bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $bd->sqlvalue_inyeccion($total , true).",".
    		              									  $bd->sqlvalue_inyeccion($id_periodo, true).",".
    		              									  $bd->sqlvalue_inyeccion($anio, true).",".
    		              									  $bd->sqlvalue_inyeccion($mes , true).",".
    		              									  $bd->sqlvalue_inyeccion($sesion 	, true).",".
    		              									  $fecha.",".
    		              									  $bd->sqlvalue_inyeccion( $registro , true).")";
    		              									  
    		              									  if ( $total > 0 )     {
    		              									      if ($dato > 6 ){
    		              									          $bd->ejecutar($sql);
    		              									      }
    		              									      
    		              									  }
    		              									  
}
//-------------------------
function asiento_contable($bd ,$ruc_registro,$fanio,$idasiento){
    
    $sql = 'SELECT a.cuenta,
                   b.detalle,
                   COALESCE(a.debe,0) as debe,
                   COALESCE(a.haber,0) as haber,
                   a.aux,
                   a.principal,
                   a.codigo1,
                   a.partida,
                   a.item,
                   a.monto1,
                   a.monto2,
                   a.id_asientod,
                   b.partida_enlace
        FROM co_asientod a,  co_plan_ctas b
        where a.id_asiento= '.$bd->sqlvalue_inyeccion($idasiento, true).' and
              b.anio= '.$bd->sqlvalue_inyeccion($fanio, true).' and
              b.cuenta = a.cuenta
        order by a.cuenta';
    
    
    echo ' <table id="jsontable_deta" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
     			<thead>
    			 <tr>
                    <th align="center" width="10%">Acciones</th>
    				<th align="center" width="10%">Cuenta</th>
    				<th align="center" width="35%">Detalle</th>
                    <th align="center" width="15%">Debe</th>
    				<th align="center" width="15%">Haber</th>
    				<th align="center" width="15%">partida</th>
                    </tr>
    			</thead>';
    
    /*
     <a class="btn btn-xs" href="javascript:open_pop('../model/ajax_delAsientosd','action=del&amp;tid=1079&amp;codigo=298',30,30)">
     <i class="icon-trash icon-white"></i></a>
     <a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalAux" onclick="ViewDetAuxiliar(1079)"> ViewDetAuxiliar
     <i class="icon-user icon-white"></i>
     </a><a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalCostos" onclick="ViewDetCostos(1079)">
     <i class="icon-asterisk icon-white"></i> Controller-co_xpagar_gasto.php
     </a>
     */
    
    $resultado	= $bd->ejecutar($sql);
    
    $debe  = 0;
    $haber = 0;
    
    while ($y=$bd->obtener_fila($resultado)){
        
        
        $funcion1   = ' onClick="goToURLDel('."'del'".",". $y['id_asientod'].')" ';
        $title1     = 'title="Eliminar Informacion"';
        $boton_del  = '<button   class="btn btn-xs" '.$title1.$funcion1.'   ><i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
        
        $cpartida   = '<span style="color: #A0A0A0">'.trim($y['partida']).'</span>';
        
        $boton_gas  = '';
        $fondo      = '';
        $color      = '';
        
         
        
       
            $funcion1  = ' onClick="PoneEnlace('.$y['id_asientod'].",'".trim($y['cuenta'])."'".')" ';
            $title1    = 'data-toggle="modal" data-target="#myModalAuxIng" title="Asistente de asiento enlace"';
            $boton_ing = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;';
            

            $boton_ing2= ' ';   

        if ( $y['aux'] == 'S'){
            $funcion2  = ' onClick="PoneEnlaceAUX('.$y['id_asientod'].",'".trim($y['cuenta'])."'".')" ';
            $title2    = 'data-toggle="modal" data-target="#myModalAux" title="Asistente de asiento enlace"';
            $boton_ing2 = '<button   class="btn btn-xs" '.$title2.$funcion2.' ><i class="glyphicon glyphicon-user"></i></button>&nbsp;';
        }
        
        $acciones = $boton_gas.$boton_del.$boton_ing. $boton_ing2;
        
        $evento = '';
        $evento1 = '';
        
        $clased = ' class="form-control_asiento" min="-99999999" max="9999999" step="0.01" '. 'id="debe_'.trim($y['id_asientod']).'" name="debe_'.trim($y['id_asientod']).'"'.' ';
        $claseh = ' class="form-control_asiento" min="-99999999" max="9999999" step="0.01" '. 'id="haber_'.trim($y['id_asientod']).'" name="haber_'.trim($y['id_asientod']).'"'.' ';
        
        
        $evento =  'onChange="actualiza_datod('.'this.value,'. $y['id_asientod'].')" ';
        $evento1 =  'onChange="actualiza_datoh('.'this.value,'. $y['id_asientod'].')" ';
        
        $cuenta = trim($y['cuenta']);
         
        echo ' <tr>
               <td '.$color.'>'.$acciones.$fondo.'</td>
				<td>'.$cuenta.'</td>
				<td>'.$y['detalle'].'</td>
                <td align="right">'.' <input type="number" '.$evento.$clased.' value='.'"'.trim($y['debe']).'"'.'>'.'</td>
                <td align="right">'.' <input type="number" '.$evento1.$claseh.'value='.'"'.trim($y['haber']).'"'.'>'.'</td>
                <td>'.$cpartida.'</td>
                 </tr>';
        
        
        $debe  = $debe  + $y['debe'];
        $haber = $haber + $y['haber'];
    }
    
    $saldo = round($debe,2) - round($haber,2);
    
    echo ' <tr>
                <td><b>TOTAL</b></td>
				<td><b>RESUMEN</b></td>
				<td>&nbsp;</td>
                <td align="right"><b>'.number_format($debe,2).'</b></td>
                <td align="right"><b>'.number_format($haber,2).'</b></td>
                <td align="right"><b>'.number_format($saldo,2).'</b></td>
                 </tr>';
    
    //<input type="hidden">
    echo	'</table> ';
    

    echo '<script>
        jQuery.noConflict(); 
             jQuery(document).ready(function() {
                 	jQuery("#jsontable_deta").DataTable( {      
                         "searching": true,
                         "paging": false, 
                         "info": false,         
                         "lengthChange":false ,
                         "aoColumnDefs": [
                		      { "sClass": "highlight", "aTargets": [ 1 ] },
                		    ]
                    } );
                } ); 
        </script>';

    $div_mistareas = 'ok';
    
    echo $div_mistareas;
}
?>