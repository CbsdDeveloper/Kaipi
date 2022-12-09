<?php 
    session_start();   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php';   /*Incluimos el fichero de la clase objetos*/
    require '../../kconfig/Set.php';        /*Incluimos el fichero de la clase objetos*/
    
    /**
     Clase contenedora para la creacion del formulario de busquedas
     @return
     **/
    
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
      /**
       Constructor de la clase  del formulario de busquedas
       @return
       **/ 
      function componente(){
  
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
         
 
      }
      /**
      Funcion para creacion del formulario de filtro de busquedas dinamicas
      @return  
      **/
      function FiltroFormulario(){
      
        $datos = array();
           
        $evento = '';
          
      	$MATRIZA =  $this->obj->array->catalogo_activo();
      	$MATRIZB =  $this->obj->array->catalogo_naturaleza();
      	
      	$this->obj->list->listae('Estado',$MATRIZA,'bestado',$datos,'required','',$evento,'div-3-9');
       	
      	$this->obj->text->text_blue('Contribuyente',"texto",'crazon',15,15,$datos,'','','div-3-9');
      	
      	$this->obj->text->text_yellow('Identificacion',"texto",'ccedula',15,15,$datos,'','','div-3-9');
       
      	$this->obj->list->lista('Naturaleza',$MATRIZB,'bnaturaleza',$datos,'required','','div-3-9');
       
      	$resultado =$this->bd->ejecutar("select 0 as codigo, '[ Todas las ciudades ]' as nombre   union
                                         select idcatalogo as codigo, nombre
            			                     from par_catalogo
            								where tipo = 'canton' and publica = 'S' order by 2 ");
      	
      	$tipo = $this->bd->retorna_tipo();
      	
      	$this->obj->list->listadb($resultado,$tipo,'Ciudad','bidciudad',$datos,'required','','div-3-9');
 
       
      }

}    

//------------------------------------------------------------------------
// Llama de la clase para creacion de formulario de busqueda
//------------------------------------------------------------------------

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>