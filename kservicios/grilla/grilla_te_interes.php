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
      public function BusquedaGrilla($banio,$bmes){
      
		  
		  $qquery = array(
                    array( campo  => 'anio',valor => $banio, filtro => 'S',visor  => 'S'),

                    array( campo  => 'mes',valor => $bmes,filtro => 'S',visor  => 'S'),

                    array( campo  => 'monto',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'sesion',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'creacion',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'modificado',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'fmodificacion',valor => '-',filtro => 'N',visor  => 'S'),

                    array( campo  => 'idinteres',valor => '-',filtro => 'N',visor  => 'S')
                    );
      	
       
		 
       
      	$resultado = $this->bd->JqueryCursorVisor('tesoreria.te_interes',$qquery);
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
       				$fetch['idinteres'],
      				$fetch['anio'],
      				$fetch['mes'],
                    $fetch['monto'],
                    $fetch['modificado'],
                    $fetch['fmodificacion']
      				
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

    		if (isset($_GET['banio']))	{
    			
    			$banio	  = $_GET['banio'];
                $bmes     = $_GET['bmes'];
    		 
    			
					
    			$gestion->BusquedaGrilla($banio,$bmes);
    			
    		}
    		
 
   
 ?>
 
  