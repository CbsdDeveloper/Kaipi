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
        
        
       // variable para fechas 
       // $datos['ffecha1'] =  date('Y-m-d', strtotime("-15 days"));
       // $datos['ffecha2'] =  date("Y-m-d");
       // $this->obj->text->text(' Inicio',"date",'ffecha1',15,15,$datos,'required','','div-3-9');
       // $this->obj->text->text(' Final',"date",'ffecha2',15,15,$datos,'required','','div-3-9');
        
        $MATRIZ = array(
            'S'    => 'Habilitado',
            'N'    => 'No Habilitado',
        );
        
        $this->obj->list->lista('Estado',$MATRIZ,'festado',$datos,'','','div-3-9');
        
        
        $MATRIZ = array(
            'catalogo'    => 'Catalogo Lista',
            'arbol'    => '(*) Catalogo Arbol ' 
        );
       
        $this->obj->list->lista('Estructura',$MATRIZ,'ftipo',$datos,'','','div-3-9');
        
        $MATRIZ = array(
            'programa'     => 'Programa ',
            'actividad'    => 'Actividad ',
            'proyecto'    => 'Proyecto ',
            'competencia'  => 'Competencia ',
            'orientador'    => 'Orientador de gastos ',
            'fuente'    => 'Fuente ',
            'clasificador'    => '(*) Clasificador ',
         );
        
        $this->obj->list->lista('Categoria',$MATRIZ,'fcategoria',$datos,'','','div-3-9');
        
        
        $MATRIZ = array(
            '-'    => 'No Aplica',
            'gasto'    => 'Gasto',
            'ingreso'    => 'Ingreso'
        );
        
        $evento = 'Onchange="listaClasificador(this.value )"' ;
        
        $this->obj->list->listae('Clasificador',$MATRIZ,'fsubcategoria',$datos,'','',$evento,'div-3-9');
        
        
        $MATRIZ = array(
            '-'    => 'No Aplica',
        );
        
        $this->obj->list->lista('Grupo',$MATRIZ,'fgrupo',$datos,'','','div-3-9');
        
    }
    
    
    
    
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}

$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  