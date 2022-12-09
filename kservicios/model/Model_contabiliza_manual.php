<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$cuenta1 = trim($_GET["cuenta_uno"]);
$cuenta2 = trim($_GET["cuenta_dos"]);
$partida = trim($_GET["partida_uno"]);

$monto = $_GET["monto"];

$sesion = trim($_SESSION['email']);

$fecha_caja = $_GET["fecha_caja"];
$parte_caja = $_GET["parte_caja"];

 

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
         
        $bd->pideSq(0);
   
        if ( $bandera == 1) {
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
 
?>

  