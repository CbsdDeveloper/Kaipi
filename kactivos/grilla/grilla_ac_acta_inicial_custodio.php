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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($idprov){
      
  
         
          
          $qquery = array( 
              array( campo => 'id_acta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'clase_documento',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'modificacion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tipo',valor => 'A',filtro => 'S', visor => 'S'),
              array( campo => 'idprov',     valor => $idprov,filtro => 'S', visor => 'S') 
          );
  
          $resultado = $this->bd->JqueryCursorVisor('activo.ac_movimiento',$qquery );
 
          
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
		 	$output[] = array (
		      				    $fetch['id_acta'],
		 						trim($fetch['clase_documento']),
		      				    trim($fetch['documento']),
		      				    $fetch['fecha'],
		 	                    $fetch['detalle'],
                 		 	    $fetch['modificacion']
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
 
    		$gestion   = 	new proceso;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['idprov']))	{
            
 
                $idprov = $_GET['idprov'];
              	 
                $gestion->BusquedaGrilla($idprov);
            	 
            }
  
  
   
 ?>
 
  