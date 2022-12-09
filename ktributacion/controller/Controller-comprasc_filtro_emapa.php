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
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
       
        
          $MATRIZ = array(
              '2018'    => '2018',
              '2017'    => '2017',
              '2016'    => '2016'
          );
          
          $this->obj->list->lista('Año',$MATRIZ,'canio',$datos,'required','','div-2-10');
          
          
          $MATRIZ =  $this->obj->array->catalogo_mes();
          $this->obj->list->lista('Mes',$MATRIZ,'cmes',$datos,'required','','div-2-10');
          
 
          
          $MATRIZ = array(
              '-'    => '[Todos los comprobantes]',
              'enviada'  => 'Enviadas',
              'isnull'    => 'Sin Enviar'
          );
          
          $this->obj->list->lista('Estado',$MATRIZ,'cestado',$datos,'required','','div-2-10');
      
          echo '<h6> &nbsp; </h6>';
          
          
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  