<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
 
   
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $fecha        = $_GET['fecha'];
    $cajero       = $_GET['cajero'];
 
    
    $tipo 		= $bd->retorna_tipo();
 
    
    $sql = 'SELECT  razon, 
			sum(base0) as tarifa_cero, 
			sum(base12) as base_imponible,
			sum(iva) as monto_iva, 
			sum(interes) as interes, 
			sum(descuento) as descuento, 
			sum(recargo) as recargo, 
			sum(subtotal) as subtotal,
			sum(apagar) as pagado, 
			count(*) as titulos
FROM rentas.view_ren_movimiento_pagos
where sesion_pago = '.$bd->sqlvalue_inyeccion($cajero ,true).'  and fechap = '.$bd->sqlvalue_inyeccion($fecha ,true).' 
group by razon
order by razon';

    echo $sql;
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
    
    $cabecera =  "Usuarios Contribuyentes,Tarifa Cero,Base Imponible,Monto IVA,Interes,Descuento,Recargo,Subtotal,Total";
    
    
    $obj->table->KP_sumatoria(9,8) ;
    
    $obj->table->table_basic_js($resultado,$tipo,'','','' ,$cabecera);
    
    $DivDetalleMovimiento= ' ';
    
    echo $DivDetalleMovimiento;
 

?>
 
  