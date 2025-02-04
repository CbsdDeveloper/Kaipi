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
      public function BusquedaGrilla($PK_codigo,$idcategoria1,$idbodega1 ,$facturacion1){
      
      	// Soporte Tecnico
      
      	$filtro1 = 'N';
      	$filtro2 = 'N';
      	$filtro3 = 'N';
      
      	if ($idcategoria1 <> 0){
      		$filtro1 = 'S';
      	}
      	if ($idbodega1 <> 0){
      		$filtro2 = 'S';
      	}
      	if ($facturacion1 <> '-'){
      		$filtro3 = 'S';
      	}
      
      	$qquery = array(
      			array( campo => 'idproducto',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'referencia',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'tipo',   valor => $PK_codigo ,  filtro => 'S',   visor => 'N'),
      			array( campo => 'idcategoria',   valor => $idcategoria1,  filtro => $filtro1,   visor => 'N'),
      			array( campo => 'idbodega',   valor => $idbodega1 ,  filtro => $filtro2,   visor => 'N'),
      			array( campo => 'facturacion',   valor =>$facturacion1 ,  filtro => $filtro3,   visor => 'N')
      	);
      
      	$resultado = $this->bd->JqueryCursorVisor('web_producto',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array ($fetch['idproducto'],$fetch['producto'],$fetch['referencia'],$fetch['estado'],$fetch['unidad'],$fetch['costo']);
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
   			 
   			 	$PKcodigo      = $_GET['GrillaCodigo'];
   			 	$idcategoria1  = $_GET['idcategoria1'];
   			 	$idbodega1     = $_GET['idbodega1'];
   			 	$facturacion1  = $_GET['facturacion1'];
   			 
   			 	 
   			 	$gestion->BusquedaGrilla($PKcodigo,$idcategoria1,$idbodega1 ,$facturacion1);
   			 	 
   			 }
 
  
  
   
 ?>
 
  