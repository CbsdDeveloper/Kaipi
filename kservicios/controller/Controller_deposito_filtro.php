<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
   
      private $obj;
      private $bd;
      private $set;
      
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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $tipo            = $this->bd->retorna_tipo();
        $datos           = array();
        $datos['fecha1'] =  date("Y-m-d");
 
      	
      	$this->obj->text->text('','date','fecha1',10,15,$datos ,'required','','div-0-4') ;
       	
 
           
      
      }
      
}    
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>