<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
          
      }
 
      //---------------------------------------
      
     function Formulario( ){
      
         
      
       
         
   echo ' <div class="col-md-6">
           <div class="alert alert-info">
              <div class="row">';
             
                                $this->obj->text->textautocomplete('CI.','texto','idprov1',13,13,$datos ,'',' ','div-2-10') ;
                                    
                                    
                                $this->obj->text->textautocomplete('Cliente',"texto",'razon1',40,45,$datos,'','','div-2-10');
                                    
                                    
                                $this->obj->text->text('Email','texto','correo1',120,120,$datos ,' ','','div-2-10') ;
                                    
                                $evento1 = ' onClick="LimpiarCliente()" ';
                                    
                                $cboton2 = '&nbsp;&nbsp;&nbsp;<a href="#" '.$evento1.' title="Limpiar Informacion">
                                <img src="../../kimages/02_.png"
                                    align="absmiddle"/></a>';
                                        
                                $evento = ' onClick="ActualizaCliente()" ';
                                
                                $cboton1 = '&nbsp;<a href="#" '.$evento.' title="Actualizar Cliente">
                                <img src="../../kimages/03_.png"
                                    align="absmiddle"/></a>';
                                
                             
                                        
                                echo $cboton2.$cboton1 ;
                                        
                                echo '<div id="okCliente"> </div>';
                                    
      echo'</div>
             </div>
                </div>
           <div class="col-md-6">
              <div class="alert alert-info">
                 <div class="row"> ';
      
                              $MATRIZ = array(
                                  '0'    => 'Factura',
                                  '9'    => 'Ingreso a Caja'
                               );
                              
                               
                              $this->obj->list->listae('',$MATRIZ,'tipofactura',$datos,'required','','','div-2-10');
       
      
                                        $MATRIZ = array(
                                           ''    => ' [ Seleccione la forma de pago ]',
                                           'contado'    => 'Contado',
                                           'credito'    => 'Credito' 
                                       );
                                               
                                        $evento = 'onChange="FormaPago(this.value)"';
                                            
                                       $this->obj->list->listae('Pago',$MATRIZ,'formapago1',$datos,'required','',$evento,'div-2-10');
                                          
                                       
                                           
                                       $MATRIZ = array(
                                           'efectivo'    => 'Efectivo',
                                           'cheque'    => 'Cheque',
                                           'tarjeta'    => 'Tarjeta',
                                       );
                                               
                                     
                                       
                                       $evento = 'onChange="tipopagoshow(this.value)"';
                                           
                                       $this->obj->list->listae('Tipo',$MATRIZ,'tipopago1',$datos,'required','',$evento,'div-2-10');
                                           
                                       $evento = 'onChange="cambio_dato(this.value)"';
                                           
                                       $this->obj->text->textLong('PAGO',"number",'efectivo',15,15,$datos,'','',$evento,'div-2-10');
                                           
                                       echo '<h3 align="center" id="div_sucambio"></h3>';
                                           
                                           
                                       $this->obj->text->texte('Nro.Cuenta','texto','cuentaBanco',30,30,$datos ,'','','','div-2-10') ;
                                           
                                           
                                       $evento = '';
                                           
                                       $sql ="SELECT idcatalogo as codigo, nombre
                                            FROM  par_catalogo
                                            WHERE  tipo = 'bancos'"   ;
                                                
                                       $resultado = $this->bd->ejecutar($sql);
                                                
                                       $this->obj->list->listadbe($resultado,$tipo,'Institucion','idbanco',$datos,'','',$evento,'div-2-10');
                                           
        echo '</div>
                </div>
                   </div>';
 
  
      
   }
   
///------------------------------------------------------------------------
  }
 ///------------------------------------------------------------------------
 ///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
   
  $gestion->Formulario( );
 
  
 ?>
 <script type="text/javascript">

 jQuery.noConflict(); 

 
 jQuery('#razon1').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});


 jQuery('#idprov1').typeahead({
	    source:  function (query, process) {
     return $.get('../model/AutoCompleteIDCedula.php', { query: query }, function (data) {
     		console.log(data);
     		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
 

 
 $("#razon1").focusin(function(){
	 
	 		    var itemVariable = $("#razon1").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
										    type:  'GET' ,
											data:  parametros,
											url:   '../model/AutoCompleteIDMultiple.php',
											dataType: "json",
 											success:  function (response) {

 	 											
													 $("#idprov1").val( response.a );  
													 
													 $("#correo1").val( response.b );  
													  
											} 
									});
	 
    });


 $("#idprov1").focusin(function(){
	 
	    var itemVariable = $("#idprov1").val();  

		var parametros = {
									"itemVariable" : itemVariable 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/AutoCompleteIDMultipleID.php',
									dataType: "json",
									success:  function (response) {

										
											 $("#razon1").val( response.a );  
											 
											 $("#correo1").val( response.b );  
											  
									} 
							});

});

 </script>
  