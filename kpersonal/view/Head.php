<?php
 
session_start();
  
	if (empty($_SESSION['usuario']))  {
		header('Location: ../../kadmin/');
    } 
?>	
<link rel="shortcut icon" href="../../app/kaipi-favicon.png">
   
<link rel="stylesheet" href="../../app/fontawesome/font-awesome.min.css" media="all"/>
         
<link href="../../app/dist/css/bootstrap.css" rel="stylesheet" media="all">
   
<link href="../../app/dist/css/bootstrap-theme.min.css" rel="stylesheet" media="all">
    
    <!-- Ionicons -->
<link href="../../app/css/ionicons.min.css" rel="stylesheet" type="text/css" media="all" />
    
    <link rel="stylesheet" href="../../app/css/jquery-ui.min.css" type="text/css" media="all"/>
      
    <link rel="stylesheet" type="text/css" href="../js/default/easyui.css">
   
   <link rel="stylesheet" href="../../app/dist/css/bootstrap.min.css" />
    
   <link rel="stylesheet" href="../../app/dist/css/dataTables.bootstrap.min.css" media="all" />
                          
   <link rel="stylesheet" href="../../app/themes/alertify.core.css" />
 	
   <link rel="stylesheet" href="../../app/themes/alertify.default.css" />    
      
   
   <script type="text/javascript" src="../../app/js/jquery-1.10.2.min.js"></script>
   
   <script src="../../app/dist/js/bootstrap.min.js"></script>  
     
 
    <!--   <script src="../../app/js/jquery.min.js"></script>  -->

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  

     	
   <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
      
   <script type="text/javascript" src="../../app/js/jquery.dataTables.min.js"></script>
     
   <script type="text/javascript" src="../../app/js/dataTables.bootstrap.min.js"></script>
   
   <script type="text/javascript" src="../js/kaipi.js"></script> 
 	
   <script type="text/javascript" src="../../app/lib/alertify.js"></script>

   <script src="../../app/js/bootstrap3-typeahead.min.js"></script>  
    
 
 <style>
	 
 body {
			font-style: normal;
			font-weight: normal;
			font-size: 12px;
}

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
	 	 .hijo {
		  position: absolute;
		}
		.padre{
		  position:relative;
 		} 
	 
	   #mdialTamanio{
  					width: 75% !important;
		}
	 
	 
	 
	   #mdialTamanio1{
  					width: 75% !important;
		}
		#mdialTamanio2{
  					width: 85% !important;
		} 
	 
	 	#mdialTamanio3{
  					width: 55% !important;
		} 
	 
	 
	 #mdialTamanio4{
  					width: 70% !important;
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
	 
	 	.div_s {
	position: relative;
    min-height: 2px;
	padding-top: 5px;
	padding-bottom: 5px;
    padding-right: 10px;
    padding-left: 10px;
    font-style: normal;
    font-weight: normal;
    font-size: 11px;
    font-family: "Segoe UI", "Trebuchet MS", sans-serif;
	width:21%;
	float: left;
	border:solid 1px darkgoldenrod;
    box-shadow: 0px 20px 15px -15px #818181;	
margin: 3px;
	}	
</style>

    <link href="../../app/css/elegant-icons-style.css" rel="stylesheet" media="all"/>
	<link href="../../app/css/font-awesome.min.css" rel="stylesheet" media="all" />    
    <link href="../../app/css/widgets.css" rel="stylesheet" media="all">
	  
 
    <link href="../../app/css/style.css" rel="stylesheet" media="all">
    <link href="../../app/css/style-responsive.css" rel="stylesheet" media="all" />