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
      
      	$datos['ffecha1'] =  date('Y-m-d', strtotime("-30 days"));
      	$datos['ffecha2'] =  date("Y-m-d");
      	
      	
      	$datos['qid_asiento'] =  '0';
     
      	
      	$this->obj->text->text('Inicio ',"date",'ffecha1',15,15,$datos,'required','','div-1-3');
      	
      	$this->obj->text->text('Fin ',"date",'ffecha2',15,15,$datos,'required','','div-1-3');
      	
      	$MATRIZ = array(
        		 'aprobado'    => 'Aprobado',
      	         'digitado'    => 'digitado',
      	          'anulado'    => 'Anulado',
      	);
      
      	$this->obj->list->lista('Estado',$MATRIZ,'festado',$datos,'','','div-1-3');
      
 
      
      	$this->obj->text->text_yellow('Asiento',"number",'qid_asiento',0,10,$datos,'','','div-1-3') ;
      	
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  