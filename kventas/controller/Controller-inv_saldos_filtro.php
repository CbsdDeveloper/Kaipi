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
        
        $tipo = $this->bd->retorna_tipo();
        
        $datos = array();
        
        $anio = date("Y");
           
        
        
        $MATRIZ = array(
            $anio  => $anio,
            $anio - 1    => $anio - 1 ,
            $anio - 2   => $anio - 2 ,
            $anio - 3   => $anio - 3 ,
            $anio - 4   => $anio - 4 ,
        );
        
        
        $this->obj->list->lista('',$MATRIZ,'anio',$datos,'required','','div-0-2');
        
        
        $MATRIZ = array(
            '1'  => 'Enero',
            '2'  => 'Febrero',
            '3'  => 'Marzo',
            '4'  => 'Abril',
            '5'  => 'Mayo',
            '6'  => 'Junio',
            '7'  => 'Julio',
            '8'  => 'Agosto',
            '9'  => 'Septiembre',
            '10'  => 'Octubre',
            '11'    => 'Noviembre',
            '12'    => 'Diciembre' 
        );
        
        
        $this->obj->list->lista('',$MATRIZ,'mes',$datos,'required','','div-0-2');
        
        
        
        
        $resultado =$this->bd->ejecutar("SELECT 0 as codigo, '-  0. Seleccionar Categoria  -' as nombre union
                                        SELECT idcategoria as codigo, nombre
            			                     from web_categoria
                                            WHERE  variable = 'S'
                                            ORDER BY 2 asc ");
        
   
        $evento = 'onChange="PoneServicios(this.value)" ';
        
        $this->obj->list->listadbe($resultado,$tipo,'','idcategoria',$datos,'required','',$evento,'div-0-5');
        
        $resultado =$this->bd->ejecutar("SELECT 0 as codigo, '[ Seleccionar Servicios ]' as nombre ");
         
        
        
        $this->obj->list->listadb($resultado,$tipo,'','idproducto',$datos,'required','','div-0-9');
        
 
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  