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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ven_interes.php'; 
   
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
                     
                  
                $this->obj->text->text('<b>POTENCIAL CLIENTE</b>',"texto",'razon_nombre',70,70,$datos,'','readonly','div-2-10') ;
                
                $MATRIZ = array(
                    '0'  => 'No esta interesado',
                    '3' => 'Potencial Cliente',
                    '4' => 'Interesado En espera',
                    '5'  => 'Interesado sin confirmar',
                    '6'  => 'Interesado confirmado'
                );
                
                $this->obj->list->listae('Proceso',$MATRIZ,'estado_proceso',$datos,'','',$evento,'div-2-10');
                
                    
                
                $MATRIZ = array(
                    'llamada'  => 'llamada',
                    'cita' => 'cita',
                    'reunion'  => 'reunion',
                    'no aplica'  => 'no aplica',
                );
                
                $this->obj->list->listae('Evento Proximo',$MATRIZ,'canal',$datos,'','',$evento,'div-2-10');
                
                 
        		  $this->obj->text->editor('Producto ofertado','producto',2,45,300,$datos,'required','','div-2-10') ;
        		
        		
        		 $this->obj->text->editor('Novedad','novedad',2,45,300,$datos,'required','','div-2-10') ;
        		
        		      
         $this->obj->text->texto_oculto("medio",$datos); 
      	 $this->obj->text->texto_oculto("action",$datos); 
         $this->obj->text->texto_oculto("idvengestion",$datos); 
           
         $this->obj->text->texto_oculto("idprov",$datos); 
         
       
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
    
  //----------------------------------------------
  function listaValores($titulo,$campo){
  	
  	
  	if  ($titulo == 'Unidad'){
  	 	   $sqlb = " SELECT  id_departamento as codigo,   nombre
							                FROM nom_departamento
							                WHERE id_departamento <> -1
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
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
}
    
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 