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
 
                $this->obj     =  new objects;
                
                $this->set     =  new ItemsController;
                   
                $this->bd    =  new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->sesion    =  $_SESSION['email'];
         
 
      }

 /*
 Nombre:        FiltroFromulario
 Detalle:       Construye el formulario de filtro de datos
 Datos entrada: -----------
 Datos salida:  ----------- 
*/
      function FiltroFormulario(){
      
        $datos          = array();

        $anio           = date('Y');
        
        $datos['banio'] = $anio;
       
        $MATRIZ =  $this->obj->array->catalogo_anio();

        $evento =  '';
        
        $this->obj->list->listae('Periodo',$MATRIZ,'banio',$datos,'required','',$evento,'div-3-9');


       	
      	
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>