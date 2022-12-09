<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$obj     = 	new objects;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$tipo           = trim($_POST["tipo"]);
$idproducto_ser = trim($_POST["idproducto_ser"]);
$secuencia_a    = trim($_POST["secuencia_a"]);
$hasta_a        = trim($_POST["hasta_a"]);
$comprobante_a  = trim($_POST["comprobante_a"]);
$fecha_a        = trim($_POST["fecha_a"]);
$id_ren_movimiento_a = trim($_POST["id_ren_movimiento_a"]);

 



        if ( $tipo  == '2' )  { 
            
            $sql = "UPDATE  rentas.ren_serie_espe
                     set actual = ".$bd->sqlvalue_inyeccion($secuencia_a ,true) ."
                     where estado= 'S' and idproducto_ser = ".$bd->sqlvalue_inyeccion( $idproducto_ser ,true)  ;
            
            $bd->ejecutar($sql);
            
            $result = 'DATOS ACTUALIZADOS CON EXITO ... ';
            
        }

        if ( $tipo  == '1' )  {
            
            $sql = " UPDATE rentas.ren_movimiento
                      SET 	estado=".$bd->sqlvalue_inyeccion('P', true).",
                            comprobante = ".$bd->sqlvalue_inyeccion(  $comprobante_a   ,true).",
                            secuencial = ".$bd->sqlvalue_inyeccion(  $hasta_a   ,true).",
                            fecha = ".$bd->sqlvalue_inyeccion(  $fecha_a   ,true).",
                            fechap=".$bd->sqlvalue_inyeccion( $fecha_a, true)."
                      WHERE id_ren_movimiento=".$bd->sqlvalue_inyeccion($id_ren_movimiento_a, true);
            
             
            $bd->ejecutar($sql);
            
            $result = 'DATOS ACTUALIZADOS CON EXITO ...  ';
            
        }
        
 echo $result;
              

?>