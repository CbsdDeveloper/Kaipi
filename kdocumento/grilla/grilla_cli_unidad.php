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
                
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla( ){
      
          
          
               
              $sql = "SELECT   *
                        from nom_departamento
                        where estado = 'S' and nivel > 0  order by orden" ;
              
         
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	$output = array();
      	
      	
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){ 
 
      	    if (  trim($fetch['nivel']) == '1'){ 
      	        $nombre = '<b>'.trim($fetch['nombre']).'</b>';
      	    }else{ 
      	        $nombre = trim($fetch['nombre']);
      	    }
      	    
      	    
		 	$output[] = array (
		 			            '<b>'.trim($fetch['orden']).'</b>',
		 	                    $nombre,
		 	                    trim($fetch['nivel']),
		 	                    trim($fetch['siglas']),
		 	                    $fetch['id_departamento'],
		 	                    $fetch['programa'] 
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
 
   
           
              	 
                $gestion->BusquedaGrilla($idproceso);
            	 
        
          
   
 ?>
 
  