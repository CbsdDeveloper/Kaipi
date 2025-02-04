<?php 
     session_start();   
  
    require '../../kconfig/Db.class.php';    
 	
 	require '../../kconfig/Obj.conf.php';  
    
  
 	class grilla_cli_inicio_id {
 
    
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $usuario;
      private $hoy;
      private $POST;
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function grilla_cli_inicio_id( ){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->usuario 	 =  trim($_SESSION['usuario']);
                
         
                $this->anio     = $_SESSION['anio'];
                
                
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla(  $codigo_tramite ){
      
     
          
          $sql = 'SELECT  idcaso,fecha,sesion,caso, fvencimiento,estado_tramite,
                                        tarea,dias_trascurrido,idprov,idproceso,estado,proceso,idtareactual,secuencia,
                                        umodificado ,  modificado ,  hmodificado 
                                    from flow.view_proceso_caso
                                    where estado  in ('."'2','3','4'". ') and
                                        idtareactual > 1 and 
                                        anio = '.$this->bd->sqlvalue_inyeccion($this->anio,true). " and
                                        tipo_doc = 'proceso' and 
                                        idcaso = ".$this->bd->sqlvalue_inyeccion(  $codigo_tramite,true);
                 
          
       
 
                	$resultado  =  $this->bd->ejecutar($sql);
      	        	$output     =  array();
      	
      	
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
                  	    $razon =  $this->bd->__ciu($fetch['idprov']);
                  	    
                  	    $idproceso    = $fetch['idproceso'] ;
                  	    
                  	    $idtareactual = $fetch['idtareactual'] ;
                  	    
                  	    $z = $this->bd->query_array('flow.view_unidadprocesotarea',
                  	                                'count(*) as nn', 
                  	                                'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true) 
                  	        );
                  	    
                  	
                  	    $x = $this->bd->query_array('flow.proceso_tarea',
                  	        'tarea, condicion',
                  	        'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and 
                             idtarea = '.$this->bd->sqlvalue_inyeccion($idtareactual,true)
                  	        );
                  	    
 
      	    
                  	    $title =   trim($x['tarea']).' - Nro. Tareas '.$z['nn'] ;
                  	    
                  	    $porcentaje = round(($idtareactual/$z['nn']) * 100,2)  ;
      	    
       	    
                  	    if ( $x['condicion'] == 'S' ){
                  	        $numero3 = ' <img src="../../kimages/tab_condicion.png" title = "'.$title.'">';
                  	    }else {
                  	        if ( $idtareactual == 1){
                  	            
                  	            $numero3 = ' <img src="../../kimages/tab_inicio.png" title = "'.$title.'">';
                  	            
                  	        }else{
                  	            if ( $idtareactual == $z['nn']){
                  	                
                  	                $numero3 = ' <img src="../../kimages/tab_fin.png" title = "'.$title.'">';
                  	            }else {
                  	                $numero3 = ' <img src="../../kimages/tab_tarea.png" title = "'.$title.'">';
                  	            }
                  	            
                  	        }
                  	        
                  	    }
      	    
                  	    $cadena1 = $numero3   ;
                  	    
                   	    
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
                  	    
            
                          if ( empty( trim($fetch['secuencia']))){
                            $caso = trim($fetch['caso']);
                       }else  {
                           $caso =  '<b>'.trim($fetch['secuencia']).'</b>-'.trim($fetch['caso']);
                         } 
                  	    
                         $ultimos =  trim($fetch['umodificado']). ' ('.trim($fetch['modificado']).'-'.trim($fetch['hmodificado']).')';
            
            		 	$output[] = array (
            		 			            $fetch['idcaso'],
            		      				    $fetch['fecha'],
            		 	                    $imagen.' '.$razon,
                                            $caso ,
            		 	                    '( '.$fetch['dias_trascurrido'].' ) ',
                                            $fetch['idproceso'],
            		 	                    $fetch['proceso'],
            		 	                    $cadena1,  
                                             $ultimos,
            		 	                    $fetch['idtareactual'],
            		 	                   $fetch['estado_tramite']
            		      		);	 
                  		
                  	}
 
 
 	echo json_encode($output);
      	
 
      	
 }
 
 	//---------------------
 	function departamento_codigo( ){
 	    
 	    
 	    
 	    $Aunidad = $this->bd->query_array('par_usuario',
 	        'id_departamento,tarea',
 	        'email='.$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)
 	        );
 	    
 	    
 	    return $Aunidad ;
 	}
   
 }    
///------------------------------------------------------------------------
 
 
            $gestion   = 	new grilla_cli_inicio_id;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['codigo_tramite']))	{
            
            	 
                $codigo_tramite = $_GET['codigo_tramite'];
             	 
                $gestion->BusquedaGrilla(  $codigo_tramite);
            	 
            }
  
          
   
 ?>