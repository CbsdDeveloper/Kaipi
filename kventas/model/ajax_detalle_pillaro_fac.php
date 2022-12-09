<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
    $obj     = 	new objects;
    $bd	   =	new Db ;
 
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
 
    $tipo 		= $bd->retorna_tipo();
    
    
    $id 		= trim($_GET["id"]);
    
 
    
    $sql = "SELECT id,producto,monto_iva,baseiva,tarifa_cero,total 
            FROM view_movimiento_det
            where id_movimiento  =".$bd->sqlvalue_inyeccion( $id, true).' order by 2';

    $resultado  = $bd->ejecutar($sql);
     
    $cabecera =  "Movimiento,Rubro,Iva,Base Imponible,Tarifa Cero,Total";
 
    $evento   = "";
    
    $obj->table->table_basic_seleccion($resultado,$tipo,'','',$evento ,$cabecera);

   
    $yy = $bd->query_array('inv_movimiento',
    'detalle,documento,sesion',
    'id_movimiento='.$bd->sqlvalue_inyeccion($id,true)
    );


    $detalle = trim($yy['detalle']) .' Referencia: <b>'.trim($yy['documento']).'</b> sesion: '. trim($yy['sesion']);


    $x = $bd->query_array('view_movimiento_det',
    'sum(total) as total',
    'id_movimiento='.$bd->sqlvalue_inyeccion($id,true)
    );


    $total = trim($x['total']);


    
    $DetalleRequisitos=   $detalle.'<br>total : '.  number_format(  $total,2) ;

    echo $DetalleRequisitos;
 
 

?>

  