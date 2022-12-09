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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->usuario   = $_SESSION['usuario'] ;
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase   bnaturaleza,bidciudad
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        $tipo = $this->bd->retorna_tipo();
        
        
        
        $resultado =$this->bd->ejecutar("select '0' as codigo, 'No asignados' as nombre union
                                        SELECT id_campana as codigo, titulo as nombre
                                        FROM  view_ventas_campana
                                        where publica = 'S' order by 1" );
        
        $evento = '';
        
       
        $this->obj->list->listadbe($resultado,$tipo,'','vid_campana',$datos,'','',$evento,'div-1-11');
        
        
        $resultado =$this->bd->ejecutar("select '-' as codigo, 'Seleccione zona' as nombre union
                                       SELECT  nombre as codigo, nombre
                                    FROM public.par_catalogo
                                    where tipo = 'canton' order by 1" );
                                            
        
        
        $evento = '';
        
        $this->obj->list->listadbe($resultado,$tipo,' ','vsector',$datos,'required','',$evento,'div-1-11');
        
 
  
        $MATRIZ = array(
            '-'  => 'Estado de Informacion',
            '0'  => 'No Confirmados',
            '1' => 'Por Actualizar',
            '2'  => 'En proceso',
        );
        
        $this->obj->list->listae('',$MATRIZ,'vestado',$datos,'','',$evento,'div-1-11');
        

        
        $MATRIZ = array(
            '-'  => 'Seleccion medios de informacion',
            'Redes Sociales'  => 'Redes Sociales',
            'Base Datos'  => 'Base Datos',
            'Otros Medios'  => 'Otros Medios'
        );
        
        $this->obj->list->listae('',$MATRIZ,'vmedio',$datos,'','',$evento,'div-1-11');
        
        
      
        
    }
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>


 
  