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
	               
	           	   jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-periodo.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
   
            
        $this->BarraHerramientas();
        
        $datos = array();
         
        $this->set->div_label(12,'<h4><center><b>Defina el periodo y el proceso de la planificacion</center></b></h4>');
        
        
        $this->obj->text->text_yellow('Periodo',"number" ,'idperiodo' ,80,80, $datos ,'','readonly','div-2-4') ;
        
        $MATRIZ = array(
            '2019'    => '2019',
            '2020'    => '2020',
            '2021' => '2021',
            '2022' => '2022' 
        );
        
        $evento = '';
        $this->obj->list->listae('Anio ',$MATRIZ,'anio',$datos,'required','',$evento,'div-2-4');
        
        $MATRIZ = array(
            'proforma'    => 'proforma',
            'ejecucion'    => 'ejecucion',
            'cierre' => 'cierre'
        );
        
        $this->obj->text->text_blue('Detalle',"texto" ,'detalle' ,80,80, $datos ,'','readonly','div-2-10') ;
        
        $MATRIZPOA = array(
            'elaboracion'    => 'Elaboracion',
            'ejecucion'    => 'Ejecucion',
            'cierre' => 'Cierre'
        );
        $this->obj->list->listae('<b> Proceso POA </b>',$MATRIZPOA,'tipo',$datos,'required','',$evento,'div-2-4');
        
        
        $this->obj->list->listae('Estado ',$MATRIZ,'estado',$datos,'required','disabled',$evento,'div-2-4');
        

        
        

        
        $this->obj->text->text('Inicial',"date" ,'fechainicial' ,80,80, $datos ,'','','div-2-4') ;
        $this->obj->text->text('Final',"date" ,'fechafinal' ,80,80, $datos ,'','','div-2-4') ;
        
        $this->set->div_label(12,'Ultima modificacion');
        
        
        $this->obj->text->text('Modificado',"texto" ,'sesionm' ,80,80, $datos ,'','readonly','div-2-4') ;
        $this->obj->text->text('Fecha',"date" ,'modificacion' ,80,80, $datos ,'','readonly','div-2-4') ;
        
    
        $this->obj->text->texto_oculto("action",$datos); 
                
        
 
    
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
   
    $ToolArray = array( 
              //   array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add")
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") 
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
  
  
  $gestion   = 	new componente;
  
  $gestion->Formulario( );
  
 ?>
 

  