<?php
	session_start( );

     include ('../model/FichaProcesosReportes.php');


   if (isset($_GET['id']))	{
	
	       $gestion   = 	new proceso;
	 
			$id       = $_GET['id'];
 
 }

?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Reporte</title>
	
    <?php  require('../view/Head.php')  ?> 
	
  	<script type="text/javascript">
            function imprimir() {
                if (window.print) {
                       window.print();
					
					    ventana=window.self; 
				//		ventana.opener=window.self; 
					//	ventana.close();  
					
					
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
            }
        </script>
	
	
</head>
    <body onload="imprimir();">
<!-- ------------------------------------------------------ -->
 
 
 
	<div class="col-md-12" style="padding: 25px">
	  <table width="100%" border="1">
		  <tbody>
			<tr>
			  <td rowspan="4"  align="center" width="15%"><img width="100px" height="100px" src="../../kimages/<?php echo trim($_SESSION['logo'])?>"></td>
			  <td width="60%"  align="center" style="padding: 5px"><b><?php echo trim($_SESSION['razon']) ?></b></td>
			  <td width="10%" align="right" style="padding: 5px">&nbsp; </td>
			  <td width="15%" style="padding: 5px">&nbsp;</td>
			</tr>
			<tr>
			  <td rowspan="2" align="center" style="padding: 5px"> <b><?php echo  $gestion->ProcesoNombre( $id );  ?> </b>  </td>
			  <td  align="right" style="padding: 5px">Codigo</td>
			  <td style="padding: 5px"><?php   $gestion->variable('codigo') ?></td>
			</tr>
			<tr>
			  <td  align="right" style="padding: 5px">Fecha</td>
			  <td style="padding: 5px"><?php   $gestion->variable('hoy') ?></td>
			</tr>
			<tr>
			  <td align="center" style="padding: 5px">FICHA DE GESTION DE PROCESOS</td>
			  <td  align="right" style="padding: 5px">Usuario</td>
			  <td style="padding: 5px"><?php echo trim($_SESSION['login']) ?></td>
			</tr>
		  </tbody>
		</table>
  </div>  
 
<div class="col-md-12" style="padding: 25px">
	
		 <table width="100%" border="1">
  <tbody>
    <tr>
      <td colspan="4" align="center" style="padding: 5px">INFORMACION GENERAL DEL DOCUMENTO</td>
      </tr>
    <tr>
      <td width="10%" style="padding: 5px">Codigo Proceso</td>
      <td width="40%" style="padding: 5px"><?php   $gestion->variable('codigo') ?></td>
      <td width="10%" style="padding: 5px">Macro Proceso</td>
      <td width="40%" style="padding: 5px"><?php   $gestion->variable('macro_proceso') ?></td>
    </tr>
    <tr>
      <td style="padding: 5px">Proceso</td>
      <td style="padding: 5px"><?php   $gestion->variable('nombre') ?></td>
      <td style="padding: 5px">Sub Proceso</td>
      <td style="padding: 5px"><?php   $gestion->variable('subproceso') ?></td>
    </tr>
    <tr>
      <td style="padding: 5px">Ambito</td>
      <td style="padding: 5px"><?php   $gestion->variable('ambito') ?></td>
      <td style="padding: 5px">Tipo</td>
      <td style="padding: 5px"><?php   $gestion->variable('tipo') ?></td>
    </tr>
    <tr>
      <td style="padding: 5px">Unidad</td>
      <td style="padding: 5px"><?php   $gestion->variable('unidad') ?></td>
      <td style="padding: 5px">Responsable</td>
      <td style="padding: 5px"><?php   $gestion->variable('completo') ?></td>
    </tr>
    <tr>
      <td style="padding: 5px">Marco Legal</td>
      <td style="padding: 5px" colspan="3"><?php   $gestion->variable('legal') ?></td>
      </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      </tr>
    <tr>
      <td style="padding: 5px">Objetivo</td>
      <td colspan="3" style="padding: 5px"><?php   $gestion->variable('objetivo') ?></td>
      </tr>
    <tr>
      <td><span style="padding: 5px">Alcance</span></td>
      <td colspan="3" style="padding: 5px"><span style="padding: 5px">
        <?php   $gestion->variable('alcance') ?>
      </span></td>
      </tr>
    <tr>
      <td style="padding: 5px">Entrada</td>
      <td style="padding: 5px"><?php   $gestion->variable('entrada') ?></td>
      <td style="padding: 5px">Salida</td>
      <td style="padding: 5px"><?php   $gestion->variable('salida') ?></td>
    </tr>
    <tr>
      <td style="padding: 5px">Disparador</td>
      <td style="padding: 5px"><?php   $gestion->variable('disparador') ?></td>
      <td style="padding: 5px">Indicador</td>
      <td style="padding: 5px"><?php   $gestion->variable('indicador') ?></td>
    </tr>
    <tr>
      <td style="padding: 5px">Modelador</td>
      <td style="padding: 5px"><?php   $gestion->variable('modelador') ?></td>
      <td style="padding: 5px">&nbsp;</td>
      <td style="padding: 5px">&nbsp;</td>
    </tr>
  </tbody>
</table>
	
  </div>  	
	   
	<div class="col-md-12" style="padding: 25px">
 	
      <?php  $gestion->Flujo( );  ?>  
                             
   </div>  	 
 
 
 <div class="col-md-12" style="padding: 25px">
 		<h3><b>REQUISITOS</b></h3>  
      <?php  $gestion->Requisitos( );  ?>  
                             
   </div>  
		
		
	  <div class="col-md-12" style="padding: 25px">
		  
		       <div class="col-md-12" align="justify" style="font-size: 14px;padding: 25px">
 					<h3><b>PROCEDIMIENTO</b></h3>  
     				<?php   $gestion->variable('procedimiento') ?> 
 		      </div>  
      </div>  
		
   <div class="col-md-12" style="padding: 25px">
 	
 <table width="100%" border="1">
  <tbody> 
    <tr>
      <td style="padding: 5px">Observacion</td>
      <td colspan="3" style="padding: 5px"><?php   $gestion->variable('novedad') ?></td>
      </tr>
    <tr>
      <td width="10%" style="padding: 5px">Creado</td>
      <td width="40%" style="padding: 5px"><?php   $gestion->variable('sesion') ?></td>
      <td width="10%" style="padding: 5px">Fecha</td>
      <td width="40%" style="padding: 5px"><?php   $gestion->variable('creacion') ?></td>
    </tr>
     
    <tr>
      <td style="padding: 5px">Modificado</td>
      <td style="padding: 5px"><?php   $gestion->variable('sesionm') ?></td>
      <td style="padding: 5px">Fecha</td>
      <td style="padding: 5px"><?php   $gestion->variable('modificacion') ?></td>
    </tr>
  </tbody>
</table>
                             
   </div>  	 
		
 
</body>
	
</html>
 