<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class grilla_liquidaciones{
 
     

      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function grilla_liquidaciones( ){
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
      public function BusquedaGrilla($anio,$mes, $cnombre ){
      
      	// Soporte Tecnico

        $longitud= strlen( $cnombre );
        $filtro = 'S';
        $filtro1 = 'N';


        if ( $longitud > 5 ){
                 $filtro  = 'N';
                 $filtro1 = 'S';
                 $nombre  = $cnombre.'%';

        } 
      
      	$qquery = array(
      	    array( campo => 'fecharegistro',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'razon',valor => 'LIKE.'.$nombre ,filtro =>  $filtro1, visor => 'S'),
      	    array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'baseimpgrav',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'montoiva',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'baseimponible',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'autorizacion',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'codigoe',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'id_liquida',valor => '-',filtro => 'N', visor => 'S'),
      	    array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
      	    array( campo => 'mes',valor => $mes,filtro => $filtro, visor => 'N'),
      	    array( campo => 'registro',valor => $this->ruc ,filtro => 'S', visor => 'N')
      	);
      	
      	
      
      	$resultado = $this->bd->JqueryCursorVisor('view_liquidaciones',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
        	    
      	    if ( $fetch['codigoe'] == 0) {
      	        
      	        $imagen  = '<img src="../../kimages/star.png" align="absmiddle"   />';
       	        
      	    }else{
      	        $imagen  = '<img src="../../kimages/starok.png" align="absmiddle"   />';
      	        
      	    }
      	    
      	    
      		$output[] = array (
      		        $fetch['fecharegistro'],
      		        $fetch['idprov'],
      		        $imagen.' '.$fetch['razon'],
      		        $fetch['secuencial'],
      		        $fetch['baseimpgrav'],
      		        $fetch['montoiva'],
          		    $fetch['baseimponible'],
          		    $fetch['id_liquida'] 
      		    
      		);
      		 
      	}

      	echo json_encode($output);
      	
      	
      	}
      	
//-----------------------------      	
       
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new grilla_liquidaciones;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['anio']))	{
            
            	$anio  = $_GET['anio'];
            	$mes   = $_GET['mes'];

                $cnombre = trim($_GET['cnombre']);
             	 
            	$gestion->BusquedaGrilla($anio,$mes, $cnombre  );
            	 
            }
  
  
   
 ?>