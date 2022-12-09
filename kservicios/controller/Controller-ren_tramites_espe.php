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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ren_tramites_espe.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;         
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
     
      //---------------------------------------
      
     function Formulario( ){
      
 
         
         $datos   =  array();
         
         $cboton2 = '<b>Contribuyente</b>';

         $MATRIZ = array(
            'N'    => 'No',
            'S'    => 'Si'
        );

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
  
    
        $MATRIZE = array(
        'E'    => 'EMITIDO',
        'P'    => 'PAGADO',
        'A'    => 'ANULADO',
        );
        
       
                $this->BarraHerramientas();
                
                $this->set->div_panel6('<b>2. SOLICITA SERVICIO </b>');

 
                            $this->obj->text->text('Codigo',"number" ,'id_ren_movimiento' ,80,80, $datos ,'required','readonly','div-2-10') ;

                
                            $this->obj->text->textautocomplete('<b>Identificacion</b>','texto','idprov',13,13,$datos ,'required',' ','div-2-4') ;
                            
                            $this->obj->text->text('CIU',"number" ,'id_par_ciu' ,80,80, $datos ,'required','readonly','div-2-4') ;
                            
                            $this->obj->text->textautocomplete($cboton2,"texto",'razon',40,45,$datos,'required','','div-2-10');
                            
                            $this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','','div-2-10') ;
                            
                            $this->obj->text->text('Email','texto','correo',120,120,$datos ,'required','','div-2-10') ;
                            
                            $this->obj->list->listae('Estado',$MATRIZE,'estado',$datos,'required','readonly','','div-8-4');
                            
                          
                            
                            
                            echo ' <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px"> 
                                         <div class="alert alert-success">
                                          <strong>ADVERTENCIA!</strong> UNA VEZ GENERADA LA TRANSACCION DEBE PRESIONAR EL ICONO DE  
                                            <i class="glyphicon glyphicon-flash"> </i> 
                                            PARA PROCESAR EL PAGO Y LA SECUENCIA</span>
                                        </div> </div>';
        
              $this->set->div_panel6('fin');



                $this->set->div_panel6('<b>1. INFORMACION REQUERIMIENTO </b>');
                

           

                        $this->obj->text->text_blue('Nro.Especie',"texto" ,'comprobante' ,10,10, $datos ,'required','','div-2-4') ;   
                       


                  $evento = 'onkeyup="cambio_monto(this.value)"';

                     $this->obj->text->texte('Cantidad',"number" ,'cantidad' ,80,80, $datos ,'required','',$evento,'div-2-4') ;

                     $this->obj->text->text_yellow('Costo',"number" ,'costo' ,80,80, $datos ,'required','readonly','div-2-4') ;

                     $this->obj->text->text_blue(' <b>TOTAL</b>',"number" ,'base' ,80,80, $datos ,'required','readonly','div-2-4') ;

                    

                     $MATRIZ = array(
                        'efectivo'    => 'Efectivo',
                        'deposito'    => 'Deposito',
                        'trasferencia'    => 'trasferencia',
                    );
                            
                   
                            
                    $evento = '';
                         
                    $this->obj->list->listae('Forma Pago',$MATRIZ,'documento',$datos,'required','',$evento,'div-2-10');
                        
                    $evento = 'onkeyup="cambio_dato(this.value)"';
                                                                   
                    $this->obj->text->textLong('A Pagar',"number",'efectivo',15,15,$datos,'required','',$evento,'div-2-4');
 

                    $this->set->div_label(12,'Etiqueta');

                    $datos['detalle'] = 'CONTROL DE ESPECIES';

 

                    $this->obj->text->editor('Actividad/Detalle','detalle',2,45,350,$datos,'required','','div-3-9') ;
                 
                    $this->obj->text->text_blue('Formulario Permiso',"texto" ,'secuencial' ,10,10, $datos ,'required','','div-3-9') ;   


                    $this->obj->text->text('Codigo AutoInspeccion',"texto" ,'autorizacion' ,10,10, $datos ,'required','readonly','div-3-9') ;   


                    $this->set->div_label(12,'Información complementaria/Retira');

                    $this->obj->text->text('Detalle','texto','novedad',250,250,$datos ,'required','','div-2-10') ;



                    


                $this->set->div_panel6('fin');


                echo ' <div id="cambio"> </div>';
                
               
           
                $datos['referencia'] = 'E';
                 $datos['fecha_aprobacion'] =  $this->hoy 	;
                $datos['fecha_inicio'] =  $this->hoy 	;
          
                $datos['resolucion'] = 'EE-CONTROL';
                
                $this->obj->text->texto_oculto("enlace",$datos); 
           
                $this->obj->text->texto_oculto("referencia",$datos); 
            
                $this->obj->text->texto_oculto("fecha_aprobacion",$datos); 
                $this->obj->text->texto_oculto("fecha_inicio",$datos); 
                $this->obj->text->texto_oculto("fecha_cierre",$datos); 

               
                $this->obj->text->texto_oculto("resolucion",$datos); 

                $this->obj->text->texto_oculto("direccion_alterna",$datos); 
                
               
 
                
                 
         $this->obj->text->texto_oculto("action",$datos); 

         $this->obj->text->texto_oculto("id_rubro",$datos); 
 
         
         $this->set->_formulario('-','fin'); 
 
   }
  
  //----------------------------------------------------......................-------------------------------------------------------------
    function BarraHerramientas(){
 
 
 
   
   $formulario_reporte   = '../reportes/permiso_funcionamiento';
   
   $eventoi              = "imprimir_informe('".$formulario_reporte."')";
    
   $eventop              = "enviar_informacion()";
   
   $formulario_impresion = '../view/cliente';

   $eventoc              = 'openView('."'".$formulario_impresion."')";
   
 

   $eventocc  = "permiso_informacion()";

    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'GENERAR PROCESO DE PAGO', evento =>$eventop,  grafico => 'glyphicon glyphicon-flash' ,  type=>"button_success"),
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'Contibuyentes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                array( boton => 'Actualizar Permisos', evento =>$eventocc,  grafico => 'glyphicon glyphicon-cog' ,  type=>"button_default") 
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
  