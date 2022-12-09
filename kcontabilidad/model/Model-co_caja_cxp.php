<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
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
		$this->bd	   =	new Db ;
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		$this->sesion 	 =     $_SESSION['email'];
 		$this->hoy 	     =      date("Y-m-d");    	//$this->hoy 	     =  
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	 
	
	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($fanio,$fmes){
		
		 	
	    $cadena0 =  '( registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
	    
	    $cadena1 = '( anio ='.$this->bd->sqlvalue_inyeccion($fanio,true).") and ";
	    
	    $cadena4 = '( mes ='.$this->bd->sqlvalue_inyeccion($fmes,true).") and ";
	    
	    $cadena3 = '( estado_pago ='.$this->bd->sqlvalue_inyeccion(trim('N'),true).") and ";
	    
	    $cadena2 = '( transaccion ='.$this->bd->sqlvalue_inyeccion(trim('X'),true).")   ";
	    
 	    
	    
	    $where = $cadena0.$cadena1.$cadena4.$cadena3.$cadena2;
	    
	    $sql = 'SELECT id_asiento, fecha,   detalle,   razon,    documento, idprov  ,   apagar,   marca 
                FROM  view_asientocxp
                where '. $where;
                	    
	  
                          
	    $resultado  = $this->bd->ejecutar($sql);
	    
	    
	    echo ' <table  id="tablaItem" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
					<thead>
						<tr>
							<th width="10%">Asiento</th>
							<th  width="10%">Fecha</th>
                            <th  width="10%">Identificacion</th>
                            <th  width="20%">Nombre</th>
                            <th  width="20%">Detalle</th>
                            <th  width="10%">Documento</th>
                            <th  width="10%">A pagar</th>
 							<th width="10%">Accion </th>
 						</tr>
				  </thead> ';
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $iddato = $fetch['id_asiento'];
 
	        $enlace = '<input type="checkbox" id="myCheck'.$iddato.'" onclick="myFunction('.$iddato.',this)"  >';
	        
	        echo '  <tr>
                        <td>'.$fetch['id_asiento'].'</td>
                        <td>'. ($fetch['fecha']).'</td>
                        <td>'.trim($fetch['idprov']).'</td>
                        <td>'.trim($fetch['razon']).'</td>
                        <td>'.trim($fetch['detalle']).'</td>
                       <td>'.trim($fetch['documento']).'</td>
                       <td>'. ($fetch['apagar']).'</td>
                        <td>'.$enlace.'</td>
                  </tr>';
	        
	    }
	    
	    echo ' </table>';
	    
	    
	    
	}
 	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function pago_caja(   ){
	    
	    
	    $AResultado = $this->bd->query_array('view_asientocxp',
	        'SUM(apagar) as total',
	        'transaccion='.$this->bd->sqlvalue_inyeccion('X',true). ' and '.
	        'registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true). ' and '.
	        'estado_pago='.$this->bd->sqlvalue_inyeccion('N' ,true). ' and '.
	        'marca='.$this->bd->sqlvalue_inyeccion('S',true)
	        
	        );
	    
	    
	    return $AResultado['total'];
	    
	}
	///----------------
	function detalle_cxp( $id_asiento  ){
	    
	    
	    $sql = 'SELECT id_asiento,id_asiento_ref,idprov,apagar,detalle,id_periodo, anio,mes,documento
            FROM  view_asientocxp
            where transaccion = '.$this->bd->sqlvalue_inyeccion('X', true).' and 
            	     registro = '.$this->bd->sqlvalue_inyeccion($this->ruc, true).' and 
                   estado_pago = '.$this->bd->sqlvalue_inyeccion('N', true).' and 
                   marca = '.$this->bd->sqlvalue_inyeccion('S', true);

 
	    
	    $stmtD = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmtD)){
	        
	        $y = $this->bd->query_array('view_aux',
	                                    'cuenta', 
	                                    'idprov='.$this->bd->sqlvalue_inyeccion(trim($x["idprov"]),true).' and  
                                         id_asiento='.$this->bd->sqlvalue_inyeccion($x["id_asiento"],true).' and  
                                         haber <> 0'
	            );
 
	        
	        $this->cuenta_pagar ($id_asiento,$y["cuenta"],
	                                         $x["id_periodo"],
	                                         $x["anio"],
	                                         $x["mes"],
	                                         $x["apagar"],
 	                                         $x["documento"],
	                                         trim($x["idprov"]),
	                                         $x["detalle"] 
	                            );
	        
	        
	      $this->actualiza_asiento($x["id_asiento"], $id_asiento   ) ; 
	        
	    }
	    
	}
