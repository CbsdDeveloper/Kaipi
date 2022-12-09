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
      public function BusquedaGrilla($anio,$mes){
      
      	// Soporte Tecnico
      
      	$qquery = array(
      	    array( campo => 'fechaemision',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'idcliente',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'id_ventas',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
      	    array( campo => 'mes',valor => $mes,filtro => 'S', visor => 'N'),
      	    array( campo => 'registro',valor => $this->ruc ,filtro => 'S', visor => 'N')
      	);
      
      	$resultado = $this->bd->JqueryCursorVisor('view_anexos_ventas',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      		        $fetch['fechaemision'],
      		        $fetch['idcliente'],
      		        $fetch['razon'],
      		        $fetch['secuencial'],
      		        $fetch['baseimpgrav'],
      		        $fetch['montoiva'],
          		    $fetch['baseimponible'],
          		    $fetch['id_ventas'] 
      		    
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
            if (isset($_GET['anio']))	{
            
            	$anio  = $_GET['anio'];
            	$mes   = $_GET['mes'];
             	 
            	$gestion->BusquedaGrilla($anio,$mes );
            	 
            }
  
  
   
 ?>
 
  