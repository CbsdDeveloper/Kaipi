<?php  
session_start( );  
       date_default_timezone_set('UTC');
       date_default_timezone_set('America/Lima');
       setlocale(LC_TIME, 'es_ES.UTF-8');
       setlocale (LC_TIME,"spanish");
       
       require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
       require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
        
       $bd	   =	new Db;
       
       $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
       
       $idUsuario = $_SESSION['usuario'];
       
       $x = $bd->query_array('par_usuario',
           'tipo',
           'idusuario='.$bd->sqlvalue_inyeccion($idUsuario,true)
           );
       
       $enlace = 'inicio';
       
 
     
       
?>
<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<div class="navbar-header">
				     <a class="navbar-brand" href="#">K·Gestiona</a>
					 <a class="navbar-brand"> <span style="font-size:20px;cursor:pointer" onclick="openNav()">&#9776</span></a>
				</div>
				<ul class="nav navbar-nav">
				  <li class="active"><a href="../../kadmin/view/View-panel">INICIO</a></li>
				  <li><a href="<?php  echo $enlace;  ?>">SERVICIOS</a></li>
				  <li><a href="#"> <b><?php  echo $_SESSION['ruc_registro'];  ?> </b></a></li>
				  <li><a href="#"> <b>EMPRESA: <?php  echo $_SESSION['razon'];  ?> </b></a></li>
				  <li><a href="#"><?php echo date("F j, Y, g:i a") ?> </a></li>
				  <li><a href="#">Login <?php echo strtoupper($_SESSION['login']); ?> </a></li>
					
					 <li><a href="#"  onClick="window.location.reload(true)">  
							   <span style="font-size:22px;cursor:pointer">&#9965</span>
				   </a></li>
					
				  <li><a href="#"></a></li>
 				</ul>
			  </div>
	
 </nav>