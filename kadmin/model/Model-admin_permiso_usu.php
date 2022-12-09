<?php session_start( );  
   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/  
        
 
	$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    if ((isset($_GET['mod'])) && (isset($_GET['user']))){
      
      $modulo = $_GET['mod'];  

      $idusuario = $_GET['user'];  
     
        if (isset($_GET['action']))	{
        	
            $action          = $_GET['action'];  

            $modulo_codigo   = $_GET['modcod'];   
              
            if ( $action == 'del'){

                 $sql = " delete 
                            from par_rol
            		       where idusuario=".$bd->sqlvalue_inyeccion($idusuario, true).' and 
                                 id_par_modulo='.$bd->sqlvalue_inyeccion($modulo_codigo, true);
            	
            	$bd->ejecutar($sql);

            }


            //-----------------------------------//

            if ( $action == 'add'){
               
               $sql = "SELECT count(*) as nexiste
                	  FROM par_rol 
                      where idusuario=".$bd->sqlvalue_inyeccion($idusuario, true).' and 
                            id_par_modulo='.$bd->sqlvalue_inyeccion($modulo_codigo, true);
                  	
               $resultado = $bd->ejecutar($sql);
               $datos_dat = $bd->obtener_array($resultado);
         
               if ($datos_dat['nexiste'] == 0){
                   
                        $sql = 'INSERT INTO par_rol
            				(idusuario, id_par_modulo) 
            				VALUES ('.$bd->sqlvalue_inyeccion($idusuario, true).', '.
                                      $bd->sqlvalue_inyeccion($modulo_codigo, true).')';
                        
                        $bd->ejecutar($sql);
                  }    

            }
        } 
 
          $sql1 = 'select a.id_par_modulo as shijo, 
                         a.fid_par_modulo as spadre,
                         a.modulo as snombre , a.script
    		        from par_modulos a, 
                         par_rol b
    				where a.id_par_modulo = b.id_par_modulo and 
                          b.idusuario ='.$bd->sqlvalue_inyeccion($idusuario,true).' and 
                          a.fid_par_modulo = '.$bd->sqlvalue_inyeccion($modulo ,true).' 
                          order by   a.script  desc';  
     
    	   /*Ejecutamos la query*/

        	$stmt1 = $bd->ejecutar($sql1);

        	/*Realizamos un bucle para ir obteniendo los resultados*/

            $asignado ='';	
           
            while ($x=$bd->obtener_fila($stmt1)){
        
                    $modulo_codigo = ($x['shijo']);


                    $tipo          = trim($x['script']);

                    $class = 'btn btn-default';

                    if ( $tipo == 'A'){
                        $gestion = '-GESTION';
                        $class = 'btn btn-primary';
                    }
                    if ( $tipo == 'B'){
                        $gestion = '-PARAMETROS';
                        $class = 'btn btn-success';
                    }
                    if ( $tipo == 'C'){
                        $gestion = '-REPORTES';
                        $class = 'btn btn-danger';
                    }

                    $nombre        = trim($x['snombre']).  $gestion  ;
                 
                    
                    $mensaje       = "filtro_perfil(".$modulo_codigo.",".$idusuario.",".$modulo.")";
                    
                    $asignado      = '<input type="button" class="'.$class.'  btn-sm btn-block" onClick="'.$mensaje.'" value="'.$nombre.'">'.$asignado;
        
          	}
           
  
          	$asignado = '<div class="alert alert-info"><div class="row"  style="padding: 8px">'.$asignado.'</div></div>';
          	
          	echo $asignado;
            
   	}   
 
  ?> 
								
 
 
 