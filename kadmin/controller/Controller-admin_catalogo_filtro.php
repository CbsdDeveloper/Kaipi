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
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
      	
        $datos = array();
      	
      	$evento = ' onChange="'.'javascript:open_forma()'.'"' ;
       	
 
      	$MATRIZ =  $this->obj->array->catalogo_tipo_general();
      	
      	$this->obj->list->listae('Catalogo',$MATRIZ,'cata',$datos,'required','',$evento,'div-2-4');
      
      	
      	$tipo = $this->bd->retorna_tipo();
      	
      	
      	$sql = "SELECT  tipo as codigo, upper(tipo) as nombre
                FROM par_catalogo
                group by tipo 
                order by tipo " ;
      	
      	$resultado =  $this->bd->ejecutar($sql);
 
        $this->obj->list->listadb($resultado,$tipo,'Tipo Catalogo','tipo_catalogo',$datos,'required','','div-2-4');	
 
 
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  