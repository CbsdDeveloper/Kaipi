<script>// <![CDATA[
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
 	             
	             jQuery('#result').slideUp( 300 ).delay( 0 ).fadeIn( 400 ); 
            
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
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
                
				$this->formulario = 'Model-inv_cierre.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
         
        $titulo = '';
        
        $datos = array();
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 	     
          
        
        $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
        
        $this->set->div_label(12,'ANULACION DE FACTURA ');	 
        
        echo'<div class="col-md-12"><br>
               <div class="alert alert-danger">
                <div class="row">
                    <div class="col-md-4">
                      Para Anular una factura, tiene que seleccionar el numero de factura o registro como indica la figura,  
                       <br> <img src="../../kimages/eliminar_manual.png" />   
                    </div>
                <div class="col-md-8">';
                        echo '<h6 align="center">
                               <img src="../../kimages/use.png" align="absmiddle" />
                               &nbsp;Caja Abierta : '.$ACaja['completo'] .' [ Va Anular Factura ?]</h6>' ;
        
            $this->obj->text->text('Transaccion','number','id_movimiento',10,10,$datos ,'','readonly','div-2-10') ;
            $this->obj->text->text('<b>NRO.FACTURA</b>','texto','comprobante',10,10,$datos ,'','readonly','div-2-4') ;
            $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-1-5') ;
        
        echo '</div></div></div></div>';
        
        $this->set->div_label(12,'CIERRE DE CAJA ');	 
        
        echo '<div class="col-md-12">
                  <div class="alert alert-info">
                    <div class="row">
                     <h5 align="center"><b> CIERRE DE CAJA '.$ACaja['completo'] .'</b></h5>
                  </div>
                 </div>
              </div>
             <div class="col-md-12">
               <div class="col-md-7">
                    <h6><b> DETALLE FACTURA DE VENTAS </b></h6>
	                <div style="overflow-y:scroll; overflow-x:hidden; height:250px;padding: 5px"> 
                             <div id="DivDetalleMovimiento"> </div>
                    </div> 
                </div> 
               <div class="col-md-5">
                     <div class="alert alert-info">
                      <div class="row">
                     <h6 align="center"> <b>   RESUMEN DE VENTAS </b></h6>  
                        <div id="DivMovimiento"> </div>
                     <h6 align="center"><b> DETALLE FORMA DE PAGO</b></h6>
                       <div id="DivDetallePago"> </div>
                     </div> 
                   </div> 
                </div> 
             </div> 
             <div class="col-md-12">
                  <div class="alert alert-warning">
                    <div class="row">
                     <h5 align="center"><b> NOVEDADES DE CIERRE DE CAJA</b></h5>
                  </div>
                 </div>
              </div>';
        
            $this->set->div_label(12,'DETALLE LAS NOVEDADES DEL CIERRE DE CAJA (OBLIGATORIO)');	 
        
            echo  ' <div class="col-md-12"> 
                     <div class="col-md-7"> 
                         <h5 align="center"> <b>   GASTOS DE CAJA CHICA</b></h5> '; 
        
                    $cadena    = 'javascript:open_gasto('."'".'View-inv_gasto'."','".''."',".'740,370)';
        
                    $urlImagen =   '<a href="'.$cadena.'" ><img src="../../kimages/cnew.png"/></a> ';
        
                    $this->set->div_labelmin(12,'<h6>'.$urlImagen.' Agregar gastos de caja chica<h6>');
            
           echo    '   <div div class="col-md-12" id="precio_grilla"></div>
                     </div>
                    <div class="col-md-5"> 
                         <h5 align="center"> <b>   CIERRE DE CAJA NOVEDAD </b></h5> ';
                                $this->obj->text->editor('Novedad','novedad',3,75,500,$datos,'','','div-2-10') ;
           echo    ' </div>
               </div> ';
        
       
          $this->obj->text->texto_oculto("estado",$datos); 
		  $this->obj->text->texto_oculto("action",$datos); 
          $this->set->evento_formulario('-','fin'); 
          
        
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
     if ( $autoriza == 'S') {
       
             $formulario_impresion = '../view/cliente';
          
         
             $evento = 'javascript:aprobacion()';
             
             $formulario_impresion = '../../reportes/reporteInv?tipo=52';
             $eventop = 'javascript:url_comprobante('."'".$formulario_impresion."')";
             
             
             $formulario_impresion = '../../reportes/reporteCierre.php?';
             $eventocierre = 'javascript:url_cierre('."'".$formulario_impresion."')";
             
             $titulo = '<b><span style="font-size: 12px">[ Eliminar o Anular ]</span></b>';
             
             $ToolArray = array(
                 array( boton => 'Anular Registro seleccionado', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Impresion Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default"),
                 array( boton => 'Aprobar Cierre de Caja',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                 array( boton => 'Cierre de Caja', evento =>$eventocierre,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button_success") 
             );
             
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
     
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
 
  