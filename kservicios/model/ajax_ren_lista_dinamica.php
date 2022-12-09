<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	 
    
	$bd	   = new Db ;
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $txtcodigo = trim($_GET['valor']);
     
      
 
   
 
    $sql = "SELECT idcatalogo,upper(nombre) as nombre 
				  FROM par_catalogo
				  where trim(codigo) =".$bd->sqlvalue_inyeccion($txtcodigo,true).' order by nombre';
    
     
    $stmt1 = $bd->ejecutar($sql);
 
     
    echo  '<option value="0"> [  0. CATALOGOS DISPONIBLES ] </option>';
    
    while ($fila=$bd->obtener_fila($stmt1)){
        
        echo "<option value=". trim($fila['idcatalogo']).">".strtoupper(trim($fila['nombre']))."</option>";
        
    }
     
    
?>