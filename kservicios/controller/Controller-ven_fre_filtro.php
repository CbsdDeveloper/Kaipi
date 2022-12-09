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

        $this->obj->list->listadb($this->ListaDB('cajero'),$tipo,'Unidades','cajero',$datos,'required','','div-2-4');
        
 
        
    }
    //---------------------------------------------
    function ListaDB( $titulo){
        
       
        $anio= date('Y');
        
        $sql1 = "SELECT idprov as codigo, razon as nombre
                FROM par_ciu
        where estado = 'S' and serie = 'C'
        order by razon 
        limit 25";
 


 
       $resultado = $this->bd->ejecutar($sql1 );
        
         
        
        return $resultado;
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  