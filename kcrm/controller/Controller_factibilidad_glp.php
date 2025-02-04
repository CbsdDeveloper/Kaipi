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
  
    class Controller_factibilidad_glp{
 
  
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
      function Controller_factibilidad_glp( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
				
                $this->formulario = 'Model-clientes.php'; 
                
              	$this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
         
        $datos = array();
        
        $tipo = $this->bd->retorna_tipo();
         
        $this->set->_formulario( $this->evento_form,'inicio' ); 
        
        $this->BarraHerramientas();
        
        
        echo '<ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home"><b>1. INFORMACION PROYECTO</b></a></li>
                <li><a data-toggle="tab" href="#menu1"><b>2. INFORMACION TECNICA</b></a></li>
                <li><a data-toggle="tab" href="#menu2"><b>3. GEOLOCALIZACION</b></a></li>
         </ul>
             <div class="tab-content">
                    <div id="home" class="tab-pane fade in active" style="padding: 8px">';
                                      
                            $this->set->div_panel6('<b>1. INFORMACION PRINCIPAL </b>');
                            
                            
                                    $this->obj->text->text('Identificacion','texto','idprov',10,15,$datos ,'required','readonly','div-2-10') ;
                                    $this->obj->text->text('Razon','texto','razon',120,120,$datos ,'required','readonly','div-2-10') ;
                                    $this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','readonly','div-2-10') ;
                                    $this->obj->text->text('Estado','texto','factibilidad_estado',120,120,$datos ,'required','readonly','div-2-10') ;
                            
                                    $this->obj->list->listadb($this->ListaDB('parroquia'),$tipo,'Parroquia','factibilidad_parroquia',$datos,'required','','div-2-10');
                            
                            $this->set->div_panel6('fin');
                            $this->set->div_panel6('<b>1. UBICACION COMPLEMENTARIA </b>');
                            
                                     $this->obj->text->text('Principal',"texto" ,'factibilidad_principal' ,180,180, $datos ,'required','','div-2-10') ;
                                    $this->obj->text->text('Secundaria',"texto" ,'factibilidad_secundaria' ,180,180, $datos ,'required','','div-2-10') ;
                                    $this->obj->text->text('Manzana',"texto" ,'factibilidad_manzana' ,80,80, $datos ,'required','','div-2-10') ;
                                    $this->obj->text->text('Nro.lote',"texto" ,'factibilidad_lote' ,80,80, $datos ,'required','','div-2-10') ;
                                    $this->obj->text->text('Nro.Predio',"texto" ,'factibilidad_clavecatastral' ,80,80, $datos ,'required','','div-2-10') ;
                            
                            
                            $this->set->div_panel6('fin');
        
              echo '</div>
                    <div id="menu1" class="tab-pane fade" style="padding: 8px">';
                  
              
              echo ' </div>
                        <div id="menu2" class="tab-pane fade" style="padding: 8px">
                    </div>
            </div>';
        
        
        /*
       
        
        
      
        
        
        

        $this->obj->text->text('Factibilidad_longitud',"texto" ,'factibilidad_longitud' ,80,80, $datos ,'required','','div-2-4') ;
        $this->obj->text->text('Factibilidad_latitud',"texto" ,'factibilidad_latitud' ,80,80, $datos ,'required','','div-2-4') ;
        
        
        $this->set->div_panel6('fin');
        
        
        $this->obj->text->text('Factibilidad_proyecto',"texto" ,'factibilidad_proyecto' ,80,80, $datos ,'required','','div-2-4') ;
        $this->obj->text->text('Factibilidad_codigo',"texto" ,'factibilidad_codigo' ,80,80, $datos ,'required','','div-2-4') ;
        $this->obj->text->text('Factibilidad_serie',"number" ,'factibilidad_serie' ,80,80, $datos ,'required','','div-2-4') ;
        
        */
        /*
      
        
        echo '<h6> &nbsp; </h6>';
        
       
		
        $datos = array();

        $MATRIZ =  $this->obj->array->catalogo_tipoCiu();
	
	$this->obj->list->lista('Tipo',$MATRIZ,'tpidprov',$datos,'required','','div-2-4');
	
	$this->obj->text->text('Identificacion','texto','idprov',10,15,$datos ,'required','','div-2-4') ;
	
	
	$this->obj->text->text('Razon','texto','razon',120,120,$datos ,'required','','div-2-10') ;
	
	
	
	
	
	$this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text('Telefono','texto','telefono',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text('Email','texto','correo',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text('FechaNacimiento','date','nacimiento',10,10,$datos ,'required','','div-2-4') ;
	
	  
	$datos['estado'] = 'S';
	$datos['naturaleza'] = 'NN';
	 
   
	$this->obj->text->texto_oculto("estado",$datos); 
	$this->obj->text->texto_oculto("naturaleza",$datos); 
	*/
		
	        $this->obj->text->texto_oculto("action",$datos); 
	        $this->obj->text->texto_oculto("idcaso",$datos); 
	        $this->obj->text->texto_oculto("id_par_ciu",$datos); 
	        $this->obj->text->texto_oculto("id_rubro",$datos); 
	        
	        
        
	        
    	 
	 $this->set->_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
      
     
    $ToolArray = array( 
                        array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
    
                  
    $this->obj->boton->ToolMenuDivCrm($ToolArray); 
    
  }  
 
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  function ListaDB( $titulo){
  	
  	if ($titulo == 'parroquia'){
  	    
  		$resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre
			                     from par_catalogo
								where tipo = 'PARROQUIAS' and publica = 'S' order by nombre ");
  	}
  
  	
  	return $resultado;
  	
  }   
  
  //----------------------------------------------
 }  
 
    $gestion   = 	new Controller_factibilidad_glp;
   
    $gestion->Formulario( );
   
?>