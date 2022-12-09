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
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
            	  jQuery('#result').html(data.resultado);
            	  
 				  jQuery( "#result" ).fadeOut( 1600 );
 				  
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  
 			 	  jQuery("#id_bien").val(data.id );


            
			}
        })        
        return false;
    }); 
 })
</script>
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';  
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php';  
  
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
                
               $this->formulario = 'Model-ac_bienes.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //---------------------------------------
      
     function Formulario( ){
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
        $datos = array();
    
                $this->BarraHerramientas();
           
 
                
               echo '<ul  id="mytabs_1"  class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">1. Registro de Revalorizacion</a></li>
                    <li><a data-toggle="tab" href="#menu2">2. Informacion Basica</a></li>
                    <li><a data-toggle="tab" href="#menu3">3. Historial Documental Bien</a></li>
                 </ul>';
                
                //--------------------------------------------------------------------------------
                // TAB 1
                //--------------------------------------------------------------------------------
                echo '<div class="tab-content"><div id="home" class="tab-pane fade in active"  style="padding: 10px;">';
 		                
                         $this->tab_3_custodios();
                           
                   
         		echo '</div>';
        	 
        		//--------------------------------------------------------------------------------
        		// TAB 3
        		//--------------------------------------------------------------------------------
        		echo '<div id="menu2" class="tab-pane fade" style="padding: 20px;">';
        		
        		       $this->tab_1_datos_bienes( );
              
        		echo '</div>';
        		//--------------------------------------------------------------------------------
        		// TAB 4
        		//--------------------------------------------------------------------------------
        		echo '<div id="menu3" class="tab-pane fade" style="padding: 25px;">';
        		
        	           	$this->tab_4_graficos();
        		 
        	   echo '</div></div>';
        		
        	 
      				
		                   
         $this->obj->text->texto_oculto("action",$datos); 
         $this->obj->text->texto_oculto("codigo_actual",$datos); 
         
     
         $this->obj->text->texto_oculto("depreciacion",$datos);
         $this->obj->text->texto_oculto("anio_depre",$datos); 
         
         $this->obj->text->texto_oculto("vida_util",$datos);
         $this->obj->text->texto_oculto("valor_residual",$datos); 
         
         
 
 
         $this->obj->text->texto_oculto("cuenta_parametro",$datos); 
         
 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       
       $formulario_impresion = '../reportes/fichaActivo';
       $eventoi = 'javascript:url_ficha('."'".$formulario_impresion."')";
 
        
       
    $ToolArray = array( 
                    array( boton => 'Nuevo Regitro Tramite',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                    array( boton => 'Ficha Tecnica', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") 
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 //--------------------
  
  //----------------------------------------------
  function tab_1_datos_bienes( ){
      
 
      $datos = array();
      
      $tipo = $this->bd->retorna_tipo();
      
     
      $this->set->div_panel6('<b> DATOS DEL BIEN </b>');
      
   
      $MATRIZ = array(
          'Individual'    => 'Individual',
          'Lote'    => 'Lote'
      );
      $evento='';
      $this->obj->list->listae('Forma',$MATRIZ,'forma_ingreso',$datos,'','disabled',$evento,'div-2-10');
      $MATRIZ = array(
          'BLD'    => 'Bienes de larga duracion',
          'BCA'    => 'Bienes de control administrativo'
      );
      $this->obj->list->listae('Tipo',$MATRIZ,'tipo_bien',$datos,'','disabled',$evento,'div-2-10');
      $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','readonly','div-2-10');
  
      
      $this->obj->text->editor('Bien','descripcion',3,70,100,$datos,'','readonly','div-2-10');
      
      $this->obj->text->texto_oculto("clasificador",$datos);
      $this->obj->text->texto_oculto("identificador",$datos);
 
      
       
      $this->set->div_panel6('fin');
    
         
      
      $this->set->div_panel6('<b> CUSTODIOS ADMINISTRATIVOS </b>');
      
              $this->obj->text->textautocomplete('Custodio',"texto",'razon',40,45,$datos,'required','readonly','div-2-10');
              
              $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;
              
              $resultado = $this->bd->ejecutar("select 0 as codigo, '[ 0. No aplica ]' as nombre  union
                                                              select id_departamento as codigo, nombre
                                                                from nom_departamento
                                                                where  estado=". $this->bd->sqlvalue_inyeccion('S',true).' order by 2'
                  );
              
              $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'required','disabled','div-2-10');
               
              $MATRIZ = array(
                  'Institucion'    => 'Institucion',
                  'Exterior'    => 'Exterior'
              );
              $this->obj->list->lista('Ubicado en',$MATRIZ,'tipo_ubicacion',$datos,'','disabled','div-2-10');
              
              $resultado = $this->bd->ejecutar("select idsede as codigo, nombre
                                                                from activo.view_sede_user
                                                                where  sesion=". $this->bd->sqlvalue_inyeccion(   $this->sesion,true).' order by 2'
                  );
              
              $this->obj->list->listadb($resultado,$tipo,'Ubicacion','idsede',$datos,'required','disabled','div-2-10');
               
              $this->obj->text->text('Detalle','texto','detalle_ubica',250,250,$datos ,'required','readonly','div-2-10') ;
              
              $MATRIZ = array(
                  'N'    => 'NO',
                  'S'    => 'SI'
              );
              $this->obj->list->lista('Acta?',$MATRIZ,'tiene_acta',$datos,'','disabled','div-2-10');
      
      $this->set->div_panel6('fin');
      
      $this->set->div_panel6('<b>Referencia de la Adquisicion</b>');
        
                      $MATRIZ = array(
                          'Acta de Entrega - Recepcion'    => 'Acta de Entrega - Recepcion',
                          'Acta Trasferencia de Bienes'    => 'Acta Trasferencia de Bienes',
                          'Acta Baja de Bienes'    => 'Acta Baja de Bienes'
                      );
                      $this->obj->list->lista('Documento',$MATRIZ,'clase_documento',$datos,'required','disabled','div-2-10');
                      $MATRIZ = array(
                          'Factura'    => 'Factura',
                          'Nota de Venta'    => 'Nota de Venta',
                          'Liquidacion de Compras'    => 'Liquidacion de Compras',
                          'Otros'    => 'Otros'
                      );
                      $evento = '';
                      $this->obj->list->listae('Tipo',$MATRIZ,'tipo_comprobante',$datos,'required','disabled',$evento,'div-2-10');
                      $this->obj->text->text('Fecha',"date",'fecha_comprobante',15,15,$datos,'required','readonly','div-2-4');
                      $this->obj->text->text('Adquisicion',"date",'fecha_adquisicion',15,15,$datos,'required','readonly','div-2-4');
                     
                      $this->obj->text->textautocomplete('Proveedor',"texto",'proveedor',40,45,$datos,'','readonly','div-2-10');
                      $this->obj->text->text('RUC',"texto",'idproveedor',13,13,$datos,'required','readonly','div-2-4');
                      $this->obj->text->text('Nro.Factura',"texto",'factura',9,9,$datos,'required','readonly','div-2-4');
                      $this->obj->text->text('Costo','number','costo_adquisicion',10,10, $datos ,'required','readonly','div-2-4');
      
      //-------------------------------------------------------------------------------
     //-------------------------------------------------------------------------------
      $this->obj->text->texto_oculto("id_tramite",$datos); 
      
      $this->set->div_panel6('fin');
   
          //-----------------------------------------------------
      $this->set->div_panel6('<b>Identificacion del Bien</b>');
      
              $this->obj->text->textautocomplete('Marca',"texto",'marca',40,45,$datos,'','readonly','div-2-10');
              $this->obj->text->texto_oculto("id_marca",$datos);
              $evento    = '';
              $resultado = $this->sql(2);
              $this->obj->list->listadbe($resultado,$tipo,'Modelo','id_modelo',$datos,'required','disabled',$evento,'div-2-10');
              $this->obj->text->text('Serie',"texto",'serie',35,35,$datos,'required','readonly','div-2-10');
              $MATRIZ = array(
                  'Libre'    => 'Libre',
                  'Asignado'    => 'Asignado',
                  'Baja'    => 'Baja',
              );
              $this->obj->list->lista('Asigna',$MATRIZ,'uso',$datos,'','disabled','div-2-10');
             
      
  
       $this->set->div_panel6('fin');
              
      
      
  
      echo '<div class="col-md-12" style="padding-top: 15px" align="center">
                <button type="button" onClick="siguiente('."'menu3'".')"  class="btn btn-primary">SIGUIENTE PAGINA</button></div> ';
      
       
      
  }  
 //-----------------------------
  function tab_3_custodios( ){
      
 
      $datos = array();
      
      $tipo = $this->bd->retorna_tipo();
      
 
       $this->set->div_panel12('<b> DATOS DEL BIEN </b>');
                  
                
                  $this->obj->text->textautocomplete('Grupo',"texto",'clase_esigef',40,45,$datos,'','readonly','div-1-5');
                  $evento = '';

                  $this->obj->text->textautocomplete('Clase',"texto",'clase',40,45,$datos,'','readonly','div-1-5');
                  $resultado = $this->sql(1);
                  $this->obj->list->listadbe($resultado,$tipo,'Cuenta','cuenta',$datos,'required','disabled',$evento,'div-1-5');
                  $MATRIZ = array(
                      'Bueno'    => 'Bueno',
                      'Malo'    => 'Malo',
                      'Regular'    => 'Regular'
                  );
                  $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','disabled','div-1-5');
      
                  $this->obj->text->text('CodigoBien',"number",'id_bien',40,45,$datos,'required','readonly','div-1-5') ;
       
      $this->set->div_panel12('fin');
      
      $this->set->div_panel12('<b> HISTORIAL REVALORIZACION BIEN</b>');
                                       
                 echo '<div id="ViewFormReval"> </div>';
      
      $this->set->div_panel12('fin');
 
      echo '<div class="col-md-12" style="padding-top: 15px" align="center">
                <button type="button" onClick="siguiente('."'menu2'".')"  class="btn btn-primary">INFORMACION DEL BIEN</button></div> ';
      
  }
 //-------------------
  function tab_4_graficos( ){
      
      echo '<div class="panel panel-default">
                                  <div class="panel-heading">Documentos complementarios</div>
                                    <div class="panel-body"> 
                                        <button type="button" class="btn btn-sm btn-default" onClick="openFile()" >  
										  Agregar Documentos complementarios </button>	
                                    </div>
                                  </div>
                                
                                 <div class="panel panel-default">
                                  <div class="panel-heading">Detalle de Documentos</div>
                                    <div class="panel-body"> 
                                        <div id="ViewFormfile"> </div>
                                    </div>
           </div>';
      
      
  }
  
  function tab_5_componentes( ){
      
      echo '<div class="panel panel-default">
                                  <div class="panel-heading">Componentes Adicionales</div>
                                    <div class="panel-body">
                                        <button type="button" class="btn btn-sm btn-default" onClick="openFileComponente()" >
										  Agregar Componentes adicionales</button>
                                    </div>
                                  </div>
                                      
                                 <div class="panel panel-default">
                                  <div class="panel-heading">Detalle de Documentos</div>
                                    <div class="panel-body">
                                        <div id="ViewFormComponentes"> </div>
                                    </div>
           </div>';
      
      
  }
  
  
  //----------------------------------------------
  function sql($titulo){
      
      if  ($titulo == 1){ 
  	    
  	 	   $sqlb = "Select '-' as codigo, '[01. Seleccione cuenta contable ]' as nombre   
                    union
                    SELECT  cuenta as codigo, (cuenta || '.'||  detalle) as nombre
                    FROM  co_plan_ctas
                    where tipo_cuenta = 'A' and 
                          univel = 'S'  and 
                          anio =".$this->bd->sqlvalue_inyeccion($this->anio , true)." and
                          estado =".$this->bd->sqlvalue_inyeccion('S', true).' order by 1';
	 		  	
  	}
  	
 
  	
  	if  ($titulo == 2){
  	    
  	    
  		$sqlb = "SELECT idmodelo  as codigo ,  nombre
		          FROM  web_modelo
                 where idmodelo = 0";
  		
 
  		
  	}
  	
 
  	
  	$resultado = $this->bd->ejecutar($sqlb);
  	
  	
  	return  $resultado;
  	
  }  
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>
<script type="text/javascript">

jQuery.noConflict(); 

jQuery(document).ready(function() {


	jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#razon").focusout(function(){
	 
	 var itemVariable = $("#razon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU_json.php',
											type:  'GET' ,
											beforeSend: function () {
												$("#idprov").val('...');
											},
											dataType: "json",
											success:  function (response) {
 
												var str = response.a;
												var prov = str.trim()
								
												 $("#idprov").val(prov);   
 
 												 $("#id_departamento").val( response.b ); 

 												 $("#idsede").val( response.c ); 
 												
												 
											} 
									});
	 
    });
 
 
 jQuery('#clase_esigef').typeahead(
		 {
	    minLength : 5,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/Model-ac_busca_indicador.php', { query: query  }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});


 
 jQuery('#clase').typeahead(
		 {
	    minLength : 5,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/Model-ac_busca_clase.php', { query: query   }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

 jQuery('#marca').typeahead(
		 {
	    minLength : 2,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/Model-ac_busca_marca.php', { query: query  }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 //-----------------------------------------
 $("#clase_esigef").focusout(function(){
	 
   var referencia = $("#clase_esigef").val();  

		var parametros = {
									"referencia" : referencia 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/Model_ac_auto_indicador.php',
									dataType: "json",
									success:  function (response) {
 										
											 $("#identificador").val( response.a );  
											 
											 $("#cuenta").val( response.b );  

											 $("#clasificador").val( response.c );  

											 $("#cuenta_parametro").val( response.b );  
 
											 $("#clase").val( response.d );   

											 VerVariables(response.b );
									} 
							});
	
});
 //-----------------------------------------
 $("#marca").focusout(function(){
	 
        var referencia = $("#marca").val();  
        var idmarca    = 0;  
        
		var parametros = {
									"referencia" : referencia 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/Model_ac_auto_marca.php',
									dataType: "json",
									success:  function (response) {
 											 $("#id_marca").val( response.a );  
											 ListaModelo( response.a ) 
 											   
									} 
							});
       //-------------------------------------------------------------------
 				
    });

//------------------------------------
 jQuery('#proveedor').typeahead(
		 {
	    minLength : 5,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/AutoCompleteCIU.php', { query: query   }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

 jQuery("#proveedor").focusout(function(){
	 
	 var itemVariable = $("#proveedor").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											success:  function (response) {
												var str = response;
 								
												$("#idproveedor").val(str);   
													  
											} 
									});
	 
    });
    //-------------------------------------------------------------------
				
 
 
	
});


 

</script>
   
  