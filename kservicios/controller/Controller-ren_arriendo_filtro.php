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
        
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase   bnaturaleza,bidciudad
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        
        $datos = array();
        
        $MATRIZ = array(
             'N'    => 'Contrato Vigente',
             'S'    => 'Contrato Finalizado'
        );
        
        $MATRIZL = array(
            'Local Comercial'    => 'Local Comercial',
            'Baterias Sanitarias'    => 'Baterias Sanitarias',
            'Oficina'    => 'Oficina',
            'Cooperativas de Trasporte'   => 'Cooperativas de Trasporte',
            'Boleteria'    => 'Boleteria',
            'Kiosko Isla' => 'Kiosko Isla',
            'Espacio' => 'Espacio Publicitario'
        );


        $evento = '';
        
        $this->obj->list->listae('',$MATRIZ,'ffinalizado',$datos,'','',$evento,'div-0-6');
        
  
        $this->obj->list->listae('',$MATRIZL,'ftipo',$datos,'','',$evento,'div-0-6');
        
     
        
        
        
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  