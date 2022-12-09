<?php
session_start( );

require '../../kconfig/Db.class.php';


require '../../kconfig/Obj.conf.php';


class proceso{
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  trim($_SESSION['ruc_registro']);
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function _tabla_ingresos($id_rol,$id_config,$regimen,$tipo){
        
        $cadena = " || ' ' ";
        
        if ( $tipo == 'I') {
            
            $sql = 'SELECT idprov '.$cadena.' as "Identificacion",
            		   empleado as "Nombre",
                       unidad as "Departamento",
                       programa '.$cadena.' as "Programa",
                       ingreso as "Ingreso"
               FROM    view_rol_impresion
              WHERE  id_config_matriz = '.$this->bd->sqlvalue_inyeccion($id_config, true). " and
                     id_rol= ".$this->bd->sqlvalue_inyeccion($id_rol, true). "  and
                     regimen = ".$this->bd->sqlvalue_inyeccion($regimen, true). " and ingreso > 0
                      order by empleado";
            
            $this->obj->grid->KP_sumatoria(6,"Ingreso","", "",'');
            
        }else
        {
         
            $sql = 'SELECT idprov '.$cadena.' as "Identificacion",
            		   empleado as "Nombre",
                       unidad as "Departamento",
                       programa '.$cadena.' as "Programa",
                       descuento as "Descuento"
               FROM    view_rol_impresion
              WHERE  id_config_matriz = '.$this->bd->sqlvalue_inyeccion($id_config, true). " and
                     id_rol= ".$this->bd->sqlvalue_inyeccion($id_rol, true). "  and
                     regimen = ".$this->bd->sqlvalue_inyeccion($regimen, true). " and descuento  > 0
                      order by empleado";
            
            
            $this->obj->grid->KP_sumatoria(6,"Descuento","", "",'');
            
        }
            
        
        
   
        $resultado = $this->bd->ejecutar($sql);
        
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $variables  = '';
        
       
        
        $this->obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'N','','','' );
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
   
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($id_rol,$id_config,$regimen,$tipo ){
        
        
         
        if ( $id_config <> '-'){
            
            $this->_tabla_ingresos($id_rol,$id_config,$regimen,$tipo);
            
        }
        
        
       
        
        
        
    }
    
    //--------------------------------------------------------------------------------
  
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;
 

$id_rol             = $_GET['id_rol'];
$id_config          = $_GET['id_config'];
$regimen            = $_GET['regimen'];
$tipo               = $_GET['tipo'];


$gestion->consultaId($id_rol,$id_config,$regimen,$tipo);



?>