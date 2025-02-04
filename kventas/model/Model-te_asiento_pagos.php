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
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$comprobante){
		//inicializamos la clase para conectarnos a la bd
	
		echo '<script type="text/javascript">accion_pago('.$id.',"'.$accion.'","'.trim($comprobante).'"  ) </script>';
 
 	
 		
		
		$resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>Registro por procesar</b>';
		
		
		
		if ($accion == 'pagado'){
 			$resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>Trasanccion generada... si desea anular vaya a la opcion de asientos</b>';
		
		}
		
		if ($accion == 'editar'){
 		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>Trasanccion por generar comprobante de pago</b>';
		    
		}
		
			
			if ($accion == 'procesado'){
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			}
				
		    if ($accion == 'del'){
		        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
		    }
				
 
		   
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	function consultaId_ingreso($accion,$id ){
	    
	    
	    $x = $this->bd->query_array('view_auxbancos',
	        'id_asiento_aux',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true) ." and
              tipo_cuenta  = 'B' and montoi > 0  "
	        );
	    
	    
	    
	    $qquery = array(
	        array( campo => 'id_asiento',    valor =>$id,  filtro => 'S',   visor => 'S'),
	        array( campo => 'id_asiento_aux',         valor => $x['id_asiento_aux'],  filtro => 'S',   visor => 'S'),
	        array( campo => 'pago',         valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'razon',     valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'cuenta_pago',     valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'monto',     valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'comprobante',     valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'retencion',     valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'cheque',  valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'tipo_cuenta',  valor => 'B',  filtro => 'S',   visor => 'N'),
	        array( campo => 'montoi',  valor => '-',  filtro => 'N',   visor => 'S')
	    );
	    
	    
	    $datos = $this->bd->JqueryArrayVisorDato('view_auxbancos',$qquery,0 );
	    
	    
	    $total = $datos['monto'] + $datos['montoi'];
	    
	    $pago = $datos['pago'] == 'S';
	    
	    if ( $datos['montoi'] > 0 ){
	        $pago = 'S';
	    }
	    
	    
	    
	    if ($pago == 'S'){
	        $accion = 'pagado';
	    }else{
	        $accion = 'editar';
	    }
	    
	    echo '<script type="text/javascript">
              $("#ruc_pago").val('."'". trim($datos['idprov']) ."'".');'.
              '$("#monto_pago").val('.  ($total)  .');'.
              '$("#comprobantePago").val('."'". ($datos['comprobante']) ."'".');'.
              '$("#asiento").val('."'". ($datos['id_asiento']) ."'".');'.
              '$("#tipo_pago").val('."'". (trim($datos['tipo'])) ."'".');'.
              '$("#cheque").val('."'". ($datos['cheque']) ."'".');'.
              '$("#enlace_pago").val('."'". 'I' ."'".');'.
              '$("#idbancos").val('."'". ($datos['cuenta_pago']) ."'".');'.
              '$("#id_asiento_aux").val('."'". ($datos['id_asiento_aux']) ."'".');'.
              '$("#pago").val('."'". ($datos['pago']) ."'".');'.
              '$("#razon").val('."'". trim($datos['razon']) ."'".');'.'</script>';
	    
	    
	    
	    if ($total == 0){
	        echo '<script type="text/javascript">cerrar_pago(1)</script>';
	    }else {
	        echo '<script type="text/javascript">cerrar_pago(0)</script>';
	    }
	    
	    
	    $result_pago =  $this->div_resultado($accion,$id,$datos['comprobante']). ' ['.$id.'] '.$accion;
	    
	    echo  $result_pago;
	}
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
		   
	    $x = $this->bd->query_array('view_auxbancos',
	        'id_asiento_aux',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true) ." and
              tipo_cuenta  = 'B' and monto > 0  "
	        );
	    
	    
		$qquery = array(
				array( campo => 'id_asiento',    valor =>$id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'id_asiento_aux',         valor => $x['id_asiento_aux'],  filtro => 'S',   visor => 'S'),
		    array( campo => 'pago',         valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'razon',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cuenta_pago',     valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'monto',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'retencion',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cheque',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'tipo_cuenta',  valor => 'B',  filtro => 'S',   visor => 'N'),
		        array( campo => 'montoi',  valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
		
		$datos = $this->bd->JqueryArrayVisorDato('view_auxbancos',$qquery,0 );
 		
		
		$total = $datos['monto'] + $datos['montoi'];
		
		$pago = $datos['pago'] == 'S';
		
		if ( $datos['montoi'] > 0 ){
		    $pago = 'S';
		}
		
	 
		
		if ($pago == 'S'){
			$accion = 'pagado';
		}else{
			$accion = 'editar';
		}
		
		echo '<script type="text/javascript">
              $("#ruc_pago").val('."'". trim($datos['idprov']) ."'".');'.
              '$("#monto_pago").val('.  ($total)  .');'.
		  	 '$("#comprobantePago").val('."'". ($datos['comprobante']) ."'".');'.
		  	 '$("#asiento").val('."'". ($datos['id_asiento']) ."'".');'.
 		  	 '$("#tipo_pago").val('."'". (trim($datos['tipo'])) ."'".');'.
 		  	 '$("#enlace_pago").val('."'". 'G' ."'".');'.
 		  	  		  	 '$("#cheque").val('."'". ($datos['cheque']) ."'".');'.
 		  	 '$("#idbancos").val('."'". ($datos['cuenta_pago']) ."'".');'.
		  	 '$("#id_asiento_aux").val('."'". ($datos['id_asiento_aux']) ."'".');'.
		  	 '$("#pago").val('."'". ($datos['pago']) ."'".');'.
		  	 '$("#razon").val('."'". trim($datos['razon']) ."'".');'.'</script>';
		
		
 
		if ($total == 0){
		    echo '<script type="text/javascript">cerrar_pago(1)</script>';
		}else {
		    echo '<script type="text/javascript">cerrar_pago(0)</script>';
		}
		 
 
		$result_pago =  $this->div_resultado($accion,$id,$datos['comprobante']). ' ['.$id.'] '.$accion;
		 
		echo  $result_pago;
	}
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
	function aprobacion($action,$id  ,$idasiento){
	    
  
	    //  cuenta_pago
	    
	    
	    $result_pago = '<b> NO SE PUEDE PROCESAR ESTA TRANSACCION - COMPROBANTES </b> ';
	    
	    $estadoa = $this->bd->query_array('co_asiento',
	        'estado,fecha,id_periodo',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true)
	        );
	    
	    
	    //$idbancos      =   trim($_POST["idbancos"]);
	    $anio           =  $this->bd->_anio($estadoa['fecha']);
 	    $fecha			=  $this->bd->fecha($estadoa['fecha']);
  	
  		//$cheque			= $_POST["cheque"];
 		$tipo			= $_POST["tipo_pago"];
 		
 	//	$comprobante    =  $this->_Comprobante_pago($idbancos,$cheque,$anio);
		
 		$tipo_pago    =  trim($_POST["enlace_pago"]);
 		
 		if ( $tipo_pago == 'G'){
 		    $comprobante          = $this->bd->_secuencias($anio, 'CE',8);
 		}else{
 		    $comprobante          = $this->bd->_secuencias($anio, 'CI',8);
 		}
 		
		 /*
		if (empty($idbancos)){
		    $result_pago = '<b> NO SE PUEDE PROCESAR ESTA TRANSACCION </b> ';
		    
		}else {
        		if (empty( $comprobante)){*/
         
         	 	    $sql = "UPDATE co_asiento
        						SET 	estado_pago  =".$this->bd->sqlvalue_inyeccion('S', true)."
        					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($idasiento, true);
        	 	    
        			 $this->bd->ejecutar($sql);
 
        			
        			$sql1 = " UPDATE co_asiento_aux
        						SET 	pago	     =".$this->bd->sqlvalue_inyeccion('S', true).",
        								cheque       =".$this->bd->sqlvalue_inyeccion(trim($_POST["cheque"]), true).",
        								tipo         =".$this->bd->sqlvalue_inyeccion(trim($tipo), true).",
        								fechap		 =".$fecha.",
        							    comprobante  =".$this->bd->sqlvalue_inyeccion( $comprobante, true)."
        					 WHERE id_asiento_aux    =".$this->bd->sqlvalue_inyeccion($id, true);
        			
        		 	$this->bd->ejecutar($sql1);
         			 	
        		 	$result_pago =  $this->div_resultado('procesado',$id,$comprobante).'-'.$id;
        			
      /*  		}
        	}
 */
		 
		echo $result_pago;
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,$idasiento){
		
		
		 
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
		// ------------------  eliminar
		if ($action == 'aprobacion'){
			
		    $this->aprobacion($action,$id,$idasiento );
			
		}
		
	}
 
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function _Comprobante_pago($idbancos,$cheque,$anio){
	    
	    
	    $Acomprobante = $this->bd->query_array('co_plan_ctas',
	        'documento',
	        'cuenta='.$this->bd->sqlvalue_inyeccion(trim($idbancos),true).' and
             anio = '.$this->bd->sqlvalue_inyeccion($anio,true).' and
             registro='.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)
	        );
	    
	    
	    
	    $comp = $Acomprobante['documento'] ;
	    
	    $input= str_pad($comp, 8, "0", STR_PAD_LEFT).'-'.$anio;
	    
	    $contador = $comp + 1;
	    
	    // actualiza cheque
	    $sql = 'UPDATE co_plan_ctas
		 		       SET  documento ='.$this->bd->sqlvalue_inyeccion($contador, true)."
				   where tipo_cuenta  = 'B' AND
						    registro  = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND
                            anio      = ".$this->bd->sqlvalue_inyeccion($this->anio,true)." and
							cuenta    = ".$this->bd->sqlvalue_inyeccion($idbancos,true);
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    
	    return $input ;
	}
	//--------------------------------------------------------------------------
	 
	/////////////// llena para consultar
}	
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['accionpago']))	{
	
	$accion    		    = $_GET['accionpago'];
	
	$id            		= $_GET['id'];
	
	if ( $accion == 'gasto'){
	    $gestion->consultaId($accion,$id);
	}else {
	    $gestion->consultaId_ingreso($accion,$id);
	}
 
}

//------ grud de datos insercion
if (isset($_POST["action_pago"]))	{
	
	$action 			=     $_POST["action_pago"];
	 
	$id 				=     $_POST["id_asiento_aux"];
	
	$idasiento 		    =     $_POST["asiento"];
 
	$gestion->xcrud( trim($action) ,  $id  ,$idasiento);
 
	
}



?>
 
  