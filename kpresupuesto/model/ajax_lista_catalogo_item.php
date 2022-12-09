<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $grupo   = trim($_GET['grupo']);
    $bandera = 0;
    
    if ( $grupo == 'gasto'){
        
        $sql = "select  codigo, detalle 
                 from presupuesto.pre_catalogo 
                where subcategoria = ".$bd->sqlvalue_inyeccion('gasto' ,true). " and nivel= 1 order by codigo";
         $bandera = 1;
    } 
    
    if ( $grupo == 'ingreso'){
        
        $sql = "select  codigo, detalle
                 from presupuesto.pre_catalogo
                where subcategoria = ".$bd->sqlvalue_inyeccion('ingreso' ,true). " and nivel= 1 order by codigo";
        $bandera = 1;
    }
    
    if ( $grupo == '-') {
        
        echo    '<option value="'.'-'.'" > '."No aplica".' </option>';
        
        $bandera = 0;
    }
 
    
    if ( $bandera == 1 ) {
  
        $stmt1 = $bd->ejecutar($sql);
    
        while ($fila=$bd->obtener_fila($stmt1)){
            
            $cadena = $fila['codigo'].'. '.trim($fila['detalle']);
            
            echo    '<option value="'.$fila['codigo'].'" > '.$cadena.' </option>';
            
        }
    }

    
?>
