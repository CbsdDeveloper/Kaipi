<?php session_start( );  
   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/  
	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
        
 
 
	$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
      
      $modulo    = $_GET['mod'];  
      
      $email     = trim($_GET['email']);  
      
      $modcod    = $_GET['modcod'];  
     
        if (isset($_GET['action']))	{
        	
            $action          = $_GET['action'];  
            $modulo_codigo   = $_GET['modcod'];   
           
            
            if ( $action == 'del'){
                
                 $sql = " delete 
                            from activo.ac_sede_user
            		       where idsede_user=".$bd->sqlvalue_inyeccion($modcod, true) ;
            	
            	$bd->ejecutar($sql);
            }
            //-----------------------------------
            if ( $action == 'add'){
               
                
                
               $sql = "SELECT count(*) as nexiste
                	  FROM activo.ac_sede_user 
                      where sesion=".$bd->sqlvalue_inyeccion($email, true).' and 
                            idsede='.$bd->sqlvalue_inyeccion($modulo, true);
                  	
               $resultado = $bd->ejecutar($sql);
               $datos_dat = $bd->obtener_array($resultado);
         
               if ($datos_dat['nexiste'] == 0){
                   
                        $sql = 'INSERT INTO activo.ac_sede_user
            				(idsede, sesion) 
            				VALUES ('.$bd->sqlvalue_inyeccion($modulo, true).', '.
            				$bd->sqlvalue_inyeccion($email, true).')';
                        
                        $bd->ejecutar($sql);
                  }    
            }
        } 
 
          $sql1 = 'SELECT idsede_user, idsede, sesion, nombre, publica
                     FROM activo.view_sede_user 
    				where  sesion ='.$bd->sqlvalue_inyeccion($email,true).'  order by 1';  
     
  
       
          
        	$stmt1 = $bd->ejecutar($sql1);
         
            $asignado ='';	
           
            while ($x=$bd->obtener_fila($stmt1)){
        
        	 $modulo_codigo = ($x['idsede_user']);
             $nombre    = trim($x['nombre']);
             
             $mensaje = "javascript:filtro_perfil(".$modulo_codigo.","."'".$email."'".",".$modulo.")";
             
             $asignado = '<input type="button" class="btn btn-primary  btn-sm btn-block" onClick="'.$mensaje.'" value="'.$nombre.'">'.$asignado;
        
          	}
           
  
          	$asignado = '<div class="alert alert-info"><div class="row"  style="padding: 8px">'.$asignado.'</div></div>';
          	
          	echo $asignado;
            
 
 
  ?> 
								
 
 
 