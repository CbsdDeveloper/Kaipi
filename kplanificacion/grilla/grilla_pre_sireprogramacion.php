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
    private $anio;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     =    new objects;
        $this->bd      =    new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion    =  $_SESSION['email'];
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($festado,$ffecha1,$ffecha2,$ftipo){
        
        
        $cadena01 =  '( anio = '.$this->bd->sqlvalue_inyeccion( $this->anio  ,true).') and ';
         
        $cadena0 =  '( tipo = '.$this->bd->sqlvalue_inyeccion(trim($ftipo),true).') and ';
        
        $cadena1 = '( estado ='.$this->bd->sqlvalue_inyeccion(trim($festado),true).") and ";
        
        
        $cadena2 = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".$this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
        
        $where = $cadena01.$cadena0.$cadena1.$cadena2;
        
        $sql = 'SELECT id_sireprogra,
                       tipo,
                       fecha,
                       comprobante,
                       id_departamento,
                       detalle
                from presupuesto.pre_sireprogramacion   where '. $where;

        $resultado  = $this->bd->ejecutar($sql);
        
        $output = array();
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $output[] = array (
                $fetch['id_sireprogra'],
                $fetch['tipo'],
                $fetch['fecha'],
                $fetch['comprobante'],
                trim($fetch['id_departamento']),
                trim($fetch['detalle'])
            );
            
        }
        
        
        pg_free_result($resultado);
        
        echo json_encode($output);
        
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   =    new proceso;



//------ consulta grilla de informacion
if (isset($_GET['festado']))    {
    
    $festado= $_GET['festado'];
    $ffecha1= $_GET['ffecha1'];
    $ffecha2= $_GET['ffecha2'];
    
    $ftipo          = $_GET['ftipo'];
    
    $gestion->BusquedaGrilla($festado,$ffecha1,$ffecha2,$ftipo);
    
     
}



?>
 
  