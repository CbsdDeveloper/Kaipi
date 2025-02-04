<script >// <![CDATA[

    jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#formProducto').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {

             	 jQuery('#guardarProducto').html(data);

            	 jQuery( "#guardarProducto" ).fadeOut( 1600 );

            	 jQuery("#guardarProducto").fadeIn("slow");

            	 
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
				
                $this->formulario = 'Model-certificacion_partida.php'; 
                
              	$this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $titulo = 'Productos';
         
        $datos = array();
        
        $this->set->evento_formulario_id( $this->evento_form,'inicio','formProducto' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 		
        $this->BarraHerramientas();
        
        $this->set->div_label(12,'Ingreso de informacion presupuestaria');	 
        
        $tipo = $this->bd->retorna_tipo();
		
         
        
        $resultado = $this->bd->ejecutar("SELECT   codigo, detalle AS nombre
                                           FROM presupuesto.pre_catalogo
                                          WHERE categoria = 'actividad' and estado = 'S'");

        $evento2 ='';
        
        $this->obj->list->listadbe($resultado,$tipo,'Actividad','actividad',$datos,'','',$evento2,'div-2-10');
        
        
        
        $resultado = $this->bd->ejecutar("SELECT   codigo, codigo || ' ' || detalle AS nombre
                                           FROM presupuesto.pre_catalogo
                                          WHERE categoria = 'clasificador' and subcategoria = 'gasto' and nivel = 2  and estado = 'S'");
        
        
      
        
        $this->obj->list->listadbe($resultado,$tipo,'Grupo','grupo',$datos,'','',$evento2,'div-2-10');
        
         
        $resultado = $this->bd->ejecutar("Select '-' as codigo , ' [ Seleccione la Fuente ]' as nombre union 
                                          SELECT   codigo, codigo || ' ' || detalle AS nombre
                                           FROM presupuesto.pre_catalogo
                                          WHERE categoria = 'fuente'  and estado = 'S'");
        
        
 
        $evento2 =  'onChange="PonePartida(this.value)"';
        
        $this->obj->list->listadbe($resultado,$tipo,'Fuente','fuente',$datos,'','',$evento2,'div-2-10');
        
        
        $evento2 =  'onChange="PoneSaldo(this.value)"';
        
        $this->obj->list->listadbe($resultado,$tipo,'Partida','partida',$datos,'','',$evento2,'div-2-10');
        
        
        $this->obj->text->text('SALDO DISPONIBLE','texto','saldo',30,30,$datos ,'','readonly','div-2-4') ;
        
        
        $MATRIZ = array(
            ''  => '-',
            'I'  => 'Aplica Iva',
            'T'  => 'Aplica Tarifa Cero'
        );
        
        $evento = 'onChange="LimpiaDatosPartida()"';
        
        $this->obj->list->listae('Aplica',$MATRIZ,'tipo_aplica',$datos,'','',$evento,'div-2-4');
        
        $evento = 'onChange="PoneCalculo(this.value)"';
      
       
        $this->obj->text->texte('Monto Base','texto','base',30,30,$datos ,'required','',$evento,'div-2-4') ;
        
        $this->obj->text->text('Monto IVA','texto','iva',30,30,$datos ,'required','','div-2-4') ;
        
       
        
        $this->obj->text->text('Certificado','texto','certificado',30,30,$datos ,'required','','div-2-4') ;
        
        $this->obj->text->text('Compromiso','texto','compromiso',30,30,$datos ,'','readonly','div-2-4') ;
        
        $this->obj->text->text('Devengado','texto','devengado',30,30,$datos ,'','readonly','div-2-4') ;
     
 
 	    $this->obj->text->texto_oculto("id_tramite_det",$datos); 
 	    
 	    $this->obj->text->texto_oculto("actionProducto",$datos); 
 	    
 	    $this->obj->text->texto_oculto("id_tramite_prod",$datos); 
	    
 	    
	  
        $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
       
     $eventoi = "javascript:Limpiar_producto()";
     
     $ToolArray = array(
         array( boton => 'Nuevo Ingreso', evento =>$eventoi,  grafico => 'icon-white icon-plus' ,  type=>"button"),
         array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")
     );
     
     
     $this->obj->boton->ToolMenuDivId($ToolArray,'guardarProducto'); 
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
   
  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   
?>
