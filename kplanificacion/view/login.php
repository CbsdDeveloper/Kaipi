<?php session_start( );  ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

	<title>Panel de Gestión Empresarial</title>
	<!--=== CSS ===-->
	
  <link rel="shortcut icon" href="../../app/kaipi-favicon.png">
  <link rel="stylesheet" href="../../app/fontawesome/font-awesome.min.css"/>
  <link href="../../app/dist/css/bootstrap.css" rel="stylesheet">
  <link href="../../app/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="../../app/js/jquery-1.10.2.min.js"></script>
  <link href="../../app/css/ionicons.min.css" rel="stylesheet" type="text/css" />
     <!-- <script src="../app/dist/js/bootstrap.min.js"></script>  -->
  <link rel="stylesheet" href="../../app/css/jquery-ui.min.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="../js/default/easyui.css">
  <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
  <!-- DataTables -->
  <script type="text/javascript" src="../../app/plugins/datatables/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../../app/plugins/datatables/DT_bootstrap.js"></script>
  <script type="text/javascript" src="../../app/plugins/datatables/bootstrap-table.js"></script>
  <!-- bostrap -->
  <link rel="stylesheet" href="../../app/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../app/plugins/datatables/jquery.dataTables.css" />
  <script type="text/javascript" src="../../app/dist/js/bootstrap.js"></script>
  <script type="text/javascript" src="../../app/plugins/datatables/jquery.dataTables.js" ></script>
   	   			
  <script type="text/javascript" src="../js/kaipi.js"></script> 
 	
  <script type="text/javascript" src="../../kconfig/lib/alertify.js"></script>
  <link rel="stylesheet" href="../../kconfig/themes/alertify.core.css" />
  <link rel="stylesheet" href="../../kconfig/themes/alertify.default.css" />
  <!-- Login -->
  <link href="../../app/assets/css/login.css" rel="stylesheet" type="text/css" />
   
  <!-- inicio de pantalla para ejecuciÃ³n -->
 <link href="../../app/assets/css/login.css" rel="stylesheet" type="text/css" />
 <!-- App -->
 <script type="text/javascript" src="../../app/assets/js/login.js"></script>
 <script>
	$(document).ready(function(){
		"use strict";
 		Login.init(); // Init login JavaScript
	});
</script>

 <style type="text/css">
		body {
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
		}
 </style>
	
 </head>
<body class="login" background="../../kimages/erp.jpg">
    <div class="logo">
       <img src="../../kimages/1398967526_kservices.png" alt="logo" />
    <span style="color: #FFFFFF"><strong>KAI</strong>pi Plataforma de Gestión Empresarial</span> </div>
    <div class="box">
     <div class="content">
        <form action='../controller/Controller-login' method="post" enctype="application/x-www-form-urlencoded" class="form-vertical login-form" id="form" autocomplete="on" accept-charset="UTF-8">
          <h3 class="form-title">Ingresa tu cuenta</h3>
            <div class="alert fade in alert-danger" style="display: none;">
              <i class="icon-remove close" data-dismiss="alert"></i>
	             Introduzca cualquier nombre de usuario y contraseña.
            </div>
            <!-- Form username -->
            <div class="form-group">
              <div class="input-icon">
                <i class="icon-user"></i>
                  <input name="username" type="text" autofocus required="required" class="form-control" id ="username" placeholder="Usuario" autocomplete="off" data-rule-required="true" data-msg-required="Por favor, ingrese su nombre de usuario" />
              </div>
            </div>
             <!-- Form password -->
            <div class="form-group">
              <div class="input-icon">
                <i class="icon-lock"></i>
                <input name="password" type="password" required="required" class="form-control" placeholder="Password" data-rule-required="true" data-msg-required="Por favor, ingrese su contraseña." />
              </div>
            </div>
            <!-- Form codigos -->
           <!--      <div class="form-group">
                <div class="input-icon">
                  <i class="icon-time"></i>
                  <input name="codigos" type="text" required="required" class="form-control" id ="codigos" placeholder="codigo seguridad" autocomplete="off" data-rule-required="true" data-msg-required="Por favor, ingrese su nombre de usuario" /> 
                </div>
            </div>  
              
        <div class="form-group"> 
               <div class="input-icon"><img src="../../kconfig/captcha/captcha.php" align="absmiddle"/>
               </div>
            </div>
         -->   
            <input name="s" type="hidden" id="s" value="register">
            <!-- Form Actions -->
            <div class="form-group">
               <button type="submit" class="submit btn btn-primary pull-right">Ingresar <i class="icon-angle-right"></i></button>
            </div>
      </form>
   </div> 
   <!-- /.content -->
   <div class="inner-box">
     <div class="content">
	 <!-- Close Button -->
	  <i class="icon-remove close hide-default"></i>
        
	    ¿<a href="reset">Olvidó su clave</a>? 
      </div> 
      <!-- /.content -->
   </div>
   </div>
   <div class="single-sign-on">
   		<p> <br>
	  <small>Copyright 2017 kaipi. All Rights Reserved. <a href="#" target="_blank">Privacy Policy</a> 
		  Quito - Ecuador  |  Jasapas</small></p>
	  
   </div>
   <div class="footer"></div>
</body>
</html>