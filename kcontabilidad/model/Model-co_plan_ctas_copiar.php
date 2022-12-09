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
		
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->anio      =  $_SESSION['anio'];
		
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
		    array( campo => 'cuenta',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
		    array( campo => 'cuentas',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'nivel',   tipo => 'NUMBER',   id => '3',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'univel',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'aux',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'tipo_cuenta',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'registro',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'debe',   tipo => 'numeric',   id => '10',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'haber',   tipo => 'numeric',   id => '11',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'saldo',   tipo => 'numeric',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'impresion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'documento',   tipo => 'NUMBER',   id => '14',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'comprobante',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'debito',   tipo => 'VARCHAR2',   id => '17',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'credito',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'partida_enlace',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'deudor_acreedor',   tipo => 'VARCHAR2',   id => '20',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'anio',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => $this->anio   ,   filtro => 'N',   key => 'N')
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
		
		$resultado = '';
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
		return $resultado;
		
	}
	
	
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( $id_registro ,$anio ){
		
 
	    
	    $sql = "SELECT cuenta, cuentas, detalle, nivel, tipo, univel, aux, tipo_cuenta, estado, registro, debe, 
	           haber, saldo, impresion, documento, comprobante, idprov, deudor_acreedor, debito, credito, 
	           partida_enlace, anio
                FROM  co_plan_ctas
                where registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true). ' and 
                      anio = '.$this->bd->sqlvalue_inyeccion($anio,true);

      
	    $stmt = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $cuenta = $x['cuenta'];
	        
	        $valida = $this->verifica($cuenta ,$this->ruc,$this->anio);
	        
 	    
	        
	        if ( $valida == 0 ){
	                $this->ATabla[0][valor] = $x['cuenta'];
	                $this->ATabla[1][valor] = $x['cuentas'];
	                $this->ATabla[2][valor] = $x['detalle'];
	                $this->ATabla[3][valor] = $x['nivel'];
        	        
	                $this->ATabla[4][valor] = $x['tipo'];
	                $this->ATabla[5][valor] = $x['univel'];
	                $this->ATabla[6][valor] = $x['aux'];
	                $this->ATabla[7][valor] = $x['tipo_cuenta'];
	                
	                $this->ATabla[8][valor] = $x['estado'];
	                $this->ATabla[9][valor] = $this->ruc;
	                $this->ATabla[10][valor] = 0;
	                $this->ATabla[11][valor] = 0;
	                
	                $this->ATabla[12][valor] = 0;
	                $this->ATabla[13][valor] = $x['impresion'];
	                $this->ATabla[14][valor] = $x['documento'];
	                $this->ATabla[15][valor] = $x['comprobante'];
	                $this->ATabla[16][valor] = $x['idprov'];
	                
	                $this->ATabla[17][valor] = $x['debito'];
	                $this->ATabla[18][valor] = $x['credito'];
	                
	                $this->ATabla[19][valor] = $x['partida_enlace'];
	                $this->ATabla[20][valor] = $x['deudor_acreedor'];
	                
        	        $this->bd->_InsertSQL($this->tabla,$this->ATabla,'NO');
	        }
	        else {
	            
 
	            $this->ATabla[2][valor] = $x['detalle'];
 	            $this->ATabla[17][valor] = $x['debito'];
	            $this->ATabla[18][valor] = $x['credito'];
	            
	            
	            $this->ATabla[4][valor] = $x['tipo'];
	            $this->ATabla[5][valor] = $x['univel'];
	            $this->ATabla[6][valor] = $x['aux'];
	            $this->ATabla[19][valor] = $x['partida_enlace'];
	            $this->ATabla[20][valor] = $x['deudor_acreedor'];
	            
	            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$cuenta);
	        }
	    }
	    
 
		
		$resultadoCta = 'Plan de cuentas cargado correctamente';
		
		echo $resultadoCta;
		
	}
	
	//--------------------------------------------------------------------------------
 
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function verifica($id ,$ruc,$anio){
		
   $sql = "SELECT count(*) as nro_registros
	       FROM co_plan_ctas
           where cuenta = ".$this->bd->sqlvalue_inyeccion($id ,true).' and 
                 anio = '.$this->bd->sqlvalue_inyeccion($anio ,true).' and 
				 registro='.$this->bd->sqlvalue_inyeccion($ruc, true);
	
        $valida = 0;
   
		$resultado = $this->bd->ejecutar($sql);
		
		$datos_valida = $this->bd->obtener_array( $resultado);
		
		if ($datos_valida['nro_registros'] == 0){
			
		    $valida = 0;
			
		}else{
		    $valida = 1;
		}
		
	 
		
		return $valida;
 
		
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
if (isset($_GET['anio_selecciona']))	{
    
      $id              = $_SESSION['ruc_registro'];
  	  $anio            = $_GET['anio_selecciona'] - 1;
	  
  	  $gestion->agregar($id,$anio);
	 
}
 


?>
 
  