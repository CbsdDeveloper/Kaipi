<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
    $obj   = 	new objects;
    
    $bd	   =	    new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
     
    $fecha         = $_GET['fecha'];
    
    $sql = 'SELECT  id_productogasto as "Referencia", 
                    fecha as "Fecha", 
                    tipo as "Tipo", 
                    detalle as "Detalle", 
                    monto as "Gasto"
      FROM inv_producto_gasto 
      where fecha = '.$bd->sqlvalue_inyeccion($fecha,true). ' and 
            sesion = '.$bd->sqlvalue_inyeccion($_SESSION['email'] ,true);


 
    ///--- desplaza la informacion de la gestion	
    $resultado  = $bd->ejecutar($sql);
    
    $tipo 		= $bd->retorna_tipo();
    
    $enlace    = '../model/Model-ajax_gasto_del';
    
    $variables = 'ref='.$fecha;
    
    $obj->grid->KP_GRID_POP($resultado,$tipo,'Referencia', $enlace,$variables,'S','','','del',250,120,''); 

    $precio_grilla ='';
 
    echo $precio_grilla;
     
 ?>