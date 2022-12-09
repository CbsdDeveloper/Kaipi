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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-controlAnticipo.php'; 
   
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
                 
 
                $this->obj->text->editor('Detalle','detalle',3,45,300,$datos,'required','','div-1-11') ;
           
 
                $this->obj->text->text_blue('Beneficiario',"texto",'proveedor',125,125,$datos,'','readonly','div-1-7');

                $this->obj->text->text_blue('Plazo',"number",'base',0,10,$datos,'','','div-1-3') ;

                $this->obj->text->text_yellow('Monto Solicitado',"number",'apagar',0,10,$datos,'','','div-1-3') ;

                
                $this->set->div_label(12,'<h6> Detalle de Asientos<h6>');


                $resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE ANTICIPO ]' as nombre
                union
                SELECT cuenta as codigo, cuenta || ' ' || detalle as nombre
                              FROM co_plan_ctas
                              where  univel = 'S' and cuenta like '112.01%' and 
                                     anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true). " and 
                                     registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );



                $this->obj->list->listadb($resultado,$tipo,'Anticipo','idanticipo',$datos,'required','','div-1-5');  



                $resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE BANCO ]' as nombre
                union
                SELECT cuenta as codigo, cuenta || ' ' || detalle as nombre
                              FROM co_plan_ctas
                              where tipo_cuenta = 'B' and univel = 'S' and
                                  anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true). " and 
                                  registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );



                $this->obj->list->listadb($resultado,$tipo,'Banco','idbancos',$datos,'required','','div-1-5');  
              
               
                      
         $this->obj->text->texto_oculto("tipo",$datos); 

         $this->obj->text->texto_oculto("id_tramite",$datos); 

         $this->obj->text->texto_oculto("action",$datos); 
         
           
         $this->obj->text->texto_oculto("nomina",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'javascript:aprobacion('."'".$this->formulario.'?action=aprobacion'."'".')';
   	
 
   	$formulario_impresion = $this->bd->_impresion_carpeta('54');
   	$eventop = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   
 
   	    	
  
   	
   	$formulario_impresion = $this->bd->_impresion_carpeta('55');
   	$eventopp = 'javascript:impresion_pago('."'".$formulario_impresion."','".'id_asiento'."')";
   	
 
   	$eventoe = "javascript:ExportarExcel()";
   	
   
   	
    $ToolArray = array( 
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		     array( boton => 'Aprobar asientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
     	     	 array( boton => 'Reporte diario contable', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
    		     array( boton => 'Exportar a excel', evento =>$eventoe,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button_default") 
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
 
  