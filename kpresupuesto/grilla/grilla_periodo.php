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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla(){
        
        
         
       
        
        $sql = 'SELECT idperiodo, anio, sesion, creacion, sesionm, modificacion, estado, registro, detalle
                  FROM presupuesto.pre_periodo
                 WHERE registro = '.$this->bd->sqlvalue_inyeccion($this->ruc,true);
         
        $resultado  = $this->bd->ejecutar($sql);
        
        $output = array();
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array (
                $fetch['idperiodo'],
                $fetch['anio'],
                $fetch['detalle'],
                $fetch['estado'],
                trim($fetch['sesionm']) 
            );
            
        }
        
        
        pg_free_result($resultado);
        
        echo json_encode($output);
        
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 

$gestion   = 	new proceso;

$gestion->BusquedaGrilla( );
    
 



?>
 
  