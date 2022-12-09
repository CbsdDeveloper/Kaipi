<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
 	
	private $obj;
	private $bd;
	private $saldos;
	
	
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
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		$this->anio       =  $_SESSION['anio'];
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$comprobante,$idasiento){
		//inicializamos la clase para conectarnos a la bd
	
	    echo '<script type="text/javascript">accion('.$idasiento.','.$id.',"'.$accion.'","'.trim($comprobante).'"  );</script>';
 
	    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>PAGO REALIZADO CON EXITO... INFORMACION ACTUALIZADA ['.$id.']</b>';
	    
 
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
	 	$qquery = array(
 		        array( campo => 'id_asiento',    valor => $id,  filtro => 'S',   visor => 'S'),
 				array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'beneficiario',     valor => '-',  filtro => 'N',   visor => 'S'),
	 	        array( campo => 'id_tramite',     valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'apagar',     valor => '-',  filtro => 'N',   visor => 'S') 
		);
	 	
	 	
		
		$datos = $this->bd->JqueryArrayVisor('view_cxp',$qquery );
		
		$ACarpeta = $this->bd->query_array('view_asientocxp_aux',
		'sum(debe) as debe',
		"cuenta like '213.%' and
		 debe > 0  and anio = ".$this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
		 idprov = ".$this->bd->sqlvalue_inyeccion(trim($datos['idprov']),true) ." and
		 id_tramite = ".$this->bd->sqlvalue_inyeccion( $datos['id_tramite'],true)  
		 );

		 $idtramte = $datos['id_tramite'];

		 $pago = $datos["apagar"];

	    if ( $ACarpeta['debe'] >  0  ){

			$pago = $pago -  $ACarpeta['debe'] ;

			$ACarpeta1 = $this->bd->query_array('view_asientocxp_aux',
			'sum(haber) as haber',
			"cuenta like '213.%' and
			 haber > 0  and anio = ".$this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
			 idprov = ".$this->bd->sqlvalue_inyeccion(trim($datos['idprov']),true) ." and
			 id_tramite = ".$this->bd->sqlvalue_inyeccion( $idtramte,true)  
			 );

			$pago = $ACarpeta1['haber'] - $ACarpeta['debe'];

		}


	
