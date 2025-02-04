<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';    
 	
    require '../../kconfig/Obj.conf.php'; 
    
    require '../../kconfig/Set.php'; 
  
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
      
      	$datos['ffecha1'] =  date('Y-m-d', strtotime("-15 days"));
      	
      	
      	$datos['ffecha2'] =  date("Y-m-d");
      	
     
      	
      	$this->obj->text->text_yellow(' Inicio',"date",'ffecha1',15,15,$datos,'required','','div-1-2');
      	
      	$this->obj->text->text_yellow(' Final',"date",'ffecha2',15,15,$datos,'required','','div-1-2');
      	
      	
      	$MATRIZ = array(
      	    '1'    => 'Por Depositar',
      	    '2'    => 'Cierre Caja Bancos' 
      	);
      
      	$this->obj->list->lista('Transaccion',$MATRIZ,'festado',$datos,'','','div-1-2');
      
 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  