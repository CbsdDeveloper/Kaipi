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
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  $_SESSION['email'];
		
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->anio       =  $_SESSION['anio'];
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$tipo,$id,$tipofacturaf,$sesionc){
		
  
	    if ($tipo == 'I'){
	        $destino = 'Ingresos';
	    }elseif ($tipo == 'E'){
	        $destino = 'Egresos';
	    }elseif ($tipo == 'F'){
	        $destino = 'Facturacion';
	    }
	    
	  
	    if ( $sesionc == '-'){
	        $cadena = '';
	    }else{
	        $caja = $this->bd->__user($sesionc);
	        $cadena = '<b> Usuario: '.$caja['completo'].'</b>';
	    }
	    
	        $sql        = $this->_sql( $f1,$f2,$tipo,$id,$tipofacturaf,$sesionc);
  			$tipo 		= $this->bd->retorna_tipo();
 			$resultado  = $this->bd->ejecutar($sql);
			
			
			$ViewForm= ' <h5><b>Resumen  Ventas </b>
                             <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.'<br>'.$cadena.'  </h5>';
			
			
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
			    $this->obj->grid->KP_sumatoria(6,"monto_iva","tarifa_cero", "baseiva","total");
			}
			
			if ($id == 7){
			    $this->obj->grid->KP_sumatoria(4,"total","monto_iva", "tarifa_cero","baseiva");
			    
			}
			
			if ($id == 8){
			    $this->obj->grid->KP_sumatoria(3,"iva","baseimponible", "tarifa0","total");
			    
			}
			
 
			
			if ($id == 9){
			    $this->obj->grid->KP_sumatoria(3,"monto_iva","tarifa_cero", "baseiva","total");
			    
			}
 
			if ($id == 5){
			    
			    $datos   = array();
			    $action  = '';
 			    
			
			   
			   $resultado_combo = $this->bd->ejecutar("SELECT '-' as codigo, '[ SELECCIONE BANCO ]' as nombre union
                                        SELECT cuenta as codigo, detalle as nombre
          											FROM co_plan_ctas
          											where tipo_cuenta = 'B' and univel = 'S' and
                                                          anio =".$this->bd->sqlvalue_inyeccion($this->anio , true). " order by 1"  );
 			   
			     
			   
			   $this->obj->list->listadb($resultado_combo,$tipo,'Depositar en','idbancos',$datos,'required','','div-2-10');  
			   
			   echo '<h6> &nbsp; </h6><div class="col-md-2">  &nbsp; </div>
                    <div class="col-md-10"> 
 						<button type="button" class="btn btn-sm btn-primary" id="loadContabilizar" onClick="Contabilizar();">
						<i class="icon-white icon-search"></i> Generar Informacion a contabilidad</button>

                        <button type="button" class="btn btn-sm btn-info" id="loadVentas" onClick="EnlaceVentas();">
						<i class="icon-white icon-search"></i> Generar Informacion a VentasAnexos</button>

  					</div><h6> &nbsp; </h6>
                    <div id="ContabilizadoVentas">  &nbsp; </div>';
			   
			 
			   $this->obj->grid->KP_sumatoria(4,"total","monto_iva", "baseimponible","tarifa_cero");
 
 								
			}
			
			$this->obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
 
	}
  ///------------------------------------------
	function _sql( $f1,$f2,$tipo,$id,$tipofacturaf,$sesionc){
	    
	    $anioArray = explode('-', $f2);
	    
	    $anio = $anioArray[0];
	    
	    $tipo = 'F';
	   
	    if ($id == 1)  {
	        
	        if ( $sesionc == '-'){
	            $cadena = ' ';
	        }else{
	            if ( empty($sesionc)){
	                $cadena = ' ';
	            }else{
	                $cadena = ' and sesion = '.$this->bd->sqlvalue_inyeccion(trim($sesionc), true);
	                
	            }
	        }
	       
	        $sql ="SELECT id_movimiento as movimiento,
                          fechaa as fecha,
                          comprobante,
                          detalle,
                          idprov  || ' ' as identificacion,
                          cliente as Cliente,
                          montoiva iva,
                          baseimpgrav as baseimponible,
                          baseimponible as tarifa0,
                          total  
                    FROM  view_inv_ingresos
                    where tipo ='".$tipo."'   and carga = ".$tipofacturaf." and 
                          (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) ".$cadena."
                     order by fechaa ";
	      
	        
	    }
	   // $sesionc
	    if ($id == 2)  { 
	        
	        if ( $sesionc == '-'){ 
	            $cadena = '';
	        }else{ 
	            if ( empty($sesionc)){
	                $cadena = ' ';
	            }else{
	                $cadena = ' and sesion = '.$this->bd->sqlvalue_inyeccion(trim($sesionc), true);
	                
	            }
 	        }
 	        $sql ="SELECT idprov  || ' ' as identificacion,
                          cliente as cliente,
                          count(*) || ' ' as  transaccion,
                          sum(montoiva) as iva,
                          sum(baseimpgrav) as baseimponible,
                          sum(baseimponible) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_ingresos
                    where   carga = ".$tipofacturaf." and 
                          (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )".$cadena."
                     group by  idprov,    cliente
                     order by cliente ";
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
                          sum(montoiva) as iva,
                          sum(baseimpgrav) as baseimponible,
                          sum(baseimponible) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_ingresos
                    where carga = ".$tipofacturaf." and 
                          anio = ".$anio." 
                     group by  mes
                     order by mes ";
	    }
	    
	    if ($id == 4)  {
	        
	        $tipo = 'F';
	        
	        $sql ="SELECT 
                        fechaa as fecha, 
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
                   where tipo ='".$tipo."' and   carga = ".$tipofacturaf." and 
                          (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     order by fecha ";
	        
	         
	    }
	    
	    if ($id == 5)  {
	    
	        
	        $sql ="SELECT
                        cuenta_ing || ' ' as  cuenta ,
                        cuentaxcobrar || ' ' as  cuentaxcobrar ,
                        partida || ' ' as  partida , 
                        sum(total) as total, 
                        sum(montoiva) as monto_iva, 
                        sum(baseimponible) as baseimponible,
                        sum(tarifa_cero) as tarifa_cero
                     from view_inv_conta
                   where  (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and  carga = ".$tipofacturaf."  
                   group by cuenta_ing  , cuentaxcobrar, partida
                     order by 1 ";
	        
	      
	        
	    }
	    
 
	    if ($id == 6)  {
	        
	        
	        $this->anio       =  $_SESSION['anio'];
	        
	        $sql ="  SELECT   a.grupo_categoria as grupo,
                	    partida || ' ' as  partida , 
                	    a.cuenta_ing as cuenta_ingreso,
                	    a.cuenta_inv as cuenta_cxc,
                	    sum(a.registros) as registros,
                	    sum(a.monto_iva) as monto_iva,
                	    sum(a.tarifa_cero) as tarifa_cero ,
                	    sum(a.baseiva) as  baseiva,
                	    sum(a.total) as total
                    FROM  view_factura_res a
                    WHERE trim(a.tipo_mov) = 'F' and a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and   
                                                a.carga = ".$tipofacturaf." and 
                                                a.tipo = "."'S'"." and 
                                                (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by a.grupo_categoria,a.partida, a.cuenta_ing,a.cuenta_inv
	                 order by a.grupo_categoria,a.partida,a.cuenta_ing,a.cuenta_inv";
	        
	   
	    }
	    
	 
	    if ($id == 9)  {
 	        
	        $sql ="  SELECT   a.producto as servicio,
                	    sum(a.registros) as registros,
                	    sum(a.monto_iva) as monto_iva,
                	    sum(a.tarifa_cero) as tarifa_cero ,
                	    sum(a.baseiva) as  baseiva,
                	    sum(a.total) as total
                    FROM  view_factura_res a
                    WHERE a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                                a.carga = ".$tipofacturaf." and
                                                a.tipo = "."'S'"." and 
                                                (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by a.producto 
	                 order by a.producto";
	        
	        
	    }
	    
	    if ($id == 7)  {
	        
	        
	        $sql ="SELECT   a.partida,   
                    		b.detalle ,
                    		sum(a.registros) as registros, 
                    		sum(a.total) as total,
                    		sum(a.monto_iva) as monto_iva,
                    		sum(a.tarifa_cero) as tarifa_cero ,
                    		sum(a.baseiva) as  baseiva
                    FROM view_factura_res a
                         join presupuesto.pre_gestion b on trim(b.partida) = trim(a.partida) and  
                                tipo_mov = 'F' and 
                                b.anio = ".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
                                a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) and 
                                a.carga = ".$tipofacturaf."  
                    group by a.partida, b.detalle
                    order by 1,2";
	        
	        
	    }
	    
	    if ($id == 8)  {
	        
	        $sql ="SELECT completo as caja, 
                          count(*) || ' ' as  transaccion,
                          sum(montoiva) as iva,
                          sum(baseimpgrav) as baseimponible,
                          sum(baseimponible) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_ingresos
                    where carga = ".$tipofacturaf."  and
                           (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by  completo
                     order by completo ";
	    }
	    
	    if ($id == 10)  {
	        
	        
 	        
	        $sql ="  SELECT  b.completo,  a.grupo_categoria as grupo,
                	    partida || ' ' as  partida ,
                	    a.cuenta_ing as cuenta_ingreso,
                	    a.cuenta_inv as cuenta_cxc,
                	    sum(a.registros) as registros,
                	    sum(a.monto_iva) as monto_iva,
                	    sum(a.tarifa_cero) as tarifa_cero ,
                	    sum(a.baseiva) as  baseiva,
                	    sum(a.total) as total
                    FROM  view_factura_res_sesion a, par_usuario b
                    WHERE a.sesion = b.email  and  
                          trim(a.sesion) = ".$this->bd->sqlvalue_inyeccion(trim($sesionc) , true)." and
                          a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and
                                                a.carga = ".$tipofacturaf." and
                                                a.tipo = "."'S'"." and
                                                (a.fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     group by  b.completo,a.sesion,a.grupo_categoria,a.partida, a.cuenta_ing,a.cuenta_inv
	                 order by  b.completo";
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
    $id                 =     $_GET["id"];
    $tipofacturaf       =     $_GET["tipofacturaf"];
    
    $sesionc       =     $_GET["sesionc"];
    

    $gestion->grilla( $f1,$f2,$tipo,$id,$tipofacturaf,$sesionc);
 
	
}



?>
 
  