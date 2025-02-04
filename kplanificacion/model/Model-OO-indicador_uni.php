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
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->tabla 	  	  = 'planificacion.pyobjetivosindicador';
		
		$this->secuencia 	     = 'planificacion.pyobjetivosindicador_idobjetivoindicador_seq';
		
 		$this->ATabla = array(
				array( campo => 'idobjetivoindicador',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
      		    array( campo => 'idobjetivo',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'id_departamento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
     		    array( campo => 'indicador',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'detalle',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'tipoformula',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'idperiodo',tipo => 'NUMBER',id => '6',add => 'S', edit => 'N', valor => '-', key => 'N'),
     		    array( campo => 'anio',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => '-', key => 'N'),
     		    array( campo => 'estado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'periodo',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'valor1',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'valor2',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'variable1',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'variable2',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'formula',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'meta',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
     		    array( campo => 'medio',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
 		        array( campo => 'sesion',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
 		        array( campo => 'creacion',tipo => 'DATE',id => '18',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
 		        array( campo => 'sesionm',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
 		        array( campo => 'modificacion',tipo => 'DATE',id => '20',add => 'S', edit => 'S', valor => $this->hoy , key => 'N') 
 		);
		
		
 
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
 		echo '<script type="text/javascript">accionIndicador("'.$id.'","'.$accion.'") </script>';
 
		if ($tipo == 0){
			
			     if ($accion == 'editar')
			            $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
 				 if ($accion == 'del')
 				        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
 					
		}
		
		if ($tipo == 1){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>INFORMACIÓN GUARDADA CON EXITO ... </b>';
			
		}
		
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
		
		$qquery = array( 
				array( campo => 'idobjetivoindicador',   valor => $id,  filtro => 'S',   visor => 'N'),
 				array( campo => 'indicador',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipoformula',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'periodo',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',       valor => 'estado2',  filtro => 'N',   visor => 'S'),
				array( campo => 'idobjetivo',   valor => 'idobjetivo_indicador',  filtro => 'N',   visor => 'S'),
  				array( campo => 'variable1',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'variable2',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'formula',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'meta',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'id_departamento',   valor => 'id_departamento_indicador',  filtro => 'N',   visor => 'S'),
 				array( campo => 'medio',   valor => '-',  filtro => 'N',   visor => 'S'),
   		);
		 
		 
	 $datos = $this->bd->JqueryArrayVisorTab('planificacion.view_indicadores_oo',$qquery,'-' );
	 
	 
 	 echo '<script type="text/javascript"> $("#idobjetivo_indicador").val('.$datos['idobjetivo'].');</script>';
 	 
  
	 
 	 
		
		 $result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,$idQuery){
		
		
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
		// ------------------  visor
		if ($action == 'visor'){
			
			$this->consultaId('editar',$idQuery);
			
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar(   ){
		
	    $anio =  $_POST["anio_indicador"];
 
	    $x     = $this->bd->query_array('planificacion.view_periodo',
	             'idperiodo,anio', 
	        'anio='.$this->bd->sqlvalue_inyeccion($anio,true));
	    
	   
 		$this->ATabla[1][valor]  =  $_POST["idobjetivo_indicador"];
		$this->ATabla[2][valor]  =  $_POST["id_departamento_indicador"];
		$this->ATabla[8][valor]  =  $_POST["estado2"];
		
		$this->ATabla[7][valor]  =   $x["anio"];
 		$this->ATabla[6][valor]  =   $x["idperiodo"];
  	
		$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
	 		
		$result = $this->div_resultado('editar',$id,1);
		
		echo $result;
		 
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
	    $anio =  $_POST["anio_indicador"];
	    
	    $x     = $this->bd->query_array('planificacion.view_periodo',
	        'idperiodo,anio',
	        'anio='.$this->bd->sqlvalue_inyeccion($anio,true));
	    
	    
	    $this->ATabla[1][valor]  =  $_POST["idobjetivo_indicador"];
	    $this->ATabla[2][valor]  =  $_POST["id_departamento_indicador"];
	    $this->ATabla[8][valor]  =  $_POST["estado2"];
	    
	    $this->ATabla[7][valor]  =   $x["anio"];
 	    $this->ATabla[6][valor]  =   $x["idperiodo"];
	    
		
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
	    
	 	    
	    $result = '<img src="../kimages/kdel.png"/>&nbsp;<b>NO SE PUEDE ELIMINAR EL REGISTRO</b><br>';
	    
	    if ( trim($AUnidad['tipo'] ) == 'elaboracion'  ){
 	        
	            
	            $result = '<img src="../kimages/kdel.png"/>&nbsp;<b>REGISTRO ELIMINADO</b><br>';
	            
	            $sql = 'delete from planificacion.pyobjetivosindicador where idobjetivoindicador='.$this->bd->sqlvalue_inyeccion($id, true);
	            
	            $this->bd->ejecutar($sql);
	            
	       
	        
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


//------ grud de datos insercion
if (isset($_POST["actionindicador"]))	{
	
	$action = $_POST["actionindicador"];
	
	$id 	     = $_POST["id_idobjetivoindicador"];
	
	$idQuery     = $_POST['id'];
	
	$gestion->xcrud(trim($action),$id,$idQuery);
	
}



?>
 
  