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
 		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$tipo,$id){
		
  
	    if ($tipo == 'I'){
	        $destino = 'Ingresos';
	    }elseif ($tipo == 'E'){
	        $destino = 'Egresos';
	    }elseif ($tipo == 'F'){
	        $destino = 'Facturacion';
	    }
	    
	    
	        $sql        = $this->_sql( $f1,$f2,$tipo,$id);
  			$tipo 		= $this->bd->retorna_tipo();
 			$resultado  = $this->bd->ejecutar($sql);
			
			
			$ViewForm= ' <h5><b>Resumen  Ventas </b>
                             <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.'  </h5>';
			
			
			echo $ViewForm;
			
			$formulario='';
			
			if ($id == 1){
			    $this->obj->grid->KP_sumatoria(7,"iva","baseimponible", "tarifa0","total");
			}
			if ($id == 2){
			    $this->obj->grid->KP_sumatoria(4,"iva","baseimponible", "tarifa0","total");
			}
			if ($id == 3){
			    $this->obj->grid->KP_sumatoria(3,"iva","baseimponible", "tarifa0","total");
			}
			
			if ($id == 6){
			    $this->obj->grid->KP_sumatoria(5,"monto_iva","tarifa_cero", "baseiva","total");
			}
			
			if ($id == 7){
			    $this->obj->grid->KP_sumatoria(4,"base","monto_iva", "costo","lifo");
			    
			}
 
 
			
			if ($id == 8){
			    $this->obj->grid->KP_sumatoria(3,"iva","baseimponible", "tarifa0","total");
			    
			}
			
 
			if ($id == 5){
			    
			    $datos   = array();
			    $action  = '';
 			    
			
			   
			   $resultado_combo = $this->bd->ejecutar("SELECT '-' as codigo, '[ SELECCIONE BANCO ]' as nombre
          											FROM co_plan_ctas
          											where cuenta = '1' and registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true)."
                                        union
                                        SELECT cuenta as codigo, detalle as nombre
          											FROM co_plan_ctas
          											where tipo_cuenta = 'B' and univel = 'S' and
                                                          registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );
			   
			   $this->obj->list->listadb($resultado_combo,$tipo,'Depositar en','idbancos',$datos,'required','','div-2-10');  
			   
			   echo '<h6> &nbsp; </h6><div class="col-md-2">  &nbsp; </div>
                    <div class="col-md-10"> 
 						<button type="button" class="btn btn-sm btn-primary" id="loadContabilizar" onClick="Contabilizar();">
						<i class="icon-white icon-search"></i> Generar Informacion a contabilidad</button>
  					</div><h6> &nbsp; </h6>
                    <div id="ContabilizadoVentas">  &nbsp; </div>';
			   
			 
			   $this->obj->grid->KP_sumatoria(6,"total","montoiva", "tarifa_cero","baseimponible");
 
 								
			}
			
			$this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
 
	}
  ///------------------------------------------
	function _sql( $f1,$f2,$tipo,$id){
	    
	    $anioArray = explode('-', $f2);
	    
	    $anio = $anioArray[0];
	    
	   
	    if ($id == 1)  {
	        $sql ="SELECT id_movimiento as movimiento,
                          fecha,
                          comprobante,
                          detalle,
                          idprov  || ' ' as identificacion,
                          proveedor as Cliente,
                          iva,
                          base12 as baseimponible,
                          base0 as tarifa0,
                          total  
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and estado ='".'aprobado'."' and 
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     order by fecha ";
	      
	    }
	    
	    if ($id == 2)  {
	        
 	        $sql ="SELECT idprov  || ' ' as identificacion,
                          proveedor as cliente,
                          count(*) || ' ' as  transaccion,
                          sum(iva) as iva,
                          sum(base12) as baseimponible,
                          sum(base0) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and estado ='".'aprobado'."' and 
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by  idprov,    proveedor
                     order by proveedor ";
	    }
	    
	    if ($id == 3)  {
	        
	        $detalleMes = "CASE WHEN mes='1' THEN '1. ENERO' WHEN
                                   mes='2' THEN '2. FEBRERO' WHEN
                                   mes='3' THEN '3. MARZO' WHEN
                                   mes='4' THEN '4. ABRIL' WHEN
                                   mes='5' THEN '5. MAYO' WHEN
                                   mes='6' THEN '6. JUNIO' WHEN
                                   mes='7' THEN '7. JULIO' WHEN
                                   mes='8' THEN '8. AGOSTO' WHEN
                                   mes='9' THEN '9. SEPTIEMBRE' WHEN
                                   mes='10' THEN '10. OCTUBRE' WHEN
                                   mes='11' THEN '11. NOVIEMBRE' ELSE '12. DICIEMBRE' END ";
	        
	        
	        
	        $sql ="SELECT ".$detalleMes." as mes,
                          count(*) || ' ' as  transaccion,
                          sum(iva) as iva,
                          sum(base12) as baseimponible,
                          sum(base0) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and estado ='".'aprobado'."' and 
                          anio = ".$anio." 
                     group by  mes
                     order by mes ";
	    }
	    
	    if ($id == 4)  {
	        
	        $tipo = 'F';
	        
	        $sql ="SELECT 
                        fecha, 
                        secuencial , 
                        idcliente  || ' ' as  idcliente , 
                        cliente, 
                        parterelvtas,
                        tipocomprobante      , 
                        tipoemision, 
                        numerocomprobantes   ,
                        basenograiva, baseimponible, baseimpgrav, montoiva,
                        formasdepago, 
                        autorizacion_venta 
                    from view_inv_venta
                   where tipo ='".$tipo."' and   
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     order by fecha ";
	        
	         
	    }
	    
	    if ($id == 5)  {
	    
	        
	        $sql ="SELECT
                        id_movimiento, 
                        cuenta_ing || ' ' as  cuenta ,
                        fecha, 
                        idprov || ' ' as  idcliente , 
                        comprobante, 
                        total, 
                        montoiva, 
                        tarifa_cero, 
                        baseimponible
                    from view_inv_conta
                   where  (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     order by fechaa ";
	    }
	    
 
	    if ($id == 6)  {
	        
	        $tipo = 'F';
	        
	        $sql ="  SELECT   a.grupo_categoria as grupo,
                	    a.cuenta_ing as cuenta_ingreso,
                	    a.cuenta_inv as cuenta_cxc,
                        a.cuenta_gas as cuenta_gasto,
                	    sum(a.monto_iva) as monto_iva,
                	    sum(a.tarifa_cero) as tarifa_cero ,
                	    sum(a.baseiva) as  baseiva,
                	    sum(a.total) as total
                    FROM  view_factura_res a 
                    where  a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and 
                          (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and tipo_mov = 'F' AND tipo = 'B'
                     group by a.grupo_categoria,  a.cuenta_ing,a.cuenta_inv, a.cuenta_gas
	                 order by a.grupo_categoria,  a.cuenta_ing,a.cuenta_inv";
	        
	    
	    }
	    
	 
	    
	    if ($id == 7)  {
	        
	        
	        $sql ="  SELECT   
                	    a.cuenta_ing as cuenta_ingreso,
                	    a.cuenta_inv as cuenta_cxc,
                        a.cuenta_gas as cuenta_gasto,
                	    sum(a.baseiva) + sum(a.tarifa_cero) as  base,
                	    sum(a.monto_iva) as monto_iva,
                	    sum(a.costo) as costo,
                        sum(a.lifo) as lifo
                    FROM  view_factura_res a
                    where  a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                          (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and tipo_mov = 'F' AND tipo = 'B'
                     group by   a.cuenta_ing,a.cuenta_inv, a.cuenta_gas
	                 order by    a.cuenta_ing,a.cuenta_inv";
	        
	    }
	    
	    if ($id == 8)  {
	        
	        $sql ="SELECT sesion as caja, 
                          count(*) || ' ' as  transaccion,
                          sum(iva) as iva,
                          sum(base12) as baseimponible,
                          sum(base0) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and estado ='".'aprobado'."' and
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by  sesion
                     order by sesion ";
	    }
	    return $sql;
	    
	}
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_GET["id"]))	{
	
    $f1 			    =     $_GET["fecha1"];
    $f2 				=     $_GET["fecha2"];
    $tipo               =     $_GET["tipo"];
    $id                  =     $_GET["id"];
    
    $gestion->grilla( $f1,$f2,$tipo,$id);
 
	
}



?>
 
  