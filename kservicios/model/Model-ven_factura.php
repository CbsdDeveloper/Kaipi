<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
	private $POST;
	private $ATabla;
	private $ATabla_detalle;
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
		
		$this->sesion 	 =     trim($_SESSION['email']);
		
		$this->hoy 	     =     date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->ATabla = array(
            array( campo => 'id_ren_movimiento',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fechaa',tipo => 'DATE',id => '2',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'comprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'documento',tipo => 'VARCHAR2',id => '5',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => 'E', key => 'N'),
            array( campo => 'cierre',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => 'N', key => 'N'),
            array( campo => 'iva',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'base0',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'base12',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'interes',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'descuento',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'recargo',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'total',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'carga',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'envio',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '17',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'N', valor =>$this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '20',add => 'S', edit => 'N', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesion_pago',tipo => 'VARCHAR2',id => '23',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'modulo',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'N', valor => 'servicios', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'mes',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'multa',tipo => 'NUMBER',id => '27',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'fechap',tipo => 'DATE',id => '28',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion_baja',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '30',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_rubro',tipo => 'NUMBER',id => '31',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'fecha_obligacion',tipo => 'DATE',id => '32',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'subtotal',tipo => 'NUMBER',id => '33',add => 'S', edit => 'N', valor => '-', key => 'N')
         );
		
		 $this->tabla 	  	     = 'rentas.ren_movimiento';
        
		 $this->secuencia 	     = 'rentas.ren_movimiento_id_ren_movimiento_seq';
		 
 
		 
		 $this->ATabla_detalle = array(
			 array( campo => 'idproducto_ser',tipo => 'NUMBER',id => '0',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'id_ren_movimiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'id_ren_movimientod',tipo => 'NUMBER',id => '2',add => 'N', edit => 'N', valor => '-', key => 'S'),
			 array( campo => 'costo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'monto_iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'baseiva',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'tarifa_cero',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'descuento',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'interes',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'recargo',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'total',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
			 array( campo => 'tipo',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '0', key => 'N'),
			 array( campo => 'sesion',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
			 array( campo => 'creacion',tipo => 'DATE',id => '13',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
		 );
		

		 		
		$this->ATablaPago = array(
		    array( campo => 'id_renpago',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
		    array( campo => 'formapago',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => 'efectivo', key => 'N'),
		    array( campo => 'tipopago',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => 'caja', key => 'N'),
		    array( campo => 'monto',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'idbanco',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '0', key => 'N'),
		    array( campo => 'cuenta',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'fecha_pago',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
		    array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
		    array( campo => 'fechad',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'fcreacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor =>$this->hoy 	, key => 'N'),
		    array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor =>'-' 	, key => 'N'),
		    array( campo => 'activo',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>'N' 	, key => 'N'),
		);
		

	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		//inicializamos la clase para conectarnos a la bd
		
		if ($tipo == 0){
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
			if ($accion == 'editar')
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			    
				if ($accion == 'del')
				    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
				    
		}
		
		if ($tipo == 1){
			
			echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
			
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
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
 
		$qquery = array(  
		    array( campo => 'id_movimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
		    array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 		    array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'carga',   valor => '-',  filtro => 'N',   visor => 'S'),
  		    array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'retencion_ventas',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'retencion_servicios',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'retencion_bienes',   valor => '-',  filtro => 'N',   visor => 'S'),
		    array( campo => 'retencion_renta',   valor => '-',  filtro => 'N',   visor => 'S')
 		);
		
		 $this->bd->JqueryArrayVisor('view_ventas_fac',$qquery );
		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
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
	function agregar( ){
		
		$fecha      =      $_POST["fecha"];
		$detalle    =      substr(trim($_POST["detalle"]),0,300);
 		$idprov 	=      trim($_POST["idprov"]);
		$id_par_ciu 	=  $_POST["id_par_ciu"]; 

 
 

					$Aciu = $this->bd->query_array('par_ciu',    
					'id_par_ciu',                        // CAMPOS
					'idprov ='.$this->bd->sqlvalue_inyeccion ( trim($idprov), true),1
					);	

					$id_par_ciu 	=  $Aciu["id_par_ciu"]; 
 

		$Aproducto = $this->bd->query_array('rentas.ren_movimiento_det',    
								'idproducto_ser',                        // CAMPOS
								'sesion ='.$this->bd->sqlvalue_inyeccion (trim($this->sesion), true).' and
								id_ren_movimiento = 0'
		);	

		$idproducto_ser = $Aproducto["idproducto_ser"]; 

 	
		$x_tramite = $this->bd->query_array('rentas.ren_rubros_matriz',    
			'id_rubro',                        // CAMPOS
			'idproducto_ser='.$this->bd->sqlvalue_inyeccion($idproducto_ser, true)  
        );

		/*
		*/
	 
 
        $titulo  =  $detalle;
        $periodo = explode("-",$fecha);
        $mes     =   $periodo[1]  ;
        $anio    =   $periodo[0]  ;
         
         $input = str_pad($x_tramite['id_rubro'], 4, "0", STR_PAD_LEFT);
        
            
        $this->ATabla[1][valor]  =  $fecha   ;
        $this->ATabla[3][valor]  =  trim($titulo);
        $this->ATabla[4][valor]  =  $input.'-'.$anio;
        
        $this->ATabla[8][valor]   =  '0.00';
        $this->ATabla[9][valor]   =  '0.00'; // total
        $this->ATabla[10][valor]  =  '0.00';
        $this->ATabla[11][valor]  =  '0.00';
        $this->ATabla[12][valor]  =  '0.00';
        $this->ATabla[13][valor]  =  '0.00';
        
        
        $this->ATabla[33][valor]  =  '0.00'; // total
        $this->ATabla[14][valor]  = '0.00';  // total
        $this->ATabla[18][valor]  = '0';
        
        $this->ATabla[25][valor]  =  $anio;
        $this->ATabla[26][valor]  =  $mes;
        
        $this->ATabla[30][valor]  =  $id_par_ciu;
        $this->ATabla[31][valor]  =  $x_tramite['id_rubro'];
        
        $this->ATabla[32][valor]  =  $fecha   ;
		
 
 		    
		 
			
				$id_movimiento =  $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia ,0);
        
 
				 $xx = $this->bd->query_array('rentas.ren_fre_mov',   // TABLA
						'id_fre_mov',                        // CAMPOS
						'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion(0,true) .' and 
							sesion ='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true));

				 
				if ( $xx['id_fre_mov'] > 0 )	 {		

						$sql = 'UPDATE rentas.ren_fre_mov
									SET id_ren_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento ,true) .' 
								WHERE id_fre_mov ='.$this->bd->sqlvalue_inyeccion($xx['id_fre_mov'], true);
						
						$this->bd->ejecutar($sql);		

				}

				$this->_detalle_emision($id_movimiento);

				$this->DetalleTotal($id_movimiento);
            			
                $result = $this->div_resultado('editar',$id_movimiento,1);
            			
            		 
 
		 
 
	 
		echo $result;
		
	}
	/*
	*/
	public function _detalle_emision(  $id_movimiento  ){
        
 
		$sql = " UPDATE rentas.ren_movimiento_det
					SET 	id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id_movimiento, true)."
			  	  WHERE     id_ren_movimiento = 0 and 
						    sesion=".$this->bd->sqlvalue_inyeccion($this->sesion , true);


		$this->bd->ejecutar($sql);

 
        
    }
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion( $id  ){
		
	    $estado =  trim($_POST["estado"]);
	    
 	        
	    if ($estado == 'D') {

			$fecha      =      $_POST["fecha"];
			$detalle    =      substr(trim($_POST["detalle"]),0,300);
			 $idprov 	=      trim($_POST["idprov"]);
			$id_par_ciu 	=  $_POST["id_par_ciu"]; 
			 
		 
 	
	
						$Aciu = $this->bd->query_array('par_ciu',    
						'id_par_ciu',                        // CAMPOS
						'idprov ='.$this->bd->sqlvalue_inyeccion ( $idprov, true) 
						);	
						$id_par_ciu 	=  $Aciu["id_par_ciu"]; 
	 
	
			$Aproducto = $this->bd->query_array('rentas.ren_movimiento_det',    
									'idproducto_ser',                        // CAMPOS
									'sesion ='.$this->bd->sqlvalue_inyeccion (trim($this->sesion), true).' and
									id_ren_movimiento = 0'
			);	
	
			$idproducto_ser = $Aproducto["idproducto_ser"]; 
	
		 
			$x_tramite = $this->bd->query_array('rentas.ren_rubros_matriz',    
				'id_rubro',                        // CAMPOS
				'idproducto_ser='.$this->bd->sqlvalue_inyeccion($idproducto_ser, true)  
			);
	
			/*
			*/
		 
	 
			$titulo  =  $detalle;
			$periodo = explode("-",$fecha);
			$mes     =   $periodo[1]  ;
			$anio    =   $periodo[0]  ;
			 
			 $input = str_pad($x_tramite['id_rubro'], 4, "0", STR_PAD_LEFT);
			
				
			$this->ATabla[1][valor]  =  $fecha   ;
			$this->ATabla[3][valor]  =  trim($titulo);
			$this->ATabla[4][valor]  =  $input.'-'.$anio;
			
			$this->ATabla[8][valor]   =  '0.00';
			$this->ATabla[9][valor]   =  '0.00'; // total
			$this->ATabla[10][valor]  =  '0.00';
			$this->ATabla[11][valor]  =  '0.00';
			$this->ATabla[12][valor]  =  '0.00';
			$this->ATabla[13][valor]  =  '0.00';
			
			
			$this->ATabla[33][valor]  =  '0.00'; // total
			$this->ATabla[14][valor]  = '0.00';  // total
			$this->ATabla[18][valor]  = '0';
			
			$this->ATabla[25][valor]  =  $anio;
			$this->ATabla[26][valor]  =  $mes;
			
			$this->ATabla[30][valor]  =  $id_par_ciu;
			$this->ATabla[31][valor]  =  			
			
			$this->ATabla[32][valor]  =  $fecha   ;

	 
          		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        			
          		$result =$this->div_resultado('editar',$id,1);
           	

				 $xx = $this->bd->query_array('rentas.ren_fre_mov',   // TABLA
				 'id_fre_mov',                        // CAMPOS
				 'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion(0,true) .' and 
					 sesion ='.$this->bd->sqlvalue_inyeccion(trim($this->sesion) ,true));

				
				if ( $xx['id_fre_mov'] > 0 )	 {		

						$sql = 'UPDATE rentas.ren_fre_mov
									SET id_ren_movimiento = '.$this->bd->sqlvalue_inyeccion($id_movimiento ,true) .' 
								WHERE id_fre_mov ='.$this->bd->sqlvalue_inyeccion($xx['id_fre_mov'], true);
						
						$this->bd->ejecutar($sql);		
											
				}

				$this->_detalle_emision($id);

				$this->DetalleTotal($id);



	    }		
		
	    echo $result   ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
	
		$x_tramite = $this->bd->query_array('rentas.ren_movimiento',    
		'*',                        // CAMPOS
		'id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion  ( $id, true) 
         );	
 
		 $estado   = trim($x_tramite['estado']);
		 $cierre   = trim($x_tramite['cierre']);


		 if (  $cierre  == 'N'){

			$id_par_ciu   = $x_tramite['id_par_ciu'];
			$hoy 		  = date("Y-m-d");
			$fechaa		  = $this->bd->fecha($hoy);
			$estado       = 'B';
			 
			 $sql = " UPDATE rentas.ren_movimiento
					   SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
							fechaa=".$this->bd->sqlvalue_inyeccion($hoy, true).",
							id_renpago = 0, carga=0,
							sesion_baja=".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
 					   WHERE  
						   id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id , true)." and 
						   id_par_ciu =".$this->bd->sqlvalue_inyeccion($id_par_ciu , true);
			 
			  
			 $this->bd->ejecutar($sql);
			  
		   
			 $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE ANULADO CON EXITO [ '.$id.' ]</b>';
				
			 echo $result;


	    }		

	}
 
	 
	//-------------
	function AprobarComprobante($accion,$id){
	    
		$x_tramite = $this->bd->query_array('rentas.ren_movimiento',    
		'*',                        // CAMPOS
		'id_ren_movimiento ='.$this->bd->sqlvalue_inyeccion  ( $id, true) 
         );	

        $id_par_ciu     = $x_tramite['id_par_ciu'];
		$id_rubro       = $x_tramite["id_rubro"]; 

	    $hoy 		  = date("Y-m-d");
		$anio 		  = date("Y");
	    $fechaa		  = $this->bd->fecha($hoy);
	    $estado       = 'P';
 	    
		$compro = str_pad($id, 5, "0", STR_PAD_LEFT).'-'.	$anio ;

  

	   if ( $id_rubro  > 0   )		{

				$sql = " UPDATE rentas.ren_movimiento
				SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
					fechap=".$this->bd->sqlvalue_inyeccion($hoy, true).",
					sesion_pago=".$this->bd->sqlvalue_inyeccion($this->sesion, true).",
					comprobante=".$this->bd->sqlvalue_inyeccion($compro, true).",
					carga=".$this->bd->sqlvalue_inyeccion(0, true)."
				WHERE estado = 'E' and
					id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id , true)." and 
					id_par_ciu =".$this->bd->sqlvalue_inyeccion($id_par_ciu , true);

	   }else {


		$x_rubro= $this->bd->query_array('rentas.ren_movimiento_det',    
		'max(idproducto_ser) as  idproducto_ser',                        // CAMPOS
		'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id, true)  
		);
		
		$idproducto_ser = $x_rubro["idproducto_ser"]; 

		$x_rubro_datos = $this->bd->query_array('rentas.ren_rubros_matriz',    
		'id_rubro',                        // CAMPOS
		'idproducto_ser='.$this->bd->sqlvalue_inyeccion($idproducto_ser, true)  
		);

		$id_rubro = $x_rubro_datos["id_rubro"]; 


		$sql = " UPDATE rentas.ren_movimiento
		SET 	estado=".$this->bd->sqlvalue_inyeccion($estado, true).",
			 fechap=".$this->bd->sqlvalue_inyeccion($hoy, true).",
			 id_rubro=".$this->bd->sqlvalue_inyeccion($id_rubro, true).",
			 sesion_pago=".$this->bd->sqlvalue_inyeccion($this->sesion, true).",
			 comprobante=".$this->bd->sqlvalue_inyeccion($compro, true).",
			 carga=".$this->bd->sqlvalue_inyeccion(0, true)."
		WHERE estado = 'E' and
			id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id , true)." and 
			id_par_ciu =".$this->bd->sqlvalue_inyeccion($id_par_ciu , true);

		}

 	 
 	    
 		 
 	    $this->bd->ejecutar($sql);
  	    

		 $this->DetallePago($id);

 	  
 	    $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>COMPROBANTE EMITIDO CON EXITO VERIFIQUE.... [ '.$id.' ]</b>';
	        
	     echo $result;
	        
	}
  //------------------------------
 
 
	//--------------------
	function DetallePago($id){
	        
	     
		$ATotal = $this->bd->query_array('rentas.ren_movimiento',
	                                      '*', 
	      								  'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );

		 $id_par_ciu                =  $ATotal["id_par_ciu"];
		 $efectivo                  =  $ATotal["total"];
 
	    $this->ATablaPago[3][valor] =  $efectivo;
  	    $this->ATablaPago[10][valor] =  $id_par_ciu;
  		 
		
		$tabla 	  	     = 'rentas.ren_movimiento_pago';
 		$secuencia 	     = 'rentas.ren_movimiento_pago_id_renpago_seq';
		
         $id_renpago = $this->bd->_InsertSQL($tabla,$this->ATablaPago,   $secuencia  );
         	            
         	    
	   
		 $sql = " UPDATE rentas.ren_movimiento  
    			   SET 	id_renpago=".$this->bd->sqlvalue_inyeccion( $id_renpago, true)."
     			 WHERE id_ren_movimiento =".$this->bd->sqlvalue_inyeccion($id , true);
	    
	    
	    $this->bd->ejecutar($sql);
	    
	    
	}
	//----/----
	//--------------------
	function DetalleTotal($id){
	    
	    $ATotal = $this->bd->query_array('rentas.ren_movimiento_det',
	                                      'sum(tarifa_cero) as tarifa_cero, sum(total) as total', 
	      								  'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
	        );
	    
			 
 
	    $sql = " UPDATE rentas.ren_movimiento  
    			   SET 	base0=".$this->bd->sqlvalue_inyeccion( $ATotal['total'], true).",
                        subtotal=".$this->bd->sqlvalue_inyeccion($ATotal['total'], true).",
                    	total=".$this->bd->sqlvalue_inyeccion($ATotal['total'], true)." 
     			 WHERE id_ren_movimiento =".$this->bd->sqlvalue_inyeccion($id , true);
	    
	    
	    $this->bd->ejecutar($sql);
 
	      
	      return  $ATotal['total'];
 
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
if (isset($_GET['accion']))	{
	
	$accion    = trim($_GET['accion']);
	
	$id        = $_GET['id'];
	
	$tipo      = 'F';
	
 	
	if ($accion == 'aprobacion'){
	    
	    $gestion->AprobarComprobante($accion,$id);
	
	}elseif($accion == 'alerta'){
	        
		$gestion->_alerta($id);
		
	}elseif($accion == 'del'){
	        
		$gestion->eliminar($id);
		
	}	
	else{
		
		$gestion->consultaId($accion,$id);
	}
	
	
	
}

    //------ grud de datos insercion
    if (isset($_POST["action"]))	{
    	
    	$action = $_POST["action"];
    	
    	$id     = $_POST["id_movimiento"];
    	
    	$gestion->xcrud(trim($action),$id);
    	
    }



?>
 
  