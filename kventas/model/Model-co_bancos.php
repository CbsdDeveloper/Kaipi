<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 

class proceso{
	
 
	
	private $obj;
	private $bd;
	private $saldos;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	
	private $ATabla;
	private $tabla ;
	private $secuencia;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		
		
		$this->hoy 	     =   date("Y-m-d");  
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
 		
		
		$this->ATabla = array(
		    array( campo => 'id_concilia',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
		    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
		    array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
		    array( campo => 'creacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => $this->hoy 	, key => 'N'),
		    array( campo => 'estado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => 'digitado', key => 'N'),
		    array( campo => 'cuenta',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'saldobanco',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'notacredito',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'notadebito',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'saldoestado',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'cheques',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'depositos',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N')
		);
		
		$this->tabla 	  	  = 'co_concilia';
		
		$this->secuencia 	     = 'co_concilia_id_concilia_seq';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
	    
	    
	    return  $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
	    
 		
	 
		
	}
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
		$resultado = 'TRANSACCION ELIMINADA';
		
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
				array( campo => 'id_concilia',    valor =>$id,  filtro => 'S',   visor => 'N'),
				array( campo => 'fecha',         valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'cuenta',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'saldobanco',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'notacredito',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'notadebito',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'saldoestado',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'cheques',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'depositos',   valor => '-',  filtro => 'N',   visor => 'S') 
		);
		
		$datos = $this->bd->JqueryArrayVisor('co_concilia',$qquery );
 
 
	 	$result =  $this->div_resultado($accion,$id,0,$datos['estado']);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobación de asientos
	function aprobacion( $id  ){
	    
	    
	    
	    $sql = "update co_concilia
                    set estado = 'aprobado' 
               where id_concilia=".$this->bd->sqlvalue_inyeccion($id, true);
	    
	    $this->bd->ejecutar($sql);
	    
	 
	    
	    echo '<script>'.'$("#estado").val( '."'aprobado'".')'.'</script>';
 	    	
 
	   $result = $this->div_resultado('aprobado',$id,2,$comprobante);
	 
	    
		 
		echo $result;
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
			
			$this->edicion($id);
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
		// ------------------  eliminar
		if ($action == 'aprobacion'){
			
			$this->aprobacion($id );
			
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( ){
		
	    $fecha    = @$_POST["fecha"];
 		
 		$anio = substr($fecha, 0, 4);
 		$mes  = substr($fecha, 5, 2);
 		
 		
 		$nd = @$_POST["notadebito"];
 		$nc = @$_POST["notacredito"];
 		
 		if (empty($nd)) {
 		    $this->ATabla[12][valor] =  '0';
 		}
 		
 		if (empty($nc)) {
 		    $this->ATabla[11][valor] =  '0';
 		}
 		
 		$this->ATabla[1][valor] =  $fecha;
 		$this->ATabla[3][valor] =  $anio;
 		$this->ATabla[4][valor] =  $mes;
  		
  	 	
 		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
 		
 		$estado = 'digitado';
 		 	
 		$result = $this->div_resultado('editar',$id,1,$estado) ;
 		
 	 
 
		 echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	 
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
	    
	    
	    $fecha    = @$_POST["fecha"];
	    $estado    = @$_POST["estado"];
	 	    
	    
	    $anio = substr($fecha, 0, 4);
	    $mes  = substr($fecha, 5, 2);
	    
	    
	    $nd = @$_POST["notadebito"];
	    $nc = @$_POST["notacredito"];
	    
	    if (empty($nd)) {
	        $this->ATabla[12][valor] =  '0';
	    } 
	   
	    if (empty($nc)) {
	        $this->ATabla[11][valor] =  '0';
	    }
	    
	    $this->ATabla[1][valor] =  $fecha;
	    $this->ATabla[3][valor] =  $anio;
	    $this->ATabla[4][valor] =  $mes;
		
	    $this->ATabla[14][valor] =  $this->saldo_bancos_e($id,'cheque');
	    $this->ATabla[15][valor] =  $this->saldo_bancos_e($id,'deposito');
	    
 	    $this->ATabla[11][valor] =  $this->saldo_bancos_i($id,'credito');
 	    $this->ATabla[12][valor] =  $this->saldo_bancos_e($id,'debito');
 	    
	    
	    
	    
	    @$_POST["estado"];
	    
	    if ($estado == 'digitado') {
	        
	        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
	    
	    }
 	    
	    
	    $result = $this->div_resultado('editar',$id,1,$estado);
		
  
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
 
 		
	 
		
		
		$result = $this->div_limpiar();
		
		echo $result;
 		
	} 
	//-----------------------------------------
	function saldo_bancos_e($id,$tipo){
	    
	  
	    $a = $this->bd->query_array('co_conciliad',
	                                'coalesce(sum(haber),0) as egreso', 
	                                'id_concilia='.$this->bd->sqlvalue_inyeccion($id,true). " and 
                                     tipo = ".$this->bd->sqlvalue_inyeccion(trim($tipo),true)
	        );
	    
	    $valor = 0;
	    
	    if ($a['egreso'] > 0 ){
	        
	        $valor = $a['egreso'] ;
	        
	    }else {
	      
	        $valor = '0.00';
	    }
 
	  	    
	    return $valor;
	   
	}
	//-----------------------------------------
	function saldo_bancos_i($id,$tipo){
	    
	    
	    $a = $this->bd->query_array('co_conciliad',
	                                'coalesce(sum(debe),0) as ingreso', 
	                                'id_concilia='.$this->bd->sqlvalue_inyeccion($id,true). " and
                                     tipo = ".$this->bd->sqlvalue_inyeccion($tipo,true)
	        );
	    
	    $valor = 0;
	    
	    if ($a['ingreso'] > 0 ){
	        
	        $valor = $a['ingreso'] ;
	        
	    }else {
	        
	        $valor = '0.00';
	    }
	    
	    
	    return $valor;
	    
	}
	//--------------
	//-----------------------------------------
	function saldo_bancos_cheque($id){
	    
	    $sql = " SELECT  id_concilia, id_asiento, id_asiento_aux 
                FROM  co_conciliad
                where tipo = 'cheque' and id_concilia=".$this->bd->sqlvalue_inyeccion($id,true);
	    
	    $stmt = $bd->ejecutar($sql);
	    
	    $haber = 0;
	    
	    while ($x=$bd->obtener_fila($stmt)){
	        
	        $idaux =  $x['id_asiento_aux'];
	  
	        
	        $sql = "update co_asiento_aux
                            set bandera = 0, cab_codigo = 2
                            where id_asiento_aux=".$bd->sqlvalue_inyeccion($idaux, true) ;
	        
	        $bd->ejecutar($sql);
	        
	    }
 
	    
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
	
	$accion    		= $_GET['accion'];
	$id            		= $_GET['id'];
	  
		$gestion->consultaId($accion,$id);
  
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 		    =     @$_POST["action"];
	
	$id 				=     @$_POST["id_concilia"];
    
	$gestion->xcrud(trim($action) ,  $id  );
 
	
}

 

?>
 
  