<?php
session_start( );

require '../../kconfig/Db.class.php';    
require '../../kconfig/Obj.conf.php';  


class proceso{
	
 
	
	private $obj;
	private $bd;
	private $bd_cat;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;

	private $ATablaPago;
	private $tabla ;
	private $secuencia;
	
	private $estado_periodo;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->bd_cat	   =	 	new Db ;

		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");     
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		 
		
		$this->ATablaPago = array(
		    array( campo => 'id_renpago',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
		    array( campo => 'formapago',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'tipopago',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'monto',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'idbanco',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'cuenta',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'fecha_pago',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
		    array( campo => 'fechad',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'fcreacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor =>$this->hoy 	, key => 'N'),
		    array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor =>'-' 	, key => 'N'),
		    array( campo => 'activo',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>'N' 	, key => 'N'),
		);
		
		
		
		$this->tabla 	  	  = 'rentas.ren_movimiento_pago';
		
		$this->secuencia 	     = 'rentas.ren_movimiento_pago_id_renpago_seq';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		if ($tipo == 0){
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			    
				if ($accion == 'del')
				    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
				    
		}
		
		if ($tipo == 1){
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
			
		}
		
		
 		
		return $resultado;
		
	}
 
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion(  $id  ){
		
	    $formapago                 =  $_POST["formapago"];
	    $pagado                    =  $_POST["pagado"];
	    $cuentabanco               =  $_POST["cuentabanco"];
	    $idbanco                   =  $_POST["idbanco"];
	    $fechadeposito             =  $_POST["fechadeposito"];
	    $id_par_ciu                =  $_POST["id_par_ciu"];
	    $fecha_pago                =  $_POST["fecha_pago"];
		$pantalla         		   =  $_POST["efectivo"];
		$bandera = 0;

		
	    $id_renpago                =  $_POST["id_renpago"];

 
		if (  $pagado > 0 ) 
		{
				$bandera = 1;
		} 
		else
		{
			if (   $pantalla  >=  $pagado  )   
			{
				$bandera   =  1;
				$efectivo  =  0;
			} 
		}
		
	    $this->ATablaPago[1][valor] =  $formapago;
	    $this->ATablaPago[6][valor] =  $fecha_pago;
	    $this->ATablaPago[2][valor] =  'caja';
	    
	    $this->ATablaPago[3][valor] =  $pagado;
	    $this->ATablaPago[4][valor] =  $idbanco;
	    $this->ATablaPago[5][valor] =  $cuentabanco;
	    
	    $this->ATablaPago[8][valor] =  $fechadeposito;
	    $this->ATablaPago[10][valor] =  $id_par_ciu;
 
	    
	    $result = '<b>INGRESE LA INFORMACION REQUERIDA...MONTO A PAGAR</b>';
	    
	    if ($formapago <> '-') {
	        
         	    if ( $bandera == 1 ) {
        	        
         	        if ($id_renpago > 0  ){
         	            
         	            $this->bd->_UpdateSQL($this->tabla,$this->ATablaPago,$id_renpago);
         	            
         	            $id = $id_renpago;

						 $this->DetallePago( $id,$id_par_ciu,$fecha_pago);
         	            
         	        }else {
         	            
         	            $id = $this->bd->_InsertSQL($this->tabla,$this->ATablaPago,   $this->secuencia  );

						 $this->DetallePago( $id,$id_par_ciu,$fecha_pago);
         	            
         	        }
        	        
        	        
        	        $result = $this->div_resultado('editar',$id,1);
        	        
        	    }
	    }else{
	        
	        $result = '<b>INGRESE LA INFORMACION REQUERIDA...FORMA DE PAGO</b>';
	    }
	   
	    
	 
	    echo $result   ;
	}
	
	//--------------------------------------------------------------------------------
	   
	//-----------------------------------------------------------
 
	function AprobarComprobante($id_par_ciu,$id_renpago){
	    
	    $hoy          = date("Y-m-d");

 	    $estado       = 'P';
 	    
 	    
 	    $sql = " UPDATE rentas.ren_movimiento
    			   SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
                        fechap=".$this->bd->sqlvalue_inyeccion($hoy, true).",
                        carga=".$this->bd->sqlvalue_inyeccion(0, true)."
      			 WHERE carga = 1 and
                       estado = 'E' and
                       sesion_pago=".$this->bd->sqlvalue_inyeccion( trim($this->sesion), true)."  and
                       id_par_ciu =".$this->bd->sqlvalue_inyeccion($id_par_ciu , true);
 	    
 	    
 	    $this->bd->ejecutar($sql);
 	    
 	    
 	  
 	    if ($id_renpago > 0  ) {
 	        
         	    $sql = " UPDATE rentas.ren_movimiento_pago
        						   SET 	activo=".$this->bd->sqlvalue_inyeccion('S', true)."
         						 WHERE id_renpago=".$this->bd->sqlvalue_inyeccion($id_renpago, true)." and  
								       sesion=".$this->bd->sqlvalue_inyeccion( trim($this->sesion), true);
          	   
        	   $this->bd->ejecutar($sql);

			   //----- ACTUALIZA SISTEMA DE CATASTRO
			  // $this->Actualiza_catastro($id_renpago);

		    // 	 $this->Actualiza_bomberos($id_renpago);

			   
 	    }
	        
 	    $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO [ '.$id_renpago.' ]</b>';
	        
	     echo $result;
	        
	}
//--------------------------
//------------------------------
	function K_comprobante($tipo ){
  
	        
	    $sql = "SELECT   coalesce(factura,0) as secuencia
        	    FROM web_registro
        	    where ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc   ,true);
	    
	        
	    $parametros 			= $this->bd->ejecutar($sql);
	    
	    $secuencia 				= $this->bd->obtener_array($parametros);
	     
	    $contador = $secuencia['secuencia'] + 1;
	    
	    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
	    
	    
	    $sqlEdit = "UPDATE web_registro
    			   SET 	factura=".$this->bd->sqlvalue_inyeccion($contador, true)."
     			 WHERE ruc_registro=".$this->bd->sqlvalue_inyeccion($this->ruc , true);
	    
	    
	    $this->bd->ejecutar($sqlEdit);
	    
	    return $input ;
	}
 //----------------------
 function Actualiza_catastro($id_renpago){

	$this->bd_cat->conectar_sesion_catastro();

	$sql = "select id_ren_movimiento, enlace
		      from  rentas.ren_movimiento
	         where estado = 'P' and  
			 	   enlace > 0 and 
				   id_renpago =" .$this->bd->sqlvalue_inyeccion($id_renpago,true);


	$stmt1 = $this->bd->ejecutar($sql);
	
	while ($fila=$this->bd->obtener_fila($stmt1)){
		$enlace=   $fila['enlace'] ;
		$this->externo_catastro($enlace);
	}	

}	 
/*
actualiza en bomberos
*/
function Actualiza_bomberos($id_renpago){
 
 
	$sql = "select id_ren_movimiento, enlace,documento
		      from  rentas.ren_movimiento
	         where estado = 'P' and  
			 	   enlace > 0 and 
				   id_renpago =" .$this->bd->sqlvalue_inyeccion($id_renpago,true);


	$stmt1 = $this->bd->ejecutar($sql);
	
	while ($fila=$this->bd->obtener_fila($stmt1)){
		$enlace   =   $fila['enlace'] ;
		$documento=   $fila['documento'] ;
		$this->externo_bomberos($enlace,$documento);
	}	



}	 
//-------------------------
function externo_bomberos($id_emite_externo,$documento){

	$servidor ='192.168.1.3';
	$base_datos = 'db_cbsd';
	$usuario = 'postgres';
	$password = 'Cbsd2019';

	$documento1 = trim($documento);
	
	$this->bd_cat->conectar_sesion_externo($servidor, $base_datos, $usuario, $password) ;

 


	$sql = "UPDATE recaudacion.tb_ordenescobro
                      set orden_estado = 'DESPACHADA',
					      fecha_despachado = ".$this->bd_cat->sqlvalue_inyeccion($this->hoy,true).",
						  fk_despacha = 98
                 where orden_id= ".$this->bd_cat->sqlvalue_inyeccion($id_emite_externo,true).' and 
				 	   orden_codigo='.$this->bd_cat->sqlvalue_inyeccion($documento1,true);
	
	$this->bd_cat->ejecutar($sql);  
	
 

					 
						$sql1 = "update  prevencion.tb_definitivoglp    set definitivo_estado = 'PAGADO' where definitivo_codigo =".$this->bd_cat->sqlvalue_inyeccion($documento1,true);
						$this->bd_cat->ejecutar($sql1);  

						$sql2 = "update  prevencion.tb_factibilidadglp  set factibilidad_estado = 'PAGADO' where factibilidad_codigo = ".$this->bd_cat->sqlvalue_inyeccion($documento1,true);
						$this->bd_cat->ejecutar($sql2);  

						$sql3 = "update  prevencion.tb_habitabilidad    set habitabilidad_estado = 'PAGADO' where habitabilidad_codigo = ".$this->bd_cat->sqlvalue_inyeccion($documento1,true);
						$this->bd_cat->ejecutar($sql3);  

						$sql4 = "update  prevencion.tb_inspecciones     set inspeccion_estado = 'PAGADO' where inspeccion_codigo =".$this->bd_cat->sqlvalue_inyeccion($documento1,true);
						$this->bd_cat->ejecutar($sql4);  

						$sql5 = "update  prevencion.tb_ocasionales      set ocasional_estado = 'PAGADO' where ocasional_codigo = ".$this->bd_cat->sqlvalue_inyeccion($documento1,true);
						$this->bd_cat->ejecutar($sql5);  

 
						$sql6 = "update  prevencion.tb_planesemergencia set plan_estado = 'PAGADO' where plan_codigo = ".$this->bd_cat->sqlvalue_inyeccion($documento1,true);
						$this->bd_cat->ejecutar($sql6);  

						$sql = "update  prevencion.tb_vbp set vbp_estado = 'PAGADO' where vbp_codigo = ".$this->bd_cat->sqlvalue_inyeccion($documento1,true);
						$this->bd_cat->ejecutar($sql);  
						

  
						


}	 

//--------------------------
function externo_catastro($id_emite_externo){

  
	$sql = "UPDATE emision.padron_catastral 
                      set estado = 'PAGADO'
                 where id_padron= ".$this->bd_cat->sqlvalue_inyeccion($id_emite_externo,true);
        
	$this->bd_cat->ejecutar($sql);

}	 	
	//--------------------
	function DetallePago($id,$id_par_ciu,$fecha_pago){
	    
	 
	    $sql = "select id_ren_movimiento ,carga ,total,documento
                    from  rentas.view_ren_movimiento_emitido
                    where id_par_ciu =" .$this->bd->sqlvalue_inyeccion($id_par_ciu,true)." and 
                          carga = 1";
 
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    
	    
 	    
	    while ($fila=$this->bd->obtener_fila($stmt1)){
	        
	        $id_ren_movimiento =   $fila['id_ren_movimiento'] ;
 
 	         
	        $sql = " UPDATE rentas.ren_movimiento
    			   SET 	id_renpago=".$this->bd->sqlvalue_inyeccion($id, true).",
                        fechap=".$this->bd->sqlvalue_inyeccion($fecha_pago, true).",
                    	sesion_pago=".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
      			 WHERE carga = 1 and 
                       estado = 'E' and 
                       id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id_ren_movimiento , true)." and
                       id_par_ciu =".$this->bd->sqlvalue_inyeccion($id_par_ciu , true);
	        
	        
	        $this->bd->ejecutar($sql);
	        
	    }
	    
	    
	}
	//----/----
	function Reversar($id_renpago){
	    
	    $hoy         = date("Y-m-d");
	    $time        = date("h:i:sa");
 
				
		$ACaja = $this->bd->query_array('par_usuario',
		'caja, supervisor, url,completo,tipourl',
		'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
		);
	
		$result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>NO TIENE PERMISOS PARA REALIZAR ESTA OPERACION</b>';

	
	if ($ACaja['supervisor'] == 'S'){
				
				$sql = " UPDATE rentas.ren_movimiento_pago
						SET 	reverso=".$this->bd->sqlvalue_inyeccion('S', true).",
								hora=".$this->bd->sqlvalue_inyeccion($time, true).",
								fecha_reverso=".$this->bd->sqlvalue_inyeccion($hoy, true).",
								sesion_reverso=".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
						WHERE reverso = 'N' and
							id_renpago =".$this->bd->sqlvalue_inyeccion($id_renpago , true);
				
				
				$this->bd->ejecutar($sql);
				
				
		
					$sql = " UPDATE rentas.ren_movimiento
										SET 	sesion_pago=".$this->bd->sqlvalue_inyeccion('', true).",
												id_renpago = 0, carga=0,
												doc_reverso=".$this->bd->sqlvalue_inyeccion($id_renpago, true).",
												estado=".$this->bd->sqlvalue_inyeccion('B', true)."
										WHERE id_renpago=".$this->bd->sqlvalue_inyeccion($id_renpago, true). ' and 
											estado='.$this->bd->sqlvalue_inyeccion('P', true). ' and 
											cierre='.$this->bd->sqlvalue_inyeccion('N', true);

					
					$this->bd->ejecutar($sql);
		
				
					$result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE REVERTIDO [ '.$id_renpago.' ]</b>';

				}


	    
	    echo $result;
	    
	}
 //----------------
	function anular_datos($id_renpago){
	    
	      
	    
	    $sql = " delete from  rentas.ren_movimiento_pago
      			 WHERE   id_renpago =".$this->bd->sqlvalue_inyeccion($id_renpago , true);
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    $sql = " UPDATE rentas.ren_movimiento
        						   SET 	sesion_pago=".$this->bd->sqlvalue_inyeccion('', true).",
                                        id_renpago = 0,
										carga= 0,
                                        estado=".$this->bd->sqlvalue_inyeccion('E', true)."
         						 WHERE id_renpago=".$this->bd->sqlvalue_inyeccion($id_renpago, true) ;
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE REVERTIDO [ '.$id_renpago.' ]</b>';
	    
	    echo $result;
	    
	}
///-------------------------------------------
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
 

    //------ grud de datos insercion
    if (isset($_POST["action"]))	{
    	
    	$action = $_POST["action"];
    	
    	$id =     $_POST["id_par_ciu"];
    	
    	if ( $action== 'editar'){
    	    
    	    $gestion->edicion($id);
    	    
    	}
    	
    	if ( $action== 'add'){
    	    
    	    $gestion->edicion($id);
    	    
    	}
    	
    	
    	if ( $action== 'aprobacion'){
    	    
    	    $id_renpago = $_POST["id_renpago"];
    	    
    	    $gestion->AprobarComprobante($id,$id_renpago);
    	    
    	}
    	
    }

//---------------------------
    if (isset($_GET["accion"]))	{
        
        $id =     $_GET["id"];
        
        $accion = trim($_GET["accion"]);
        
        if ($accion == 'anular'){
            $gestion->anular_datos($id);
        }else{
            $gestion->Reversar($id);
        }
        
        
    }
?>