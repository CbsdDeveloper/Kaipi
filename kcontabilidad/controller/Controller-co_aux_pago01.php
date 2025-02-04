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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                    
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                 
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->anio       =  $_SESSION['anio'];
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
           
           
       $datos = array();
      	
     
      	
      	$this->obj->text->text('Asiento',"number",'d_id_asiento',0,10,$datos,'','readonly','div-2-4') ;
      	
      	$this->obj->text->text('Id.Asiento',"number",'d_id_asientod',0,10,$datos,'','readonly','div-2-4') ;
      	
      	$this->obj->text->text('Cuenta',"texto",'d_cuenta',15,15,$datos,'required','readonly','div-2-4');
      	
      
      	$this->obj->text->text_yellow('Monto',"number",'d_haber',0,10,$datos,'','','div-2-4') ;
      
      	$this->obj->text->text_blue('Parcial',"number",'d_parcial',0,10,$datos,'','','div-2-4') ;
      	
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  