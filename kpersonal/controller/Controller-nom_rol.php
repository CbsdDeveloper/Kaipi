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
      private $anio;
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
                
                $this->hoy 	     =  date("Y-m-d");   
        
                $this->anio       =  $_SESSION['anio'];
              
   
               $this->evento_form = '../model/Model-nom_rol.php';        // eventos para ejecucion de editar eliminar y agregar 
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
   
        $this->set->body_tab('','inicio');
 
        
        $datos['fecha'] = $this->hoy ;
    
                $this->BarraHerramientas();
                
                $tipo = $this->bd->retorna_tipo();
                
                $this->obj->text->text('Nro. Rol',"number",'id_rol',40,45,$datos,'required','readonly','div-2-4') ;
                
                $resultado = $this->bd->ejecutar("select id_periodo as codigo,  mesc || '-' || mes  || '-' || anio   as nombre
								from co_periodo
								where estado = 'abierto' and anio =".$this->bd->sqlvalue_inyeccion($this->anio , true)." and 
                                      registro=".$this->bd->sqlvalue_inyeccion($this->ruc , true).' order by 1 asc');
                
                
                $evento = 'onChange="ShowSelected()"';
                
                
                $this->obj->list->listadbe($resultado,$tipo,'Nro. periodo ','id_periodo',$datos,'required','',$evento,'div-2-4'); 
                
                $this->obj->text->text('Anio gestion',"number",'anio',2010,2020,$datos,'required','','div-2-4') ;
                
                $MATRIZ =    $this->obj->array->catalogo_mes();	// lista de valores
                
                $this->obj->list->lista('Mes gestion',$MATRIZ,'mes',$datos,'required','','div-2-4');
                
                $evento = '';
                
                $MATRIZ =  $this->obj->array->catalogo_sino();
                $this->obj->list->listae('Cerrado',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-4');
                
         
                $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->text('Novedad',"texto" ,'novedad' ,80,80, $datos ,'required','','div-2-10') ;
                    
                
                $MATRIZ = array(
                    '0'    => 'Normal',
                    '1'    => 'Decimo14',
                    '2'    => 'Decimo13',
                );
                
                $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'required','','div-2-4');
            
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
   $evento1 = 'javascript:CerrarPeriodo();';
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Cerrar Periodos ', evento =>$evento1,  grafico => 'glyphicon glyphicon-alert' ,  type=>"button")
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
 
  