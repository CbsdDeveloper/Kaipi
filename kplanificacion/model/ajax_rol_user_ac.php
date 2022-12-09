<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;
    

    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    $action		= $_POST['action'];
    $idusuario 	= $_POST['idusuario'];
    $tipo	 		= $_POST['tipo'];
    
    ///-----------------------------------------
    
    $sql = "SELECT count(*) as nexiste
                	  FROM par_rol_actividad
                      where idusuario		=".$bd->sqlvalue_inyeccion($idusuario, true).' and
                                  actividad		='.$bd->sqlvalue_inyeccion($tipo, true);
    
    $resultado 			= $bd->ejecutar($sql);
    $validaRegistro = $bd->obtener_array($resultado);
    
   //------------------------------------------------- 
	    if ( $action == 'add'){
	    	if ( $validaRegistro['nexiste'] == 0 ) {
	    		
	    		$sql = 'INSERT INTO par_rol_actividad  ( idusuario,  actividad)
			            				VALUES ('.$bd->sqlvalue_inyeccion($idusuario, true).', '.
			            				$bd->sqlvalue_inyeccion($tipo, true).')';
			            				
			            				$bd->ejecutar($sql);
	    	}
	    }
      
      ///-----------------------------------------
      
	    if ( $action == 'del'){
	    	$sql = " delete
                            from par_rol_actividad
            		       where idusuario		=".$bd->sqlvalue_inyeccion($idusuario, true).' and
                                       actividad		='.$bd->sqlvalue_inyeccion($tipo, true);
	    	
	    	$bd->ejecutar($sql);
	    }
    
	    ///-----------------------------------------
	    
	    
 
	    $sql1 = 'select actividad  from par_rol_actividad where idusuario = '.$bd->sqlvalue_inyeccion($idusuario,true);
     
    	   /*Ejecutamos la query*/
        	$stmt1 = $bd->ejecutar($sql1);
        	/*Realizamos un bucle para ir obteniendo los resultados*/
        	
        	$tableroasignado ='';	
           
            while ($x=$bd->obtener_fila($stmt1)){
         
             $nombre    = trim($x['actividad']);
          
              
             $mensaje = "javascript:asignaa(". "'". $nombre. "'" .",'del')";
             
             $tableroasignado  = $tableroasignado.' <a href="#" onClick="'.$mensaje.' " class="list-group-item">'.$nombre.'</a>';
        
          	}
           
          	$tableroasignado= '<div class="alert alert-info"><div class="row"  style="padding: 8px">'.$tableroasignado.'</div></div>';
          	
          	echo $tableroasignado;
            
 
 
  ?> 
								
 
 
 