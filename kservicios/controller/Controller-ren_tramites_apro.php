<script type="text/javascript" src="formulario_result.js"></script> 	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    
 	
 	
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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ren_tramites_seg.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;         
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
      
 
         
         $datos   =  array();
         
         $cboton2 = '<b>Razon Social</b>';

         $MATRIZ = array(
            'N'    => 'No',
            'S'    => 'Si'
        );

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
  
    
 
       
                $this->BarraHerramientas();
                
                $this->set->div_panel6('<b>1. INFORMACION PRINCIPAL </b>');
                
                     $this->obj->text->text_yellow('<b>Servicios</b>',"texto" ,'referencia' ,85,85, $datos ,'required','readonly','div-2-10') ;

                     $this->obj->text->text_yellow('Nro.Comprobante',"texto",'comprobante',0,10,$datos,'','readonly','div-2-10') ;
                  
                     $this->obj->text->text_blue('Nro.Transaccion',"number",'id_ren_tramite',0,10,$datos,'','readonly','div-2-4') ;
                    

                     $this->obj->text->text('Fecha Tramite',"date" ,'fecha_inicio' ,80,80, $datos ,'required','','div-2-4') ;
                
                     $this->obj->text->text_blue('Estado',"texto" ,'estado' ,5,5, $datos ,'required','readonly','div-2-4') ;                   
                    
                    $this->obj->text->text('Fecha Emision',"date" ,'fecha_aprobacion' ,80,80, $datos ,'','readonly','div-2-4') ;

                    $this->obj->text->text_blue('Fecha Cierre',"date" ,'fecha_cierre' ,80,80, $datos ,'','readonly','div-2-4') ;

                    $this->obj->text->text('Ultimo Pago',"number" ,'apago' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                $this->set->div_panel6('fin');
                
                $this->set->div_panel6('<b>2. SOLICITA SERVICIO </b>');
                
                        $this->obj->text->textautocomplete('<b>Identificacion</b>','texto','idprov',13,13,$datos ,'required',' ','div-2-4') ;
                        
                        $this->obj->text->text('CIU',"number" ,'id_par_ciu' ,80,80, $datos ,'required','readonly','div-2-4') ;
                         
                        $this->obj->text->textautocomplete($cboton2,"texto",'razon',40,45,$datos,'required','','div-2-10');
                        
                        $this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','','div-2-10') ;
                        
                        $this->obj->text->text('Correo Electronico','texto','correo',120,120,$datos ,'required','','div-3-9') ;

                        $this->obj->text->text('Contacto/Representante Legal','texto','contacto',120,120,$datos ,'required','','div-3-9') ;

                
                $this->set->div_panel6('fin');


                $this->set->div_panel6('<b>3. MONTOS COMPLEMENTARIOS </b>');
                        
                            $this->obj->text->text_yellow('<b>Monto</b>',"number" ,'base' ,80,80, $datos ,'required','','div-2-4') ;
                            
                            $this->obj->list->lista('Aplica Multa',$MATRIZ,'multa',$datos,'required','','div-2-4');

                            $this->obj->text->text('Fecha Pago',"date" ,'fecha_pago' ,80,80, $datos ,'','readonly','div-2-4') ;

                           
                           echo '<div class="col-md-6" style="padding-bottom: 5px;padding-top: 5px;padding-left:120px;padding-right: 10px">
                                <button type="button" title= "GUARDE LA INFORMACION PREVIO A LA SIMULACION DE LOS VALORES A PAGAR!!!" onclick="SimularEmision()" class="btn btn-danger">Simulación   Apagar</button>
                                </div>';
 
                $this->set->div_panel6('fin');


                  
                $this->set->div_panel6('<b>4. INFORMACION DEL SERVICIO </b>');
                
                        $this->obj->text->editor('Detalle','detalle',2,45,350,$datos,'required','','div-2-10') ;
                        
                        $this->obj->text->text('Resolucion','texto','resolucion',200,200,$datos ,'required','','div-2-10') ;

                 
                $this->set->div_panel6('fin');
                
               
              
                    
                
               echo '<div class="col-md-12"><div id="ViewFormDetalle"> </div></div>';
                
                 
         $this->obj->text->texto_oculto("action",$datos); 

         $this->obj->text->texto_oculto("id_rubro",$datos); 
 
         
         $this->set->_formulario('-','fin'); 
 
   }
  
  //----------------------------------------------------......................-------------------------------------------------------------
    function BarraHerramientas(){
 
 
 
   
   $formulario_reporte   = '../reportes/requerimiento';
   
   $eventoi              = "imprimir_informe('".$formulario_reporte."')";
    
   $eventop              = "enviar_informacion()";

   $formulario_reporte1   = '../reportes/requerimientopdf';

   $eventop1    = "imprimir_informe('".$formulario_reporte1."')";
   
   $formulario_impresion = '../view/cliente';

   $eventoc              = 'openView('."'".$formulario_impresion."')";
   
   $eventoa              = "anular_informacion()";

    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Descargar Informe', evento =>$eventop1,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button_info"),
                array( boton => 'Contibuyentes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                array( boton => 'APROBAR INSPECCION - REGISTRO DE DATOS', evento =>$eventop,  grafico => 'glyphicon glyphicon-flash' ,  type=>"button_success"),
                array( boton => 'Anular/Cierre Transaccion', evento =>$eventoa,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger"),
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

    													 $("#id_par_ciu").val( response.c ); 

    													 $("#direccion").val( response.d ); 
    													 
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

											 $("#id_par_ciu").val( response.c ); 

											 $("#direccion").val( response.d ); 
									} 
							});

});
 
</script>
  