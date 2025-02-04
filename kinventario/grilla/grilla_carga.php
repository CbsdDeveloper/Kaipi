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
      public function BusquedaGrilla($estado,$tipo,$fecha1,$fecha2){
      
       
      	$qquery = 
      			array( 
      			array( campo => 'id_cmovimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
      		    array( campo => 'sesion',   valor => '-',  filtro => 'N',   visor => 'S'),
      		    array( campo => 'estado',     valor => $estado,  filtro => 'S',   visor => 'S'),
       			array( campo => 'tipo',       valor =>$tipo,  filtro => 'S',   visor => 'N')
       			);
      
        // filtro para fechas
      	$this->bd->__between('fecha',$fecha1,$fecha2);
      			
      	$resultado = $this->bd->JqueryCursorVisor('inv_carga_movimiento',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_cmovimiento'],$fetch['fecha'],$fetch['detalle'],
      		                   $fetch['sesion'],$fetch['estado']
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
   			 
   			 	$estado= $_GET['estado'];
   			 	
   			 	$tipo= $_GET['tipo'];
   			 	
   			 	$fecha1= $_GET['fecha1'];
   			 	
   			 	$fecha2= $_GET['fecha2'];
   		 	 	 
   			 	$gestion->BusquedaGrilla($estado,$tipo,$fecha1,$fecha2);
   			 	 
   			 }
 
  
  
   
 ?>
 
  