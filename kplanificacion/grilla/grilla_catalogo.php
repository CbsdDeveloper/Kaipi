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
                $this->sesion 	 =  $_SESSION['login'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($idcatalogo){
      
       
  
      	$qquery = array( 
      			array( campo => 'IDCATALOGODETALLE',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'NOMBRE',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'CODIGO',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'ESTADO',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'FECHAMODIFICA',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'USERMODIFICA',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'IDCATALOGO',   valor => $idcatalogo,  filtro => 'S',   visor => 'N')
       	);
      
      	$resultado = $this->bd->JqueryCursorVisor('SICATALOGODETALLE',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (   $fetch[0], $fetch[1],$fetch[2],$fetch[3],$fetch[4],$fetch[5] 	);
      		
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
    
    		$idcatalogo = $_GET['idcatalogo'];
 
   			 	 
    		$gestion->BusquedaGrilla($idcatalogo);
   			 	 
   	 
  
  
   
 ?>
 
  