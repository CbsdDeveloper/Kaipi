<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/co_caja_mov.js"></script> 
    
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
    
</head>
<body>

<div id="mySidenav" class="sidenav">
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 </div>

<div id="main">
	<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
    
    <div class="col-md-12" style="padding-top: 60px"> 
       <!-- Content Here -->
	    <div class="row">
 		   <div class="col-md-12">
						   <!-- Nav tabs  -->      	 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Control Mensual Caja</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Pago Caja Chica Facturas</a>
                  		</li>
                   </ul>
                     <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
                     <div class="tab-content">
                     <!-- Tab 1 -->
                         <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
                                 <div class="panel panel-default">
                                  <div class="panel-body" > 
                                       <div class="col-md-12" style="padding: 1px">
                                            <div class="col-md-3" style="background-color:#EFEFEF">
                                                 <h5>Filtro búsqueda</h5>
                                                 <div id="ViewFiltro"></div> 
                                                
                                                     <div style="padding: 10px;" class="col-md-10">
                                                           <button type="button" class="btn btn-sm btn-primary" id="load">  
                                                               <i class="icon-white icon-search"></i> Buscar
                                                            </button>	

                                                            <button type="button" class="btn btn-sm btn-default" id="loadxls"  >  
                                                                        <i class="icon-white icon-download-alt"></i>
                                                                        Descargar XLS
                                                             </button>	
 
                                                     </div>
                                                
                                                    <div style="padding: 10px;" class="col-md-10">
                                                        
                                                          <div class="btn-group-vertical">
                                                            <button type="button" id="load1" class="btn btn-sm  btn-default"><i class="icon-white icon-print"></i> Resumen Cuenta Caja</button>
                                                            <button type="button" id="load2" class="btn btn-sm  btn-default"><i class="icon-white icon-print"></i> Resumen Mensual Caja</button>
                                                            <button type="button" id="load3" class="btn btn-sm  btn-default"><i class="icon-white icon-print"></i> Detalle Mensual Caja &nbsp; &nbsp; </button>
                                                          </div>
                                                        
                                                      </div>
                                                     
                                                 </div>
                                            
                                                <div class="col-md-9">
                                                   <div class="table-responsive" id="employee_table">  
                                                       <h5>Transacciones por periódo</h5>
                                                       <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
                                                                                            <thead>
                                                                                                <tr>
                                                                                                 <th width="10%">Id</th>
                                                                                                 <th  width="10%">Fecha</th>
                                                                                                 <th  width="10%">Identificacion</th>
                                                                                                 <th width="20%">Nombre</th>
                                                                                                 <th width="30%">Detalle</th>
                                                                                                  <th width="10%">Ingreso</th>
                                                                                                  <th width="10%">Egreso</th>
                                                                                                 </tr>
                                                                                            </thead>
                                                         </table>
                                                      </div>  
                                                 </div>        
                                             <label style="padding-top: 5px;text-align: right;" > &nbsp; </label> 
                                             <div style="padding:20px" align="right" id='totalPago'> </div>
                                           
                                       </div>
                                  </div>  
                                 </div> 
                         </div>
                         <!-- Tab 2 -->
                         <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
                              <div class="panel panel-default">
                                  <div class="panel-body"  > 
                                       <div id="ViewForm"> </div>
                                  </div>
                              </div>
                         </div>
                   </div>
           </div>	  
        </div>
    </div>
    
   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
</div>   
 </body>
</html>
 