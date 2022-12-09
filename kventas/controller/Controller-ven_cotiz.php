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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ven_cotiz.php'; 
   
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
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
   
                
                $this->obj->text->text('<b>TRAMITE</b>',"texto",'idven_gestion',80,95,$datos,'','readonly','div-2-10') ;
                
                 
                $this->obj->text->text('<b>NOMBRE</b>',"texto",'razon_nombre',80,95,$datos,'','readonly','div-2-10') ;
                  
                $MATRIZ = array(
                    '1'  => '1. Proceso de Negociacion',
                    '2'  => '2. Condiciones Comerciales',
                    '3'  => '3. (*) Emitir Facturar Servicios/Bienes',
                    '4'  => '4. Tramites Finalizados',
                     '0'  => 'Anulada transaccion'
                 );
                
           
                
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'','',$evento,'div-2-4');
                
 
                $MATRIZ = array(
                     'seguimiento'  => 'Seguimiento',
                     'llamar'  => 'Llamar',
                     'reunion'  => 'Reunion',
                     'email'  => 'Enviar Email',
                     'whastapp'  => 'Enviar Whastapp',
                     'por facturar'  => 'Por Facturar',
                     'no aplica'  => 'no aplica',
                );
                
                $this->obj->list->listae('<b>Evento</b>',$MATRIZ,'canal',$datos,'','',$evento,'div-2-4');
                
                
                $this->obj->text->editor('Novedad','novedad',3,45,300,$datos,'required','','div-2-10') ;
                
                 
                $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
                
                
                $this->obj->text->text('Hora','time','hora',10,10,$datos ,'','','div-2-4') ;
              
                $this->set->div_label(12,'GESTION DE VENTAS');
                
                $tipo = $this->bd->retorna_tipo();
                
                $resultado = $this->bd->ejecutar("select '-' as codigo , ' [ No Aplica ]' as nombre union
                                                   SELECT idprov AS codigo, razon as nombre
													FROM par_ciu
                                                    where modulo = 'N' AND 
                                                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc ,true)." and 
                                                          estado = 'S' ORDER BY 1 asc ");
                
                
                
                $this->obj->list->listadb($resultado,$tipo,'Responsable Ventas','vendedor',$datos,'required','','div-2-6');
   
      	  $this->obj->text->texto_oculto("action",$datos); 
      	 
          $this->obj->text->texto_oculto("idprov_cotiza",$datos);
            
          $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    $ToolArray = array( 
                array( boton => 'Enviar informacion', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
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
 