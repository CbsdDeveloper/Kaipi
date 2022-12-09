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
 
 	<script type="text/javascript" src="../js/ac_unidad.js"></script> 
 	 		 
</head>
<body>

<!-- ------------------------------------------------------ -->
 
<!-- ------------------------------------------------------ -->
 <div id="main">
 <!-- ------------------------------------------------------ -->  
 	 <div class="col-md-12" style="padding-top: 5px"> 
        		 <!-- Content Here -->
	        <ul id="mytabs" class="nav nav-tabs">       
 				 
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>Unidades Externas</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Detalle de información</a>
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
                             
				
				
			  		  	     <div class="col-md-12"> 
					  		 	  <table id="jsontable" class="display table-condensed" style="font-size: 12px" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
											<th width="10%">Codigo</th>
											<th width="30%">Unidad Externa</th>
											<th width="40%">Ubicacion y Referencia</th>
 											<th width="10%">Estado</th>
 											<th width="10%">Acciones</th>
									   </tr>
									</thead>
							    </table>
                             </div>  
              </div>
           
             <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
                  <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
  						  		   <div id="ViewForm"> </div>
              	  </div>
          	 </div>
		   
 		</div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
