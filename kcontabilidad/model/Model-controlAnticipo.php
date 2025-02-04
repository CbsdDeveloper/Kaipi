<?php
session_start();

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php';  

require 'Model-asientos_saldos.php';  

class proceso{
	
	 
	
	private $obj;
	private $bd;
	private $saldos;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $anio;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
 		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  $this->bd->hoy();
		
	 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		$this->anio       =  $_SESSION['anio'];
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo,$estado){
		//inicializamos la clase para conectarnos a la bd
	
	   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
 
		if ($tipo == 0){
			
			if ($accion == 'editar'){
			    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
			}
				
		    if ($accion == 'del'){
		        $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
		    }
 
		}
		
		if ($tipo == 1){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
 
			
		}
		
		if ($tipo == 2){
			
		    $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b>';
		    
		}
  	
 		
		return $resultado;
		
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
				array( campo => 'id_asiento',    valor =>$id,  filtro => 'S',   visor => 'S'),
				array( campo => 'id_periodo',    valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'fecha',         valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'nomina',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'documento',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'tipo',     valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'id_tramite',     valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'detalle',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'sesion',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'modulo',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'sesion',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'modulo',  valor => '-',  filtro => 'N',   visor => 'S'),
		        array( campo => 'sesionm',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'proveedor',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'base',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'modificacion',  valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'apagar',  valor => '-',  filtro => 'N',   visor => 'S'),
				array( campo => 'creacion',  valor => '-',  filtro => 'N',   visor => 'S')
		);
		
		
		
 		$datos = $this->bd->JqueryArrayVisor('view_asientos',$qquery );

 		
		
	 
 
	 	$result =  $this->div_resultado($accion,$id,0,$datos['estado']);
		
		echo  $result;
	}
	//--------------------------------------------------------------------------------------
	//aprobaci�n de asientos
	function aprobacion( $id  ){
		
	    $comprobante =  $this->saldos->_aprobacion_anticipo($id);
	     
	    if ($comprobante <> '-')	{
	    

			$sql_update = "update co_anticipo 
			set estado=".  $this->bd->sqlvalue_inyeccion(  'contabilizado'  ,true).' 
			where id_asiento='. $this->bd->sqlvalue_inyeccion(  $id ,true);

			$this->bd->ejecutar($sql_update);


	        $result = $this->div_resultado('aprobado',$id,2,$comprobante);
	 
	    }else{
	        
	        $result = 'NO SE APROBO EL ASIENTO... REVISE AUXILIARES - ENLACES PRESUPUESTARIOS INGRESO - GASTO';
	    }
 			
		 
		echo $result;
	}
	 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id,	$estado  ){
		
		
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
		
		if ($action == 'cambio_tramite'){
			
			$this->cambio_datos($id,	$estado   );
			
		}
		
	}
	//--------------------------
	function apagar_asiento( $idasiento, $aidprov ){
	    
	    
	    $idprov = trim($aidprov['idprov']);
	    
	    $secuencia = $this->bd->query_array('co_asiento_aux',
	        'sum(haber)  - sum(debe) as total',
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)." and cuenta like '213.%' and
             id_asiento=".$this->bd->sqlvalue_inyeccion($idasiento,true)
	        );
	    
	    
	    $len = strlen(trim($idprov));
	    
	    $total = $secuencia['total'];
	    
	    $sql = " UPDATE co_asiento
							    SET 	apagar      =".$this->bd->sqlvalue_inyeccion($total, true)."
 							      WHERE id_asiento   =".$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
	    if ( $len > 8 ){
	        
	        $this->bd->ejecutar($sql);
	    }
	  
	    
	    
	    
	    return 1;
	    
	}
 	 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetalle( $id,$cuenta, $debe,$haber, $idprov){
		
	 
		    
					$periodo_s = $this->bd->query_array('co_asiento',
														'mes,anio,id_periodo,fecha,detalle',
														'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)  	);

					$id_periodo     = $periodo_s["id_periodo"];
					$mes  			= $periodo_s["mes"];
					$anio  			= $periodo_s["anio"];

                    $fecha   	    = $periodo_s["fecha"];
                    $detalle	    = $periodo_s["detalle"];
				 
					$datosaux  = $this->bd->query_array('co_plan_ctas',
											'aux',
						                	'cuenta='.$this->bd->sqlvalue_inyeccion($cuenta,true).' and 
										    registro ='.$this->bd->sqlvalue_inyeccion( $this->ruc,true)
											);
					 		
					$aux		= $datosaux['aux'];
					
					
					$sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$this->bd->sqlvalue_inyeccion($id , true).",".
								$this->bd->sqlvalue_inyeccion( $cuenta, true).",".
								$this->bd->sqlvalue_inyeccion( $aux, true).",".
								$this->bd->sqlvalue_inyeccion($debe, true).",".
								$this->bd->sqlvalue_inyeccion($haber, true).",".
								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
								$this->bd->sqlvalue_inyeccion( $anio, true).",".
								$this->bd->sqlvalue_inyeccion( $mes, true).",".
								$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
								$this->hoy.",".
								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
								
								$this->bd->ejecutar($sql_inserta);
								
                                $id_asientod = $this->bd->ultima_secuencia('co_asientod');

                                $this->saldos->_aux_contable($fecha,$id,$id_asientod,$detalle,$cuenta,$idprov,$debe,$haber,'0','N','-','-');
							
		 								        
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id){
		
        $fecha_registro   = $_POST["fecha"];
        $x                = explode('-',$fecha_registro);
        $mes  			  = $x[1];
        $anio  			  = $x[0];

        //------------ seleccion de periodo
	 	$periodo_s = $this->bd->query_array('co_periodo','id_periodo,mes,anio',
                    'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                    anio='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
                    mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
                    );

          $aprov         = $this->bd->query_array('co_asiento',
                            'idprov',
                            'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true)
                            );


	 	$estado           = trim($_POST["estado"]);
	
		$fecha		      = $this->bd->fecha($_POST["fecha"]);
		$hoy 		      = date('Y-m-d');
		$hoy 		      = $this->bd->fecha( $hoy );
		$bandera          = 0;
	 
	 	$id_periodo       = $periodo_s["id_periodo"];

        $idprov           = trim($aprov["idprov"]);


         $idanticipo        = trim($_POST["idanticipo"]);           

         $idbancos          = trim($_POST["idbancos"]);       	 	
	 	

         $apagar          = $_POST["apagar"] ;       
 
          
	 	if ( $anio   <>  $this->anio ) {
	 	    $bandera = -1;
	 	    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO NO VALIDO... REVISE PORFAVOR PERIODO ?'.$this->anio .'</b>';
	 	}
	 	
	 	
	 	
	 	if ($this->bd->_cierre($fecha_registro) == 'cerrado'){
	 	    $bandera = -1;
	 	    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO CERRADO ?'.$this->anio .'</b>';
	 	    
	 	}
 	 	
         $v1 = $this->valida_cuenta($id,$idanticipo);

         $v2 = $this->valida_cuenta($id,$idbancos);
	 	
      
	 	
	 	if ( $bandera == 0 ){
	 	
        		if (trim($estado) == 'solicitado'){
        		    
                  

                       if (  $v1 == 0 ){
                                        
                                     $this->agregarDetalle( $id,trim($idanticipo), $apagar,'0.00', $idprov);

                            }

                            if ( $v2 == 0 ){

                                     $this->agregarDetalle( $id,trim($idbancos),'0.00',$apagar, $idprov);

                            }

 
        		 			$sql = " UPDATE co_asiento
        							              SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim($_POST["detalle"]), true).",
        											    comprobante  =".$this->bd->sqlvalue_inyeccion($_POST["comprobante"], true).",
														apagar  =".$this->bd->sqlvalue_inyeccion($_POST["apagar"], true).",
														base  =".$this->bd->sqlvalue_inyeccion($_POST["base"], true).",
                                                        id_tramite  =".$this->bd->sqlvalue_inyeccion($_POST["id_tramite"], true).",
                                                        id_periodo   =".$this->bd->sqlvalue_inyeccion($id_periodo, true).",
                                                        sesionm      =".$this->bd->sqlvalue_inyeccion($this->sesion , true).",
                                                        fecha        =".$fecha.",
                                                        modificacion =". $hoy.",
        												tipo         =".$this->bd->sqlvalue_inyeccion(trim($_POST["tipo"]), true).",
        												documento    =".$this->bd->sqlvalue_inyeccion(trim($_POST["documento"]), true)."
        							      WHERE id_asiento           =".$this->bd->sqlvalue_inyeccion($id, true);
        					
        					$this->bd->ejecutar($sql);

                   				 
         
        		}else 	{
        		    
        		    $sql = " UPDATE co_asiento
        							              SET 	detalle      =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["detalle"]), true).",
                                                         fecha       =".$fecha.",
														 apagar  =".$this->bd->sqlvalue_inyeccion($_POST["apagar"], true).",
														 base  =".$this->bd->sqlvalue_inyeccion($_POST["base"], true).",
        												documento    =".$this->bd->sqlvalue_inyeccion(trim(@$_POST["documento"]), true)."
        							      WHERE id_asiento           =".$this->bd->sqlvalue_inyeccion($id, true);
        		    
        		    $this->bd->ejecutar($sql);
        		    
        		}
	       
        		
        		
        		$result = $this->div_resultado('editar',$id,1,$estado);
        		
	 	}	
		
	 	 
	 	
		echo $result;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	    $fecha_registro = $_POST["fecha"];
	    $estado         = trim($_POST["estado"]);
	    $bandera        = 0;
	    
 		
		if ($this->bd->_cierre($fecha_registro) == 'cerrado'){
		    
		    $bandera  = -1;
		    $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO CERRADO '.$this->anio .'</b>';
		    
		}
		
		
		if ( $bandera == 0 ){
		

            if (   $estado  == 'solicitado') {
            
                $sql = " UPDATE co_asiento
                    SET 	estado      =".$this->bd->sqlvalue_inyeccion('anuladoa', true)."
                         WHERE id_asiento  =".$this->bd->sqlvalue_inyeccion($id, true);

                $this->bd->ejecutar($sql);


		         $result = $this->div_limpiar();
            
             }

		}
	 	

		echo $result;
 		
	}

	/*
	cambio_datos
	*/
 
	function valida_cuenta($id,	$cuenta   ){
		
        $longitud = strlen(	$cuenta );
 	
        $x = $this->bd->query_array('co_asientod',   // TABLA
                            'count(*) as nn',                        // CAMPOS
                            'id_asiento='.$this->bd->sqlvalue_inyeccion($id,true) .' and 
                            cuenta='.$this->bd->sqlvalue_inyeccion(trim($cuenta),true));

       if (   $longitud   > 5   ) {

                if (    $x['nn']  > 0  ) {
                    return 1;
                }   
                else
                {
                    return 0;
                }
       }else   {     
              return 1;
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
	
	$accion    		    = $_GET['accion'];
	$id            		= $_GET['id'];
	  
		$gestion->consultaId($accion,$id);
	 
	 
	
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action 	     	=     @$_POST["action"];
	
	$id 				=     @$_POST["id_asiento"];
	
	$estado             = $_POST["estado"];

 	$gestion->xcrud(trim($action) ,  $id,	$estado    );
 
	
}



?>
 
  