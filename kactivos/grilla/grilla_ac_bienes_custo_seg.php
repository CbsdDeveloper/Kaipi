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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($vcustodio,$vcodigo){
      
      
      
          $len_nombre = strlen(trim($vcustodio));
          $len_bien   = strlen(trim($vcodigo));
         
          $filtro1 = 'N';
          $filtro2 = 'N';


          if ( $len_nombre >= 4 ){
              $filtro1 = 'S';
              $cadena  = "LIKE.%".trim(strtoupper(trim($vcustodio).'%'));
            }else {
              $filtro1 = 'N';
           }
           
        
          
          if ( $len_bien >= 4 ){
              $filtro2 = 'S';
              $cadena2  = "LIKE.%".trim(strtoupper(trim($vcodigo).'%'));
            }else {
              $filtro2 = 'N';
           }

         
          
          $qquery = array( 
              array( campo => 'id_bien',valor => '-',filtro =>'N', visor => 'S'),
              array( campo => 'clase',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'color',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'codigo_actual',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'material',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'vida_util',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiempo_anio',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'fecha_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idprov',valor => $cadena2 ,filtro => $filtro2, visor => 'S'),
              array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tipo_bien',      valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'razon',         valor => $cadena,filtro => $filtro1 , visor => 'S'),
              array( campo => 'detalle',            valor => '-',filtro => 'N', visor => 'S') 
          );
  
          
          $resultado = $this->bd->JqueryCursorVisor('activo.view_bienes',$qquery);
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $tiempo = $fetch['tiempo_anio'].'/'.$fetch['vida_util'];

       	    
            $detalle = trim( $fetch['descripcion']). ' '.trim( $fetch['color']) .' ('. $fetch['codigo_actual'].') Factura: '.trim($fetch['factura']).' '.trim($fetch['detalle'])  .' '. trim($fetch['material']);


		 	$output[] = array (
		      				    $fetch['id_bien'],
		 						$fetch['unidad'],
		 	                    trim($fetch['clase']),
                                $detalle ,
                                trim($fetch['marca']),
                                trim($fetch['serie']),
                		 	    $fetch['fecha_adquisicion'],
		 	                    $tiempo,
                 		 	    $fetch['costo_adquisicion'] ,
		 	                    trim($fetch['tipo_bien']) 
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
            if (isset($_GET['vcodigo']))	{
            
 
                
                 $vcustodio          = $_GET['vcustodio'];
                 $vcodigo            = $_GET['vcodigo'];
                
                
                $gestion->BusquedaGrilla($vcustodio,$vcodigo);
            	 
            }
  
  
   
 ?>
 
  