<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_ver_tarea{
 
  
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
      function Controller_ver_tarea( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario($tarea,$idtarea_seg,$idtarea_segcom){
      
          
          $datos = array();
          
          
       
          $datos = $this->bd->query_array(
              'planificacion.sitarea_seg_com',
              '*',
              'idtarea_segcom='.$this->bd->sqlvalue_inyeccion($idtarea_segcom,true)
              );
          

          
          $secuencia = $datos['secuencia'] + 1;
           
          $input = str_pad($secuencia, 2, "0", STR_PAD_LEFT);
          
          $this->obj->text->editor('PROCESO ACTUAL','proceso_tarea',3,250,250,$datos,'','readonly','div-2-10');
          
          $this->obj->text->editor('COMENTARIO','comentario_dato',3,250,250,$datos,'','','div-2-10');
          
          
          $datos_prox = $this->bd->query_array(
              'planificacion.sitarea_seg_com',
              '*',
              'idtarea_seg='.$this->bd->sqlvalue_inyeccion($idtarea_seg,true). ' and 
               secuencia='.$this->bd->sqlvalue_inyeccion($input,true)
              );
          
          
          $datos['proceso_tarea_next'] = $datos_prox['proceso_tarea'];
          
          $datos['secuencia_next'] =   $input;
          
          $datos['idtarea_segcom_next'] = $datos_prox['idtarea_segcom'];
          
          
          $this->obj->text->text_blue('Proximo Evento',"texto" ,'proceso_tarea_next' ,80,80, $datos ,'required','readonly','div-2-10') ;
          
          $this->obj->text->texto_oculto("secuencia_next",$datos);
          
          $this->obj->text->texto_oculto("idtarea_segcom_next",$datos); 
         
        
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
 $gestion   = 	new Controller_ver_tarea;
  
        
   $tarea           = $_GET['idtarea1'];
   $idtarea_seg     = $_GET['idtarea_seg'];
   $idtarea_segcom  = $_GET['idtarea_segcom'];
     
   $gestion->FiltroFormulario( $tarea,$idtarea_seg,$idtarea_segcom);
   
   
 

?> 