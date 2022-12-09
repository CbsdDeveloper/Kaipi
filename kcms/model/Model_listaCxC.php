<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	private $set;
	
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
		$this->set     = 	new ItemsController;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function cuentaxcobrar( $idprov,$idasiento){
		
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Realizar Cobro</div>
              <div class="panel-body">';
	    
	    $this->FormularioPago( $idprov,$idasiento);
	    
	    echo '</div>
            </div>'; 
	 
	    $ViewFormCxc= '<h6><br>'.' Resumen cuenta por cobrar '.$idprov.'</br></h6>';
	    
	    echo $ViewFormCxc;
	
	}
 //---------------------------------
	function FormularioPago( $idprov,$idasiento){
	    
	 $tipo = $this->bd->retorna_tipo();
	    
	 $datos = $this->bd->query_array('view_aux',
	                                      'cuenta, debe, haber, pago, razon, tipo, registro', 
	                                      'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and 
                                           idprov='.$this->bd->sqlvalue_inyeccion($idprov,true). ' and
                                           debe > 0'
	               );
	 	 
	 $datos['cuenta_cobro'] = $datos['cuenta'];
	 
	 $datos['cobro_total']  = $datos['debe'];
	 
	 $saldo = $this->_actualiza_pago($idasiento,$idprov,$datos['cuenta_cobro']);
	 
	 $datos['cobro_pago']  = $saldo;
	 
	 $datos['cliente_cobro']  = $datos['razon'];
   
	 echo '<div class="alert alert-warning"><div class="row"> <div class="col-md-8"> ';
	 
	
	 
	$resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE BANCO ]' as nombre
          											FROM co_plan_ctas
          											where cuenta = '1' and registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true)."
                                        union
                                        SELECT cuenta as codigo, detalle as nombre
          											FROM co_plan_ctas
          											where tipo_cuenta = 'B' and univel = 'S' and
                                                          registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );
	
	
	
	$this->obj->list->listadb($resultado,$tipo,'Banco','idbancos',$datos,'required','','div-2-10');
	
	
	$MATRIZ =   $this->obj->array->catalogo_tipo_tpago();
	
	 
	$evento = '  ';
	
	$this->obj->text->text('Fecha',"date",'fecha_pago',15,15,$datos,'required','','div-2-4');
	
	
	$this->obj->list->listae('Forma pago',$MATRIZ,'tipo_pago',$datos,'required','',$evento,'div-2-4');
	
	
	$this->obj->text->text('Nro.Cheque',"texto",'cheque_pago',15,15,$datos,'required','','div-2-4');
	
	
	$this->obj->text->text('Nro.Retencion',"texto",'retencion_pago',15,15,$datos,'required','','div-2-4');
	
	$this->obj->text->text('US $',"number",'cobro_pago',0,30,$datos,'required','','div-2-4') ;
 
	
	

	
	echo '</div>
                <div class="col-md-4"> ';
	               
	               $this->obj->text->text('Cliente',"texto",'cliente_cobro',0,50,$datos,'','readonly','div-2-10') ;
	               $this->obj->text->text('Cuenta',"texto",'cuenta_cobro',0,30,$datos,'','readonly','div-2-10') ;
	               $this->obj->text->text('US $',"number",'cobro_total',0,30,$datos,'','readonly','div-2-10') ;
	        
	               if (	 $datos['pago'] == 'N') {
	                   
 	               echo '<label style="padding-top: 5px;text-align: right;" class="col-md-2"> &nbsp; </label>
                        <div style="padding-top: 5px;" class="col-md-10"> 
                           <input type="button" onClick="GuardarAuxiliarCxC()" class="btn btn-info" value="Cobrar Factura"> 
                        </div>
                        <div id="result_cxcpago">   </div> ';
 	               
	               }
    echo ' </div>
    </div></div>';
	
	}
	
	//---------------------------------
	function GrillaPago( $idprov,$idasiento){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
	    $datos = $this->bd->query_array('view_aux',
	        'cuenta, debe, haber, pago, razon, tipo, registro',
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idasiento,true). ' and
                                           idprov='.$this->bd->sqlvalue_inyeccion($idprov,true). ' and
                                           debe > 0'
	        );
	    
 
	        
	     $sql = 'SELECT id_asiento AS "Asiento",
                        id_asiento_aux || '."' '" .' as "Referencia",
                        fecha as "Fecha",
                        cuenta as "Cuenta",
                        comprobante as "Comprobante",
                        detalle as "Detalle",
                        debe as "Debe",haber as "Haber",
                        debe - haber as "Saldo"
                FROM view_aux
                where id_asiento ='. $this->bd->sqlvalue_inyeccion($idasiento , true).' and 
                      idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                      estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and 
                      cuenta='. $this->bd->sqlvalue_inyeccion(trim($datos['cuenta']) , true).' union 
                SELECT id_asiento AS "Asiento",
                        id_asiento_aux || '."' '" .' as "Referencia",
                        fecha as "Fecha",
                        cuenta as "Cuenta",
                        comprobante as "Comprobante",
                        detalle as "Detalle",
                        debe as "Debe",haber as "Haber",
                        debe - haber as "Saldo"
                FROM view_aux
                where id_asiento_ref ='. $this->bd->sqlvalue_inyeccion($idasiento , true).' and 
                      idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and 
                       estado = '. $this->bd->sqlvalue_inyeccion('aprobado' , true).' and 
                      cuenta='. $this->bd->sqlvalue_inyeccion(trim($datos['cuenta']) , true);
 
      
	      $resultado  = $this->bd->ejecutar($sql);
	      
	      $this->obj->grid->KP_sumatoria(7,"Debe","Haber", 'Saldo','');
	  
	   
	    
	     $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'cuenta',$formulario,'N','','','','');
	     
 
	     
	    
	}
	//----
	function _actualiza_pago($idasiento,$idprov,$cuenta){
	
	
	
	    $saldos =  $this->bd->query_array(
	    'view_aux',
	    'sum(debe) as debe,sum(haber) as haber',
	        'id_asiento ='.  $this->bd->sqlvalue_inyeccion($idasiento , true).' and
               idprov = '.  $this->bd->sqlvalue_inyeccion($idprov , true).' and
               estado = '.  $this->bd->sqlvalue_inyeccion('aprobado' , true).' and
               cuenta='.    $this->bd->sqlvalue_inyeccion(trim($cuenta) , true)
	    );
	
	    $saldosAux =  $this->bd->query_array(
	    'view_aux',
	    'sum(debe) as debe,sum(haber) as haber',
	        'id_asiento_ref ='.  $this->bd->sqlvalue_inyeccion($idasiento , true).' and
               idprov = '.  $this->bd->sqlvalue_inyeccion($idprov , true).' and
               estado = '.  $this->bd->sqlvalue_inyeccion('aprobado' , true).' and
               cuenta='.    $this->bd->sqlvalue_inyeccion(trim($cuenta) , true)
	    );
	
	
	$saldo1       =  $saldos['debe'] - $saldos['haber'];
	$saldo2       =   $saldosAux['debe'] - $saldosAux['haber'];
	
	$saldo       =   $saldo1 + $saldo2;
	
	
	
	
	return $saldo;
	
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
if (isset($_GET["idprov"]))	{
	
 
    $idprov				=   $_GET["idprov"];
    $idasiento          =   $_GET["idasiento"];
 
    $gestion->cuentaxcobrar( $idprov,$idasiento);
 
	
}
 
 

?>
 
  