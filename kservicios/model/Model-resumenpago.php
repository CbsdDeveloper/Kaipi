<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
 
   
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $fecha        = $_GET['fecha'];
    $cajero       = trim($_GET['cajero']);
    $evento       = "";
    
    $tipo 		= $bd->retorna_tipo();
 
    
    $sql = 'SELECT fecha_pago,
                   formapago, 
                   tipopago, 
                   banco,
                   cuenta, 
                   parte,   
                   sum(total) as pagado
                FROM rentas.view_ren_diario_pagos
                where fecha_pago = '.$bd->sqlvalue_inyeccion($fecha ,true).' and 
                      sesion = '.$bd->sqlvalue_inyeccion(trim($cajero) ,true).' and 
                      cierre = '.$bd->sqlvalue_inyeccion('N' ,true)." and
                      estado = 'P'
                group by fecha_pago,formapago, tipopago, cuenta, parte,   banco";

 
        
 
 
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Fecha,Forma Pago,Tipo Pago, Institucion Bancaria,Nro.Cuenta,Nro.Parte,Pagado";
     
    
    $obj->table->KP_sumatoria(7,6) ;
    
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);

     
    $DivDetalleMovimiento= ' <h6> RESUMEN NOVEDADES/ ANULACION/BAJAS </h6> ';

    echo $DivDetalleMovimiento;
 

    $sql = 'SELECT fecha_pago,
    formapago, 
    tipopago, 
    banco,
    cuenta, 
    parte,   
    sum(total) as pagado
 FROM rentas.view_ren_diario_pagos
 where fecha_pago = '.$bd->sqlvalue_inyeccion($fecha ,true).' and 
       sesion = '.$bd->sqlvalue_inyeccion(trim($cajero) ,true).' and 
       cierre = '.$bd->sqlvalue_inyeccion('N' ,true)." and
       estado <> 'P'
 group by fecha_pago,formapago, tipopago, cuenta, parte,   banco";





$resultado  = $bd->ejecutar($sql);

$cabecera =  "Fecha,Forma Pago,Tipo Pago, Institucion Bancaria,Nro.Cuenta,Nro.Parte,Pagado";


$obj->table->KP_sumatoria(7,6) ;

$obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
 

?>
 
  