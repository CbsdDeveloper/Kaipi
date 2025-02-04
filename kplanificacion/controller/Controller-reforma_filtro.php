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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  $this->bd->hoy();
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        $datos = array();
        
        $datos['ffecha1'] =  date('Y-m-d', strtotime("-15 days"));
        
        $datos['ffecha2'] =  date("Y-m-d");
        
        
        
        $this->obj->text->text(' Inicio',"date",'ffecha1',15,15,$datos,'required','','div-3-9');
        
        $this->obj->text->text(' Final',"date",'ffecha2',15,15,$datos,'required','','div-3-9');
        
        $MATRIZ = array(
            'digitado'    => 'Solicitado',
            'aprobado'    => 'Aprobado',
            'autorizado'    => 'Autorizado',
            'anulado'    => 'Anulado',
        );
        
        $this->obj->list->lista('Estado',$MATRIZ,'festado',$datos,'','','div-3-9');
        
        
 
        $datos['ftipo'] =  'G' ;
        $this->obj->text->texto_oculto("ftipo",$datos); 
        
         
        $MATRIZ = array(
            'Traspaso'    => 'Traspaso',
            'Aumento'    => 'Aumento',
            'Reduccion'    => 'Reduccion' 
        );
        
        $this->obj->list->lista('Tipo',$MATRIZ,'ftipo_reforma',$datos,'','','div-3-9');
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  