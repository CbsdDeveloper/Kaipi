<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
    class proceso{
 
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
           
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($PK_codigo,$idcategoria1,$idbodega1 ,$facturacion1,$productob,$codigob){
      
      	// Soporte Tecnico
        $_SESSION['idbodega'] = $idbodega1;
          
      	$filtro1 = 'N';
      	$filtro2 = 'N';
      	$filtro3 = 'N';
      	$filtro4 = 'N';
      	$filtro5 = 'N';
      	$cadena = '';
      
      	if ($idcategoria1 <> 0){
      		$filtro1 = 'S';
      	}
      	if ($idbodega1 <> 0){
      		$filtro2 = 'S';
      	}
      	if ($facturacion1 <> '-'){
      		$filtro3 = 'S';
      	}
      
      	$lon = strlen(trim(	$productob)) ;
      	
      	if ( $lon > 4 ){
      	    $filtro4 = 'S' ;
      	    $cadena  = "LIKE.%".trim(strtoupper($productob))."%";
      	    $filtro2 = 'S';
      	    $filtro1 = 'N';
      	    $filtro3 = 'N';
      	}
      	
      	if ( $codigob >  0){
      	    $filtro4 = 'N' ;
       	    $filtro2 = 'S';
      	    $filtro1 = 'N';
      	    $filtro3 = 'N';
      	    $filtro5 = 'S';
      	}
      	
      	
      
      	$qquery = array(
      	        array( campo => 'idproducto',   valor =>$codigob,  filtro => $filtro5,   visor => 'S'),
      	        array( campo => 'producto',   valor => $cadena,  filtro => $filtro4,   visor => 'S'),
      			array( campo => 'referencia',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'idmarca',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'saldo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'cuenta_inv',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'tipo',   valor => $PK_codigo ,  filtro => 'S',   visor => 'N'),
      			array( campo => 'idcategoria',   valor => $idcategoria1,  filtro => $filtro1,   visor => 'N'),
      			array( campo => 'idbodega',   valor => $idbodega1 ,  filtro => $filtro2,   visor => 'N'),
      			array( campo => 'facturacion',   valor =>$facturacion1 ,  filtro => $filtro3,   visor => 'N'),
      	        array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
      	);
      
      	
      	
      	$this->bd->_order_by('idproducto');
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('web_producto',$qquery );
      
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    $x = $this->bd->query_array('web_marca','nombre', 'idmarca='.$this->bd->sqlvalue_inyeccion( $fetch['idmarca'],true));
       	    
      	    
      		$output[] = array ( $fetch['idproducto'],
      		                    $fetch['producto'],
      		                    $fetch['referencia'],
      		                    $fetch['cuenta_inv'],
      		                    $x['nombre'],
      		                    $fetch['unidad'],
      		                    $fetch['costo'],
      		                    $fetch['saldo']
      		    
      		); 
      	}
      
      	pg_free_result($resultado);
      	
      	
      	echo json_encode($output);
      }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
    
   	 
   
   			 //------ consulta grilla de informacion
   			 if (isset($_GET['GrillaCodigo']))	{
   			 
   			 	$PKcodigo      = $_GET['GrillaCodigo'];
   			 	$idcategoria1  = $_GET['idcategoria1'];
   			 	$idbodega1     = $_GET['idbodega1'];
   			 	$facturacion1  = $_GET['facturacion1'];
   			 	$productob  = $_GET['productob'];
   			 	$codigob    = $_GET['codigob'];
   			 	
   			 	
   			 	 
   			 	$gestion->BusquedaGrilla($PKcodigo,$idcategoria1,$idbodega1 ,$facturacion1,$productob,$codigob);
   			 	 
   			 }
 
  
  
   
 ?>
 
  