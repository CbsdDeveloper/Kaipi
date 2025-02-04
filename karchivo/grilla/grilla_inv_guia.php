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
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($festado,$ffecha1,$ffecha2) {
      
 
          $cadena2 = '  fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." 
                                        and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)."   ";
          
          $cadena0 = ' estado = '.$this->bd->sqlvalue_inyeccion($festado,true).' and ';
          
          $cadena1 = ' registro = '.$this->bd->sqlvalue_inyeccion($this->ruc,true).' and ';
      
           
          $where = $cadena0.$cadena1.$cadena2 ;
          
          $sql = 'SELECT cab_codigo,  claveacceso,   fecha,
                         razonsocialtransportista,  dirpartida, fechainitransporte, placa
                from guia_cabecera where '. $where;
          
          
           
          $resultado  = $this->bd->ejecutar($sql);
          
          
          while ($fetch=$this->bd->obtener_fila($resultado)){
              
              $output[] = array (
                  $fetch['cab_codigo'],
                  $fetch['claveacceso'],
                  $fetch['fecha'],
                  $fetch['razonsocialtransportista'],
                  $fetch['dirpartida'],
                  $fetch['fechainitransporte'],
                  trim($fetch['placa']) 
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
    		if (isset($_GET['festado']))	{
    			
    		    $festado  = $_GET['festado'];
    		    $ffecha1  = $_GET['ffecha1'];
    		    $ffecha2  = $_GET['ffecha2'];
    	 		
    		    $gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2);
    			
    		}
    		
    		
    	 
    	 
    		
         
  
  
  
   
 ?>
 
  