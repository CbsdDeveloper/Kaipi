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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->sesion    =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $datos = array();
           
        $evento = '';
          
      	$MATRIZ =  $this->obj->array->catalogo_activo();

        $tipo   = $this->bd->retorna_tipo();
      	
       

     /*$resultado =$this->bd->
     ejecutar("SELECT 0 as codigo, '-- 00.Todos los modulos --' as  nombre   union SELECT id_par_modulo as codigo, modulo from par_modulos  where fid_par_modulo=0  order by 2 ");*/

     $resultado =$this->bd->
     ejecutar("SELECT '' as codigo, '-- 00.Todos los modulos --' as  nombre   union SELECT modulo as codigo, modulo from par_modulos  where fid_par_modulo=0  order by 2 ");


      	$this->obj->list->listadb($resultado,$tipo,'Modulo','bmodulo',$datos,'required','','div-3-9'); // lista dinamica con busqueda de modulos
         
      	
      
      
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>