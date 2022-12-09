<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo,$estado){
        
        return  $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = '';
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($GET){
        
        $estado = $GET['estado'];
        $id     = $GET['id'];
        
        $id_par_ciu     = $GET['id_par_ciu'];
        
        
        $this->CambioEstado( $estado,$id );
        
        $x = $this->bd->query_array('rentas.view_ren_movimiento_emitido',   // TABLA
            'coalesce(sum(coalesce(total,0)),0) as total',                        // CAMPOS
            'carga = 1 and id_par_ciu='.$this->bd->sqlvalue_inyeccion($id_par_ciu,true) // CONDICION
            );
 
        echo json_encode( 
            array(
                "a"=>trim($x['total']) 
                 )
            );
        
    }
     
    //--------------------------------------------------------------------------------
    function CambioEstado($estado,$id ){
        
        
        $sql = "update rentas.ren_movimiento
                   set carga =".$this->bd->sqlvalue_inyeccion($estado, true)."
                where id_ren_movimiento = ". $this->bd->sqlvalue_inyeccion($id, true);
        
        
        $this->bd->ejecutar($sql);
        
         
        return true;
        
    }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

if (isset($_GET['accion']))	{
    
    $accion    = $_GET['accion'];
    
    if ( $accion ==  'resumen') {
        
        $gestion->consultaId($_GET);
        
    }
}
 

?>