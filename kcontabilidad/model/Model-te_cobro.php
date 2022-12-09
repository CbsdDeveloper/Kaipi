<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	private $saldos;
	
	
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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$comprobante,$idasiento){
		//inicializamos la clase para conectarnos a la bd
	
	    echo '<script type="text/javascript">accion('.$idasiento.','.$id.',"'.$accion.'","'.trim($comprobante).'"  );</script>';
 
	    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
	    
 
		
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
 				array( campo => 'apagar',     valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
		$datos = $this->bd->JqueryArrayVisor('view_cxp',$qquery );
		
		
		echo '<script> $("#monto_valida").val('.$datos["apagar"].');</script>';
 
		$result =  $this->div_resultado($accion,$id,'-',0). '['.$id.'] '.$accion;
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	function pago_proveedor($fecha,$id_asiento_banco,$detalle,$idprov  ){
	    
	    
	    
	    $cadena0 =  '( registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
	    $cadena1 = '( marca ='.$this->bd->sqlvalue_inyeccion(trim('S'),true).") and ";
	    $cadena3 = '( estado_pago ='.$this->bd->sqlvalue_inyeccion(trim('N'),true).") and ";
	    $cadena4 =  '( idprov = '.$this->bd->sqlvalue_inyeccion(trim($idprov),true).')   ';
	    
 	    $where = $cadena0.$cadena1.$cadena3.$cadena4;
	    
	    $sql = 'SELECT id_asiento, fecha, comprobante,idprov, beneficiario, detalle,  apagar
                from view_cxc
                where '. $where;
	    
 	      
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    $asientos_ref = '';
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $id_asientoref =  $fetch['id_asiento'] ;
	        
	        $asientos_ref =  $id_asientoref.' '.$asientos_ref;
	        
	        
	        //--------------------------------------------
	        
	        $xx = $this->bd->query_array('view_aux',
	                                     'cuenta, debe', 
                        	             'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asientoref,true). ' and 
                                         idprov='.$this->bd->sqlvalue_inyeccion($idprov,true). " and  tipo_cuenta = 'C'"
	            );
 
	        $apagar        =  $xx['debe'] ; 
	        $cuenta        =  $xx['cuenta'] ;  
 	            
	        //----------------------------------------------------
	        $detalle       =   trim($fetch['detalle']) . ' Asiento Ref.'. $id_asientoref ;  
	        /// asiento detalle
	        $id_asiento_banco_det = $this->saldos->_detalle_contable($fecha,$id_asiento_banco,$cuenta,0,$apagar);
	        
	        // auxiliar
	        $this->saldos->_aux_contable($fecha,$id_asiento_banco,$id_asiento_banco_det,$detalle,
	            $cuenta,$idprov,0,$apagar,$id_asientoref,'S','-');
	        
	        
	        ///----------------
	        $sql = "UPDATE co_asiento
						SET 	estado_pago  =".$this->bd->sqlvalue_inyeccion('S', true).",
                                marca =".$this->bd->sqlvalue_inyeccion('N', true).",
                                id_asiento_ref=".$this->bd->sqlvalue_inyeccion($id_asiento_banco, true)."
					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asientoref, true);
	        
	        $this->bd->ejecutar($sql);
	        
	    }
	    
	    $detalle1       =   trim($detalle) . ' Asientos Ref.'. $asientos_ref ;  
	    
	    $sql = "UPDATE co_asiento
    						SET 	detalle  =".$this->bd->sqlvalue_inyeccion($detalle1, true)."
    					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asiento_banco, true);
	    
	    $this->bd->ejecutar($sql);
	    
	}
	//--------------------pago_individual
	function pago_individual($fecha,$id_asiento_banco,$detalle,$idprov ,$id_asiento ,$saldo,$apagar){
	    
	    
	    $sql = "SELECT id_asiento,  detalle,     apagar , haber,cuenta
                FROM  view_asientocxp_aux
                where haber > 0 and
                      cuenta like '2%' and 
                	  registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                	  id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento,true);
	    
	    
	    
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $id_asientoref =  $fetch['id_asiento'] ;
	        $apagar        =  $apagar ;
	        $cuenta        =  $fetch['cuenta'] ;
	        $detalle       =  'Pago Efectuado'. trim($fetch['detalle']) . ' Asiento Ref.'. $id_asientoref ;
	        /// asiento detalle
	        $id_asiento_banco_det = $this->saldos->_detalle_contable($fecha,$id_asiento_banco,$cuenta,$apagar,0);
	        
	        // auxiliar
	        $this->saldos->_aux_contable($fecha,$id_asiento_banco,$id_asiento_banco_det,$detalle,
	            $cuenta,$idprov,$apagar,0,$id_asientoref,'S','-');
	        
	        
	        ///----------------
	        if ( $saldo > 0){
	         
	            $sql = "UPDATE co_asiento
    						SET 	estado_pago  =".$this->bd->sqlvalue_inyeccion('N', true).",
                                    marca  =".$this->bd->sqlvalue_inyeccion('N', true).",
                                    apagar =".$this->bd->sqlvalue_inyeccion($saldo, true).",
                                    id_asiento_ref=".$this->bd->sqlvalue_inyeccion($id_asiento_banco, true)."
    					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asientoref, true);
	            
	            $this->bd->ejecutar($sql);
	            
	        }else{
	            
	            $sql = "UPDATE co_asiento
    						SET 	estado_pago  =".$this->bd->sqlvalue_inyeccion('S', true).",
                                    marca =".$this->bd->sqlvalue_inyeccion('N', true).",
                                    id_asiento_ref=".$this->bd->sqlvalue_inyeccion($id_asiento_banco, true)."
    					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asientoref, true);
	            
	            $this->bd->ejecutar($sql);
	            
	            
	        }
    	       
	        $sql = "UPDATE co_asiento
    						SET 	detalle  =".$this->bd->sqlvalue_inyeccion($detalle, true)."
    					 WHERE id_asiento        =".$this->bd->sqlvalue_inyeccion($id_asiento_banco, true);
	        
	        $this->bd->ejecutar($sql);
	       
	        
	    }
	    
	    
	    
	}
	//aprobación de asientos
	function aprobacion($action, $id  ){

	    $id_asiento		= $id;
	    $idprov    		= trim($_POST["idprov"]);
	    
	    $cuentaBanco    = $_POST["idbancos"];
	    $bandera_pago   = $_POST["pago_tipo"];
	    $fecha			= $_POST["fecha"] ;
	    $cheque			= $_POST["cheque"];
	    //$tipo			= $_POST["tipo"];
	    
	    $comprobante    ='-';
	    $apagar			=   @$_POST["apagar"];
	    $apagar_total   =   @$_POST["monto_valida"];
 	    
	    
	    $detalle        =  $_POST["detalle"];
	    
	    $id_asiento_banco = $this->saldos->_asiento_contable($fecha,$detalle,'B',
	                                                         $comprobante,$id_asiento,
	                                                         'bancos' ,'000',$idprov);
  	     /// asiento detalle
	    $id_asiento_banco_det = $this->saldos->_detalle_contable($fecha,$id_asiento_banco,$cuentaBanco,$apagar,0);
	
	     // auxiliar
	     $this->saldos->_aux_contable($fecha,$id_asiento_banco,$id_asiento_banco_det,$detalle,
	                                  $cuentaBanco,$idprov,$apagar,0,0,'S',$cheque);
	     
	     
	     if ( $bandera_pago == 'S' ){
	         
	         $this->pago_proveedor($fecha,$id_asiento_banco,$detalle,$idprov);
	         
	     }
	     
	     
	       
	     $comprobante =  $this->saldos->_aprobacion($id_asiento_banco);
	     
	     if ($comprobante <> '-')	{
	         
	         $result =  $this->div_resultado('procesado',$id_asiento_banco,$comprobante,$id_asiento_banco);
	         
	     }else{
	         
	         $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>No se pudo actualizar y aprobar el asiento contable</b>';
	         
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
	function eliminar($id ){
		
  
 		
	}
	//--------------------------------------------------------------------------
	function _Comprobante($idbancos,$cheque){
		
	
	    $Acomprobante = $this->bd->query_array('co_plan_ctas',
	                                          'documento', 
	        'cuenta='.$this->bd->sqlvalue_inyeccion(trim($idbancos),true).' and 
            registro='.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)
	        );
	    
  
		
		$comp = $Acomprobante['documento'] ;
		
		$input= str_pad($comp, 8, "0", STR_PAD_LEFT);
		
		$contador = $comp + 1;
		
	  // actualiza cheque
		$sql = 'UPDATE co_plan_ctas
		 		       SET  documento ='.$this->bd->sqlvalue_inyeccion($contador, true)."
				   where tipo_cuenta  = 'B' AND
						    REGISTRO  = ".$this->bd->sqlvalue_inyeccion(trim($this->ruc),true). " AND
							cuenta    = ".$this->bd->sqlvalue_inyeccion($idbancos,true);
		
		$this->bd->ejecutar($sql);
		
 
		
		return $input ;
	}
//------
	function CambioEstado($estado,$id ,$idprove){
	    
	    
	    $sql = "update co_asiento
                   set marca =".$this->bd->sqlvalue_inyeccion($estado, true)."
                where id_asiento = ". $this->bd->sqlvalue_inyeccion($id, true). ' and 
                      idprov = '.$this->bd->sqlvalue_inyeccion($idprove, true) ;
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    $x = $this->bd->query_array('co_asiento','sum(apagar) as pago', 
            ' idprov='.$this->bd->sqlvalue_inyeccion($idprove,true). ' and 
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
	$id            		= $_GET['id'];
	  
	if ( $accion <>  'check') {
	    
	    $gestion->consultaId($accion,$id);
	    
	}else{
	    
	    $idprove            		= $_GET['idprove'];
	    
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
 
  