<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
	$anio = date("Y");
     
    $id = $_GET['id'];
    
 
    
 
    $sql1 = "SELECT idproducto as codigo, producto as nombre
                                 from view_mov_aprobado
                                 WHERE  anio = ".$anio."   and 
                                        idcategoria = ". $bd->sqlvalue_inyeccion($id,true) ." 
                                 GROUP BY idproducto,  producto order by producto" ;
                             
 
    $stmt1 = $bd->ejecutar($sql1);
    
    while ($fila=$bd->obtener_fila($stmt1)){
        
       echo '<option value='.$fila['codigo']. ' >'.$fila['nombre'].'</option>';
        
    }
    
     
    
?>