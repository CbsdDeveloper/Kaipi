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
 
    
    $sql = 'SELECT  fecha ,
                    formapago,
                    tipopago,
                    institucion,
                    cuenta,
                    pago  
      FROM view_factura_cajapago
      where fecha = '.$bd->sqlvalue_inyeccion($fecha ,true).' and
            sesion = '.$bd->sqlvalue_inyeccion(trim($cajero) ,true)      ;
 
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Fecha,Forma Pago,Tipo Pago, Institucion Bancaria,Nro.Cuenta,Pagado";
   
 
    $evento   = "";
    
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
    $DivDetalleMovimiento= ' ';

    echo $DivDetalleMovimiento;
 
 

?>
 
  