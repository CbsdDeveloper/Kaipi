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
 
                $this->obj     =  new objects;
                $this->set     =  new ItemsController;
                   
                $this->bd    =  new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion    =  trim($_SESSION['email']);
                
                $this->hoy       =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
        $datos = array();
           
        $evento = '';
       
        
        $tipo = $this->bd->retorna_tipo();

        $datos = array();
           
        $datos['ffecha1'] = date('Y-m-d');
        
        $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
          
        
       $this->obj->text->text('',"date",'ffecha1',15,15,$datos,'required','','div-0-3');
       $this->obj->text->text('',"date",'ffecha2',15,15,$datos,'required','','div-0-3');
        
        $resultado_p = $this->bd->ejecutar("SELECT '' as codigo, ' -- 00.Todos las parroquias -- ' as  nombre   union 
        SELECT nombre as codigo, nombre as nombre from view_parroquias  order by 2" );

 
        
        $this->obj->list->listadb($resultado_p,$tipo,'','bparro',$datos,'',$evento,'div-0-3');


 

        $resultado_t = $this->bd->ejecutar("SELECT '' as codigo ,'-- 01. Toda Emergencia --' as  nombre   union 
          SELECT nombre as codigo, nombre  as nombre from view_tipo_emergencia order by 2 " );
      
  
        $this->obj->list->listadb($resultado_t,$tipo,'','btipo',$datos,'required','','div-0-3');

 
       
       
        
 
        
         
      
      }
      
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   =   new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  