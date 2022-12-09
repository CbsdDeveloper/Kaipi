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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];

                $this->sesion 	 =  trim($_SESSION['email']);
 
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
                $this->anio       =  $_SESSION['anio'];
                
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( $estado  ){
      
      	 
        $output = array();
        
	 
	  	 
		   	
			
      	$qquery = array(
                 array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
                 array( campo => 'id_vacacion',   valor => '-',  filtro => 'N',   visor => 'S'),
      		    	array( campo => 'hora_out',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'hora_in',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
      		    	array( campo => 'motivo',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'observacion',   valor => '-',  filtro => 'N',   visor => 'S'),
          	    array( campo => 'dia_tomados',   valor => '-',  filtro => 'N',   visor => 'S'),
       		    	array( campo => 'hora_tomados',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'sesion',   valor =>  $this->sesion ,  filtro => 'S',   visor => 'S'),
      	        array( campo => 'estado',   valor => $estado ,  filtro => 'S',   visor => 'S'),
      	        array( campo => 'anio',   valor => $this->anio ,  filtro => 'S',   visor => 'S')  
      	);
 
       
      	
      	$resultado = $this->bd->JqueryCursorVisor('nom_vacaciones',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      		                $fetch['id_vacacion'],
      		                $fetch['fecha'],
      		                trim($fetch['tipo']),
      		                trim($fetch['motivo']),
      		                trim($fetch['observacion']),
                   		    $fetch['dia_tomados'],
                           $fetch['hora_out'] .'-'. $fetch['hora_in'] ,
                   		    $fetch['hora_tomados'],
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
            if (isset($_GET['estado']))	{
            
                 $estado  = $_GET['estado'];
                 
                $gestion->BusquedaGrilla( $estado );
            	 
            }
  
  
   
 ?>
 
  