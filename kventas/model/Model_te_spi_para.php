<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
 
	
 
 
	if (isset($_GET['accion']))	{
	    
	    $accion = $_GET['accion'] ;
	    
	    $id_spi_para    = $_GET['id_spi_para'];
	    
	    $fecha_pago    = $_GET['fecha_pago'];
	    $mes_pago      = $_GET['mes_pago'];
	    $referencia_pago    = $_GET['referencia_pago'];
	    $localidada    = $_GET['localidad'];
	    
	    $responsable1  = $_GET['responsable1'];
	    $cargo1   = $_GET['cargo1'];
	    $responsable2   = $_GET['responsable2'];
	    $cargo2    = $_GET['cargo2'];
	    $cuenta_bce   = $_GET['cuenta_bce'];
	    $empresa   = $_GET['empresa'];
	    
	    
	    $ATabla = array(
	        array( campo => 'id_spi_para',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
	        array( campo => 'fecha_pago',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => $fecha_pago, key => 'N'),
	        array( campo => 'mes_pago',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor =>$mes_pago, key => 'N'),
	        array( campo => 'referencia_pago',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $referencia_pago, key => 'N'),
	        array( campo => 'localidad',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $localidada, key => 'N'),
	        array( campo => 'responsable1',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $responsable1, key => 'N'),
	        array( campo => 'cargo1',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $cargo1, key => 'N'),
	        array( campo => 'responsable2',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $responsable2, key => 'N'),
	        array( campo => 'cargo2',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>$cargo2, key => 'N'),
	        array( campo => 'cuenta_bce',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $cuenta_bce, key => 'N'),
	        array( campo => 'empresa',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $empresa, key => 'N'),
	    );
	    
	    if ( $accion == 'actualizar'){
 	    
        	    if ( $id_spi_para > 0 ){
        	        
        	        $bd->_UpdateSQL('tesoreria.te_spi_para',$ATabla,$id_spi_para);
        	        
        	    }else {
        	        
        	        $bd->_InsertSQL('tesoreria.te_spi_para',$ATabla, 'tesoreria.te_spi_para_id_spi_para_seq');
        	    }
        	   
        	    
        	     echo 'Datos actualizados con exito';
	    
	    }else {
	        
	        $qquery = array( array( campo => 'id_spi_para',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'fecha_pago',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'mes_pago',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'referencia_pago',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'localidad',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'responsable1',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'cargo1',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'responsable2',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'cargo2',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'cuenta_bce',valor => '-',filtro => 'N', visor => 'S'),
	            array( campo => 'empresa',valor => '-',filtro => 'N', visor => 'S') ,
	            array( campo => '1',valor => '1',filtro => 'S', visor => 'S') 
	        );
	        
	        
	        $datos =   $bd->JqueryArrayVisorDato('tesoreria.te_spi_para',$qquery );
	        
	        header('Content-Type: application/json');
	        
	        echo json_encode($datos, JSON_FORCE_OBJECT);
	    }
	}
	 
 
    
?>
 
  