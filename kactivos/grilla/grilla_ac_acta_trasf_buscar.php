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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($idprov){
      
          
          
          $cadena = strtoupper(trim($idprov)).'%';
          
          $sql = "SELECT idprov,  razon 
                    FROM activo.view_resumen_custodios
                    where upper(razon) like ".$this->bd->sqlvalue_inyeccion($cadena ,true).'
                    group by idprov,  razon ';

         $resultado  = $this->bd->ejecutar($sql);
          
 
      	 $output = array();
      	
       	while ($fetch=$this->bd->obtener_fila($resultado)){
 
		 	$output[] = array (
 		 						trim($fetch['idprov']),
		      				    trim($fetch['razon']) 
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
            if (isset($_GET['cnombre']))	{
            
 
                $idprov = $_GET['cnombre'];
              	
                 
                
                
                
                $gestion->BusquedaGrilla($idprov);
            	 
            }
  
  
   
 ?>
 
  