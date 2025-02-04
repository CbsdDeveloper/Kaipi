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
    public function grafico($id){
        
        $anio = date ("Y");
        
        
        $sql = "SELECT mes, sum(coalesce(ingreso,0)) ingreso,sum(coalesce(egreso,0)) egreso
        FROM  view_movimiento_det_cta
        where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and  
              idproducto =  ". $this->bd->sqlvalue_inyeccion($id,true)."
        group by mes";

 

        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $bln = array();
        
        $bln['name'] = 'Mes';
        $rows['name'] = 'Ingresos';
        $rows1['name'] = 'Egresos';
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            
            
            $Mes = $this->bd->_mes( $r['mes'] );
            
            $bln['data'][]  = $Mes;
            
            $rows['data'][] = (int) $r['ingreso'];
            
            $rows1['data'][] = (int) $r['egreso'];
            
        }
        
        
        $rslt = array();
        array_push($rslt, $bln);
        array_push($rslt, $rows);
        array_push($rslt, $rows1);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
        
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

$id= $_GET['id'];

$gestion->grafico($id);



?>