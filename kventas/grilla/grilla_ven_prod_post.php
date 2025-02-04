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
      public function BusquedaGrilla($idvengestion ){
      
    
          
      	$qquery = array(
      	    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
       	    array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'cantidad',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'precio',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'total_descuento',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'iva',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'subtotal',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'idven_prod',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'idvengestion',   valor => $idvengestion,  filtro => 'S',   visor => 'N'),
      	    array( campo => 'registro',   valor =>  $this->ruc,  filtro => 'S',   visor => 'N'),
      	    array( campo => 'estado',   valor => 1,  filtro => 'S',   visor => 'N')
       	);
      
    
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('ven_cliente_prod',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (  $fetch['fecha'],
      		                     $fetch['producto'],
      		                     $fetch['cantidad']	,
      		                     $fetch['precio'] ,
                      		     $fetch['total_descuento']  ,
                      		    $fetch['iva']  ,
                      		    $fetch['subtotal']  ,
                      		    $fetch['total']  ,
       		                     $fetch['idven_prod']  
      		    
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
 
 
    		if (isset($_GET['id']))	{
    		    
    		    
     		    $idvengestion      = $_GET['id'];
    		    
     		    $gestion->BusquedaGrilla($idvengestion);
    		    
    		}
   			 	 
   	 
  
  
   
 ?>
 
  