<script >// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
				$this->formulario = 'Model-ven_factura_arriendo.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
      function Formulario( $id,$accion ){
  
         
        $datos = array();

        $datos['fecha'] =  date("Y-m-d");
        
        $tipo = $this->bd->retorna_tipo();
        
        if ( $accion == 'add'){
            
            $len    = strlen($id);
            $idprov = $id;
            if ($len == 9){
                $idprov = '0'.$id;
            }
            if ($len == 12){
                $idprov = '0'.$id;
            }
            
            $x = $this->bd->query_array('par_ciu',
                                        'idprov,razon,correo', 
                                        'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)
                );
            
            $datos['razon'] = $x['razon'];
            $datos['idprov'] = $x['idprov'];
            $datos['correo'] = $x['correo'];
            $datos['detalle'] = 'Por Servicio de ';
            $datos['estado'] = 'digitado';
            $datos['efectivo'] = '0.00';
            
        }
        
        $this->consultaId($accion,$id );
        
 
        $this->set->_formulario( $this->evento_form,'inicio' );  
 
        
        $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas( $ACaja['caja'], $accion );
        
        
        echo '<div class="col-md-8">
                <div class="col-md-12"> ';
        
                        echo '<h6><img src="../../kimages/use.png" align="absmiddle" /> &nbsp;Usuario : '.$ACaja['completo'] .'</h6>' ;
            
                        $this->obj->text->text('Transaccion','number','id_movimiento',10,10,$datos ,'','readonly','div-1-3') ;
             
                        $this->obj->text->text('Factura','texto','comprobante',10,10,$datos ,'','readonly','div-1-3') ;
                
                        $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-1-3') ;

                        echo '</div> <div class="col-md-12">';
                        
                        
            $this->set->div_label(12,'DETALLE DE FACTURACION - SERVICIOS');	 
        
            $evento = ' onClick="AgregaVariables()" ';
            
            $cboton2 = ' <a href="#" '.$evento.' title="Agregar Variables" data-toggle="modal" data-target="#myModalvar"><img src="../../kimages/form.png" align="absmiddle"/></a>';
             
            $this->obj->text->editor('CONCEPTO'.$cboton2,'detalle',2,45,300,$datos,'required','','div-2-10') ;
              
            $evento = ' onClick="InsertaProducto()" ';
            
            $cboton1 = ' <a href="#" '.$evento.' title="Agregar Servicio"><img src="../../kimages/if_cart_add.png" align="absmiddle"/></a>';
            
            
            $this->obj->text->textautocomplete($cboton1,"texto",'articulo',100,100,$datos,'','','div-2-6');
            
            $this->obj->text->text('','texto','idproducto',30,30,$datos ,'','readonly','div-0-4') ;
            
        
        
         echo  '<div class="alert al1ert-info fade in">
                                <div id="DivMovimiento"> </div>
                        </div>
                                <div id="DivProducto"> </div>
                    </div>
                 </div> ';
        
        
        echo '</div></div>';
        
        echo '<div class="col-md-4">
                 <div class="col-md-12" align="center">
                    <div id="ver_pago"> </div>
               
                </div>
                <div class="col-md-12">
                     <div class="alert alert-info">
                        <div class="row">';
        
                        $this->obj->text->textautocomplete('Identificacion','texto','idprov',13,13,$datos ,'',' ','div-3-9') ;
                        
                        
                        $evento1 = ' onClick="LimpiarCliente()" ';
                        $cboton2 = ' <a href="#" '.$evento1.' title="Limpiar Informacion">Cliente   <img src="../../kimages/cdel.png" align="absmiddle"/></a>';
                        
                     
                        
                        $this->obj->text->textautocomplete($cboton2,"texto",'razon',40,45,$datos,'','','div-3-9');
                        
                        $evento = ' onClick="ActualizaCliente()" ';
                        $cboton1 = '<a href="#" '.$evento.' title="Actualizar Cliente">Email <img src="../../kimages/okk.png" align="absmiddle"/></a>';
                        
                        $this->obj->text->text($cboton1,'texto','correo',120,120,$datos ,' ','','div-3-9') ;
                        
 
                        
                        echo '<div id="okCliente"> </div>';
        
                        
        echo '</div></div></div>';
        
        echo ' <div class="col-md-12">
                <div class="alert alert-info">
                  <div class="row"> ';
                              
        
                        $this->obj->text->text_blue('F.Pago','date','fechaa',10,10,$datos ,'','readonly','div-2-10') ;
        
                            
                            $MATRIZ = array(
                                '-'    => ' [ Seleccione Forma de Pago ] ',
                               'credito'    => 'Cuenta X Cobrar(Credito)',
                                'contado'    => 'Contado'
                           );
                           
                            $evento = 'onChange="FormaPago(this.value)"';
                           
                           $this->obj->list->listae('Pago',$MATRIZ,'formapago',$datos,'required','',$evento,'div-2-10');
                                                                      
                                                                      
                           $MATRIZ = array(
                               'efectivo'    => 'Efectivo',
                               'cheque'    => 'Cheque',
                               'tarjeta'    => 'Tarjeta',
                           );
                                   
                                   
                           $evento = 'onChange="tipopagoshow(this.value)"';
                                
                           $this->obj->list->listae('Tipo',$MATRIZ,'tipopago',$datos,'required','',$evento,'div-2-10');
                               
                           $evento = 'onkeyup="cambio_dato(this.value)"';
                                                                          
                           $this->obj->text->textLong('Pagar',"number",'efectivo',15,15,$datos,'','',$evento,'div-2-10');
                                   
                           echo '<h4 align="center" id="div_sucambio"></h4>';
                                       
                                       
                           $this->obj->text->texte('Nro.Cuenta','texto','cuentaBanco',30,30,$datos ,'','','','div-2-10') ;
                               
                               
                           $evento = '';
                                   
                           $sql ="SELECT idcatalogo as codigo, nombre
                                FROM  par_catalogo
                                WHERE  tipo = 'bancos'"   ;
                               
                           $resultado = $this->bd->ejecutar($sql);
                               
                           $this->obj->list->listadbe($resultado,$tipo,'Institucion','idbanco',$datos,'','',$evento,'div-2-10');
         
              echo   '</div>
                        </div>
                          </div> 
                            <div class="col-md-12">';
                        
              
              $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
                  );
              
              $MATRIZ = array(
                  '0'    => 'Factura',
                  '9'    => 'Ingreso a Caja'
              );
              
              
              $this->obj->list->listae('',$MATRIZ,'carga',$datos,'required','','disabled','div-2-10');
              
        
              
              $this->obj->text->texto_oculto("idbodega",$datos); 
              
              echo ' </div>
                      <div id="FacturaElectronica"> </div> 
                        <div id="ver_factura"> </div>
                         </div>';
        
         $datos['action'] = $accion;
              
         $this->obj->text->texto_oculto("estado",$datos); 
		 $this->obj->text->texto_oculto("action",$datos); 
		 
		 
		 $this->set->_formulario('-','fin'); 
      
   }
 //----------------------------------------------
   function consultaId($accion,$id ){
       
       
       $qquery = array(
           array( campo => 'id_movimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
           array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'fechaa',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'comprobante',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'carga',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S')
       );
       
       $datos = $this->bd->JqueryArrayVisor('view_ventas_fac',$qquery );
       
      
       
       return  $datos;
   }
   function BarraHerramientas($autoriza, $accion){
   
   

     
     if ( $autoriza == 'S') {
       
             $formulario_impresion = '../view/cliente';
             $eventoc = 'javascript:openView('."'".$formulario_impresion."')";
         
         
             $evento = 'javascript:aprobacion()';
             
             $formulario_impresion = '../../reportes/reporteInv?tipo=51';
             $eventop = 'javascript:url_comprobante('."'".$formulario_impresion."')";
             
             $titulo = '<b><span style="font-size: 16px">[ 1 ]</span></b>';
             
             
             
             $eventof = "javascript:goToURLElectronicoTool(1)";
             
             $eventog = "javascript:goToURLElectronicoActualiza(1)";
             
             if ( $accion ==  'editar'){
                 
                 $ToolArray = array(
                     array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                     array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                     array( boton => 'Clientes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                     array( boton => 'Impresion Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
                     array( boton => 'Emitir Factura Electronica', evento =>$eventof,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success"),
                     array( boton => 'Descargar Factura Electronica', evento =>$eventog,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button_default")
                 );
                 
             }else {
                 
                 $ToolArray = array(
                    // array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                     array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                     array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                     array( boton => 'Clientes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                     array( boton => 'Impresion Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
                     array( boton => 'Emitir Factura Electronica', evento =>$eventof,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success"),
                     array( boton => 'Descargar Factura Electronica', evento =>$eventog,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button_default")
                 );
                 
             }
               
             
             
             $this->obj->boton->ToolMenuDivTitulo($ToolArray,$titulo); 
     
      }else{
          echo '<b>NO SE ENCUENTRA ASIGNADO COMO CAJERO(A)...</b>';
      }
    
    
    
    
   
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $id     = $_GET['id'];
   $accion = $_GET['accion'];
 			 
   
    $gestion->Formulario($id,$accion );
   
  
 
   
?>

<script type="text/javascript">

 jQuery.noConflict(); 
 
   
 
 //----------------------------------------------  
  if ( jQuery("#action").val() == 'add' ) {
 
   $("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');

 
  }

  $("#cuentaBanco").hide();
	 
	 $("#idbanco").hide();
	 
	 $("#lcuentaBanco").hide();
	 
	 $("#lidbanco").hide();		

	 $("#efectivo").val('0.00');		

	 $("#formapago").val('contado');
	 
  jQuery('#articulo').typeahead({
 	    source:  function (query, process) {
        return $.get('../model/AutoCompleteProdFacSer.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

  $("#articulo").focusin(function(){
		 
		 var itemVariable = $("#articulo").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDProd.php',
												type:  'GET' ,
												beforeSend: function () {
														$("#idproducto").val('...');
												},
												success:  function (response) {
														 $("#idproducto").val(response);  // $("#cuenta").html(response);
														  
												} 
										});
		 
	    });
  
  //------------------
  var id		    = $("#id_movimiento").val();  
  var accion 		= 'editar'; 			

  
  var parametros1 = {
						'id' :  id ,  
						'accion': accion
				};
   
    
				$.ajax({
						url:   '../controller/Controller-inv_FacDetSer.php',
						data:  parametros1,
						type:  'GET' ,
						success:  function (data) {
								 $("#DivMovimiento").html(data);   

							} 
				});
  
  
</script>