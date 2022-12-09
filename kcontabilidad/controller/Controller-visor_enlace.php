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
      private $anio;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
                
               $this->formulario = 'Model-visor_enlace.php'; 
   
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
      
 
     	$this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
    
      	
     	$datos = array();
 
 
    
                $this->BarraHerramientas();
                    
                 
               
                
                $this->obj->text->text('Nro.Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-2-4') ;
                
                
                $this->obj->text->text('Nro.Referencia',"number",'id_asientod',0,10,$datos,'','readonly','div-2-4') ;
                
  
                $this->obj->text->text('idtramite',"number",'id_tramite',0,10,$datos,'','readonly','div-2-4') ;
                
                
                $this->obj->text->text('fecha',"date",'fecha',0,10,$datos,'','readonly','div-2-4') ;
                
                $this->obj->text->text_blue('Debe',"number",'debe',0,10,$datos,'','readonly','div-2-4') ;
                $this->obj->text->text_blue('Haber',"number",'haber',0,10,$datos,'','readonly','div-2-4') ;
                
                $tipo = $this->bd->retorna_tipo();
                $resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE PARTIDA ]' as nombre "  );
                 
                
                $this->obj->list->listadb($resultado,$tipo,'Partida','partida',$datos,'required','','div-2-4');  
           
                
                $tipo = $this->bd->retorna_tipo();
                $resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE PARTIDA (*) ]' as nombre "  );
                
                $this->obj->list->listadb($resultado,$tipo,'Partida(*)','partidap',$datos,'required','','div-2-4');  
                
                
                $this->obj->text->texto_oculto("action",$datos); 
                
                
                $this->set->div_label(12,'Informacion Complementaria');
                
                echo '<a href="#" title="Ver Enlaces" onclick="AbrirEnlace()">
                <img src="../../kimages/05_.png" align="absmiddle"> Enlaces </a>';
            
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   	
    
    $ToolArray = array( 
             array( boton => 'Generar Pago de Factura', evento =>'', grafico => 'glyphicon glyphicon-ok' ,  type=>"submit") ,
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