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
          
                $this->obj->text->textautocomplete('Beneficiarios',"texto",'razon',40,45,$datos,'required','','div-1-5');
                
               
                
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-1-5') ;
                
                
                $this->set->div_label(12,'Enlace contable - presupuestario');	 
                
                $evento = 'onClick="PonePartida()"';
                
                $variable = 'action=add&ref='.$datos['id_asiento']; 
                $cadena = 'onClick="open_spop_parametro('."'".'co_asientosd_cxp'."','".$variable."'".",780,470,"."'id_asiento'".')"';
                

                $variable1 = 'action=add&ref='.$datos['id_asiento']; 
                $cadena1 = 'onClick="open_spop_parametro('."'".'co_asientosd_ant'."','".$variable1."'".",780,470,"."'id_asiento'".')"';
                
                echo '<div class="col-md-6"><div class="btn-group">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalGasto" '.$evento.' >Enlace Presupuestario</button>
                <button type="button" class="btn btn-default btn-sm" '.$cadena.' >Agregar Cuentas</button>
                <button type="button" class="btn btn-warning btn-sm" '.$cadena1.' >Anticipos</button>
                </div></div>';
                         
              
                echo '<div class="col-md-6">
                 <a href="#" title= "Ver Auxiliares" onClick="VerBeneficiarios()"  data-toggle="modal" data-target="#myModalprov"><img src="../../kimages/03_.png" align="absmiddle"/> Lista de Auxiliares</a>  &nbsp; &nbsp;
                <a href="#" title= "Ver Enlaces" onClick="AbrirEnlace()"><img src="../../kimages/05_.png" align="absmiddle"/> Validacion Enlace Presupuestario </a>  &nbsp;
                </div>';
 
                
                $this->set->div_label(12,'Detalle asientos contables');	 
                 
         
                
                 $this->set->div_panel('fin');	
                 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 //-------------
      
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
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		    array( boton => 'Aprobar asientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
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