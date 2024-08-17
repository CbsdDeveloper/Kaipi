<?php 
session_start();   
  
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
      public function BusquedaGrilla($vtipo_bien,$vcuenta,$Vid_departamento,$vuso,$vtiene_acta,$vidsede,$vactivo,$vcodigo){
      
 
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
          
          if ( $vcuenta == '-'){
              $filtro4 = 'N';
          }else {
              $filtro4 = 'S';
          }
          
          
          $len = strlen($vactivo);
          $filtro5 = 'N';
          
          if ( $len  > 5 ){
              $filtro4 = 'N';
              $filtro1 = 'N';
              $filtro2 = 'N';
              $filtro3 = 'N';
              $filtro5 = 'S';
              $variable = 'LIKE.'.'%'.strtoupper($vactivo).'%';
          }
          
          $filtro6 = 'N'; 
          $filtro8 = 'S';
          if ( $vcodigo  > 0 ){
              $filtro4 = 'N';
              $filtro1 = 'N';
              $filtro2 = 'N';
              $filtro3 = 'N';
              $filtro5 = 'N';
              $filtro6 = 'S';
              $filtro8 = 'N';
          }
          
          
          
          $qquery = array( 
              array( campo => 'id_bien',valor => $vcodigo,filtro => $filtro6, visor => 'S'),
              array( campo => 'sede',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'descripcion',valor => $variable,filtro => $filtro5, visor => 'S'),
              array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idproveedor',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'proveedor',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'codigo_actual',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tipo_bien',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idsede',valor => $vidsede,filtro => $filtro8, visor => 'S'),
              array( campo => 'tipo_bien',      valor => $vtipo_bien,filtro => 'S', visor => 'S'),
              array( campo => 'cuenta',         valor => $vcuenta,filtro => $filtro4, visor => 'S'),
              array( campo => 'uso',            valor => $vuso,filtro => $filtro1, visor => 'S'),
              array( campo => 'id_departamento',valor => $Vid_departamento,filtro => $filtro2, visor => 'S'),
              array( campo => 'tiene_acta',     valor => $vtiene_acta,filtro => $filtro3, visor => 'S')  
              
          );
          
 
          
          $resultado = $this->bd->JqueryCursorVisor('activo.view_bienes',$qquery );
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $id = str_pad($fetch['id_bien'],6,"0",STR_PAD_LEFT);
      	    
      	    $codigo = trim($fetch['tipo_bien']).'-'.trim($fetch['cuenta']).'-'.$id;
      	    
              $codigo =  trim($fetch['cuenta']).'-'.$id;
      	    //BLD.141.01.03-4386

              

              $cadena = str_replace('"', '', trim( $fetch['descripcion']) .' ('.trim( $fetch['codigo_actual']).')');


      	    
		 	$output[] = array (
		      				    $fetch['id_bien'],
		 						$fetch['unidad'],
		      				    $fetch['razon'],
		      				    $cadena ,
		 	                    $codigo,
                		 	    $fetch['tiene_acta'],
                		 	    $fetch['costo_adquisicion'] ,
                                $fetch['serie'] 
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
                $vactivo      = $_GET['vactivo'];
                $vcodigo      = $_GET['vcodigo'];
                
                
                
                $gestion->BusquedaGrilla($vtipo_bien,$vcuenta,$Vid_departamento,$vuso,$vtiene_acta,$vidsede,$vactivo,$vcodigo);
            	 
            }
  
  
   
 ?>
 
  