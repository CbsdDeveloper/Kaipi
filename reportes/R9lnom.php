<?php 
session_start( );  
$_SESSION['us']		= $_GET['us'];
'' 	= $_GET['db'];
$_SESSION['ac']		= $_GET['ac'];
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 
$id 	= $_GET['i'];
$op 	= $_GET['r'];

   
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Gestion Institucional</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Header -->
			<header id="header">
				<a class="logo" href="#">PLATAFORMA DE GESTION LOCAL</a>
				<nav>
					<a href="#menu">Menu</a>
				</nav>
			</header>
		<!-- Heading -->
			<div id="heading" >
				<h1>Bienvenidos</h1>
			</div>

		<!-- Main -->
		 <section id="main" class="wrapper">
				<div class="inner">
					<div class="content">

					<!-- Elements -->
						<div class="row">
							 
							<div class="col-9 col-12-medium">
 							  <!-- Form -->
							  	    <h4><?php $gestion->_empresa( $_GET['rd'] ) ; ?></h4>
									<h3>Si recibiste esta comunicación con tu informacion presiona confirmar...</h3>
					    	  		<h3><?php $gestion->_nombre( $id  ) ; ?></h3>
								
									<form action="R9lnom" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
										<div class="row gtr-uniform">
 											<!-- Break -->
											<div class="col-12">
												
												<ul class="actions">
													<li><input type="submit" value="Confirmación" class="primary" /></li>
													 
												</ul>
											</div>
										</div>
										<input name="val" type="hidden" id="val" value="S">
										<input name="i" type="hidden" id="i" value="<?php $_GET['i']; ?>">
										<input name="r" type="hidden" id="r" value="<?php $_GET['r']; ?>">
										<?php 
										if (isset($_POST["val"]))	{
        
										   if ( $_POST["val"] == 'S'){
												 $id 	    = $_POST["i"];
												 $res		= $_POST["r"];

												$dato = $gestion->_actualiza_rol( $id,$res ) ;

												if ( $dato == 1){
													
													echo '<h4><b>INFORMACION ENVIADA CON EXITO!!! ...</b></h4>'; 
												}	
										   }       
										}     
									?>	
									</form>

 
								<!-- Image -->
			 
							</div>
						</div>
					</div>
				</div>
			</section>

		<!-- Footer -->
			 

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
