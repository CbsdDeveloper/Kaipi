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
      public function BusquedaGrilla($breferencia){
      
		  
		  $qquery = array(
            array( campo  => 'clase',      valor => '-',            filtro => 'N',visor  => 'S'),

            array( campo  => 'referencia', valor => $breferencia,   filtro => 'S',visor  => 'S'),
            
            array( campo  => 'idclasebien',valor => '-',            filtro => 'N',visor  => 'S'),
            );
      	
       
		 
       
      	$resultado = $this->bd->JqueryCursorVisor('activo.ac_clase',$qquery);
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
       				$fetch['idclasebien'],
      				$fetch['clase'],
      				$fetch['referencia']
      				
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

    		if (isset($_GET['breferencia']))	{
    			
    			$VARIABLE	  = $_GET['breferencia'];
    		 
    			
					
    			$gestion->BusquedaGrilla($VARIABLE);
    			
    		}
    		
 
   
 ?>
 
  