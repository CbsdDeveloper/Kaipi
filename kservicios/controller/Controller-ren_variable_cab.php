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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");    
  
                $this->anio       =  $_SESSION['anio'];
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
 
       $datos = array();
          
       $this->obj->text->text('Referencia',"texto" ,'id_matriz_var' ,85,85, $datos ,'required','readonly','div-3-9') ;
       
       
       $this->obj->text->text_yellow('Catalogo Matriz',"texto" ,'catalogo' ,150,150, $datos ,'required','','div-3-9') ;
         
 
       $MATRIZ = array(
           'S'    => 'Catalogo Relacionado',
           'N'    => 'Catalogo Variables',
       );
       
       $this->obj->list->lista('Tipo Catalogo',$MATRIZ,'tipo_cat',$datos,'required','','div-3-9');
       
       
       $this->obj->text->texto_oculto("action_cab",$datos); 
       
 
       
      
        
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  