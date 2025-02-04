<?php
 			session_start( );  
		    require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    		require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
          
            $bd	  =	new Db;
            $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

		    $sesion 	 =     trim($_SESSION['login']);
			$hoy 	     =     date("Y-m-d"); 
			$ruc         =     trim($_SESSION['ruc_registro']);

    		$tipo =  $_GET['id'];
	
			if ( $tipo == 1){
				
 				   $Avalida = $bd->query_array('web_chat_directo',
                    'count(*) ya, max(sesion) as sesion',
                    'trim(sesion)<>'.$bd->sqlvalue_inyeccion( $sesion ,true). ' and 
					 modulo='.$bd->sqlvalue_inyeccion('panel',true). " and 
                     registro=".$bd->sqlvalue_inyeccion($ruc,true). " and 
					 to_char(fecha, 'YYYY-MM-DD') =". $bd->sqlvalue_inyeccion($hoy,true)
                    );
 				   
 				   $imagen = '';
		  
 				   if ($Avalida['ya'] > 0){
 				       $imagen = ' <img src="../kimages/_recor.png"/>';
 				   }
 				   $response =   $Avalida['sesion'].' ( '.$Avalida['ya'].' ) ' .$imagen;
 				
					echo $response ;	
			}

			if ( $tipo == 2){
			 
			    $sql = "SELECT max(sesion) as sesion ,count(*) as ya
                         FROM  view_agenda
                         where registro  = ".$bd->sqlvalue_inyeccion($ruc,true)." and quedan between 0 and 5 ";

      
			    $resultado  = $bd->ejecutar($sql);
			    $Avalida   = $bd->obtener_array($resultado);
			    
			    $imagen = '';
			    
			    if ($Avalida['ya'] > 0){
			        $imagen = ' <img src="../kimages/_recor.png"/>';
			    }
			    $response =   $Avalida['sesion'].' ( '.$Avalida['ya'].' ) ' .$imagen;
			    
	 
				
			   echo $response ;	
			}

		   if ( $tipo == 3){
			 
		       $Avalida = $bd->query_array('web_chat_directo',
		           'count(*) ya, max(sesion) as sesion',
		           'modulo='.$bd->sqlvalue_inyeccion('cartelera',true). " and
                     registro=".$bd->sqlvalue_inyeccion($ruc,true)
		           );
		       
		       $imagen = '';
		       
		       if ($Avalida['ya'] > 0){
		           $imagen = ' <img src="../kimages/_recor.png"/>';
		       }
		       $response =   $Avalida['sesion'].' ( '.$Avalida['ya'].' ) '.$imagen;
		       
		  
				
			   echo $response ;	
			}

 
?> 