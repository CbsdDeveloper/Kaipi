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
      public function BusquedaGrilla($banio,$btipo,$bregimen,$btipo_proyecto,$btipo_producto,$bprocedimiento){
      
		  $lon      =  strlen($banio);

        $filtro2  = 'N';

        $filtro3  = 'S';
        $filtro4  = 'S';
        $filtro5  = 'S';
        $filtro6  = 'S';
        $filtro7  = 'S';

        if ( $lon >  3 ){
            $filtro2= 'S';
            
            $dato = 'LIKE.'.($banio).'%';   // PALABRA RESERVADA PARA BUSCAR COICIDENCIAS CON LA VARIABLE LIKE
        }


        if ( $btipo == '-'){
            $filtro3  = 'N';
        }

        if ( $bregimen == '-'){
            $filtro4  = 'N';
        }

        if ( $btipo_proyecto == '-'){
            $filtro5  = 'N';
        }

        if ( $btipo_producto == '-'){
            $filtro6  = 'N';
        }

        if ( $bprocedimiento == '-'){
            $filtro7  = 'N';
        }

		  $qquery = array(
                    array( campo  => 'referencia',     valor => '-',           filtro => 'N',visor  => 'S'),
                    array( campo  => 'partida',        valor => '-',           filtro => 'N',visor  => 'S'),
                    array( campo  => 'cpc',            valor => '-',           filtro => 'N',visor  => 'S'),
                    array( campo  => 'tipo',           valor => $btipo,        filtro => $filtro3 ,visor  => 'S'),
                    array( campo  => 'regimen',        valor => $bregimen,     filtro => $filtro4 ,visor  => 'S'),
                    array( campo  => 'bid',            valor => '-',           filtro => 'N',visor  => 'S'),
                    array( campo  => 'tipo_proyecto',  valor => $btipo_proyecto,filtro => $filtro5,visor  => 'S'),
                    array( campo  => 'tipo_producto',  valor => $btipo_producto, filtro => $filtro6,visor  => 'S'),
                    array( campo  => 'catalogo_e',     valor => '-',            filtro => 'N',visor  => 'S'),
                    array( campo  => 'procedimiento',  valor => $bprocedimiento,filtro => $filtro7,visor  => 'S'),
                    array( campo  => 'detalle',        valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'cantidad',       valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'medida',         valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'costo',          valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'total',          valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'periodo',        valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'estado',         valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'sesion',         valor => '-',             filtro => 'N',visor  => 'S'),
                    array( campo  => 'fecha',          valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'fecha_ejecuta',  valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'fecha_final',    valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'id_departamento',valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'id_pac',         valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'programa',       valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'clasificador',   valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'anio',          valor => $dato,            filtro => $filtro2,visor  => 'S'),
                    array( campo  => 'partida_fin',   valor => '-',              filtro => 'N',visor  => 'S'),
                    array( campo  => 'avance',         valor => '-',             filtro => 'N',visor  => 'S'),

);
      	
       
		 
       
      	$resultado = $this->bd->JqueryCursorVisor('adm.adm_pac',$qquery);
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      		$output[] = array (
       				$fetch['id_pac'],
      				$fetch['cpc'],
      				$fetch['partida'],
                    $fetch['tipo'],
                    $fetch['tipo_proyecto'],
                    $fetch['procedimiento'],
                    $fetch['detalle'],
                    $fetch['total'],

      				
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

    		if (isset($_GET['btipo']))	{
    			
    			$banio	            = $_GET['banio'];
                $btipo              = $_GET['btipo'];
                $bregimen           = $_GET['bregimen'];
                $btipo_proyecto     = $_GET['btipo_proyecto'];
                $btipo_producto     = $_GET['btipo_producto'];
                $bprocedimiento     = $_GET['bprocedimiento'];
    		 
    			
			
    			$gestion->BusquedaGrilla($banio,$btipo,$bregimen,$btipo_proyecto,$btipo_producto,$bprocedimiento);
    			
    		}
    		
 
   
 ?>
 
  