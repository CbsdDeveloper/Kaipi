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
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($GET){
      
      
          $ffecha1 = $GET['ffecha1'];
          $ffecha2 = $GET['ffecha2'];
 
          
          $ruc     = trim($GET['ruc']);
          $nombrec = strtoupper(trim($GET['nombrec']));
 
          $longitud1 = strlen($ruc);
          $longitud2 = strlen($nombrec);
          
       	  $cadena2 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	  $where = $cadena2;
      	
      	if ( $longitud1 > 3 ){
      	    $cadena0 =  '( idprov like '.$this->bd->sqlvalue_inyeccion(trim($ruc).'%',true).')   ';
      	    $where = $cadena0;
      	}
      	
      	if ( $longitud2 > 3 ){
      	    $cadena0 =  '( razon like '.$this->bd->sqlvalue_inyeccion(trim($nombrec).'%',true).')  ';
      	    $where = $cadena0;
      	}
      	
      	
      	$sql = 'SELECT id_ren_baja,fecha, idprov,razon, resolucion,  sesion   ,usuario,tipo_baja
                from rentas.view_ren_baja   where '. $where;
 
      	$resultado  = $this->bd->ejecutar($sql);
         	
      	while ($fetch=$this->bd->obtener_fila($resultado) ){
  
      	    $detalle =  trim($fetch['resolucion']).' MOTIVO: '.trim($fetch['tipo_baja']);
       	    
 	          $output[] = array (
      				    $fetch['id_ren_baja'],
 						$fetch['fecha'],
						$fetch['idprov'],
       				    trim($fetch['razon']),
 	                    $detalle,
         	              $fetch['usuario'] 
        		);	 
      		
      	}
 
 
        pg_free_result($resultado);
      	
        echo json_encode($output);
      	
      	
      	}
 
   
 }    
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
 
    		$gestion   = 	new proceso;
        
             if (isset($_GET))	{
  
                 $gestion->BusquedaGrilla($_GET);
            	 
            }
  
  
   
 ?>
 
  