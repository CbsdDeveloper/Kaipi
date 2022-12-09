<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
                
                $this->sesion 	 =  $_SESSION['email'];
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
       $tipo = $this->bd->retorna_tipo();
          
          
       $anio = date("Y"); 
       
 
       $datos['fecha1'] =  date('Y-m-d', strtotime('-1 month'));
       $datos['fecha2'] =  date("Y-m-d");
       
     
       $this->obj->text->text('Inicio','date','fecha1',10,15,$datos ,'required','','div-2-4') ;
       $this->obj->text->text('Hasta','date','fecha2',10,15,$datos ,'required','','div-2-4') ;
       
       
       $MATRIZ = $this->obj->array->inven_tipo();
       $this->obj->list->lista('Tipo',$MATRIZ,'tipo1',$datos,'','','div-2-10');
       
       
 
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  