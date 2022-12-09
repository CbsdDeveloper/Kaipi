 <script >// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
            	   jQuery('#result').html(data);

   				  jQuery( "#result" ).fadeOut( 1600 );

  			 	  jQuery("#result").fadeIn("slow");
            
			}
        })        
        return false;
    }); 
 })
</script>	
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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
				$this->formulario = 'Model-inv_factura.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $titulo = 'Factura';
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 	     
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
        echo '<div class="col-md-3" style="padding:1px">
                <div class="col-md-12" style="padding:1px">
                  <div class="alert alert-info">
                       <div class="row">
                          <h5 align="center"><b> Productos Disponibles</b></h5>
                             <div id="DivProductoDisponible"> </div>
                         </div>
                   </div>
                 </div>

                <div class="col-md-12" style="padding:1px">
                     <div class="alert alert-danger">
                        <div class="row"> ';
                        echo '<h6 align="center"><img src="../../kimages/use.png" align="absmiddle" /> &nbsp;Caja Abierta : '.$ACaja['completo'] .'</h6>' ;
                        
                        $this->obj->text->text('Codigo','number','id_movimiento',10,10,$datos ,'','readonly','div-2-10') ;
                        
                        $datos['fecha'] =  date("Y-m-d");
                        
                        $this->obj->text->text('Factura','texto','comprobante',10,10,$datos ,'','readonly','div-2-10') ;
                        
                        $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-10') ;

                        $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
                            );
                        
                        
                        $evento2 =' OnChange="AsignaBodega();"';
                        
                        $this->obj->list->listadbe($resultado,$tipo,'Bodega','idbodega',$datos,'','',$evento2,'div-2-10');
                        
                echo ' <div id="FacturaElectronica"> </div>
                      </div>
                    </div>
                  </div>
                </div>'; 
        
        
          echo' <div class="col-md-9">
                  <div class="col-md-12">  
                    <h5>
                         <a href="#" class="btn btn-default" data-toggle="collapse" data-target="#demo"" role="button">
                             <b>[ 2 ] <i class="glyphicon glyphicon-user"></i>CLIENTE Y FORMA DE PAGO   </b>
                         </a> 
                   
                        <a href="#" class="btn btn-default" role="button">
                            <b> <div id="ver_factura">NRO. </div> </b>
                        </a>
                   </h5>
                  <div id="demo" class="collapse">
                      <div class="col-md-6">  
                            <div class="alert alert-info">
                              <div class="row">';
           
                                $this->obj->text->textautocomplete('CI.','texto','idprov',13,13,$datos ,'',' ','div-2-10') ;
          
          
                                $this->obj->text->textautocomplete('Cliente',"texto",'razon',40,45,$datos,'','','div-2-10');
                       
                                   
                                $this->obj->text->text('Email','texto','correo',120,120,$datos ,' ','','div-2-10') ;
                                
                                $evento1 = ' onClick="LimpiarCliente()" ';
                                
                                $cboton2 = '&nbsp;&nbsp;&nbsp;<a href="#" '.$evento1.' title="Limpiar Informacion">
                                              <img src="../../kimages/02_.png"
                                            align="absmiddle"/></a>';
                               
                                $evento = ' onClick="ActualizaCliente()" ';
                                $cboton1 = '&nbsp;<a href="#" '.$evento.' title="Actualizar Cliente"> 
                                              <img src="../../kimages/03_.png" 
                                            align="absmiddle"/></a>';
                                
                                echo $cboton2.$cboton1;
                                
                                echo '<div id="okCliente"> </div>';
                               
                       echo'</div>
                          </div>
                         </div>
                        <div class="col-md-6">
                          <div class="alert alert-info">
                            <div class="row"> ';
                                        $MATRIZ = array(
                                           'contado'    => 'Contado',
                                           'credito'    => 'Credito',
                                       );
                                       
                                        $evento = 'onChange="FormaPago(this.value)"';
                                       
                                       $this->obj->list->listae('Pago',$MATRIZ,'formapago',$datos,'required','',$evento,'div-2-10');
                                       
                                       
                                       $MATRIZ = array(
                                           'efectivo'    => 'Efectivo',
                                           'cheque'    => 'Cheque',
                                           'tarjeta'    => 'Tarjeta',
                                       );
                                       
                              
                                       $evento = 'onChange="tipopagoshow(this.value)"';
                                       
                                       $this->obj->list->listae('Tipo',$MATRIZ,'tipopago',$datos,'required','',$evento,'div-2-10');
                                       
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
                   </div> 
                </div>';
 
                echo '<div class="col-md-12" style="padding:1px">
                        <div class="col-md-10"> 
                         <div class="col-md-12" style="padding:1px">';
                           $evento = ' onClick="InsertaProducto()" ';
                            
                           $cboton1 = ' <a href="#" '.$evento.' title="Agregar Articulo"><img src="../../kimages/z_compras.png"/></a>';
                                
                           $this->obj->text->textautocomplete($cboton1,"texto",'articulo',50,50,$datos,'','','div-2-6');
                               
                           $this->obj->text->text('Articulo','texto','idproducto',30,30,$datos ,'','readonly','div-1-3') ;
                           
                           
                           $cboton2 = '<a href="#"><img src="../../kimages/if_barcode.png"/></a>';
                           
                           $evento = "javascript:inserta_dfacturacodigo(this.value)";
                           $evento1 = 'onChange="'.$evento.'"';
                           
                           $evento1='';
                         
                           $this->obj->text->texte_focus(trim($cboton2),'texto','idbarra',30,30,$datos ,'','',$evento1,'div-2-10') ;
                         
                      //     $this->obj->text->text(trim($cboton2),'texto','idbarra',50,50,$datos ,'','','div-2-6') ;
                     
                   echo  '</div>
                           </div> 
                            <div class="col-md-2">
                               <div id="ver_pago" align="center"  style="font-size: 32px;font-weight: bold;background-color: #FFADAE">$</div> 
                            </div>
                        </div>';
 
                  echo  '<div class="col-md-12" style="padding:1px">
                                  <div class="alert al1ert-info fade in">
                                        <div id="DivMovimiento"> </div>
                                  </div>
                                 <div id="DivProducto"> </div>
                        </div>';

                 echo  ' </div> ';

     
         $this->obj->text->texto_oculto("estado",$datos); 
		 $this->obj->text->texto_oculto("action",$datos); 
          $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
     if ( $autoriza == 'S') {
       
             $formulario_impresion = '../view/cliente';
             $eventoc = 'javascript:openView('."'".$formulario_impresion."')";
         
         
             $evento = 'javascript:aprobacion()';
             
             $formulario_impresion = '../../reportes/reporteInv?tipo=51';
             $eventop = 'javascript:url_comprobante('."'".$formulario_impresion."')";
             
             $titulo = '<b><span style="font-size: 16px">[ 1 ]</span></b>';
             
             
             $eventof = "javascript:goToURLElectronicoTool(1)";
             
             $eventog = "javascript:goToURLElectronicoActualiza(1)";
             
               
             $ToolArray = array(
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
                 array( boton => 'Impresion Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button") ,
                 array( boton => 'Lista de Clientes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button") ,
                 array( boton => 'Emitir Factura Electronica', evento =>$eventof,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button"),
                 array( boton => 'Descargar Factura Electronica', evento =>$eventog,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button")
             );
             
             $this->obj->boton->ToolMenuDivTitulo($ToolArray,$titulo); 
     
      }else{
          echo '<b>NO SE ENCUENTRA ASIGNADO COMO CAJERO(A)...</b>';
      }
    
    
    
    
   
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
<script type="text/javascript">

 jQuery.noConflict(); 


 jQuery("#idbarra").keypress(function(e) { var code = (e.keyCode ? e.keyCode : e.which); 
	if(code == 13){ 
		inserta_dfacturacodigo();
		return false; 
		} 
});

 
 
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});


 jQuery('#idprov').typeahead({
	    source:  function (query, process) {
     return $.get('../model/AutoCompleteIDCedula.php', { query: query }, function (data) {
     		console.log(data);
     		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
 

 
 $("#razon").focusin(function(){
	 
	 		    var itemVariable = $("#razon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
										    type:  'GET' ,
											data:  parametros,
											url:   '../model/AutoCompleteIDMultiple.php',
											dataType: "json",
 											success:  function (response) {

 	 											
													 $("#idprov").val( response.a );  
													 
													 $("#correo").val( response.b );  
													  
											} 
									});
	 
    });


 $("#idprov").focusin(function(){
	 
	    var itemVariable = $("#idprov").val();  

		var parametros = {
									"itemVariable" : itemVariable 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/AutoCompleteIDMultipleID.php',
									dataType: "json",
									success:  function (response) {

										
											 $("#razon").val( response.a );  
											 
											 $("#correo").val( response.b );  
											  
									} 
							});

});
 
 //---------------------------------------------- focusin focusout
 
 
  jQuery('#articulo').typeahead({
 	    source:  function (query, process) {
        return $.get('../model/AutoCompleteProdFac.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

  $("#articulo").focusout(function(){
		 
		 var itemVariable = $("#articulo").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDProd.php',
												type:  'GET' ,
												beforeSend: function () {
														$("#idproducto").val('...');
												},
												success:  function (response) {
														 $("#idproducto").val(response);  // $("#cuenta").html(response);
														  
												} 
										});
		 
	    });
  

  
  
  
</script>
 
  