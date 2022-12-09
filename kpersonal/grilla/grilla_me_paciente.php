<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class grilla_me_paciente{
 
  
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function grilla_me_paciente( ){
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
      public function BusquedaGrilla($qestado,$qunidad ,$qregimen){
      
      	 
        $output = array();
        
		$filtro = 'S';
		$filtror = 'S';
		
		if ( $qunidad == '-'){
			$filtro = 'N';
	  	}
			
	  	if ( $qregimen == '-'){
	  	    $filtror = 'N';
	  	}
		   	
		   	
			
      	$qquery = array(
      	        array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
       	        array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'tsangre',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'sueldo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'anio_trascurrido',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'estado',   valor => $qestado ,  filtro => 'S',   visor => 'N'),
      	        array( campo => 'id_departamento',   valor => $qunidad ,  filtro => $filtro,   visor => 'N'),
      	        array( campo => 'regimen',   valor => trim($qregimen) ,  filtro => $filtror,   visor => 'N') 
      	);
      
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_nomina_rol',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      		                $fetch['idprov'],
      		                $fetch['razon'],
      		                $fetch['cargo'],
      		                $fetch['correo'],
      		                $fetch['fecha'],
      		                $fetch['anio_trascurrido'],            
      		                $fetch['tsangre'],
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
 
    		$gestion   = 	new grilla_me_paciente;
 
    		 
    		
          
            //------ consulta grilla de informacion
            if (isset($_GET['qestado']))	{
            
                $qestado  = $_GET['qestado'];
                $qunidad  = $_GET['qunidad'];
                $qregimen  = $_GET['qregimen'];
                
                $gestion->BusquedaGrilla($qestado,$qunidad ,$qregimen);
            	 
            }
  
  
   
 ?>
 
  