<?php
/* Clase encargada de gestionar las temas y scripts */
class objects_var  {
 private static $_instance;
 //function obtiene titulo 
 function _titulo(){
  $titulo ='Kaipi Plataforma de Gesti�n Empresarial';
  echo $titulo;
  return true;
 }
 //HOJA DE ESTILOS
 function _Theme(){		
  echo '<link href="../kconfig/assets/css/plugins.css" rel="stylesheet" type="text/css" />
		<link href="../kconfig/assets/css/responsive.css" rel="stylesheet" type="text/css" />
		<link href="../kconfig/assets/css/icons.css" rel="stylesheet" type="text/css" />
 		<link rel="stylesheet" href="../kconfig/assets/css/fontawesome/font-awesome.min.css">';
   // echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>";
   return true;
 }   
 //     HOJA DE ESTILLOS jquery PARA LAS PAGINAS
 function _Theme_js(){		
   echo '<!--=== JavaScript ===-->
		 <script type="text/javascript" src="../kconfig/assets/js/libs/jquery-1.10.2.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		 <script type="text/javascript" src="../kconfig/bootstrap/js/bootstrap.min.js"></script>
		 <script type="text/javascript" src="../kconfig/assets/js/libs/lodash.compat.min.js"></script>
		 <!-- Smartphone Touch Events -->
		 <script type="text/javascript" src="../kconfig/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/event.swipe/jquery.event.move.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/event.swipe/jquery.event.swipe.js"></script>
		 <!-- General -->
		 <script type="text/javascript" src="../kconfig/assets/js/libs/breakpoints.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/respond/respond.min.js"></script> <!-- Polyfill for min/m-W CSS3 Media(only for IE8) -->
		 <script type="text/javascript" src="../kconfig/plugins/cookie/jquery.cookie.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
		 <!-- Page specific plugins -->
		 <!-- Charts -->
		 <!--[if lt IE 9]>
		 <script type="text/javascript" src="../kconfig/plugins/flot/excanvas.min.js"></script>
		 <![endif]-->
		 <script type="text/javascript" src="../kconfig/plugins/sparkline/jquery.sparkline.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/flot/jquery.flot.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/flot/jquery.flot.tooltip.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/flot/jquery.flot.resize.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/flot/jquery.flot.time.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/flot/jquery.flot.growraf.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/daterangepicker/moment.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/daterangepicker/daterangepicker.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/blockui/jquery.blockUI.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/fullcalendar/fullcalendar.min.js"></script>
		 <!-- Noty -->
		 <script type="text/javascript" src="../kconfig/plugins/noty/jquery.noty.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/noty/layouts/top.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/noty/themes/default.js"></script>
		 <!-- Forms -->
		 <script type="text/javascript" src="../kconfig/plugins/uniform/jquery.uniform.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/select2/select2.min.js"></script>
		 <!-- App -->
		 <script type="text/javascript" src="../kconfig/assets/js/app.js"></script>
		 <script type="text/javascript" src="../kconfig/assets/js/plugins.js"></script>
		 <script type="text/javascript" src="../kconfig/assets/js/plugins.form-components.js"></script>
		 <!-- DataTables -->
		 <script type="text/javascript" src="../kconfig/plugins/datatables/jquery.dataTables.min.js"></script>
		 <script type="text/javascript" src="../kconfig/plugins/datatables/tabletools/TableTools.min.js"></script> <!-- optional -->
		 <script type="text/javascript" src="../kconfig/plugins/datatables/colvis/ColVis.min.js"></script> <!-- optional -->
		 <script type="text/javascript" src="../kconfig/plugins/datatables/columnfilter/jquery.dataTables.columnFilter.js"></script> <!-- optional -->
		 <script type="text/javascript" src="../kconfig/plugins/datatables/DT_bootstrap.js"></script> 			
		 <!-- Bootbox -->
		 <script type="text/javascript" src="../kconfig/plugins/bootbox/bootbox.min.js"></script>
		 <!-- Nestable List -->
		 <script type="text/javascript" src="../kconfig/plugins/nestable/jquery.nestable.min.js"></script>';
 }
 // jquery
 function _Theme_jquery(){	
   echo '<script>
		 $(document).ready(function(){
		   "use strict";
			App.init(); // Init layout and core plugins
			Plugins.init(); // Init all plugins
			FormComponents.init(); // Init all form-specific plugins
		  });
		 </script>';
   echo '<!-- Demo JS -->
		 <script type="text/javascript" src="../kconfig/assets/js/custom.js"></script>
		 <!-- <script type="text/javascript" src="../kconfig/assets/js/demo/ui_nestable_list.js"></script>-->
		 <script type="text/javascript" src="../kconfig/assets/js/demo/ui_general.js"></script>';
   echo '<!-- alerta JS -->	
		 <script type="text/javascript" src="../kconfig/lib/alertify.js"></script>
		 <link rel="stylesheet" href="../kconfig/themes/alertify.core.css" />
		 <link rel="stylesheet" href="../kconfig/themes/alertify.default.css" />
		 <script>
		 function changeAction(tipo,action,mensaje){
			if (tipo =="confirmar"){			 
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				document.location.href = action; 
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }
		  </script>
		  <script language="JavaScript"> 
			function confirmacion(){ 
			 if (confirm("¿Estas seguro de enviar este formulario?")){ 
   			    $("#formulario").submit();														 
  			   }	
			  }	 
 		   </script>';
		}		
// RETORNA EL NOMBRE DEL ARCHIVO FORMULARIO ACTIVO
 function _formulario($tipo){				
   $nombre_archivo = $_SERVER['SCRIPT_NAME'];
   //verificamos si en la ruta nos han indicado el directorio en el que se encuentra
   if ( strpos($nombre_archivo, '/') !== FALSE )
	//de ser asi, lo eliminamos, y solamente nos quedamos con el nombre sin su extension
	$nombre_archivo = preg_replace('/\.php$/', '' ,array_pop(explode('/', $nombre_archivo)));
	// 0 = el mismo archivo
	// 1 = archivo con parametro de añadir
	// 2 = archivo con parametro de acciones
 	// $_SERVER["PHP_SELF"];
	if ($tipo==-1)
	 return substr(trim($nombre_archivo),0,strlen(trim($nombre_archivo)) - 2);			
	if ($tipo==0)
	 return $nombre_archivo;	
 }	
// titulo modal header
 function _modal_title($titulo) {	
   //<input type="button" value="Reload Page" onClick="window.location.reload()">
   //<button class="btn btn-xs"><i class="icon-cog"></i></button>
   echo '<div class="modal-header">';
   echo '<button type="button" class="close" data-dismiss="modal" onClick="window.location.reload()" title="Refrescar informacion">
						 <i class="icon-cog"></i></button>';    
   echo '<h4 class="modal-title">'.$titulo.'</h4>';    
   echo '</div>';    
   return true;
 }
// RETORNA EL NOMBRE DEL modulo asignado
 function _enlace($vinculo){				
   echo '<SCRIPT LANGUAGE="javascript">location.href = "'.$vinculo.'";</SCRIPT>';
   return true;
 }
// SUBTITULO PARA LA OPCION DE LOS FORMULARIOS
 function kaipi_titulo_formulario($cadena){			 	
   echo '<td colspan="4" align="left" valign="middle" bgcolor="#FFFFFF"><b>'.$cadena.'</b></td>';
   return true;
 }		
// Tomar una clave aleatoria, cifrarla en base64 y mover los caracteres 13 posiciones (solo letras)
function _codifica($clave){
  //$clave = generar_clave();
  //$clave = str_rot13(base64_encode($clave));
  $clave = (base64_encode($clave));
  return $clave;
}	
public function _refd($clave){
  //$clave = generar_clave();
  //$clave = str_rot13(base64_encode($clave));
  $clave = trim($clave);
  $clave = base64_decode($clave);
  $clave = substr($clave,2,50);
  return trim($clave);
}
public function _refc($clave){
  //$clave = generar_clave();
  //$clave = str_rot13(base64_encode($clave));
  $clave1 = '11'.trim($clave);
  $clave = base64_encode($clave1);
   return trim($clave);
}
// Evitamos la inyeccion SQL
 function clave_inyeccion() {
  // Modificamos las variables pasadas por URL
  return 'cmkDAK4qoP5BGg1wAjfeM0pA2';
}			
//enlace a ventanas pop con variable referencial y codigo id
 function kaipi_enlace_pop($vinculo,$variable,$largo,$ancho){				
   $cadena = 'javascript:open_pop('."'".$vinculo."','".$variable."',".$largo.','.$ancho.')';
   return $cadena;
 }
//enlace a ventanas pop con variable referencial y codigo id
 function kaipi_enlace_spop($vinculo,$variable,$largo,$ancho){				
   $cadena = 'javascript:open_spop('."'".$vinculo."','".$variable."',".$largo.','.$ancho.')';
   return $cadena;
 }
/*    enlace a ventanas pop con variable referencial y codigo id-----*/
function kaipi_enlace_opop($vinculo,$variable,$largo,$ancho,$var1){				
	$cadena = 'javascript:openpop('."'".$vinculo."','".$variable."',".$largo.','.$ancho.','."'".trim($var1)."'".')';
	return $cadena;
}		
// Evitamos la inyeccion SQL
function id_inyeccion($id) {
  $id_codigo = intval(substr($id,25,5),0);
  return $id_codigo;
}	
/*   cierra ventana pop ----------------------------------------------------*/
function kaipi_cierre_pop(){				
 /* $ejecuta = '<script type="text/javascript">opener.location.reload();</script>';
  echo  $ejecuta;*/
  echo '<script type="text/javascript">window.close();</script>';	
  return true;
}	

 



/*   cierra ventana pop ----------------------------------------------------*/
function kaipi_cierre(){				
  echo '<script type="text/javascript">window.close();</script>';	
  return true;
}	
// VALIDAR CLAVE DE ACCESO 
function kaipi_validar_clave($clave){
	   if(strlen($clave) < 6){
		  $error_clave = "La clave debe tener al menos 6 caracteres";
		  return $error_clave;
	   }
	   if(strlen($clave) > 16){
		  $error_clave = "La clave no puede tener más de 16 caracteres";
		  return $error_clave;
	   }
	   if (!preg_match('`[a-z]`',$clave)){
		  $error_clave = "La clave debe tener al menos una letra minúscula";
		  return $error_clave;
	   }
	   if (!preg_match('`[A-Z]`',$clave)){
		  $error_clave = "La clave debe tener al menos una letra mayúscula";
		  return $error_clave;
	   }
	   if (!preg_match('`[0-9]`',$clave)){
		  $error_clave = "La clave debe tener al menos un caracter numérico";
		  return $error_clave;
	   }
	   $error_clave = "ok";
	   return $error_clave;
	}	 
	function _mes($mes){
		if ($mes == 1)
			return 'Enero';
		if ($mes == 2)
			return 'Febrero';
		if ($mes == 3)
			return 'Marzo';
		if ($mes == 4)
			return 'Abril';
		if ($mes == 5)
			return 'Mayo';
		if ($mes == 6)
			return 'Junio';
		if ($mes == 7)
			return 'Julio';
		if ($mes == 8)
			return 'Agosto';
		if ($mes == 9)
			return 'Septiembre';
		if ($mes == 10)
			return 'Octubre';
		if ($mes == 11)
			return 'Noviembre';
		if ($mes == 12)
			return 'Diciembre';
   }	
 	function _alerta($mensaje){
		echo "<script>window.alert('".$mensaje."')</script>";
   }  	
 
   						
}

?>