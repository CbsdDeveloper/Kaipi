<?php 
	session_start( );  
	 
	require 'SesionInicio.php';   /*Incluimos el fichero de la clase Db*/
    
	require '../model/Model-panel_miembros.php';   
	 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    
    <title>Miembros</title>
    
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../app/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="../../app/css/font-awesome.min.panel.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../../app/css//ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
     <!-- jvectormap -->
     <!-- Daterange picker -->
     <!-- Theme style -->
    <link href="../../app/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../../app/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body >
  
      
        <!-- Main content -->
        <section class="content">
 
          <div class='row'>
            
            <div class='col-md-4'>
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Miembros Equipo</h3>
                  <div class="box-tools pull-right">
                    <span class="label label-danger">Miembros</span>
                    
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php
                            miembros($bd, $obj)
                   ?> 
                     
                  </ul><!-- /.users-list -->
                </div><!-- /.box-body -->
               
              </div><!--/.box -->
            </div><!-- /.col -->
             
          </div><!-- /.row -->

          

        </section><!-- /.content -->


    <!-- jQuery 2.1.3 -->
    <script src="../../app/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../app/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
   
    <!-- AdminLTE App -->
    <script src="../../app/dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
  
  
    <!-- SlimScroll 1.3.0 
  

    <!-- AdminLTE for demo purposes -->
   </body>
</html>