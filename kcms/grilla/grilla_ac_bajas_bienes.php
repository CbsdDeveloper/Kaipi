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
      public function BusquedaGrilla($idsede,$ccustodio,$ccactivo){
      
  
          $filtro3 = 'N';
          $filtro1 = 'N';
          
          
          $len_nombre = strlen(trim($ccustodio));
          
          
          
          if ( $len_nombre >= 4 ){
              $filtro1 = 'S';
              $cadena  = "LIKE.%".trim(strtoupper($ccustodio))."%";
          }else {
              $filtro1 = 'N';
          }
          
          
          
          $len_bien = strlen(trim($ccactivo));
          
          if ( $len_bien >= 4 ){
              $filtro3 = 'S';
              $cadena1  = "LIKE.%".trim(strtoupper($ccactivo))."%";
          }else {
              $filtro3 = 'N';
          }
          
         
          
          $qquery = array( 
              array( campo => 'id_bien',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'detalle',valor => $cadena1,filtro => $filtro3, visor => 'S'),
              array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'serie',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'vida_util',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'tiempo_anio',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'fecha_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
              array( campo => 'razon',valor => $cadena,filtro => $filtro1, visor => 'S'),
               array( campo => 'idsede',     valor => $idsede,filtro => 'S', visor => 'S') 
          );
  
          $resultado = $this->bd->JqueryCursorVisor('activo.view_bienes',$qquery );
 
 
          
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $tiempo = $fetch['tiempo_anio'].'/'.$fetch['vida_util'];
      	    
		 	$output[] = array (
		      				    $fetch['id_bien'],
                		 	    $fetch['detalle'],
                		 	    $fetch['marca'],
                		 	    $fetch['serie'],
		 	                    $fetch['estado'],
		 	                    $fetch['fecha_adquisicion'],
		 	                    $tiempo,
  		      				    $fetch['costo_adquisicion'],
		 	                    $fetch['razon'] 
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
            if (isset($_GET['idsede']))	{
            
 
                $idsede = $_GET['idsede'];
                
                $ccustodio = $_GET['ccustodio'];
                $ccactivo = $_GET['ccactivo'];
                
 
              	 
                $gestion->BusquedaGrilla($idsede,$ccustodio,$ccactivo);
            	 
            }
  
  
   
 ?>
 
  