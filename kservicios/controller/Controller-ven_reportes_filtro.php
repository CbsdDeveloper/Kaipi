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
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  $this->bd->hoy();
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        $tipo = $this->bd->retorna_tipo();
        
        $datos = array();
        
        $datos['fecha1'] =  date("Y-m-d");
        $datos['fecha2'] =  date("Y-m-d");
        
        
        
        $this->obj->text->text('Inicio','date','fecha1',10,15,$datos ,'required','','div-2-4') ;
        $this->obj->text->text('Hasta','date','fecha2',10,15,$datos ,'required','','div-2-4') ;

        $this->obj->list->listadb($this->ListaDB('cajero'),$tipo,'Usuario','cajero',$datos,'required','','div-2-4');
        
 
        
    }
    //---------------------------------------------
    function ListaDB( $titulo){
        
       
        $anio= date('Y');
        
 
       $resultado = $this->bd->ejecutar("select '-' as codigo, ' --- Todos los usuarios --' as nombre  union 
			                       select sesion as codigo ,sesion_usuario as nombre
                                   from rentas.view_ren_movimiento_diario
								where anio = ".$this->bd->sqlvalue_inyeccion($anio,true)."
                          order by 2 ");
        
         
        
        return $resultado;
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  