/*
		$ACarpeta = $this->bd->query_array('view_asientocxp_aux',
		'debe',
		'id_tramite='.$this->bd->sqlvalue_inyeccion(trim($datos['id_tramite']),true)." and 
		 cuenta like '213.%' and
		 debe > 0  and 
		 idprov = ".$this->bd->sqlvalue_inyeccion(trim($datos['idprov']),true)
		 );

		 if ( $ACarpeta['debe'] >  0  ){
			$pago = $pago -  $ACarpeta['debe'] ;
		}*/



		
		echo '<script> $("#monto_valida").val('.$pago.');</script>';
		echo '<script> $("#apagar").val('.$pago.');</script>';
 
		$result =  $this->div_resultado($accion,$id,'-',0). '['.$id.'] '.$accion;
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	function _actualizar_pago($id_auxiliar,$comprobante_pago,$cuentaBanco,$comprobante,$tipo){
	    
	     
	        $sql = "UPDATE co_asiento_aux
						SET 	comprobante  =".$this->bd->sqlvalue_inyeccion(trim($comprobante_pago), true).",
                                tipo         =".$this->bd->sqlvalue_inyeccion(trim($tipo), true)."
					 WHERE id_asiento_aux     =".$this->bd->sqlvalue_inyeccion($id_auxiliar, true);
	        
	        $this->bd->ejecutar($sql);
	        
	    
	    
	}
	//--------------------pago_individual
	function pago_individual($fecha,$id_asiento_banco,$detalle,$idprov ,$id_asiento ,$saldo,$apagar_uno){
	    
 
	    
		   $sql = 'SELECT  id_asiento, cuenta,detalle_cuenta, detalle, sum(debe) as debe , sum(haber) haber,sum(haber) - sum(debe) as saldo_aux ,partida,id_tramite
					  FROM view_asientocxp_aux
					  where id_asiento= '.$this->bd->sqlvalue_inyeccion($id_asiento, true).' and 
							anio= '.$this->bd->sqlvalue_inyeccion($this->anio, true).' and 
							idprov = '.$this->bd->sqlvalue_inyeccion($idprov, true)." and cuenta like '213%'
							group by  cuenta,detalle_cuenta, detalle,   partida,id_tramite,id_asiento
							order by  haber desc, cuenta ";

							


	    
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $id_asientoref =  $fetch['id_asiento'] ;
	        
	        $id_tramite =  $fetch['id_tramite'] ;
 	        
 	        
	        $apagar        =  $fetch['saldo_aux'] ;

			$cuenta        =  trim($fetch['cuenta']) ;

			$partida  = trim($fetch['partida']) ;

			$ACarpeta = $this->bd->query_array('view_asientocxp_aux',
			'sum(debe) as debe',
			"cuenta = ".$this->bd->sqlvalue_inyeccion( $cuenta ,true)." and
			 debe > 0  and anio = ".$this->bd->sqlvalue_inyeccion( $this->anio ,true)." and
			 idprov = ".$this->bd->sqlvalue_inyeccion(trim( $idprov  ),true) ." and
			 partida = ".$this->bd->sqlvalue_inyeccion(trim( $partida  ),true) ." and
			 id_asiento <> ".$this->bd->sqlvalue_inyeccion(trim( $id_asientoref  ),true) ." and
			 id_tramite = ".$this->bd->sqlvalue_inyeccion(  $id_tramite ,true)  
			 );

 

             if ( $ACarpeta['debe'] >  0  ){
                $apagar = $apagar -  $ACarpeta['debe'] ;
            }
 
	        
	        $partida       =  trim($fetch['partida']) ;
	        
	        $detalle1        = 'Pago Efectuado '. substr(trim($fetch["detalle"]),0,200) . ' Asiento Ref.'. $id_asientoref. ' Nro.Tramite '.$id_tramite ;
  
	        /// asiento detalle
	        $id_asiento_banco_det = $this->saldos->_detalle_contable($fecha,$id_asiento_banco,$cuenta,$apagar,0,$partida);
	        
	        // auxiliar
	        $this->saldos->_aux_contable($fecha,$id_asiento_banco,$id_asiento_banco_det,$detalle1,
	                                     $cuenta,$idprov,$apagar,0,$id_asientoref,'S','-','S');
	        
	        
	        $sql = "UPDATE co_asiento
    						SET 	estado_pago  =".$this->bd->sqlvalue_inyeccion('S', true).",
                                    marca =".$this->bd->sqlvalue_inyeccion('N', true).",
                                    id_asiento_ref=".$this->bd->sqlvalue_inyeccion($id_asiento_banco, true)."
    					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asientoref, true);
	        
	        $this->bd->ejecutar($sql);
 
	        $detalle        = 'Pago Efectuado '. substr(trim($fetch["detalle"]),0,200) . ' Asiento Ref.'. $id_asientoref . ' Nro.Tramite '.$id_tramite ;
    	       
	        $sql = "UPDATE co_asiento
    						SET 	detalle  =".$this->bd->sqlvalue_inyeccion($detalle, true)."
    					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asiento_banco, true);
	        
	        $this->bd->ejecutar($sql);
	       
	        
	    }
	    
	    
	    
	}
	//aprobaci�n de asientos
	function aprobacion($action, $id  ){

	    $id_asiento		= $id;
	    $idprov    		= trim($_POST["idprov"]);
	    $cuentaBanco    = trim($_POST["idbancos"]);
	    $id_tramite     = trim($_POST["id_tramite"]);

	    $fecha			= $_POST["fecha"] ;
	    $cheque			= trim($_POST["cheque"]);
	    
	    $anio           =  $this->bd->_anio($fecha);
  	    
	    $comprobante    ='-';
	    $apagar			=   $_POST["apagar"];
 	    $saldo          =   $_POST["apagar"];
 	    $detalle        =   substr(trim($_POST["detalle"]),0,250).' Nro.Tramite '.$id_tramite;
	    $result         =   $detalle;
	    
	    $tipo_pago	    =   trim($_POST["tipo"]);
	    
	    $id_asiento_banco = $this->saldos->_asiento_contable($fecha,
	                        trim($detalle),'B',
                	        trim($comprobante),
	                        $id_asiento,
	                        'bancos' ,'000',trim($idprov),
	                        $id_tramite);
	    
       /// asiento detalle
       
       $id_asiento_banco_det = $this->saldos->_detalle_contable($fecha,$id_asiento_banco,trim($cuentaBanco),0,$apagar,'');
       
       // auxiliar
       $id_auxiliar = $this->saldos->_aux_contable($fecha,$id_asiento_banco,$id_asiento_banco_det,$detalle,
                                                   $cuentaBanco,$idprov,0,$apagar,0,'S',$cheque,$tipo_pago);
       
       
       $comprobante_pago =  $this->_Comprobante_pago($cuentaBanco,'',$anio);
       
       
       $this->pago_individual($fecha,$id_asiento_banco,$detalle,$idprov,$id_asiento,$saldo,$apagar);
 
       
       
	   $comprobante =  $this->saldos->_aprobacion($id_asiento_banco);
	     
	    if ($comprobante <> '-')	{
	         
	         $this->_actualizar_pago($id_auxiliar,$comprobante_pago,$cuentaBanco,$comprobante,$tipo_pago);
	        
	         $result =  $this->div_resultado('procesado',$id_asiento_banco,$comprobante,$id_asiento_banco);
	         
	     }else{
	         
	         $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>No se pudo actualizar y aprobar el asiento contable nro '.$id_asiento_banco.'</b>';
	         
	     }
 
		echo $result;
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
 		 
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
		// ------------------  eliminar
		if ($action == 'aprobacion'){
			
			$this->aprobacion($action,$id );
			
		}
		
	}
 
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
 
	//--------------------------------------------------------------------------
	function _Comprobante_pago($idbancos,$cheque,$anio){
		
	
	    $input          = $this->bd->_secuencias($anio, 'CE',8);
   
		
		return $input ;
	}
