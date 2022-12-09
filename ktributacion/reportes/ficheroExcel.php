<?php session_start( );   

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	 
    $obj   = 	new objects;
    $bd     = 	new Db;
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $sql = $_SESSION['isql'] ;
    
    $resultado  = $bd->ejecutar($sql);
    $tipo 		= $bd->retorna_tipo();
    
    $tbHtml = $obj->grid->KP_GRID_EXCEL($resultado,$tipo); 
    
	header ('Content-type: text/html; charset=utf-8');
  // esto le indica al navegador que muestre el diálogo de descarga aún sin haber descargado todo el contenido
    header("Content-type: application/octet-stream");
 	//indicamos al navegador que se está devolviendo un archivo
	header("Content-Disposition: attachment; filename=ficheroExcel.xls");
	//con esto evitamos que el navegador lo grabe en su caché
	header("Pragma: no-cache");
	header("Expires: 0");
 	//damos salida a la tabla
	echo $tbHtml; 															 
?>