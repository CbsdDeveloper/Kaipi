<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
    
    $ruc       =    $_SESSION['ruc_registro'];
    $sesion 	 =  $_SESSION['email'];
   
 
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
 
   
    $tipo 		= $bd->retorna_tipo();
    
    $sql = 'SELECT  indicador,   ambito, tipo
      FROM view_proceso
      where publica = '.$bd->sqlvalue_inyeccion('S' ,true)     ;
    
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Indicador,Ambito,Proceso";
    
    $evento   =  " ";
    
    $numero = $obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
    
     
    $div_indicador = 'Nro. de Indicadores '.$numero;

    echo $div_indicador;
 
 

?>
 
  