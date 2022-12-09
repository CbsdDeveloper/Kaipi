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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($GET){
      
      
          $ffecha1 = $GET['ffecha1'];
          $ffecha2 = $GET['ffecha2'];
          $festado = $GET['festado'];
          $frubro  = $GET['frubro'];
          
          $ruc     = trim($GET['ruc']);
          $nombrec = strtoupper(trim($GET['nombrec']));
 
          $longitud1 = strlen($ruc);
          $longitud2 = strlen($nombrec);
          
          
 
              $cadena0 =  '( estado = '.$this->bd->sqlvalue_inyeccion(trim($festado),true).') and ';
   
        
      
        
        
        
        $cadena1 = '( id_rubro ='.$this->bd->sqlvalue_inyeccion(trim($frubro),true).") and ";

      	$cadena2 = '( fecha_inicio BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
      	$where = $cadena0.$cadena1.$cadena2;
      	
      	if ( $longitud1 > 3 ){
              
      	    $cadena0 =  " estado <> 'cierre'  and ( trim(idprov) like ".$this->bd->sqlvalue_inyeccion(trim($ruc).'%',true).")  ";
      	    $where = $cadena1.$cadena0;
      	}
      	
      	if ( $longitud2 > 3 ){
               $cadena0 =  " estado <> 'cierre'  and ( trim(razon) like ".$this->bd->sqlvalue_inyeccion(trim($nombrec).'%',true).")  ";
      	    $where = $cadena1.$cadena0;
      	}
      	
      	
      	$sql = 'SELECT id_ren_tramite,fecha_inicio, idprov,razon, detalle,  login,estado   
                from rentas.view_ren_tramite   where '. $where;
 
 
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
  
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
  
      	    
      	    $detalle =  trim($fetch['detalle']);
      	    
      	    $razon   =  trim($fetch['razon']);
      	    
      	    if ( trim($fetch['estado']) == 'aprobado'){
      	        $razon = '<b>≡ '. trim($fetch['razon'].'</b>');
      	    }
      	 
      	    
 	          $output[] = array (
      				    $fetch['id_ren_tramite'],
 						$fetch['fecha_inicio'],
  	                    $razon,
 	                    $detalle,
         	              $fetch['login'] 
        		);	 
      		
      	}
 
 
      	pg_free_result($resultado);
      	
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
            if (isset($_GET))	{
            
 
             	 
                $gestion->BusquedaGrilla($_GET);
            	 
            }
  
  
   
 ?>
 
  