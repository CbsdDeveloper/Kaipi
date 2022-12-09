<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

/* 
'ctipo' : ctipo,
'servicio' : servicio,
'monto':monto,
'fecha_caja':fecha_caja,
'parte_caja':parte_caja,
'anio':anio
*/

$ctipo    = trim($_GET["ctipo"]);
$emite    = trim($_GET["emite"]);
$servicio = trim($_GET["servicio"]);
$anio     = trim($_GET["anio"]);
$monto    = $_GET["monto"];

$sesion     = trim($_SESSION['email']);
$fecha_caja = $_GET["fecha_caja"];
$parte_caja = $_GET["parte_caja"];


$x = $bd->query_array('rentas.view_ren_servicios',   // TABLA
    '*',                        // CAMPOS
    'idproducto_ser='.$bd->sqlvalue_inyeccion($servicio,true) // CONDICION
    );

/*
        debe haber
cxc      12       0
ingreso   0      12
cxc       0      12
caja     12       0 

emite
cxc      12      0
ingreso   0     12

recauda
cxc       0      12
caja     12       0


'1'    => 'Emision-Recaudacion',
'2'    => 'Recaudacion',
'3'    => 'Emision',
*/

if ( $ctipo == 'A'){

    $cta_cxc       = trim($x["cuenta_inv"]);
    $cta_ingreso   = trim($x["cuenta_ing"]);
    $partida       = trim($x["cuenta_ce"]);
    
    $fondoa       = trim($x["fondoa"]);
    
    if ( $fondoa == 'S'){
        $cuenta_ajeno   = trim($x["cuenta_ajeno"]);
        $debe  = 0;
        $haber = $monto;
        agrega_emision($bd,$cuenta_ajeno,'-',$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
    }else {
    
                if ( $emite == '1'){
                    $debe  = $monto;
                    $haber = 0;
                    agrega_emision($bd,$cta_cxc,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
                    $debe  = 0;
                    $haber = $monto;
                    agrega_emision($bd,$cta_cxc,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
                    $debe  = 0;
                    $haber = $monto;
                    agrega_emision($bd,$cta_ingreso,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
                }
                if ( $emite == '2'){
                    $debe  = 0;
                    $haber = $monto;
                    agrega_emision($bd,$cta_cxc,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
                }
                if ( $emite == '3'){
                    $debe  = $monto;
                    $haber = 0;
                    agrega_emision($bd,$cta_cxc,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
                    $debe  = 0;
                    $haber = $monto;
                    agrega_emision($bd,$cta_cxc,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
                }
        }
}
///--------------------------------------------------
if ( $ctipo == 'B'){
            $cta_cxc       = trim($x["cuenta_ae"]);
            $cta_ingreso   = trim($x["cuenta_aa"]);
            $partida       = trim($x["partidaa"]);
  
            $debe  = $monto;
            $haber = 0;
            agrega_emision($bd,$cta_cxc,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
            $debe  = 0;
            $haber = $monto;
            agrega_emision($bd,$cta_cxc,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
            $debe  = 0;
            $haber = $monto;
            agrega_emision($bd,$cta_ingreso,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio);
}

//--------------------------------------------------------
function agrega_emision( $bd,$cuenta1,$partida,$debe,$haber,$sesion,$fecha_caja,$parte_caja,$anio){
    
    $bd->pideSq(0);
    
    $InsertQuery = array(
        array( campo => 'fecha',   valor => $fecha_caja),
        array( campo => 'parte',   valor => $parte_caja),
        array( campo => 'cuenta',   valor => $cuenta1),
        array( campo => 'partida',   valor => $partida),
        array( campo => 'debe',   valor => $debe),
        array( campo => 'haber',   valor =>   $haber),
        array( campo => 'sesion',   valor => $sesion),
        array( campo => 'tramite',   valor => '0'),
        array( campo => 'contabilizado',   valor => '0')
    );
    $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
    
}

 /*

$item = substr($cuenta1, 0,3);

        if ( $item == '113'){
            if ( $cuenta2 == '-'){
                $debe  = '0.00';
                $haber = $monto;
                $bandera = 1;
            }else{
                $debe  = $monto;
                $haber = '0.00';
                $bandera = 2;
            }
         }
         
         if ( $item == '111'){
             $debe  = $monto;
             $haber = '0.00';
             $bandera = 1;
         }
         
         if ( $item == '212'){
             $debe  =  '0.00';
             $haber =  $monto;
             $bandera = 1;
         }
         
         if ( $item == '213'){
             $debe  =  '0.00';
             $haber =  $monto;
             $bandera = 3;
         }
         
     
   
        if ( $bandera == 1) {
                   
        }
        
        if ( $bandera == 2) {
            $InsertQuery = array(
                 array( campo => 'fecha',   valor => $fecha_caja),
                array( campo => 'parte',   valor => $parte_caja),
                array( campo => 'cuenta',   valor => $cuenta1),
                array( campo => 'partida',   valor => $partida),
                array( campo => 'debe',   valor => $debe),
                array( campo => 'haber',   valor =>   $haber),
                array( campo => 'sesion',   valor => $sesion),
                array( campo => 'tramite',   valor => '0'),
                array( campo => 'contabilizado',   valor => '0')
            );
            $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
            
            $InsertQuery = array(
                 array( campo => 'fecha',   valor => $fecha_caja),
                array( campo => 'parte',   valor => $parte_caja),
                array( campo => 'cuenta',   valor => $cuenta2),
                array( campo => 'partida',   valor => $partida),
                array( campo => 'debe',   valor => $haber),
                array( campo => 'haber',   valor =>   $debe),
                array( campo => 'sesion',   valor => $sesion),
                array( campo => 'tramite',   valor => '0'),
                array( campo => 'contabilizado',   valor => '0')
            );
            $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
            
            $InsertQuery = array(
                 array( campo => 'fecha',   valor => $fecha_caja),
                array( campo => 'parte',   valor => $parte_caja),
                array( campo => 'cuenta',   valor => $cuenta1),
                array( campo => 'partida',   valor => $partida),
                array( campo => 'debe',   valor => $haber),
                array( campo => 'haber',   valor =>   $debe),
                array( campo => 'sesion',   valor => $sesion),
                array( campo => 'tramite',   valor => '0'),
                array( campo => 'contabilizado',   valor => '0')
            );
            $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
        }
        
        //-----------------------------------
        if ( $bandera == 3) {
            $InsertQuery = array(
                 array( campo => 'fecha',   valor => $fecha_caja),
                array( campo => 'parte',   valor => $parte_caja),
                array( campo => 'cuenta',   valor => $cuenta1),
                array( campo => 'partida',   valor => $partida),
                array( campo => 'debe',   valor => $debe),
                array( campo => 'haber',   valor =>   $haber),
                array( campo => 'sesion',   valor => $sesion),
                array( campo => 'tramite',   valor => '0'),
                array( campo => 'contabilizado',   valor => '0')
            );
            $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
            
            $InsertQuery = array(
                 array( campo => 'fecha',   valor => $fecha_caja),
                array( campo => 'parte',   valor => $parte_caja),
                array( campo => 'cuenta',   valor => $cuenta2),
                array( campo => 'partida',   valor => $partida),
                array( campo => 'debe',   valor => $haber),
                array( campo => 'haber',   valor =>   $debe),
                array( campo => 'sesion',   valor => $sesion),
                array( campo => 'tramite',   valor => '0'),
                array( campo => 'contabilizado',   valor => '0')
            );
            $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
            
            $InsertQuery = array(
                 array( campo => 'fecha',   valor => $fecha_caja),
                array( campo => 'parte',   valor => $parte_caja),
                array( campo => 'cuenta',   valor => $cuenta1),
                array( campo => 'partida',   valor => $partida),
                array( campo => 'debe',   valor => $haber),
                array( campo => 'haber',   valor =>   $debe),
                array( campo => 'sesion',   valor => $sesion),
                array( campo => 'tramite',   valor => '0'),
                array( campo => 'contabilizado',   valor => '0')
            );
            $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
        }
 */
?>

  