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
      public function BusquedaGrilla($ciu_bus){
      
		  
		  $qquery = array(

            array( campo  => 'idprov',valor => trim($ciu_bus) ,filtro => 'S',visor  => 'S'),

            array( campo  => 'sesion',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'id_ciu_ori',valor => 'N',filtro => 'N',visor  => 'S'),

            array( campo  => 'id_fre',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'id_ciu_des',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'chofer',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'hora',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'hora_min',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'ruta_ori',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'ruta_des',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'num_carro',valor => '-',filtro => 'N',visor  => 'S'),

            array( campo  => 'num_placa',valor => '-',filtro => 'N',visor  => 'S'),
);
      	
       
		 
       
      	$resultado = $this->bd->JqueryCursorVisor('rentas.ren_frecuencias',$qquery);
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
                    $fetch['id_fre'],
                    $fetch['hora'],
       				$fetch['ruta_ori'],
      				$fetch['ruta_des']
                    
      				
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

    		if (isset($_GET['ciu_bus']))	{
    			
    			$ciu_bus	  = $_GET['ciu_bus'];

     		 
                
    			$gestion->BusquedaGrilla($ciu_bus);
    			
    		}
    		
 
   
 ?>
 
  