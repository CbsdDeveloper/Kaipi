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
      public function BusquedaGrilla($anio,$mes,$estado){
      
      	// Soporte Tecnico
      
      	$qquery = array(
      	    array( campo => 'fecharegistro',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'secretencion1',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'id_tramite',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'id_compras',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
      	    array( campo => 'mes',valor => $mes,filtro => 'S', visor => 'N'),
      	    array( campo => 'estado',valor => $estado,filtro => 'S', visor => 'N'),
      	    array( campo => 'autretencion1',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'registro',valor => $this->ruc ,filtro => 'S', visor => 'N')
      	);
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_anexos_compras',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      	    $comprobante =   trim($fetch['autretencion1'] );
      	    
      	    $len = strlen($comprobante);
      	    
      	    if ($len > 10){
      	        
      	        $imagen  = '<img src="../../kimages/starok.png" align="absmiddle"   />';
      	        
      	        
      	    }else{
      	        
      	        $imagen  = '<img src="../../kimages/star.png" align="absmiddle"   />';
      	        
      	    }
      	    
      	    
      	    
      		$output[] = array (
      		        $fetch['fecharegistro'],
      		        $fetch['idprov'],
      		        $fetch['razon'],
      		        $fetch['secuencial'],
      		        $fetch['secretencion1'],
      		        $fetch['baseimpgrav'],
      		        $fetch['montoiva'],
          		    $fetch['baseimponible'],
      		        $fetch['id_tramite'],
          		    $fetch['id_compras'] ,
      		    $imagen
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
            
            	$anio    = $_GET['anio'];
            	$mes     = $_GET['mes'];
            	$estado  = $_GET['estado'];
             	 
            	$gestion->BusquedaGrilla($anio,$mes,$estado );
            	 
            }
  
  
   
 ?>
 
  