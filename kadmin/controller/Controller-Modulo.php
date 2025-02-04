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
        
                
               $this->formulario = 'Model-modulo_sistema.php'; 
   
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
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                     
                 
                
                        $tipo = $this->bd->retorna_tipo();
    
                
                       $resultado = $this->bd->ejecutar("select id_par_modulo as codigo, modulo as nombre
								from par_modulos
							    where fid_par_modulo = 0 and id_par_modulo  <> 3");
                        
                        
                        $this->obj->list->listadb($resultado,$tipo,'Modulo','fid_par_modulo',$datos,'required','','div-2-4');
                        
                        $this->obj->text->text('Id',"number",'id_par_modulo',0,10,$datos,'required','','div-2-4') ; 
                        
   
                        $this->obj->text->text('Nombre',"texto",'modulo',50,50,$datos,'required','','div-2-10') ; 
                        
                        
                        $MATRIZ =  $this->obj->array->catalogo_sino();
                        $this->obj->list->lista('Estado',$MATRIZ,'estado',$datos,'required','','div-2-4');
                         
                        $MATRIZ = array(
                            'O'    => 'Publica',
                            'N'    => 'No Publica'
                        );
                        
                        $this->obj->list->lista('publica',$MATRIZ,'publica',$datos,'required','','div-2-4');
                        
                        
                        $MATRIZ = array(
                            'A'    => 'Gestion',
                            'B'    => 'Parametros',
                            'C'    => 'Reportes'
                        );
                        
                        $this->obj->list->lista('Gestion',$MATRIZ,'script',$datos,'required','','div-2-4');
                        
                        
                        $MATRIZ = array(
                            'F'    => 'Menu Lateral Financiero',
                            'A'    => 'Menu Lateral Admin',
                            'X'    => 'Pantalla Inicial',
                            'E'    => 'Menu CMS'
                        );
                        
                        $this->obj->list->lista('Opcion Pantalla',$MATRIZ,'tipo',$datos,'required','','div-2-4');
                        
                        
                        $this->obj->text->text('Vinculo',"texto",'vinculo',50,50,$datos,'required','','div-2-10') ; 
                        
                        $this->obj->text->text('Ruta',"texto",'ruta',50,50,$datos,'required','','div-2-10') ; 
                        
                        
                        $this->obj->text->text('Carpeta',"texto",'accion',50,50,$datos,'required','','div-2-10') ;
                        
                        $this->obj->text->text('Detalle',"texto",'detalle',50,50,$datos,'required','','div-2-10') ; 
                        
                        $this->obj->text->text('Orden',"texto",'logo',50,50,$datos,'required','','div-2-10') ; 
                       
 
                      
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
    //----------------------------------------------
   function combodbA(){
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  