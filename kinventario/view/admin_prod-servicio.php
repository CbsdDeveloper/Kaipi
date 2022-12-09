<?php
	session_start( );
    if (empty($_SESSION['usuario']))  {
	    header('Location: ../../kadmin/view/login');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/admin_prod-servicio.js"></script> 
 	 
    
    
    <style>
        
    	#mdialTamanio{
      			width: 55% !important;
   			 }
     
        #mdialTamanio2{
      			width: 65% !important;
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
    
</head>
<body>
 
 
  
	<div class="col-md-12" role="banner">
 	   <div id="MHeader"></div>
 	</div> 
 	
	<div id="mySidenav" class="sidenav" >
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
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"> 
                   			<span class="glyphicon glyphicon-th-list"></span> <b>DEFINICION PRODUCTOS </b>  </a>
                   		</li>
                   		
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Bienes/Producto</a>
                  		</li>
	 
	 				    <li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-download-alt"></span> Importar Informacion Inicial</a>
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
		  		  	     
		  		  	         <div class="col-md-12"> 
                                	 	 
									 
									         <div class="alert alert-info"><div class="row">
  													<div id = "ViewFiltro" > </div>
  										
  													<div class="col-md-2" style="padding-top: 5px;">&nbsp;</div> 
													<div class="col-md-4" style="padding-top: 5px;">
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
													<button type="button" class="btn btn-sm btn-default" id="loadSaldo" title="Saldos de bodega">  
													<i class="icon-white icon-ambulance"></i></button>
														
												</div>
								 			 </div>
								  			</div>
   								     
 				  		     </div> 
			  		  	     
 			  		  	     <div class="col-md-12"> 
 			  		  	     
        					  		  <table id="jsontable" class="display table-condensed"  width="100%">
        									 <thead>
        									   <tr>   
        													<th width="10%">Codigo</th>
        													<th width="20%">Detalle</th>
        													<th width="20%">Referencia</th>
        										   			<th width="10%">Cuenta</th>
        													<th width="10%">Marca</th>
         													<th width="10%">Unidad</th>    
        													<th  width="10%">Costo</th>
        										  		    <th  width="10%" bgcolor="#FFB5B6">Saldo</th>
        													<th width="10%">Acciones</th>
        									   </tr>
        									</thead>
        							 </table>
								 
								 	  <div id="SaldoBodega"></div>
                             </div>  
                          </div>  
                     </div> 
             </div>
               
               <!-- ------------------------------------------------------ -->
               <!-- Tab 2 -->
               <!-- ------------------------------------------------------ -->
           
                 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
						    
						  		   <div id="ViewForm"> </div>
						  		   
						  		   <div class="col-md-12" id="precio_grilla"></div>
						   
               		       </div>
                	  </div>
             	 </div>
 			    
                <!-- ------------------------------------------------------ -->
                 <!-- Tab 3 -->
                 <!-- ------------------------------------------------------ -->
                 
			     <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
							  
							 <div class="col-md-12">
							       <h5> <b>Formato Importar archivo XLS </b>
								        <a href="../../archivos/web_producto_model.csv" title="Descargar archivos">
											<img src="../../kimages/Download_183297.png" />
									   </a> 
								   </h5>   
				                 		 <img src="../../kimages/excel_carga.jpg" /> 
								   <h5><b>Generar archivo CSV</b></h5>   
								 <img src="../../kimages/excel_csv.jpg" /> 
								 
					        </div>
							  
							  	 <div class="col-md-12" style="background-color:#E3E3E3">
							   		<iframe width="100%" id="archivocsv" name = "archivocsv" height="160" src="../model/Model_carga_inicial_excel.php" border="0" scrolling="no" allowTransparency="true" frameborder="0">
							 	    </iframe>
							   </div>
							  
							  
						  </div>
                	  </div>
                 </div>	
			   
          	 </div>
		   
 	 </div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 
    <div class="modal fade" id="ViewCarga" role="dialog">
      <div class="modal-dialog" id="mdialTamanio">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Visor de Carga Inicial</h4>
            </div>
            <div class="modal-body">
              <div class="row">
    			  <div id = "ViewFiltroCarga" > </div>
    			  
    		  </div>
            </div>
            <div class="modal-footer">
    			 <div id = "DatosCarga" > </div>
    			
    			<button type="button" class="btn btn-warning" onClick="CargaInicialDato()" data-dismiss="modal">Guardar</button>
    			
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>
    
    
    <div class="modal fade" id="ViewCodigo" role="dialog">
    
  <div class="modal-dialog" id="mdialTamanio2">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Codigo Externo Articulo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
               <div id = "DatosCarga1" align="center"> Mensaje </div>
              
			  <div id = "ViewFiltroCodigo"> </div>
			  
              	
		  </div>
        </div>
        <div class="modal-footer">
		
			
			<button type="button" class="btn btn-warning" onClick="ActualizaCodigo()" data-dismiss="modal">Guardar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


 </body>
</html>
