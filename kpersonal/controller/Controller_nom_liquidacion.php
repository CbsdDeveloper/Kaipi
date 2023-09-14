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
              
   
               $this->evento_form = '../model/Model_nom_liquidacion.php';        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){
      
 
        $datos = array();

        $tipo  = $this->bd->retorna_tipo();

 
        $MATRIZ_M =    $this->obj->array->catalogo_accion();	// lista de valores
        
        $MATRIZ_S =    $this->obj->array->catalogo_sino();	// lista de valores

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
     
        /*
        SELECT idprov, anio, , salario, ingreso, salida, motivo, discapacidad, detalle,   FROM 
        public.nom_liq_cab;

        */
        $this->BarraHerramientas();

        $MATRIZ = array(
            'N'    => 'NO',
            'S'    => 'SI' 
        );

        $MATRIZM = array(
            'CONTRATO INDEFINIDO'    => 'CONTRATO INDEFINIDO' ,
            'DESPIDO INTEMPESTIVO'    => 'DESPIDO INTEMPESTIVO',
            'TERMINACION PERIODO DE PRUEBA'    => 'TERMINACION PERIODO DE PRUEBA' ,
            'TERMINACION PLAZO DE CONTRATO'    => 'TERMINACION PLAZO DE CONTRATO' ,
        );
 
        $this->set->div_panel6('<h6> Informacion Personal del Funcionario<h6>');
                
                            $this->obj->text->text_blue('Transaccion',"number" ,'id_liqcab' ,80,80, $datos ,'required','readonly','div-2-10') ;

                            $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-10') ;
                            
                            $this->obj->text->text_blue('Nro.Documento',"texto" ,'comprobante' ,80,80, $datos ,'required','readonly','div-2-10') ;
                            
                            $this->obj->text->textautocomplete('<b>Funcionario</b>',"texto",'razon',40,45,$datos,'required','','div-2-10');
                            
                            $this->obj->text->text('<b>Identificacion</b>','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                              
                            $this->obj->text->text_blue('Estado','texto','estado',10,10,$datos ,'','readonly','div-2-4') ;


                            $resultado =  $this->combo_lista("nom_regimen");
                            $this->obj->list->listadb($resultado,$tipo,'Regimen laboral','regimen',$datos,'required','','div-2-10');
                            
                            $resultado =  $this->combo_lista("presupuesto.pre_catalogo");
                            $this->obj->list->listadb($resultado,$tipo,'Programa','programa',$datos,'required','','div-2-10');
                           
                            

        $this->set->div_panel6('fin');
        

        $this->set->div_panel6('<h6> Situacion Actual del Funcionario <h6>');
         
                    
                    $resultado =  $this->combo_lista("nom_departamento");
                    $this->obj->list->listadb($resultado,$tipo,'Unidad','unidad',$datos,'required','','div-2-10');
                    
                    $resultado =  $this->combo_lista("nom_cargo");
                    $this->obj->list->listadb($resultado,$tipo,'Puesto','cargo',$datos,'required','','div-2-10');

                    $this->obj->text->text('Salario/RMU','numerico','salario',10,10,$datos ,'','readonly','div-2-10') ;

                    $this->obj->text->text_blue('INGRESO',"date" ,'ingreso' ,80,80, $datos ,'required','','div-2-10') ;
                    $this->obj->text->text_blue('SALIDA',"date" ,'salida' ,80,80, $datos ,'required','','div-2-10') ;

                    $this->obj->list->lista('Discapacidad',$MATRIZ,'discapacidad',$datos,'required','','div-2-10');

                    $this->obj->list->lista('Motivo',$MATRIZM,'motivo',$datos,'required','','div-2-10');

 

 
        $this->set->div_panel6('fin');

 
      
        $this->set->div_panel12('<h6> DATOS PARA CÁLCULO DE INDEMNIZACIONES <h6>');
        
                         
                $result =  $this->bloque_datos( 'GRUPO1' );

                while ($fila=$this->bd->obtener_fila($result)){
    
                    $objeto   = trim($fila['objeto']);
                    $etiqueta = trim($fila['variables']);
                    $referencia = trim($fila['referencia']);

                   
                    if ( $objeto == 'lista'){

                        $this->obj->list->lista($etiqueta,$MATRIZ,$referencia,$datos,'required','','div-3-3');
                    }
                    else {
                        $this->obj->text->text( $etiqueta,'number',$referencia,10,10,$datos ,'','','div-3-3') ;
                    }
                     
                }

        $this->set->div_panel12('fin');
        
        

        
        $this->set->div_panel6('<h6> INGRESOS A PAGAR EN FINIQUITO <h6>');
        
                         
                $result1 =  $this->bloque_datos( 'GRUPO2' );

                while ($fila=$this->bd->obtener_fila($result1)){
    
                    $objeto   = trim($fila['objeto']);
                    $grupo   = trim($fila['grupo']);
                    $etiqueta = trim($fila['variables']);
                    $referencia = trim($fila['referencia']);

                    if (   $grupo  == '-'){
                    }
                    else{
                        $this->set->div_label(12, $grupo );
                    }
                
                   
                    if ( $objeto == 'lista'){

                        $this->obj->list->lista($etiqueta,$MATRIZ,$referencia,$datos,'required','','div-7-5');
                    }
                    else {
                        $this->obj->text->text_yellow( '<b>'.$etiqueta.'</b>','number',$referencia,10,10,$datos ,'','','div-7-5') ;
                    }
                     
                }

        $this->set->div_panel6('fin');


        $this->set->div_panel6('<h6> EGRESOS A DESCONTAR EN FINIQUITO<h6>');
        
                         
        $result1 =  $this->bloque_datos( 'GRUPO3' );

        while ($fila=$this->bd->obtener_fila($result1)){

            $objeto   = trim($fila['objeto']);
            $grupo   = trim($fila['grupo']);
            $etiqueta = trim($fila['variables']);
            $referencia = trim($fila['referencia']);

            if (   $grupo  == '-'){
            }
            else{
                $this->set->div_label(12, $grupo );
            }
        
           
            if ( $objeto == 'lista'){

                $this->obj->list->lista($etiqueta,$MATRIZ,$referencia,$datos,'required','','div-7-5');
            }
            else {
                $this->obj->text->text_blue( '<b>'.$etiqueta.'</b>','number',$referencia,10,10,$datos ,'','','div-7-5') ;
            }
             
        }


        $this->set->div_label(12, 'RESUMEN FINIQUITO FUNCIONARIO' );

        $this->obj->text->text_yellow( '<b>RESUMEN INGRESOS</b>','number','tingreso',10,10,$datos ,'','','div-7-5') ;

        $this->obj->text->text_yellow( '<b>RESUMEN DESCUENTOS</b>','number','tdescuento',10,10,$datos ,'','','div-7-5') ;

        $this->obj->text->text_blue( '<b>TOTAL A RECIBIR</b>','number','tpago',10,10,$datos ,'','','div-7-5') ;


        echo '<a href="#" class="btn btn-info" onClick="calcula_dato()" role="button">CALCULAR RESUMEN</a>';

$this->set->div_panel6('fin');
 
 
 
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
   $evento1 = 'Calcular();';
    
   $evento2 = 'Aprobar();'; 

     
   $formulario_reporte = '../../reportes/liquidacion';
   
   $eventoi = "javascript:openFile('".$formulario_reporte."')";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'PROCESAR INFORMACION-Calcular Datos ', evento =>$evento1,  grafico => 'glyphicon glyphicon-alert' ,  type=>"button"),
                array( boton => 'Guardar Registros-Guardar', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Aprobar tramite de liquidación- Aprobar', evento =>$evento2,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_info")
             
            
             );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
 //----------------
 function bloque_datos($grupo ){


 $sql1 = "SELECT referencia, grupo, variables, clasificador, objeto 
        FROM nom_liq_matriz
        where formulario = ".$this->bd->sqlvalue_inyeccion($grupo,true).'
        order by referencia';

 
$stmt1 = $this->bd->ejecutar($sql1);

return $stmt1 ;

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
                      SELECT idprov as codigo,  razon AS nombre
                          FROM view_nomina_rol
                          WHERE responsable = 'S' 
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
													 $("#unidad").val( response.d );  
													 $("#cargo").val( response.e );  
													 $("#salario").val( response.f );

                                                     $("#discapacidad").val( response.g );
                                                     $("#ingreso").val( response.h );

                                                     $("#A9").val( response.i );  

													 var regimen = response.b
													 $("#regimen").val( regimen.trim() );    
												 
													    
													    
											} 
									});
	 
    });
 
 
</script>
  