<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
  
   //----------------------------------------------
      function principal($idproceso,$id,$codigo,$idtarea){
      
          $tipo = $this->bd->retorna_tipo();
          $resultado = $this->bd->ejecutar("select 0 as codigo , 'Seleccionar destinario' as nombre union
                                            SELECT idusuario as codigo,  completo  || ' ['  || departamento  || ']' as nombre
                                                FROM view_proceso_user
                                                where responsable = 'S'");
            
          
          echo '<h4 align="center"><b>'. strtoupper($id) .'</b><h4><div align="right"> ';
          
          $this->obj->text->text_place('Nro.'.$id,'texto','documento',50,50, $datos ,'','readonly','div-0-12') ;
          echo '</div>';
          
          if (trim($id) =='Oficio'){
               $this->obj->list->listadb_place($resultado,$tipo,'Oficio para','para',$datos,'required','','div-0-12');
               $CADENA ='En su Despacho <br>
                         De mi consideracion...<br><br><br><br>
                         Con sentimientos de distinguida consideracion.<br>
                         Atentamente,<br> ';
               
               echo '<input name="asunto" type="hidden" id="asunto" value="'."Oficio".'">';   
           } 
   
           if (trim($id) =='Memo'){
               $this->obj->list->listadb_place($resultado,$tipo,'Para','para',$datos,'required','','div-0-12');
               $this->obj->text->text_place('Asunto','texto','asunto',80,80, $datos ,'required','','div-0-12') ;
              
          } 
          
          if (trim($id) =='Informe'){
           
              $this->obj->text->text_place('Asunto','texto','asunto',80,80, $datos ,'required','','div-0-12') ;
              
          } 
          
          
          
          echo '<input name="codigoDocId" type="hidden" id="codigoDocId" value="'.$codigo.'">';   
          
          echo '<input name="tipoDoc" type="hidden" id="tipoDoc" value="'.trim($id).'">';   
          
          echo '<input name="codigoProceso" type="hidden" id="codigoProceso" value="'. ($idproceso).'">';   
          
          echo '<input name="idtareaD" type="hidden" id="idtareaD" value="'. ($idtarea).'">';
          
          echo'<h6>&nbsp;</h6>
          <textarea cols="80" id="editor1" name="editor1" rows="5" > '.$CADENA.' </textarea>';
          
          
   }  
     
  
  //-------------------------- 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
 
  
  if (isset($_GET['tipo']))	{
  	
  	
  	$tipo               = $_GET['tipo'];
  	$codigo           = $_GET['codigo'];
  	$idproceso        = $_GET['idproceso'];
  	$idtarea          =  $_GET['idtarea'];
   	
  	$gestion->principal($idproceso, $tipo,$codigo,$idtarea);
  	
  }
 
 ?>
   <script src="../../keditor/ckeditor/ckeditor.js"></script>
 <script>
						CKEDITOR.replace( 'editor1', {
							height: 180,
							width: '100%',
						} );
 </script>
 