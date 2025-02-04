<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
    
 
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $id_producto =  $_GET['id'] ;
    
    $codigo      =  $_GET['codigo'] ;
    
    $UpdateQuery = array(
        array( campo => 'idproducto',   valor => $id_producto ,  filtro => 'S'),
        array( campo => 'codigo',      valor => $codigo,  filtro => 'N')
    );
    
    
    $bd->JqueryUpdateSQL('web_producto',$UpdateQuery);
    
    $ViewFiltroCodigo = 'Autorizado '.$id_producto.' Codigo Referencia:'.$codigo;
    
    echo $ViewFiltroCodigo;
    
?>