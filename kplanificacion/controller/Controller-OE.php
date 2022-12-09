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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-OE.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
 
      
     function Formulario( ){

        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
             
        $this->BarraHerramientas();
        
        $datos = array();
        
        $tipo = $this->bd->retorna_tipo();
        
        $evento = '';
        
         
        $this->set->div_label(12,' <b>OBJETIVO RELACIONADO</b>');	 
        
        $MATRIZ = array(
            '1'    => '1.- PLAN NACIONAL DE DESARROLLO ',
            '2'    => '2.-  POLITICA/PDOT ESTRATEGIA NACIONAL/LOCAL',
            '3'    => '3.- PLAN ESTRATEGICO INSTITUCIONAL PEI' 
            
        );
        
        $this->obj->list->listae('Nivel Estrategias',$MATRIZ,'nivel',$datos,'','',$evento,'div-2-4');
        
        $this->set->div_label(12,'<b>DETALLE DEL OBJETIVO</b>');	 
        
        $MATRIZ = array(
        'N'    => 'NO',
        'S'    => 'SI'
          );
        
        $evento = '';
        
        $this->obj->text->text_yellow('Id',"number",'idestrategia',40,45,$datos,'required','readonly','div-2-4') ;
        
        $this->obj->list->listae('Activo',$MATRIZ,'estado',$datos,'','',$evento,'div-2-4');
        
        
        $this->obj->text->editor('<b>Estrategia/Objetivo</b>','objetivoe',3,250,250,$datos,'','','div-2-10');
        
        $MATRIZ = array(
            'Comunidad'    => 'Comunidad',
            'Institucional'    => 'Institucional',
            'Servicios'    => 'Servicios'
        );
        $this->obj->list->listae('Ambito',$MATRIZ,'ambito',$datos,'','',$evento,'div-2-4');
        
        
        $MATRIZ = array(
            'Desarrollo regional'    => 'Desarrollo regional',
            'Desarrollo Local'    => 'Desarrollo Local',
            'Fomentar las actividades productivas'    => 'Fomentar las actividades productivas',
            'Cumplimiento de sus competencias'    => 'Cumplimiento de sus competencias',
        );
        $this->obj->list->listae('Aporte a',$MATRIZ,'aporte',$datos,'','',$evento,'div-2-4');
     

        $MATRIZ = array(
            'N'    => 'NO',
            'S'    => 'SI'
              );

              $this->obj->list->lista('Ultimo Nivel',$MATRIZ,'univel',$datos,'','','div-2-4');
        
        

        $this->obj->text->text_yellow('Siglas',"texto" ,'siglas' ,15,15, $datos ,'required','','div-2-4') ;

         
        
        
        $this->set->div_label(12,'<b>ARTICULAR OBJETIVOS NIVEL 1 Y 2</b>');	 
        
        $evento    = '';
        $resultado = $this->sql(1);
        $this->obj->list->listadbe($resultado,$tipo,'<b>1.- PLAN NACIONAL DE DESARROLLO</b>','idestrategia_matriz',$datos,'','',$evento,'div-5-7');
        
         
        $resultado = $this->sql(2);
        $this->obj->list->listadbe($resultado,$tipo,'<b>2. -POLITICA/PDOT ESTRATEGIA NACIONAL/LOCAL</b>','idestrategia_padre',$datos,'','',$evento,'div-5-7');
        
        
        
        
 
        
        
        $this->obj->text->texto_oculto("action",$datos); 
                
        
        
     
                    
     
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
   
       $eventoe = "EliminarInformacion()";
       
    $ToolArray = array( 
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Eliminar Informacion', evento =>$eventoe,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger") ,
                );
     
    $this->obj->boton->ToolMenuDiv($ToolArray);
    
   
 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 
  
  //----------------------------------------------
  function sql($titulo){
    
      
      if  ($titulo == 1){
          
          $sqlb = "SELECT  0 as codigo, '-- 0. Seleccionar dato  --'  AS nombre union
                    SELECT  idestrategia as codigo, '[' || nivel ||'] ' || SUBSTR(objetivoe,1,200) AS nombre
                    FROM  planificacion.pyestrategia
                    where nivel = '1'  and
                          estado =".$this->bd->sqlvalue_inyeccion('S', true).' order by 1';
          
      }
      
      
      
      if  ($titulo == 2){
          
          
          $sqlb = "SELECT  0 as codigo, '-- 1. Seleccionar dato  --'  AS nombre union
                    SELECT  idestrategia as codigo, '[' || nivel ||'] ' || SUBSTR(objetivoe,1,200) AS nombre
                    FROM  planificacion.pyestrategia
                    where nivel = '2'  and
                          estado =".$this->bd->sqlvalue_inyeccion('S', true).' order by 1';
          
          
          
      }
      
      
      
      $resultado = $this->bd->ejecutar($sqlb);
      
      
      return  $resultado;
      
  }  ///------------------------------------------------------------------------
  }
  
  
  $gestion   = 	new componente;
  
  $gestion->Formulario( );
  
 ?>
 

  