<?php
session_start( );
require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';

require 'Formulas-roles_nomina.php';

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
    private $anio;
    
    private $monto_iess;

    private $formula;


    
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
        
        $this->anio       =  $_SESSION['anio'];


        $this->formula     = 	new Formula_rol(  $this->obj,  $this->bd);
        
    }

    /*
    */

    function _busca_configuracion($id_config, $regimen,$programa){
        
        $AResultado = $this->bd->query_array(
            'nom_config_regimen',
            'id_config_reg,tipo_config',
            'id_config='.$this->bd->sqlvalue_inyeccion($id_config,true) .' and 
               regimen='.$this->bd->sqlvalue_inyeccion(trim( $regimen),true) .' and 
               programa='.$this->bd->sqlvalue_inyeccion(trim($programa),true) 
            );
        
 
       
                   
         return  $AResultado;
                   
    }

 
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($id_rol,$id_config,$regimen,$accion){
        
        
        $rol = $this->bd->query_array('nom_rol_pago',
        'id_periodo, mes, anio, registro',
        'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true));
    
 
       $tipo_rol = $this->bd->query_array('nom_config',
            'tipo',
            'id_config='.$this->bd->sqlvalue_inyeccion($id_config,true));

  
     $tipo_rol   = trim($tipo_rol["tipo"]);
 
     $cadena = " || ' ' " ;
         
    if ( $regimen == '-') {

       $sql = 'SELECT idprov '.$cadena.' as "Identificacion",
            		   empleado as "Nombre",
                       regimen as "Regimen",
                       unidad as "Departamento",
                       programa '.$cadena.' as "Programa",
                       monto as "Monto"
                FROM    view_rol_impresion
              WHERE   id_config_matriz ='.$this->bd->sqlvalue_inyeccion($id_config, true). ' and 
                      id_rol= '.$this->bd->sqlvalue_inyeccion($id_rol, true). "   and 
                      tipo_config =".$this->bd->sqlvalue_inyeccion($tipo_rol, true)." 
                       order by empleado";
                       
         

    }else   {  
                
        $sql = 'SELECT idprov '.$cadena.' as "Identificacion",
                            empleado as "Nombre",
                            regimen as "Regimen",
                            unidad as "Departamento",
                            programa '.$cadena.' as "Programa",
                             monto as "Monto"
                    FROM    view_rol_impresion
                    WHERE   id_config_matriz = '.$this->bd->sqlvalue_inyeccion($id_config, true). ' and 
                            id_rol= '.$this->bd->sqlvalue_inyeccion($id_rol, true). "  and
                            regimen = ".$this->bd->sqlvalue_inyeccion($regimen, true). "  and
                            tipo_config =".$this->bd->sqlvalue_inyeccion($tipo_rol, true)." 
                            order by empleado";

           
     }

 
     $this->obj->grid->KP_sumatoria(7,"Monto","", "",'');

     $resultado = $this->bd->ejecutar($sql);
        
        
     $tipo = $this->bd->retorna_tipo();
     
     
     $variables  = '';
     
    
     
     $this->obj->grid->KP_GRID_POP_NOM($resultado,$tipo,'id', $variables,'N','','','' );



    
    }
 
  
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



$id_rol              = $_GET['id_rol'];
$id_config           = $_GET['id_config'];
 $regimen            = $_GET['regimen'];
 
$accion             = $_GET['accion'];

$gestion->consultaId($id_rol,$id_config,$regimen,$accion);

 

?>
<script>

   jQuery.noConflict(); 

   jQuery(document).ready(function() {

	   jQuery('#jsontable').DataTable( {
    	        "paging":   true,
    	        "ordering": false,
    	        "info":     true
    	    } );
        
    } ); 
</script>  
  