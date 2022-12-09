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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
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
        
        $resultado = $this->bd->ejecutar("select id_rol as codigo, novedad as nombre
                								from nom_rol_pago
                								where estado=". $this->bd->sqlvalue_inyeccion('N', true)."   and 
								                      registro=". $this->bd->sqlvalue_inyeccion($this->ruc, true).'
                                           order by 1 desc ' );
        
        
        $this->obj->list->listadb($resultado,$tipo,'Periodo','id_rol1',$datos,'required','','div-0-3');
        
        
        $evento = ' OnChange="BuscaPrograma(this.value,0)" ';
        $resultado =  $this->combo_lista("nom_regimen");
        $this->obj->list->listadbe($resultado,$tipo,'','regimen',$datos,'required','',$evento,'div-0-3');
        
        
        $evento = ' OnChange="BuscaPrograma(this.value,1)" ';
        $resultado =  $this->combo_lista("programa");
        $this->obj->list->listadbe($resultado,$tipo,'','programa',$datos,'required','',$evento,'div-0-3');
        
        
        $resultado =  $this->combo_lista("unidad");
        $this->obj->list->listadb($resultado,$tipo,'','unidad',$datos,'required','','div-0-3');
        
        
        $resultado =  $this->combo_lista("rubros");
        $this->obj->list->listadb($resultado,$tipo,'','id_config1',$datos,'required','','div-0-3');
        
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
            
            $resultado = $this->bd->ejecutar("select '-' as codigo, '[Seleccione Regimen]' as nombre   union
                                            select regimen as codigo, regimen as  nombre
                								from nom_regimen
                								where activo =". $this->bd->sqlvalue_inyeccion('S', true) .'
                                           order by 1   ' );
                
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
 
  