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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($naturaleza,$ciudad,$bestado,$clienteq){
      
      	
      	if ($naturaleza == '-'){
      		$sfiltro = 'N';
      	}else{
      		$sfiltro = 'S';
      	}
      	
      	if ($ciudad == '0'){
      	    $sfiltro1 = 'N';
      	}else{
      	    $sfiltro1 = 'S';
      	}
      	
      	$cadena = '%'.strtoupper($clienteq).'%';
      	
      	$qquery = array(
      			array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'razon',   valor => 'LIKE.'.$cadena,  filtro => 'S',   visor => 'S'),
      			array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'estado',   valor =>$bestado,  filtro => 'S',   visor => 'N'),
      	        array( campo => 'idciudad',   valor =>$ciudad,  filtro => $sfiltro1,   visor => 'N'),
      			array( campo => 'naturaleza',   valor =>$naturaleza,  filtro => $sfiltro,   visor => 'N'),
      			array( campo => 'modulo',   valor =>"C",  filtro => 'S',   visor => 'N')
      	);
      	
      	
       
     // 	$this->bd->_order_by('idseq');
      	
      	$resultado = $this->bd->JqueryCursorVisor('par_ciu',$qquery );
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
      				trim($fetch['idprov']),
      				$fetch['razon'],
      				$fetch['correo'],
      				$fetch['telefono']
      				
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
    		if (isset($_GET['bnaturaleza']))	{
    			
    			$naturaleza   = $_GET['bnaturaleza'];
    			$ciudad       = $_GET['bidciudad'];
    			$bestado      = $_GET['bestado'];
    			
    			$clienteq      = $_GET['clienteq'];
    			
    			
    			$gestion->BusquedaGrilla($naturaleza,$ciudad,$bestado,$clienteq);
    			
    		}
    		
    		
    	 
    	 
    		
         
  
  
  
   
 ?>
 
  