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
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =		new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d");
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->tabla 	  	  = 'planificacion.siactividad';
		
		$this->secuencia 	     = 'planificacion.siactividad_idactividad_seq';
		
 		
		$this->ATabla = array(
				array( campo => 'idactividad',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
     		    array( campo => 'idobjetivo',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'id_departamento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'idperiodo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'actividad',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'aportaen',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'estado',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'anio',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'idobjetivoindicador',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
    		    array( campo => 'creacion',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
    		    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
    		    array( campo => 'modificacion',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
    		    array( campo => 'producto',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
		        array( campo => 'beneficiario',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N')
 		);
		
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
 		
 
		if ($tipo == 0){
			
			if ($accion == 'editar')
 				    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
				    
		    if ($accion == 'del')
		            $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
		        
			
			echo '<script type="text/javascript"> accion("'.$id.'","'.$accion.'") </script>';
		}
		
		if ($tipo == 1){
			
 			echo '<script type="text/javascript"> accion("'.$id.'","'.$accion.'") </script>';
 			
 			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>INFORMACION ACTUALIZADA ... </b>';
 			
  			
		}
		
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
	  
		$qquery = array( 
		    array( campo => 'idactividad',   valor => $id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'idobjetivo',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'idperiodo',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'actividad',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'aportaen',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'idobjetivoindicador',valor => '-',filtro => 'N', visor => 'S'),
 		    array( campo => 'producto',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'beneficiario',valor => '-',filtro => 'N', visor => 'S') 
 		);
		
	
	 
	 	 $this->bd->JqueryArrayVisorTab('planificacion.siactividad',$qquery,'-' );
	     
	 	 $result =  $this->div_resultado('editar',$id,0);
		
		 echo  $result;
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,$idQuery,$visor){
		
	 
		if ($visor == 'S'){
			
			$this->consultaId($action,$idQuery);
			
		}
		
		else {
			// ------------------  agregar
			if ($action == 'add'){
				
				$this->agregar( );
				
			}
			// ------------------  editar
			if ($action == 'editar'){
				
				$this->edicion($id );
				
			}
			// ------------------  eliminar
			if ($action == 'eliminar'){
				
			    $this->eliminar($id,$idQuery );
				
			}
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar(   ){
		
	    $anio 	 = $_POST["anio"];
 	    
	    $idperiodo = $this->bd->query_array('presupuesto.view_periodo',  'idperiodo', 'anio='.$this->bd->sqlvalue_inyeccion($anio,true));
 
	    
	    $this->ATabla[3][valor] = $idperiodo['idperiodo'] ;
	    
	    $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
		
		
		$result = $this->div_resultado('editar',$id,1);
		
		echo $result;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
	 
		
		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$result = $this->div_resultado('editar',$id,1) ;
		
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id,$Q_IDPERIODO ){
		
		
 		
		
		$AUnidad = $this->bd->query_array('presupuesto.pre_periodo',
		    'tipo,estado',
		    "tipo in ('elaboracion','proforma') and
			 anio = ".$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true)
		    );
		
		$ATarea = $this->bd->query_array('planificacion.sitarea',
		    'count(*) as nn',
		    "idactividad = ".$this->bd->sqlvalue_inyeccion($id,true)
		    );
		
		
		$result = '<img src="../kimages/kdel.png"/>&nbsp;<b>NO SE PUEDE ELIMINAR EL REGISTRO</b><br>';
		
		if ( trim($AUnidad['tipo'] ) == 'elaboracion'  ){
		    
		    if ( $ATarea['nn'] > 0 ){
		        
		    }else{
		        
		        $result = '<img src="../kimages/kdel.png"/>&nbsp;<b>REGISTRO ELIMINADO</b><br>';
		        
		        $sql = 'delete from planificacion.siactividad where idactividad='.$this->bd->sqlvalue_inyeccion($id, true);
		        
		       $this->bd->ejecutar($sql);
		     
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

 
  
if (isset($_POST["action"]))	{
	
	$action 	 = $_POST["action"];
 	$id 		 = $_POST["idactividad"];
 	$idQuery     = $_POST['id'];
 	$visor    	 = $_POST['visor'];
 	
	
 
 	 $gestion->xcrud( $action,$id,$idQuery,$visor);
 	
	
}
 



?>
 
  