<?php
session_start();
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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($fecha1,$fecha2,  $tipo){
        
 
        
        $output = array();
        

        if (   $tipo == 1 ){
                    $sql = 'SELECT  id_ren_movimiento,razon, servicio , estado,
                                    costo,   coalesce(descuento,0) as descuento, interes, coalesce(recargo,0) AS recargo, total,cxcobrar, cuenta_ing,partida ,conta
                    FROM  rentas.view_contabilizacion
                    where  fecha between '.$this->bd->sqlvalue_inyeccion( $fecha1,true).' and '.$this->bd->sqlvalue_inyeccion($fecha2,true).' 
                    order by fecha desc ';
        }else{
            $sql = 'SELECT  id_ren_movimiento,razon, servicio ,estado,
                            costo,   coalesce(descuento,0) as descuento, interes, coalesce(recargo,0) AS recargo, total,cxcobrar, cuenta_ing,partida ,conta
            FROM  rentas.view_contabilizacion
            where  fechap between '.$this->bd->sqlvalue_inyeccion( $fecha1,true).' and '.$this->bd->sqlvalue_inyeccion($fecha2,true)." and
                   conta = 'N' and estado = 'P'
            order by fecha desc ";
        }
        
  
        
        $resultado  = $this->bd->ejecutar($sql);
        

        // filtro para fechas
         
         
        while ($fetch=$this->bd->obtener_fila($resultado)){
                
            if (  $fetch['conta'] == 'N'){
                    $conta = 'NO';
            }else{
                $conta = 'SI';
            }
            
            $output[] = array (
                trim($fetch['id_ren_movimiento']),
                trim($fetch['razon']).' ('. trim($fetch['estado']).')',
                $fetch['servicio'],
                round($fetch['costo'],2),
                $fetch['interes'],
                $fetch['recargo'],
                $fetch['descuento'],
                $fetch['total'],
                $fetch['cxcobrar'],
                $fetch['partida'],
                $conta
             );
        }
        
        pg_free_result($resultado);
        
        echo json_encode($output);
        
    }
    //---------------
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ consulta grilla de informacion
if (isset($_GET['fecha1']))	{
    
 
    
    $fecha1= $_GET['fecha1'];
 
    $fecha2 = $_GET['fecha2'];
    
    $tipo = $_GET['tipo'];
    
    $gestion->BusquedaGrilla( $fecha1,$fecha2,  $tipo);
    
}




?>
 
  