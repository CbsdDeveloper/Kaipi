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
                
          
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
   
      
     function Formulario( ){
      
         $datos = array();
                 
         $tipo = $this->bd->retorna_tipo();
         
                 $MATRIZ = array(
                     'C'    => 'Variable',
                     'L'    => 'Lista Corta',
                     'B'    => 'Lista Catalogo',
                 );
             
                $this->obj->list->lista('Tipo Variable',$MATRIZ,'tipo',$datos,'required','','div-3-9');
         
                $this->obj->text->text('Nombre Variable',"texto",'nombre_variable',50,50,$datos,'required','','div-3-9') ;
                
                $MATRIZ =  $this->obj->array->catalogo_sino();
                
                $this->obj->list->lista('Imprime',$MATRIZ,'imprime',$datos,'required','','div-3-9');
                
                
                $this->obj->text->editor('Lista (,)','lista',3,45,300,$datos,'required','','div-3-9') ;
                
           
                
                $sql = "SELECT '-' as codigo, ' [  0. CATALOGOS DISPONIBLES ] ' as nombre UNION
                        SELECT  tipo as codigo, upper(tipo) as nombre
                        FROM par_catalogo
                        group by tipo
                        order by 2 " ;
                
                $resultado =  $this->bd->ejecutar($sql);
                $this->obj->list->listadb($resultado,$tipo,'Tipo Catalogo','tipo_dato',$datos,'required','','div-3-9');
                
                      
                
         $this->obj->text->texto_oculto("action_variable",$datos); 
         
         $this->obj->text->texto_oculto("idcategoriavar",$datos); 
  
      
   }
 
    
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 
 
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  