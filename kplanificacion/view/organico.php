<?php
 	session_start();

	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

		$obj   = 	new objects; 
		$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('HeadPanel.php')  ?> 
    
 
   
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
	
	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}
	
}
	
	/*Now the CSS*/
* {margin: 0; padding: 0;}

.tree ul {
    padding-top: 20px; position: relative;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
}
.tree li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
}

.tree li a{
	border: 1px solid #ccc;
	padding: 5px 10px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 11px;
	display: inline-block;
	
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
	border-color:  #94a0b4;
}

/*Thats all. I hope you enjoyed it.
Thanks :)*/
</style>	
    
</head>
<body>

<div>
	<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
 	  <nav class="navbar navbar-inverse navbar-fixed-top">
 				<div class="container-fluid">
 					<div class="navbar-header">
					  		<a class="navbar-brand" href="#">KAipi</a>
					  	 
					</div>
					
					<ul class="nav navbar-nav">
							  <li class="active"><a href="../../kadmin/view/View-panel">INICIO</a></li>
							  <li><a href="#">ORGANICO FUNCIONAL</a></li>
							  <li><a href="#"> EMPRESA: <?php  echo $_SESSION['ruc_registro'];  ?></a></li>
							  <li><a href="#"><?php echo date("F j, Y, g:i a") ?> </a></li>
							 
							 
					</ul>
					  <ul class="nav navbar-nav navbar-right">
						<li><a href="#">Login <?php echo strtoupper($_SESSION['login']); ?> </a></li>
						 
				    </ul>
			  </div>
		</nav>
 	</header> 
    
    <div class="col-md-12" style="padding-top: 60px"> 
      
       <!-- Content Here -->
				 <div class="col-md-12"> 
						<div class="tree">
						<ul>
							<li>
								<a href="#">ORGANICO FUNCIONAL DE LA INSTITUCIÓN</a>
								<ul>
								 <?php
								 $sql_nivel1 = 'SELECT IDUNIDAD, IDUNIDADPADRE, NOMBRE, NIVEL
										 FROM SIUNIDAD
										 WHERE NIVEL = 2 
										 ORDER BY IDUNIDAD, IDUNIDADPADRE';

										$stmt_nivel1 = $bd->ejecutar($sql_nivel1);

										echo '<li>';
										while ($x=$bd->obtener_fila($stmt_nivel1)){

											$nombre 				= trim($x[2]);
											$id_unidad  			= trim($x[0]);

											echo '<a href="#">'.$nombre.'</a>';

											$mas_niveles = _niveles($id_unidad,  $bd	, $obj  );

											$nivel = 2;

											if ( $mas_niveles >= 1){
												Subnivel($id_unidad,$bd,$obj,$nivel);
											}


										}
										echo '</li>';
								?>		
								</ul>
							</li>
						</ul>
					</div>
				</div>

			  <div class="col-md-4"> 
			   <div class="panel panel-default">
			   <div class="panel-heading">Panel with panel-default class</div>
			   <div class="panel-body">Panel Content</div>
			   </div>

			  </div>

			  <div class="col-md-4"> 

			  <div class="panel panel-default">
			   <div class="panel-heading">Panel with panel-default class</div>
			   <div class="panel-body">Panel Content</div>
			   </div>

			  </div>

			  <div class="col-md-4"> 

			   <div class="panel panel-default">
			   <div class="panel-heading">Panel with panel-default class</div>
			   <div class="panel-body">Panel Content</div>
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
 
    
 
      
    </div>   
</body>
</html>
<?php
function _niveles($id_unidad,  $bd	, $obj){
   
        	
     	$AResultado = $bd->query_array('SIUNIDAD',
											'count(*) as NUMERO',
											'IDUNIDADPADRE='.$bd->sqlvalue_inyeccion($id_unidad,true));
     	
     	return $AResultado['NUMERO'] ;
    }
//--------------------------------------------------------
 function Subnivel($id_unidad,$bd,$obj,$nivel){
 
   
   $nivel = $nivel + 1;
    	
 
   $sql1 ="SELECT IDUNIDAD, IDUNIDADPADRE, NOMBRE, NIVEL,NIVELGESTION
   FROM SIUNIDAD
   WHERE IDUNIDADPADRE =" .$bd->sqlvalue_inyeccion($id_unidad,true); ;
   
   
   $stmt_nivel2 = $bd->ejecutar($sql1);
    
   echo '<ul>';
   
   while ($y=$bd->obtener_fila($stmt_nivel2)){
   	
   	$titulo_nivel2 			= trim($y[2]);
   	$id_departamento_nivel2 = trim($y[0]);
   	$nivel2  				= $y[3];
   	$ultimonivel 			= $y[4];
     
	 
	echo  '<li> <a href="#">'.$titulo_nivel2.'</a>';
	   
	   	$mas_niveles = _niveles($id_departamento_nivel2,  $bd	, $obj  );
	 		 
	   	if ( $mas_niveles >= 1){
				   Subnivel($id_departamento_nivel2,$bd,$obj,$nivel);
		 }
	   
	
   	
   	echo '</li>';
   	
   }
   echo '</ul>';
   
 
   }   
?>