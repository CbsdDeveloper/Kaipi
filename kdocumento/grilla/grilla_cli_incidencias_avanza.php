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
      public function BusquedaGrilla($id, $asunto,  $aquien){
      
          $user = $this->departamento_codigo( );
  
     
          $idproceso      = 21;
          $responsable    = $user['responsable'];
          $iddepartamento = $user['id_departamento'];
        
          $limit  = 'LIMIT  45 ' ;
 
         $anio = date('Y');
          
         $len  = strlen($asunto);

         $len1 = strlen($aquien);

      

         if ( $id > 0 ){

            $sql = 'SELECT  *
            from flow.view_proceso_caso
            where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso,true). ' and
                   anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                   idcaso = '.$this->bd->sqlvalue_inyeccion($id,true).' '.$limit;

        }     else   {

                    if ( $len > 5  ){
                      
                        $asunto = '%'.strtoupper(trim($asunto)).'%';

                        $sql = 'SELECT  *
                        from flow.view_proceso_caso
                        where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso,true). ' and
                                anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                upper(caso) like '.$this->bd->sqlvalue_inyeccion($asunto,true).' '.$limit;


                    }  else  {
                            $asunto = 'NO VALIDA';

                            $sql = 'SELECT  *
                            from flow.view_proceso_caso
                            where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso,true). ' and
                                anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                upper(caso) like '.$this->bd->sqlvalue_inyeccion($asunto,true).' '.$limit;
                        
                    }

                    if ( $len1 > 5  ){
                        
                            $asunto = '%'.strtoupper(trim($aquien)).'%';

                            $sql = 'SELECT  *
                        from flow.view_proceso_caso
                        where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso,true). ' and
                                anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                upper(nombre_solicita) like '.$this->bd->sqlvalue_inyeccion($asunto,true).' '.$limit;

                    }  else   {
                            $asunto = 'NO VALIDA';
                            $sql = 'SELECT  *
                            from flow.view_proceso_caso
                            where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso,true). ' and
                                    anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
                                    upper(nombre_solicita) like '.$this->bd->sqlvalue_inyeccion($asunto,true).' '.$limit;
                    }    

           
        }
        
          
       	
      	$resultado  = $this->bd->ejecutar($sql);
      	
      	
      	$output = array();
 
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
            $comentario =  trim($fetch['novedad']) ;


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
 
 
    	    	$gestion   = 	new proceso;
 
 
            	 
            	$id     = $_GET['iddocaso'];
            	
            	$estado = $_GET['idasunto'];

                $aquien = $_GET['aquien'];
             	 
            	$gestion->BusquedaGrilla($id,$estado, $aquien);
            	 
          
 
   
 ?>
 
  