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
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($estado,$cajero,$fecha1,$fecha2,$tipofacturaf){
        
        /*
        
        $this->_Verifica_suma_facturas_Total();
        $this->_Verifica_suma_facturas();*/
        
        
        $this->_Verifica_facturas();
        
        $output = array();
        
        $qquery = array(
            array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'base12',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'iva',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'base0',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'total',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cierre',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'autorizacion',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'envio',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_asiento_ref',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'sesion',   valor => trim($cajero),  filtro => 'S',   visor => 'N'),
            array( campo => 'estado',     valor => $estado,  filtro => 'S',   visor => 'N'),
            array( campo => 'carga',     valor => '9',  filtro => 'S',   visor => 'N')
        );
        
        
        // filtro para fechas
        if ( $estado == 'digitado'){
            $this->bd->__between('fecha',$fecha1,$fecha2);
        }else {
            $this->bd->__between('fechaa',$fecha1,$fecha2);
        }
     
        
        $resultado = $this->bd->JqueryCursorVisor('view_ventas_fac_estado',$qquery );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
     
          
            $imagen =  '<img src="../../kimages/star.png" title="FACTURA NO EMITIDA ELECTRONICAMENTE"/>';
            
            if (!empty($fetch['envio'])){
            
                    if ( $fetch['envio'] == 'N'){
                        $imagen =  '<img src="../../kimages/star.png" title="FACTURA NO EMITIDA ELECTRONICAMENTE"/>';
                    }
                    else {
                        if ( $fetch['envio'] == 'S'){
                            if ( !empty($fetch['autorizacion'])){
                                $imagen =  '<img src="../../kimages/starok.png"   title="'.$fetch['autorizacion'].'"/>';
                            }else{
                                $imagen =  '<img src="../../kimages/star_medio.png"  title="FACTURA ENVIADA POR ACTUALIZAR"/>';
                            }
                        }
                    }
                    
            }
             
            
            $output[] = array (
                $fetch['fecha'],$fetch['comprobante'],
                $fetch['razon'],$fetch['base12'],$fetch['iva'],
                $fetch['base0'],$fetch['total'],
                $imagen,
                $fetch['id_asiento_ref'],
                $fetch['id_movimiento']
            );
        }
        
        pg_free_result($resultado);
        
        echo json_encode($output);
        
    }
    //---------------
    function _Verifica_facturas(   ){
        
      
        
        
    }
    //---------------
    function _Verifica_suma_facturas(   ){
        
        
        $sql_det1 = 'SELECT id_movimiento,    iva, base0, base12, total
                        FROM inv_movimiento
                        where base0 is null';
        
        
        
        $stmt1 = $this->bd->ejecutar($sql_det1);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            $id = $x['id_movimiento'];
            
            $ATotal = $this->bd->query_array(
                'inv_movimiento_det',
                'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
                ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
                );
            
            $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
            
            $this->bd->ejecutar($sqlEdit);
            
            
        }
        
    }
    //---------------
    function _Verifica_suma_facturas_Total(   ){
        
        
        $sql_det1 = 'select   id_movimiento
                        FROM inv_movimiento
                        where ( iva + base0 + base12) <> total ';
        
        
        
        $stmt1 = $this->bd->ejecutar($sql_det1);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
            
            $id = $x['id_movimiento'];
            
            $ATotal = $this->bd->query_array(
                'inv_movimiento_det',
                'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
                ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
                );
            
            $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
            
            $this->bd->ejecutar($sqlEdit);
            
            
        }
        
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ consulta grilla de informacion
if (isset($_GET['estado']))	{
    
    $estado= $_GET['estado'];
    
    $cajero= $_GET['cajero'];
    
    $fecha1= $_GET['fecha1'];
    
    $fecha2= $_GET['fecha2'];
    
    $tipofacturaf = $_GET['tipofacturaf'];
    
    
    $gestion->BusquedaGrilla($estado,$cajero,$fecha1,$fecha2,$tipofacturaf);
    
}




?>
 
  