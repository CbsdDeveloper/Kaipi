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
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
           
      $datos = array();
 
      $tipo = $this->bd->retorna_tipo();
      
       
    
      
      $sql_integra = " SELECT idproducto_ser, producto
      FROM rentas.view_ren_servicios
      where especie = 'N'
      order by 1";
  
         
      $MATRIZ = array(
          '-'    => '--- Seleccione Transaccion ---',
          '1'    => 'Emision-Recaudacion',
          '2'    => 'Recaudacion',
          '3'    => 'Emision',
      );
      
      $this->obj->list->lista('',$MATRIZ,'emite',$datos,'required','','div-0-2');
      
      
      $MATRIZ = array(
          '-'    => '--- Seleccione Tipo ---',
          'A'    => 'A�o Actual',
          'B'    => 'A�o Anterior',
      );
      
      $this->obj->list->lista('',$MATRIZ,'ctipo',$datos,'required','','div-0-2');
      
     
      
      $resultado = $this->bd->ejecutar("select 0 as codigo,' --- Seleccione servicio --- ' as nombre  union ".$sql_integra);
      
    
      $evento = 'OnChange="busca_cuenta(this.value,1)"';
      
      $evento = ' ';
      
      $this->obj->list->listadbe($resultado,$tipo,'servicio','servicio',$datos,'required','',$evento ,'div-0-3');
       
      
      $datos['anio'] = date('Y');
      $this->obj->text->text_blue('',"number",'anio',0,10,$datos,'','','div-0-2') ; 
      
      
      $datos['monto'] = '0.00';
      $this->obj->text->text_blue('',"number",'monto',0,10,$datos,'','','div-0-2') ; 
 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
   
 
   $gestion->FiltroFormulario( );

 ?>


 
  