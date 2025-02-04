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
      	
        $MATRIZ_A = array(
          '-'  => 'No Aplica',
          'AGREGA'                          => 'AGREGA',
          'APROBACION'                     => 'APROBACIÓN',
          'EDICION'                     => 'EDICIÓN',
          'ACTUALIZACION'              => 'ACTUALIZACIÓN',
          'DIGITADO'                   => 'DIGITADO',
          'ANULADO'                    => 'ANULADO'
          
        
      );
        $MATRIZ_B = array(
          '-'  => 'No Aplica',
          'PRESUPUESTO'               => 'PRESUPUESTO',
          'CONTROL'                     => 'CONTROL',
          'TESORERIA'                 => 'TESORERIA',
          'NOMINA-PRESUPUESTO'          => 'NOMINA-PRESUPUESTO'
          
            
      );


      	$this->obj->list->listae('Accion',$MATRIZ_A,'baccion',$datos,'required','',$evento,'div-3-9');  
      	

        $this->obj->list->listae('Modulo',$MATRIZ_B,'bmodulo',$datos,'required','',$evento,'div-3-9'); 
      	
      
      
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario();

 ?>