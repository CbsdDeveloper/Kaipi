<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    
 	
 	require '../../kconfig/Obj.conf.php';  
    
  
    class proceso{
 
    
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $usuario;
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
                
                $this->usuario 	 =  trim($_SESSION['usuario']);
                
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($idproceso,$fecha){
      
          
          
               
              $sql = "SELECT   idcaso, unidad,nombre_solicita,caso,nombre_actual,dias_tramite,estado_tramite
                        from flow.view_proceso_caso
                        where estado in ('1','2','3','4') and 
                              periodo = ".$this->bd->sqlvalue_inyeccion( $fecha ,true)." and
                              idproceso = ".$this->bd->sqlvalue_inyeccion( $idproceso ,true);
              
          
 
 
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	$output = array();
      	
      	
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){ 
 
      	    
      	    
		 	$output[] = array (
		 			           $fetch['idcaso'],
		      				    $fetch['estado_tramite'],
		 	                    trim($fetch['nombre_solicita']),
		 	                    trim($fetch['caso']),
		 	                    $fetch['nombre_actual'],
		 	                    '( '.$fetch['dias_tramite'].' ) ' 
		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
 
      	
 }
 
 	//---------------------
 	function departamento_codigo( ){
 	    
 	    
 	    
 	    $Aunidad = $this->bd->query_array('par_usuario',
 	        'id_departamento',
 	        'email='.$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)
 	        );
 	    
 	    
 	    return $Aunidad['id_departamento'];
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
            if (isset($_GET['idproceso']))	{
            
            	 
                $idproceso   = $_GET['idproceso'];
                
                $fecha = $_GET['fecha'];
              	 
                $gestion->BusquedaGrilla($idproceso,$fecha);
            	 
            }
  
          
   
 ?>
 
  