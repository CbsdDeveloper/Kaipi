<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $ruc       =    $_SESSION['ruc_registro'];
 
   
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $factura     =  trim($_GET['factura']) ;
      
    $tipo 		= $bd->retorna_tipo();
 
    $input = str_pad($factura, 9, "0", STR_PAD_LEFT);
    
 
    $ADatos = $bd->query_array(
        'web_registro',
        'razon, contacto, correo,direccion,felectronica,estab',
        'ruc_registro='.$bd->sqlvalue_inyeccion( $ruc,true)
        );
    
     $estab       = trim($ADatos['estab'] ) ;
    
    $AFactura = $bd->query_array(
                            'view_inv_movimiento',
                            'fecha,autorizacion,razon,idprov,direccion',
                            'comprobante='.$bd->sqlvalue_inyeccion( $input,true)." and 
                             estado = 'aprobado' and 
                             registro=".$bd->sqlvalue_inyeccion( $ruc,true)
        );
 
    
    

    echo '<script> 
                $("#factura").val('."'".$input."'".');
                $("#codestabdestino").val('."'".$estab."'".');
                $("#estab").val('."'".$estab."'".');
                $("#dirdestinatario").val('."'".$AFactura['direccion']."'".');
                $("#identificaciondestinatario").val('."'".$AFactura['idprov']."'".');
                $("#razonsocialdestinatario").val('."'".$AFactura['razon']."'".');
                $("#ptoemi").val('."'".'001'."'".');
          </script> ';
  
    //----------------------------numdocsustento
 
    
    $sql = "SELECT id,  trim(producto) as producto, unidad, cantidad   
            FROM view_factura_detalle
            where estado = 'aprobado' and 
                  registro = ".$bd->sqlvalue_inyeccion($ruc ,true)." and 
                  comprobante = ".$bd->sqlvalue_inyeccion($input ,true) ;

 
    
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Codigo,Producto,Unidad,Cantidad";
   
   
    $evento   = "";
    
    $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
     
    $det_factura= ' ';

    echo $det_factura;
 
 

?>
 
  