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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($tipo){
      
       
      	$qquery = 
      			array( 
      			    array( campo => 'id_config',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'estructura',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'formula',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'monto',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'variable',   valor => '-',  filtro => 'N',   visor => 'S'),
      			    array( campo => 'tipo',       valor =>$tipo,  filtro => 'S',   visor => 'N')
       			);
      
      			
      	$resultado = $this->bd->JqueryCursorVisor('nom_config',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_config'],$fetch['nombre'],$fetch['estado'],
      		                    $fetch['estructura'],$fetch['formula'],$fetch['monto'],$fetch['variable']
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
   			 if (isset($_GET['tipo']))	{
   			 
   			  	$tipo= $_GET['tipo'];
   			 	
   			  
   			  	$gestion->BusquedaGrilla($tipo);
   			 	 
   			 }
 
  
  
   
 ?>
 
  