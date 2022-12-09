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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
       
      	
      	$datos['fanio']	= date("Y");
      	
       
      	$tipo = $this->bd->retorna_tipo();
 
      	$resultado = $this->bd->ejecutar(" select 0 as codigo,' [ Seleccione Caja Transaccion ] ' as nombre union
                                            SELECT id_co_caja as codigo, detalle as nombre
          											FROM co_caja
          											where estado = 'abierto' and  
                                                          registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );
      	
               	
      	$evento = 'onChange="PoneDato(this.value)"';
      	
      	$this->obj->list->listadbe($resultado,$tipo,'Caja','id_co_caja',$datos,'','',$evento,'div-0-12');
      	
      	
      	
      	$this->obj->text->text('Cuenta',"texto",'cuenta',15,15,$datos,'required','readonly','div-0-12');
      	
      	$this->obj->text->texto_oculto("fanio",$datos);
      	
      	$this->obj->text->texto_oculto("fmes",$datos);
      	
      	
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  