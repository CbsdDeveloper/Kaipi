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
 
    
    class componente {
 
  
 
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
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
              
                $this->anio       =  $_SESSION['anio'];
                
                
               $this->formulario = 'Model-nom_vacaciones.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
 
      //---------------------------------------
      
     function Formulario( ){
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
                $datos = array();
    
                $this->BarraHerramientas();
                
                $DateAndTime = date('h:i', time());  

                $datos['hora_out'] =  $DateAndTime ;
                $datos['hora_in']  =  $DateAndTime ;
 
                
                $MATRIZ_ESTADO= array(
                    '1'    => 'Solicitado',
                    '2'    => 'Autorizado',
                    '3'    => 'Anulado',
                    '4'    => 'Enviado'
                );
                
                
                
                $this->set->div_panel7('<h6> Informacion Documento<h6>');
                
                                    $this->obj->text->text('Codigo','number','id_vacacion',10,10,$datos ,'','readonly','div-2-10') ;
                                    
                                    $datos['fecha'] =  date("Y-m-d");
                                    $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-10') ;
                                    
                                    
                                    $this->obj->text->textautocomplete('Funcionario',"texto",'razon',40,45,$datos,'required','','div-2-10');
                                    
                                    $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;
                                    
                                    
                                    $MATRIZ =  $this->obj->array->catalogo_tipoPermiso();
                                    $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'required','','div-2-10');
                                    
                                    
                                    $MATRIZ =  $this->obj->array->catalogo_motivoPermiso();
                                    $this->obj->list->lista('Motivo',$MATRIZ,'motivo',$datos,'required','','div-2-10');
                                    
                        
                                    $MATRIZ =  $this->obj->array->catalogo_sino();
                                    $this->obj->list->lista('Cargo Vacaciones',$MATRIZ,'cargoa',$datos,'required','','div-2-10');
                            
                                    
                                    $this->set->div_panel7('fin');
                                    
                                    $this->set->div_panel5('<h6> Informacion Periodo a solicitar<h6>');
                                
                                    
                                    $this->obj->text->text_yellow('Fecha Salida',"date" ,'fecha_out' ,80,80, $datos ,'required','readonly','div-3-9') ;
                                    $this->obj->text->text_yellow('Fecha Entrada',"date" ,'fecha_in' ,80,80, $datos ,'required','readonly','div-3-9') ;
                                   
                                 
                                    $this->obj->text->text_yellow('Hora Salida',"time" ,'hora_out' ,80,80, $datos ,'','readonly','div-3-9') ;
                                    $this->obj->text->text_yellow('Hora Entrada',"time" ,'hora_in' ,80,80, $datos ,'','readonly','div-3-9') ;

                                
                                    $this->obj->text->text_blue('Nro.dia(s)',"number" ,'dia_tomados' ,80,80, $datos ,'required','','div-3-9') ;
                                    $this->obj->text->text_blue('Fracción dia/hora',"number" ,'hora_tomados' ,80,80, $datos ,'','readonly','div-3-9') ;
                                    
                                    
                                    $this->obj->text->editor('Detalle','novedad',3,75,500,$datos,'required','','div-3-9') ;
                
                $this->set->div_panel5('fin');
                
                $this->set->div_panel7('<b>Parametro de validacion</b>');
      
                
                $this->obj->text->text_yellow('Nro.Dias Tomados',"number" ,'dia_acumula' ,80,80, $datos ,'required','readonly','div-3-9') ;
                
                $this->obj->text->text_blue('Nro.dia(s)',"number" ,'dia_tomados' ,80,80, $datos ,'required','readonly','div-3-9') ;
                
                $this->obj->text->text_blue('Fracción dia/hora',"number" ,'hora_tomados' ,80,80, $datos ,'required','readonly','div-3-9') ;
                
                $this->obj->list->lista('Estado',$MATRIZ_ESTADO,'estado',$datos,'required','readonly','div-3-9');
                 
               $this->set->div_panel7('fin');


               $this->set->div_panel5('<h6> USO EXCLUSIVO DE LA UNIDAD<h6>');
             
                
                            $MATRIZ = array(
                                '1'    => 'SOLICITADO',
                                '2'    => 'AUTORIZADO',
                                '4'    => 'ENVIADO',
                                '3'    => 'ANULADO'
                            );
                            
                                $this->obj->list->lista('<b>ESTADO</b>',$MATRIZ,'estado',$datos,'required','readonly','div-3-9');
                                
                                
                                $this->obj->text->editor('<b>COMENTARIO</b>','observacion',5,75,500,$datos,'required','','div-3-9') ;
                
                $this->set->div_panel5('fin');
                
 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
          
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
   $formulario_reporte = '../../reportes/Permiso';
   
   $eventoi = "openFile('".$formulario_reporte."')";
    
   $eventop = "notificar_permiso();";
   
   $eventoe = "anular_permiso();";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                array( boton => 'NOTIFICAR SOLICITUD', evento =>$eventop, grafico => 'glyphicon glyphicon glyphicon-send' ,  type=>"button_success") ,
                array( boton => 'ANULAR SOLICITUD', evento =>$eventoe, grafico => 'glyphicon glyphicon glyphicon-trash' ,  type=>"button_danger") 
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
   //----------------------------------------------
   function combodb(){
    
        $datos = array();
        
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
       
        $datos = array();
       
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
///------------------------------------------------------------------------
//----------------------------------------------
  function combo_lista($tabla ){
      
      if  ($tabla == 'presupuesto.pre_catalogo'){
          
          $sql ="SELECT ' - ' as codigo,' [ Sin Programa ]' as nombre union
                        SELECT codigo as codigo, detalle as nombre
                            FROM  presupuesto.pre_catalogo
                            WHERE estado = 'S' and  categoria = ".$this->bd->sqlvalue_inyeccion('programa'  ,true)."
                        order by 1"   ;
          
          
          
          $resultado = $this->bd->ejecutar($sql);
          
          
          
      }
      
      if  ($tabla == 'items'){
          
          $sql ="SELECT ' - ' as codigo,' [ Sin Clasificador ]' as nombre union
                         SELECT trim(clasificador) as codigo, ( clasificador || ' ' ||  detalle)  as nombre
                            FROM presupuesto.view_gasto_nomina_grupo
                            group by clasificador, detalle 
                            order by 1"   ;
          
          
          
          $resultado = $this->bd->ejecutar($sql);
          
          
          
      }
      
      //--------------------------------
      
      
      
      if  ($tabla == 'nom_departamento'){
          
          $resultado =  $this->bd->ejecutarLista("id_departamento,nombre",
              $tabla,
              "ruc_registro = ".$this->bd->sqlvalue_inyeccion( trim($this->ruc ) ,true),
              "order by 2");
              
      }
      
      if  ($tabla == 'nom_cargo'){
          
          $resultado =  $this->bd->ejecutarLista("id_cargo,nombre",
              $tabla,
              "-",
              "order by 2");
              
      }
      
      
      if  ($tabla == 'nom_regimen'){
          
          $resultado =  $this->bd->ejecutarLista("regimen,regimen",
              $tabla,
              "activo = ".$this->bd->sqlvalue_inyeccion('S' ,true),
              "order by 2");
              
      }
      
      
      
      
      return $resultado;
      
      
  } 
///------------------------------------------------------------------------
 }    
 
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
											url:   '../model/AutoCompleteIDCIUNom.php',
											type:  'GET' ,
											dataType: "json",
											success:  function (response) {
 
												
													 $("#idprov").val( response.a );  
													 
													 $("#dia_derecho").val( response.b );  

													 $("#dia_acumula").val( response.c );  
													  
											} 
									});
	 
    });
 
 
</script> 