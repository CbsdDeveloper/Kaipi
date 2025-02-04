<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $ruc       =    $_SESSION['ruc_registro'];
 
   
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $codigo     =   ($_GET['codigo']) ;
      
    $tipo 		= $bd->retorna_tipo();
 
    
  
    //----------------------------numdocsustento
 
    
    $sql = "SELECT codigointerno, descripcion, cantidad   
            FROM guia_destinatario_detalle
            where  cab_codigo = ".$bd->sqlvalue_inyeccion($codigo ,true)  ;

 
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Codigo,Producto, Cantidad";
   
   
    $evento   = "";
    
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
    $det_factura= ' ';

    echo $det_factura;
 
 

?>
 
  