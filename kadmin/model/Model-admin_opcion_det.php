<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
    $obj   = 	new objects;
    
    $bd	   =		new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
    $id_producto= $_GET['id'];

    $sql = 'select id_par_modulo as "Id",modulo as "Opcion",vinculo as "Enlace",estado as "Vigente",publica as "Tipo",accion as "Ambito"
																from par_modulos
																where fid_par_modulo ='.$id_producto.' order by id_par_modulo asc ';
    
    
 


    ///--- desplaza la informacion de la gestion	
    $resultado  = $bd->ejecutar($sql);
    
    $tipo 		= $bd->retorna_tipo();
    
//    $enlace    = '../model/ajax_precio_del';

    $enlace    = '../model/#';
    
    $variables = 'ref=Codigo&codigo='.$id_producto;
    
    $obj->grid->KP_GRID_POP($resultado,$tipo,'Referencia', $enlace,$variables,'S','','','del',250,120,''); 

    $precio_grilla ='';
 
    echo $precio_grilla;
     
 ?>