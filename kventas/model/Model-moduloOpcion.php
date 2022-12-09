<?php
session_start( );

// retorna el valor del campo para impresion de pantalla

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
/*Creamos la instancia del objeto. Ya estamos conectados*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   = new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


 
$Alocal = $bd->query_array('ven_registro','directorio', 'idven_registro='.$bd->sqlvalue_inyeccion(1,true)  );

$_SESSION['directorio_crm'] = $Alocal['directorio'];

$moduloOpcion = $_GET["ViewModulo"];


$clase = array("btn btn-lg btn-primary", "btn btn-lg btn-info",
    "btn btn-lg btn-success", "btn btn-lg btn-warning",
    "btn btn-lg btn-danger", "btn btn-lg btn-inverse"
);


$fontsize ='style="font-weight:450;color: #1D1C1C;font-size: 12px"';

$acordeon1 ='<div class="panel panel-default">
												  <div class="panel-heading">
													<h4 class="panel-title">
													  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" '.$fontsize.'>
                   										<span class="glyphicon glyphicon-tasks"> </span> GESTION</a>
													</h4>
												  </div>
												  <div id="collapse1" class="panel-collapse collapse in">
													<div class="panel-body"> ';

$acordeon2 ='<div class="panel panel-default">
												  <div class="panel-heading">
													<h4 class="panel-title">
													  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" '.$fontsize.'>
                   										<span class="glyphicon glyphicon-cog"> </span> PARAMETROS</a>
													</h4>
												  </div>
												  <div id="collapse2" class="panel-collapse collapse">
													<div class="panel-body"> ';

$acordeon3 ='<div class="panel panel-default">
												  <div class="panel-heading">
													<h4 class="panel-title">
													  <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" '.$fontsize.'>
                   										<span class="glyphicon glyphicon-folder-close"> </span> REPORTES</a>
													</h4>
												  </div>
												  <div id="collapse3" class="panel-collapse collapse">
													<div class="panel-body"> ';

$pieacordeon = '</div>  </div></div>';

echo ' <div class="panel-group" id="accordion">';

$tipo = 1 ;
$i = 0;

//  ------------ GESTION ----------------------
$sql = "select a.modulo,a.vinculo,a.script
					       	        from par_modulos a,par_usuario b, par_rol c
									where b.idusuario = c.idusuario and
									      a.id_par_modulo = c.id_par_modulo and
						                  a.publica = 'O' and a.ruta =".$bd->sqlvalue_inyeccion($moduloOpcion,true)." and
						                  b.idusuario  =" .$bd->sqlvalue_inyeccion($_SESSION['usuario'] ,true).'  and
									      a.script  = '.$bd->sqlvalue_inyeccion('A' ,true).'
									order by a.logo' ;


/*Ejecutamos la query*/
$stmt = $bd->ejecutar($sql);

echo $acordeon1;

echo '<ul class="nav nav-pills nav-stacked">';

while ($x=$bd->obtener_fila($stmt)){
    $clase ='';
    $url = trim($x['vinculo']);
    $modulo = trim($x['modulo']);
    $enlace ="'".$url."'".','."''".",'".trim($x['modulo'])."'";
    $vinculo = 'javascript:open_enlace('.$enlace.')';
    $magen = '<img src="../view/tree.png" />&nbsp;';
    echo '<li '.$clase.' style="padding:0px"><a href="'.$vinculo.'" style="padding:2px"> '.$magen.$modulo.' </a></li>';
    
}
echo '</ul>';

echo $pieacordeon;

//  ------------ PARAMETROS  ----------------------

//----------------------------------------------------------------------
$sql = "select a.modulo,a.vinculo,a.script
       	        from par_modulos a,par_usuario b, par_rol c
				where b.idusuario = c.idusuario and
				      a.id_par_modulo = c.id_par_modulo and
	                 a.publica = 'O' and a.ruta =".$bd->sqlvalue_inyeccion($moduloOpcion,true)." and
	                  b.idusuario  =" .$bd->sqlvalue_inyeccion($_SESSION['usuario'] ,true).'  and
				      a.script  = '.$bd->sqlvalue_inyeccion('B' ,true).'
				order by a.logo' ;

/*Ejecutamos la query*/
$stmt1 = $bd->ejecutar($sql);
echo $acordeon2;
echo '<ul class="nav nav-pills nav-stacked">';
while ($x=$bd->obtener_fila($stmt1)){
    $clase ='';
    $url = trim($x['vinculo']);
    $modulo = trim($x['modulo']);
    $enlace ="'".$url."'".','."''".",'".trim($x['modulo'])."'";
    $vinculo = 'javascript:open_enlace('.$enlace.')';
    $magen = '<img src="../view/tree.png" />&nbsp;';
    echo '<li '.$clase.' style="padding:0px"><a href="'.$vinculo.'" style="padding:2px"> '.$magen.$modulo.' </a></li>';
}
echo '</ul>';
echo $pieacordeon;


//----------------------------------------------------------------------
$sql = "select a.modulo,a.vinculo,a.script
       	        from par_modulos a,par_usuario b, par_rol c
				where b.idusuario = c.idusuario and
				      a.id_par_modulo = c.id_par_modulo and
	                  a.publica = 'O' and a.ruta =".$bd->sqlvalue_inyeccion($moduloOpcion,true)." and
	                  b.idusuario  =" .$bd->sqlvalue_inyeccion($_SESSION['usuario'] ,true).'  and
				      a.script  = '.$bd->sqlvalue_inyeccion('C' ,true).'
				order by a.script, a.id_par_modulo' ;

/*Ejecutamos la query*/
$stmt2 = $bd->ejecutar($sql);

echo $acordeon3;


echo '<ul class="nav nav-pills nav-stacked">';
while ($x=$bd->obtener_fila($stmt2)){
    $clase ='';
    $url = trim($x['vinculo']);
    $modulo = trim($x['modulo']);
    $enlace ="'".$url."'".','."''".",'".trim($x['modulo'])."'";
    $vinculo = 'javascript:open_enlace('.$enlace.')';
    $magen = '<img src="../view/tree.png" />&nbsp;';
    echo '<li '.$clase.' style="padding:0px"><a href="'.$vinculo.'" style="padding:2px"> '.$magen.$modulo.' </a></li>';
}
echo '</ul>';



echo $pieacordeon;

echo '<div class="panel-heading">
	 <h4 class="panel-title">
	 <a data-toggle="collapse" data-parent="#accordion" onclick="closeNav()" href="#" '.$fontsize.' >
	 <span class="glyphicon glyphicon-chevron-left"> </span> REGRESAR</a>
	 </h4>
	 </div>';


echo '</div>';

$modulo = '';



echo $modulo;

?>
  
  