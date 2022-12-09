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
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($ffecha1,$ffecha2,$vid_departamento){
      
       
       $datos = $this->bd->__user($this->sesion ) ;
       
       if ( trim($datos['responsable']) == 'S'){
           $filtro = 'N';
        }else{
           $filtro = 'S';
       }
          
  
      	$qquery = array(
      		    	array( campo => 'id_bita_bom',   valor => '-',  filtro => 'N',   visor => 'S'),
                    array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'peloton',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'fecha_creacion',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'fecha_modificacion',valor => '-',filtro => 'N', visor => 'S'),
      	            array( campo => 'sesion',valor => $this->sesion,filtro => $filtro , visor => 'S'),
                    array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
      	            array( campo => 'id_departamento',valor => $vid_departamento,filtro => $filtro, visor => 'S')
      	);
      
      	
      	$this->bd->__between('fecha',$ffecha1,$ffecha2);
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('bomberos.view_bom_bitacora',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		
      	     
      	    
      	    $output[] = array (  
                  $fetch['id_bita_bom'],
      	          $fetch['razon'],
      	          $fetch['fecha'],
      	          $fetch['peloton'],
      	          $fetch['novedad'] ,
                  $fetch['estado'] ,
                   
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
    
    		$ffecha1           = $_GET['ffecha1'];
    		$ffecha2           = $_GET['ffecha2'];
    		$vid_departamento  = $_GET['vid_departamento'];
 
        
   			 	 
        
    		$gestion->BusquedaGrilla($ffecha1,$ffecha2,$vid_departamento);
 
   
 ?>