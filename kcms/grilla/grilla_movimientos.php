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
      public function BusquedaGrilla($estado,$tipo,$fecha1,$fecha2,$idbodega1){
      
       
      	$qquery = 
      			array( 
      			array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'documento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'proveedor',   valor => '-',  filtro => 'N',   visor => 'S'),
      			 array( campo => 'carga',     valor => '0',  filtro => 'S',   visor => 'N'),
      			array( campo => 'estado',     valor => $estado,  filtro => 'S',   visor => 'N'),
      		    array( campo => 'registro',     valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
      			array( campo => 'idbodega',     valor => $idbodega1 ,  filtro => 'S',   visor => 'N'),
       			array( campo => 'tipo',       valor =>$tipo,  filtro => 'S',   visor => 'N')
       			);
      
      			
        // filtro para fechas
      	$this->bd->__between('fecha',$fecha1,$fecha2);
      			
      	$resultado = $this->bd->JqueryCursorVisor('view_inv_movimiento',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_movimiento'],$fetch['fecha'],$fetch['detalle'],
      		                    $fetch['comprobante'],$fetch['documento'],$fetch['idprov'],$fetch['proveedor']
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
   			 	
   			 	$idbodega1= $_GET['idbodega1'];
   			 	
   			 	$fecha2= $_GET['fecha2'];
   		 	 	 
   			 	$gestion->BusquedaGrilla($estado,$tipo,$fecha1,$fecha2,$idbodega1);
   			 	 
   			 }
 
  
  
   
 ?>
 
  