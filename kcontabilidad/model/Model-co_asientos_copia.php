<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require 'Model-asientos_saldos.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	private $saldos;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
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
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		
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
		 
		    echo '<script type="text/javascript">DetalleAsiento();</script>';
		}
		
		if ($tipo == 1){
			
		    $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
		    
 			echo '<script type="text/javascript">DetalleAsiento();</script>';
			
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
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( $id_asiento_old ){
		
	     
	    $x = $this->bd->query_array('co_asiento',
	       'fecha, registro, anio, mes,   detalle, sesion, creacion, comprobante, estado, tipo,   id_periodo, 
            documento, modulo, idprov, estado_pago, cuentag, id_tramite,descuento, apagar, base, id_asiento_ref, idmovimiento', 
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento_old,true) 
	        );
	    
	       
		//------------------------------------------------------------
		$sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, id_tramite,detalle, sesion, creacion,
                						comprobante, estado, tipo, documento,modulo,id_periodo)
										        VALUES (". $this->hoy.",".
										        $this->bd->sqlvalue_inyeccion($this->ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($x["anio"], true).",".
										        $this->bd->sqlvalue_inyeccion($x["mes"], true).",".
										        $this->bd->sqlvalue_inyeccion($x["id_tramite"], true).",".
										        $this->bd->sqlvalue_inyeccion($x["detalle"], true).",".
										        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
										        $this->hoy.",".
										        $this->bd->sqlvalue_inyeccion('0', true).",".
										        $this->bd->sqlvalue_inyeccion('digitado', true).",".
										        $this->bd->sqlvalue_inyeccion($x["tipo"], true).",".
										        $this->bd->sqlvalue_inyeccion($x["documento"], true).",".
										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $this->bd->sqlvalue_inyeccion($x["id_periodo"], true).")";
        
 
     
		 $this->bd->ejecutar($sql);
		
          $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
          
        if  ( !empty(trim($idAsiento))) {
          	
            $this->agregarDetalle( $idAsiento,$id_asiento_old);
         
          }
     
              
          $result = ' <b>Asiento generado Nro.'.$idAsiento.' </b>';
 
		 echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregarDetalle( $idAsiento,$id_asiento_old){
		
	       
	    $sql_det = 'SELECT id_asientod, id_asiento, cuenta, debe, haber, id_periodo, 
                           anio, mes, sesion, creacion, 
                           registro, 
                           aux, principal, codigo1, codigo2, 
                           codigo3, codigo4, partida, item, monto1, monto2
                     FROM co_asientod
                     WHERE id_asiento = '.$this->bd->sqlvalue_inyeccion($id_asiento_old, true).' and
                           registro ='.$this->bd->sqlvalue_inyeccion($this->ruc, true);
	    
	    
	    $stmt13 = $this->bd->ejecutar($sql_det);
	    
	    while ($x=$this->bd->obtener_fila($stmt13)){
	        
	        $sql_inserta = "INSERT INTO co_asientod(
								id_asiento, cuenta, aux,debe, haber, id_periodo, 
                                  principal, codigo1, codigo2, codigo3, codigo4, 
                                partida, item, monto1, monto2,
                                anio, mes,
								sesion, creacion, registro)
								VALUES (".
								$this->bd->sqlvalue_inyeccion($idAsiento , true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["cuenta"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["aux"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["debe"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["haber"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["id_periodo"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["principal"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["codigo1"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["codigo2"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["codigo3"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["codigo4"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["partida"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["item"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["monto1"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["monto2"]), true).",".
 								$this->bd->sqlvalue_inyeccion(trim($x["anio"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["mes"]), true).",".
								$this->bd->sqlvalue_inyeccion(trim($x["sesion"]), true).",".
								$this->hoy.",".
								$this->bd->sqlvalue_inyeccion( $this->ruc, true).")";
								
								$this->bd->ejecutar($sql_inserta);
								
								
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
if (isset($_GET['id_asiento']))	{
	
	 
	   $id            		= $_GET['id_asiento'];
	  
		$gestion->agregar(trim($id));
	 
	 
	
}

 



?>
 
  