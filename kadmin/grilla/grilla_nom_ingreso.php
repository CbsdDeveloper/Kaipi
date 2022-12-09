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
      public function BusquedaGrilla($PK_codigo){
      
      	 
          
      
      	$qquery = array(
      	        array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
       	        array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'sueldo',   valor => '-',  filtro => 'N',   visor => 'S'),
       			array( campo => 'estado',   valor => $PK_codigo ,  filtro => 'S',   visor => 'N'),
      	        array( campo => 'registro',   valor =>$this->ruc  ,  filtro => 'N',   visor => 'N')
      	);
      
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_nomina_rol',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      		                $fetch['idprov'],
      		                $fetch['razon'],
      		                $fetch['direccion'],
      		                $fetch['correo'],
      		                $fetch['fecha'],
      		                $fetch['sueldo'],
       		    
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
            if (isset($_GET['GrillaCodigo']))	{
            
            	$PKcodigo  = $_GET['GrillaCodigo'];
             	 
            	$gestion->BusquedaGrilla($PKcodigo );
            	 
            }
  
  
   
 ?>
 
  