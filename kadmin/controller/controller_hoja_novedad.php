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
        
        $this->hoy 	     =  date('Y-m-d');
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        
        $datos = array();
        
        $DateAndTime = date('h:i');
        
        $datos['hora1'] = $DateAndTime;
        $datos['hora2'] = $DateAndTime;
      
        
        $this->obj->text->text_yellow('Hora Salida',"time",'hora1',15,15,$datos,'required','','div-0-3');
        
        $this->obj->text->text_blue('Hora Llegada',"time",'hora2',15,15,$datos,'required','','div-0-3');
        
        $this->obj->text->editor('Ingrese Destino','actividad',3,400,400,$datos,'','','div-0-6') ;
 
        
        
        $this->obj->text->editor('Motivo de salida','motivo',3,400,400,$datos,'','','div-0-6') ;
        
        $this->obj->text->editor('Observacion','observacion',3,400,400,$datos,'','','div-0-6') ;
        
       
        
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>