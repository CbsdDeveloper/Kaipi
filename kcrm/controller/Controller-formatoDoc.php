<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
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
      function componente( ){
           
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
  
   //----------------------------------------------
      function principal($idproceso,$id,$codigo,$idtarea,$idcaso){
      
          $tipo = $this->bd->retorna_tipo();
          
          $year = date('Y');
          
          $caso_array = $this->bd->__tramite( $idcaso );
          
          $documento_array = $this->bd->__user_tthh( $caso_array['email_solicita'] );
           
          $doc =  trim($documento_array['siglas']).'-'.$year.'-';
          
 
          
          $datos = $this->bd->query_array('flow.wk_proceso_casodoc',
                                         'documento, asunto, tipodoc, para, de, editor,secuencia',
                                         'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) .' and
                                          idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso,true) .' and
                                          idproceso_docu =  '.$this->bd->sqlvalue_inyeccion($codigo,true)
              );
          
         
          
        
               
              if ( empty($datos['documento']) ){
                  
                  if (trim($id) =='Informe'){
                      $secuencia_dato = $documento_array['informe'] ;
                      $input = str_pad($secuencia_dato, 5, "0", STR_PAD_LEFT);
                      $datos['documento'] = $doc.$input.'-IN';
                   } 
                   
                   if (trim($id) =='Memo'){
                       $secuencia_dato = $documento_array['memo'] ;
                       $input = str_pad($secuencia_dato, 5, "0", STR_PAD_LEFT);
                       $datos['documento'] = $doc.$input.'-ME';
                   } 
                   if (trim($id) =='Notificacion'){
                       $secuencia_dato = $documento_array['notifica'] ;
                       $input = str_pad($secuencia_dato, 5, "0", STR_PAD_LEFT);
                       $datos['documento'] = $doc.$input.'-NO';
                   } 
                   if (trim($id) =='Circular'){
                       $secuencia_dato = $documento_array['circular'] ;
                       $input = str_pad($secuencia_dato, 5, "0", STR_PAD_LEFT);
                       $datos['documento'] = $doc.$input.'-CI';
                   }
                   if (trim($id) =='Oficio'){
                       $secuencia_dato = $documento_array['oficio'] ;
                       $input = str_pad($secuencia_dato, 5, "0", STR_PAD_LEFT);
                       $datos['documento'] = $doc.$input.'-OF';
                   }
              
          } 
          
          //oficio,memo,notifica,,circular
          
          
          
          $resultado = $this->bd->ejecutar("select 0 as codigo , 'Seleccionar destinario' as nombre union
                                            SELECT idusuario as codigo,  completo  || ' ['  || departamento  || ']' as nombre
                                                FROM flow.view_proceso_user
                                                where responsable = 'S'");
            
       
          
          $resultadoPlantilla = $this->bd->ejecutar("select 0 as codigo , 'Plantillas Disponibles' as nombre union
                                            SELECT id_docmodelo as codigo,  plantilla  as nombre
                                                FROM flow.wk_doc_modelo
                                                where tipo ='".$id."'");
          
          
 
       
           $this->obj->text->text_place('Nro.'.$id,'texto','documento',50,50, $datos ,'','','div-0-6') ;
           
        
           $this->set->div_label(12,'Destinatario');
          
          if (trim($id) =='Oficio'){
             
              
               $this->obj->list->listadb_place($resultado,$tipo,'Oficio para','para',$datos,'required','','div-0-12');
               
                
            } 
   
           if (trim($id) =='Memo'){
               $this->obj->list->listadb_place($resultado,$tipo,'Para','para',$datos,'required','','div-0-12');
               
          } 
          
          if (trim($id) =='Informe'){
              $this->obj->list->listadb_place($resultado,$tipo,'Para','para',$datos,'required','','div-0-12');
               
          } 
          
          if (trim($id) =='Notificacion'){
              $this->obj->list->listadb_place($resultado,$tipo,'Para','para',$datos,'required','','div-0-12');
               
          }
          
          $this->set->div_label(12,'Asunto Documento');
          
          $this->obj->text->text_place('Asunto','texto','asunto',80,80, $datos ,'required','','div-0-12') ;
          
          $this->set->div_label(12,'Seleccionar plantillas');
          
          
          $this->obj->list->listadb_place($resultadoPlantilla,$tipo,'Plantilla','plantilla',$datos,'required','','div-0-12');
          
          
          echo '<input name="casoid" type="hidden" id="casoid" value="'.$idcaso.'">';   
          
          echo '<input name="codigoDocId" type="hidden" id="codigoDocId" value="'.$codigo.'">';   
          
          echo '<input name="secuencia_dato" type="hidden" id="secuencia_dato" value="'.trim($secuencia_dato).'">';   
          
          echo '<input name="tipoDoc" type="hidden" id="tipoDoc" value="'.trim($id).'">';   
          
           
          
          echo '<input name="codigoProceso" type="hidden" id="codigoProceso" value="'. ($idproceso).'">';   
          
 
          echo'<h6>&nbsp;</h6>';
          
          
   }  
     
  
  //-------------------------- 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
 
  
  if (isset($_GET['tipo']))	{
  	
  	
  	$tipo             = $_GET['tipo'];
  	$codigo           = $_GET['codigo'];
  	$idproceso        = $_GET['idproceso'];
  	$idtarea          = $_GET['idtarea'];
  	$idcaso           = $_GET['idcaso'];
   	
  	
  	$gestion->principal($idproceso, $tipo,$codigo,$idtarea,$idcaso);
  	
  }
 
?>

 