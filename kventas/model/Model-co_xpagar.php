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
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
	
	   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
 
		if ($tipo == 0){
			
			if ($accion == 'editar'){
				$resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b>';
			}
				
		    if ($accion == 'del'){
		    	$resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b>';
		    }
				
		    echo '<script type="text/javascript">DetalleAsientoIR();</script>';
		}
		
		if ($tipo == 1){
			
 			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Registro Actualizado</b>';
 			
 			echo '<script type="text/javascript">DetalleAsientoIR();</script>';
			
		}
		
		if ($tipo == 2){
			
			$resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Asiento aprobado</b>';
			
		}
 	
		
		return $resultado;
		
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
	
	//--------------------------------------------------------------------------------------
	//aprobación de asientos
	  
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		 
		// ------------------  editar
		if ($action == 'editar'){
			
			$this->edicion($id);
			
		}
		// ------------------  eliminar
		 
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function total_gasto( ){
	    
	    $baseimpgrav     = @$_POST["baseimpgrav"];
	    $baseimponible   = @$_POST["baseimponible"];
	    $basenograiva    = @$_POST["basenograiva"];
	    $montoiva        = 0;
	    $montoice        = 0;
	    $descuento       = @$_POST["descuento"];
	    
	    $total = ($baseimpgrav + $baseimponible + $basenograiva + $montoiva + $montoice ) -  $descuento;
	    
	    return $total;
	    
	}
	function total_gastoIVA( ){
	    
	    $baseimpgrav     = 0;
	    $baseimponible   = 0;
	    $basenograiva    = 0;
	    $montoiva        = @$_POST["montoiva"];
	    $montoice        = 0;
	    $descuento       = 0;
	    
	    $total = ($baseimpgrav + $baseimponible + $basenograiva + $montoiva + $montoice ) -  $descuento;
	    
	    return $total;
	    
	}
	function total_gastoICE( ){
	    
	    $baseimpgrav     = 0;
	    $baseimponible   = 0;
	    $basenograiva    = 0;
	    $montoiva        = 0;
	    $montoice        = @$_POST["montoice"];
	    $descuento       = 0;
	    
	    $total = ($baseimpgrav + $baseimponible + $basenograiva + $montoiva + $montoice ) -  $descuento;
	    
	    return $total;
	    
	}
	//-----------------------------------------------
	function total_iva( ){
	    
	    $valorretbienes      = @$_POST["valorretbienes"];
	    $valorretservicios   = @$_POST["valorretservicios"];
	    $valretserv100       = @$_POST["valretserv100"];
	     
	    
	    $total =  $valorretbienes + $valorretservicios + $valretserv100  ;
 
	    
	    return $total;
	    
	}
	
	//-----------------------------------------------
	function apagar_asiento( $idasiento, $apagar ){
	    
	    $sql = " UPDATE co_asiento
							    SET 	apagar      =".$this->bd->sqlvalue_inyeccion($apagar, true)."
 							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
	    $this->bd->ejecutar($sql);
	    
 
	    return 1;
	    
	}
	//-----------------------------------------------
	function movi_asiento( $idasiento, $idmov ){
	    
	    $sql = " UPDATE co_asiento
							    SET 	idmovimiento      =".$this->bd->sqlvalue_inyeccion($idmov, true)."
 							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    //-----------------------------------------------------------
	    $sql = " UPDATE inv_movimiento
							    SET 	id_asiento_ref      =".$this->bd->sqlvalue_inyeccion($idasiento, true)."
 							      WHERE id_movimiento   =".$this->bd->sqlvalue_inyeccion($idmov, true);
	    
	    $this->bd->ejecutar($sql);
	    
	    return 1;
	    
	}
	//-----------------------
	function total_ir_add( $idasiento,$idcompra,$secuencia ){
	    
	    $codretair       = @$_POST["codretair"];
	    $baseimponible   = @$_POST["baseimpair"];
	 
 	    
	    $sql1 = "SELECT valor1
         		        FROM co_catalogo
        		       WHERE tipo = 'Fuente de Impuesto a la Renta' and
                             activo = 'S' and codigo=".$this->bd->sqlvalue_inyeccion($codretair ,true);
	    
	    $Amonto = $this->bd->ejecutar($sql1);
 	    $Aporcentaje = $this->bd->obtener_array( $Amonto);
	    
	    $porcentaje = $Aporcentaje['valor1'] /100 ;
	    
	    $total = round($porcentaje * $baseimponible,2) ;
	    
	    
	    //----------------------------------
	/*    $sql = "INSERT INTO co_compras_f(
                    id_compras, id_asiento, secuencial, codretair, baseimpair, porcentajeair, valretair )
            VALUES (".
            $this->bd->sqlvalue_inyeccion($idcompra, true).",".
            $this->bd->sqlvalue_inyeccion($idasiento, true).",".
            $this->bd->sqlvalue_inyeccion($secuencia, true).",".
            $this->bd->sqlvalue_inyeccion(trim($codretair), true).",".
            $this->bd->sqlvalue_inyeccion($baseimponible, true).",".
            $this->bd->sqlvalue_inyeccion($Aporcentaje['valor1'] , true).",".
            $this->bd->sqlvalue_inyeccion($total, true).")";
            
            
            $this->bd->ejecutar($sql);
	    
	    */
	    
	    return $total;
	    
	}
	//----------------------------------------------------
	function agregar( $idmovimiento ){
	 
	    $result = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Transaccion actualizada</b>';
	    
	    
	    $AResultado = $this->bd->query_array('inv_movimiento',
	                                         'fecha,   detalle,   id_periodo, documento, idprov, id_asiento_ref, comprobante', 
	                                         'id_movimiento='.$this->bd->sqlvalue_inyeccion($idmovimiento,true)
	                                          );
	    
  
	  if ( empty($AResultado['id_asiento_ref']) )  {
 	 
	    $id_periodo  = $AResultado["id_periodo"];
	    $fecha		 = $this->bd->fecha($AResultado["fecha"]);
 		$cuenta      =  '-';
 		$estado      = 'digitado';
 	//	$secuencial   = $AResultado["documento"];
 		
		//------------ seleccion de periodo
 		$periodo_s = $this->bd->query_array('co_periodo',
 		                                     'mes,anio',
											'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo ,true));
 		
 		$mes  			= $periodo_s["mes"];
		$anio  			= $periodo_s["anio"];
 		
		$comprobante    = '-';
		
 	
		
		//------------------------------------------------------------
		$sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                						comprobante, estado, tipo, documento,idprov,cuentag,
                                        id_periodo)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion($AResultado["detalle"], true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->hoy.",".
										        $this->bd->sqlvalue_inyeccion('cxpagar', true).",".
										        $this->bd->sqlvalue_inyeccion($comprobante, true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion('F', true).",".
										        $this->bd->sqlvalue_inyeccion($AResultado["documento"] , true).",".
										        $this->bd->sqlvalue_inyeccion($AResultado["idprov"] , true).",".
										        $this->bd->sqlvalue_inyeccion($cuenta , true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
        
     
        	 	$this->bd->ejecutar($sql);
        		
                 $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
                
                 $this->movi_asiento( $idAsiento, $idmovimiento );
               
                
                 $this->AnexosTransacional($idAsiento);
               
              
                //------ AGREGA DETALLES PARA LA CONTABILIDAD
                 
                $result = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Transaccion actualizada</b>';
	     }
	     
		 echo $result;
		
	}
 
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
		
	 	$estado   = @$_POST["estado"];
	 	$idprov   = @$_POST["idprov"];
	 	$cuenta   = @$_POST["cuenta"];
	 	$secuencial =   @$_POST["secuencial"];
	 	/*
	 	$fecha		 = $this->bd->fecha(@$_POST["fecha"]);
	 	$periodo_s   = $this->bd->query_array('co_periodo',
	 	    'mes,anio',
	 	    'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                          	id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo ,true));
	
	 	$mes  			= $periodo_s["mes"];
	 	$anio  			= $periodo_s["anio"];
	 	*/
		
		if (trim($estado) == 'digitado'){
			
		    $total_gasto    = $this->total_gasto();
		    $iva_total      = $this->total_gastoIVA();
		    $iva_ICE        = $this->total_gastoICE();
		    $iva_retencion  = $this->total_iva();
		    
		    
		 			$sql = " UPDATE co_asiento
							    SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["detalle"]), true).",
								        idprov       =".$this->bd->sqlvalue_inyeccion(trim($idprov), true).",
										cuentag      =".$this->bd->sqlvalue_inyeccion(trim($cuenta), true).",
										documento    =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["documento"]), true)."
							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($id, true);
					
					$this->bd->ejecutar($sql);
				
					$id_compras = $this->AnexosTransacional($id);
			
					$totalir = $this->total_ir_add( $id,$id_compras,$secuencial );
					
					//--- actualiza valor a pagar....
					$apagar = ($total_gasto + $iva_total + $iva_ICE) - ($iva_retencion + $totalir);
					
					$this->apagar_asiento( $id, $apagar );
					
      
		}	
		
 
		
		$result = $this->div_resultado('editar',$id,1,$estado);
 
		echo $result;
	}
	
 
