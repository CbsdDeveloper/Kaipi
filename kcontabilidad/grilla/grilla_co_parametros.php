<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
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
            //inicializamos la clase para conectarnos a la bd
 
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
      public function BusquedaGrilla($PK_codigo,$var_activo){
      
      	// Soporte Tecnico
      
      	$qquery = array(
      			array( campo => 'secuencia',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'activo',    valor =>  $var_activo,  filtro => 'S',   visor => 'S'),
      			array( campo => 'cuenta',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'codigo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'valor1',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'tipo',   valor => $PK_codigo ,  filtro => 'S',   visor => 'N')
      	);
      
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('co_catalogo',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      	    
      	    if ($fetch['activo'] == 'S'){
      	        $check ='checked';
      	    }else{
      	        $check =' ';
      	    }
      	 
      		 
      	    $output[] = array ($fetch['secuencia'],
      	                       $fetch['detalle'],
      	                       $check,
      	                       $fetch['cuenta'],$fetch['codigo'],$fetch['valor1']);
      		 
      	}

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
            
            	$PKcodigo  = $_GET['GrillaCodigo'];
            	
            	$var_activo  = $_GET['var_activo'];
             	 
            	$gestion->BusquedaGrilla($PKcodigo,$var_activo );
            	 
            }
  
  
   
 ?>
 
  