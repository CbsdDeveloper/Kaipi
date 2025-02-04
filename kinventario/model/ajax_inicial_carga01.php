<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$anio       = $_GET["anio"];
$id         = $_GET["idbodega"];

 
$tipo    =    $bd->retorna_tipo();

 
    
    $sql1 = 'SELECT  cuenta_inv,sum(cantidad),sum(costo), sum(total),sum(costo_total)
            FROM view_inv_movimiento_det
            where  anio = '.$bd->sqlvalue_inyeccion($anio ,true).' and 
                   idbodega = '.$bd->sqlvalue_inyeccion($id ,true)."  and
                   trim(transaccion) = 'carga inicial'
            group by cuenta_inv 
            order by cuenta_inv";
    
 
    
    $stmt2 = $bd->ejecutar($sql1);
     
    $obj->table->table_basic_js($stmt2, // resultado de la consulta
        $tipo,      // tipo de conexoin
        '',         // icono de edicion = 'editar'
        '',			// icono de eliminar = 'del'
        '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
        "Cuenta, Cantidad, Costo, saldos" , // nombre de cabecera de grill basica,
        '12px',      // tama�o de letra
        'id'         // id
        );
 

  
    

?>
 
  