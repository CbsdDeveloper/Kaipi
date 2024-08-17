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
      public function BusquedaGrilla($vidsede,$vtipo_bien){
      
   
   
        
          
          $qquery = array( 
              array( campo => 'id_bien',valor => $vcodigo,filtro => 'N', visor => 'S'),
              array( campo => 'sede',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'detalle_ubica',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'descripcion',valor => $variable,filtro => 'N', visor => 'S'),
              array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idproveedor',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'codigo_actual',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'proveedor',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'id_tramite',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'idsede',valor => $vidsede,filtro => 'S', visor => 'S'),
              array( campo => 'tipo_bien',      valor => $vtipo_bien,filtro => 'S', visor => 'S'),
              array( campo => 'cuenta',         valor => $vcuenta,filtro => 'N', visor => 'S'),
              array( campo => 'uso',            valor => $vuso,filtro =>'N', visor => 'S'),
              array( campo => 'id_departamento',valor => $Vid_departamento,filtro =>'N', visor => 'S'),
              array( campo => 'tiene_acta',     valor => $vtiene_acta,filtro => 'N', visor => 'S')  
              
          );

          $fecha2 = date('Y-m-d');
          $fecha1 = date("Y-m-d",strtotime($fecha2."- 90 days")); 
  
          $this->bd->__between('fecha_adquisicion',$fecha1,$fecha2);
           
          
          $resultado = $this->bd->JqueryCursorVisor('activo.view_bienes',$qquery  );
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
        

            $descripcion = trim( $fetch['descripcion']). ' '. $fetch['codigo_actual'] ;

                    $output[] = array (
                        $fetch['id_bien'],
                       $fetch['detalle_ubica'],
                        $fetch['razon'],
                        $descripcion,
                        $fetch['serie'],
                    $fetch['fecha'],
                    $fetch['tiene_acta'],
                    $fetch['costo_adquisicion'] ,
                    $fetch['id_tramite'] ,
                    $fetch['factura'] ,
                    $fetch['idproveedor'] ,
                    $fetch['cuenta'] ,

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
            if (isset($_GET['vidsede']))	{
            
   
                $vidsede      = $_GET['vidsede'];
                $vtipo_bien= $_GET['vtipo_bien'];
                
                
                $gestion->BusquedaGrilla( $vidsede ,$vtipo_bien);
            	 
            }
  
  
   
 ?>
 
  