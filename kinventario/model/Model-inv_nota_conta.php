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
		
	 
		
	}
	//-----------------------------------------------------------------------------------------------------------
 
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function nota_contabilidad($id,$secuencial1,$fechac ){
	 		
		$x = $this->bd->query_array(
		    'doctor_vta',
		    'cuenta,valorretbienes',
		    'registro='.$this->bd->sqlvalue_inyeccion( $this->ruc,true). ' and 
               secuencial='.$this->bd->sqlvalue_inyeccion( $secuencial1,true)
		    );
		
 
		
		if ( !empty($x['valorretbienes']) ){
		    $resultadoNota = 'Dato ya actualizado ... Asiento YA  se genero '.$x['valorretbienes'];
		}else{
 		    
		    $xy = $this->bd->query_array(
		        'inv_movimiento',
		        'id_asiento_ref',
		        'id_movimiento='.$this->bd->sqlvalue_inyeccion( $id ,true) 
		        );
		    
		    if ( empty($xy['id_asiento_ref'])) {
		        $resultadoNota ='No esta contabilizado!';
		    }else{
		        $resultadoNota = $this->contabilidad($xy['id_asiento_ref'],$fechac,$secuencial1);
		    }
		    
		}
	 
		
		echo  $resultadoNota;
	}
//-----------------------------
	function contabilidad($idasiento,$fechac ,$secuencial1){
	    
	    $x = $this->bd->query_array(
	        'co_asiento',
	        'id_asiento, fecha, registro, anio, mes, detalle, sesion, creacion, comprobante, estado, tipo, id_periodo, documento, modulo, idprov, estado_pago, cuentag, descuento, apagar, base, id_asiento_ref, idmovimiento, marca',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion( $idasiento,true) 
	        );
 
	    $ATabla = array(
	        array( campo => 'id_asiento',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'Y'),
	        array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor =>  $fechac, key => 'N'),
	        array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $x['registro'], key => 'N'),
	        array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $x['anio'], key => 'N'),
	        array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>  $x['mes'], key => 'N'),
	        array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => 'Reverso Nota Credito '. trim($x['detalle']), key => 'N'),
	        array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>  $x['sesion'], key => 'N'),
	        array( campo => 'creacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => $x['creacion'], key => 'N'),
	        array( campo => 'comprobante',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $x['comprobante'], key => 'N'),
	        array( campo => 'estado',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => 'aprobado', key => 'N'),
	        array( campo => 'tipo',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => 'H', key => 'N'),
	        array( campo => 'id_periodo',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => $x['id_periodo'], key => 'N'),
	        array( campo => 'documento',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>  $x['documento'], key => 'N'),
	        array( campo => 'modulo',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor =>  $x['modulo'], key => 'N'),
	        array( campo => 'idprov',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor =>  $x['idprov'], key => 'N'),
	        array( campo => 'estado_pago',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor =>  $x['estado_pago'], key => 'N'),
	        array( campo => 'cuentag',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor =>  $x['cuentag'], key => 'N'),
	        array( campo => 'descuento',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor =>  $x['descuento'], key => 'N'),
	        array( campo => 'apagar',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor =>  $x['apagar'], key => 'N'),
	        array( campo => 'base',tipo => 'NUMBER',id => '19',add => 'S', edit => 'S', valor =>  $x['base'], key => 'N'),
	        array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '20',add => 'S', edit => 'S', valor => $x['id_asiento_ref'], key => 'N'),
	        array( campo => 'idmovimiento',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor =>  $x['idmovimiento'], key => 'N'),
	        array( campo => 'marca',tipo => 'VARCHAR2',id => '22',add => 'S', edit => 'S', valor =>  $x['marca'], key => 'N'),
	    );
	    
	    $id = $this->bd->_InsertSQL('co_asiento',$ATabla,'id_co_asiento');
	    
	    $this->K_kardex($idasiento,$id ,$secuencial1 );
	     
	    $resultadoNota = 'Dato ya actualizado ... Asiento generado '.$id;
	    
	    return $resultadoNota;
	}
  //------------------------------
	function K_kardex($idasiento,$id,$secuencial1 ){
 
 	    
	    $sql_det = 'SELECT id_asientod, id_asiento, cuenta, debe, haber, id_periodo, anio, mes, sesion, creacion,
	                 registro, aux, principal, codigo1, codigo2, codigo3, codigo4
				  from co_asientod
				 where id_asiento ='.$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
  	    
	    $stmt1 = $this->bd->ejecutar($sql_det);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
 
	        $ATabla = array(
	            array( campo => 'id_asientod',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'Y'),
	            array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id, key => 'N'),
	            array( campo => 'cuenta',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $x['cuenta'], key => 'N'),
	            array( campo => 'debe',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $x['debe'] * -1, key => 'N'),
	            array( campo => 'haber',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $x['haber']* -1, key => 'N'),
	            array( campo => 'id_periodo',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => $x['id_periodo'], key => 'N'),
	            array( campo => 'anio',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor =>$x['anio'] , key => 'N'),
	            array( campo => 'mes',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => $x['mes'], key => 'N'),
	            array( campo => 'sesion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>$x['sesion'], key => 'N'),
	            array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $x['creacion'], key => 'N'),
	            array( campo => 'registro',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $x['registro'], key => 'N'),
	            array( campo => 'aux',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $x['aux'], key => 'N'),
	            array( campo => 'principal',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $x['principal'], key => 'N'),
	            array( campo => 'codigo1',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => $x['codigo1'], key => 'N'),
	            array( campo => 'codigo2',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => $x['codigo2'], key => 'N'),
	            array( campo => 'codigo3',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => $x['codigo3'], key => 'N'),
	            array( campo => 'codigo4',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => $x['codigo4'], key => 'N'),
	        );
	   
	        $this->bd->_InsertSQL('co_asientod',$ATabla,'id_co_asientod');
	        
	        
	        
	    }
 
	    
	    //------ elimina ventas
	    $sql_det = ' DELETE FROM   co_ventas  WHERE id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
	    $this->bd->ejecutar($sql_det);
	    
	    
	    $sql_edit = 'update doctor_vta 
                       set valorretbienes='.$this->bd->sqlvalue_inyeccion($id, true).' 
                    where secuencial='.$this->bd->sqlvalue_inyeccion(trim($secuencial1), true).' and 
                          registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true, true) ;
	    
	    $this->bd->ejecutar($sql_edit);
	    
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
if (isset($_GET['id']))	{
	
 
     	$id            = $_GET['id'];
     	$secuencial1   = $_GET['secuencial1'];
     	$fechac  = $_GET['fechac'];
 
     	$gestion->nota_contabilidad($id,$secuencial1,$fechac);
	 
	 
 
}
 



?>
 
  