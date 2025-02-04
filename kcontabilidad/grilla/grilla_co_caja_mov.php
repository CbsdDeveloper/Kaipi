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
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($PK_codigo, $fmes,$cuenta){
      
          
           
         
      	$qquery = array(
      			array( campo => 'id_asiento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'anio',   valor => $PK_codigo,  filtro => 'S',   visor => 'S'),
      	        array( campo => 'mes',   valor => $fmes,  filtro => 'S',   visor => 'S'),
      	        array( campo => 'cuenta',   valor => $cuenta,  filtro => 'S',   visor => 'S'),
      	        array( campo => 'transaccion',   valor => 'X',  filtro => 'S',   visor => 'S'),
      	        array( campo => 'estado',   valor => 'aprobado',  filtro => 'S',   visor => 'S'),
      			array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
          	    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
          	    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'montoi',   valor => '-',  filtro => 'N',   visor => 'S'),
      	        array( campo => 'monto',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'registro',   valor => $this->ruc,  filtro => 'S',   visor => 'N')
      	);
      
      	$this->bd->_order_by('fecha asc ,montoi desc'  );
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_auxbancos',$qquery );
      	
      	
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array ($fetch['id_asiento'],
      		                    $fetch['fecha'],
      		                    $fetch['idprov'],
      		                    $fetch['razon'],
      		                    $fetch['detalle'],
                      		    $fetch['montoi'],
                      		    $fetch['monto'] 
      		    
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
            if (isset($_GET['fanio']))	{
            
            	$PKcodigo  = $_GET['fanio'];
             	 
            	$fmes = $_GET['fmes'];
            	
            	$cuenta = $_GET['cuenta'];
            	
            	$gestion->BusquedaGrilla($PKcodigo ,$fmes,$cuenta);
            	 
            }
  
  
   
 ?>
 
  