<head>

<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<title>Plataforma de Gestión Empresarial</title>
	<!-- Bootstrap -->
	<link href="../../kconfig/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- Theme -->
	<link href="../../kconfig/assets/css/main.css" rel="stylesheet" type="text/css" />
	<link href="../../kconfig/assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="../../kconfig/assets/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="../../kconfig/assets/css/icons.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="../../kconfig/assets/css/fontawesome/font-awesome.min.css">
	<!--[if IE 7]>
		<link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

    <link href="../plugins/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../plugins/ionicons.min.css" rel="stylesheet" type="text/css" /> 

     <!-- Morris chart -->
    <link href="../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />  

<script language="javascript" src="../controller/jquery-1.3.min.js"></script> 
    
 <script language="javascript">
	$(document).ready(function() {
		$().ajaxStart(function() {
			$('#loading').show();
			$('#result').hide();
		}).ajaxStop(function() {
			$('#loading').hide();
			$('#result').fadeIn('slow');
		});
		$('#form, #fat, #fo3').submit(function() {
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				 success: function(data,data1) {
					$('#result').html(data);
				}
		})
			
			return false;
		}); 
	})  
</script>
	<!--=== JavaScript ===-->

	<script type="text/javascript" src="../../kconfig/assets/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="../plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>

	<script type="text/javascript" src="../../kconfig/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../kconfig/assets/js/libs/lodash.compat.min.js"></script>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="assets/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Smartphone Touch Events -->
	<script type="text/javascript" src="../plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="../plugins/event.swipe/jquery.event.move.js"></script>
	<script type="text/javascript" src="../plugins/event.swipe/jquery.event.swipe.js"></script>

	<!-- General -->
	<script type="text/javascript" src="../../kconfig/assets/js/libs/breakpoints.js"></script>
	<script type="text/javascript" src="../plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
	<script type="text/javascript" src="../plugins/cookie/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="../plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="../plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>

	<!-- Page specific plugins -->
	<!-- Charts -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../plugins/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="../plugins/flot/jquery.flot.min.js"></script>
	<script type="text/javascript" src="../plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script type="text/javascript" src="../plugins/flot/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="../plugins/flot/jquery.flot.time.min.js"></script>
	<script type="text/javascript" src="../plugins/flot/jquery.flot.growraf.min.js"></script>
	<script type="text/javascript" src="../plugins/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

	<script type="text/javascript" src="../plugins/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="../plugins/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="../plugins/blockui/jquery.blockUI.min.js"></script>

	<script type="text/javascript" src="../plugins/fullcalendar/fullcalendar.min.js"></script>

	<!-- Noty -->
	<script type="text/javascript" src="../plugins/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="../plugins/noty/layouts/top.js"></script>
	<script type="text/javascript" src="../plugins/noty/themes/default.js"></script>

	<!-- Forms -->
	<script type="text/javascript" src="../plugins/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="../plugins/select2/select2.min.js"></script>

	<!-- DataTables -->
	<script type="text/javascript" src="../plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../plugins/datatables/tabletools/TableTools.min.js"></script> <!-- optional -->
	<script type="text/javascript" src="../plugins/datatables/colvis/ColVis.min.js"></script> <!-- optional -->
	<script type="text/javascript" src="../plugins/datatables/columnfilter/jquery.dataTables.columnFilter.js"></script> <!-- optional -->
	<script type="text/javascript" src="../plugins/datatables/DT_bootstrap.js"></script>

	<!-- App -->
 

	<!-- App -->
	<script type="text/javascript" src="../../kconfig/assets/js/app.js"></script>
	<script type="text/javascript" src="../../kconfig/assets/js/plugins.js"></script>
	<script type="text/javascript" src="../../kconfig/assets/js/plugins.form-components.js"></script>

 
	<script>
		 
		$(document).ready(function(){
			"use strict";
	
			App.init(); // Init layout and core plugins
			Plugins.init(); // Init all plugins
			FormComponents.init(); // Init all form-specific plugins
		});
	</script>

    <!-- alerta JS -->	
	<script type="text/javascript" src="../../kconfig/lib/alertify.js"></script>
    <link rel="stylesheet" href="../../kconfig/themes/alertify.core.css" />
	<link rel="stylesheet" href="../../kconfig/themes/alertify.default.css" />
    
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

 <!-----------------------------------------------------------------
      FUNCIONES DE APOYO JAVASCRIPT  
 ------------------------------------------------------------------->	
 <script type='text/javascript'>
 
        function http(){
         if(typeof window.XMLHttpRequest!='undefined'){
		   return new XMLHttpRequest();    
		 }else{
		 try{
		  return new ActiveXObject('Microsoft.XMLHTTP');
		}catch(e){
		  alert('Su navegador no soporta AJAX');
		  return false;
		 }    
	     }    
      }
 /*-----------------------------------------------------------------
      FUNCIONES DE APOYO AJAX  
 -------------------------------------------------------------------*/
     function request(url,callback,params){
      var H=new http();
      if(!H)return;
    	  H.open('post',url+'?'+Math.random(),true);
    	  H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    	  H.onreadystatechange=function(){
    	  if(H.readyState==4){
    		callback(H.responseText);
    		H.onreadystatechange=function(){}
    		H.abort();
    		H=null;
    		}
    	}
    	var p='';
    	for(var i in params){
    	  p+='&'+i+'='+escape(params[i]);    
    	}
    	 H.send(p);
      }
  /*-----------------------------------------------------------------
      FUNCIONES DE APOYO AJAX  ASIGNACION DE OPCIONES
 -------------------------------------------------------------------*/ 
 
 /*-----------------------------------------------------------------
      FUNCIONES DE APOYO PERFIL DE USUARIOS  
 -------------------------------------------------------------------*/
  
  
function ir(){ 
  window.parent.scrollTo (0,0);
}	

</script>      
	<!-- Demo JS -->
<script type="text/javascript" src="../../kconfig/assets/js/custom.js"></script>

<script type="text/javascript" src="../../kconfig/kaipi.js"></script>
  
 
    
      
</head>
 