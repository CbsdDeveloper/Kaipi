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
	             
	             
	             jQuery('#result').slideUp( 300 ).delay( 0 ).fadeIn( 400 ); 
            
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
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
				$this->formulario = 'Model-inv_factura.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $titulo = '';
        
        $datos = array();
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 	     
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
       echo'<div class="col-md-12">
               <div class="col-md-4">   
                  <div class="alert alert-danger"><div class="row">
                   <div class="col-md-12">';
                   echo '<h6><img src="../../kimages/use.png" align="absmiddle" /> &nbsp;Caja Abierta : '.$ACaja['completo'] .'</h6>' ;
                   
                   $this->obj->text->text('Transaccion','number','id_movimiento',10,10,$datos ,'','readonly','div-2-10') ;
                
                   $datos['fecha'] =  date("Y-m-d");
                   
                   $this->obj->text->text('Factura','texto','comprobante',10,10,$datos ,'','readonly','div-2-4') ;
                   
                   $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-1-5') ;
                   
                   echo'</div>
                        </div>
                      </div>
                    <div class="alert alert-info"><div class="row">
                   <div class="col-md-12"> 
                   <h5> <b> [ 3 ] CLIENTE </b></h5>';
                    
               
                   
                   $this->obj->text->textautocomplete('Cliente',"texto",'razon',40,45,$datos,'required','','div-2-10');
                   
                   $this->obj->text->text('CI.','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;
                   
                   echo '<h5><div id ="div_sucambio" align="center"> &nbsp;</div></h5>' ;
     
       echo '<h6> &nbsp;</h6>' ;
       echo' </div>  
                </div>
                 </div>  
                <div class="alert alert-warning"><div class="row">
                        <div class="col-md-12">
                                <h5><b>[ 4 ]    PAGO</b></h5>';
       
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
                       
                       $this->obj->text->textLong('PAGO',"number",'efectivo',15,15,$datos,'required','',$evento,'div-2-10');
                       
                       
                 
                       $this->obj->text->texte('Nro.Cuenta','texto','cuentaBanco',10,10,$datos ,'','','','div-2-10') ;
                       
                      
                       $evento = '';
                      
                       $sql ="SELECT idcatalogo as codigo, nombre
                            FROM  par_catalogo 
                            WHERE  tipo = 'bancos'"   ;
                       
                       $resultado = $this->bd->ejecutar($sql);
                      
                       $this->obj->list->listadbe($resultado,$tipo,'Institucion','idbanco',$datos,'','',$evento,'div-2-10');
                       
       
       echo '    </div>
               </div>
               </div></div> 
               <div class="col-md-8">';
     
               echo'     <h5><b>[ 2 ] DETALLE FACTURA</b></h5>
                        <div class="col-md-12">';
       
     
       
      
       
           $evento = ' onClick="InsertaProducto()" ';
           
           $cboton1 = ' <a href="#" '.$evento.' title="Agregar Articulo"><img src="../../kimages/if_cart_add.png" align="absmiddle"/></a>';
       
           $this->obj->text->textautocomplete('Articulo',"texto",'articulo',40,45,$datos,'','','div-2-4');
           
           $cboton2 = '<a href="#"><img src="../../kimages/if_barcode.png"/></a>';
           
           $this->obj->text->text($cboton2,'texto','idbarra',50,50,$datos ,'','','div-2-4') ;
           
           $this->obj->text->text($cboton1,'texto','idproducto',10,10,$datos ,'','readonly','div-2-10') ;
           
           
          
       
         echo  '<div class="alert al1ert-info fade in">
                                		<div id="DivMovimiento"> </div>
                </div>
                                        <div id="DivProducto"> </div>
                                
                </div>
               </div>
            </div>
';
        
         $this->obj->text->texto_oculto("estado",$datos); 
		 $this->obj->text->texto_oculto("action",$datos); 
          $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
     if ( $autoriza == 'S') {
       
             $formulario_impresion = '../view/cliente';
             $eventoc = 'javascript:impresion('."'".$formulario_impresion."')";
         
         
             $evento = 'javascript:aprobacion()';
             
             $formulario_impresion = '../../reportes/reporteInv?tipo=51';
             $eventop = 'javascript:url_comprobante('."'".$formulario_impresion."')";
             
             $titulo = '<b><span style="font-size: 16px">[ 1 ]</span></b>';
             
             $ToolArray = array(
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Clientes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
                 array( boton => 'Impresi�n Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button") 
                 
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
 
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
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
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											beforeSend: function () {
													$("#idprov").val('...');
											},
											success:  function (response) {
													 $("#idprov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
 
 //----------------------------------------------
 
 
  jQuery('#articulo').typeahead({
 	    source:  function (query, process) {
        return $.get('../model/AutoCompleteProdFac.php', { query: query }, function (data) {
         		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
			 
	        });
	    } 
	});

  $("#articulo").focusin(function(){
		 
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
 
  