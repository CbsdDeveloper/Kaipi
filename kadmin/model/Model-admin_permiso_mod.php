<?php

    session_start( );
   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/  
	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
        
    $obj   = 	new objects;
	$set   = 	new ItemsController;
	$bd	   =	new Db;
    
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
     $modulo1 = $_GET['mod'];  
 
     $idusuario = $_GET['user'];  
     
     
     $sql = "select id_par_modulo as shijo, 
                    fid_par_modulo as spadre,
                    modulo as snombre , script,logo
				from par_modulos 
                where fid_par_modulo = ".$bd->sqlvalue_inyeccion($modulo1 ,true).' order by script asc, logo asc';	
      
				 
	/*Ejecutamos la query*/
	$stmt = $bd->ejecutar($sql);
	/*Realizamos un bucle para ir obteniendo los resultados*/
    
    $modulo ='';
    
   
 	while ($x=$bd->obtener_fila($stmt)){
	
                    $modulo_codigo = ($x['shijo']);
                
                    $tipo          = trim($x['script']);
                    $logo          = trim($x['logo']);
 
 
                    if ( $tipo == 'A'){
                        $gestion = '-GESTION';
                        $class = '<span style="font-size: 12px;font-weight: 700;padding: 5px" class="label label-primary">GESTION</span>';
                    }
                    if ( $tipo == 'B'){
                        $gestion = '-PARAMETROS';
                        $class   = '<span style="font-size: 12px;font-weight: 700;padding: 5px" class="label label-success">PARAMETROS</span>';
                    }    
 

                    if ( $tipo == 'C'){
                        $gestion = '-REPORTES';
                        $class   = '<span  style="font-size: 12px;font-weight: 700;padding: 5px" class="label label-danger">REPORTES</span>';
                    }
                    

                    $nombre        = trim($x['snombre']).  $gestion  ;
                
                    $mensaje       = "filtro_addperfil(".$modulo_codigo.",".$idusuario.",".$modulo1.")";

                
                    if ( $logo == '1' ){
                           $etiqueta  =  $class .' <br>';
                   }else {
                           $etiqueta  =  '';
                     }
 
                    $boton =   ' <button type="button" class="btn btn-default btn-sm btn-block" onClick="'.$mensaje.'"> '.$nombre.'</button> ' ;
                    
                    $modulo =  $etiqueta.$boton ;

                   echo     $modulo;
 
 	  
 	}

    
 
     
    
    ?>					 
 
 
 