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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               
      }
       //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){
      
 
 
                     
                $tipo = $this->bd->retorna_tipo();
                
                  
                $this->set->div_panel6('<b> INFORMACION ACTUAL </b>');
                               
                
                 
                $this->obj->text->text(' ',"texto",'usuario',90,95,$datos,'','readonly','div-1-11') ;
                   
                
                $this->obj->text->text('','number','nro_actual',10,10, $datos ,'','readonly','div-1-11') ;
                
                echo '<p>&nbsp;</p><p>Esta opcion permite re-asignar contactos a los usuarios con el perfil de ventas para personalizar la gestion de preventa</p>';    
               
                $this->set->div_panel6('fin');
                
                 
                
                $this->set->div_panel6('<b> PROCESO DE RE ASIGNACION DE CONTACTOS</b>');
                
                $resultado =$this->bd->ejecutar("select 0 as codigo, 'No requiere parametros' as nombre");
                
                $this->obj->list->listadb($resultado,$tipo,'Asignar a','idusuario_para',$datos,'','','div-2-10');
                
                
                $this->obj->text->text('Trasladar','number','numero',10,10, $datos ,'required','','div-2-10') ;
                
                echo '<p>&nbsp;</p><p>Ingrese la cantidad de contactos que desea asignar al usuario con el perfil de ventas (La informacion se genera aleatoriamente de acuerdo a la cantidad solicitada) </p>';    
                
                
                echo '<div id="Asignarcta"></div>';
                
             
                
                
                $this->set->div_panel6('fin');
                
   
   }
 
   
    
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  