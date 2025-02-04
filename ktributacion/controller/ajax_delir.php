<?php 
    session_start(); 

    require('../view/Head.php')  ;
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj   = 	new objects;
    
    $bd	   =	 	new Db ;
    
	$set     = 	new ItemsController;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
	if (isset($_POST['accion']))	{

		$id_compras = $_POST['id_compras'];
		K_actualizar($bd,	$_POST);
		K_ejecuta_detalle('#retencion_fuente','../model/ajax_DetAsientoIR.php?id_compras='.$id_compras);
		$obj->var->kaipi_cierre_pop();
	}		

    
 	if (isset($_GET['id']))	{
	
    	 $id_compras = $_GET['id'];
    	 $codigo     = trim($_GET['ref']);
    	 $action     = trim($_GET['action']);

		 $secuencia     = trim($_GET['secuencia']);
    	 
		 $x = $bd->query_array('co_compras',
							    'transaccion,autretencion1,estado', 
							    'id_compras='.$bd->sqlvalue_inyeccion($id_compras,true));


		 if ( $action  == 'del') {
    	 
					if ( $x['estado'] == 'S'  ){
						$auto = $x['transaccion'] ;
						if ( $auto  <> 'E' ){
										$sql = "delete from co_compras_f
												where id_compras=".$bd->sqlvalue_inyeccion($id_compras, true).' and
												      codretair ='.$bd->sqlvalue_inyeccion($codigo, true);
								
										$bd->ejecutar($sql);
										K_ejecuta_detalle('#retencion_fuente','../model/ajax_DetAsientoIR.php?id_compras='.$id_compras);
						}
 					}
     	 			$obj->var->kaipi_cierre_pop();
		 }	
 	
		 if ( $action  == 'editar') {

			K_formulario($bd,    $obj ,$set, $id_compras,$codigo, $secuencia );

	     }	
   	 }	
 
/*
carga de detalle de fuentes
*/		
  function K_ejecuta_detalle($div,$url ){
     
      echo '<script type="text/javascript">';
      echo "  opener.$('".$div."').load('".$url."');   ";
      echo '</script>';  
     
  }
/*
Formulario de edición
*/
function K_formulario ($bd,    $obj , $set, $id_compras,$codigo, $secuencia ){
     
	$datos = $bd->query_array('co_compras_f',
	'*', 
	'id_compras='.$bd->sqlvalue_inyeccion($id_compras,true).' and 
	codretair='.$bd->sqlvalue_inyeccion($codigo,true).' and 
	secuencial='.$bd->sqlvalue_inyeccion($secuencia,true) 

    );

	$datos['accion'] = 'actualizar';
 
 
	echo '<div class="col-md-12">	
	
		  <form action="ajax_delir.php" method="POST"   enctype="multipart/form-data" accept-charset="UTF-8"> ';

					$set->div_label(12,'<h6><b>Retencion Fuente</b> '.$cboton.'</h6>');
					
					$evento = '';
		
					$obj->text->text_yellow('Nro.Factura',"texto",'secuencial',9,9,$datos,'required','','div-3-9');

					$obj->text->text_blue('Codigo Retencion',"texto",'codretair',4,4,$datos,'required','readonly','div-3-9');
					
					$obj->text->texte('Base Imponible',"number",'baseimpair',40,45,$datos,'','',$evento,'div-3-9');
					
					$obj->text->texte('Porcentaje Retencion',"number",'porcentajeair',40,45,$datos,'','',$evento,'div-3-9');

					$obj->text->texte('Monto Retencion',"number",'valretair',40,45,$datos,'','',$evento,'div-3-9');

					$obj->text->texto_oculto("id_compras",$datos); 

					$obj->text->texto_oculto("accion",$datos); 

					echo '<div class="col-md-12" align="center"	style="padding: 15px">	
							<input type="submit" class="btn btn-primary btn-sm" value="Actualizar Información">
							</div>';
						 

	echo '</form></div>';
 
}
/*
guardar informacion 
*/
function K_actualizar ($bd, $POST){


 
 

	$sql = "UPDATE co_compras_f
	SET 	baseimpair	  =".$bd->sqlvalue_inyeccion($POST['baseimpair'], true).",
			porcentajeair =".$bd->sqlvalue_inyeccion($POST['porcentajeair'], true).",
			valretair	  =".$bd->sqlvalue_inyeccion($POST['valretair'], true)."
	WHERE id_compras=".$bd->sqlvalue_inyeccion($POST['id_compras'], true).' and 
		  codretair='.$bd->sqlvalue_inyeccion(trim($POST['codretair']), true).' and 
		  secuencial='.$bd->sqlvalue_inyeccion(trim($POST['secuencial']), true);

	$bd->ejecutar($sql);
 
}
?>