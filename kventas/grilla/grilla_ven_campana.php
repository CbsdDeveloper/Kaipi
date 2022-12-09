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
      public function BusquedaGrilla($qpublica,$qmedio,$qzona){
      
          $filtro='S';
          $filtrom='S';
          
         
          if($qmedio == '-'){
              $filtrom='N';
          }
             
      	$qquery = array(
      	    array( campo => 'id_campana',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'titulo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'completo',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
      	    array( campo => 'medio',   valor => $qmedio,  filtro => $filtrom,   visor => 'S'),
      	    array( campo => 'publica',   valor => $qpublica,  filtro => 'S',   visor => 'S'),
       	    array( campo => 'idvengrupo',   valor => $qzona,  filtro => 'S',   visor => 'N')
      	);
      
 
      	
      	$resultado = $this->bd->JqueryCursorVisor('view_ventas_campana',$qquery );
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (  $fetch['id_campana'],
      		                     $fetch['titulo'],
      		                     $fetch['completo']	,
      		                     $fetch['fecha'] ,
                      		     $fetch['medio']  ,
      		                     $fetch['publica']  
      		    
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
 
 
    		if (isset($_GET['qpublica']))	{
 
    		    $qpublica     = $_GET['qpublica'];
    		    $qmedio          = $_GET['qmedio'];
    		    $qzona           = $_GET['qzona'];
    		    
    		    $gestion->BusquedaGrilla($qpublica,$qmedio,$qzona);
    		    
    		}
   			 	 
   	 
  
  
   
 ?>
 
  