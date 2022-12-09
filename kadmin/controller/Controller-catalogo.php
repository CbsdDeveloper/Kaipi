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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-admin_catalogo.php'; 
   
               $this->evento_form = '../model/Model-admin_catalogo.php';        // eventos para ejecucion de editar eliminar y agregar 
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
      

        $sql = "SELECT '-' as codigo, ' --  0. CATALOGOS DISPONIBLES  --  ' as nombre UNION
        SELECT  tipo as codigo, upper(tipo) as nombre
        FROM par_catalogo
        group by tipo
        order by 2 " ;
        
        $resultado  =  $this->bd->ejecutar($sql);

        $tipo       = $this->bd->retorna_tipo();

        $datos      = array();
 
        $MATRIZ    =  $this->obj->array->catalogo_general();
        $MATRIZ_SN =  $this->obj->array->catalogo_activo();

        $MATRIZ_S = array(
            'G'    => 'General',
            'S'    => 'Servicios'
        );
 

        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab('Catalogo','inicio');
    
                $this->BarraHerramientas();
                     
                            $this->obj->text->text('Id',"number",'idcatalogo',0,10,$datos,'','readonly','div-2-4') ; 
                            
                            $this->obj->list->listadb($resultado,$tipo,'<b>CATALOGO</b>','tipo',$datos,'required','','div-2-4');	
                            
                            $this->obj->text->text_yellow('Catalogo',"texto",'nombre',50,50,$datos,'required','','div-2-10') ;  
                            
                            $this->obj->text->text_blue('Referencial',"texto",'codigo',50,50,$datos,'required','','div-2-4') ;   
                            
                            $this->obj->text->text('Secuencia',"number",'secuencia',0,15,$datos,'required','','div-2-4') ;
                            
                            $this->obj->list->lista('Estado',$MATRIZ_SN,'publica',$datos,'required','','div-2-4'); 
                    
                            $this->obj->list->lista('Enlace',$MATRIZ_S,'modulo',$datos,'required','','div-2-4'); 


                $this->set->div_label(12,' VALORES ADICIONALES');	 

                            $this->obj->text->text('Valor1',"number",'valor1',0,15,$datos,'required','','div-2-4') ;
                            $this->obj->text->text('Valor2',"number",'valor2',0,15,$datos,'required','','div-2-4') ;
                            $this->obj->text->text('Valor3',"number",'valor3',0,15,$datos,'required','','div-2-4') ;
                            $this->obj->text->text('Valor4',"number",'valor4',0,15,$datos,'required','','div-2-4') ;

                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
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
 
  