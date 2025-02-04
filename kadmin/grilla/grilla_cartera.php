<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
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
      public function BusquedaGrilla(){
      
       
      	$qquery = 
      			array( 
      			    array( campo => 'id_cartelera',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'asunto',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'notificacion',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'sesion',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'modulo',   valor => 'S',  filtro => 'S',   visor => 'S'),
      			    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S')
       			);
      
      			
 
       
        $output = array();
      			
      	$resultado = $this->bd->JqueryCursorVisor('nom_cartelera',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_cartelera'],
      		                    $fetch['asunto'],
      		                    $fetch['notificacion'],
      		                    $fetch['estado'] , 
      		                    $fetch['sesion'] 
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
     
        	$gestion->BusquedaGrilla();
   			 	 
 
  
  
   
 ?>
 
  