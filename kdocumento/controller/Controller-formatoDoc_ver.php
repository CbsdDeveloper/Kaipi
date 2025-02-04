<?php 
session_start();   
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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
  
   //----------------------------------------------
   
      function principal($idcaso){
      
          $tipo_b = $this->bd->retorna_tipo();
          
          $datos = array();
           
          $datos = $this->bd->query_array('flow.wk_proceso_casodoc',
              'idcasodoc,asunto,tipodoc,documento,secuencia',
              'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)." and 
               uso = 'I' and 
               sesion=".$this->bd->sqlvalue_inyeccion( $this->sesion,true)
              );
           
 
            if ( $datos['idcasodoc'] > 0  ){
                $idcasodoc = $datos['idcasodoc'];
                $accion    = 'edit';
            }else{
                $idcasodoc = '0';
                $accion    = 'add';
            }
 
            $datos_c = $this->bd->query_array('flow.view_proceso_caso',  '*',   'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) );     
            
           
          
            $evento1 =  "Ver_secuencia('Memo')";
            $evento2 =  "Ver_secuencia('Circular')";
            $evento3 =  "Ver_secuencia('Oficio')";
            $evento4 =  "Ver_secuencia('Informe')";
            
            echo '<div class="col-md-7" style="padding: 5px"> 
                     <div class="btn-group btn-group-justified">
                          <a href="#" onClick="'.$evento1.'" class="btn btn-primary btn-sm">Memorandum</a>
                          <a href="#" onClick="'.$evento2.'" class="btn btn-success btn-sm">Memorandum Circular</a>
                          <a href="#" onClick="'.$evento3.'" class="btn btn-info btn-sm">Oficio</a>
                          <a href="#" onClick="'.$evento4.'" class="btn btn-warning btn-sm">Informe</a>
                    </div>
                </div>';
                            
            $this->obj->text->text_place('Nro.Documento','texto','documento',50,50, $datos ,'','readonly','div-0-5') ;
            
            $this->set->div_label(12,'<b>Asunto Documento</b>');
            
            if ( empty( $datos['asunto'] )){
                $datos['asunto'] = trim($datos_c['caso'] ) ;
            }
            
            $datos['tipo']           =  trim($datos['tipodoc']);
            $datos['secuencia_dato'] =  trim($datos['secuencia']);
            $datos['tipoDoc']        =  trim($datos['tipodoc']);
            $secuencia_dato          =  trim($datos['secuencia']);
            $tipoDoc                 =  trim($datos['tipodoc']); 
            
            $this->obj->text->text_place('<b>Asunto</b>','texto','asunto',150,150, $datos ,'required','','div-0-12') ;
            
           
            if (empty(trim($tipoDoc))){
                $resultadoPlantilla = $this->bd->ejecutar("select 0 as codigo , 'Plantillas Disponibles' as nombre");
            }else{
                
                $sql1 = "SELECT  id_docmodelo as codigo,  plantilla  as nombre
		                   FROM flow.wk_doc_modelo
						where visor= 'S' and tipo = ".$this->bd->sqlvalue_inyeccion(trim($tipoDoc ),true) ;
                
                $resultadoPlantilla = $this->bd->ejecutar( $sql1);
            }
            
 
          
           $this->set->div_label(12,'Seleccionar plantillas');
           
                    $this->obj->list->listadb_place($resultadoPlantilla,$tipo_b,'Plantilla','plantilla',$datos,'required','','div-0-6');

           
       
          
                    
          echo '<input name="tipo" type="hidden" id="tipo" value="Memo">';
          echo '<input name="casoid" type="hidden" id="casoid" value="'.$idcaso.'">';
          echo '<input name="idcasodoc" type="hidden" id="idcasodoc" value="'.$idcasodoc.'">';
          echo '<input name="secuencia_dato" type="hidden" id="secuencia_dato" value="'.$secuencia_dato.'">';
          echo '<input name="tipoDoc" type="hidden" id="tipoDoc" value="'.$tipoDoc.'">';
          echo '<input name="accion_doc" type="hidden" id="accion_doc"  value="'.$accion.'">';
          
          

 
          
   }  
 
  }
  
 
  
    $gestion   = 	new componente;
 
  
  	$idcaso           = $_GET['idcaso'];
   	
  	
  	$gestion->principal( $idcaso);
  	
 
 
?>