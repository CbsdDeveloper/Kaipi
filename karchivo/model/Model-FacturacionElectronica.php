<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
 
	
	private $obj;
	public $bdF;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
 
	
 
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		 
		
		$this->obj     = 	new objects;
		
		$this->bdF	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     $_SESSION['email'];
		 
		
	//	$this->bd->conectar_sesion( );
		
	  
		
	}
  
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_limpiar( ){
		//inicializamos la clase para conectarnos a la bd
		
	/*	$resultado = '';
		
		echo '<script type="text/javascript">';
		
		echo  'LimpiarPantalla();';
		
		echo '</script>';
		
		return $resultado;
		
		*/
		
	}
	
	
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
 /*
		$qquery = array(  
		    array( campo => 'id_movimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'fechaa',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'documento',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
		$datos = $this->bd->JqueryArrayVisor('view_inv_movimiento',$qquery );
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
		
		*/
	}
	
	
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		/*
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
			
		}*/
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( ){
 
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
	 
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	 
		
	}
	//---------------------------------------
	function periodo(  ){
		
 
		$APeriodo = $this->bd->query_array('spo_cabecera',
				'razonsocialcomprador',
				'ruc='.$this->bd->sqlvalue_inyeccion('1002537411001',true). ' AND
 											  cab_codigo ='.$this->bd->sqlvalue_inyeccion(241,true)
				);
		
  		echo $APeriodo['razonsocialcomprador'];
	 
	}
	//-------------
	function AprobarComprobante($accion,$id,$tipo){
	 
	}
  //------------------------------
	function K_comprobante($tipo ){
 
	}
	//------------------------------
	function K_kardex($id,$tipo){
 
	  
	}    
    //--------------------
    	function DetalleMov($id){
  
    	
    	
    }
 }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
?>
 
  