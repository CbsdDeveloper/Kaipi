<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
    public function BusquedaGrilla($estado,$idprov ){
        
          
        $this->_Verifica_suma_facturas_Total();
        $this->_Verifica_suma_facturas();
        $this->_Verifica_facturas();
        
        
        $sql ="SELECT a.idmovimiento,a.fecha,a.idprov,a.razon, sum(b.total ) as total,a.idven_gestion, a.bandera,a.novedad
                 FROM  ven_cliente_gestion a, ven_cliente_prod b
                where a.idmovimiento = -1 and a.factura = 'S' and 
                      a.registro =" .$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                      a.idprov =" .$this->bd->sqlvalue_inyeccion($idprov,true)." and
                	  a.idven_gestion = b.idvengestion and 
                      a.registro = b.registro
               group by   a.idmovimiento,a.fecha,a.idprov,a.razon,a.idven_gestion,a.bandera,a.novedad";

 
        
        $resultado = $this->bd->ejecutar($sql);
          
        while ($fetch=$this->bd->obtener_fila($resultado)){
     
                   
            if ($fetch['bandera'] == 'S'){
                $check ='checked';
            }else{
                $check =' ';
            }
            
            
            $output[] = array (
                $fetch['idven_gestion'],
                $fetch['fecha'],
                $fetch['idprov'],
                $fetch['razon'],
                $fetch['novedad'],
                $fetch['total'],
                 $check
            );
        }
        
        echo json_encode($output);
        
    }
    //---------------
    function _total_facturas( $idprov  ){
        
        $sql = "SELECT sum( b.total ) as total
                FROM  ven_cliente_gestion a, ven_cliente_prod b
                where a.idmovimiento = -1 and a.factura = 'S' and 
                	  a.idven_gestion = b.idvengestion and
                	  a.registro = b.registro and
                      a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true)." and 
                	  a.idprov = ".$this->bd->sqlvalue_inyeccion($idprov, true);  

 
        
        $resultado 			= $this->bd->ejecutar($sql);
        $validaRegistro     = $this->bd->obtener_array($resultado);
        
        return $validaRegistro['total'];
    }
   //-----------------------------  
    function _Verifica_facturas(   ){
        
        $sqlEdit = "update inv_movimiento_det
				      set monto_iva = 0 , tarifa_cero = total / cantidad , baseiva = 0 "."
 				 		 WHERE  tarifa_cero is null and
                                cantidad > 0 and
                                monto_iva is null and
                                tipo=".$this->bd->sqlvalue_inyeccion('T', true);
        
        $this->bd->ejecutar($sqlEdit);
        
        
        
        $sql = "update inv_movimiento_det
                        set tipo = ".$this->bd->sqlvalue_inyeccion('T', true)."
                        where   cantidad > 0 and monto_iva = 0" ;
        
        $this->bd->ejecutar($sql);
        
        
        $sql = "update inv_movimiento_det
                     set tarifa_cero = costo * cantidad,
                         total       = costo * cantidad
                   where  tipo = ".$this->bd->sqlvalue_inyeccion('T', true)." and (monto_iva + tarifa_cero + baseiva) <> total" ;
        
        $this->bd->ejecutar($sql);
        
        
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
      
    
    $idprov= $_GET['idprov'];
    
    
    $gestion->BusquedaGrilla( $estado,$idprov );
    
}




?>
 
  