<?php 
    
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
  
    
    function ver_perfil ($sesion , $codigo ){
        //inicializamos la clase para conectarnos a la bd
        
         
        
        $bd	   =	new Db;
        
        $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
        $datos = $bd->query_array('view_perfil_usuario',
                                  'count(*) as nn', 
                                   'idusuario='.$bd->sqlvalue_inyeccion($sesion,true).' and 
                                   id_par_modulo='.$bd->sqlvalue_inyeccion($codigo,true)
            );
        
        
        if ( $datos['nn'] > 0  ){
            return 1;
        }else{
            return 0;
        }
      
        
        
        
     
    }


 ?>