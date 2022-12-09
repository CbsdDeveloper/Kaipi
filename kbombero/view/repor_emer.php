<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
		 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js"></script>   
	     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js"></script>
 	     <script type="text/javascript" src="../js/repor_emer.js"></script> 
	
		 <style type="text/css">
		 
	 #mdialTamanio{
  					width: 75% !important;
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
	        <ul id="mytabs" class="nav nav-tabs">       
 				 
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>CONTROL DE EMERGENCIAS</b></a>
                   		</li>
                  	 
           </ul>
                    
           <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->
           <div class="tab-content">
            
           <!-- ------------------------------------------------------ -->
           <!-- Tab 1 -->
           <!-- ------------------------------------------------------ -->
                  
            <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
 			  <div class="panel panel-default">
					<div class="panel-body" > 
											  
			 		    <div class="col-md-12"  >
 					  <div class="col-md-12" style="background-color:#ededed; padding-bottom: 10px;padding-top: 10px">
													    
 														   
														   <div id="ViewFiltro"></div> 
						 
														   
 															<div class="col-md-12" style="padding-top: 8px">
																	<button type="button"  class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
																
																   <button type="button" class="btn btn-sm btn-default" id="saveAsExcel">  
																	<i class="icon-white icon-download-alt"></i> Exportar</button>

																
																 <button title="Exportar a excel las emergencias"  type="button" class="btn btn-sm btn-info" id="saveAsExcelResumen">  
																	<i class="icon-white icon-download-alt"></i></button>	
																
																 <button title="Impresion por categoria" type="button" class="btn btn-sm btn-warning" id="saveAsReporte">  
																	<i class="icon-white icon-print"></i></button>	
																
																	
																
															</div>
															 
														 
					 </div>
					  <div class="col-md-12">
												        <h5>Transacciones por periódo</h5>
						  
					 
						  
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="5%">Fecha</th>
																						<th width="10%">Nro.Informe</th>
																						<th width="10%">Parroquia</th>
																						<th width="20%">Descripcion</th>
																						<th width="10%">Emergencia</th>
																						<th width="10%">Estado</th>						
																						<th width="10%">Fecha Emergencia</th>
																						<th width="10%">Hora Aviso</th>
																						<th width="10%">Usuario</th>
																						<th width="5%">Acción</th>
																						</tr>
																					</thead>
														  </table>
						 
						 </div>  
  						</div>
					
				  </div>
				  </div>
                 </div>
           
               
          	 </div>
		   
 		</div>
	
    

<input type="hidden" id="cuenta_tmp" name="cuenta_tmp">
   
 
    <div id="FormPie"></div>  

  <div id="ViewForma"></div> 
	
 </div>   


 
 </body>
</html>
