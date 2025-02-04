<?php 
	
session_start( );


require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

	$obj     = 	new objects;
	$bd	   =	new Db ;
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$filename = "PlanCuentas.xls";

header("Content-Type: application/vnd.ms-excel");

header("Content-Disposition: attachment; filename=".$filename);




	$usuario = "SELECT  cuenta, cuentas, detalle, nivel, tipo, univel, aux ,tipo_cuenta
				FROM co_plan_ctas  
				where registro = '". $_SESSION['ruc_registro']."'
				order by cuenta";	



	$usuarios=$bd->ejecutar($usuario);


 
	$AResultado = $bd->query_array('web_registro','razon', 
								   'ruc_registro='.$bd->sqlvalue_inyeccion($_SESSION['ruc_registro'],true)
								  ); 


 

    $titulo = 'Plan de Cuentas '.trim($_SESSION['ruc_registro']);
		
    // $AResultado['razon'], 'Contabilidad'
 
	
	
	$content .= '
		<div class="row">
        	<div class="col-md-12">
            	<h1 style="text-align:center;">'.'Plan de cuentas'.'</h1>
       	
      <table border="1" cellpadding="3">
        <thead>
          <tr>
            <th width="10%">Cuenta</th>
            <th width="10%"> Cuentas </th>
            <th width="30%">Detalle Cuenta</th>
            <th width="10%">Nivel</th>
			 <th width="10%">Tipo</th>
            <th width="10%">Transaccion</th>
            <th width="10%">Auxiliar</th>
		    <th width="10%">Tipo Cta</th>
          </tr>
        </thead>
	';
 
	while ($user=$bd->obtener_fila($usuarios)){
		
			if($user['univel']=='S'){  $color= '#dedddd'; }else{ $color= '#fbf7f7'; }

		$content .= ' <tr bgcolor="'.$color.'">
            <td width="10%">'.trim($user['cuenta']).'</td>
            <td width="10%">'.trim($user['cuentas']).'</td>
            <td width="40%">'.htmlentities(trim($user['detalle'])).'</td>
            <td width="10%">'.trim($user['nivel']).'</td>
		    <td width="10%">'.trim($user['tipo']).'</td>
            <td width="10%">'.trim($user['univel']).'</td>
            <td width="10%">'.trim($user['aux']).'</td>
			<td width="10%">'.trim($user['tipo_cuenta']).'</td>
 
        </tr>
	';
	}
	
	$content .= '</table>';
	
	echo $content ;



 

?>
	 