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
    private $usuario;
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
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->usuario   = $_SESSION['usuario'] ;
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase   bnaturaleza,bidciudad
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $resultado =$this->bd->ejecutar("select '-' as codigo, 'Seleccionar Dato' as nombre union
                                        select zona as codigo, zona as nombre
            			                     from ven_cliente_zona
                                            where idusuario=".$this->bd->sqlvalue_inyeccion($this->usuario , true)."
            								group by zona ");
        
 
        
        $evento = 'onChange="BuscaCanton(this.value);"';
        
        $this->obj->list->listadbe($resultado,$tipo,'Zona ','vprovincia',$datos,'required','',$evento,'div-2-4');
        
 
  
        $resultado =$this->bd->ejecutar("select '-' as codigo, 'Seleccionar' as nombre ");
        

        
        $this->obj->list->listadb($resultado,$tipo,'Sector','vcanton',$datos,'required','','div-2-4');
        
        
      
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  