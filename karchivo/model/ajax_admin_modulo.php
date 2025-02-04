<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

  
$bd	   =	new Db;

     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
     $modulo1 = $_GET['mod'];  
 
     $idusuario = $_GET['user'];  
     
     
     $sql = "select id_par_modulo as shijo, 
                    fid_par_modulo as spadre,
                    modulo as snombre 
				from par_modulos 
                where fid_par_modulo = ".$bd->sqlvalue_inyeccion($modulo1 ,true).' order by 1';	
      
				 
	/*Ejecutamos la query*/
	$stmt = $bd->ejecutar($sql);
	/*Realizamos un bucle para ir obteniendo los resultados*/
    
    $modulo ='';
    
 	while ($x=$bd->obtener_fila($stmt)){
	
    
     $modulo_codigo = ($x['shijo']);
     
     $nombre    = trim($x['snombre']);
     
    $mensaje = "javascript:filtro_addperfil(".$modulo_codigo.",".$idusuario.",".$modulo1.")";
      
    $modulo = '<input type="button" class="btn btn-default btn-sm btn-block" onClick="'.$mensaje.'" value="'.$nombre.'">'.$modulo;
 	  
 	}
 
 
    echo $modulo;
    
    ?>					 
 
 
 