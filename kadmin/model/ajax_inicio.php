<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 

$bd	     =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$sesion 	=  trim($_SESSION['email']);

$x 			=  $bd->query_array('par_usuario',  '*',  'email='.$bd->sqlvalue_inyeccion( $sesion ,true));

$ACarpeta   =  $bd->query_array('wk_config',  'carpetasub',  'tipo='.$bd->sqlvalue_inyeccion(2,true). ' AND  registro = '.$bd->sqlvalue_inyeccion($_SESSION['ruc_registro'] ,true)  );

$carpeta    =  trim($ACarpeta['carpetasub']);

$imagen 	=  $carpeta.trim($_SESSION['foto']);
$imagen 	=  $carpeta.trim($x['url']);

$rol        =  trim($x['rol']);


if  ( $x['empresas'] == '0000000000000'){
    
    if ($_SESSION['sesion_actual'] == 0){
        
        $id = $x['empresas'];
        
        $sql = "SELECT a.ruc_registro, a.url,a.razon, b.nombre, a.fondo
						  FROM web_registro a , par_catalogo b
						 WHERE b.idcatalogo =  a.idciudad and
							   a.tipo =".$bd->sqlvalue_inyeccion('principal' ,true);
        
        $resultado				  = $bd->ejecutar($sql);
        $datos1 				  = $bd->obtener_array( $resultado);
        $_SESSION['ciudad']       = trim($datos1['nombre']);
        $_SESSION['razon']        = trim($datos1['razon']);
        $_SESSION['ruc_registro'] = $datos1['ruc_registro'];
        $_SESSION['fondo']        = trim($datos1['fondo']);
        $_SESSION['logo']		  = trim($datos1['url']);
        
        $resultado 				   = $bd->ejecutar("select * from web_registro where  estado = 'S' order by tipo desc ");
        
        $_SESSION['sesion_actual'] = 1;
        
    } else {
        
        $resultado = $bd->ejecutar("select * from web_registro  where  estado = 'S' order by tipo desc");
        
        $_SESSION['sesion_actual'] = 1;
        
    }
    
}else{
    
    $id = $x['empresas'];
    
    $sql = "SELECT a.ruc_registro, a.url,a.razon, b.nombre ,a.url ,a.fondo
                                         FROM web_registro a , par_catalogo b
                                        WHERE b.idcatalogo =  a.idciudad and a.ruc_registro =".$bd->sqlvalue_inyeccion($id ,true);
    
    $resultado = $bd->ejecutar($sql);
    $datos1    = $bd->obtener_array( $resultado);
    
    $_SESSION['ciudad']       = trim($datos1['nombre']);
    $_SESSION['razon']        = trim($datos1['razon']);
    $_SESSION['fondo']        = trim($datos1['fondo']);
    $_SESSION['ruc_registro'] = trim($datos1['ruc_registro']);
    $_SESSION['logo']		  = trim($datos1['url']);
    
   
}



?>