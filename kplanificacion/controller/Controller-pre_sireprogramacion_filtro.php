<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      private $obj;
      private $bd;
      private $set;
      
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
      
                $this->sesion 	 =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          $datos = array();
           
          $MATRIZ_A = array(
            'digitado'   => 'Digitado',
            'aprobado'   => 'Aprobado',
            'anulado'    => 'Anulado',
            );

          $MATRIZ_B = array(
            'Tiempo'              => 'Tiempo',
            'Traslado'            => 'Traslado',
            'Nuevas actividades'  => 'Nuevas actividades' 
            );
       
    		  $this->obj->text->text_dia('Inicio',"text",'bfechainicio',15,15,$datos,'','','div-3-9');

          $this->obj->text->text_dia('Fin',"text",'bfechafin',15,15,$datos,'','','div-3-9');
         
          $this->obj->list->lista('Estado',$MATRIZ_A,'bestado',$datos,'','','div-3-9');

          $this->obj->list->lista('Tipo',$MATRIZ_B,'btipo',$datos,'','','div-3-9');

         

      
      
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>