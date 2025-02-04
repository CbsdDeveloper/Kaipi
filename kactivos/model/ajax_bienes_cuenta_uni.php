<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);




     $tipo     = $_GET['tipo'] ;
    
 

    if ( $tipo == '1'){
        
        echo '<option value="-"> [ 0. Todas las Cuentas ]</option>';
        
        $sql1 = "select  cuenta as codigo,trim(cuenta) || ' ' || trim(detalle) as nombre
                    FROM co_plan_ctas
                    WHERE tipo_cuenta = 'A' and univel = 'S'
                    group by cuenta,detalle
                    order by cuenta";
        
    }


$stmt1 = $bd->ejecutar($sql1);



while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}


?>