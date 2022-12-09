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
 	//-----------------------------------------------------------------------------------------------------------
	function _aux_cuentas_xpagar($id_tramite,$fecha,$id_asiento_banco,$id_asientoref, $id_asiento_banco_det,$tipo_prov,$partida,$detalle1,$cuenta,$comprobante_pago,$tipo_pago){
		 
 
	    
	    $sql = "SELECT  cuenta,idprov, detalle_cuenta,  partida,    haber 
                FROM   view_asientocxp_nomina
                where id_tramite = ".$this->bd->sqlvalue_inyeccion($id_tramite,true)." and  
                      modulo = ".$this->bd->sqlvalue_inyeccion($tipo_prov,true)." and 
                      cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta,true)." and 
                      partida = ".$this->bd->sqlvalue_inyeccion($partida,true);
     
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idprov = trim($fetch['idprov']);
	        
	        $cuenta = trim($fetch['cuenta']);
	        
	        $apagar = $fetch['haber'];
	        
	        $this->saldos->_aux_contable($fecha,$id_asiento_banco,$id_asiento_banco_det,$detalle1,
	            $cuenta,$idprov,$apagar,0,$id_asientoref,'S','-',$tipo_pago);
	        
	        $this->_actualizar_pago($id_asientoref,$comprobante_pago,$idprov);
	        
	    }
	        
	        
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function _detalle_pago_bancos($idbancos,$id_asiento_banco,$id_tramite,$tipo_prov,$fecha ,$detalle,$cheque,$comprobante,$tipo_pago){
		
	 	 
	    $xx = $this->bd->query_array('view_asientocxp_nomina',
	                                         'sum(haber) as pago', 
	                                         'id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true).' and 
                                              modulo='.$this->bd->sqlvalue_inyeccion($tipo_prov,true).' and
                                              cuenta like '.$this->bd->sqlvalue_inyeccion('2%',true).' and
                                              estado_pago='.$this->bd->sqlvalue_inyeccion('N',true)
	        );
	    
	    $apagar = $xx['pago'] ;
 
	    
	    /// asiento detalle
	    $id_asiento_banco_det = $this->saldos->_detalle_contable($fecha,$id_asiento_banco,$idbancos,0,$apagar,'');
	    
 
	    
	    $sql = "SELECT id_asiento,  idprov, sum(haber) as pago
	    FROM public.view_asientocxp_nomina
	    where id_tramite=".$this->bd->sqlvalue_inyeccion($id_tramite,true).' and 
              modulo='.$this->bd->sqlvalue_inyeccion($tipo_prov,true)." and cuenta like '2%' and
              estado_pago=".$this->bd->sqlvalue_inyeccion('N',true).' group by id_asiento,  idprov';


 
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idprov =  $fetch['idprov'] ;
	        $apagar =  $fetch['pago'] ;
	        
	        $this->saldos->_aux_contable_bancos($fecha,$id_asiento_banco,$id_asiento_banco_det,$detalle,
	            $idbancos,$idprov,0,$apagar,0,'S',$cheque,$tipo_pago,$comprobante);  
	        
	    }
	    
	    
	}
	
	//--------------------------------------------------------------------------------------
	function _actualizar_pago( $id_asientoref,$comprobante_pago,$idprov ){
	    
	     
	        $sql = "UPDATE co_asiento_aux
						SET 	comprobante  =".$this->bd->sqlvalue_inyeccion($comprobante_pago, true).",
                                pago  =".$this->bd->sqlvalue_inyeccion('S', true)."
					 WHERE id_asiento=".$this->bd->sqlvalue_inyeccion($id_asientoref, true). ' and 
                               idprov='.$this->bd->sqlvalue_inyeccion($idprov, true);
	        
	        $this->bd->ejecutar($sql);
	        
	    
	    
	}
	//--------------------pago_individual
	function _detalle_cxpagar($id_tramite,$fecha,$id_asiento_banco,$detalle,$id_asiento,$tipo_prov,$comprobante_pago,$tipo_pago){
	    
	    
	    $sql = "SELECT  cuenta, detalle_cuenta,  partida,   sum(haber) as haber 
                FROM view_asientocxp_nomina
                where id_tramite = ".$this->bd->sqlvalue_inyeccion($id_tramite,true)."  and  
                      modulo =  ".$this->bd->sqlvalue_inyeccion($tipo_prov,true)." and
                      cuenta like  ".$this->bd->sqlvalue_inyeccion('2%',true)." 
                group by cuenta, detalle_cuenta,  partida";

	    
 
	    
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $id_asientoref =  $id_asiento ;
	        $apagar        =  $fetch['haber'] ;
	        
	        $cuenta        =  trim($fetch['cuenta']) ;
	        $partida       =  trim($fetch['partida']) ;
	        
	        $detalle1        = 'Pago Efectuado'. substr(trim($detalle),0,150) . ' Asiento Ref.'. $id_asientoref ;
  
	        /// asiento detalle
	        
	        $id_asiento_banco_det = $this->saldos->_detalle_contable($fecha,$id_asiento_banco,$cuenta,$apagar,0,$partida);
	        
	        
	        $this->_aux_cuentas_xpagar($id_tramite,$fecha,$id_asiento_banco,$id_asientoref,$id_asiento_banco_det,
	            $tipo_prov,$partida,$detalle1,$cuenta,$comprobante_pago,$tipo_pago);
	        
 
	       
	      
	    }
	    
	    
	    
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
//------
	function CrearPago(  $id_asiento,$id_tramite, $fecha_pago, $detalle_pago,$idbancos,$tipo_pago ,$cheque,$comprobante,$tipo_prov){
	    
	    
	    $fecha			= $fecha_pago ;
	    $anio           =  $this->bd->_anio($fecha_pago);
	    $idprov         = '-';
	    $comprobante    ='-';
	    $detalle        =  substr(trim($detalle_pago),0,350);
	    $result         = $detalle;
	    
	    $bandera =  0;
	    
	    if ($this->bd->_cierre($fecha) == 'cerrado'){
	        
	        $bandera = -1;
	        $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO CERRADO '.$this->anio .'</b>';
	        
	    }
	    
	    
	    if ( $bandera == 0 ){
	        
	    
	    $id_asiento_banco = $this->saldos->_asiento_contable($fecha,$detalle,'F',
	        $comprobante,$id_asiento,
	        'bancos' ,'000',$idprov);
	    
	        
	        $comprobante_pago =  $this->_Comprobante_pago(trim($idbancos),'',$anio);
	        
	        $this->_detalle_pago_bancos($idbancos,$id_asiento_banco,$id_tramite,$tipo_prov,$fecha,$detalle,$cheque,$comprobante_pago,$tipo_pago);
	        
	        $this->_detalle_cxpagar($id_tramite,$fecha,$id_asiento_banco,$detalle,$id_asiento,$tipo_prov,$comprobante_pago,$tipo_pago);
	         
  	        
	    
	        if ($comprobante_pago <> '-')	{
	            
	            $comprobante =  $this->saldos->_aprobacion($id_asiento_banco);
	            
 	            
	            $result = '<img src="../../kimages/starok.png" align="absmiddle"/>&nbsp;<b>Asiento generado nro '.$id_asiento_banco.'</b>';
	            
	            
	        }else{
	            
	            $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>No se pudo actualizar y aprobar el asiento contable nro '.$id_asiento_banco.'</b>';
	            
	        }
	        
	    }
	        echo $result;
 
	    
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
	$id_asiento         = $_GET['id_asiento'];
	
	$id_tramite            		= $_GET['id_tramite'];
	$fecha_pago          		= $_GET['fecha_pago'];
	$detalle_pago          		= $_GET['detalle_pago'];
	$idbancos          		    = $_GET['idbancos'];
	$tipo_pago           		= $_GET['tipo'];
	$cheque           		= $_GET['cheque'];
	$comprobante            = $_GET['comprobante'];
	
	$tipo_prov            = $_GET['tipo_prov'];
	  
	
 
	
	if ( $accion == 'pago'){
	    
	    $gestion->CrearPago(  $id_asiento,$id_tramite, $fecha_pago, $detalle_pago,$idbancos,$tipo_pago ,$cheque,$comprobante,$tipo_prov);
	    
	}
 
     
	    
	 
	
	 
 
}
 


?>
 
  