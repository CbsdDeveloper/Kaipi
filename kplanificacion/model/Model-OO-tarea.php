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
	private $ATablaD;
	private $tabla ;
	private $tablaD ;
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
		
		$this->tabla 	  	  = 'planificacion.sitarea';
		
		$this->secuencia 	     = 'planificacion.sitarea_idtarea_seq';
 
		
		$this->ATabla = array(
 				array( campo => 'idtarea',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
     		    array( campo => 'idactividad',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'estado',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'tarea',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'recurso',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'inicial',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'codificado',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'certificacion',tipo => 'NUMBER',id => '7',add => 'S', edit => 'N', valor => '0', key => 'N'),
    		    array( campo => 'ejecutado',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '0', key => 'N'),
    		    array( campo => 'disponible',tipo => 'NUMBER',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
    		    array( campo => 'aumentoreformas',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor => '0', key => 'N'),
    		    array( campo => 'disminuyereforma',tipo => 'NUMBER',id => '11',add => 'S', edit => 'N', valor => '0', key => 'N'),
    		    array( campo => 'cumplimiento',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => 'N', key => 'N'),
    		    array( campo => 'reprogramacion',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'N', valor => 'N', key => 'N'),
    		    array( campo => 'responsable',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'fechainicial',tipo => 'DATE',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'fechafinal',tipo => 'DATE',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'sesion',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
    		    array( campo => 'creacion',tipo => 'DATE',id => '18',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
    		    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
    		    array( campo => 'modificacion',tipo => 'DATE',id => '20',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
    		    array( campo => 'programa',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'clasificador',tipo => 'VARCHAR2',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'actividad',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N'),
    		    array( campo => 'fuente',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'N', valor => '-', key => 'N'),
				array( campo => 'justificacion',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
		        array( campo => 'enlace_pac',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N'),
		        array( campo => 'modulo',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'S', valor => '-', key => 'N')
		);
 
		
		$this->tablaD 	  	  = 'planificacion.sitareadetalle';
		

		$this->ATablaD = array(
				    array( campo => 'idtareadetalle',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
        		    array( campo => 'idtarea',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
        		    array( campo => 'fechaejecuta',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
        		    array( campo => 'anio',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
        		    array( campo => 'mes',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
        		    array( campo => 'inicial',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
        		    array( campo => 'codificado',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
        		    array( campo => 'certificacion',tipo => 'NUMBER',id => '7',add => 'S', edit => 'N', valor => '0', key => 'N'),
        		    array( campo => 'ejecutado',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '0', key => 'N'),
        		    array( campo => 'disponible',tipo => 'NUMBER',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
        		    array( campo => 'aumentoreformas',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor => '0', key => 'N'),
        		    array( campo => 'disminuyereforma',tipo => 'NUMBER',id => '11',add => 'S', edit => 'N', valor => '0', key => 'N'),
        		    array( campo => 'cumplimiento',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => 'N', key => 'N'),
        		    array( campo => 'reprogramacion',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'N', valor => 'N', key => 'N')   );
  
		
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
			        
			echo '<script type="text/javascript">accionTarea("'.$id.'","'.$accion.'") </script>';
		}
		
		if ($tipo == 1){
			
			echo '<script type="text/javascript">accionTarea("'.$id.'","'.$accion.'") </script>';
			
			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>INFORMACION ACTUALIZADA ... </b>';
			
		}
		
		if ($tipo == -1){
			
			echo '<script type="text/javascript">accionTarea("'.$id.'","'.$accion.'") </script>';
			
 			
			$resultado = '<img src="../../kimages/ksavee.png" align="absmiddle" />&nbsp;<b>PARA DESACTIVAR ESTA TAREA DEBE AGREGAR JUSTIFICACION.... ... </b>';
			
		}
		

		
		return $resultado;
		
	}
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
		
		$qquery = array( 
		        array( campo => 'idtarea',   valor => $id,  filtro => 'S',   visor => 'S'),
		        array( campo => 'idactividad',   valor => 'idactividad_tarea',  filtro => 'N',   visor => 'S'),
				array( campo => 'tarea',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => 'estado1',  filtro => 'N',   visor => 'S'),
				array( campo => 'responsable',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'clasificador',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'nombre_funcionario',   valor => '-',  filtro => 'N',   visor => 'S'),
 				array( campo => 'recurso',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fechainicial',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fechafinal',   valor => '-',  filtro => 'N',   visor => 'S'),
		         array( campo => 'enlace_pac',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'actividad',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'programa',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'actividad_tarea',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
			);
		
		
		
		
		$this->bd->JqueryArrayVisorTab('planificacion.view_tarea_poa',$qquery,'-' );
		
		$this->consultaIdDetalle($id );
		
		$resultadoTarea =  $this->div_resultado($accion,$id,0);
		
		echo  $resultadoTarea;
	}
	//--------------------------------------------------------------------------------
	function consultaIdDetalle($id ){
		
		
		$sqlOO= 'SELECT  idtareadetalle, fechaejecuta, anio, mes, coalesce(inicial,0) as inicial, codificado, 
                		certificacion, ejecutado, disponible, aumentoreformas, 
                		disminuyereforma, cumplimiento, reprogramacion
					FROM planificacion.sitareadetalle
				WHERE idtarea = '.$this->bd->sqlvalue_inyeccion($id,true) ;
		
 
		
		$stmt_oo = $this->bd->ejecutar($sqlOO);
		
		$suma = 0;

		echo "<script>habilitaperiodo('S')</script>";
		
		while ($y=$this->bd->obtener_fila($stmt_oo)){
		
			$mes = intval($y['mes']);

			$cobjeto = "'".'m'.$mes."'";
			
			echo '<script>valorMes('.$cobjeto.','.$y['inicial'].')</script>';
		
	 		$suma =  $suma + $y['inicial'];
		}
		
		echo '<script>valorMes('."'TOTALPOA'".','.$suma.')</script>';

 		echo '<script>valorMes('."'TOTALPOA1'".','.$suma.')</script>';
 	 
	}
	
	//--------------------------------------------------------------------------------
	function VerificaDetalle($id ){
		 	
		$sql= 'SELECT    count(mes) as nn
					FROM planificacion.sitareadetalle
				WHERE idtarea = '.$this->bd->sqlvalue_inyeccion($id,true) ;
		
 	
		
		$stmt_oo = $this->bd->ejecutar($sql);
		
		$suma = 0;
	
		while ($y=$this->bd->obtener_fila($stmt_oo)){
			
		    $suma = $suma + $y['nn'];
			 
		}
		
		return $suma;
		
	}
	//-------------------------------
	
	function programa_unidad($id ){
	    
	    
 
	    
	    $Array = $this->bd->query_array('nom_departamento','programa', 'id_departamento='.$this->bd->sqlvalue_inyeccion($id,true));
	    
	    return $Array['programa'];
	    
	    
	}
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,$idQuery,$visor,$Q_IDPERIODO){
		
		
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
				
				$this->eliminar($id,$Q_IDPERIODO );
				
			}
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar(   ){
		
		
		$this->ATabla[1][valor]  =  $_POST["idactividad_tarea"];
 
		$this->ATabla[2][valor] =  $_POST["estado1"];
		
	
		
		$this->ATabla[5][valor] =  $_POST["TOTALPOA"];
		
		$this->ATabla[6][valor] =  $_POST["TOTALPOA"];
		
		$this->ATabla[9][valor] =  $_POST["TOTALPOA"];
		
  		
		
		$this->ATabla[23][valor] =  trim($_POST["actividad_tarea"]);
		
		$this->ATabla[27][valor] =  trim($_POST["modulo"]);
		
		$this->ATabla[21][valor] =  trim($_POST["programa"]);
		
		
		
		$this->ATabla[22][valor] =  $_POST["clasificador"];
		 
		
		$validaTotal		 =  $_POST["TOTALPOA"];
		
		$validaTareaRecurso  =  $_POST["recurso"];
 		
		//----------------------------------------------------------
		
		if (trim($validaTareaRecurso) == 'S') {
			$bandera = 1;
		}else{
			$bandera = 0;
			$this->ATabla[22][valor] = '-';
		}
		//----------------------------------------------------------
	 	if ($bandera == 1){
			if ($validaTotal == 0){
				$bandera = -1;
				$resultadoTarea= '<b>Esta tarea requiere de Tipo de gasto y monto</b>';
			}else{
				$bandera = 0;
			}
		}
		//----------------------------------------------------------
		if ($bandera == 0){
			
		    $id1 = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
			
			if ($validaTotal > 0){
				
				$this->agregarDetalleMonto( $id1);
			}
			
			$resultadoTarea = $this->div_resultado('editar',$id1,1);
			
		}
	 
 		echo $resultadoTarea;
		
	}
	//---------------
	function agregarDetalleMonto( $idTarea  ){
		
		
		$this->ATablaD[1][valor]  =     $idTarea;
		$this->ATablaD[2][valor]  = 	$_POST["fechainicial"];
		$this->ATablaD[3][valor]  = 	$_POST["anio_tarea"];
		
		
	
	   for ($x = 1; $x <= 12; $x++) {
	   
	        $mes = str_pad($x,2,"0",STR_PAD_LEFT );
	       
	        $this->ATablaD[4][valor]  = $mes;
	  	 	
	  	 	$variable = 'm'.$x;
	  	 	
	  	 	$monto =  $_POST[$variable];
	  	 	
	  	 	$this->ATablaD[5][valor]  = $monto;
	  	 	$this->ATablaD[6][valor]  = $monto;
	  	 	$this->ATablaD[9][valor]  = $monto;
	   	
	   		 $this->bd->_InsertSQL($this->tablaD,$this->ATablaD,'planificacion.sitareadetalle_idtareadetalle_seq');
	   	
	   		 
	   } 
	 		
  
	   
	 return 0;
		
	}
	//---------------------------------------------------------------------------
	//---------------
	function editarDetalleMonto( $idTarea  ){
		
 	    
 		
		$sqlOO= 'SELECT  idtareadetalle, idtarea, mes, inicial
					FROM planificacion.sitareadetalle
				WHERE idtarea = '.$this->bd->sqlvalue_inyeccion($idTarea,true) ;
		
		
 
		$stmt_oo = $this->bd->ejecutar($sqlOO);
		
		 
		while ($y=$this->bd->obtener_fila($stmt_oo)){
			
		    //$int = (int);
		    
		    $c = intval($y['mes']);
		    
		    $cobjeto = 'm'.$c;
			
 
		    
			$monto =  $_POST[$cobjeto];
 
			$this->ATablaD[4][valor]  = $monto;
			$this->ATablaD[5][valor]  = $monto;
			
		 	$idmes = $y['idtareadetalle'];
		 
		    $this->bd->_UpdateSQL($this->tablaD,$this->ATablaD,$idmes);
			
		}
		
		
	 
		
		return 0;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
		
	    $this->ATabla[1][valor]  =  $_POST["idactividad_tarea"];
	    
	    $this->ATabla[2][valor] =  trim($_POST["estado1"]);
	    
	    $this->ATabla[22][valor] =  $_POST["clasificador"];
	    
	    $this->ATabla[5][valor] =  $_POST["TOTALPOA"];
	    
	    $this->ATabla[6][valor] =  $_POST["TOTALPOA"];
	    
	    $this->ATabla[9][valor] =  $_POST["TOTALPOA"];
	    
 	    
	    $this->ATabla[23][valor] =  trim($_POST["actividad_tarea"]);
	    
	    $this->ATabla[27][valor] =  trim($_POST["modulo"]);
	    
	    
	    $this->ATabla[21][valor] =  trim($_POST["programa"]);
	    
	    $validaTotal		 =  $_POST["TOTALPOA"];
	    
	    $validaTareaRecurso  =  $_POST["recurso"];
		
	
		//----------------------------------------------------------

		$bandera = 0;
		
		if (trim($validaTareaRecurso) == 'S') {
			$bandera = 1;
		}else{
			$bandera = 0;
			$this->ATabla[22][valor] = '-';
		}
		
		$estado_tarea  = trim($_POST["estado1"]);

		$justificacion = trim($_POST["justificacion"]);
		
		$len           = strlen($justificacion );



		if ( trim($estado_tarea)  == 'N')  {

				if ( $len < 15 ) {
					$bandera = -1;
					$resultadoTarea= '<b>PARA DESACTIVAR ESTA TAREA DEBE AGREGAR JUSTIFICACION....</b>';
  				}
		}
		
		
 

		//----------------------------------------------------------
		if ($bandera == 1){

			if ($validaTotal == 0){
				$bandera = -1;
				$resultadoTarea= '<b>Esta tarea requiere de Tipo de gasto y monto</b>';
 			}else{
				$bandera = 0;
			}
		}
	 

		//----------------------------------------------------------
	 	if ($bandera == 0){
			
			$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
			
			if ($validaTotal > 0){
				
				$valida = $this->VerificaDetalle($id);
				
				if ( $valida <= 1){
				  $this->agregarDetalleMonto( $id);
				}else{
				  $this->editarDetalleMonto( $id);
				}
 				
			}
		 
		} 

		$tipo_dato= 1;
 		
		if ( $bandera == -1)  {
			$resultadoTarea= '<b>PARA DESACTIVAR ESTA TAREA DEBE AGREGAR JUSTIFICACION....</b>';
			$tipo_dato= -1;
		 
		}

		$resultadoTarea= $this->div_resultado('editar',$id,$tipo_dato) ;
		
		echo $resultadoTarea;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id,$Q_IDPERIODO  ){
		
		
		 
        $AUnidad = $this->bd->query_array('presupuesto.pre_periodo',
            'tipo,estado',
            "tipo in ('elaboracion','proforma') and
			 anio = ".$this->bd->sqlvalue_inyeccion($Q_IDPERIODO,true)
            );
        
     
        $resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>NO SE PUEDE ELIMINAR EL REGISTRO</b><br>';

        if ( trim($AUnidad['tipo']) == 'elaboracion'  ){
          
				$sql = 'delete from planificacion.sitarea where idtarea='.$this->bd->sqlvalue_inyeccion($id, true);
			
				$this->bd->ejecutar($sql);

				$sql = 'delete from planificacion.sitareadetalle where idtarea='.$this->bd->sqlvalue_inyeccion($id, true);
				
				$this->bd->ejecutar($sql);


				$resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>REGISTRO ELIMINADO</b><br>';

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
 
if (isset($_POST["actionTarea"]))	{
	
	$action 	 = $_POST["actionTarea"];
	$id 		 = $_POST["idtarea"];
	$idQuery     = $_POST['id'];
	$visor    	 = $_POST['visor'];

	$Q_IDPERIODO    	 = $_POST['Q_IDPERIODO'];
	
	 

	$gestion->xcrud( $action,$id,$idQuery,$visor,$Q_IDPERIODO  );
	
}

 
 



?>
 
  