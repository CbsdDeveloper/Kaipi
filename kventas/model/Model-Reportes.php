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
	    
	    
	        $sql = $this->_sql( $f1,$f2,$tipo,$id);
	    
        	
			$resultado  = $this->bd->ejecutar($sql);
			
			$tipo 		= $this->bd->retorna_tipo();
			
			
			
			$ViewForm= ' <h5><b>Resumen Mensual Inventarios </b>
                             <br>Periodo  '.$f1.' al '.$f2.'<br>'.$destino.'  </h5>';
			
			
			echo $ViewForm;
			
			if ($id == 1){
			    $this->obj->grid->KP_sumatoria(7,"iva","baseimponible", "tarifa0","total");
			}
			if ($id == 2){
			    $this->obj->grid->KP_sumatoria(4,"iva","baseimponible", "tarifa0","total");
			}
			if ($id == 3){
			    $this->obj->grid->KP_sumatoria(3,"iva","baseimponible", "tarifa0","total");
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
                          proveedor,
                          iva,
                          base12 as baseimponible,
                          base0 as tarifa0,
                          total  
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and 
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     order by fecha ";
	    }
	    
	    if ($id == 2)  {
	        
 	        $sql ="SELECT idprov  || ' ' as identificacion,
                          proveedor,
                          count(*) || ' ' as transaccion,
                          sum(iva) as iva,
                          sum(base12) as baseimponible,
                          sum(base0) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and 
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
                          count(*) || ' ' as transaccion,
                          sum(iva) as iva,
                          sum(base12) as baseimponible,
                          sum(base0) as tarifa0,
                          sum(total) as total
                    FROM  view_inv_transaccion
                    where tipo ='".$tipo."' and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and 
                          anio = ".$anio." 
                     group by  mes
                     order by mes ";
	    }
	    
	    if ($id == 4)  {
	        
	        $tipo = 'I';
	        
	        $sql ="SELECT id_movimiento as movimiento,
                           fecha,   
                           comprobante,  
                           idprov  || ' ' as identificacion,
                           proveedor,   correo, 
                         iva, base12, base0, total, 
                      codsustento,  
                     tipocomprobante, fecharegistro, establecimiento, puntoemision, secuencial,
                     fechaemision, autorizacion, 
                     valorretbienes as ivabienes, 
                     valorretservicios as ivaservicios, 
                     valretserv100 as ivaservicios100 
                    from view_inv_transaccion
                   where tipo ='".$tipo."' and
                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc , true)." and 
                          (fecha  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )
                     order by fecha ";
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
 
  