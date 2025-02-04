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
      
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
          
 
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");
                
                
                $this->anio       =  $_SESSION['anio'];
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
         $datos = array();
           
         $datos['ffecha1'] = $this->bd->_primer_dia($this->hoy);
         
         $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
           
       	
      	$this->obj->text->text(' Inicio',"date",'ffecha1',15,15,$datos,'required','','div-0-2');
      	$this->obj->text->text(' Final',"date",'ffecha2',15,15,$datos,'required','','div-0-2');
      	
        
      	$MATRIZ = array(
      	    'solicitado'    => 'Solicitado',
      	    'aprobado'    => 'Aprobado',
      	    'anulado'    => 'Anulado',
      	);
      	
      	$this->obj->list->lista('',$MATRIZ,'festado',$datos,'','','div-0-3');
      	
       
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  