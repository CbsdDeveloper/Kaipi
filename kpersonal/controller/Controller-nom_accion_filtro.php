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
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        
        $MATRIZ = $this->obj->array->catalogo_anio();
        
        $evento ='';
        
        $datos = array();
        
        $tipo = $this->bd->retorna_tipo();
        
        $this->obj->list->listae('Año Solicitud',$MATRIZ,'fanio',$datos,'required','',$evento,'div-1-2');
        
        $MATRIZ = $this->obj->array->catalogo_mes_nomina();  
        
        $this->obj->list->listae('Mes Solicitud ',$MATRIZ,'fmes',$datos,'required','',$evento,'div-1-2');
        
        
        $MATRIZ = array(
            '-'    => '-- Todos --',
            'N'    => 'Digitado',
            'S'    => 'Aprobado',
            'X'    => 'Anulado',
        );
        
        $MATRIZ1 = array(
            '-'    => '-- Todos --',
            'N'    => 'NO',
            'S'    => 'SI'
         );
        
         
        $this->obj->list->listae('Estado',$MATRIZ,'festado',$datos,'required','',$evento,'div-1-2');
        
          
        $this->obj->list->listae('Finalizados',$MATRIZ1,'ffin',$datos,'required','',$evento,'div-1-2');
    
        $resultado =  $this->combo_lista("nom_accion");

        $this->obj->list->listadb($resultado,$tipo,'Motivo Accion','fmotivo',$datos,'required','','div-1-5');
        
        
   
       
    }
    ///------------------------------------------------------------------------
    function combo_lista($tabla ){
        
        if  ($tabla == 'nom_accion'){
            
            $sql ="SELECT ' - ' as codigo,' [ 0. Motivo Accion ]' as nombre union
                        SELECT motivo as codigo, motivo as nombre
                            FROM  nom_accion
                            group by motivo
                        order by 1"   ;
            
            
            
            $resultado = $this->bd->ejecutar($sql);
            
            
            
        }
        
     
        
        
        return $resultado;
        
        
    }  
    ///------------------------------------------------------------------------
}
$gestion   = 	new componente;


$gestion->FiltroFormulario( );

?>