//------
	function CambioEstado($estado,$id ,$idprove){
	    
	    
	    $sql = "update co_asiento
                   set marca =".$this->bd->sqlvalue_inyeccion($estado, true)."
                where id_asiento = ". $this->bd->sqlvalue_inyeccion($id, true). " and 
                      anio      = ".$this->bd->sqlvalue_inyeccion($this->anio,true)." and
                      idprov = ".$this->bd->sqlvalue_inyeccion($idprove, true) ;
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    $x = $this->bd->query_array('co_asiento','sum(apagar) as pago', 
            ' idprov='.$this->bd->sqlvalue_inyeccion($idprove,true). ' and 
                anio= '.$this->bd->sqlvalue_inyeccion($this->anio,true).' and
             marca='.$this->bd->sqlvalue_inyeccion('S',true) 
	        
	        );
	    
	    
	    $mensajeEstado = $x['pago'];
	    
	    echo $mensajeEstado;
	    
	}
 
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
	
	$accion    		    = $_GET['accion'];
	$id            		= trim($_GET['id']);
	  
	if ( $accion <>  'check') {
	    
	    $gestion->consultaId($accion,$id);
	    
	}else{
	    
	    $idprove            		= trim($_GET['idprove']);
	    
 	    $gestion->CambioEstado($_GET['estado'],$id,$idprove);
	    
	}
	
	 
 
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 			=     $_POST["action"];
 	$id 				=     $_POST["id_asiento"];
 
   $gestion->xcrud( trim($action) ,  $id  );
 
	
}



?>
 
  