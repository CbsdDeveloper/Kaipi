<?php 
session_start();   
  
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
      public function BusquedaGrilla($bparro,$btipo,$ffecha1,$ffecha2){
      
 

        $cadena2 = '(  fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
        $cadena01  = '';
        $cadena02  = '';
        
    
        if ( strlen($bparro) > 4){
            $cadena01 =  '( parroquia = '.$this->bd->sqlvalue_inyeccion(trim($bparro),true).')  and ';
        }

        if ( strlen($btipo) > 4){
            $cadena02 =  '( tipo_de_emergencia = '.$this->bd->sqlvalue_inyeccion(trim($btipo),true).')  and ';
        }

          $where = $cadena01.$cadena02. $cadena2 ;
      	
      	$sql = 'SELECT  fecha,secuencia ,parroquia,descripcion_emergencia,
                       tipo_de_emergencia, estado_tramite,fecha_emergencia ,hora_aviso,usuario   ,id,idproceso
          FROM bomberos.view_emergencias where '. $where;
      	
 
          $resultado  = $this->bd->ejecutar($sql);
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	   
      	    
		 	$output[] = array (
		      				 $fetch['fecha'],
                            $fetch['secuencia'],
                            $fetch['parroquia'],
                            $fetch['descripcion_emergencia'],
                            $fetch['tipo_de_emergencia'],
                            $fetch['estado_tramite'],
                            $fetch['fecha_emergencia'] ,
                            $fetch['hora_aviso'],
                            $fetch['usuario'],
                            $fetch['id'],
                            $fetch['idproceso']
                            
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
            if (isset($_GET['bparro']))	{
            
            	 
                $bparro   = $_GET['bparro'];
                $btipo    = $_GET['btipo'];
                
                $ffecha1= $_GET['ffecha1'];
            	$ffecha2= $_GET['ffecha2'];
                
                
                $gestion->BusquedaGrilla($bparro,$btipo,$ffecha1,$ffecha2);
            	 
            }
  
  
   
 ?>
 
  