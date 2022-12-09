<?php 
session_start();   
    
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
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");    
  
                $this->anio       =  $_SESSION['anio'];
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
         
       
       $datos = array();
        
       
       $evento = '';
       $this->obj->text->texte('Periodo ',"number",'valor0',0,30,$datos,'required','',$evento,'div-3-9') ; 
       
       $this->obj->text->texte('Var 1 ',"number",'valor1',0,30,$datos,'required','',$evento,'div-3-9') ; 
       $this->obj->text->texte('Var 2 ',"number",'valor2',0,30,$datos,'required','',$evento,'div-3-9') ; 
       
       
       $this->obj->text->texte('Fraccion ',"number",'basico',0,30,$datos,'required','',$evento,'div-3-9') ; 
       $this->obj->text->texte('Excedente ',"number",'excendente',0,30,$datos,'required','',$evento,'div-3-9') ; 
       
      
       $this->obj->text->texto_oculto("action_cata1",$datos); 
       
       $this->obj->text->texto_oculto("id_matriz_cat1",$datos); 
       
    
        
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  