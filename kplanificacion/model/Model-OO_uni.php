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
		
		$this->tabla 	  	  = 'planificacion.pyobjetivos';
 	 
		$this->secuencia 	     = 'planificacion.pyobjetivos_idobjetivo_seq';
		
		$this->ATabla = array(
				array( campo => 'idobjetivo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
     		    array( campo => 'id_departamento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'idestrategia',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'objetivo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'estado',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'idperiodo',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'anio',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'aporte',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'ambito',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
		        array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
		        array( campo => 'creacion',tipo => 'DATE',id => '10',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
		        array( campo => 'sesionm',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
		        array( campo => 'modificacion',tipo => 'DATE',id => '12',add => 'S', edit => 'S', valor => $this->hoy, key => 'N')   
		);
		
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		
 		echo '<script type="text/javascript">accion_oo("'.$id.'","'.$accion.'") </script>';
 
 		if ($tipo == 0){
 		    
 		    if ($accion == 'editar'){
 		        $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
 		    }
 		    
 		    if ($accion == 'del'){
 		        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ... PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION</b>';
 		    }
 		    
 		}
 		
 		if ($tipo == 1){
 		    
 		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>INFORMACIÓN GUARDADA CON EXITO ... </b>';
 		    
 		    
 		    
 		}
 		
 		if ($tipo == 2){
 		    
 		    $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>INFORMACIÓN GUARDADA CON EXITO ... </b>';
 		    
  		    
 		}
		
		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
		
		$qquery = array( 
		        array( campo => 'idobjetivo',   valor => $id,  filtro => 'S',   visor => 'S'),
    		    array( campo => 'id_departamento',valor => 'id_departamentoo',filtro => 'N', visor => 'S'),
    		    array( campo => 'idestrategia',valor => '-',filtro => 'N', visor => 'S'),
    		    array( campo => 'objetivo',valor => '-',filtro => 'N', visor => 'S'),
    		    array( campo => 'estado',valor => 'estadoo',filtro => 'N', visor => 'S'),
    		    array( campo => 'idperiodo',valor => '-',filtro => 'N', visor => 'S'),
    		    array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
    		    array( campo => 'aporte',valor => '-',filtro => 'N', visor => 'S'),
    		    array( campo => 'ambito',valor => '-',filtro => 'N', visor => 'S')
    	);
		
		$this->bd->JqueryArrayVisorTab('planificacion.pyobjetivos',$qquery,'-' );
		
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
		
	    $idperiodo         	= $_POST["idperiodo"];
	    $id_departamentoo	= $_POST["id_departamentoo"];
 		
	    $estadoo	= $_POST["estadoo"];
	    
		$ESTRATEGIA = $this->bd->query_array(
				'planificacion.view_periodo',
			 	'anio',
		        'idperiodo='.$this->bd->sqlvalue_inyeccion($idperiodo,true));
		
 	   //------------------------------------------------------------------
  		
		$this->ATabla[6][valor] = $ESTRATEGIA['anio'];
		$this->ATabla[1][valor] = $id_departamentoo;
		$this->ATabla[4][valor] = $estadoo;
		
  		
		$id = $this->bd->_InsertSQL($this->tabla, $this->ATabla, $this->secuencia  	);
		
		
		$result = $this->div_resultado('editar',$id,1);
		
		echo $result;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
 
	    $id_departamentoo	= $_POST["id_departamentoo"];
	    $estadoo	= $_POST["estadoo"];
	    
	    $this->ATabla[4][valor] = $estadoo;
	    
	    $this->ATabla[1][valor] = $id_departamentoo;
	  
		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
		
		$result = $this->div_resultado('editar',$id,1) ;
		
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id,$idQuery ){
		
		
	    $AUnidad = $this->bd->query_array('presupuesto.pre_periodo',
	        'tipo,estado',
	        "tipo in ('elaboracion','proforma') and
			 anio = ".$this->bd->sqlvalue_inyeccion($idQuery,true)
	        );
	    
	    
	    $Actividad = $this->bd->query_array('planificacion.siactividad',
	        'count(*) as nn',
	        "idobjetivo = ".$this->bd->sqlvalue_inyeccion($id,true)
	        );
	     
	    
	    $resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>NO SE PUEDE ELIMINAR EL REGISTRO '. $Actividad['nn'].'</b><br>';
	    
	      
	    
	    if ( trim($AUnidad['tipo']) == 'elaboracion'  ){
	        
	        if ( $Actividad['nn'] > 0 ){
	            
	               $resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>NO SE PUEDE ELIMINAR EL REGISTRO '. $Actividad['nn'].'</b><br>';
	            
	        }else {
	        
            	        $sql = 'delete from planificacion.pyobjetivos  where idobjetivo='.$this->bd->sqlvalue_inyeccion($id, true);
            	        
            	  $this->bd->ejecutar($sql);
            	         
            	        
            	        $resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>REGISTRO ELIMINADO</b><br>';
	        }
	    }
		
	    echo $resultado;
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
if (isset($_POST["actionoo"]))	{
	
	$action       = $_POST["actionoo"];
	
	$id 	      = $_POST["idobjetivoo"];
	
	$idQuery      = $_POST['id'];
	
	$gestion->xcrud(trim($action),$id,$idQuery);
	
}



?>
 
  