<?php 
	session_start( );  
	 
	require 'SesionInicio.php';   /*Incluimos el fichero de la clase Db*/
    
	require '../model/Model-panel_miembros.php';   
	
 	
	 $mensaje = @$_POST["message"];
    
   	 if (!empty($mensaje)){
		 
		      $sesion 	 = $_SESSION['login'];
 	 		  $hoy 		 = $bd->hoy();      
	 	
   	  
		  $mensaje = (trim($mensaje));
			   
		  $sql = "INSERT INTO web_chat_directo( sesion, modulo,mensaje ,estado, fecha) values (".
					  $bd->sqlvalue_inyeccion($sesion, true).",".
					   $bd->sqlvalue_inyeccion('panel', true).",".
					   $bd->sqlvalue_inyeccion($mensaje, true).",".
					  $bd->sqlvalue_inyeccion('E', true).",".$hoy.")";   
					  
		  $bd->ejecutar($sql);
	  
	  }
	 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
     
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../app/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
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
  <body>
         <!-- <div class="wrapper">
 Content Wrapper. Contains page content 
      <div class="content-wrapper">-->
        <!-- Main content
        
         
           -->
       
  
            
       
              <!-- DIRECT CHAT -->
              
              
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                
                  <div class="box-tools pull-right">
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                   <div  id="result" class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    <?php chat_msg($bd, $obj ); ?>
                    <!-- Message to the right -->    
                 </div><!--/.direct-chat-messages-->
 				<!-- Contacts are loaded here -->
                 </div><!-- /.box-body -->
                 
                 <form action="View-panelchat.php" method="post" name="fat" id="fat" accept-charset="UTF-8" >
                 <div class="box-footer">
                   <div class="input-group">
                     <input type="text" name="message" placeholder="Mensaje ..." class="form-control"/>
                      <span class="input-group-btn">
                      <button id="guardai" name="guardai" class="btn btn-warning btn-flat" >Enviar</button>
                      </span>
                    </div>
                 </div><!-- /.box-footer-->
                  </form> 
              </div><!--/.direct-chat -->
 
          
          
             
      

          <!--

      
      </div> /.content-wrapper -->

      

    <!-- </div>-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="../../app/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../app/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
   
    <!-- AdminLTE App -->
    <script src="../../app/dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    
    <!-- SlimScroll 1.3.0
    <script src="app/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script> -->
    <!-- ChartJS 1.0.1 -->
   
 

    <!-- AdminLTE for demo purposes -->
   
  </body>
</html>