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
      private $anio;
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
 
                $this->anio     = $_SESSION['anio'];
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($id,$estado){
      
          $iddepartamento = $this->departamento_codigo( );
 
       
          
       	$sql = 'SELECT  idcaso,fecha,sesion,caso, nombre_solicita,fvencimiento, tarea,dias_trascurrido,idprov,secuencia,
             umodificado ,  modificado ,  hmodificado 
                from flow.view_proceso_caso   
                where idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and 
                      id_departamento_caso = '.$this->bd->sqlvalue_inyeccion($iddepartamento,true).' and 
                      anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true). ' and
                      estado = '.$this->bd->sqlvalue_inyeccion($estado,true);
      	
                    
       	
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	$output = array();
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	   // $razon =  $this->bd->__ciu($fetch['idprov']);

             if ( empty( trim($fetch['secuencia']))){
                 $caso = trim($fetch['caso']);
            }else  {
                $caso =  '<b>'.trim($fetch['secuencia']).'</b>-'.trim($fetch['caso']);
      	    } 

             $ultimos =  trim($fetch['umodificado']). ' ('.trim($fetch['modificado']).'-'.trim($fetch['hmodificado']).')';
           

            
		 	$output[] = array (
		 			           $fetch['idcaso'],
		      				    $fetch['fecha'],
		 	                    $fetch['nombre_solicita'],
                                 $caso,
 		 	                    $fetch['dias_trascurrido'],
                                  $ultimos
		      		
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
            
            	 
            	$id= $_GET['idproceso'];
            	
            	$estado= $_GET['estado'];
             	 
            	$gestion->BusquedaGrilla($id,$estado);
            	 
            }
  
  
   
 ?>
 
  