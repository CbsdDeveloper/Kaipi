<?php
	session_start( );

    if (empty($_SESSION['usuario']))  {
	
	    header('Location: ../../kadmin/view/login');
 	
	}
  $_SESSION['directorio_crm'] = '../kimages/';

  
?>	
       
   <link rel="shortcut icon" href="../../app/kaipi-favicon.png">
   
    <link rel="stylesheet" href="../../app/fontawesome/font-awesome.min.css"/>
        
    <link href="../../app/dist/css/bootstrap.css" rel="stylesheet">
   
    <link href="../../app/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    
    <!-- Ionicons -->
	<link href="../../app/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="../../app/css/jquery-ui.min.css" type="text/css" />
      
    <link rel="stylesheet" type="text/css" href="../js/default/easyui.css">
   
   <link rel="stylesheet" href="../../app/dist/css/bootstrap.min.css" />
    
   <link rel="stylesheet" href="../../app/dist/css/dataTables.bootstrap.min.css" />
                          
   <link rel="stylesheet" href="../../app/themes/alertify.core.css" />
 	
   <link rel="stylesheet" href="../../app/themes/alertify.default.css" />    
      
   
   <script type="text/javascript" src="../../app/js/jquery-1.10.2.min.js"></script>
   
   <script src="../../app/dist/js/bootstrap.min.js"></script>  
     
   <script src="../../app/js/jquery.min.js"></script>  
     	
   <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
      
   <script type="text/javascript" src="../../app/js/jquery.dataTables.min.js"></script>
     
   <script type="text/javascript" src="../../app/js/dataTables.bootstrap.min.js"></script>
   
   <script type="text/javascript" src="../js/kaipi.js"></script> 
 	
   <script type="text/javascript" src="../../app/lib/alertify.js"></script>

   <script src="../../app/js/bootstrap3-typeahead.min.js"></script>  
    
 
 

 <style>
	 


.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
  /*  background-color: #111;*/
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
	font-size: 11px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 11px;
    color:#322E2E;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover, .offcanvas a:focus{
    color:#BFBFBF;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 11px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 11px;}

	 
	 }
	 
body {
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
	    	color:#000000;
}
	 
	 #mdialTamanio1{
        width: 80% !important;
       }
	  #mdialTamanioCliente{
        width: 65% !important;
       }
		
		#mdialTamanioAgenda{
        width: 35% !important;
       }
		
		#mdialProducto{
        width: 75% !important;
       }
		
	 #mdialEmail{
        width: 75% !important;
       }
	 
	  #mdialTamanio{
		  width: 95% !important;
		}
	    span.blue {
		  background: #5178D0;
		  border-radius: 0.8em;
		  -moz-border-radius: 0.8em;
		  -webkit-border-radius: 0.8em;
		  color: #ffffff;
		  display: inline-block;
		  font-weight: bold;
		  line-height: 1.6em;
		  text-align: center;
		  width: 1.6em; 
		}
		
		
	 .bloque1 {
	display: inline-block;
		width: 100%;
		font-weight: 600;
		color: #ffffff;
		text-align: justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#e00000  !important;
		padding: 10px;
		line-height: 1;
 		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}
		
	
	 .bloque0 {
		display: inline-block;
		 width: 100%;
		font-weight: 600;
		color: #ffffff;
		text-align: justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#8f5fe8   !important;
		padding: 10px;
		line-height: 1;
 		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	 .bloque2 {
		display: inline-block;
		width: 100%;
		font-weight: 600;
		color: #ffffff;
		text-align: justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#b4991f  !important;
		padding: 10px;
		line-height: 1;
 		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	 .bloque3 {
		display: inline-block;
		font-weight: 600;
		width: 100%;
		color: #ffffff;
		text-align: justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#00d25b  !important;
		padding: 10px;
		line-height: 1;
 		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}
		
	 .bloque4 {
		display: inline-block;
		width: 100%;
		font-weight: 600;
		color: #ffffff;
		text-align: justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#54638a !important;
		padding: 10px;
		line-height: 1;
 		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	 .bloque5 {
		display: inline-block;
		width: 100%;
		font-weight: 600;
		color: #ffffff;
		text-align: justify;
		vertical-align: middle;
		cursor: pointer;
		user-select: none;
		background-color:#8397cc   !important;
		padding: 10px;
		line-height: 1;
 		-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		-moz-box-shadow:    1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		box-shadow:         1px 1px 5px 0px rgba(50, 50, 50, 0.32);
	}	
		
	 .sidenav_proceso {
		  height: 100%;
		  width: 0;
		  position: fixed;
		  z-index: 1;
		  top: 0;
		  left: 0;
		  background-color:#FFFFFF;
		  overflow-x: hidden;
		  transition: 0.5s;
		  padding-top: 10px;
		}

	 .sidenav_proceso a {
		  padding: 8px 8px 8px 32px;
		  text-decoration: none;
		  font-size: 12px;
		  color: #818181;
		  display: block;
		  transition: 0.3s;
		}

	  .sidenav_proceso a:hover {
  color:#0A0A0A;
}

	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#93ADFF;
	  }
	 .di {
  			 background-color:#F5C0C1;
	  }
	 
</style>

    <link href="../../app/css/elegant-icons-style.css" rel="stylesheet" />
	<link href="../../app/css/font-awesome.min.css" rel="stylesheet" />    
    <link href="../../app/css/widgets.css" rel="stylesheet">
	  
 
    <link href="../../app/css/style.css" rel="stylesheet">
    <link href="../../app/css/style-responsive.css" rel="stylesheet" />
    
   
  