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
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-co_bancos.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //---------------------------------------
      
     function Formulario( ){
        
        $datos = array();
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
        
        $tipo = $this->bd->retorna_tipo();
    
                $this->BarraHerramientas();
                 
                $this->set->div_panel6('<b> REFERENCIA CONCILIACION BANCARIA </b>');
                
                    $this->obj->text->text('Referencia',"number",'id_concilia',0,10,$datos,'','readonly','div-2-10') ;
                    
                    $this->obj->text->text('Fecha','date','fecha',15,15, $datos ,'required','','div-2-10') ;
                    
                    $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;
                    
                    
                    
                    $sql = "select b.cuenta as codigo, b.cuenta || ' ' || b.detalle as nombre
				       from   co_plan_ctas b
                      where  b.tipo_cuenta = 'B' and b.univel = 'S' and
                             b.anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true)." and 
                             b.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                      order by 1';
                    
                    
 
                    $resultado = $this->bd->ejecutar($sql);
                    
                    
                    $this->obj->list->listadb($resultado,$tipo,'Bancos','cuenta',$datos,'required','','div-2-10');
                    
                    
                    $this->obj->text->text('Estado',"texto",'estado',15,15,$datos,'','readonly','div-2-10');
                    
                    echo '<h6> &nbsp; </h6>';
                    
                    echo '<div class="btn-group" align="center">
                    <button type="button" class="btn btn-info btn-sm" onClick="SaldoBancos()">Saldo Bancos</button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"  onClick="ChequeLista()">Cheque</button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalDeposito"  onClick="DepositoLista()">Trasferencias</button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModalEstado" onClick="LimpiarNota();"> Nota Credito/Debito</button>
                    <button type="button" class="btn btn-warning btn-sm" onClick="total_saldos_datos()">Diferencia Conciliar</button>
                    </div>';
                    
                    echo '<h6> &nbsp; </h6>';
                    
                    echo '<div  align="center" id="resumen">-</div>';
                
                $this->set->div_panel6('fin');
                
                
                $this->set->div_panel6('<b> RESUMEN DE VALORES DE CONCILIACION </b>');
                
                    $this->obj->text->text('<b> SALDO BANCOS</b> ','number','saldobanco',10,10, $datos ,'','readonly','div-4-8') ;
                    $this->obj->text->text('(+) Notas Credito','number','notacredito',10,10, $datos ,'','readonly','div-4-8') ;
                    $this->obj->text->text('(-) Notas Debito','number','notadebito',10,10, $datos ,'','readonly','div-4-8') ;
                    
                    $this->obj->text->text_yellow('(=) Saldo Conciliar','number','saldo1',10,10, $datos ,'','readonly','div-4-8') ;
                    
                    $this->obj->text->text('<b> SALDO ESTADO CUENTA</b> ','number','saldoestado',10,10, $datos ,'required','','div-4-8') ;
                    $this->obj->text->text('(-) Cheques Girados/No girados','number','cheques',10,10, $datos ,'','readonly','div-4-8') ;
                    $this->obj->text->text('(-) Trasferencias','number','depositos',10,10, $datos ,'','readonly','div-4-8') ;
                    
                    $this->obj->text->text_yellow('(=) Saldo Conciliar','number','saldo2',10,10, $datos ,'','readonly','div-4-8') ;
                    
                   
                $this->set->div_panel6('fin');
                
                
                $this->set->div_panel6('<b> MOVIMIENTOS CONTABLES DE BANCOS PERIODO MENSUAL</b>');
                
                 echo '<div id="Mov_cheque">(-) Cheques Girados y no cobrados</div>';
                 echo '<div id="Mov_Desposito">(-) Trasferencias</div>';
                
                $this->set->div_panel6('fin');
                
                $this->set->div_panel6('<b> MOVIMIENTOS NOTAS CREDITO/DEBITO ESTADO DE CUENTA </b>');
                
              
                echo '<div id="Mov_credito">Notas de Credito/Debito</div>';
                 
                
                $this->set->div_panel6('fin');
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'javascript:aprobacion('."'".$this->formulario.'?action=aprobacion'."'".')';
   	
   	$formulario_impresion = '../../reportes/conciliacion';
   	
   	$eventop = 'javascript:reporte_impresion('."'".$formulario_impresion."')";
   
   	$eventoModal='javascript:PagoAsiento()';
   	    	
   	$eventoc = '#myModalPago-'.$eventoModal;
   	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		    array( boton => 'Aprobar Conciliacion',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
    	     	array( boton => 'Reporte diario contable', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button") 
     		
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
