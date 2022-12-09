<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php';  


class proceso{
	
 
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
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
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");    	 
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
				array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
				array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
				array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
				array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		       array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '00000',   filtro => 'N',   key => 'N'),
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		        array( campo => 'cierre',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
		    array( campo => 'base12',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'iva',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'base0',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'total',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'novedad',   tipo => 'VARCHAR2',   id => '19',  add => 'S',   edit => 'N',   valor => 'servicio',   filtro => 'N',   key => 'N'),
		    array( campo => 'idbodega',   tipo => 'NUMBER',   id => '20',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		    array( campo => 'carga',   tipo => 'VARCHAR2',   id => '21',  add => 'S',   edit => 'N',   valor => '0',   filtro => 'N',   key => 'N'),
		    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'N',   valor => 'arriendo',   filtro => 'N',   key => 'N'),
 		);
		
 
		
		$this->tabla 	  	  = 'inv_movimiento';
		
		$this->secuencia 	     = '-';
		
	}
 
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function agua($id_movimiento,$costo,$monto_iva,$tarifa_cero,$tipo,$baseiva ){
		
 /*
		$qquery = array(  
		    array( campo => 'id_movimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'carga',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
	    $this->bd->JqueryArrayVisor('view_ventas_fac',$qquery );
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result; */
	}
	
	
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function genera_transaccion( $idprov,$idren_local,$carriendo,$cluz,$cagua,$fecha_emite,$cdetalle,$tipo ){
		
	    $fecha                   = $fecha_emite;
		$idperiodo               = $this->periodo($fecha);
		$this->ATabla[1][valor]  =  $fecha;
 		$this->ATabla[9][valor]  =  $idperiodo;
		$this->ATabla[11][valor] =  trim($idprov);
 		
  		  
    		   
    		    $total =  $carriendo + $cluz + $cagua;
    		    
    		    
    		    $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>NO EXISTE INFORMACION </b>';
    		    
    		    if ( $total > 0  ){
             		
            	 
    		        //-------------------------------------------------------------------------------
            		if ( $tipo == '1') {
            		    
                		if ( $cluz > 0 ) {
                		    
                		    $base0  = $cluz;
                		    $base12 = '0.00';
                		    $iva    = '0.00';
                		    $total  = $cluz;
                		    
                		    $this->ATabla[15][valor]  =  $base12;
                		    $this->ATabla[16][valor]  =  $iva;
                		    $this->ATabla[17][valor]  =  $base0;
                		    $this->ATabla[18][valor]  =  $base0 ;
                		    $this->ATabla[3][valor]   =  $cdetalle.' ( LUZ ELETRICA )';
 
                		    
                		    $id_movimiento = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
                		    $tributa       = 'T';
                   		   
                		    $this->luz( $id_movimiento,$total,$iva,$base0,$tributa,$base12);
                		    
                		    $sql = "update rentas.ren_arre_local
                                               set luz  = ".$this->bd->sqlvalue_inyeccion($cluz,true).'
                                             where idren_local='.$this->bd->sqlvalue_inyeccion($idren_local,true);
                		}
                		
            		}
            		//-------------------------------------------------------------------------------
            		if ( $tipo == '2') {
       
                		if ( $carriendo > 0 ) {
                		    $base12 = round($carriendo / (1.12),2) ;
                		    $iva    = round($base12 *  (12/100),2);
                		    $base0  = '0.00';
                		    
                		    $this->ATabla[15][valor]  =  $base12;
                		    $this->ATabla[16][valor]  =  $iva;
                		    $this->ATabla[17][valor]  =  $base0;
                 		    $this->ATabla[18][valor]  =    $carriendo ;
                		    $this->ATabla[3][valor]   =    $cdetalle.' ( ARRIENDO PERIODO)';
                		    
                		    
                		    $id_movimiento = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
                		    $tributa= 'I';
                		    $this->arriendo( $id_movimiento,$carriendo,$iva,$base0,$tributa,$base12);
                		}
                		
                		$sql = "update rentas.ren_arre_local
                                               set arriendo = ".$this->bd->sqlvalue_inyeccion($carriendo,true).'
                                             where idren_local='.$this->bd->sqlvalue_inyeccion($idren_local,true);
                		
            		}
            		//-------------------------------------------------------------------------------
            		if ( $tipo == '3') {
            		    
            		    $total = $carriendo + $cluz;
            		    
            		    $base12 = round($carriendo / (1.12),2) ;
            		    $iva    = round($base12 *  (12/100),2);
            		    $base0  = $cluz;
            		    
            		    $this->ATabla[15][valor]  =  $base12;
            		    $this->ATabla[16][valor]  =  $iva;
            		    $this->ATabla[17][valor]  =  $base0;
            		    $this->ATabla[18][valor]  =  $total ;
            		    
             		    $this->ATabla[3][valor]  =   $cdetalle.' ( ARRIENDO PERIODO Y LUZ ELECTRICA)';
            		    
            		    if ( $total > 0  ){
                        		    $id_movimiento = $this->bd->_InsertSQL($this->tabla,$this->ATabla, '-' );
                        		    
                        		    if ( $carriendo > 0 ) {
                        		        $tributa= 'I';
                        		        $this->arriendo( $id_movimiento,$carriendo,$iva,'0.00',$tributa,$base12);
                        		    }
                        		    if ( $cluz > 0 ) {
                        		        $tributa= 'T';
                        		        $this->luz( $id_movimiento,$cluz,'0.00',$cluz,$tributa,'0.00');
                        		    }
                        		    
                        		    $sql = "update rentas.ren_arre_local
                                               set arriendo = ".$this->bd->sqlvalue_inyeccion($carriendo,true).",
                                                   luz  = ".$this->bd->sqlvalue_inyeccion($cluz,true).'
                                             where idren_local='.$this->bd->sqlvalue_inyeccion($idren_local,true);
            		    }
            		}
            		
             		
            		$this->bd->ejecutar($sql);
            		
             		$result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id_movimiento.']</b>';
    		    }
    		    
    		    
             		
         		
		
		echo $result;
		
	}
 
 
	//---------------------------------------
	function periodo($fecha ){
		
		$anio = substr($fecha, 0, 4);
		$mes  = substr($fecha, 5, 2);
		
		$APeriodo = $this->bd->query_array('co_periodo',
				'id_periodo, estado',
				'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true). ' AND
											  mes = '.$this->bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$this->bd->sqlvalue_inyeccion($anio,true)
				);
		
 
		$this->estado_periodo = trim($APeriodo['estado']);
		
		return $APeriodo['id_periodo'];
		
	}
	  
  
	//--------------------
	function luz($id_movimiento,$costo,$monto_iva,$tarifa_cero,$tipo,$baseiva ){
	    
	    $idproducto = 568;
	    //1085
	    //1086 interes
	    
	    $ATabla = array(
	        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
	        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
	        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
	        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
	        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
	        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
	        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
	        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
	        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
	        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tipo,   filtro => 'N',   key => 'N'),
	        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
	        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
	        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
	        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $this->sesion,   filtro => 'N',   key => 'N')
	        
	    );
	    
	    $this->bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
	    
	    
	}
	 
 
//--------------- DetalleMovSin
	function arriendo( $id_movimiento,$costo,$monto_iva,$tarifa_cero,$tipo,$baseiva  ){
    
    $idproducto = 567;
    //1085
    //1086 interes
    
    $ATabla = array(
        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tipo,   filtro => 'N',   key => 'N'),
        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => '0',   filtro => 'N',   key => 'N'),
        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => '1',   filtro => 'N',   key => 'N'),
        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $this->sesion,   filtro => 'N',   key => 'N')
        
    );
    
    $this->bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
    
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
if (isset($_GET['tipo']))	{
 
	
	$idprov        = $_GET['idprov'];
	$idren_local   = $_GET['idren_local'];
	$carriendo     = $_GET['carriendo'];
	$cluz          = $_GET['cluz'];
	$cagua         = $_GET['cagua'];
	$fecha_emite   = $_GET['fecha_emite'];
	$cdetalle      = $_GET['cdetalle'];
	$tipo          = $_GET['tipo'];
	
	
  
	$gestion->genera_transaccion($idprov,$idren_local,$carriendo,$cluz,$cagua,$fecha_emite,$cdetalle,$tipo);
	        
	    
	
	
	
}

  



?>
 
  