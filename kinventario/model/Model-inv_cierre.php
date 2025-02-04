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
		
		$this->sesion 	 =     $_SESSION['email'];
		
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
 
	    $estado =     @$_POST["estado"];
	    
	    if ($estado == 'aprobado'){
	        
	        $result = '<img src="../../kimages/kdel.png"/>&nbsp;<b>FACTURA ANULADA NRO  ['.$id.']</b><br>';
	        
	        $sql = " UPDATE inv_movimiento
						   SET 	estado =".$this->bd->sqlvalue_inyeccion('anulado', true)." 
                           WHERE cierre = ".$this->bd->sqlvalue_inyeccion('N', true)."  and  
                                 id_movimiento=".$this->bd->sqlvalue_inyeccion($id, true)     ;
	        
	          $this->bd->ejecutar($sql);
	        
	          $this->K_kardex($id);
	        
	    }else{
	        $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>NO SE PUEDE ANULAR FACTURA NRO  ['.$id.']</b><br>';
	        
 	    }
	    
	      
		 echo $result;
	 
		
	}
 
	//-------------
	function AprobarComprobante($id,$fecha,$novedad){
	    
 
	    if (!empty($novedad)){
	        
	        $fechaa		 = $this->bd->fecha($this->hoy);
  	         
	        $sql = " UPDATE inv_movimiento
						   SET 	cierre =".$this->bd->sqlvalue_inyeccion('S', true).",
                                novedad=".$this->bd->sqlvalue_inyeccion($novedad, true).",
 								fechaa =".$fechaa."
						 WHERE fecha=".$this->bd->sqlvalue_inyeccion($fecha, true). ' and 
                               sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true)        ;
	        
	        $this->bd->ejecutar($sql);
	 
	        $result = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>CAJA CERRADA ['.$this->sesion.']</b><br>';
	        
 	        
	    }else{
	        
	        $result = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>REGISTRE NOVEDAD EN EL CIERRE ['.$this->sesion.']</b><br>';
	        
 	   
	    }
	        
	    echo $result;
	        
	}
 
	//------------------------------
	function K_kardex($id ){
 
	 	    
	    $sql_det = 'SELECT  a.cantidad,a.costo, a.idproducto,id_movimientod
				  from inv_movimiento_det a
				 where a.id_movimiento ='.$this->bd->sqlvalue_inyeccion($id, true);
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $idproducto        = $x['idproducto'];
	        $cantidad          = $x['cantidad'];
 	        
	              
	            $sql = 'UPDATE web_producto
						  SET  	egreso = egreso - '.$this->bd->sqlvalue_inyeccion($cantidad, true).',
  								saldo  = saldo + '.$this->bd->sqlvalue_inyeccion($cantidad, true).'
						  WHERE idproducto='.$this->bd->sqlvalue_inyeccion($idproducto, true);
	            
	            $this->bd->ejecutar($sql);
	            //--------------------------------------------------------------------------------
	   
	        
	        
	    }
	    
	    
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
if (isset($_GET['accion']))	{
	
	$accion    = $_GET['accion'];
	
	$id            = $_GET['id'];
	$fecha         = $_GET['fecha'];
	$novedad       = $_GET['novedad'];
	
 	
	if ($accion == 'aprobacion'){
	    
	    $gestion->AprobarComprobante($id,$fecha,$novedad);
	
	}else{
	
	    $gestion->consultaId($accion,$id);
	
	}
 
}

    //------ grud de datos insercion
    if (isset($_POST["action"]))	{
    	
    	$action = @$_POST["action"];
    	
    	$id =     @$_POST["id_movimiento"];
    	
    	$gestion->xcrud(trim($action),$id);
    	
    }



?>
 
  