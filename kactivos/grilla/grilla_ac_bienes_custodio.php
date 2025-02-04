<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';  
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
                $this->sesion 	 =  trim($_SESSION['email']);
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($vcustodio,$vcodigo){
      
      
      
          $len_nombre = strlen(trim($vcustodio));
          $len_bien   = strlen(trim($vcodigo));
          $cadena     = " idprov= '000' ";
 

          if ( $len_nombre >= 4 ){
               $cadena  = "razon like "."'".trim(strtoupper(trim($vcustodio).'%')) ."'";
            }else {
                if ( $len_bien >= 4 ){
                    $cadena  = "idprov like "."'".trim(strtoupper(trim($vcodigo).'%'))."'";
                 } 
            }
 
       
           $sql = "SELECT  idprov, unidad, razon, correo, count(*) as bienes, sum(costo_adquisicion) as costo
           FROM activo.view_custodios
           where ".$cadena."
           group by idprov, unidad, razon, correo";

   
         $resultado= $this->bd->ejecutar($sql);
 
 
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
        
      	    
		 	$output[] = array (
		      				    $fetch['idprov'],
		 						$fetch['unidad'],
		 	                    trim($fetch['razon']),
                                 trim($fetch['correo']),
                 		 	    $fetch['bienes'],
                                  number_format($fetch['costo'],2)  
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
            if (isset($_GET['vcodigo']))	{
            
 
                
                 $vcustodio          = $_GET['vcustodio'];
                 $vcodigo            = $_GET['vcodigo'];
                
                
                $gestion->BusquedaGrilla($vcustodio,$vcodigo);
            	 
            }
  
  
   
 ?>
 
  