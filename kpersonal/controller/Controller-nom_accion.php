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
                
                $this->hoy 	     =  date("Y-m-d");   
        
                $this->anio       =  $_SESSION['anio'];
              
   
               $this->evento_form = '../model/Model-nom_accion.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){
      
 
        $datos = array();

        $tipo  = $this->bd->retorna_tipo();

        $MATRIZ = array(
            'Decreto'    => 'Decreto',
            'Acuerdo'    => 'Acuerdo',
            'Resolucion'    => 'Resolucion',
            'Reglamento'    => 'Reglamento',
            'Otros'    => 'Otros',
        );

     //   $MATRIZ_M =    $this->obj->array->catalogo_accion();	// lista de valores
        
        $MATRIZ_S = array(
             'N'    => 'Digitado',
            'S'    => 'Aprobado',
            'X'    => 'Anulado',
        );

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
     
        $MATRIZ1 = array(
             'N'    => 'NO',
            'S'    => 'SI'
         );

        $this->BarraHerramientas();
 
        $this->set->div_panel6('<h6> Informacion Personal del Funcionario<h6>');
                
                            $this->obj->text->text_blue('Transaccion',"number" ,'id_accion' ,80,80, $datos ,'required','readonly','div-2-10') ;

                            $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-10') ;
                            
                            $this->obj->text->text_blue('Nro.Documento',"texto" ,'comprobante' ,80,80, $datos ,'required','readonly','div-2-10') ;
                            
                            $this->obj->text->textautocomplete('Funcionario',"texto",'razon',40,45,$datos,'required','','div-2-10');
                            
                            $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-10') ;
        
 
                            $this->obj->text->text_blue('Referencia',"texto" ,'referencia' ,250,250, $datos ,'required','','div-2-4') ;
              
                            $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'required','','div-2-4');
                            

        $this->set->div_panel6('fin');
        
        $this->set->div_panel6('<h6> Detalle de la Accion de Personal <h6>');
        
                            $this->obj->list->lista('Estado',$MATRIZ_S,'estado',$datos,'required','disabled','div-2-4');
                            
                            $this->obj->list->lista('Finalizado',$MATRIZ1,'finalizado',$datos,'required','readonly','div-2-4');



                            $resultado =  $this->combo_lista("nom_accion_lista");
                            
                            $evento    = 'OnChange="ValidaAccion(this.value)"';
                            $this->obj->list->listadbe($resultado,$tipo,'Motivo','motivo',$datos,'required','',$evento,'div-2-10');

 
                            $this->obj->text->text('Rige',"date" ,'fecha_rige' ,80,80, $datos ,'required','','div-2-4') ;
                            
                            $this->obj->text->text('Hasta',"date" ,'ffinalizacion' ,80,80, $datos ,'','','div-2-4') ;
                        
                            
                            $this->obj->text->editor('Explicación','novedad',6,175,730,$datos,'required','','div-2-10') ;
                            
         
        $this->set->div_panel6('fin');
        
        
        
        $this->set->div_panel6('<h6> Situacion Actual del Funcionario <h6>');
        
        
                            $resultado =  $this->combo_lista("nom_regimen");
                            $this->obj->list->listadb($resultado,$tipo,'Regimen laboral','regimen',$datos,'required','','div-2-10');
                            
                            $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
                            $this->obj->list->listadb($resultado,$tipo,'Programa','programa',$datos,'required','','div-2-10');
                            
                            $resultado =  $this->combo_lista("nom_departamento");
                            $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamento',$datos,'required','','div-2-10');
                            
                            $resultado =  $this->combo_lista("nom_cargo");
                            $this->obj->list->listadb($resultado,$tipo,'Cargo','id_cargo',$datos,'required','','div-2-10');
                    
                            $this->obj->text->text_blue('Sueldo',"number" ,'sueldo' ,80,80, $datos ,'required','','div-2-10') ;
        
        $this->set->div_panel6('fin');
         

        
        $this->set->div_panel6('<h6> Situacion Propuesta del Funcionario <h6>');
        
                            
                            $resultado =  $this->combo_lista("nom_regimen");
                            $this->obj->list->listadb($resultado,$tipo,'Regimen laboral','p_regimen',$datos,'required','','div-2-10');
                            
                            $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
                            $this->obj->list->listadb($resultado,$tipo,'Programa','p_programa',$datos,'required','','div-2-10');
                            
                            $resultado =  $this->combo_lista("nom_departamento");
                            $this->obj->list->listadb($resultado,$tipo,'Unidad','p_id_departamento',$datos,'required','','div-2-10');
                            
                            $resultado =  $this->combo_lista("nom_cargo");
                            $this->obj->list->listadb($resultado,$tipo,'Cargo','p_id_cargo',$datos,'required','','div-2-10');
                    
                            $this->obj->text->text_blue('Sueldo',"number" ,'p_sueldo' ,80,80, $datos ,'required','','div-2-10') ;
                            
        
        $this->set->div_panel6('fin');

        
                
        $this->set->div_panel6('<h6> Información Base Legal <h6>');

                    $datos['baselegal'] = '- ART. 16.- ATRIBUCIONES DEL DIRECTOR GENERAL NUMERAL 13./ ORDENANZA MUNICIPAL - ART. 17.- CLASES DE NOMBRAMIENTO.-LITERAL C) DE LIBRE NOMBRAMIENTO Y REMOCIÓN /LOSEP - ART. 17.- CLASES DE NOMBRAMIENTO.-LITERAL C) DE LIBRE NOMBRAMIENTO Y REMOCIÓN / REGLAMENTO GENERAL DE LA LOSEP';


                    $this->obj->text->editor('Base Legal','baselegal',5,1000,1000,$datos,'required','','div-2-10') ;
                
                
        $this->set->div_panel6('fin');

              


        $this->set->div_panel6('<h6> Responsable Autorización Acción de Personal / Solo para uso de acción definida por el usuario  <h6>');

 
        $resultado1 =  $this->combo_lista("nom_accion_res");
        $this->obj->list->listadb($resultado1,$tipo,'Responsable/Dirección','idprovc',$datos,'required','','div-3-9');
     

        $this->obj->text->editor('Observacion','observacion',5,550,550,$datos,'','','div-3-9') ;

    
        $this->set->div_panel6('fin');


        
         $this->obj->text->texto_oculto("otro",$datos); 

         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
   $evento1 = 'Aprobar();';
    
   $evento2 = 'Cierre();'; 

   $evento3 = 'Revertir();'; 
    
   $formulario_reporte = '../../reportes/accion';
   
   $eventoi = "javascript:openFile('".$formulario_reporte."')";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_info"),
                array( boton => 'Aprobar Accion de Personal ', evento =>$evento1,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_primary"),
                array( boton => 'Finalizar Accion de Personal ', evento =>$evento2,  grafico => 'glyphicon glyphicon-alert' ,  type=>"button_danger"),
                array( boton => 'Revertir Accion de Personal ', evento =>$evento3,  grafico => 'glyphicon glyphicon-retweet' ,  type=>"button_default"),
            );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
 
  //----------------------------------------------
  function combo_lista($tabla ){
      
      if  ($tabla == 'presupuesto.pre_catalogo'){
          
          $sql ="SELECT ' - ' as codigo,' --- 00.Sin Programa  --- ' as nombre union
                        SELECT codigo as codigo, detalle as nombre
                            FROM  presupuesto.pre_catalogo
                            WHERE estado = 'S' and  categoria = ".$this->bd->sqlvalue_inyeccion('programa'  ,true)."
                        order by 1"   ;
          
          
          
          $resultado = $this->bd->ejecutar($sql);
          
          
          
      }


 
      
   if  ($tabla == 'nom_accion_lista'){
          
        $sql ="SELECT '-' as codigo,' --- 00. NO APLICA --- ' as nombre union
                      SELECT nombre as codigo,   nombre
                          FROM nom_accion_lista
                          WHERE activo = 'S' 
                      order by 2"   ;
        
        
        
        $resultado = $this->bd->ejecutar($sql);
        
        
        
    }

    if  ($tabla == 'nom_accion_res'){
          
        $sql ="SELECT '-' as codigo,' - ' as nombre union
                      SELECT idprov as codigo,  razon || ' - ' || cargo AS nombre
                          FROM view_nomina_rol
                          WHERE responsable = 'S' and estado = 'S'
                      order by 2"   ;
        
        
        
        $resultado = $this->bd->ejecutar($sql);
        
        
        
    }

      
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
											url:   '../model/AutoCompleteIDCIUNom_accion.php',
											type:  'GET' ,
											dataType: "json",
											success:  function (response) {
												
													 $("#idprov").val( response.a );  
													 
													 $("#programa").val( response.c );  
													 $("#id_departamento").val( response.d );  
													 $("#id_cargo").val( response.e );  
													 $("#sueldo").val( response.f );

													 var regimen = response.b
													 $("#regimen").val( regimen.trim() );    
													 $("#p_regimen").val( regimen.trim()  );
													   
													 $("#p_programa").val( response.c );  
													 $("#p_id_departamento").val( response.d );  
													 $("#p_id_cargo").val( response.e );  
													 $("#p_sueldo").val( response.f );  
													    
													    
											} 
									});
	 
    });
 
 
</script>
  