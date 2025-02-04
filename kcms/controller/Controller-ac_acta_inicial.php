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
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
            	  jQuery('#result').html(data.resultado);
            	  
 				  jQuery( "#result" ).fadeOut( 1600 );
 				  
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  
 			 	  jQuery("#id_acta").val(data.id );

 			 	  jQuery("#documento").val(data.documento ); 

 			 	  BusquedaGrillaCustodio(oTable_doc);
            
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ac_inicial.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
        $datos = array();
    
                $this->BarraHerramientas();
           
                $this->set->div_panel('<b> ACTA DE ENTREGA RECEPCION INICIAL</b>');
                
              
 		                
                            $this->tab_1_datos_bienes( );
                   
         	              $this->obj->text->texto_oculto("action",$datos); 
         
 
         
         
             $this->set->div_panel('fin');
         
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
       
       
       
       $evento= "javascript:confirmar_envio(event)";
 
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Generar el Acta Entrega Recepcion', evento =>$evento, grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
    $this->obj->boton->ToolMenuDivSet($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
  //----------------------------------------------
  function tab_1_datos_bienes( ){
      
 
      $datos = array();
  
      
    
      
      $this->obj->text->text('Custodio',"texto",'razon',40,45,$datos,'','readonly','div-2-4');
      
      $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
      
      
      $this->obj->text->text('Id.Acta',"number",'id_acta',40,45,$datos,'required','readonly','div-2-4') ;
      
      
      $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
      
       
      // 'Acta Trasferencia de Bienes'    => 'Acta Trasferencia de Bienes',
     // 'Acta Baja de Bienes'    => 'Acta Baja de Bienes'
      
      $MATRIZ = array(
          'Acta de Entrega - Recepcion'    => 'Acta de Entrega - Recepcion'
      );
      $this->obj->list->lista('Clase Documento',$MATRIZ,'clase_documento',$datos,'required','','div-2-4');
      
      
      $this->obj->text->text('Nro.Acta','texto','documento',10,10,$datos ,'','readonly','div-2-4') ;
      
      
      $this->obj->text->editor('Detalle','detalle',4,70,100,$datos,'','','div-2-10');
      
      
      $MATRIZ = array(
          'N'    => 'No',
          'S'    => 'SI',
      );
      $this->obj->list->lista('Autorizado',$MATRIZ,'estado',$datos,'','disabled','div-2-4');
      
      
       
      $this->set->div_label(12,'<b>Referencia de activos</b>');
      
      
     echo ' <div class="col-md-12" style="padding: 1px">

            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm">Seleccion de informacion</button>
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a onClick="MarcarTodo(1)"  href="#">Marcar todos los bienes</a></li>
                  <li><a onClick="MarcarTodo(0)" href="#">Desmarcar todos los bienes</a></li>
                </ul>
              </div>

                <div class="col-md-12" style="padding: 1px">
                        <div id="DetalleActivosNoAsignado">Para visualizar los bienes pendientes de asignar debe agregar para crear el acta</div>
                </div>

             </div>
            <div id="GuardaDato"></div>';
        
      
      
      
  }  
 //-----------------------------

 
  //----------------------------------------------
  function sql($titulo){
      
  	if  ($titulo == 1){
  	    
  	 	   $sqlb = "Select '-' as codigo, '[01. Seleccione cuenta contable ]' as nombre   
                    union
                    SELECT  cuenta as codigo, (cuenta || '.'||  detalle) as nombre
                    FROM  co_plan_ctas
                    where tipo_cuenta = 'A' and 
                          univel = 'S'  and 
                          estado =".$this->bd->sqlvalue_inyeccion('S', true).' order by 1';
	 		  	
  	}
  	
 
  	
  	if  ($titulo == 2){
  	    
  	    
  		$sqlb = "SELECT idmodelo  as codigo ,  nombre
		          FROM  web_modelo
                 where idmodelo = 0";
  		
 
  		
  	}
  	
 
  	
  	$resultado = $this->bd->ejecutar($sqlb);
  	
  	
  	return  $resultado;
  	
  }  
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>
  