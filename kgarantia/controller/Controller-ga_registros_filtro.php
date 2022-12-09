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
      
          
       $tipo = $this->bd->retorna_tipo();
          
        
       $datos = array();
       
       $evento = '';
     
       $MATRIZ_anio = $this->obj->array->catalogo_anio();

       $MATRIZ_tipo = $this->obj->array->catalogo_tipo_contrato();

       $MATRIZ_obra= $this->obj->array->catalogo_estado_contrato();
       

       $this->obj->list->listae('Periodo',$MATRIZ_anio,'anio1',$datos,'','',$evento,'div-2-4');
	
       $this->obj->list->listae('Tipo',$MATRIZ_tipo,'tipo1',$datos,'','',$evento,'div-2-4');
       	
       $resultado = $this->bd->ejecutar_unidad();     // funcion que trae la informacion de las unidades de la institucion
     
       $this->obj->list->listadb($resultado,$tipo,'Unidad','tiddepartamento1',$datos,'required','','div-2-4');
      	
      	$this->obj->list->lista('Estado',$MATRIZ_obra,'estado1',$datos,'required','','div-2-4');
      	
  
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  