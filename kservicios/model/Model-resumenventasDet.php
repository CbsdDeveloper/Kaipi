<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $fecha        = $_GET['fecha'];
    $cajero       = trim($_GET['cajero']);
    $tipo 		  = $bd->retorna_tipo();
    $evento       = "";
    
    
    $sql = "SELECT  nombre_rubro, 
                    count(*) || ' ' as titulos,
                    COALESCE(sum(base0),0) as tarifa_cero, 
                    COALESCE(sum(base12),0) as base_imponible,
                    COALESCE(sum(iva),0) as monto_iva, 
                    COALESCE(sum(interes),0) as interes, 
                    COALESCE(sum(descuento),0) as descuento, 
                    COALESCE(sum(recargo),0) as recargo, 
                    COALESCE(sum(subtotal),0) as subtotal,
                    COALESCE(sum(apagar),0) as pagado
            FROM rentas.view_ren_movimiento_pagos
            where sesion_pago = ".$bd->sqlvalue_inyeccion($cajero ,true).'  and 
                fechap = '.$bd->sqlvalue_inyeccion($fecha ,true).' and 
                cierre = '.$bd->sqlvalue_inyeccion('N' ,true).'
            group by nombre_rubro
            order by nombre_rubro';

 
 
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Detalle,Nro.Titulos,Tarifa Cero,Base Imponible,Monto IVA,Interes,Descuento,Recargo,Subtotal,Total";
   
    
    $obj->table->KP_sumatoria(10,9) ;
     
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
    $DivDetalleMovimiento= ' ';

    echo $DivDetalleMovimiento;
 
 

?>
 
  