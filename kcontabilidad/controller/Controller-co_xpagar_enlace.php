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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
                
                $this->anio       =  $_SESSION['anio'];
                
        
                
               $this->formulario = 'Model-co_xpagar.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
 
      
     function Formulario( ){
      
        $tipo = $this->bd->retorna_tipo();
         
        $datos = array();
        
         
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
  
    
                $this->BarraHerramientas();
                
                 
                $resultado = $this->bd->ejecutar("select id_periodo as codigo, (mesc || '-' || anio)  as nombre
                    							       from co_periodo
                    							      where  anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true)." and
                                                            registro=".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                                                    order by 1 desc');
               
                
                $this->obj->list->listadb($resultado,$tipo,'Periodo','id_periodo',$datos,'required','disabled','div-1-3');
                
                $this->obj->text->text_yellow('Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-1-3') ;
                
                $this->obj->text->text_blue('Tramite',"number",'id_tramite',0,10,$datos,'','readonly','div-1-3') ;
                
                $this->obj->text->text_yellow('<b>Fecha</b>',"date",'fecha',15,15,$datos,'required','','div-1-3');
                
                
                $this->obj->text->text('Comprobante',"texto",'comprobante',15,15,$datos,'required','readonly','div-1-3');
                
                $this->obj->text->text('Referencia',"texto",'documento',15,15,$datos,'required','','div-1-3');
                
                $this->obj->text->text('Estado',"texto",'estado',15,15,$datos,'','readonly','div-1-11');
                
                 
                $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-1-11') ;

                $this->obj->text->texto_oculto("razon",$datos); 
                $this->obj->text->texto_oculto("idprov",$datos); 

           
                $resultado = $this->bd->ejecutar("select id_rol as codigo, novedad as nombre
                from nom_rol_pago
                where anio=". $this->bd->sqlvalue_inyeccion(  $this->anio  , true)."  and
                      registro=". $this->bd->sqlvalue_inyeccion($this->ruc, true).'
           order by 1 desc ' );

           

                $this->obj->list->listadb($resultado,$tipo,'Periodo','id_rol1',$datos,'required','','div-1-3');


                $evento = ' OnChange="BuscaRubros(this.value,0)" ';
                $resultado =  $this->combo_lista("nom_regimen");
                $this->obj->list->listadbe($resultado,$tipo,'','regimen',$datos,'required','',$evento,'div-0-4');


                $resultado =  $this->combo_lista("detalle_rubro");
                $this->obj->list->listadb($resultado,$tipo,'','detalle_rubro',$datos,'required','','div-0-4');
                                
                $this->set->div_label(12,'Enlace contable - Roles de pago Talent Humano');	 
                
                 
                $cadena  = 'onClick="DetalleAsiento()"';
                $cadena1 = 'onClick="DetalleAgrupado()"';
                
 
                
                echo '<div class="col-md-6"><div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm" '.$cadena.' >Detalle Cuentas</button>    &nbsp;
                        <button type="button" class="btn btn-info btn-sm" '.$cadena1.' >Agrupar Cuentas</button>    &nbsp;
                        <a href="#" title= "Ver Auxiliares" onClick="VerBeneficiarios()"  data-toggle="modal" data-target="#myModalprov"><img src="../../kimages/03_.png" align="absmiddle"/> Lista de Auxiliares</a>  &nbsp; &nbsp;
                        <a href="#" title= "Ver Enlaces" onClick="AbrirEnlace()"><img src="../../kimages/05_.png" align="absmiddle"/> Validacion Enlace Presupuestario </a>  &nbsp;
                </div></div>';
                         

                $cadena  = 'onClick="DetalleNomina()"';
                $cadena1 = 'onClick="DetalleNomCtas()"';
                $cadena2 = 'onClick="DetalleNomCtasPrograma()"';

          
              
                echo '<div class="col-md-6"><div class="btn-group">
                <button type="button" class="btn btn-warning btn-sm" '.$cadena.' >Detalle Nomina</button>    &nbsp;
                <button type="button" class="btn btn-info btn-sm" '.$cadena1.' >Agrupar Cuentas</button>    &nbsp;
                <button type="button" class="btn btn-danger btn-sm" '.$cadena2.' >Agrupar Cuentas-Programa</button>    &nbsp;

                </div></div>';
              
                
                $this->set->div_label(12,'Detalle asientos contables');	 
                 
         
                
                 $this->set->div_panel('fin');	
                 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 //-------------
      //----------------------------------------------
   function combo_lista($tabla ){
       
 

    if  ($tabla == 'detalle_rubro'){
        
        $resultado = $this->bd->ejecutar("select '-' as codigo, '[Seleccione Detalle]' as nombre   union
                                        SELECT nombre as codigo, nombre
                                            FROM  view_rol_impresion
                                            where anio = ". $this->bd->sqlvalue_inyeccion( $this->anio , true) ."
                                            group by nombre
                                                order by 1" );
                                        
                                        
        
             
    }
    
    
    if  ($tabla == 'nom_regimen'){
        
        $resultado = $this->bd->ejecutar("select '-' as codigo, '[Seleccione Regimen]' as nombre   union
                                         select regimen as codigo, regimen as  nombre
                                             from nom_regimen
                                             where activo =". $this->bd->sqlvalue_inyeccion('S', true) .'
                                        order by 1   ' );
        
        
 
            
    }
    
    
    
    
    return $resultado;
    
    
} 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'javascript:aprobacion()';
   	
  
   	
   	$formulario_impresion = $this->bd->_impresion_carpeta('54');
   	$eventopi = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   	
   
   	$formulario_impresion = $this->bd->_impresion_carpeta('55');
   	$eventopp = 'javascript:impresion_pago('."'".$formulario_impresion."','".'id_asiento'."')";
 
   	$formulario_impresion = '../view/proveedor';
   	$eventop = 'javascript:modalVentana('."'".$formulario_impresion."')";
   	
       
    $ToolArray = array( 
                  array( boton => 'Reporte diario contable', evento =>$eventopi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default"),
                array( boton => 'Orden de Gasto y Pago', evento =>$eventopp,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_info") ,
                array( boton => 'Proveedor', evento =>$eventop,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") 
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
 
//--------------------------
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        	//	console.log(data);
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