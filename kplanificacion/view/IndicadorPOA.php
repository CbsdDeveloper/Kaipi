<?php
 	session_start();
	require '../controller/Controller-FiltroAgendaMain.php';  
     $gestion   = 	new componente;
 

?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
      <?php  require('HeadPanel.php')  ?> 
  	 
	<link href="../../kplanificacion/view/articula.css" rel="stylesheet">
   
  <style type="text/css">
 	
		  
		.tree {
			min-height:20px;
			padding:1px;
			margin-bottom:10px;
			background-color:#fbfbfb;
			border:1px solid #D5D5D5;
		}
		.tree li {
			list-style-type:none;
			margin:0;
			padding:10px 5px 0 5px;
			position:relative
		}
		.tree li::before, .tree li::after {
			content:'';
			left:-20px;
			position:absolute;
			right:auto
		}
		.tree li::before {
			border-left:1px solid #D5D5D5;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #D5D5D5;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			display:inline-block;
			padding:3px 8px;
			text-decoration:none
		}
		.tree li.parent_li>span {
			cursor:pointer
		}
		.tree>ul>li::before, .tree>ul>li::after {
			border:0
		}
		.tree li:last-child::before {
			height:30px
		}
		.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
			  color:#000
		}
  		.tree li ul > li ul > li {
				display: none;
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
	
	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	
}
	 
 
.actividad {
    border-collapse: collapse;
    width: 80%;
	font-size: 12px;
   }
 
 .ex1 {
  width: 1950px;
  overflow-y: hidden;
  overflow-x: auto;
  }
	  
	 
 
	
.table1 {
  border-collapse: collapse;
}
	
 .filasupe {
 
 	border-bottom: 1px solid #ddd;
	border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
	border-top: 1px solid #ddd;
	padding-bottom: 4px; 
}
	
.derecha {
 
     border-right: 1px solid #ddd;
	  
 }
	
  #mdialTamanio{
      width: 70% !important;
    }

	
 #mdialTamanio1{
      width: 80% !important;
    }

	
  .bigdrop{
		
        width: 750px !important;

     }
		  
  .bigdrop1{
		
        width: 750px !important;

     }
		  
	  
	  resumen {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
    text-align: center;
		  }
	.resumen_td {
	padding-top: 6px;
    text-align: center;
	font-size: 10px;	
	color: #FFFFFF
		  }
	  
	.resumen_tt {
    padding-bottom: 10px;
	padding-top: 1px;
    text-align: center;
	font-size: 22px;
	font-weight: 700;
	color: #FFFFFF
		  }  
</style>	
     
 <script language="javascript" src="../js/IndicadorPOA.js?n=1"></script>
    
    
</head>
	
<body>
 
   
	<div class="col-md-12" role="banner">
 	   <div id="MHeader"></div>
 	</div> 
 	
	<div id="mySidenav" class="sidenav">
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
   </div>
	
	
       <!-- Content Here -->
	
    <div class="col-md-12"> 
 							  
       <!-- Content Here -->
		
 		  <div class="panel panel-default">
				<div class="panel-heading">Unidad de Gestión</div>
					<div class="panel-body">
						 <div class="widget box">
                              <div class="widget-content">
                                     <?php
                                      $gestion->FiltroFormulario( ); 
								    ?>
                              	    <div class="col-md-2" style="padding-top: 8px;">
														<button type="button"   class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
														 
									</div>
                               </div>
                           </div> <!-- /.col-md-6 -->
 					</div>
			 </div>
		
		 <div class="col-md-12" style="padding-bottom: 10px"> 
			 
 			 <div class="col-md-2"> <img src="../../kimages/iconfinder_bullet_white_35789.png" class="media-object"> NO INICIADO</div>
			 
			 <div class="col-md-2"> <img src="../../kimages/if_bullet_red_35785.png" class="media-object"> NO EJECUTADO </div>
			 
			 <div class="col-md-2"> <img src="../../kimages/if_bullet_yellow_35791.png" class="media-object"> EN PROCESO </div>
			 
			 <div class="col-md-2"> <img src="../../kimages/if_bullet_green_35779.png" class="media-object"> EJECUTADO </div>
 		 </div>
		
		
	  	  <div class="panel-group">
			<div class="panel panel-default">
			  <div class="panel-heading">SEGUIMIENTO DE INDICADORES - OBJETIVOS </div>
			  <div class="panel-body">
				    
				 
				  
				  <div class="col-md-12"> 
 							
							 <div id="ViewPOAMatrizOO" style="overflow-x: auto;"  > </div>
 		
					 </div>	
				  
				  
				   <div class="col-md-12"> 
				 			  <div id="UnidadArticula">  </div>
				   </div>
				    
				</div>
			</div>
		</div> 	
			
 
		
		 
 		 
</div>
 
  	<!-- Page Footer-->
      <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>Kaipi &copy; 2017-2019</p>
                </div>
                <div class="col-sm-6 text-right">
                  <p>Design by <a href="#">JASAPAS</a></p>
                  <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
              </div>
            </div>
 </footer>
 
    
 
</body>
</html> 