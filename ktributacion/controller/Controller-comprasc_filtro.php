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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
          
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
       
          $datos = array();
        
          $MATRIZ = $this->obj->array->catalogo_anio();
          
          $this->obj->list->lista('',$MATRIZ,'canio',$datos,'required','','div-0-4');
          
          
          $MATRIZ =  $this->obj->array->catalogo_mes();

          
          $datos['cmes'] = date('m');
          $this->obj->list->lista('',$MATRIZ,'cmes',$datos,'required','','div-0-4');
          
 
        
          $MATRIZ = array(
            'S'    => 'Emitidos',
            'N'    => 'Anulados',
            'X'    => 'Consolidado',
        );
          
          $evento ='';
          $this->obj->list->listae('',$MATRIZ,'estado1',$datos,'required','',$evento,'div-0-4');
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  