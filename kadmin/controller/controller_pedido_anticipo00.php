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
      private $anio;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-pedido_anticipo.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;       
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
     
      //---------------------------------------
      
     function Formulario(  $id  ){
      
   
 
                $datos = array();
    
 
               
                $datos = $this->bd->query_array('view_anticipo_solicitud',   // TABLA
	                                'id_anticipo as vid_anticipo,
                                  idprov as vidprov,
                                  funcionario as vfuncionario,
                                  idprov_ga as vidprov_ga,
                                  garante as vgarante,
                                  detalle as vdetalle,
                                  solicita as vsolicita,
                                  mensual as vmensual,
                                  plazo as vplazo,
                                  rige as vrige,
                                  fecha as vfecha,
                                  documento as vdocumento,
                                  sueldo_ga as vsueldo_ga,
                                  cargo_ga as vcargo_ga
                                  ',                        
	                                'id_anticipo='.$this->bd->sqlvalue_inyeccion(  $id,true) // CONDICION
	           );
 
          
     
               $this->set->div_panel12('<b>Información Solicitante</b>');
                

                        $this->obj->text->text('Tramite','texto','vid_anticipo',10,10,$datos ,'','readonly','div-2-10') ;
                        
                        $this->obj->text->text_blue('<b>Funcionario</b>',"texto",'vfuncionario',40,45,$datos,'required','readonly','div-2-4');
                        $this->obj->text->text_blue('Identificacion','texto','vidprov',10,10,$datos ,'','readonly','div-2-4') ;

                        $this->obj->text->editor('Motivo','vdetalle',3,75,500,$datos,'required','','div-2-10') ;


                        $this->obj->text->text_yellow('<b>Garante</b>',"texto",'vgarante',40,45,$datos,'required','readonly','div-2-4');
                        $this->obj->text->text_yellow('Identificacion','texto','vidprov_ga',10,10,$datos ,'','readonly','div-2-4') ;
                        $this->obj->text->text_blue('Cargo','texto','vcargo_ga',10,10,$datos ,'','readonly','div-2-4') ;
                        $this->obj->text->text_blue('Sueldo','number','vsueldo_ga',10,10,$datos ,'','readonly','div-2-4') ;

                    
                        $this->set->div_label(12,'Condiciones Anticipo');	 
                        $this->obj->text->text_blue('<b>Solicita</b>','number','vsolicita',10,10,$datos ,'','readonly','div-2-4') ;
                        $this->obj->text->text_blue('Plazo','number','vplazo',10,10,$datos ,'','readonly','div-2-4') ;
                        $this->obj->text->text_blue('Mensual','number','vmensual',10,10,$datos ,'','readonly','div-2-4') ;
                       
                        $nmes            = $datos['vrige'];
                        $mes             = $this->bd->_mes($nmes);
                        $datos['vmes']   = $mes;


                     
                        $this->obj->text->text_blue('<b>Documento</b>','texto','vdocumento',10,10,$datos ,'','readonly','div-2-4') ;
                        $this->obj->text->text_blue('Fecha','date','vfecha',10,10,$datos ,'','readonly','div-2-4') ;
                        $this->obj->text->text_blue('Rige Desde','texto','vmes',10,10,$datos ,'','readonly','div-2-4') ;
 
                      
                $this->set->div_panel12('fin');
                 


               $this->set->div_panel12('<b>Observaciones/Novedades</b>');
       

               $this->obj->text->editor('Comentario','comentario',4,75,500,$datos,'required','','div-2-6') ;
        
              $this->set->div_panel12('fin'); 
             
            
 
  
      
   }
    
  
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $id        = $_GET['id'];

   $gestion->Formulario( $id   );

 ?>
 