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
        
        $filtro = 'S';

        if ( $estado  == 'tthh'){
          $filtro = 'N';
			  }
        
        if ( $estado  == 'financiero'){
          $filtro = 'N';
			  }

      	$qquery = array(
                 array( campo => 'id_anticipo',   valor => '-',  filtro => 'N',   visor => 'S'),
                 array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
      		       array( campo => 'documento',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'solicita',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      		      array( campo => 'plazo',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'mensual',   valor => '-',  filtro => 'N',   visor => 'S'),
          	    array( campo => 'novedad',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'sesion',   valor =>  $this->sesion ,  filtro => $filtro,   visor => 'S'),
        	        array( campo => 'estado',   valor => $estado ,  filtro => 'S',   visor => 'S'),
      	        array( campo => 'anio',   valor => $this->anio ,  filtro => 'S',   visor => 'S')  
      	);
 
       
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_lista_anticipo',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
  
          $detalle = trim($fetch['detalle']);

          if ( $estado  == 'tthh'){
            $array   = $this->bd->__user($this->sesion ) ;
            $detalle = '<b>'.trim($fetch['razon']).'</b> '.$detalle ;


          }
          if ( $estado  == 'financiero'){
            $array   = $this->bd->__user($this->sesion ) ;
            $detalle = '<b>'.trim($fetch['razon']).'</b> '.$detalle ;


          }

        

      		$output[] = array (
      		                $fetch['id_anticipo'],
      		                $fetch['fecha'],
      		                trim($fetch['documento']),
      		                $detalle,
      		                trim($fetch['solicita']),
                   		    $fetch['plazo'],
                    		$fetch['novedad'],
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
 
  