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
      public function BusquedaGrilla($id,$estado){
      
          $user           = $this->departamento_codigo( );
          $anio           = date('Y');
          $responsable    = $user['responsable'];
          $iddepartamento = $user['id_departamento'];
          $limit          = '' ;
    

          $limit  = 'LIMIT 150 ' ;

          
          if ( $estado == '4'){
              $limit  = 'LIMIT  25 ' ;
          }    

       $nmemo = 1;
          
         if ( $estado == '1'){

         
                 
                $unidad_sesion = $this->bd->query_array('flow.view_proceso_caso',
                                                        'count(*) as nn',
                                                        'idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and
                                                        anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                                       sesion = '.$this->bd->sqlvalue_inyeccion($this->sesion,true).' and
                                                       estado = '.$this->bd->sqlvalue_inyeccion($estado,true) 
                );

           

                if (   $unidad_sesion['nn'] >= 1 ){

                         $sql = 'SELECT  idcaso,fecha,sesion,caso, nombre_solicita,fvencimiento, tarea,dias_trascurrido,idprov
                            from flow.view_proceso_caso
                            where idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and
                                anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and
                                modulo_sistema = 'D' AND 
                                sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion,true).' and
                                estado = '.$this->bd->sqlvalue_inyeccion($estado,true).' '.$limit;
                 }else{

                        $unidad_actual = $this->bd->query_array('view_nomina_user',
                        'id_departamento_padre,id_departamento,responsable,orden',
                        "email = ".$this->bd->sqlvalue_inyeccion( trim($this->sesion)  ,true)  
                        );

 
                        if (   trim($unidad_actual['responsable']) == 'S'){
                           
                           $sql = 'SELECT  idcaso,fecha,sesion,caso, nombre_solicita,fvencimiento, tarea,dias_trascurrido,idprov
                            from flow.view_proceso_caso
                            where idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and
                                anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and
                                modulo_sistema = 'D' AND 
                                id_departamento_caso = ".$this->bd->sqlvalue_inyeccion( $unidad_actual['id_departamento'],true).' and
                                estado = '.$this->bd->sqlvalue_inyeccion($estado,true).' '.$limit;

                        }else {
                            $sql = 'SELECT  idcaso,fecha,sesion,caso, nombre_solicita,fvencimiento, tarea,dias_trascurrido,idprov
                            from flow.view_proceso_caso
                            where idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and
                                anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and
                                modulo_sistema = 'D' AND 
                                sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion,true).' and
                                estado = '.$this->bd->sqlvalue_inyeccion($estado,true).' '.$limit;
                        }        
                 }

                 $nmemo = 2;

         }
          
         if ( $estado == '2'){

            $sql = 'SELECT  idcaso,fecha,sesion,caso, nombre_solicita,fvencimiento, tarea,dias_trascurrido,idprov
              from flow.view_proceso_caso
              where idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and
                     anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and
                     modulo_sistema = 'D' AND 
                    sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion,true)." and
                    estado  in ('2','3') ".' '.$limit;

                    $nmemo = 2;
           }
      
           if ( $estado == '3'){
         
                    $sql = 'SELECT   idcasotarea, idproceso, sesion, idtarea, idcaso, novedad, cumple, finaliza, fecha_recepcion, fecha_envio,
                    sesion_actual, sesion_siguiente, unidad, hora_in, hora_fin, ambito, caso, estado, idprov, nombre_solicita,
                    fecha, estado_tramite, anio, mes, dias_tramite, dias_trascurrido
            from flow.view_doc_tarea
            where estado  = '.$this->bd->sqlvalue_inyeccion($estado,true). " and finaliza= 'N' and
                    sesion_actual = ".$this->bd->sqlvalue_inyeccion( $this->sesion ,true);


                    $nmemo = 2;

           }
      
       	

           if ( $estado == '4'){

            $sql = 'SELECT  idcaso,fecha,sesion,caso, nombre_solicita,fvencimiento, tarea,dias_trascurrido,idprov
              from flow.view_proceso_caso
              where idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and
                     anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and
                     modulo_sistema = 'D' AND 
                    sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion,true)." and
                    estado  in ('4','5') ".' '.$limit;

                    $nmemo = 2;
           }


           if ( $estado == '6'){

            $sql = 'SELECT  idcaso,fecha,sesion,caso, nombre_solicita,fvencimiento, tarea,dias_trascurrido,idprov
              from flow.view_proceso_caso
              where idproceso = '.$this->bd->sqlvalue_inyeccion($id,true). ' and
                     anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and
                     modulo_sistema = 'D' AND 
                    sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion,true)." and
                    estado  in ('6' ) ".' '.$limit;
           }
            
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	$output = array();
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
           

                $anovedad = $this->bd->query_array('flow.wk_proceso_casotarea',
                'novedad,sesion_actual',
                "finaliza= 'S' and idcaso = ".$this->bd->sqlvalue_inyeccion( $fetch['idcaso']  ,true) ,
                0,
                'order by fecha_envio desc,idcasotarea desc limit 1'
                );

                $usuario_dato  = $this->bd->__user(trim($anovedad['sesion_actual']));
                $comentario    = '<b>'.trim($usuario_dato['completo']).'</b> - '. trim($anovedad['novedad']) ; 
 

            
           


             $detalle =   trim($fetch['caso']);

            if ( $nmemo == 2) {
                $datos = $this->bd->_memo_caso($fetch['idcaso'],'I');

                $detalle = '<b>'.trim( $datos['documento']).'</b> '. $detalle;
            }
      	    
		 	$output[] = array (
		 			            $fetch['idcaso'],
		      				     $fetch['fecha'],
		 	                     $fetch['nombre_solicita'],
                                  $detalle,
                                 $comentario,
 		 	                     $fetch['dias_trascurrido'],
                                  $fetch['idcasotarea'] ,
                                  $fetch['idproceso'] ,
                                  $fetch['idtarea'] 
		      		
		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
 	}
 
 	//---------------------
 	function departamento_codigo( ){
 	    
 	    
 	    
 	    $Aunidad = $this->bd->query_array('par_usuario',
 	        'responsable,id_departamento',
 	        'email='.$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)
 	        );
 	    
 	    
 	    return $Aunidad;
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
 
  