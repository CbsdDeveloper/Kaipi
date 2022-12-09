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
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
      	
      	$MATRIZ =  $this->obj->array->catalogo_activo();
      	
      	$this->obj->list->listae('Estado',$MATRIZ,'bestado',$datos,'required','',$evento,'div-3-9');
      	
      	
      	$datos = array();
      	
      	$MATRIZ = array(
      			'-'  => 'No Aplica',
      			'NN'    => 'Persona Natural',
      			'NC'    => 'Persona Natural - Obligado a llevar contabilidad',
      			'PJ'    => 'Persona Juridico ',
      			'PE'    => 'Persona Juridico - Contribuyente Especial',
      			'PP'    => 'Persona Juridico - Sector Publico'
      	);
      	
      	$this->obj->list->lista('Naturaleza',$MATRIZ,'bnaturaleza',$datos,'required','','div-3-9');
       
      	$resultado =$this->bd->ejecutar("select 0 as codigo, '[ Todas las ciudades ]' as nombre   union
                                         select idcatalogo as codigo, nombre
            			                     from par_catalogo
            								where tipo = 'canton' and publica = 'S' order by 2 ");
      	
      	$tipo = $this->bd->retorna_tipo();
      	
      	$this->obj->list->listadb($resultado,$tipo,'Ciudad','bidciudad',$datos,'required','','div-3-9');
 
      	 
      	$this->obj->text->text_blue('Nombre',"texto",'crazon',15,15,$datos,'','','div-3-9');
      	
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  