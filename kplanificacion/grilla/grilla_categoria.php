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
      public function BusquedaGrilla($tipo){
      
      	// Soporte Tecnico
  
      	$qquery = array( array( campo => 'idcategoria',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'referencia',   valor => '-',  filtro => 'N',   visor => 'S') 
      	);
      
      	$resultado = $this->bd->JqueryCursorVisor('web_categoria',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (  $fetch['idcategoria'],$fetch['nombre'],$fetch['referencia']	);
      		
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
    
    		$tipo= $_GET['tipo_catalogo'];
 
   			 	 
   	     	$gestion->BusquedaGrilla($tipo);
   			 	 
   	 
  
  
   
 ?>
 
  