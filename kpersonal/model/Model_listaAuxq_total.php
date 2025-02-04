<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class Model_listaAuxq_total{
	
 	
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
	function Model_listaAuxq_total( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		$this->set     = 	new ItemsController;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function GrillaMaestro(  $anio, $bandera){
		
	    $idprov ='';
	    
	    $cuenta = '112.01.03';
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos por Auxiliar</div>
              <div class="panel-body">
               <ul class="list-group">';

 
 
	    $this->GrillaPago( $idprov,$cuenta,$anio);
     
	    
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
 
		
	    $ViewFormCxc= '<h6><br>'.' Resumen de Auxiliares '.$idprov.'</br></h6>';
	    
	    echo $ViewFormCxc;
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$cuenta,$anio){
	    
	    $tipo 		    = $this->bd->retorna_tipo();
	    
		$this->titulo();
		// PRUEBA DE BUSQUEDA CORRECTA DE SALDOS
		$filas="";
		$sumaSolicitado = 0;
		$sumaPagado = 0;
		$sumaSaldo = 0;
		// 1 OBTENER TODOS LOS FUNCIONARIOS CON ANTICIPOS CONTABILIZADOS EN EL PERIODO
		$sqlPersonal="SELECT distinct a.idprov,s.razon FROM public.co_anticipo a INNER JOIN public.par_ciu s on a.idprov = s.idprov WHERE anio='".$anio."' and a.estado='contabilizado' order by razon";
		$stmtPersonal = $this->bd->ejecutar($sqlPersonal);
		while ($personal=$this->bd->obtener_fila($stmtPersonal)){
			$idprov =  trim($personal['idprov']);
			// echo '<li class="list-group-item">(1) - '.$idprov.'</li>';

			// 2 BUSCAR EL ANTICIPO MAS RECIENTE EN CASO DE QUE TENGA MAS DE UNO (POR SEGURIDAD ASUMIR QUE SIEMPRE VA A TENER MAS DE UNO)
			$sqlAnticipos="SELECT a.id_asiento,a.fecha,a.id_anticipo,a.solicita,a.mensual,a.plazo,s.razon as funcionario,g.razon as garante FROM public.co_anticipo a INNER JOIN public.par_ciu s on a.idprov = s.idprov INNER JOIN public.par_ciu g on a.idprov_ga = g.idprov WHERE a.anio='".$anio."' and a.estado='contabilizado' and a.idprov='".$idprov."' ORDER BY id_anticipo DESC limit 1";
			$stmtAnticipos = $this->bd->ejecutar($sqlAnticipos);
			while ($anticipos=$this->bd->obtener_fila($stmtAnticipos)){
				$id_asiento=trim($anticipos['id_asiento']);
				$fecha=trim($anticipos['fecha']);
				$id_anticipo=trim($anticipos['id_anticipo']);
				$solicita=trim($anticipos['solicita']);
				$mensual=trim($anticipos['mensual']);
				$plazo=trim($anticipos['plazo']);
				$funcionario=trim($anticipos['funcionario']);
				$garante=trim($anticipos['garante']);
				// echo '<li class="list-group-item">----------(2) - '.$id_asiento.'  - '.$fecha.'  - '.$id_anticipo.'  - '.$solicita.'  - '.$mensual.' </li>';
				
				// 3 OBTENER TODO LO COBRADO EN LA CUENTA 112.01.03 AL FUNCIONARIO EN CUESTION 
				$sqlCobros="SELECT * FROM public.view_aux WHERE anio='".$anio."' and estado='aprobado' and cuenta='112.01.03' and idprov='".$idprov."' and id_asiento > '".$id_asiento."'";
				$stmtCobros = $this->bd->ejecutar($sqlCobros);
				$sumaHaber=0;
				$cantidadPagos=0;
				while ($cobros=$this->bd->obtener_fila($stmtCobros)){
					$haber=trim($cobros['haber']);
					$sumaHaber+=$haber;
					$cantidadPagos+=1;
					// echo '<li class="list-group-item">----------(3) - '.$haber.'</li>';
				}

				$sumaSolicitado += $solicita;
				$sumaPagado += $sumaHaber;

				$filas.='<tr>
					<td>'.$idprov.'</td>
					<td>'.$funcionario.'</td>
					<td>'.$garante.'</td>
					<td align="right">'.number_format($solicita,2).'</td>
					<td align="right">'.number_format($plazo,2).'</td>
					<td align="right">'.number_format($mensual,2).'</td>
					<td align="right">'.number_format($cantidadPagos,2).'</td>
					<td align="right">'.number_format($sumaHaber,2).'</td>
					<td align="right">'.number_format(($solicita-$sumaHaber),2).'</td>
					<td width="90"><a class="btn btn-xs" href="#" onclick="javascript:abrirReporte('."'".$idprov."'".')"><i class="icon-zoom-in icon-white"></i></a> </td>
				</tr>';



				// if (($solicita-$sumaHaber) > 0 ) { // hay saldo pendiente
				// 	echo '<li class="list-group-item">----------(4) - Saldo =  '.($solicita-$sumaHaber).'</li>';
				// }else{
				// 	echo '<li class="list-group-item">----------(4) - Deuda Saldada '.($solicita-$sumaHaber).'</li>';
				// }

			}


		}

		$tabla='<table id="caso_1" class="table table-bordered table-hover table-tabletools" border="0" width="100%">
			<thead>
				<tr>
					<th style="background-color: #4993eb;color:#ffffff;">Identificacion</th>
					<th style="background-color: #4993eb;color:#ffffff;">Funcionario</th>
					<th style="background-color: #4993eb;color:#ffffff;">Garante</th>
					<th style="background-color: #4993eb;color:#ffffff;">Solicitado</th>
					<th style="background-color: #4993eb;color:#ffffff;">Plazo</th>
					<th style="background-color: #4993eb;color:#ffffff;">Cuota</th>
					<th style="background-color: #4993eb;color:#ffffff;">Cuotas Pagadas</th>
					<th style="background-color: #4993eb;color:#ffffff;">Pagado</th>
					<th style="background-color: #4993eb;color:#ffffff;">Saldo</th>
					<th> Acciones </th>
				</tr>
			</thead>
			<tbody>
				#FILAS
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td align="right"><b>'.number_format($sumaSolicitado,2).'</b></td>
					<td align="right"><b></b></td>
					<td align="right"><b></b></td>
					<td align="right"><b></b></td>
					<td align="right"><b>'.number_format($sumaPagado,2).'</b></td>
					<td align="right"><b>'.number_format($sumaSolicitado-$sumaPagado,2).'</b></td>
				</tr>
			</tbody>
		</table>';
		$tabla = str_replace("#FILAS", $filas, $tabla);

		echo $tabla;


		// FIN DE PRUEBA DE BUSQUEDA CORRECTA DE SALDOS



		// $this->titulo();
  
 	    
 
	        
	    //     $sql = 'SELECT idprov as identificacion,
	    //     			   funcionario,
		// 				   garante,
		// 		      		round(monto_solicitado/anticipo,2) solicitado, 
		// 				  	round(plazo/anticipo,0) as plazo, 
		// 					round(monto_solicitado /plazo,2) as cuota ,
		// 					round(pagado /anticipo,2) as pagado,
		// 					round((monto_solicitado - pagado)/anticipo,2) as saldo
		// 			FROM view_anticipo_ciu
        //      where   (monto_solicitado - pagado) >0 and
        //      		 anio = '. $this->bd->sqlvalue_inyeccion( $anio , true).'   order by funcionario';
 
	            
	    //   $formulario = 'idprov';
	      
	    //   $resultado  = $this->bd->ejecutar($sql);
	      
	    //   $this->obj->grid->KP_sumatoria(4,"solicitado","pagado", 'saldo','');
	 	    
	    //   $this->obj->grid->KP_GRID_CTAA($resultado,$tipo,'identificacion',$formulario,'S','visor','','','');
	     
  
	     
	}
	function titulo(){
	    
	    
	    $this->hoy 	     =  date("Y-m-d");

		$anio			 = date('Y');
	    
	    $this->login     =  trim($_SESSION['login']);
	    
 
	    
	    $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="110">';
	    
	    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                  <td width ="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>CONTROL DE ANTICIPOS ( PERIODO '.$anio.' ) </b><br>
                        </td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
	    
	}
 
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_listaAuxq_total;

 
 

if (isset($_GET["anio"]))	{
 
    
    $anio					=   $_GET["anio"];
     $bandera				=   $_GET["bandera"];
    
    $gestion->GrillaMaestro( $anio,$bandera);
 
	
}
 
 

?>