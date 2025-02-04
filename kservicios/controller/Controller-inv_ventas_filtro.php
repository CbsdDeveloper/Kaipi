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
                
                $this->sesion 	 =  trim($_SESSION['email']);
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
           
      $datos = array();
 
       
      //date('Y-m-d', strtotime('-1 month'));
 
       $datos['fecha1'] =  date("Y-m-d");
       $datos['fecha2'] =  date("Y-m-d");
        
     
       $this->obj->text->text('Fecha','date','fecha1',10,15,$datos ,'required','','div-0-2') ;
       
       
       $this->obj->text->text('Fecha','date','fecha2',10,15,$datos ,'required','','div-0-2') ;
        
       
     /*  $MATRIZ = array(
           'F'    => 'Facturacion',
           'E'    => 'Egreso'
        );
       
       $this->obj->list->lista('Tipo',$MATRIZ,'tipo1',$datos,'','','div-2-4');
       
       
        */
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  