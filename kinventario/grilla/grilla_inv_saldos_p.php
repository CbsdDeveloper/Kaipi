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
/*
CLASE CONSTRUCTOR DE INICIO DE DATOS
*/ 
      function proceso( ){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
 /*
GRILLA DE INFORMACION QUE VISUALIZA EN EL FORMULARIO DE DATOS
*/ 
      public function BusquedaGrilla($tipo,$facturacion, $idcategoria,$nivel,$idbodega,$nombre_producto,$codigog){
      
      	$filtro1 = 'S';
      	$filtro2 = 'S';
      	$filtro3 = 'S';
      	$filtro4 = 'S';
      	$filtro5 = 'N';
      	$filtro6 = 'N';
      
      	if ($tipo == '-'){
      		$filtro1 = 'N';
      	}
      	if ($facturacion == '-'){
      		$filtro2 = 'N';
      	}
       
      		$filtro3 = 'N';
      		$idmarca = '-';
      		$filtro5 = 'N';
      
      	if ($idcategoria == 0){
      	    $filtro4 = 'N';
      	}
 
      	$like_pr = '-';
      	$lon = strlen($nombre_producto);
      	
      	if ( $lon > 3 ){
      	    $filtro4 = 'N';
      	    $filtro2 = 'N';
      	    $filtro1 = 'N';
      	    $filtro5 = 'S';
      	    $like_pr = 'LIKE.'."%".$nombre_producto."%";
      	}
      	
      	if ( $codigog > 0 ){
      	    $filtro4 = 'N';
      	    $filtro2 = 'N';
      	    $filtro1 = 'N';
      	    $filtro5 = 'N';
      	    $filtro6 = 'S';
      	}
      	
      	
      	
      	$qquery = array(
      	        array( campo => 'idproducto',   valor => $codigog,  filtro => $filtro6,   visor => 'S'),
      	        array( campo => 'producto',   valor => $like_pr,  filtro => $filtro5,   visor => 'S'),
      			array( campo => 'categoria',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'minimo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'ingreso',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cuenta_inv',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'marca',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'codigo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'egreso',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'saldo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'lifo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'pvp',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'tipo',   valor => $tipo ,  filtro => $filtro1,   visor => 'N'),
      	        array( campo => 'idcategoria',   valor => $idcategoria,  filtro => $filtro4,   visor => 'N'),
      	        array( campo => 'idmarca',   valor => $idmarca ,  filtro => $filtro3,   visor => 'N'),
      	        array( campo => 'facturacion',   valor =>$facturacion ,  filtro => $filtro2,   visor => 'N'),
      	        array( campo => 'idbodega',   valor =>$idbodega ,  filtro => 'S',   visor => 'N'),
      	        array( campo => 'registro',   valor => $this->ruc  ,  filtro => 'S',   visor => 'N')
      	);
		  
      	
      	$this->bd->_order_by('idproducto');
      	
      	// filtro adicional
        $this->bd->__betweenq($nivel);
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_saldos_bod_p',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      		    $fetch['idproducto'],
      		    $fetch['producto'],
      		    $fetch['cuenta_inv'],
      		    $fetch['codigo'],
      		    $fetch['categoria'],
      		    $fetch['costo'],
				round($fetch['ingreso'],2),
				round($fetch['egreso'],2),
				round($fetch['saldo'] ,2)  
      		);
      		
      	}
      
      	
      	pg_free_result($resultado);
      	
      	
      	echo json_encode($output);
      }
   
 }    
 /*
GRILLA DE INFORMACION QUE VISUALIZA EN EL FORMULARIO DE DATOS
*/ 
 
    		$gestion   = 	new proceso;
    	 
   
   			 //------ consulta grilla de informacion
   			 if (isset($_GET['tipo']))	{
   			 
                 $tipo        = $_GET['tipo'];
   			     $facturacion = $_GET['facturacion'];
    			 $idcategoria = $_GET['idcategoria'];
   			     $nivel       = $_GET['nivel'];
    			 $idbodega    = $_GET['idbodega'];
    			 $codigog     = $_GET['codigog'];
     			 
    			 $nombre_producto  = $_GET['nombre_producto'];
   			  	 
    			 $gestion->BusquedaGrilla($tipo,$facturacion, $idcategoria,$nivel,$idbodega,$nombre_producto,$codigog);
   			 	 
   			 }
 
  
  
   
 ?>