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
	
	private $ATabla;
	private $tabla ;
	private $secuencia;
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
		
		$this->anio       =  $_SESSION['anio'];
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
		
		$this->ATabla = array(
				array( campo => 'cuenta',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'cuentas',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'nivel',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'univel',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'aux',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo_cuenta',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'debe',   tipo => 'numeric',   id => '10',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'haber',   tipo => 'numeric',   id => '11',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'saldo',   tipo => 'numeric',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'impresion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'documento',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'comprobante',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'debito',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'credito',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'partida_enlace',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'deudor_acreedor',   tipo => 'VARCHAR2',   id => '20',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'anio',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => $this->anio   ,   filtro => 'N',   key => 'N'),
				array( campo => 'cuenta_ing',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
  		);
		
		  

		$this->tabla 	  		    = 'co_plan_ctas';
		
		$this->secuencia 	     = '';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
		echo '<script type="text/javascript">';
		
		echo  '$("#action").val("'.$accion.'");';
		
 		
		echo '</script>';
		
		
		
		
		if ($tipo == 0){
			
			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			    if ($accion == 'del')
			        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
			        
		}
		
		if ($tipo == 1){
			
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
		}
		
		
		return $resultado;
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
 
		
		
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
 
		
	}
	
	
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
 
		$qquery = array(
				array( campo => 'cuenta',   valor =>$id,  filtro => 'S',   visor => 'S'),
		        array( campo => 'anio',   valor =>$this->anio ,  filtro => 'S',   visor => 'S'),
				array( campo => 'cuentas',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'nivel',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'univel',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'debito',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'credito',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'deudor_acreedor',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'partida_enlace',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'impresion',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'documento',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'aux',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo_cuenta',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cuenta_ing',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'registro',   valor => 	$this->ruc  ,  filtro => 'S',   visor => 'N')
		);
		
 $this->bd->JqueryArrayVisorObj('co_plan_ctas',$qquery,0 );
		
		$result =  $this->div_resultado($accion,$id,0);
		
	 			
		
		echo  $result;
	}
	
  
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		
		// ------------------  agregar
		if ($action == 'add'){
			
			$this->agregar( );
			
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
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar(   ){
		
	
		$id1		  =  @$_POST["cuenta"];
		$cuenta		  =  trim($id1);
		$id		      =  @$_POST["cuentas"];
		$cuentas      =  trim($id);
		
	//	$impresion    = trim(substr(trim($id),0,1));
		
 		$sql_nivel = "SELECT nivel
	                   FROM co_plan_ctas
                               WHERE cuenta =".$this->bd->sqlvalue_inyeccion($cuentas,true) .' and 
                                       anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true) .' and 
                                     registro = '.$this->bd->sqlvalue_inyeccion($this->ruc, true);
		
		$resultado1 =  $this->bd->ejecutar($sql_nivel);
		
		$datos_nivel = $this->bd->obtener_array( $resultado1);
		
		$nivel = $datos_nivel['nivel'] + 1;
 
		
		$this->ATabla[0][valor] = $cuenta;
		$this->ATabla[1][valor] =  $cuentas;
		$this->ATabla[3][valor] =  $nivel;
		$this->ATabla[9][valor] =  $this->ruc;
		
		
		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,'NO');
		
		$result = $this->div_resultado('editar',$id,1);
		
		echo $result;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
 
		
	 $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$result = $this->div_resultado('editar',$id,1);
		
 
		echo $result;
	}
	
	function activa_cuenta_si( $id,$estado  ){
	    
		if ( $estado  == 'S'){
		
			$sql = "update  co_plan_ctas
			set estado = 'S' 
					where cuenta=".$this->bd->sqlvalue_inyeccion(trim($id), true).' and
						   anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' and
						  registro='.$this->bd->sqlvalue_inyeccion($this->ruc, true);

		}	else{

			$sql = "update  co_plan_ctas
			set estado = 'N', univel='N'
					where cuenta=".$this->bd->sqlvalue_inyeccion(trim($id), true).' and
						   anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' and
						  registro='.$this->bd->sqlvalue_inyeccion($this->ruc, true);

		}		

	   
	    
 
	    $this->bd->ejecutar($sql);
	    
	    
	    echo 'Cuenta Inactiva = '.$id.' verifique la informacion' ;
	}
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	
	function activa_cuenta($id ){
	    
	    $sql = "update  co_plan_ctas
                 set estado = 'N', univel='N'
						 where cuenta=".$this->bd->sqlvalue_inyeccion(trim($id), true).' and
                                anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' and
					  	     registro='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
	    
 
	    $this->bd->ejecutar($sql);
	    
	    
	    echo 'Cuenta Inactiva = '.$id.' verifique la informacion' ;
	}
	//---------------
	
	function activa_sigef($id,$estado ){
	    
	    $sql = "update  co_plan_ctas
                 set impresion = ".$this->bd->sqlvalue_inyeccion(trim($estado), true)." 
						 where cuenta=".$this->bd->sqlvalue_inyeccion(trim($id), true).' and
                                anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' and
					  	     registro='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	    echo 'Cuenta activada  '.$id.' verifique la informacion' ;
	}
	//--------------------------------------------------------------------------------
	
	function eliminar($id ){
		
	   
	    
   $sql = "SELECT count(*) as nro_registros
	       FROM co_asientod
           where cuenta = ".$this->bd->sqlvalue_inyeccion($id ,true).' and 
                 anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' and 
				 registro='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
		
		$resultado = $this->bd->ejecutar($sql);
		
		$datos_valida = $this->bd->obtener_array( $resultado);
		
		if ($datos_valida['nro_registros'] == 0){
			
			$sql = 'delete 
                          from co_plan_ctas 
						 where cuenta='.$this->bd->sqlvalue_inyeccion($id, true).' and
                                anio = '.$this->bd->sqlvalue_inyeccion($this->anio ,true).' and 
					  	     registro='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
			
			$this->bd->ejecutar($sql);
			
			$result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINADO REGISTRO TRANSACCION ?</b>';
			
			$this->div_limpiar();
			
		}else {
		    
		    $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>NO SE PUEDE ELIMINAR ESTE REGISTRO?</b>';
		    
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
	
	$accion    = $_GET['accion'];
	
 	$id2       = $_GET['id'];
	
	$id1  		= str_replace("'",'',$id2);
	
	$accion		=      str_replace("'",'',$accion);
 	 
	if ( $accion == 'activa'){
	    
	    $gestion->activa_cuenta($id2);
	    
	}elseif  ($accion == 'impresion'){
	    
	    $estado = $_GET['estado'];
	    
	    $gestion->activa_sigef($id2,$estado);
	    
	}elseif  ($accion == 'estado_cuenta'){
	    
	    $estado = $_GET['estado'];
	    
	    $gestion->activa_cuenta_si($id2,$estado);
	    
	}else{
	    $gestion->consultaId($accion,$id1);
	}

	
	 
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = @$_POST["action"];
	
	$id =     @$_POST["cuenta"];
	
	$gestion->xcrud(trim($action),trim($id) );
	
}



?>
 
  