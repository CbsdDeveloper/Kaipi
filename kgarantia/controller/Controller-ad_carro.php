<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fat, #fo3').submit(function() {
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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ad_carro.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
     
     function Formulario( ){
      
         
         
         $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
         
         $datos = array();
         
         $this->BarraHerramientas();
         
         $this->set->div_panel('<b> INFORMACION VEHICULOS</b>');
         
         echo '<ul  id="mytabs_1"  class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">1. Informacion Basica</a></li>
                    <li><a data-toggle="tab" href="#menu1">2. Custodios Actual</a></li>
                    <li><a data-toggle="tab" href="#menu3">3. Documenta e historial Bien</a></li>
                    <li><a data-toggle="tab" href="#menu4">4. Componentes Adicionales</a></li>
                </ul>';
         
         //--------------------------------------------------------------------------------
         // TAB 1
         //--------------------------------------------------------------------------------
         echo '<div class="tab-content"><div id="home" class="tab-pane fade in active"  style="padding: 10px;">';
         
         echo   '<div class="col-md-12" id="secuencia" style="background-color:#ededed;padding-bottom:5px;padding-top:5px"></div>';
         
         $this->tab_1_datos_bienes( );
         
         echo '</div>';
         //--------------------------------------------------------------------------------
         // TAB 2
         //--------------------------------------------------------------------------------
         
         echo '<div id="menu1" class="tab-pane fade" style="padding: 20px;">';
         
         $this->tab_3_custodios();
         
         echo '</div>';
         
         //--------------------------------------------------------------------------------
         // TAB 4
         //--------------------------------------------------------------------------------
         echo '<div id="menu3" class="tab-pane fade" style="padding: 25px;">';
         
         $this->tab_4_graficos();
         
         echo '</div>';
         
         //--------------------------------------------------------------------------------
         // TAB 4
         //--------------------------------------------------------------------------------
         echo '<div id="menu4" class="tab-pane fade" style="padding: 25px;">';
         
         $this->tab_5_componentes();
         
         echo '</div></div>';
         
         
         $this->obj->text->texto_oculto("action",$datos);
         
         
         $this->obj->text->texto_oculto("cuenta_parametro",$datos);
         
         
         $this->obj->text->texto_oculto("idproveedor",$datos);
         
         
         $this->set->div_panel('fin');
         
         
         $this->set->_formulario('-','fin');
         
 
  
 
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 function K_ejecuta_detalle($div){
    
  echo '<script type="text/javascript"> goToPrecio(); </script>';
 
 
  } 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
       $formulario_impresion = '../reportes/fichaActivo';
       $eventoi = 'javascript:url_ficha('."'".$formulario_impresion."')";
   
    $ToolArray = array( 
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    //----------------------------------------------
  function tab_2_caracteristicas( ){
      
      $datos = array();
      
      
      /*
       $MATRIZ = array(
       'Bienes Muebles'    => 'Bienes Muebles',
       'Vehiculos'    => 'Vehiculos',
       'Inmuebles'    => 'Inmuebles',
       'Informatica'    => 'Informatica',
       'Libros y Colecciones'    => 'Libros y Colecciones',
       'Bienes Artisticos'    => 'Bienes Artisticos'
       );
       
       */
      
      
      $this->set->div_panel6('<b> CARACTERISTICAS ESPECIFICAS DEL BIEN</b>');
      
      
      $this->obj->text->editor('Caracteristicas','detalle',4,250,250,$datos,'','','div-2-10');
      
      $MATRIZ = array(
          'N'    => 'No',
          'S'    => 'SI'
      );
      $evento='';
      $this->obj->list->listae('Garantia',$MATRIZ,'garantia',$datos,'','',$evento,'div-2-10');
      
      
      $MATRIZ = array(
          '0'    => 'No aplica',
          '6'    => '6 Meses',
          '12'    => '12 Meses',
          '24'    => '24 Meses',
          '36'    => '36 Meses',
          '48'    => '48 Meses'
      );
      
      $this->obj->list->listae('Tiempo',$MATRIZ,'tiempo_garantia',$datos,'','',$evento,'div-2-10');
      
      
      
      
      $this->obj->text->text('Tramite','texto','id_tramite',10,10,$datos ,'','readonly','div-2-10') ;
      
     
      
      $this->set->div_panel6('fin');
      
       
     
      

      
      
  }
  //----------------------------------------------
  function tab_1_datos_bienes( ){
      
      
      $datos = array();
      
      $tipo = $this->bd->retorna_tipo();
      
      
      
      $this->set->div_panel6('INFORMACION FINANCIERA BIEN');
      
                  $this->obj->text->text_yellow('Codigo Bien',"number",'id_bien',40,45,$datos,'','readonly','div-2-10') ;
                  $MATRIZ = array(
                      'Individual'    => 'Individual',
                      'Lote'    => 'Lote'
                  );
                  $evento='';
                  $this->obj->list->listae('Ingreso',$MATRIZ,'forma_ingreso',$datos,'','disabled',$evento,'div-2-10');
                  
                  $MATRIZ = array(
                      'BLD'    => 'Bienes de larga duracion',
                      'BCA'    => 'Bienes de control administrativo'
                  );
                  $this->obj->list->listae('Tipo Bien',$MATRIZ,'tipo_bien',$datos,'','disabled',$evento,'div-2-10');
                  
                  $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'','readonly','div-2-10');
                  
                  $cadena = '#';
                  $cadena_titulo = 'Catalogo Bien';
                  
                  $cadena = '#';
                  $cboton = ' ';
                  $this->obj->text->text($cadena_titulo.$cboton,"texto",'clase_esigef',40,45,$datos,'','','div-2-10');
                  
                 
                   
                  $resultado = $this->sql(1);
                  $this->obj->list->listadbe($resultado,$tipo,'<b>Contable</b>','cuenta',$datos,'','disabled',$evento,'div-2-10');
                   
                 
                  
      $this->set->div_panel6('fin');
      
      $this->obj->text->texto_oculto("clasificador",$datos);
      $this->obj->text->texto_oculto("identificador",$datos);
      $this->obj->text->texto_oculto("id_marca",$datos);
      
      
      $this->set->div_panel6('IDENTIFICACION DEL VEHICULO');
 
                  $this->obj->text->text_yellow('<b>Clase</b>',"texto",'clase',40,45,$datos,'','readonly','div-2-10');
             
                  $this->obj->text->text_blue('<b>Nro.Placa</b>',"texto",'placa_ve',35,35,$datos,'','','div-2-10');
                  
                  
                  $MATRIZ = array(
                      'Bueno'    => 'Bueno',
                      'Malo'    => 'Malo',
                      'Regular'    => 'Regular'
                  );
                  $this->obj->list->lista('<b>Estado</b>',$MATRIZ,'estado',$datos,'','','div-2-10');
      
                  $MATRIZ = array(
                      'Asignado'    => 'Asignado',
                      'Libre'    => 'Libre',
                      'En Taller'    => 'En Taller',
                      'Fuera de Servicio'    => 'Fuera de Servicio',
                  );
                  $this->obj->list->lista('<b>Status</b>',$MATRIZ,'status',$datos,'required','','div-2-10');
                  
                      
                  
                  $MATRIZ = array(
                      'Automovil'    => 'Automovil',
                      'Camion'    => 'Camion',
                      'Camioneta'    => 'Camioneta',
                      'Motocicleta'    => 'Motocicleta'
                  );
                  $this->obj->list->lista('<b>Tipo Vehiculo</b>',$MATRIZ,'tipo_vehiculo',$datos,'required','','div-2-10');
                  
                    
                  
                  
                  $this->obj->text->text_blue('<b>Km.Actual</b>',"number",'u_km',35,35,$datos,'required','','div-2-10');
      
      $this->set->div_panel6('fin');
      
      
      $this->set->div_panel6('<b> DETALLE VEHICULO</b>');
      
      $this->obj->text->text_blue('Clase Vehiculo',"texto",'clase_ve',35,35,$datos,'','','div-2-10');
      $this->obj->text->text('Nro.Chasis',"texto",'chasis_ve',35,35,$datos,'','','div-2-10');
      $this->obj->text->text('Nro.Motor',"texto",'motor_ve',35,35,$datos,'','','div-2-10');
      
      
      $this->obj->text->text_blue('Anio Fabrica',"texto",'anio_ve',35,35,$datos,'','','div-2-10');
      $this->obj->text->text_blue('Color',"texto",'color_ve',35,35,$datos,'','','div-2-10');
      
      
      $this->obj->text->textautocomplete('Marca '.$cboton,"texto",'marca',40,45,$datos,'','','div-2-10');
      
      $cadena = 'javascript:open_spop_modelo('."'".'admin_modelo'."','".''."',".'680,350)';
      $cboton = '<a href="'.$cadena.'"><img src="../../kimages/cnew.png"/></a>';
      
      $resultado = $this->sql(2);
      $this->obj->list->listadbe($resultado,$tipo,'Modelo '.$cboton,'id_modelo',$datos,'required','',$evento,'div-2-10');
      
      
      $this->set->div_panel6('fin');
      
      
      
      $this->set->div_panel6('IDENTIFICACION INFORMACION ADICIONAL DEL VEHICULO');
      
                  
                  $this->obj->text->text_blue('<b>Codigo Interno</b>',"texto",'codigo_veh',35,35,$datos,'required','','div-2-10');
      
      
                  $this->obj->text->texto_oculto("serie",$datos);
                  
                  $this->obj->text->text_blue('<b>Año Matricula</b>',"texto",'umatricula',35,35,$datos,'','required','div-2-10');
      
                  $this->obj->text->editor('Detalle','descripcion',3,70,100,$datos,'','','div-2-10');
                  
                  
                  $MATRIZ = array(
                      'Libre'    => 'Libre',
                      'Asignado'    => 'Asignado',
                      'Baja'    => 'Baja',
                  );
                  $this->obj->list->lista('Uso',$MATRIZ,'uso',$datos,'','disabled','div-2-10');
                  
                  
                  $MATRIZ = array(
                      'Acta de Entrega - Recepcion'    => 'Acta de Entrega - Recepcion',
                      'Acta Trasferencia de Bienes'    => 'Acta Trasferencia de Bienes',
                      'Acta Baja de Bienes'    => 'Acta Baja de Bienes'
                  );
                  $this->obj->list->lista('Documento',$MATRIZ,'clase_documento',$datos,'','disabled','div-2-10');
                  
                  $MATRIZ = array(
                      'Factura'    => 'Factura',
                      'Nota de Venta'    => 'Nota de Venta',
                      'Liquidacion de Compras'    => 'Liquidacion de Compras',
                      'Otros'    => 'Otros'
                  );
                  $this->obj->list->listae('Comprobante',$MATRIZ,'tipo_comprobante',$datos,'','disabled',$evento,'div-2-10');
                  
                  $this->obj->text->text('Fecha',"date",'fecha_comprobante',15,15,$datos,'','readonly','div-2-10');
      
      $this->set->div_panel6('fin');
      
      
      $this->set->div_panel6('REFERENCIA ADQUISICION BIEN');
      
      
    
      $this->obj->text->text('Adquisicion',"date",'fecha_adquisicion',15,15,$datos,'','readonly','div-3-9');
      $this->obj->text->text('Proveedor',"texto",'proveedor',40,45,$datos,'','readonly','div-3-9');
      $this->obj->text->text('Factura',"texto",'factura',20,20,$datos,'','readonly','div-3-9');
      $this->obj->text->text_yellow('Monto Adquisicion','number','costo_adquisicion',10,10, $datos ,'','readonly','div-3-9');
      
      
      $this->set->div_panel6('fin');
      
      //-----------------------------------------------------
      $this->set->div_panel6('Valores establecidos para el bien');
      
      $MATRIZ = array(
          'N'    => 'NO',
          'S'    => 'SI',
      );
      $this->obj->list->lista('Bien Depreciado',$MATRIZ,'depreciacion',$datos,'','disabled','div-3-9');
      $this->obj->text->text('Ultima Depreciacion','number','anio_depre',10,10, $datos ,'','readonly','div-3-9') ;
      $this->obj->text->text('Vida Util','number','vida_util',10,10, $datos ,'','readonly','div-3-9') ;
      $this->obj->text->text('Valor Residual','number','valor_residual',10,10, $datos ,'','readonly','div-3-9') ;
      $this->obj->text->text('Codigo Anterior',"texto",'codigo_actual',20,20,$datos,'','readonly','div-3-9') ;
      
      $this->set->div_panel6('fin');
      
      
      $this->tab_2_caracteristicas();
      
      
      
  }
  //-----------------------------
  function tab_3_custodios( ){
      
      
      $datos = array();
      
      $tipo = $this->bd->retorna_tipo();
      
      $this->obj->text->text_yellow('Custodio',"texto",'razon',40,45,$datos,'','readonly','div-2-4');
      
      $this->obj->text->text_yellow('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
      
      $resultado = $this->bd->ejecutar("select 0 as codigo, '[ 0. No aplica ]' as nombre  union
                                          select id_departamento as codigo, nombre
                                            from nom_departamento
                                            where  estado=". $this->bd->sqlvalue_inyeccion('S',true).' order by 2'
          );
      
      
   
      
      $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'','disabled','div-2-4');
      
      
      $MATRIZ = array(
          'Institucion'    => 'Institucion',
          'Exterior'    => 'Exterior'
      );
      $this->obj->list->lista('Ubicado en',$MATRIZ,'tipo_ubicacion',$datos,'','','div-2-4');
      
      $this->obj->text->texto_oculto("idsede",$datos);
      
      $this->obj->text->text('Detalle Ubicacion','texto','detalle_ubica',250,250,$datos ,'','','div-2-10') ;
      
      
      $MATRIZ = array(
          'N'    => 'NO',
          'S'    => 'SI'
      );
      $this->obj->list->lista('Acta generada?',$MATRIZ,'tiene_acta',$datos,'','disabled','div-2-4');
      
      
      
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
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
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
	
 jQuery("#razon").focusout(function(){
	 
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
</script>
 
  