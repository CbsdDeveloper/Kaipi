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
        
        $this->obj     = 	new objects;
        
        $this->set     = 	new ItemsController;
        
        $this->bd	   =	     	new Db ;
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  $this->bd->hoy();
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function fecha( ){
        $todayh =  getdate();
        $d = $todayh[mday];
        $m = $todayh[mon];
        $y = $todayh[year];
        return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
    }
    //---------------------------------------
    
    function Formulario( ){
        
        $tipo = $this->bd->retorna_tipo();
        
        $datos = array();
        
        
        
        $evento = ' OnChange="BuscaPrograma(this.value,0)" ';
        $resultado =  $this->combo_lista("nom_regimen");
        $this->obj->list->listadbe($resultado,$tipo,'','regimen2',$datos,'required','',$evento,'div-0-3');
        
        
    
        
        $resultado =  $this->combo_lista("unidad");
        $this->obj->list->listadb($resultado,$tipo,'','unidad2',$datos,'required','','div-0-3');
        
        
       
        
    }
    ///------------------------------------------------------------------------
    //----------------------------------------------
    function combo_lista($tabla ){
        
        if  ($tabla == 'rubros'){
            
            $sql ="SELECT ' - ' as codigo,' [ Seleccione Concepto ]' as nombre "   ;
            
            
            
            $resultado = $this->bd->ejecutar($sql);
            
        }
        
        
        if  ($tabla == 'unidad'){
            
            $sql ="SELECT ' - ' as codigo,' [ Seleccione Unidad ]' as nombre "   ;
            
            
            
            $resultado = $this->bd->ejecutar($sql);
            
        }
        
        if  ($tabla == 'programa'){
            
            $sql ="SELECT ' - ' as codigo,' [ Seleccion de  Programa ]' as nombre "   ;
            
            
            
            $resultado = $this->bd->ejecutar($sql);
            
        }
        
        
        if  ($tabla == 'nom_regimen'){
            
            $resultado =  $this->bd->ejecutarLista("regimen,regimen",
                $tabla,
                "activo = ".$this->bd->sqlvalue_inyeccion('S' ,true),
                "order by 2");
                
        }
        
        
        
        
        return $resultado;
        
        
    }
    ///------------------------------------------------------------------------
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------


$gestion   = 	new componente;


$gestion->Formulario( );

?>
 
  