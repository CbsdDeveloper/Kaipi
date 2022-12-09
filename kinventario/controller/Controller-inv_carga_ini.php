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
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
				$this->formulario = 'Model-inv_carga.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 		
        $this->BarraHerramientas();
        
         
		$this->obj->text->text('Movimiento','number','id_cmovimiento',10,10,$datos ,'','readonly','div-2-4') ;

		$datos['fecha'] =  date("Y-m-d");
		$this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
	
		$resultado = $this->bd->ejecutar("select nombre as codigo, nombre
								from web_categoria ");
		
		$tipo = $this->bd->retorna_tipo();
		
		$this->obj->list->listadb($resultado,$tipo,'Categoria','detalle',$datos,'','','div-2-4');
		
		
		$this->obj->text->text('Estado','texto','estado',10,10,$datos ,'','readonly','div-2-4') ;
		
 
		 $evento = ' onClick="InsertaProducto()" ';
		 
		 $cboton1 = '  <a href="#" class="btn btn-info" role="button" '.$evento.' > Generar informacion</a>';
		 
		 $this->set->div_label(12, $cboton1);
	 
		 $datos['transaccion'] = 'CargaInicial';
		 $datos['tipo']        = 'I';
		 $datos['documento']   = 'CI00';
		 
 		 
		 $this->obj->text->texto_oculto("tipo",$datos);
		 $this->obj->text->texto_oculto("documento",$datos); 
		 $this->obj->text->texto_oculto("transaccion",$datos);
	 	 
	
		 $this->obj->text->texto_oculto("fechaa",$datos); 
	 	 
		 echo '<div class="col-md-12">
                             	<div class="alert al1ert-info fade in">
                                		<div id="DivMovimiento"></div>
                                </div>
                                <div id="DivProducto"></div>
                </div>';
		 
		 
		 $this->obj->text->texto_oculto("action",$datos); 
         $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
     $evento = 'javascript:aprobacion()';
     
     $formulario_impresion = '../../reportes/reporteInv?a=';
     $eventoi = 'javascript:url_comprobante('."'".$formulario_impresion."')";
      
  
     $ToolArray = array(
         array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
         array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
         array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
         array( boton => 'Comprobante Inventarios', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")   
          
     );
    
    
    
    
    
    $this->obj->boton->ToolMenuDiv($ToolArray); 
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
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
 
  