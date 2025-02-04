<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_menu_datos_tarea{
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function Controller_menu_datos_tarea( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario($tarea){
      
     
        $datos = $this->bd->query_array(
            'planificacion.sitarea',
            'modulo, tarea,recurso,responsable, fechainicial, fechafinal,enlace_pac,codificado,certificacion', 
            'idtarea='.$this->bd->sqlvalue_inyeccion($tarea,true)." and estado ='S'"
           );
       
     
          $enlace_pac = $datos['enlace_pac'];
          $modulo     = $datos['modulo'];
              
          $datos1 = $this->bd->query_array(
              'adm.adm_pac',
              ' procedimiento ,detalle,regimen ,total,tipo,tipo_proyecto',
              'id_pac='.$this->bd->sqlvalue_inyeccion( $enlace_pac ,true) 
              );
          
          
          $datos['procedimiento'] = $datos1['procedimiento']; 
          $datos['detalle'] = $datos1['detalle'];
          $datos['regimen'] = $datos1['regimen'];
          $datos['tipo'] = $datos1['tipo']; 
          $datos['total'] = $datos1['total'];
          
          
          $datos['idtarea_matriz'] = $tarea;
          $datos['idpac_matriz']   = $enlace_pac;
      
          
          $this->obj->text->editor('Tarea','tarea',3,250,250,$datos,'','readonly','div-2-10');
          $this->obj->text->text_yellow('Fecha Inicio',"date" ,'fechainicial' ,80,80, $datos ,'required','readonly','div-2-4') ;
          $this->obj->text->text_blue('Fecha Final',"date" ,'fechafinal' ,80,80, $datos ,'required','readonly','div-2-4') ;
       
      	 
          $evento = '';
          $this->obj->text->texte('Asignado',"number" ,'codificado' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
          $this->obj->text->texte('Solicitado',"number" ,'certificacion' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
           
          
          $this->obj->text->texto_oculto("idtarea_matriz",$datos); 
          $this->obj->text->texto_oculto("idpac_matriz",$datos); 
          $this->obj->text->texto_oculto("responsable",$datos); 
          $this->obj->text->texto_oculto("modulo",$datos); 
          
          /*
           DETALLE DE MESES DE PAGOS
           */
          $datos2 = $this->bd->query_array(
              'planificacion.sitareadetalle',
              'count(*) as nn ',
              'inicial > 0 and idtarea='.$this->bd->sqlvalue_inyeccion( $tarea ,true)
              );
          
          if ( $datos2['nn'] > 0 ){
               
                              $sqlO1= 'SELECT anio, mes, inicial
                                          FROM planificacion.sitareadetalle
                                          where inicial > 0 and idtarea='.$this->bd->sqlvalue_inyeccion( $tarea ,true).' order by mes';
                              
                              $stmt_ac = $this->bd->ejecutar($sqlO1);
                              
                              
                              $this->set->div_label(12,'Detalle de mensual planificado');
                              
                              while ($x=$this->bd->obtener_fila($stmt_ac)){
                                  
                                  $inicial = $x['inicial'];
                                  $mes     = $x['mes'];
                                  $objeto  = 't_'.$mes ;
                                  
                                  $datos[$objeto] = $inicial;
                                  $evento         = '';
                                  $nmes           = (int)$x['mes'];
                               
                                  $mes_actual = date('m');
                                  
                                   
                                  
                                  $mes_plan = $this->bd->_mes($nmes);
                                  
                                  if ( $mes_actual  ==  $mes  ){
                                      $this->obj->text->text_yellow( $mes.'-'.$mes_plan,"number" ,$objeto ,80,80, $datos ,'required','readonly','div-2-2') ;
                                  }else{
                                      $this->obj->text->text( $mes.'-'.$mes_plan,"number" ,$objeto ,80,80, $datos ,'required','readonly','div-2-2') ;
                                  }
                                  
                                 
                                  
                              }
              
          }
          
          if ( $modulo == 'requerimiento'){
             
              $this->set->div_label(12,' Enlace Compras Publicas');
              
               
              $this->obj->text->editor('Detalle','detalle',3,250,250,$datos,'','readonly','div-2-10');
              
              $this->obj->text->text_yellow('Procedimiento',"texto" ,'procedimiento' ,80,80, $datos ,'required','readonly','div-2-10') ;
              $this->obj->text->text_blue('Regimen',"texto" ,'regimen' ,80,80, $datos ,'required','readonly','div-2-10') ;
              $this->obj->text->text('Tipo',"texto" ,'tipo' ,80,80, $datos ,'required','readonly','div-2-10') ;
              
              
              $this->set->div_label(12,' Ejecución de la actividad tarea');
      
             
              echo '<button type="button" onclick="InicioProceso01()" class="btn btn-danger">INICIAR PROCESO DE EJECUCION</button>';
              
              
          }
           
          if ( $modulo == 'tareas'){

            $this->set->div_label(12,' Ejecución de la actividad tarea');
      
            
            $datos_saldo = $this->bd->query_array('planificacion.sitarea_seg',
                'count(*) as inicio',
                'idtarea='. $this->bd->sqlvalue_inyeccion($tarea,true)
                );
             
            if ( $datos_saldo['inicio'] > 0 ){
                
            }else{
                
                echo '<button type="button" onclick="InicioProceso02()" class="btn btn-danger">INICIAR PROCESO DE EJECUCION</button>';
            }
            
           

          }

          
          
          
     
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
 $gestion   = 	new Controller_menu_datos_tarea;
  
        
   $tarea    = $_GET['tarea'];
     
   $gestion->FiltroFormulario( $tarea);
   

?> 