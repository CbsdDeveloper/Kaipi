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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($id){
      
 
  
      	
      	$sql = 'SELECT orden,variable,
                       tipo,
                      estado,
                       idproceso_var
                FROM flow.wk_proceso_variables   
                WHERE idproceso = '. $id;
      	
       
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
		 	$output[] = array (
		 			           $fetch['orden'],
		      				    $fetch['variable'],
		 						$fetch['tipo'],
		      				    $fetch['estado'],
		      				    $fetch['idproceso_var']
		      		
		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['id']))	{
            
            	 
            	$id= $_GET['id'];
             	 
            	$gestion->BusquedaGrilla($id);
            	 
            }
  
  
   
 ?>
 
  