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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
      	$datos['bgfecha1'] = date('Y-m-d', strtotime('-1 month'));
      	
      	$datos['bgfecha2'] =  date("Y-m-d");
 
      	$this->obj->text->text(' Inicio',"date",'bgfecha1',15,15,$datos,'required','','div-3-9');
      	
      	$this->obj->text->text('Final',"date",'bgfecha2',15,15,$datos,'required','','div-3-9');
      	
      	$MATRIZ = array(
      			'1'    => 'Nivel 1',
      			'2'    => 'Nivel 2',
      			'3'    => 'Nivel 3',
      			'4'    => 'Nivel 4',
      			'5'    => 'Nivel 5',
      	);
      	
      	$this->obj->list->listae('Nivel',$MATRIZ,'nivelg',$datos,'required','','','div-3-9');
 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  