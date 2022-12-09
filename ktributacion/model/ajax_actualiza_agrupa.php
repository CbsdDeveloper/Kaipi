 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $id	=	$_GET["id"];
    
  
    $datos = $bd->query_array('co_compras',
    '*', 
      'id_compras='.$bd->sqlvalue_inyeccion($id,true)  
    );

    
    $sqlE = "UPDATE co_compras
    SET 	autretencion1=".$bd->sqlvalue_inyeccion( $datos['autretencion1'], true).",
            secretencion1=".$bd->sqlvalue_inyeccion($datos['secretencion1'], true)."
    WHERE referencia=".$bd->sqlvalue_inyeccion($id, true);

    $bd->ejecutar($sqlE);

    $retencion_fuente = 'actualizado...';

    echo $retencion_fuente;
    
    
?>
 
  