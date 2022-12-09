<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';  
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
                $this->sesion 	 =  trim($_SESSION['email']);
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($vtipo_bien,$vcustodio,$Vid_departamento,$vactivo,$vidsede,$vcodigo){
      
  
          
          if ( $Vid_departamento == '0'){
              $filtro2 = 'N';
          }else {
              $filtro2 = 'S';
          }
          
          $filtro3 = 'N';
          $filtro1 = 'N';
          
      
          $len_nombre = strlen(trim($vcustodio));
          
         
          
          if ( $len_nombre >= 4 ){
              $filtro1 = 'S';
              $cadena  = "LIKE.%".trim(strtoupper($vcustodio))."%";
            }else {
              $filtro1 = 'N';
           }
          
 
          
          $len_bien = strlen(trim($vactivo));
          
          if ( $len_bien >= 4 ){
              $filtro3 = 'S';
              $cadena1  = "LIKE.%".trim(strtoupper($vactivo))."%";
            }else {
              $filtro3 = 'N';
           }
           $filtro8 = 'S';
           
           $filtro9 = 'S';
           
           if ( $vcodigo >  0){
               $filtro7 = 'S';
               $filtro2 = 'N';
               $filtro1 = 'N';
               $filtro3 = 'N';
               $filtro8 = 'N';
               $filtro9 = 'N';
               
           }else {
               $filtro7 = 'N';
           }
   
           

          
          
          $qquery = array( 
              array( campo => 'id_bien',valor => $vcodigo,filtro =>$filtro7, visor => 'S'),
              array( campo => 'clase',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'vida_util',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'color',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'codigo_actual',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiempo_anio',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'fecha_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idsede',valor => $vidsede,filtro => $filtro8, visor => 'S'),
              array( campo => 'tipo_bien',      valor => $vtipo_bien,filtro => $filtro9, visor => 'S'),
              array( campo => 'id_departamento',valor => $Vid_departamento,filtro => $filtro2, visor => 'S'),
              array( campo => 'razon',         valor => $cadena,filtro => $filtro1, visor => 'S'),
              array( campo => 'busqueda',            valor => $cadena1,filtro => $filtro3, visor => 'S') 
          );
  
          
          $resultado = $this->bd->JqueryCursorVisor('activo.view_bienes',$qquery );
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $tiempo = $fetch['tiempo_anio'].'/'.$fetch['vida_util'];


                   
            $informacion_activo = trim($fetch['descripcion']).'- ('. trim($fetch['codigo_actual']).') '.trim($fetch['estado']).' ' . 
            trim($fetch['color']).' '.trim($fetch['detalle']).' Factura: '.trim($fetch['factura']);
      	    
		 	$output[] = array (
		      				    $fetch['id_bien'],
		 						$fetch['unidad'],
		 	                     trim($fetch['razon']),
		 	                     trim($fetch['clase']),
                                  $informacion_activo ,
                		 	    $fetch['marca'],
                		 	    $fetch['serie'],
                		 	    $fetch['fecha_adquisicion'],
		 	                    $tiempo,
                 		 	    $fetch['costo_adquisicion'] ,
		 	                    trim($fetch['idprov']) 
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
            
 
                
                $vtipo_bien         = $_GET['vtipo_bien'];
                $vcustodio          = $_GET['vcustodio'];
                $Vid_departamento   = $_GET['Vid_departamento'];
                $vactivo            = $_GET['vactivo'];
                $vidsede            = $_GET['vidsede'];
                $vcodigo            = $_GET['vcodigo'];
                
                
                $gestion->BusquedaGrilla($vtipo_bien,$vcustodio,$Vid_departamento,$vactivo,$vidsede,$vcodigo);
            	 
            }
  
  
   
 ?>
 
  