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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->sesion 	 =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
   
        $datos['banio'] = date('Y');

		    $this->obj->text->text_blue('<b>Periodo</b>',"number",'banio',15,15,$datos,'','','div-3-9');

      
      
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>