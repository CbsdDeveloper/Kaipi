<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
    $obj   = 	new objects;
    
    $bd	   =	    new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    $id_producto= $_GET['id'];

    $sql = 'SELECT  id_productov as "Referencia", 
                    detalle as "Detalle", 
                    monto as "Precio", 
                    activo as "Activo", 
                    principal as "Principal"
      FROM inv_producto_vta 
      where id_producto = '.$bd->sqlvalue_inyeccion($id_producto ,true);


    ///--- desplaza la informacion de la gestion	
    $resultado  = $bd->ejecutar($sql);
    
    $tipo 		= $bd->retorna_tipo();
    
    $enlace    = '../model/Model-ajax_precio_del';
    
    $variables = 'ref=Codigo&codigo='.$id_producto;
    
    $obj->grid->KP_GRID_POP($resultado,$tipo,'Referencia', $enlace,$variables,'S','','','del',250,120,''); 

    $precio_grilla ='';
 
    echo $precio_grilla;
     
 ?>