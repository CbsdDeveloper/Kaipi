<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

$especie_valor = trim($_GET["especie_valor"]);
 

$monto = $_GET["monto"];

$sesion = trim($_SESSION['email']);

$fecha_caja = $_GET["fecha_caja"];
$parte_caja = $_GET["parte_caja"];

 

$xx = $bd->query_array('rentas.ren_servicios',   
    'cuenta_inv,cuenta_ing',                       
    "especie ='S' and idproducto_ser =".$bd->sqlvalue_inyeccion($especie_valor,true)  
    );
   
            $debe  = $monto ;
            $haber = '0.00';
            
                $cuenta1 =   trim($xx["cuenta_inv"]);
                $cuenta2 =   trim($xx["cuenta_ing"]);
                
                $bd->pideSq(0);
   
        
                    $InsertQuery = array(
                     array( campo => 'fecha',   valor => $fecha_caja),
                    array( campo => 'parte',   valor => $parte_caja),
                    array( campo => 'cuenta',   valor => $cuenta1),
                    array( campo => 'partida',   valor => '-'),
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
                     array( campo => 'partida',   valor => '-'),
                     array( campo => 'debe',   valor => $haber),
                     array( campo => 'haber',   valor =>   $debe),
                     array( campo => 'sesion',   valor => $sesion),
                     array( campo => 'tramite',   valor => '0'),
                     array( campo => 'contabilizado',   valor => '0')
                 );
                 $bd->JqueryInsertSQL('co_asientod_manual',$InsertQuery,'co_asientod_manual_id_manual_seq');
                 
 
?>

  