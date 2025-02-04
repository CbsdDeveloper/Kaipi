<?php   
    session_start(); 
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
 
    $obj   = 	new objects;
    
    $bd	   =	     	new Db ;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $datos = array();
    
    $ruc       =  $_SESSION['ruc_registro'];
   
    if (isset($_GET['lista']))	{
        
        $lista = $_GET['lista'];
        
        if($lista == 'categoria')	{
            
                $resultado = $bd->ejecutar("select idcategoria as codigo, nombre 
                                             from web_categoria 
                                            where registro =".$bd->sqlvalue_inyeccion($ruc ,true).' order by nombre'
                    );
            
            	$tipo = $bd->retorna_tipo();
             
                $idcategoria = $obj->list->listadb_ajax($resultado,$tipo,'idcategoria',$datos,'required','');
                    
                echo  $idcategoria;
        }
        
        if($lista == 'marca')	{
        	
                $resultado = $bd->ejecutar("select idmarca as codigo, nombre from web_marca");
            
            	$tipo = $bd->retorna_tipo();
             
                $idmarca = $obj->list->listadb_ajax($resultado,$tipo,'idmarca',$datos,'required','');
                    
                echo  $idmarca;
        }        
 
        
	  }
 ?>