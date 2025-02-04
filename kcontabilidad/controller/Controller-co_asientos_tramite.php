<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
        
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-co_asientos.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        
      }
       //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){
      
          $datos = array();
         
          $this->set->_formulario( $this->evento_form,'inicio' );  
   
     
                $this->BarraHerramientas();
                
                
                $resultado = $this->bd->ejecutar("select id_periodo as codigo, (mesc || '-' || anio)  as nombre
                    							       from co_periodo
                    							      where  anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true)." and
                                                            registro=".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                                                    order by 1 desc');
                
                $tipo = $this->bd->retorna_tipo();
                
                
                
                $this->obj->list->listadb($resultado,$tipo,'Periodo','id_periodo',$datos,'','disabled','div-1-3');
                
                $this->obj->text->text('Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-1-3') ;
                
                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-1-3');
                
                
                $this->obj->text->text('Comprobante',"texto",'comprobante',15,15,$datos,'required','readonly','div-1-3');
                
                $this->obj->text->text('Referencia',"texto",'documento',15,15,$datos,'required','','div-1-3');
                
                $this->obj->text->text('Estado',"texto",'estado',15,15,$datos,'','readonly','div-1-3');
                
                $MATRIZ =  $this->obj->array->catalogo_con_tipoa();
                $evento =  '';
                $this->obj->list->listae('Tipo',$MATRIZ,'tipo',$datos,'required','',$evento,'div-1-7');
                
                
                $cadena = '<a onClick="buscatramite()" data-toggle="modal" data-target="#myModalGastoDev" href="#">Tramite</a>';
                
                $this->obj->text->text($cadena,"texto",'id_tramite',15,15,$datos,'required','','div-1-3');
                
                $this->obj->text->editor('Detalle','detalle',3,45,300,$datos,'required','','div-1-11') ;
          
                $this->obj->text->textautocomplete('Cuenta',"texto",'txtcuenta',150,150,$datos,'','','div-1-5');
               
                
                $evento = 'onClick="AgregaCuenta()"';
                
                $cboton1 = 'Agregar <a href="#" '.$evento.' title="Agregar Cuenta"><img src="../../kimages/cnew.png"/></a>';
                
                $this->obj->text->textautocomplete($cboton1,"texto",'cuenta',15,15,$datos,'','','div-1-5');
 
                 
                $this->set->div_label(12,'<h6> Detalle de Asientos<h6>');
 
                $this->obj->text->text_blue('Auxiliar',"texto",'proveedor',125,125,$datos,'','readonly','div-1-5');
                
                echo '<div class="col-md-6">
                 <a href="#" title= "Ver Lista de Auxiliares registrados" onClick="VerBeneficiarios()"  data-toggle="modal" data-target="#myModalprov">
                 <img src="../../kimages/03_.png" align="absmiddle"/> Listar Auxiliares</a>  &nbsp; &nbsp;
                 <a href="#" title= "Ver Comprobantes electronicos emitidos relacionados" onClick="BusquedaGrillaFactura(oTableFactura)"  data-toggle="modal" data-target="#myModalfactura">
                 <img src="../../kimages/3p.png" align="absmiddle" /> Comprobante Retencion </a>  &nbsp; &nbsp;
                <a href="#" title= "Ver Enlaces" onClick="AbrirEnlace()">
                <img src="../../kimages/05_.png" align="absmiddle"/> Verificar Enlace Presupuestario </a>  &nbsp; &nbsp;
                <a href="#" title= "Verificar Enlaces Presupuestarios  Ingresos" data-toggle="modal" data-target="#myModalIngresos">
                 <img src="../../kimages/5p.png" align="absmiddle"/> Enlace Ingresos</a>  &nbsp; &nbsp;
                </div>';
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
           
         $this->obj->text->texto_oculto("nomina",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento               = 'aprobacion_estado()';
   	$formulario_impresion = '../view/proveedor';
   	$eventope             = 'modalVentana('."'".$formulario_impresion."')";
   	
    	
   
   	
    $ToolArray = array( 
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		    array( boton => 'Cambiar de estado asientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                array( boton => 'Proveedor', evento =>$eventope,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default")  
    );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
  }  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
 ///------------------------------------------------------------------------
 ///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
   
  $gestion->Formulario( );
  
 ?>
 <script type="text/javascript">

 jQuery.noConflict(); 
 
 jQuery('#txtcuenta').typeahead({
	    source:  function (query, process) {
        return $.get('../model/ajax_CtaContable.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

 jQuery('#cuenta').typeahead({
	    source:  function (query, process) {
     return $.get('../model/ajax_CtaCuenta.php', { query: query }, function (data) {
     		console.log(data);
     		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
 
 
  $("#txtcuenta").focusout(function(){
	 
	 var itemVariable = jQuery("#txtcuenta").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/ajax_Cuenta.php',
											type:  'GET' ,
											beforeSend: function () {
													$("#cuenta").val('...');
											},
											success:  function (response) {
													 $("#cuenta").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });	   

  $("#cuenta").focusin(function(){
		 
		 var itemVariable = jQuery("#cuenta").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/ajax_CuentaNombre.php',
												type:  'GET' ,
												beforeSend: function () {
														$("#txtcuenta").val('...');
												},
												success:  function (response) {
														 $("#txtcuenta").val(response);  // $("#cuenta").html(response);
														  
												} 
										});
		 
	    });	   
 
 
   
</script>
 
  