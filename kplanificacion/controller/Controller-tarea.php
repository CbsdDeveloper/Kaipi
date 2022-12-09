<script >// <![CDATA[

   jQuery.noConflict(); 



   
	   // InjQueryerceptamos el evento submit
	    jQuery('#fo4').submit(function() {
	  		// Enviamos el formulario usando AJAX
	        jQuery.ajax({
	            type: 'POST',
	            url: jQuery(this).attr('action'),
	            data: jQuery(this).serialize(),
	            // Mostramos un mensaje con la respuesta de PHP
	            success: function(data) {
	               
	           	   jQuery('#resultadoTarea').html('<div class="alert alert-info">'+ data + '</div>');
	               jQuery( "#resultadoTarea" ).fadeOut( 1600 );
	               jQuery("#resultadoTarea").fadeIn("slow");
	            
	               
				}
	        })        
	        return false;
	    }); 

 
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
       private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                 
                $this->sesion 	 =  $_SESSION['login'];
                
               $this->formulario = 'Model-OO-tarea.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
       function Formulario( ){

    
     	$this->set->_formulario_id( $this->evento_form,'inicio','fo4' ); // activa ajax para insertar informacion
           
        $this->BarraHerramientas();
        
        $datos = array();
        
        echo ' <ul class="nav nav-pills" id= "mytabs_tarea"> 
        <li class="active"><a data-toggle="tab" href="#home_tarea">&nbsp;1. GESTION&nbsp;</a></li>
        <li><a data-toggle="tab" href="#menu1_tarea">&nbsp;2. RECURSOS ($)&nbsp;</a></li>
        <li><a data-toggle="tab" href="#menu3_tarea">&nbsp; ENLACE GESTION ADMIN - FINAN&nbsp;</a></li>
        <li><a data-toggle="tab" href="#menu2_tarea">&nbsp; NOVEDAD/COMENTARIO &nbsp;</a></li>
       
       </ul>';
    
       echo '<div class="tab-content">
        <div id="home_tarea" class="tab-pane fade in active">';
          $this->tarea();
       echo '</div>
      <div id="menu1_tarea" class="tab-pane fade">';
        $this->tareadetalle( );
        echo '</div>
        <div id="menu2_tarea" class="tab-pane fade">';
          $this->novedad_tarea( );
          echo '</div>';
  
  echo '<div id="menu3_tarea" class="tab-pane fade">';
          $this->adicional_tarea( );
          echo '</div>
   </div>';
          
             
        $this->obj->text->texto_oculto("actionTarea",$datos); 
                
        $this->obj->text->texto_oculto("programa_unidad",$datos); 
                    
        $this->set->_formulario_id('-','fin',''); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
     
       $eventoi = "javascript:window.print();";
 
   
       $eventoa              = "anular_informacion()";

       
       if ( $this->EstadoPoa() > 0){
           
           $ToolArray = array(
               array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
               array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
               array( boton => 'Eliminar Transaccion', evento =>$eventoa,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger"),
           );
           
           
       }else {
           
           
           $ToolArray = array(
               array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
           );
       }
       
       $this->obj->boton->ToolMenuDivId($ToolArray,'resultadoTarea');
 
 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function tarea( ){
  	
  
    $datos = array();
      
    $evento =' ';
    
    $tipo = $this->bd->retorna_tipo();
    

    
    $this->set->div_label(12,' ');	 
    
    $resultado =  $this->sql('IDACTIVIDAD1');
    $this->obj->list->listadb($resultado,$tipo,'Actividad','idactividad_tarea',$datos,'required','','div-2-10');
    
    
    $this->obj->text->editor('Tarea','tarea',3,250,250,$datos,'','','div-2-10');
    
    
    $this->obj->text->textautocomplete('Tarea Responsable',"texto",'nombre_funcionario',40,45,$datos,'required','','div-2-10');
    
    $this->obj->text->text('Identificacion','texto','responsable',10,10,$datos ,'required','readonly','div-2-4') ;
    
    
    $MATRIZ = array(
        'S'    => 'SI',
        'N'    => 'NO'
    );
    $this->obj->list->listae('Publica',$MATRIZ,'estado1',$datos,'','',$evento,'div-2-4');
    
   
    
    
    
    
    
    $this->obj->text->text('Inicio',"date" ,'fechainicial' ,80,80, $datos ,'required','','div-2-4') ;
    $this->obj->text->text('Final',"date" ,'fechafinal' ,80,80, $datos ,'required','','div-2-4') ;
    
    
    $evento = ' onChange="PoneBoton()" ';
    $MATRIZ = array(
        ''  => 'Seleccionar  ',
        'S'    => 'SI',
        'N'    => 'NO'
    );
    $this->obj->list->listae('Recurso?',$MATRIZ,'recurso',$datos,'','',$evento,'div-2-4');
   
/*
    echo '<div class="col-md-12" style="padding-top: 5px;" align="center">
    <button type="button" id="BotDet" name = "BotDet" class="btn btn-sm btn-primary" onClick="habilitaperiodo()">
   <i class="icon-white icon-plus"></i>&nbsp; SIGUIENTE PASO &nbsp;
   </button>
</div>';*/
    
    $this->obj->text->texto_oculto("idtarea",$datos); 
   
    $this->obj->text->texto_oculto("anio_tarea",$datos); 
  	 
  }
  //------
  function novedad_tarea( ){
  	
  
    $datos = array();
      
    $this->set->div_label(12,' ');	 
    
    $this->obj->text->editor('Agregar Justificacion','justificacion',5,250,250,$datos,'','','div-2-10');

     
  	 
  }
  //----------------------
  function adicional_tarea( ){
      
      $this->set->div_label(12,' ');	 
      
      $datos    = array();
      $evento   = '';
      $tipo     = $this->bd->retorna_tipo();
         
      $MATRIZA = array(
          '-'             => '-- Seleccionar Modulo -- ',
          'requerimiento' => 'PROCESO DE CONTRATACIÓN',
          'tareas'       => 'SEGUIMIENTO DE ACTIVIDADES SIN RECURSOS',
          'viaticos'        => 'GESTIÓN DE CONTROL DE VIÁTICOS',
          'nomina'      => 'GESTIÓN DE PAGOS DE NÓMINA E INGRESOS COMPLEMENTARIOS',
          'caja'      => 'GESTIÓN DE OTROS GASTOS PLANIFICADOS (sin contratación)',
      );
      
      
      
      $this->obj->list->listae('<b>Módulo</b>',$MATRIZA ,'modulo',$datos,'required','',$evento,'div-2-10') ;
      
      
      
      $resultado =  $this->sql('PAC');
      $evento    = "Onchange='PonePac()'";
      $this->obj->list->listadbe($resultado,$tipo,'Matriz PAC','enlace_pac',$datos,'','',$evento,'div-2-10');
      
      
      $this->obj->text->editor('Detalle','tareapac',3,250,250,$datos,'','readonly','div-2-10');
      
      $this->set->div_label(12,'Enlace Financiero ');	 
      
      $resultado =  $this->sql('PROGRAMA');
      $evento    = "Onchange='PoneActividad(this.value)'";
      $this->obj->list->listadbe($resultado,$tipo,'Programa','programa',$datos,'','',$evento,'div-2-10');
      
      $resultado =  $this->sql('ACTIVIDAD');
      $this->obj->list->listadb($resultado,$tipo,'Actividad','actividad_tarea',$datos,'','','div-2-10');
      
    
      
     
      
  }
  //----------------------------------------------
  function tareadetalle( ){
  	
      $this->set->div_label(12,' ');	 
 
      $datos = array();
      
      $evento =' ';
      
      $tipo = $this->bd->retorna_tipo();
      
      
      $evento =' onChange="BuscaCatalogo(this.value,1)" ';
      $resultado =  $this->sql('GRUPO');
      $this->obj->list->listadbe($resultado,$tipo,'Grupo','clasificador1',$datos,'required','',$evento,'div-2-4');
      
   /*
      $evento =' onChange="BuscaCatalogo(this.value,2)" ';
      $resultado =  $this->sql('SUBGRUPO');
      $this->obj->list->listadbe($resultado,$tipo,'SubGrupo','clasificador2',$datos,'required','',$evento,'div-2-4');
     
     */
  	
      $this->set->div_label(12,' ');	 
   
  
   
   $resultado =  $this->sql('CLASIFICADOR');
   $this->obj->list->listadb($resultado,$tipo,'Item/Clasificador','clasificador',$datos,'required','','div-2-10');
   
    
   $evento =' onChange="TotalSuma()" ';
   
   $this->obj->text->texte('Enero',"number" ,'m1' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Febrero',"number" ,'m2' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Marzo',"number" ,'m3' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Abril',"number" ,'m4' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   
   $this->obj->text->texte('Mayo',"number" ,'m5' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Junio',"number" ,'m6' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Julio',"number" ,'m7' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Agosto',"number" ,'m8' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   
   $this->obj->text->texte('Septiembre',"number" ,'m9' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Octubre',"number" ,'m10' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Noviembre',"number" ,'m11' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   $this->obj->text->texte('Diciembre',"number" ,'m12' ,80,80, $datos ,'required','readonly',$evento,'div-2-4') ;
   
   
   $this->obj->text->text('TOTAL',"number" ,'TOTALPOA1' ,80,80, $datos ,'required','readonly','div-2-4') ;
  	
   
  	
  	$this->obj->text->texto_oculto("TOTALPOA",$datos); 
  	
  }
  
  //----------------------------------------------
  function sql($titulo){
  	
   
  	if ( $titulo == 'CLASIFICADOR'){
  		
  	    $sqlb = "SELECT  '-' as codigo, '[ 0. No aplica ]'  AS nombre  union
               SELECT  codigo, (codigo || ' ' || detalle) as nombre
              	FROM presupuesto.pre_catalogo
              	where tipo = 'arbol' and subcategoria = 'gasto' and nivel = 5 and pac = 'S' order by 1 ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  		
  	}
  	
  	
  	if ( $titulo == 'PROGRAMA'){
  	    
  	    $sqlb = "SELECT  '-' as codigo, '[ 0. No aplica ]'  AS nombre  union
               SELECT  codigo, (codigo || ' ' || detalle) as nombre
              	FROM presupuesto.pre_catalogo
              	where tipo= 'catalogo' and categoria = 'programa'    order by 1 ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  	    
  	}
  	
  	
  	if ( $titulo == 'ACTIVIDAD'){
  	    
  	    $sqlb = "SELECT  '-' as codigo, '[ 0. No aplica ]'  AS nombre  union
               SELECT  codigo, (codigo || ' ' || detalle) as nombre
              	FROM presupuesto.pre_catalogo
              	where tipo= 'catalogo' and categoria = 'actividad'    order by 1 ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  	    
  	}
  	
  	
  	if ( $titulo == 'GRUPO'){
  	    
  	    $sqlb = "SELECT  '-' as codigo, '[ 0. No aplica ]'  AS nombre  union
               SELECT  codigo, (codigo || ' ' || detalle) as nombre
              	FROM presupuesto.pre_catalogo
              	where tipo = 'arbol' and subcategoria = 'gasto' and nivel = 2  order by 1 ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  	    
  	}
  	
 
  	
  	
  	if ( $titulo == 'SUBGRUPO'){
  	    
  	    $sqlb = "SELECT  '-' as codigo, '[ 0. No aplica ]'  AS nombre  union
               SELECT  codigo, (codigo || ' ' || detalle) as nombre
              	FROM presupuesto.pre_catalogo
               	where tipo = 'arbol' and subcategoria = 'gasto' and nivel = 3  order by 1 ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  	    
  	}
  	
  	
  	
  	if ( $titulo == 'IDACTIVIDAD1'){
  	    $sqlb = "SELECT  0 as codigo, '[ 0. Matriz Actividades ]'  AS nombre  ";
  	    $resultado = $this->bd->ejecutar($sqlb);
  	}
  	
  	if ( $titulo == 'FUNCIONARIO'){

  	    $sqlb = "SELECT  ' ' as codigo, '- 0. Matriz Funcionarios -'  AS nombre  union
           	    SELECT idprov as codigo ,razon as nombre 
          	    FROM view_nomina_user
          	    where responsable = 'S' order by 2";
         
 
              	    
  	    $resultado = $this->bd->ejecutar($sqlb);
 	}
  	
  	return $resultado;		
  	
 
  }
  
///------------------------------------------------------------------------
  // estado poa
  function EstadoPoa(   ){
      
      
      $AUnidad = $this->bd->query_array('presupuesto.pre_periodo',
          'count(*) as nn',
          'tipo = '.$this->bd->sqlvalue_inyeccion('elaboracion',true)
          );
      
      $valida = 0;
      
      if ( $AUnidad['nn']  > 0 ){
          $valida = 1;
      }
      
      
      return $valida ;
      
  }
///------------------------------------------------------------------------
  }
  
  
  $gestion   = 	new componente;
  
  $gestion->Formulario( );
  
 ?>
    <script src="../../app/js/bootstrap3-typeahead.min.js"></script>  
 <script>

  jQuery.noConflict(); 
	 
   jQuery('#nombre_funcionario').typeahead({
  	    source:  function (query, process) {
          return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
          		console.log(data);
          		data = $.parseJSON(data);
  	            return process(data);
  	        });
  	    } 
  	});
  	
   jQuery("#nombre_funcionario").focusout(function(){
  	 
  	 var itemVariable = $("#nombre_funcionario").val();  
  	 
          		var parametros = {
  											"itemVariable" : itemVariable 
  									};
  									 
  									$.ajax({
  											data:  parametros,
  											url:   '../model/AutoCompleteIDCIU.php',
  											type:  'GET' ,
  											beforeSend: function () {
  												$("#responsable").val('...');
  											},
  											success:  function (response) {
  												$("#responsable").val(response);  // $("#cuenta").html(response);
  													  
  											} 
  									});
  	 
      });
 	 </script>


 
  
 
