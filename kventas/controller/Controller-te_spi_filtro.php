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
      private $anio;
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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =     date("Y-m-d");    
  
                $this->anio       =  $_SESSION['anio'];
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $tipo = $this->bd->retorna_tipo();
       
       $datos = array();
    
       $datos['ffecha1'] =  $this->bd->_primer_dia($this->hoy);
       $datos['ffecha2'] =  $this->hoy;
       
       
       $this->obj->text->text('',"date",'ffecha1',15,15,$datos,'required','','div-0-2');
       
       $this->obj->text->text('',"date",'ffecha2',15,15,$datos,'required','','div-0-2');
       
       $MATRIZ = array(
           'digitado'    => 'digitado',
           'enviado'    => 'enviado',
           'aprobado'    => 'aprobado'
       );
       $this->obj->list->lista('',$MATRIZ,'festado',$datos,'required','','div-0-2');
      
       
       $resultado = $this->bd->ejecutar("select '' as codigo, '[ Seleccione Cuenta - Bancos ]' as nombre  union
                                                    select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								        from co_plan_ctas
                                                           where univel = 'S' and
                                                                  anio = " . $this->bd->sqlvalue_inyeccion( $this->anio  ,true)." and
                                                                  registro = " . $this->bd->sqlvalue_inyeccion( $this->ruc     ,true)." and
                                                                  tipo_cuenta = 'B' order by 1"
           );
       
       
       $this->obj->list->listadb($resultado,$tipo,'','fcuenta',$datos,'required','','div-0-4');	
      
    /*  
       $MATRIZ = array(
           'proveedores'    => 'proveedores',
           'nomina'    => 'nomina',
           'varios'    => 'varios'
       );
       $this->obj->list->lista('',$MATRIZ,'fbeneficiario',$datos,'required','','div-0-2');
      
      */
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  