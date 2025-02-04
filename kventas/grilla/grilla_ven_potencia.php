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
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($vid_campana,$vsector,$vestado,$vmedio){
      
          
          $AResponsable = $this->bd->query_array('par_usuario',
                                               'responsable', 
                                               'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
              );
          
          
          $filtro_user = 'N';
          if ($AResponsable['responsable'] == 'N'){
              $filtro_user = 'S';
          }
          
          
          $filtro1 = 'S';
          $filtro2 = 'S';
          $filtro3 = 'S';
           
          if ( $vsector == '-' ){
              $filtro1 = 'N';
          }
          
          if ( $vestado == '-' ){
              $filtro2 = 'N';
          }
          
          if ( $vmedio == '-' ){
              $filtro3 = 'N';
          }
          
      		 
  
      	$qquery = array(
      	    array( campo => 'idvencliente',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'estado',   valor => $vestado,  filtro => $filtro2,   visor => 'N'),
      	    array( campo => 'canton',   valor => $canton,  filtro => $filtro1,   visor => 'N'),
      	    array( campo => 'medio',   valor => $vmedio,  filtro => $filtro3,   visor => 'N'),
      	    array( campo => 'id_campana',   valor => $vid_campana,  filtro => 'S',   visor => 'N'),
      	    array( campo => 'sesion',   valor => $this->sesion,  filtro =>$filtro_user,   visor => 'N'),
      	);
      
      	 
      	
      	
      	$resultado = $this->bd->JqueryCursorVisor('ven_cliente',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (  $fetch['idvencliente'],
      		                     $fetch['razon'],
      		                     $fetch['direccion']	,
      		                     $fetch['telefono'] ,
                      		     $fetch['correo']  
      		    
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
 
 
    		if (isset($_GET['vid_campana']))	{
    		    
    		    
    		    $vid_campana     = $_GET['vid_campana'];
    		    $vsector         = $_GET['vsector'];
    		    $vestado         = $_GET['vestado'];
    		    $vmedio         = $_GET['vmedio'];
    		    
    		    $gestion->BusquedaGrilla($vid_campana,$vsector,$vestado,$vmedio);
    		    
    		}
  
  
   
 ?>
 
  