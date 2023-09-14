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
      public function BusquedaGrilla($naturaleza,$ciudad,$bestado,$crazon,$cidprov){
      
      	
      	if ($naturaleza == '-'){
      		$sfiltro = 'N';
      	}else{
      		$sfiltro = 'S';
      	}
      	
		  $sfiltro1 = 'S';

      	
      	$lon      =  strlen($crazon);
      	$filtro2  = 'N';
      	
      	if ( $lon >  3 ){
      	    $filtro2= 'S';
			$filtro21= 'N';
			$sfiltro1 = 'N';
      	    $dato = 'LIKE.'. '%'.strtoupper($crazon).'%';   // PALABRA RESERVADA PARA BUSCAR COICIDENCIAS CON LA VARIABLE LIKE
      	}

	    $lon1      =  strlen( $cidprov);
       	$filtro21  = 'N';
      	
      	if ( $lon1 >  3 ){
      	    $filtro21= 'S';
			$sfiltro1 = 'N';
			$filtro2= 'N';
      	    $dato1 = 'LIKE.'. strtoupper($cidprov).'%';   // PALABRA RESERVADA PARA BUSCAR COICIDENCIAS CON LA VARIABLE LIKE
      	}
      	
		 

      	$qquery = array(
      			array( campo => 'idprov',       valor => $dato1,      filtro =>  $filtro21,         visor => 'S'),
      	        array( campo => 'razon',        valor => $dato,    filtro => $filtro2,    visor => 'S'),
      			array( campo => 'correo',       valor => '-',      filtro => 'N',         visor => 'S'),
      			array( campo => 'direccion',    valor => '-',      filtro => 'N',         visor => 'S'),
      			array( campo => 'telefono',     valor => '-',      filtro => 'N',         visor => 'S'),
      			array( campo => 'estado',       valor =>$bestado,  filtro => 'S',         visor => 'N'),
      	        array( campo => 'idciudad',     valor =>$ciudad,   filtro => $sfiltro1,   visor => 'N'),
      			array( campo => 'naturaleza',   valor =>$naturaleza,  filtro => $sfiltro, visor => 'N'),
      			array( campo => 'modulo',       valor =>"-",          filtro => 'N',      visor => 'S')
      	);
      	
	   // tabla par_ciu 
	   // campo modulo = 'C' contribuyentes, 'P' proveedores 'N' nomina
       
      	$resultado = $this->bd->JqueryCursorVisor('par_ciu',$qquery );
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
      				trim($fetch['idprov']),
      				'<b>'.trim($fetch['razon']). '</b> ('.trim($fetch['modulo']).')',
      				$fetch['correo'],
      				$fetch['telefono']
      				
      		);
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
    		if (isset($_GET['bnaturaleza']))	{
    			
    			$naturaleza	  = $_GET['bnaturaleza'];
    			$ciudad       = $_GET['bidciudad'];
    			$bestado	  = $_GET['bestado'];
    			$crazon       = $_GET['crazon'];
				$cidprov = $_GET['cidprov'];
    			
    			$gestion->BusquedaGrilla($naturaleza,$ciudad,$bestado,$crazon,$cidprov);
    			
    		}
    		
 
   
 ?>
 
  