//------------------
 function AnexosTransacional($id_asiento){
	 
     $sql = "SELECT count(*) as contador
    			  FROM co_compras
    			  WHERE registro =".$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
    			  	    id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento ,true);
					    
	 // saca valor a un arreglo				    
	 $valida_asiento 	= $this->bd->ejecutar($sql);
	 $existe_anexos 	= $this->bd->obtener_array($valida_asiento);
					    
	 $tpidprov = '01';
	 $fecharegistro			= $this->bd->fecha(@$_POST["fecha"]);
	 $fechaemision			= $this->bd->fecha(@$_POST["fechaemision"]);
	 $establecimiento		= substr(@$_POST["serie"],0,3);
	 $puntoemision			= substr(@$_POST["serie"],3,3);
	 $idprov				= @$_POST["idprov"];
	 //--- valida 				    
	 if ($existe_anexos["contador"] > 0){
					        
			 $id_compras				= @$_POST["id_compras"];
					        
			 $sql = " UPDATE co_compras
        					   SET 	codsustento      =".$this->bd->sqlvalue_inyeccion(@$_POST["codsustento"], true).",
        							idprov           =".$this->bd->sqlvalue_inyeccion(trim($idprov), true).",
        							tipocomprobante  =".$this->bd->sqlvalue_inyeccion(@$_POST["tipocomprobante"], true).",
        							fecharegistro    =".$fecharegistro.",
                                  	establecimiento  =".$this->bd->sqlvalue_inyeccion($establecimiento, true).",
        							puntoemision     =".$this->bd->sqlvalue_inyeccion($puntoemision, true).",
        							secuencial       =".$this->bd->sqlvalue_inyeccion(@$_POST["secuencial"], true).",
        							fechaemision     =".$fechaemision.",
        							autorizacion     =".$this->bd->sqlvalue_inyeccion(@$_POST["autorizacion"], true).",
        							basenograiva     =".$this->bd->sqlvalue_inyeccion(@$_POST["basenograiva"], true).",
        							baseimponible    =".$this->bd->sqlvalue_inyeccion(@$_POST["baseimponible"], true).",
        							baseimpgrav      =".$this->bd->sqlvalue_inyeccion(@$_POST["baseimpgrav"], true).",
        							baseimpair       =".$this->bd->sqlvalue_inyeccion(@$_POST["baseimpair"], true).",
         							montoice         =".$this->bd->sqlvalue_inyeccion(@$_POST["montoice"], true).",
                    				montoiva         =".$this->bd->sqlvalue_inyeccion(@$_POST["montoiva"], true).",
        							valorretbienes   =".$this->bd->sqlvalue_inyeccion(@$_POST["valorretbienes"], true).",
        							porcentaje_iva   =".$this->bd->sqlvalue_inyeccion(@$_POST["porcentaje_iva"], true).",
        							valorretservicios=".$this->bd->sqlvalue_inyeccion(@$_POST["valorretservicios"], true).",
          							valretserv100    =".$this->bd->sqlvalue_inyeccion(@$_POST["valretserv100"], true)."
        					 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id_asiento, true);
					        
					        $this->bd->ejecutar($sql);
					        
		} else {
			 //------------------------------------------------------------
			 $sql = "INSERT INTO co_compras(
                    id_asiento, codsustento, tpidprov, idprov, tipocomprobante,
                    fecharegistro, establecimiento, puntoemision, secuencial, fechaemision,
                    autorizacion, basenograiva, baseimponible, baseimpgrav, montoice,
                    montoiva, valorretbienes, valorretservicios, valretserv100, porcentaje_iva,baseimpair,registro)
            VALUES (".
            $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["codsustento"], true).",".
            $this->bd->sqlvalue_inyeccion($tpidprov, true).",".
            $this->bd->sqlvalue_inyeccion(trim($idprov), true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["tipocomprobante"], true).",".
            $fecharegistro.",".
            $this->bd->sqlvalue_inyeccion($establecimiento, true).",".
            $this->bd->sqlvalue_inyeccion($puntoemision, true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["secuencial"], true).",".
            $fechaemision.",".
            $this->bd->sqlvalue_inyeccion(@$_POST["autorizacion"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["basenograiva"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["baseimponible"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["baseimpgrav"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["montoice"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["montoiva"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["valorretbienes"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["valorretservicios"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["valretserv100"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["porcentaje_iva"], true).",".
            $this->bd->sqlvalue_inyeccion(@$_POST["baseimpair"], true).",".
            $this->bd->sqlvalue_inyeccion($this->ruc, true).")";
            
            $this->bd->ejecutar($sql);
            
            $id_compras = $this->bd->ultima_secuencia('co_compras');
            
		 }
		 
					    
		 return $id_compras;
	 }
	//----------------------------
	/* function K_fuente($id_asiento,$id_compras){
	     
	     $codretair  = @$_POST["codretair"];
	     $baseimpair = @$_POST["baseimpair"];
	     $secuencial = @$_POST["secuencial"];
	     
	     $sql1 = "SELECT valor1
         		        FROM co_catalogo
        		       WHERE tipo = 'Fuente de Impuesto a la Renta' and
                             activo = 'S' and codigo=".$this->bd->sqlvalue_inyeccion($codretair ,true);
	     
	     $resultado_p = $this->bd->ejecutar($sql1);
 	     $datos_p = $this->bd->obtener_array( $resultado_p);
	     
	     $porcentajeair = $datos_p['valor1'] ;
 	     $valretair = $baseimpair * ($porcentajeair/100);
	     //--- valida sumas
	     //--- total
	     $sql2 = "SELECT sum(baseimpair) as t1  
                    FROM co_compras_f  
                   WHERE id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento ,true);
	     
	     $resultado2 = $this->bd->ejecutar($sql2);
 	     $datos2 = $this->bd->obtener_array( $resultado2);
 	     $valida =  $datos2['t1'] ;
	     
	     
	     if ($valida <= $baseimpair ){
	         
	         $sql2 = "SELECT count(*) as t1  
                        FROM co_compras_f
                	   WHERE id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento ,true)." and
                		     codretair=".$this->bd->sqlvalue_inyeccion($codretair ,true);
	         
	         $resultado21 = $this->bd->ejecutar($sql2);
	         $datos21     = $this->bd->obtener_array( $resultado21);
	         
	         if ($datos2['t1'] == 0){
	             
	             $sql = 'INSERT INTO co_compras_f (
                						id_compras, id_asiento, secuencial, codretair, baseimpair, porcentajeair, valretair)
                				VALUES ('.$this->bd->sqlvalue_inyeccion($id_compras, true).",".
                				$this->bd->sqlvalue_inyeccion($id_asiento, true).",".
                				$this->bd->sqlvalue_inyeccion($secuencial, true).",".
                				$this->bd->sqlvalue_inyeccion($codretair , true).",".
                				$this->bd->sqlvalue_inyeccion($baseimpair, true).",".
                				$this->bd->sqlvalue_inyeccion($porcentajeair , true).",".
                				$this->bd->sqlvalue_inyeccion($valretair, true).")";
                				
                				$this->bd->ejecutar($sql);
	         }
	     }
	 } */
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['accion']))	{
	
	 
	$id            =  $_GET['idmovimiento'];
	  
	$gestion->agregar($id);
 
	
}
//------ poner informacion en los campos del sistema

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 		=     @$_POST["action"];
	
	$id 			=     @$_POST["id_asiento"];
	 
 	$gestion->xcrud(trim($action) ,  $id  );
 
	
}



?>
 
  