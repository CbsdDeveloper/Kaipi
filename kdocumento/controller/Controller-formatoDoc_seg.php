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
      function principal($idcaso,$accion,$iddoc){
      
          $tipo   = $this->bd->retorna_tipo();
          $evento = ' ';
          $datos  = array();

          $datos          = $this->bd->query_array('flow.wk_proceso_casodoc',  
                                                    '*',  
                                                  'idcaso   ='.$this->bd->sqlvalue_inyeccion($idcaso,true).' and   
                                                   idcasodoc ='.$this->bd->sqlvalue_inyeccion($iddoc,true)   ); 
          
          $datos_proceso  = $this->bd->query_array('flow.wk_proceso_caso', 
                                                   '*', 
                                                  'idcaso   ='.$this->bd->sqlvalue_inyeccion($idcaso,true)  ); 

          $datos["para"]       = trim($datos_proceso["sesion_actual"]);
          $datos["uso"]        = 'E';  
          
      
          $unidad_actual            = $this->bd->query_array('view_nomina_user','*', "email = ".$this->bd->sqlvalue_inyeccion( $this->sesion  ,true) );
          $id_departamento_unidad   = $unidad_actual['id_departamento'] ;


          $sqlde = "SELECT   trim(email) as codigo,completo || ' / ' || cargo as nombre
                        FROM  view_nomina_user
                        WHERE id_departamento =".$this->bd->sqlvalue_inyeccion( $id_departamento_unidad ,true)." order by 2 asc"   ;
 
                        if ( $accion == 'edit'){
                                
                            $datos["secuencia_dato"]        = $datos["secuencia"];
                            $datos["casoid"]                = $idcaso;
                            $datos["tipoDoc"]               = $datos["tipodoc"];
                            $datos["tipo"]                  = $datos["tipodoc"];;
                                
                            $AexisteDe   =  $this->bd->query_array('view_nomina_user','*',
                            "idusuario = ". $this->bd->sqlvalue_inyeccion($datos["de"] ,true) );
                            
                            $datos["de"]       = trim($AexisteDe["email"]);
                            
                            $AexistePara   =  $this->bd->query_array('view_nomina_user','*',
                                "idusuario = ". $this->bd->sqlvalue_inyeccion($datos["para"] ,true) );
                            
                            $datos["para"]       = trim($AexistePara["email"]);
                                
                        }

                        if (empty( $datos["asunto"])){
                            $datos["asunto"] = 'EN RESPUESTA A';
                        }
                        
                         
              
                        $evento1  = "DocumentoUsuario('Memo')";
                        $evento3 = "DocumentoUsuario('Oficio')";
                        $evento4  =  "DocumentoUsuario('Informe')";
                        
                        echo ' <div class="col-md-7" style="padding: 5px">
                                 <div class="btn-group btn-group-justified">
                                      <a href="#" onClick="'.$evento1.'" class="btn btn-primary btn-sm">Memorandum</a>
                                      <a href="#" onClick="'.$evento3.'" class="btn btn-info btn-sm">Oficio</a>
                                      <a href="#" onClick="'.$evento4.'" class="btn btn-warning btn-sm">Informe</a>
                                </div>
                     </div>';
                
                $this->obj->text->text_place('Nro.Documento','texto','documento',50,50, $datos ,'','readonly','div-0-4') ;   
               
                $this->set->div_label(12,'<b>De / Para</b>');

                  $resultado    = $this->bd->ejecutar($sqlde);
                  $evento       = '';
                  $datos["de"]  = trim(  $this->sesion );
                  $this->obj->list->listadbe($resultado,$tipo,'De a','de',$datos,'required','',$evento,'div-0-6');
                  
                 $evento='';
                 $this->obj->list->listadbe_uni_responsables_para($this->bd,'<b>Asignar a</b>','para',$datos,'required','',$evento,'div-0-6');

              
          //------------------------------------------------------------------
          $this->set->div_label(12,'Seleccionar plantillas');
           
                  if (empty(trim($datos['tipodoc']))){
                      $resultadoPlantilla = $this->bd->ejecutar("select 0 as codigo , 'Plantillas Disponibles' as nombre");
                  }else{
                      
                      $sql1 = "SELECT  id_docmodelo as codigo,  plantilla  as nombre
        		                   FROM flow.wk_doc_modelo
        						where visor= 'S' and tipo = ".$this->bd->sqlvalue_inyeccion(trim( $datos["tipo"]  ),true) ;
                      
                      $resultadoPlantilla = $this->bd->ejecutar( $sql1);
                  }
    
                    $this->obj->list->listadb_place($resultadoPlantilla,$tipo,'Plantilla','plantilla',$datos,'required','','div-0-6');
                    
                    
                    
    
           $this->set->div_label(12,'<b>Asunto Documento</b>');
          
                    $this->obj->text->text_place('Asunto','texto','asunto',150,150, $datos ,'required','','div-0-12') ;
          

          $this->obj->text->texto_oculto("tipo",$datos); 
          $this->obj->text->texto_oculto("casoid",$datos); 
          $this->obj->text->texto_oculto("uso",$datos); 
          $this->obj->text->texto_oculto("secuencia_dato",$datos); 
          $this->obj->text->texto_oculto("tipoDoc",$datos); 
          
 
          
   }  
     
  
   }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
 
 
 
  	$idcaso           = $_GET['idcaso'];
  	
  	$accion           = $_GET['accion'];
   	
  	$iddoc           = $_GET['iddoc'];
  	
  	
  	
  	$gestion->principal( $idcaso,$accion,$iddoc);
  	
 
 
?>

 