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
        
                $this->evento_form = '../model/Model-co_caja.php';        // eventos para ejecucion de editar eliminar y agregar 
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
 
        $tipo = $this->bd->retorna_tipo();
        
        $resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE BANCO ]' as nombre
          											FROM co_plan_ctas
          											where cuenta = '1' and registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true)."
                                        union
                                        SELECT cuenta as codigo, detalle as nombre
          											FROM co_plan_ctas
          											where tipo_cuenta = 'B' and univel = 'S' and
                                                          registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );
        
        
                $this->BarraHerramientas();
                     
                $this->obj->text->text('Nro. Caja',"number",'id_co_caja',40,45,$datos,'required','readonly','div-2-4') ;
                
                $this->obj->text->text('Anio gestion',"number",'anio',2010,2020,$datos,'required','','div-2-4') ;
                
                $MATRIZ =    $this->obj->array->catalogo_mes();	// lista de valores
                
                $this->obj->list->lista('Mes gestion',$MATRIZ,'mes',$datos,'required','','div-2-4');
                
                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
                
                $evento = '';
                
                $MATRIZ = array(
                'abierto'    => 'abierto',
                'cerrado'    => 'cerrado',
                );
                
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-4');
                
                
                $this->obj->list->listadb($resultado,$tipo,'Caja','cuenta',$datos,'required','','div-2-4');  
                
        
                $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;
                
               
                
                
                $this->obj->text->text('Sesion',"texto",'sesion',35,35,$datos,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Creacion',"texto",'creacion',35,35,$datos,'','readonly','div-2-4') ;
                
               
                
            
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:CrearPeriodo();';
   
   $evento1 = 'javascript:CerrarPeriodo();';
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
           /*     array( boton => 'Crear Periodos ', evento =>$evento,  grafico => 'glyphicon glyphicon-eye-open' ,  type=>"button"),
                array( boton => 'Cerrar Periodos ', evento =>$evento1,  grafico => 'glyphicon glyphicon-alert' ,  type=>"button")*/
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
 
  