<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>FORMULARIO DE SEGUIMIENTO</title>
	
    <?php  require('../../kadmin/view/Head.php')  ?> 
 
	<?php 
 			require('kreportes.php'); 
			$gestion   		= 	new ReportePdf; 		 
			$idasiento 		=   $_GET['id'];
			$datos 			=	$gestion->Tramite_req($idasiento);
			$gestion->QR_DocumentoDoc($idasiento);
?>
 
	<style>
	@media print {
		
		 @page {                
   		 size: A4;
    	margin: 5mm;
  		}

  html, body {
    width: 1024px;
  }

.col-sm-1, .col-md-2, .col-sm-3, .col-md-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-md-12 {
  float: left;
}
.col-md-12 {
  width: 100%;
}
.col-sm-11 {
  width: 91.66666666666666%;
}
.col-sm-10 {
  width: 83.33333333333334%;
}
.col-sm-9 {
  width: 75%;
}
.col-sm-8 {
  width: 66.66666666666666%;
}
.col-sm-7 {
  width: 58.333333333333336%;
}
.col-sm-6 {
  width: 50%;
}
.col-sm-5 {
  width: 41.66666666666667%;
}
.col-md-4 {
  width: 33.33333333333333%;
 }
 .col-sm-3 {
   width: 25%;
 }
 .col-md-2 {
   width: 16.666666666666664%;
 }
 .col-sm-1 {
  width: 8.333333333333332%;
 }

		.solid  { 
				  border-style: solid; 
				  color:black;
				  border-width:thin ;
		      }
		
  }
		
</style>
 	 		 
</head>
	
<body>

 
		 
     <div class="col-md-12"> 
		
		   <table width="100%">
							  <tr>
								<td width="15%" align="left" valign="top" style="font-size: 11px">
									<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="80">
								</td>
								<td  width="80%" colspan="3" align="left" style="font-size: 11px">
									<?php 
										echo $gestion->EmpresaCab().'<br>';
										echo $gestion->_Cab( 'ruc_registro' ).'<br>';
										echo $gestion->_Cab( 'direccion' ).'<br>';
										echo $gestion->_Cab( 'telefono' ).'<br>';
										echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
									?>
									</td>
									 <td width="5%" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
								</tr>
				  </table>	
 </div>   
	
     <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"> 	

	
 			 <table width="100%">				 
				<tr>
					<td colspan="4" align="center" style="font-size: 10px">&nbsp;  </td> 
				 </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 14px"><b><?php echo $datos['servicio']?></b></td> </tr>
				<tr>
				  <td colspan="4" align="center" style="font-size: 12px;color:#727272"><b>Nro.Tramite <?php echo $datos['id_ren_tramite'] ?></b></td>
  				</tr>
				<tr>
				  <td colspan="4"  style="font-size: 10px">&nbsp;</td>
 				 </tr>
				<tr>
				  <td  class="solid"  style="font-size: 11px;padding:3px" width="20%">Fecha</td>
				  <td class="solid"   style="font-size: 11px;padding:3px" width="30%"><?php echo $datos['fecha_inicio'] ?></td>
				  <td class="solid"   style="font-size: 11px;padding:3px" width="20%">Cod.CIU</td>
				  <td class="solid"   style="font-size: 11px;padding:3px" width="30%"><?php echo $datos['id_par_ciu'] ?></td>
    			</tr>
				<tr >
				  <td class="solid"  style="font-size: 11px;padding:3px">Contribuyente</td>
				  <td class="solid"  style="font-size: 11px;padding:3px"><?php echo $datos['razon'] ?></td>
				  <td class="solid"  style="font-size: 11px;padding:3px">Identificacion</td>
				  <td class="solid"  style="font-size: 11px;padding:3px"><?php echo $datos['idprov'] ?></td>
  			  </tr>
				<tr>
				  <td class="solid"   style="font-size: 11px;padding:3px">Elaborador por</td>
				  <td class="solid"   style="font-size: 11px;padding:3px"><?php echo $datos['login'] ?></td>
				  <td class="solid"   style="font-size: 11px;padding:3px">Estado</td>
				  <td class="solid"   style="font-size: 11px;padding:3px"><?php echo $datos['estado'] ?></td>
    </tr>
				<tr >
				  <td  colspan="2" class="solid" style="font-size:11px;padding:3px">Detalle</td>
				  <td  colspan="2" class="solid" style="font-size:11px;padding:3px">Resolucion</td>
    </tr>
				<tr > 
					<td   colspan="2"  class="solid" style="font-size: 11px;padding:3px"><?php echo trim($datos['detalle'])  ?></td>
				    <td   colspan="2"  class="solid" style="font-size: 11px;padding:3px"><?php echo trim($datos['resolucion'])  ?></td>
			    </tr>
			
 </table>
		
	 </div>   	
	
	 <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"> 	
	
			 <div class="container">
				 
					<?php $gestion->Tramite_variables($idasiento, $datos['id_rubro']);  ?>
				
			 </div> 	   
    </div> 	

    <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"> 	
	
			 <div class="container">

				 
					<?php 

					$datos= $gestion->Tramite_seg($idasiento); 

					?>
					
					<table width="50%"  cellspacing="0">
						
							<tr>
								<td>
									<?php echo $datos['novedad_seg']; ?>
									
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $datos['accion_seg']; ?>
								</td>
									
							</tr>
							<tr>
								<td>
									<?php echo $datos['responsable_seg']; ?>	
								</td>
								<td>
									<?php echo $datos['fecha_seg']; ?>
								</td>
							</tr>
							
					</table>


				
			 </div> 	   
    </div> 	   
	   
	
	 <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"> 	
		
		<table width="100%">
				 
 					<tr>
							  <td class="solid"  style="padding-bottom: 5px; padding-top: 35px;font-size: 8px" align="center" valign="middle">FIRMA DEL INSPECTOR<br> NOMBRE:<br>
							  CC.:</td>
							  <td class="solid"  style="padding-bottom: 5px; padding-top: 35px;font-size: 8px" align="center" valign="middle">FIRMA DEL SOLICITANTE<br> NOMBRE:<br>
							  CC.:</td>
					</tr>
					<tr>
		  					<td class="solid"  style="padding-bottom: 5px; padding-top: 35px;font-size: 8px" align="center" valign="middle">VISTO BUENO<br><br>
		   					 APROBADO <img src="../../kimages/chequea.png" align="absmiddle"  width="10" height="10"/>&nbsp;&nbsp; NEGADO  <img src="../../kimages/chequea.png" align="absmiddle"  width="10" height="10"/></td>
					 		 <td class="solid"  style="padding-bottom: 5px; padding-top: 35px;font-size: 8px" align="center" valign="middle">TCRNL. HUGO ASTUDILLO TORRES<br><br>JEFE DE CBVS</td>
	  				</tr>
				</table>
		
	  </div> 		
	
	
	<p>&nbsp;</p>	
<img width="80" height="80" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
		
 </body>
</html>
