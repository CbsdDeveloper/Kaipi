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
       
        
       $MATRIZ = array(
           '-'    => '--- Ver Todos ---',
           'enviado'    => 'enviado',
           'digitado'    => 'digitado',
           'aprobado'    => 'aprobado',
           'cierre'    => 'cierre',
        );
       
            
       $date_now = date('Y-m-d');
       
       $fecha = strtotime('-60 day', strtotime($date_now));
       
       $fecha = date('Y-m-d', $fecha);
       
       $datos['ffecha1'] =  $fecha;
       
       $datos['ffecha2'] =  $this->hoy;
       

       $this->obj->list->lista('',$MATRIZ,'festado',$datos,'required','','div-0-4');
       
       $this->obj->text->text('',"date",'ffecha1',15,15,$datos,'required','','div-0-3');
       
       $this->obj->text->text('',"date",'ffecha2',15,15,$datos,'required','','div-0-3');
       

       $this->obj->text->text_place('Busqueda Contribuyente','texto','nombrec',120,120,$datos ,' ','','div-0-4') ;

       $this->obj->text->text_place('Busqueda Identificacion','texto','ruc',120,120,$datos ,' ','','div-0-3') ;
    
    
       
       $this->obj->text->texto_oculto("frubro",$datos); 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  