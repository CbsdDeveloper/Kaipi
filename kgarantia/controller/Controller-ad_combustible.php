<script type="text/javascript" src="formulario_result.js"></script> 	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
      private $obj;
      private $bd;
      private $set;
      
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
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
    
               $this->evento_form = '../model/Model-ad_combustible.php' ;       
      }
  
      //---------------------------------------
      
     function Formulario( ){
      
          
         $tipo   = $this->bd->retorna_tipo();
         $datos  = array();
       
         
         $datos['uso'] = 'S';  //'Uso para Movilizacion'
         
         $this->set->_formulario( $this->evento_form,'inicio' ); 
 
                $this->BarraHerramientas();
                      
                $this->set->div_panel6('<b> CONTROL DE VEHICULO  </b>');
                 
                        $this->obj->text->text('Codigo',"number" ,'id_combus' ,80,80, $datos ,'required','readonly','div-2-4') ;
                     
                        $this->obj->text->text('Bien',"number" ,'id_bien' ,80,80, $datos ,'required','readonly','div-2-4') ;
                        
                        
                        $this->set->div_label(12,'Registro de Operador');
                        
                        $this->obj->text->textautocomplete('<b>OPERADOR</b>',"texto",'chofer_vehiculo',40,45,$datos,'required','','div-2-10');
                        
                        
                        $this->obj->text->text('Identificacion','texto','id_prov',10,10,$datos ,'','readonly','div-2-10') ;
                        
                        $this->set->div_label(12,'Vehiculo/Maquinaria');
                        
                         
                        $this->obj->text->text_blue('<b>Vehiculo</b>','texto','nombre_vehiculo',10,10,$datos ,'','readonly','div-2-10') ;
                        
                        $this->obj->text->text_blue('<b>Codigo Vehiculo</b>','texto','codigo_veh',10,10,$datos ,'','readonly','div-2-4') ;
                          
                         $this->obj->text->text_blue('<b>Nro.Placa</b>','texto','placa_vehiculo',10,10,$datos ,'','readonly','div-2-4') ;
                        
                        $this->obj->text->text_blue('<b>Km. Actual</b>',"entero" ,'u_km' ,80,80, $datos ,'required','readonly','div-2-4') ;
                        
                        $this->obj->text->text_yellow('Km.Registro',"entero" ,'u_km_inicio' ,80,80, $datos ,'required','','div-2-4') ;
                        
                         $this->obj->text->text('Salida',"texto" ,'ubicacion_salida' ,80,80, $datos ,'required','','div-2-10') ;
                        
                $this->set->div_panel6('fin');
                
                $this->set->div_panel6('<b> CONTROL DE COMBUSTIBLE </b>');
                
                        $this->obj->text->text_yellow('<b>Comprobante</b>','texto','referencia',10,10,$datos ,'required','','div-2-10') ;
                        
                        
                        $this->obj->text->text_blue('<b>Estado</b>','texto','estado',10,10,$datos ,'required','readonly','div-2-10') ;
                    
                       
                 
                        $this->obj->text->texto_oculto("uso",$datos); 
                        
                
                        $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                        $this->obj->text->text('Hora',"texto" ,'hora_in' ,80,80, $datos ,'required','','div-2-4') ;
                        
                      
                        $MATRIZ = array(
                            'GALON'    => 'GALON',
                            'CANECA'    => 'CANECA'
                        );
                        $evento     ='Onchange="habilita_campo(this.value)"';
                        $this->obj->list->listae('Unidad',$MATRIZ,'medida',$datos,'','',$evento,'div-2-4');
                        
                        $this->obj->text->text_blue('Nro.Canecas',"entero" ,'cantidad_ca' ,80,80, $datos ,'','readonly','div-2-4') ;
                        
                        $this->set->div_label(12,' ');
                        
                                
                        $evento     ='Onchange="monto_combustible(this.value)"';
                        $resultado = $this->bd->ejecutar_catalogo('COMBUSTIBLE','texto');
                       
                        
                        $this->obj->list->listadbe($resultado,$tipo,'Combustible','tipo_comb',$datos,'required','',$evento,'div-2-10');
                        
                        $this->obj->text->text_yellow('Costo',"float" ,'costo' ,80,80, $datos ,'required','','div-2-4') ;
                         
                        $this->obj->text->text_yellow('Nro.Galones(*)',"float" ,'cantidad' ,80,80, $datos ,'required','','div-2-4') ;

                        $this->obj->text->text_yellow('Galones $',"float" ,'total_consumo' ,80,80, $datos ,'','readonly','div-2-4') ;
                        
                        $this->obj->text->text('IVA $',"float" ,'iva' ,80,80, $datos ,'','readonly','div-2-4') ;
                        
                        $this->obj->text->text('Total $',"float" ,'total_iva' ,80,80, $datos ,'','readonly','div-2-4') ;
                        
                     
                    
                $this->set->div_panel6('fin');
                
                
             
                       
               $this->obj->text->texto_oculto("action",$datos); 
         
          
               $this->set->_formulario('-','fin'); 
  
 
      
   }
  
   //----------------------------------------------
   function BarraHerramientas(){
 
       
       $formulario_reporte = '../reportes/orden_combustible';
       
       $eventoi = "imprimir_informe('".$formulario_reporte."')";
       
       $eventoe = "EnvioDato()";
       $eventoa = "Autorizar()";
       
       $eventoa = "Notificar()";
       
       $ToolArray = array(
           array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
           array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
           array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
           array( boton => 'NOTIFICAR Y ENVIAR ORDEN DE COMBUSTIBLE', evento =>$eventoe,  grafico => 'glyphicon glyphicon-send' ,  type=>"button_info"),
           array( boton => 'AUTORIZAR ORDEN DE COMBUSTIBLE', evento =>$eventoa,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
           array( boton => 'ENVIAR NOTIFICACION', evento =>$eventoa,  grafico => 'glyphicon glyphicon-envelope' ,  type=>"button_success")
       );
       
       $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  

}

///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>

<script type="text/javascript">

 jQuery.noConflict(); 
 
 jQuery('#chofer_vehiculo').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#chofer_vehiculo").focusout(function(){
	 
	 var itemVariable = $("#chofer_vehiculo").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											beforeSend: function () {
												$("#id_prov").val('...');
											},
											success:  function (response) {
												$("#id_prov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
  
  
</script>
  