<?php
/* establecer el limitador de caché a 'private' */

session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

/* establecer la caducidad de la caché a 30 minutos */
session_cache_expire(30);
$cache_expire = session_cache_expire();

/* iniciar la sesión */

session_start();
 
 
 

	if (empty($_SESSION['usuario']))  {
		header('Location: ../../kadmin/');
    } 
?>
<link rel="stylesheet" href="../../app/fontawesome/font-awesome.min.css"/>
        
    <link href="../../app/dist/css/bootstrap.css" rel="stylesheet">
   
    <link href="../../app/dist/css/bootstrap-theme.min.css" rel="stylesheet">
    
    <!-- Ionicons -->
	<link href="../../app/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="../../app/jquery-ui.min.css" type="text/css" />
      
    <link rel="stylesheet" type="text/css" href="../js/default/easyui.css">
   
   <link rel="stylesheet" href="../../app/dist/css/bootstrap.min.css" />
    
   <link rel="stylesheet" href="../../app/dist/css/dataTables.bootstrap.min.css" />
                          
   <link rel="stylesheet" href="../../app/themes/alertify.core.css" />
 	
   <link rel="stylesheet" href="../../app/themes/alertify.default.css" />    
      
   
   <script type="text/javascript" src="../../app/3.2.1/jquery-1.10.2.min.js"></script>
   
   <script src="../../app/dist/js/bootstrap.min.js"></script>  
     
   <script src="../../app/3.2.1/jquery.min.js"></script>  

     	
   <script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
      
   <script type="text/javascript" src="../../app/3.2.1/jquery.dataTables.min.js"></script>
     
   <script type="text/javascript" src="../../app/3.2.1/dataTables.bootstrap.min.js"></script>
   
   <script type="text/javascript" src="../js/kaipi.js"></script> 
 	
   <script type="text/javascript" src="../../app/lib/alertify.js"></script>

   <script src="../js/bootstrap3-typeahead.min.js"></script>  
    
 
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
	 
 
	 
	 	#mdialTamanio{
  					width: 75% !important;
		}
	 
	    #mdialTamanio4{
  					width: 65% !important;
		}
	 
	 	#mdialTamanio_aux_d{
  					width: 80% !important;
		}
	 
	 
	 #mdialTamanio_aux1{
  					width: 70% !important;
		}
	 
	 
	 
	 
	 
	 	 .form-control_asiento {  
		  display: block;
		  width: 85%;
		  height: 28px;
		  padding: 3px 3px;
		  font-size: 12px;
		  line-height: 1.428571429;
		  color: #555555;
		  vertical-align:baseline;
		  text-align: right;
		  background-color: #ffffff;
		  background-image: none;
		  border: 1px solid #cccccc;
		  border-radius: 4px;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
				  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
				  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
   }
 
   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 4px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
	 
	 
	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#c3e1fb;
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
    
   
  