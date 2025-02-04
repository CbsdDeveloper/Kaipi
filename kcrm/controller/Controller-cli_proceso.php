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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
     
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");  
        
                
               $this->formulario = 'Model-cli_proceso.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;         
      }
 
      //---------------------------------------
      
     function Formulario( ){
      
 
        $datos      = array();
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
   
                $this->BarraHerramientas();
                     
                
               echo '<ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">DEFINICION</a></li>
                <li><a data-toggle="tab" href="#menu1">PARAMETROS</a></li>
                <li><a data-toggle="tab" href="#menu2">OBJETIVOS</a></li>
                <li><a data-toggle="tab" href="#menu3">DIAGRAMA</a></li>
                </ul>';
                
                //--------------------------------------------------------------------------------
                // TAB 1
                //--------------------------------------------------------------------------------
                echo '<div class="tab-content"><div id="home" class="tab-pane fade in active"  style="padding: 20px;">';
                
		                $this->obj->text->text('Nro.Proceso',"number",'idproceso',40,45,$datos,'required','readonly','div-2-4') ;
		                
		                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
		                
		                $MATRIZ =  $this->obj->array->catalogo_activo();
		                
		                $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-10');
		                
		                
		                $this->obj->text->text('MACRO PROCESO',"texto",'macro_proceso',70,70,$datos,'required','','div-2-10') ;
		                
		                $this->obj->text->text_yellow('<b>PROCESO</b>',"texto",'nombre',70,70,$datos,'required','','div-2-10') ;
		                
  		                
		                $this->obj->text->text('SUB PROCESO',"texto",'subproceso',70,70,$datos,'required','','div-2-10') ;
		                
		                $MATRIZ = array(
		                		'Interno'    => 'Interno',
		                		'Externo'    => 'Externo'
 		                );
		                
		                $evento = '';
		                
		                $this->obj->list->listae('Ambito',$MATRIZ,'ambito',$datos,'','',$evento,'div-2-10');
		                
		                
		                $MATRIZ = array(
		                    'P'    => 'Personal',
		                    'S'    => 'Global'
		                );
		                
		                $evento = '';
		                
		                $this->obj->list->listae('Solicitud',$MATRIZ,'solicitud',$datos,'','',$evento,'div-2-10');
		             
        		echo '</div>';
        		//--------------------------------------------------------------------------------
        		// TAB 2
        		//--------------------------------------------------------------------------------
        		echo '<div id="menu1" class="tab-pane fade" style="padding: 20px;">';
           
		        		$MATRIZ = array(
		        				'Estrategico'    => 'Procesos estrategicos',
		        				'Clave'    => 'Procesos claves',
		        				'Operativos'    => 'Procesos operativos'
		        		);
		        		
		        		$this->obj->list->listae('Tipo',$MATRIZ,'tipo',$datos,'','',$evento,'div-2-10');
		        	
		        		$this->listaValores('Unidad','id_departamento');
		        		
		        		$this->listaValores('Responsable','responsable');
		        		
		        		$this->obj->text->editor('Marco Legal','legal',3,70,250,$datos,'','','div-2-10');
		        		
		        		$MATRIZ = array(
		        		    'N'    => 'No',
		        		    'S'    => 'Si'
		        		);
		        		
		        		$evento = '';
		        		
		        		$this->obj->list->listae('Generar Encuesta',$MATRIZ,'encuesta',$datos,'','',$evento,'div-2-10');
		       		
        		echo '</div>';
        		
        		//--------------------------------------------------------------------------------
        		// TAB 3
        		//--------------------------------------------------------------------------------
        		echo '<div id="menu2" class="tab-pane fade" style="padding: 20px;">';
        		
		        		$this->obj->text->editor('Objetivo','objetivo',2,70,250,$datos,'','','div-2-10');
		        		
		        		$this->obj->text->editor('Alcance','alcance',2,70,250,$datos,'','','div-2-10');
		        		
		        		$this->obj->text->editor('Entrada','entrada',2,70,250,$datos,'','','div-2-10');
		        		
		        		$this->obj->text->editor('Salida','salida',2,70,250,$datos,'','','div-2-10');
		        		
		        		$this->obj->text->editor('Disparador','disparador',2,70,250,$datos,'','','div-2-10');
		        		
		        		$this->obj->text->text('Indicador',"texto",'indicador',120,120,$datos,'required','','div-2-10') ;
              
        		echo '</div>';
        		//--------------------------------------------------------------------------------
        		// TAB 4
        		//--------------------------------------------------------------------------------
        		echo '<div id="menu3" class="tab-pane fade" style="padding: 25px;">';
        		
	        		$evento = '<a href="flowload" rel="pop-up" class="btn btn-primary btn-sm" title="1. Cargar Proceso formato SVG ">
	                              <span class="glyphicon glyphicon-floppy-open"></span>  </a> ';
	        		
	        	
	        		$MATRIZ = array(
	        		    'draw.io'    => 'Draw.io',
	        		    'bizagi'    => 'Bizagi'
 	        		);
	        		
	        		$this->obj->list->listae('Modelador',$MATRIZ,'modelador',$datos,'','','','div-2-10');
	        		
	        		$this->obj->text->text('Flujo '.$evento,"texto",'archivo',70,70,$datos,'required','readonly','div-2-10') ;
	        		
	        		
	        		
	        		
         		
        		echo '</div></div>';
      				
		                   
         $this->obj->text->texto_oculto("action",$datos); 
         
         
         $this->obj->text->texto_oculto("publica",$datos); 
         
           
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
    
    $eventop = 'javascript:limpiaGrafico()';
    
    $eventoc = 'javascript:AnulaGrafico()';
       
 
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  ,
                array( boton => 'Actualizar Grafico', evento =>$eventop,  grafico => 'glyphicon glyphicon-equalizer' ,  type=>"button") ,
                array( boton => 'Revertir Proceso', evento =>$eventoc,  grafico => 'glyphicon glyphicon-ban-circle' ,  type=>"button_default") 
        
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    
  //----------------------------------------------
  function listaValores($titulo,$campo){
  	
    $datos = array();
      
      
  	if  ($titulo == 'Unidad'){
  	 	   $sqlb = " SELECT  id_departamento as codigo,   nombre
							                FROM nom_departamento
							                WHERE id_departamento <> -1 and 
                                                  ruc_registro = ".$this->bd->sqlvalue_inyeccion($this->ruc  ,true)." 
							                order by id_departamento";
		  	
  	 	   
  	 	   
		  
		  	
  	}
  	
  	if  ($titulo == 'Responsable'){
  		$sqlb = "SELECT ltrim(rtrim(x.email))  as codigo ,  ltrim(rtrim(x.completo)) as nombre
		                                            FROM par_usuario x where estado = 'S' ORDER BY x.completo ";
  		
  		
  		
  	}
  	
  	$resultado = $this->bd->ejecutar($sqlb);
  	
  	$tipo = $this->bd->retorna_tipo();
  	
   	
  	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-10');
  	
  }  
 
 
}
    
 $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 <script>
		var posicion_x; 
		var posicion_y; 
			posicion_x=(screen.width/2)-(450/2); 
			posicion_y=(screen.height/2)-(200/2); 

	    	$( document ).ready( function() {
				$("a[rel='pop-up']").click(function () {
					var caracteristicas = "height=220,width=550,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			 });
			 
			posicion_x=(screen.width/2)-(550/2); 
			posicion_y=(screen.height/2)-(350/2); 
			
			 $("a[rel='pop-upo']").click(function () {
					var caracteristicas = "height=350,width=550,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			 });
		});
</script>