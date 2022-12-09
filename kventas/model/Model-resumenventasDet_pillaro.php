<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $fecha     = $_GET['fecha'];
    $cajero       = $_GET['cajero'];
 
    
    $tipo 		= $bd->retorna_tipo();
 
    
    
    $sql = 'SELECT   max(fecha) as fecha ,
                    producto ,
                    count(*) as numero,
                    sum(baseiva) base12,
                    sum(monto_iva) iva ,
                    sum(tarifa_cero)  base0,
                     sum(total) total
      FROM view_factura_detalle
      where fecha = '.$bd->sqlvalue_inyeccion($fecha ,true).'  group by producto  order by producto'    ;
    
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Fecha,Modulo,Nro Facturas,Base Imponible,IVA,Tarifa Cero,Total";
    
 
    $evento   = "";
    
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
    $DivDetalleMovimiento= ' ';

    echo $DivDetalleMovimiento;
 
 

?>
 
  