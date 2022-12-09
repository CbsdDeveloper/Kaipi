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
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($PK_codigo){
      
 
          $qquery = array( 
              array( campo => 'fid_par_modulo',   valor =>$PK_codigo,  filtro => 'S',   visor => 'S'),
              array( campo => 'id_par_modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'vinculo',   valor => '-',  filtro => 'N',   visor => 'S'),
              array( campo => 'script',   valor => '-',  filtro => 'N',   visor => 'S') ,
              array( campo => 'logo',   valor => '-',  filtro => 'N',   visor => 'S') 
          );
 
          
          
      	$resultado = $this->bd->JqueryCursorVisor('par_modulos',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array ($fetch['id_par_modulo'],
      		                   $fetch['modulo'],
      		                   $fetch['estado'],
      		                   $fetch['vinculo'],
      		                   $fetch['script'] ,
      		                   $fetch['logo'] 
      		    
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
    
   	 
   
   			 //------ consulta grilla de informacion
   			 if (isset($_GET['idmodulo']))	{
   			 
   			 	$PKcodigo      = $_GET['idmodulo'];
   			 
   			 	 
   			 	$gestion->BusquedaGrilla($PKcodigo);
   			 	 
   			 }
 
  
  
   
 ?>
 
  