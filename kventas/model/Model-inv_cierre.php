<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
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
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => 'Facturacion',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
				array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
				array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
				array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '00000',   filtro => 'N',   key => 'N'),
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'cierre',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
		    array( campo => 'base12',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'iva',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'base0',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'total',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		);
	 	
		$this->tabla 	  	  = 'inv_movimiento';
		
		$this->secuencia 	     = '-';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd

	    echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
	    
	    $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b><br>';
	    
	    
		if ($tipo == 0){
			
			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b><br>';
				
			if ($accion == 'del')
				$resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b><br>';
					
		}
		if ($tipo == 1){
 			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b><br>';
			
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
	function consultaId($accion,$id ){
		
 
		$qquery = array(  
		    array( campo => 'id_movimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S')
  		);
		
		$this->bd->JqueryArrayVisor('view_ventas_fac',$qquery );
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	
	
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		
		// ------------------  agregar
		if ($action == 'add'){
			
			$this->agregar();
			
		}
		// ------------------  editar
		if ($action == 'editar'){
			
			$this->edicion($id );
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
	}
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
 
	    $AEstado = $this->bd->query_array('inv_movimiento',
	        'estado, autorizacion, 	envio',
	        'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
	    
	    $result = '<b> REGISTRO NO ANULADO .... </b> '.$id ;
	    
	    
	    if (trim($AEstado['estado'])  == 'digitado'){
	        
	        $sql = 'delete from inv_movimiento_det  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
	        
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        $sql = 'delete from inv_movimiento  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
	        
	        
	        $this->bd->ejecutar($sql);
	        
	        
	        $result = $this->div_limpiar();
	        
	    }else{
	        
	       
 	                
	                $sql = "update inv_movimiento set estado = 'anulado'
                                 where id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
	                
	                $this->bd->ejecutar($sql);
	                
	                $result = $this->div_limpiar();
	                
	                $result = '<b> REGISTRO ANULADO .... </b> '.$id ;
 
 
	    }
	    
	    echo $result;
	 
		
	}
 /*
 */
function cambiar_sq($id){
	    
 		   
	$secuencia = $this->K_comprobante();

		$sql = " UPDATE inv_movimiento
					   SET 	comprobante =".$this->bd->sqlvalue_inyeccion( $secuencia  , true)."
 					 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true). ' and 
					       transaccion <> '.$this->bd->sqlvalue_inyeccion('E', true)        ;
		
		$this->bd->ejecutar($sql);
 
		$result = 'Secuencia generada!!!';
		
	 
		
	echo $result;
		
}

/**/ 
function duplicado_sq($id){
	    
 

		$sql = " UPDATE inv_movimiento
					   SET 	estado =".$this->bd->sqlvalue_inyeccion( 'anulado'  , true)."
 					 WHERE id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true)      ;
		
		$this->bd->ejecutar($sql);
 
		$result = 'Documento anulado !!!';
		
	 
		
	echo $result;
		
}

/*
*/
function K_comprobante( ){
    
    
    
    $sql = "SELECT   coalesce(factura,0) as secuencia
        	    FROM web_registro
        	    where ruc_registro = ".$this->bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro'])  ,true);
    
    
    $parametros 			= $this->bd->ejecutar($sql);
    
    $secuencia 				= $this->bd->obtener_array($parametros);
    
    $contador = $secuencia['secuencia'] + 1;
    
    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
    
    
    $sqlEdit = "UPDATE web_registro
    			   SET 	factura=".$this->bd->sqlvalue_inyeccion($contador, true)."
     			 WHERE ruc_registro=".$this->bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro']), true);
    
    
				  $this->bd->ejecutar($sqlEdit);
    
    
    return $input ;
}
/*
*/

	function AprobarComprobante($id,$fecha,$novedad){
	    
 
	    if (!empty($novedad)){
	        
	//       $fechaa		 = $this->bd->fecha($this->hoy);
  	         
	        $sql = " UPDATE inv_movimiento
						   SET 	cierre =".$this->bd->sqlvalue_inyeccion('S', true).",
                                novedad=".$this->bd->sqlvalue_inyeccion($novedad, true)."
						 WHERE fecha=".$this->bd->sqlvalue_inyeccion($fecha, true). ' and 
                               sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true)        ;
	        
	        $this->bd->ejecutar($sql);
	 
	        $result = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>CAJA CERRADA ['.$this->sesion.']</b><br>';
	        
 	        
	    }else{
	        
	        $result = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>REGISTRE NOVEDAD EN EL CIERRE ['.$this->sesion.']</b><br>';
	        
 	   
	    }
	        
	    echo $result;
	        
	}
	//---- 
	function secuencia_comprobante($fecha,$novedad,$comprobante){
	    
	    $result = '';
 
	    $contador = $comprobante  ;
	    
	    $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
	    
	    
	    $x = $this->bd->query_array('inv_movimiento',
	                                'count(*) as nn', 
	                                'comprobante='.$this->bd->sqlvalue_inyeccion($input,true).' and 
                                    tipo='.$this->bd->sqlvalue_inyeccion('F',true).' and
                                    registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true)
	                               );
	    
	    
	    $fecha     =    $this->bd->hoy();
	    
	    if (!empty($novedad)){
	        
	        if ( $x['nn'] > 0  ){
	            $result = $input;
	        }else{
	            //----------------------------------------
	                
	            $sql = "INSERT INTO inv_movimiento(	fecha, registro, detalle, sesion, creacion, 
                                                    comprobante, estado, tipo, id_periodo, documento, idprov, 
                                                    id_asiento_ref,  cierre, iva, base0, base12, total, 
                                                    novedad)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($novedad, true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion , true).",".
										        $fecha.",".
										        $this->bd->sqlvalue_inyeccion($input, true).",".
										        $this->bd->sqlvalue_inyeccion('anulado', true).",".
										        $this->bd->sqlvalue_inyeccion('F', true).",".
										        $this->bd->sqlvalue_inyeccion(1, true).",".
										        $this->bd->sqlvalue_inyeccion('ANU-001', true).",".
										        $this->bd->sqlvalue_inyeccion('9999999999999', true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).",".
										        $this->bd->sqlvalue_inyeccion('S', true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).",".
										        $this->bd->sqlvalue_inyeccion(0, true).",".
										        $this->bd->sqlvalue_inyeccion($novedad, true).")";
										         
										        $this->bd->ejecutar($sql);
										        
										      
										        
										        $result =  $this->bd->ultima_secuencia('inv_movimiento');
	        }
	        
	        
	    }
	    
 
	    
	    echo $result;
	    
	}
	//------------------------------
 
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
if (isset($_GET['accion']))	{
	
	$accion    = $_GET['accion'];
	
	$id            = $_GET['id'];
	$fecha         = $_GET['fecha'];
	$novedad       = $_GET['novedad'];
	
	if ($accion == 'aprobacion'){
	    
	    $gestion->AprobarComprobante($id,$fecha,$novedad);
	    
	} 
	    
	if ($accion == 'del'){
	        
	        $gestion->eliminar($id);
	        
	}
	    

	if ($accion == 'anulaa'){
	    
	    $fecha            = $_GET['fecha'];
	    $comprobante      = $_GET['comprobante'];
	    
	    $gestion->secuencia_comprobante($fecha,$novedad,$comprobante);
	    
	}

	 

	if ($accion == 'seq'){
	        
		$gestion->cambiar_sq($id);
		
   }
	 

   if ($accion == 'duplicado'){
	        
	$gestion->duplicado_sq($id);
	
}


   
 
}
 
?>
 
  