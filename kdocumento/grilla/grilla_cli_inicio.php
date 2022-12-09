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
      public function BusquedaGrilla($tipo,$estado){
      
  
          /*
          '1' => 'Mis Procesos Asignados',
          '2' => 'Procesos Solicitados',
          '3' => 'Procesos de la Unidad'
       */
      	
 
              
              $sql = 'SELECT   idcasotarea, idproceso, sesion, idtarea, idcaso, novedad, cumple, finaliza, fecha_recepcion, fecha_envio,
                               sesion_actual, sesion_siguiente, unidad, hora_in, hora_fin, ambito, caso, estado, idprov, nombre_solicita,
                               fecha, estado_tramite, anio, mes, dias_tramite, dias_trascurrido
                        from flow.view_doc_tarea
                        where estado  = '.$this->bd->sqlvalue_inyeccion($estado,true). " and finaliza= 'N' and
                               sesion_actual = ".$this->bd->sqlvalue_inyeccion( $this->sesion ,true);
              
 
                  
              
              $bandera = 1;
       
   if ($bandera == 1)   {
 
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	$output = array();
      	
      	
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 
      	     /*
       	    
      	    $cadena = 'Avance '.$porcentaje.' % ' ;
      	       
      	    if ($porcentaje < 40  ){
      	        $imagen= '<img src="../../kimages/m_none.png" align="absmiddle" title = "'.$cadena.'" />';
      	    }elseif ($porcentaje > 40 &&  $porcentaje < 75 ){
      	        $imagen= '<img src="../../kimages/m_rojo.png" align="absmiddle" title = "'.$cadena.'" />';
      	    }elseif ($porcentaje > 85 &&  $porcentaje < 95 ){
      	        $imagen= '<img src="../../kimages/m_amarillo.png" align="absmiddle" title = "'.$cadena.'" />';
      	    }elseif ($porcentaje > 95 ){
      	        $imagen= '<img src="../../kimages/m_verde.png" align="absmiddle" title = "'.$cadena.'" />';
      	    } 
      	    */
      	    
		 	$output[] = array (
		 			            $fetch['idcaso'],
		      				    $fetch['fecha'],
		 	                    $fetch['nombre_solicita'],
		 	                    trim($fetch['caso']),
		 	                    trim($fetch['novedad']),
		 	                    '( '.$fetch['dias_trascurrido'].' ) ',
		 	                    $fetch['estado_tramite'],
		 	                    $fetch['idcasotarea'] ,
		 	                    $fetch['idproceso'] ,
		 	                    $fetch['idtarea'] 
		 	    
		 	    
		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
   }
      	
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
            if (isset($_GET['ftipo']))	{
            
            	 
                $tipo   = $_GET['ftipo'];
                $estado = $_GET['festado'];
             	 
                $gestion->BusquedaGrilla($tipo,$estado);
            	 
            }
  
          
   
 ?>
 
  