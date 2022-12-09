<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class grilla_me_atencion{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function grilla_me_atencion( ){
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
      public function BusquedaGrilla($qestado,$qunidad ){
      
      	 
        $output = array();
        
		$filtro = 'S';
 		
		if ( $qunidad == '-'){
			$filtro = 'N';
	  	}
			
	 
      	$qquery = array(
      	        array( campo => 'id_atencion',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'hora',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'id_prov',   valor => '-',  filtro => 'N',   visor => 'S'),
       	        array( campo => 'nombre_funcionario',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'edad',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'tsangre',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'motivo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'arterial',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'estado',   valor => $qestado ,  filtro => 'S',   visor => 'N'),
      	        array( campo => 'id_departamento',   valor => $qunidad ,  filtro => $filtro,   visor => 'N')
      	    
      	);
 
       	
      	
      	$resultado = $this->bd->JqueryCursorVisor('medico.view_ate_medica',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      		                $fetch['id_atencion'],
      		                $fetch['fecha'],
      		                $fetch['hora'],
      		                $fetch['nombre_funcionario'],
      		                $fetch['edad'],            
      		                $fetch['tsangre'],
      		    $fetch['motivo'],
      		    $fetch['arterial'],
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
 
    		$gestion   = 	new grilla_me_atencion;
 
    		 
    		
          
            //------ consulta grilla de informacion
            if (isset($_GET['qestado']))	{
            
                $qestado  = $_GET['qestado'];
                $qunidad  = $_GET['qunidad'];
                 
                $gestion->BusquedaGrilla($qestado,$qunidad );
            	 
            }
  
  
   
 ?>
 
  