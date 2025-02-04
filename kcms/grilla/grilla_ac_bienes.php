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
      public function BusquedaGrilla($vtipo_bien,$vcuenta,$Vid_departamento,$vuso,$vtiene_acta,$vidsede){
      
 
          if ( $vuso == '-'){
              $filtro1 = 'N';
          }else {
              $filtro1 = 'S';
          }
          
          if ( $Vid_departamento == '0'){
              $filtro2 = 'N';
          }else {
              $filtro2 = 'S';
          }
          
          if ( $vtiene_acta == '-'){
              $filtro3 = 'N';
          }else {
              $filtro3 = 'S';
          }
          
          
          $qquery = array( 
              array( campo => 'id_bien',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idsede',valor => $vidsede,filtro => 'S', visor => 'S'),
              array( campo => 'tipo_bien',      valor => $vtipo_bien,filtro => 'S', visor => 'S'),
              array( campo => 'cuenta',         valor => $vcuenta,filtro => 'S', visor => 'S'),
              array( campo => 'uso',            valor => $vuso,filtro => $filtro1, visor => 'S'),
              array( campo => 'id_departamento',valor => $Vid_departamento,filtro => $filtro2, visor => 'S'),
              array( campo => 'tiene_acta',     valor => $vtiene_acta,filtro => $filtro3, visor => 'S') 
          );
  
          
          $resultado = $this->bd->JqueryCursorVisor('activo.view_bienes_itil',$qquery );
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
		 	$output[] = array (
		      				    $fetch['id_bien'],
		 						$fetch['unidad'],
		      				    $fetch['razon'],
		      				    $fetch['descripcion'],
                		 	    $fetch['fecha'],
                		 	    $fetch['costo_adquisicion'] 
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
            if (isset($_GET['vtipo_bien']))	{
            
            	 
                $vtipo_bien       = $_GET['vtipo_bien'];
                $vcuenta          = $_GET['vcuenta'];
                $Vid_departamento = $_GET['Vid_departamento'];
                $vuso             = $_GET['vuso'];
                $vtiene_acta      = $_GET['vtiene_acta'];
                $vidsede      = $_GET['vidsede'];
                
                
                $gestion->BusquedaGrilla($vtipo_bien,$vcuenta,$Vid_departamento,$vuso,$vtiene_acta,$vidsede);
            	 
            }
  
  
   
 ?>
 
  