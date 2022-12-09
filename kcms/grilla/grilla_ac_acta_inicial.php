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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($Vid_departamento,$vtiene_acta,$vidsede){
      
  
          
          
          $qquery = array( 
              array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'bienes',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'id_departamento',valor => $Vid_departamento,filtro => 'S', visor => 'S'),
              array( campo => 'idsede',valor => $vidsede,filtro => 'S', visor => 'S'),
              array( campo => 'tiene_acta',     valor => $vtiene_acta,filtro => 'S', visor => 'S') 
          );
  
          
          $resultado = $this->bd->JqueryCursorVisor('activo.view_resumen_custodios',$qquery );
 
          
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
		 	$output[] = array (
		      				    $fetch['idprov'],
		 						trim($fetch['razon']),
		      				    trim($fetch['unidad']),
		      				    $fetch['tiene_acta'],
                		 	    $fetch['bienes']
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
            if (isset($_GET['Vid_departamento']))	{
            
 
                 $Vid_departamento = $_GET['Vid_departamento'];
                 $vtiene_acta      = $_GET['vtiene_acta'];
                 $vidsede          = $_GET['vidsede'];
             	 
                 
                 
                 $gestion->BusquedaGrilla($Vid_departamento,$vtiene_acta,$vidsede);
            	 
            }
  
  
   
 ?>
 
  