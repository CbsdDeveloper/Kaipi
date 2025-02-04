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
             
				$this->formulario = 'Model-ven_factura.php'; 
             
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
         
        $titulo         = 'Facturacion' ; 

        $datos          = array();
        
        $datos['fecha'] =  date("Y-m-d");
        
        $tipo           = $this->bd->retorna_tipo();
        
        $ACaja          = $this->bd->query_array('par_usuario',  '*', 'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true) );

        $Acorreo        = $this->bd->query_array('web_registro',  '*', 'ruc_registro='.$this->bd->sqlvalue_inyeccion( trim($this->ruc) ,true) );

        $correo         = $Acorreo['correo'];

 

        $this->set->evento_formulario( $this->evento_form,'inicio' );  


        $this->div_panel('12');
 
                     $this->BarraHerramientas( $ACaja['caja'] );

         $this->div();

      


        $this->div_panel('5');
        
            $this->div_panel('12','padding-top:10px');
             
  
                        $stmt =  $this->listaValores();

 
                        echo '<ul class="pagination">';
                        while ($fila= $this->bd->obtener_fila($stmt)){
                            
                            $codigo = $fila['idproducto_ser'] ;
                            $marca  = trim($fila['servicio']) ;
                            $pvp    = $fila['costo'] ;

                            $evento = ' onClick="InsertaProductoItem('.$codigo.','.$pvp .')" ';

                            echo ' <div class="bloque"><a href="#" '.$evento .'><b>'.$marca.'</b></a><br><span class="badge">'. $pvp.'</span></div>';
 
                        }

                        $evento = ' onClick="InsertaFrecuencia()" ';

                        echo ' <div class="bloque2"><a href="#" title= "Registo de Frecuencia" '.$evento .'><img src="../../kimages/bus-13950.png" width="100" height="55" />  </a><br></div>';
                        

                        echo '</ul>';


            $this->div(); 

            $this->div_panel('12');

                     
                        $this->obj->text->textautocomplete('',"texto",'articulo',100,100,$datos,'','','div-0-12');
                        $this->obj->text->texto_oculto("idproducto",$datos); 

            $this->div(); 

            $this->div_panel('12','padding-top:10px');

                    $evento = ' onClick="InsertaProducto()" ';
                    $cboton1 = ' <a href="#" '.$evento.' title="Agregar Articulo"><img src="../../kimages/if_cart_add.png" align="absmiddle"/> Agregar Carrito</a>';
                    echo $cboton1 ;

            $this->div(); 

        $this->div();     

        //----------------------------------------------------------------------------------------------------

        $this->div_panel('4');

 
                echo '<h6 id="nombre_cooperativa">2. SERVICIOS SELECCIONADOS </h6>';

                echo  '<div class="alert al1ert-info fade in">
                            <div id="DivMovimiento"> </div>
                       </div> 

                       <div id="DivProducto"> </div>

                       <div id="ver_factura" style="padding:20px"> </div>
                      
                       <div id="Divbus" style="padding-top:10px"> - </div>';
 
        $this->div();     


        $this->div_panel('3','padding:10px');
       

echo '<div class="panel-group" id="accordionExample">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionExample" href="#collapseOne">
                       3. CLIENTE
                    </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">';
                    $this->div_panel('12','padding-top:5px');
                               $this->cliente_nombre($correo);
                       $this->div();   
            echo '</div>
                </div>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionExample" href="#collapseTwo">
                      4. FORMA DE PAGO
                    </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">';
                    $this->div_panel('12','padding-top:10px');
                    $this->cliente_pago();
                    $this->div();   

                    $this->div_panel('12','padding-top:5px');

                               echo '<div id="ver_factura"> </div> ';
       
                               echo '<div style="font-size: 22px;background-color: #FFEF1F" id="ver_pago"> </div> 
                                <div id="okCliente"> </div>
                                <div id="ver_factura"> </div>
                                <div id="FacturaElectronica">  </div>';

                        $this->div();   

                    echo '</div>
                </div>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionExample" href="#collapseThree">
                        INFORMACION ADICIONAL
                    </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">';
                    $this->div_panel('12','padding-top:10px');
                             $this->obj->text->text('Transaccion','number','id_movimiento',10,10,$datos ,'','readonly','div-3-9') ;
                            $this->obj->text->text('Documento','texto','comprobante',10,10,$datos ,'','readonly','div-3-9') ;
                            $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-3-9') ;
                     $this->div();  
                    echo '</div>
                </div>
                </div>
                </div>';
 
        $this->div();     
 
        
        $this->div_panel('12','padding-top:10px;padding-bottom: 10px');
       
        echo '<h6><img src="../../kimages/use.png" align="absmiddle" />&nbsp;'.$ACaja['completo'] .'</h6>';

        $this->div();
   

      $this->obj->text->texto_oculto("idbodega",$datos); 
      $this->obj->text->texto_oculto("detalle",$datos); 
      $this->obj->text->texto_oculto("estado",$datos); 
      $this->obj->text->texto_oculto("action",$datos); 
      $this->obj->text->texto_oculto("id_par_ciu",$datos); 

      

      $this->set->evento_formulario('-','fin'); 
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
     if ( $autoriza == 'S') {
       
             $formulario_impresion = '../view/cliente_trasporte';
             $eventoc = 'openView('."'".$formulario_impresion."')";
         
         
             $evento = 'aprobacion()';
             
             $formulario_impresion = '../../reportes/view_print_terminalb?tipo=51';
             $eventop = 'url_comprobante('."'".$formulario_impresion."')";
             
             $titulo = '<b><span style="font-size: 16px">[ 1 ]</span></b>';
                
             
             // array( boton => 'Impresion Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") 

             $ToolArray = array(
                  array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                  array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                  array( boton => 'Busqueda Cooperativas', evento =>$eventoc,  grafico => 'glyphicon glyphicon-bed' ,  type=>"button_default") ,
                    array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger")
             );
             
             $this->obj->boton->ToolMenuDivTitulo_punto($ToolArray,$titulo); 
     
      }else{
          echo '<b>NO SE ENCUENTRA ASIGNADO COMO CAJERO(A)...</b>';
      }
    
 
   
  }  
  function cliente_pago(){
    
    $this->obj->text->texto_oculto("tdescuento",$datos); 
    $this->obj->text->texto_oculto("formapago",$datos); 
    $this->obj->text->texto_oculto("tipopago",$datos); 
    $this->obj->text->texto_oculto("cuentaBanco",$datos); 
    $this->obj->text->texto_oculto("idbanco",$datos); 
  
   $evento = 'onBlur="cambio_dato(this.value)"';                                                                                      
   $this->obj->text->textLong('Pagar',"number",'efectivo',15,15,$datos,'','',$evento,'div-0-10');
           
   echo '<h4 align="center" id="div_sucambio"></h4>';

 
}    
  //----------------------------------------------
   function cliente_nombre(   $correo  ){
          
   
    $evento1 = ' onClick="LimpiarCliente()" ';
    $evento  = ' onClick="ActualizaCliente()" ';


    $datos           = array();

    $datos['correo'] = trim($correo);

                echo '<div  style="padding-top: 5px;" class="col-md-12">
                <div class="input-group">
                <span class="input-group-addon" '.$evento1 .' title= "LIMPIAR CASILLERO PARA BUSQUEDA DE LCIENTES"><i class="glyphicon glyphicon-cog"></i></span>
                    <input type="text" name="idprov" id="idprov" class="typeahead form-control" autocomplete="off" placeholder="Identificacion" size="13" maxlength="13" value="">
                    </div>
            </div>';


            echo '<div  style="padding-top: 5px;" class="col-md-12">
            <div class="input-group">
            <span class="input-group-addon" title="ACTUALIZAR DATOS DE CLIENTES" '.$evento.'><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" name="razon" id="razon" class="typeahead form-control" autocomplete="off" placeholder="" size="40" maxlength="45" value="">
            </div>
            </div>';

            echo '<div style="padding-top: 5px;" class="col-md-12">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                        <input id="correo" type="text" class="form-control" name="correo"  placeholder="Email" value="'.$correo .'">
                    </div>
            </div>';

            echo '<div id="okCliente"> </div>';


   }  
    
   function div_panel($valor,$pad='-'){
    
    if ( $pad == '-'){

        echo '<div class="col-md-'.$valor.'">';

    }else {
    
        echo '<div class="col-md-'.$valor.'" style="'.$pad.'" >';

    }

 
  }    

  //----------------
  function div(){
      echo '</div>';
}    
   //----------------------------------------------
   function ListaValores(){
    
    $sql1 = "SELECT idproducto_ser, servicio, costo
    FROM  rentas.view_rubro_servicios
    where estado_servicio = 'S' and tipo_servicios = 'T' limit 15";
    
    $stmt =  $this->bd->ejecutar($sql1);
 
 
    return $stmt;

  }    
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
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
											  
									} 
							});

});
 
 //---------------------------------------------- focusin focusout
 
 
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
  
  
  
  
</script>
 
  