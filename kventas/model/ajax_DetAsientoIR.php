 <?php  
 
    session_start();  
 
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj   = 	new objects;
	
    $set   = 	new ItemsController;
	
	$bd	   =	 	new Db ;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
    $registro  = $_SESSION['ruc_registro'];

    $idasiento     = $_GET['id_asiento'] ;
    
    $fuente = "Fuente de Impuesto a la Renta";
    
    
    $sql = 'SELECT id_compras as "Referencia" ,
                  codigo, 
                  detalle , 
                   baseImponible,
     			   porcentaje, 
                    retencion
    	 	 from view_fuente_asiento
    		where  id_asiento='.$bd->sqlvalue_inyeccion($idasiento ,true);
    
 
      
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
 
    $tipo 		= $bd->retorna_tipo();
    
    $enlace    = '../controller/ajax_delir';
    
    $variables = 'ref=codigo&codigo='.$idasiento;
    
    $obj->grid->KP_GRID_POP($resultado,$tipo,'Referencia', $enlace,$variables,'S','','','del',250,120,''); 
    
  
     
    $retencion_fuente = 'ok';
      
    echo $retencion_fuente;
?>

  