 <?php  
    session_start();  
 
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj   = 	new objects;
	
	$bd	   =	 	new Db ;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
     $id_compras     = $_GET['id_compras'] ;
    
     
    
    $sql = 'SELECT id_compras as "Referencia" ,
                  codigo, '."
                  secuencial || ' ' as factura,".'
                  detalle , 
                   baseImponible,
     			   porcentaje, 
                   retencion
    	 	 from view_fuente_asiento
    		where  id_compras='.$bd->sqlvalue_inyeccion($id_compras ,true).' 
            order by codigo';
    
 
      
 
    
    ///--- desplaza la informacion de la gestion
    $resultado  = $bd->ejecutar($sql);
 
    $tipo 		= $bd->retorna_tipo();
    
    $enlace    = '../controller/ajax_delir';
    
    $variables = 'ref=codigo&codigo='.$id_compras.'&secuencia=factura';

    
    $obj->grid->KP_GRID_POP($resultado,$tipo,'Referencia', $enlace,$variables,'S','','editar','del',150,90,''); 
   
  
    $x = $bd->query_array('view_fuente_asiento',
    'sum(baseImponible) as base, sum(retencion) as retencion ', 
     'id_compras='.$bd->sqlvalue_inyeccion(trim($id_compras),true) 
);

     
    

    $retencion_fuente = '<h4>Base Imponible: <b>'.$x['base'].'</b><br>Monto Retencion: <b>'.$x['retencion'].'</b></h4>';
      
    echo $retencion_fuente;
?>

  