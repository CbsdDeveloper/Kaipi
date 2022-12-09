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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
           
      $datos = array();
 
      $tipo = $this->bd->retorna_tipo();
      
       
      $sql = "select 0 as codigo,' --- Seleccione Cuenta --- ' as nombre  union 
                SELECT idproducto_ser as codigo, producto as nombre
                   from rentas.ren_servicios where especie ='S' order by 2";
      
      
      
      $resultado = $this->bd->ejecutar($sql);
     
      $this->obj->list->listadb($resultado,$tipo,'Especie','especie_valor',$datos,'required','','div-0-12');
       
      $datos['monto_especie'] = '0.00';
      $this->obj->text->text_blue('',"number",'monto_especie',0,10,$datos,'','','div-0-6') ; 
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
   
 
   $gestion->FiltroFormulario( );

 ?>


 
  