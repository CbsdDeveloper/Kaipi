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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
    
               $this->evento_form = '../model/Model-ga_contrato.php' ;        // eventos para ejecucion de editar eliminar y agregar 
      }
   //-----------------------------------------------------------------------------------------------------------
       function Formulario( ){
      

         $titulo = '';
         
         $datos = array();
         
  
         $this->set->_formulario( $this->evento_form,'inicio' ); 
    
                $tipo   = $this->bd->retorna_tipo();
        
                $evento = '';

                $MATRIZ_tipo = $this->obj->array->catalogo_tipo_contrato();

                $MATRIZ      = $this->obj->array->catalogo_compras();

                $MATRIZ_obra= $this->obj->array->catalogo_estado_contrato();

                $this->BarraHerramientas();
          
                $this->set->div_label(12,'<b>Informacion Principal</b>');	
                
                            $this->obj->text->text('Codigo',"number" ,'idcontrato' ,80,80, $datos ,'required','readonly','div-2-4') ;
                            
                            $this->obj->text->text_yellow('Nro Contrato',"texto" ,'nro_contrato' ,80,80, $datos ,'required','','div-2-4') ;
                            
                            $this->obj->list->listae('Tipo',$MATRIZ_tipo,'tipo_contratacion',$datos,'','',$evento,'div-2-10');
                            
                            $this->obj->list->listae('Proceso',$MATRIZ,'forma_contratacion',$datos,'','',$evento,'div-2-10');
                            
                            $this->obj->text->editor('Objeto','detalle_contrato',3,45,550,$datos,'required','','div-2-10') ;
                            
                            $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                $this->set->div_label(12,'<b>Informacion Adicional</b>');	
                
           
                        $this->obj->text->textautocomplete('Proveedor/Contratista',"texto",'razon',40,45,$datos,'required','','div-2-4');
                        
                        $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                        
                        $this->obj->text->text_blue('Monto Contrato',"number" ,'monto_contrato' ,80,80, $datos ,'required','','div-2-4') ;
                        $this->obj->text->text('Plazo(dias)',"number" ,'dias_vigencia' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        
                        $this->obj->text->text('Fecha Inicio',"date" ,'fecha_inicio' ,80,80, $datos ,'required','','div-2-4') ;
                        $this->obj->text->text('Fecha Fin',"date" ,'fecha_fin' ,80,80, $datos ,'required','','div-2-4') ;
                        
                        
                        $this->obj->text->editor('Forma Pago','canticipo',3,45,550,$datos,'required','','div-2-10') ;
                        $this->obj->text->text_yellow('Monto Anticipo',"number" ,'monto_anticipo' ,80,80, $datos ,'required','','div-2-4') ;
                 
                $this->set->div_label(12,'<b>Informacion Unidad requirente</b>');	
                 
                        
                        $resultado = $this->bd->ejecutar_unidad();     // funcion que trae la informacion de las unidades de la institucion
                        $this->obj->list->listadb($resultado,$tipo,'Unidad','iddepartamento',$datos,'required','','div-2-4');
                
                        $resultado = $this->bd->ejecutar_usuario('S');     // funcion que trae la informacion de los usuarios del sistema
                        $this->obj->list->listadb($resultado,$tipo,'Responsable','sesion_responsable',$datos,'required','','div-2-4');
                
                
               $this->set->div_label(12,'<b>Informacion Seguimiento Contrato</b>');	
               
                         $this->obj->list->lista('Estado',$MATRIZ_obra,'estado',$datos,'required','','div-2-4');
                        
                        $this->obj->text->text_yellow('Fecha Finalizacion',"date" ,'fecha_acta' ,80,80, $datos ,'required','','div-2-4') ;
                            
                        $this->obj->text->editor('Novedad','novedad',3,45,550,$datos,'required','','div-2-10') ;
               
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
          
  
         $this->set->_formulario('-','fin'); 
  
 
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
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
 
  
</script>