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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
       }
 
      //---------------------------------------
      
     function Formulario( ){
      
         $datos = array();
 
         $this->obj->text->text('Referencia',"number" ,'id_spi_para' ,80,80, $datos ,'','readonly','div-2-4') ;
         $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
         $this->obj->text->text('Mes Pago',"texto" ,'mes_pago' ,80,80, $datos ,'required','','div-2-4') ;
         $this->obj->text->text('Referencia',"texto" ,'referencia' ,80,80, $datos ,'required','','div-2-4') ;
         
         $this->obj->text->text('Localidad',"texto" ,'localidad' ,80,80, $datos ,'required','','div-2-10') ;
         $this->obj->text->text('Responsable1',"texto" ,'responsable1' ,80,80, $datos ,'required','','div-2-4') ;
         $this->obj->text->text('Cargo1',"texto" ,'cargo1' ,80,80, $datos ,'required','','div-2-4') ;
         $this->obj->text->text('Responsable2',"texto" ,'responsable2' ,80,80, $datos ,'required','','div-2-4') ;
         $this->obj->text->text('Cargo2',"texto" ,'cargo2' ,80,80, $datos ,'required','','div-2-4') ;
         
         
         $this->obj->text->text('Cuenta BCE',"texto" ,'cuenta_bce' ,80,80, $datos ,'required','','div-2-4') ;
         $this->obj->text->text('Nombre institucion',"texto" ,'empresa' ,80,80, $datos ,'required','','div-2-4') ;
  
 
  
      
   }
  
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  