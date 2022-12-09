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
                $this->bd	   =		new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla(){
      
      // Soporte Tecnico
 
      $codigo = 0;
      	
      $qquery = array(  
                        array( campo => 'id_par_modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'publica',   valor => '-',  filtro => 'N',   visor => 'S') ,
      				   array( campo => 'fid_par_modulo',   valor => $codigo,  filtro => 'S',   visor => 'N')
                        );
      
      
      
      
      $resultado = $this->bd->JqueryCursorVisor('par_modulos',$qquery );                    	       
      
      while ($fetch=$this->bd->obtener_fila($resultado)){
    	        
     	$output[] = array (	$fetch['id_par_modulo'],
     										$fetch['tipo'],
     										$fetch['modulo'],
     										$fetch['estado'],
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
    
    
            $gestion->BusquedaGrilla( );
           
  
  
   
 ?>
 
  