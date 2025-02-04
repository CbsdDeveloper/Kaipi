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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();

        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
           $datos = array();
          
           $actual = date('Y');
           
           
        
          $MATRIZ = array(
              $actual    => $actual,
              $actual - 1    => $actual - 1,
              $actual - 2    => $actual - 2,
              $actual - 3    => $actual - 3,
              $actual - 4    => $actual - 4
          );
          
          $this->obj->list->lista('Periodo',$MATRIZ,'canio',$datos,'required','','div-2-10');
          
          
          $MATRIZ =  $this->obj->array->catalogo_mes();
          $this->obj->list->lista('Mes',$MATRIZ,'cmes',$datos,'required','','div-2-10');
          
 

         $this->obj->text->text_yellow('Nombre','texto','cnombre',50,50,$datos ,'','','div-2-10') ;

      
        
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  