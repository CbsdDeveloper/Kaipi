<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  
 		require('Head.php')  
     ?> 
 
 	
	<script type="text/javascript" src="../js/cli_editor_doc.js"></script> 
 	 
	 <script src="../../keditor/ckeditor/ckeditor.js"></script>
	
	
	
	
	
</head>

<body>

<!-- ------------------------------------------------------ -->

<div id="mySidenav" class="sidenav">
 
  <div class="panel panel-primary" >
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 
 </div>
 
<!-- ------------------------------------------------------ -->
 <div id="main">
	
	<!-- Header -->
	
	<header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
 	
  <!-- ------------------------------------------------------ -->  
    <div class="col-md-12" style="padding-top: 60px"> 
      	   <h5><b>EDITOR DE DOCUMENTOS</b></h5>
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> PARAMETROS DOCUMENTO</a>
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
								   	    <H5><b>Parametros</b> </H5>  
											  <div class="col-md-4" style="padding-top: 5px">    
												Formato de archivo 
												<select name="formato" required="required" id="formato" class="form-control-static">
												  <option value="html">html</option>
												  <option value="pdf">pdf</option>
												</select>
												  Visualizar reporte 
												<select name="formato" required="required" id="formato" class="form-control-static">
												     <option value="N">NO</option>
													<option value="S">SI</option>
												 
												</select>
											  </div>   
	  		  	               </div> 
							    <div class="col-md-12">  
										<H5><b>Encabezado</b> </H5>  
										<textarea cols="50" id="editor1" name="editor1" rows="4" >  </textarea>
                                </div>   
							      <div class="col-md-12">  
                               			 <H5><b>Pie de Página </b></H5>  
 				  		        		  <textarea cols="50" id="editor2" name="editor2" rows="4" >  </textarea>
							      </div>  	  
                        </div>  
                     </div> 
             </div>
           
         <script>
			CKEDITOR.replace( 'editor1', {
				height: 150,
				width: '100%',
			} );
			 
			CKEDITOR.replace( 'editor2', {
				height: 150,
				width: '100%',
			} ); 
 	     </script>
            
 
          	 </div>
		   
 		</div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