//-----------------
	function actualiza_asiento($idasiento, $idasiento_banco   ){
	    
	    
	    $sql = 'UPDATE co_asiento
					 SET   estado_pago='.$this->bd->sqlvalue_inyeccion('S', true).',
						   id_asiento_ref='.$this->bd->sqlvalue_inyeccion($idasiento_banco, true).' 
 				WHERE id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento, true);
	    
	    $this->bd->ejecutar($sql);
	    
	}
 //-----------------
	function actualiza_estado(){
	    
	    
	    $sql = 'UPDATE co_asiento
					 SET   marca='.$this->bd->sqlvalue_inyeccion('N', true).'
  				WHERE marca='.$this->bd->sqlvalue_inyeccion('S', true);
	    
	    $this->bd->ejecutar($sql);
	    
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function suma(   ){
		
		  	
	    $AResultado = $this->bd->query_array('view_asientocxp',
	                                         'SUM(apagar) as total', 
	                                           'transaccion='.$this->bd->sqlvalue_inyeccion('X',true). ' and '.
	                                           'registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true). ' and '.
	                                           'estado_pago='.$this->bd->sqlvalue_inyeccion('N' ,true). ' and '.
                                    	       'marca='.$this->bd->sqlvalue_inyeccion('S',true)
	        
	        );
 
 
	    echo $AResultado['total'];
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion( $asiento,$estado  ){
		
 
	    $UpdateQuery = array(
	        array( campo => 'id_asiento',   valor => $asiento ,  filtro => 'S'),
	        array( campo => 'marca',      valor => $estado,  filtro => 'N')
	    );
	    
	    
	    $this->bd->JqueryUpdateSQL('co_asiento',$UpdateQuery);
     	 
 
	    $mensajeEstado = $this->suma(   );
	    
		
	    echo $mensajeEstado ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function generar_asiento(  ){
		
	    $valorpago = $this->pago_caja() ;
	    
	    
	    $hoy = $this->bd->hoy();
  
	    $idprov    		= $_POST["idprov"];
	    
	    $cuentaBanco    = $_POST["idbancos"];
	    
	    $fecha1			= $_POST["fecha"];
	    
	    $fecha			= $this->bd->fecha($_POST["fecha"]);
	    
	    $cheque			= $_POST["cheque"];
	    
	    $detalle			= $_POST["detalle"];
	    
	    $documento		= $_POST["documento"];
  
	    $comprobante    = '0000000000';
	    
	    $anio = substr($fecha1, 0, 4);
	    
	    $mes  = substr($fecha1, 5, 2);
	    
	    $periodo_s = $this->bd->query_array('co_periodo','id_periodo',
	                                       'registro ='.$this->bd->sqlvalue_inyeccion($this->ruc ,true).' and
                                            mes ='.$this->bd->sqlvalue_inyeccion($mes ,true).' and
                                          	anio='.$this->bd->sqlvalue_inyeccion($anio ,true));
	    
	    $id_periodo = $periodo_s["id_periodo"] ;
	    //------------ crea asiento de bancos
	    
	  
	    
	    
	    $sql = "INSERT INTO co_asiento(   fecha, registro, anio, mes, detalle, sesion, creacion,
                                          comprobante, estado, tipo, documento,id_asiento_ref,modulo,idprov,
                                         estado_pago,apagar,id_periodo)
                                VALUES (".$fecha.",".
                                $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
                                $this->bd->sqlvalue_inyeccion($anio, true).",".
                                $this->bd->sqlvalue_inyeccion($mes, true).",".
                                $this->bd->sqlvalue_inyeccion($detalle, true).",".
                                $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                                $hoy.",".
                                $this->bd->sqlvalue_inyeccion($comprobante, true).",".
                                $this->bd->sqlvalue_inyeccion('digitado', true).",".
                                $this->bd->sqlvalue_inyeccion('X' , true).",".
                                $this->bd->sqlvalue_inyeccion($documento, true).",".
                                $this->bd->sqlvalue_inyeccion(0, true).",".
                                $this->bd->sqlvalue_inyeccion('bancos', true).",".
                                $this->bd->sqlvalue_inyeccion($idprov, true).",".
                                $this->bd->sqlvalue_inyeccion('C', true).",".
                                $this->bd->sqlvalue_inyeccion($valorpago, true).",".
                                $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
                                
                                $this->bd->ejecutar($sql);
                                
                                $id_asiento_banco = $this->bd->ultima_secuencia('co_asiento');
           
                                $this->bancos($id_asiento_banco,$cuentaBanco,$id_periodo,$anio,$mes,$valorpago,$cheque,$idprov,$detalle);
                                
                                
                                $this->detalle_cxp( $id_asiento_banco  ) ;
                                
                                $this->actualiza_estado();
                                
                                $comprobante =  $this->saldos->_aprobacion($id_asiento_banco);
                                
                                $this->div_resultado( ) ;
                                
                                $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>TRANSACCION GENERADA '.$id_asiento_banco.'  </b>';
                       
                                
             echo $result;
		
	}
	
	//-----------------------------
	function div_resultado( ){
	    //inicializamos la clase para conectarnos a la bd
	    
	    echo '<script type="text/javascript">accion();</script>';
 
 
	}
	//----------------------
	function bancos ($id_asiento_banco,$cuentaBanco,$id_periodo,$anio,$mes,$pago,$cheque,$idprov,$detalle ){
	    
	    $hoy = $this->bd->hoy();
	    //------------ crea asiento de detalle bancos
	    
	    $sql = " INSERT INTO co_asientod( id_asiento, cuenta, aux,debe, haber,id_periodo,anio,mes,sesion, creacion, registro)
                    				VALUES (".
                    				$this->bd->sqlvalue_inyeccion($id_asiento_banco , true).",".
                    				$this->bd->sqlvalue_inyeccion($cuentaBanco, true).",".
                    				$this->bd->sqlvalue_inyeccion('S', true).",".
                    				$this->bd->sqlvalue_inyeccion(0, true).",".
                    				$this->bd->sqlvalue_inyeccion($pago, true).",".
                    				$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
                    				$this->bd->sqlvalue_inyeccion($anio, true).",".
                    				$this->bd->sqlvalue_inyeccion($mes, true).",".
                    				$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
                    				$hoy.",".
                    				$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
                    				
                    				$this->bd->ejecutar($sql);
                    				
                    			 	$id_asiento_banco_aux1 = $this->bd->ultima_secuencia('co_asientod');
                    				
                    				//--------- AUXILIAR DETalle
                    				$sql = "INSERT INTO co_asiento_aux(id_asientod, id_asiento, idprov, cuenta,fecha,pago, debe, haber, id_periodo,
          									  anio, mes, sesion, creacion, id_asiento_ref,cheque,tipo,detalle,registro) VALUES (".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_banco_aux1  , true).",".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_banco , true).",".
          									  $this->bd->sqlvalue_inyeccion($idprov , true).",".
          									  $this->bd->sqlvalue_inyeccion($cuentaBanco , true).",".
          									  $hoy.",".
          									  $this->bd->sqlvalue_inyeccion('S' , true).",".
          									  $this->bd->sqlvalue_inyeccion(0 , true).",".
          									  $this->bd->sqlvalue_inyeccion($pago , true).",".
          									  $this->bd->sqlvalue_inyeccion($id_periodo , true).",".
          									  $this->bd->sqlvalue_inyeccion($anio, true).",".
          									  $this->bd->sqlvalue_inyeccion($mes , true).",".
          									  $this->bd->sqlvalue_inyeccion($this->sesion , true).",".
          									  $hoy.",".
          									  $this->bd->sqlvalue_inyeccion(0 , true).",".
          									  $this->bd->sqlvalue_inyeccion($cheque , true).",".
          									  $this->bd->sqlvalue_inyeccion('cheque' , true).",".
          									  $this->bd->sqlvalue_inyeccion($detalle , true).",".
          									  $this->bd->sqlvalue_inyeccion($this->ruc , true).")";
          									  
          									  $this->bd->ejecutar($sql);
 
	}
	//--------------------------------
	function cuenta_pagar ($id_asiento_banco,$cuentaBanco,$id_periodo,$anio,$mes,$pago,$cheque,$idprov,$detalle ){
	    
	    $hoy = $this->bd->hoy();
	    //------------ crea asiento de detalle bancos
	    
	    $sql = " INSERT INTO co_asientod( id_asiento, cuenta, aux,debe, haber,id_periodo,anio,mes,sesion, creacion, registro)
                    				VALUES (".
                    				$this->bd->sqlvalue_inyeccion($id_asiento_banco , true).",".
                    				$this->bd->sqlvalue_inyeccion($cuentaBanco, true).",".
                    				$this->bd->sqlvalue_inyeccion('S', true).",".
                    				$this->bd->sqlvalue_inyeccion($pago, true).",".
                    				$this->bd->sqlvalue_inyeccion(0, true).",".
                    				$this->bd->sqlvalue_inyeccion($id_periodo, true).",".
                    				$this->bd->sqlvalue_inyeccion($anio, true).",".
                    				$this->bd->sqlvalue_inyeccion($mes, true).",".
                    				$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
                    				$hoy.",".
                    				$this->bd->sqlvalue_inyeccion( $this->ruc , true).")";
                    				
                    				$this->bd->ejecutar($sql);
                    				
                    				$id_asiento_banco_aux1 = $this->bd->ultima_secuencia('co_asientod');
                    				
                    				//--------- AUXILIAR DETalle
                    				$sql = "INSERT INTO co_asiento_aux(id_asientod, id_asiento, idprov, cuenta,fecha,pago, debe, haber, id_periodo,
          									  anio, mes, sesion, creacion, id_asiento_ref,cheque,tipo,detalle,registro) VALUES (".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_banco_aux1  , true).",".
          									  $this->bd->sqlvalue_inyeccion($id_asiento_banco , true).",".
          									  $this->bd->sqlvalue_inyeccion($idprov , true).",".
          									  $this->bd->sqlvalue_inyeccion($cuentaBanco , true).",".
          									  $hoy.",".
          									  $this->bd->sqlvalue_inyeccion('S' , true).",".
          									  $this->bd->sqlvalue_inyeccion($pago , true).",".
          									  $this->bd->sqlvalue_inyeccion(0 , true).",".
          									  $this->bd->sqlvalue_inyeccion($id_periodo , true).",".
          									  $this->bd->sqlvalue_inyeccion($anio, true).",".
          									  $this->bd->sqlvalue_inyeccion($mes , true).",".
          									  $this->bd->sqlvalue_inyeccion($this->sesion , true).",".
          									  $hoy.",".
          									  $this->bd->sqlvalue_inyeccion(0 , true).",".
          									  $this->bd->sqlvalue_inyeccion($cheque , true).",".
          									  $this->bd->sqlvalue_inyeccion('cheque' , true).",".
          									  $this->bd->sqlvalue_inyeccion($detalle , true).",".
          									  $this->bd->sqlvalue_inyeccion($this->ruc , true).")";
          									  
          									  $this->bd->ejecutar($sql);
          									  
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
        if (isset($_GET['fanio']))	{
        	
            $fanio       = $_GET['fanio'];
        	
        	$fmes        = $_GET['fmes'];
        	
         
        	$gestion->consultaId($fanio,$fmes);
        	    
         
        
         
        }
        
        
        if (isset($_GET['accion']))	{
            
            $asiento       = $_GET['id'];
            
            $estado       = $_GET['estado'];
            
            
            $gestion->edicion($asiento,$estado);
         
        }
        
        //-------------
        //------ grud de datos insercion
        if (isset($_POST["action"]))	{
            
            $action = @$_POST["action"];
            
            if ( $action == 'aprobar'){
                
                $gestion->generar_asiento( );
            }
               
          //  $gestion->xcrud(trim($action),$id );
            
        }
        

?>
 
  