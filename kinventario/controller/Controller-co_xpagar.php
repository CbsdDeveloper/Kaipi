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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-co_xpagar.php'; 
   
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
      
     function Formulario( $id ){
      
        $datos   = array(); 
        $titulo  = 'CxPagar';
        $tipo    = $this->bd->retorna_tipo();
        
        $datos = $this->bd->query_array('inv_movimiento',
            '*',
            'id_movimiento='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
         
        
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
      
                $datos["idmovimiento"]        = $id;
                $datos["fecharegistro"]       = $datos["fecha"];
                
                   
                $this->obj->text->text_yellow('Movimiento',"number",'idmovimiento',0,10,$datos,'','readonly','div-2-4') ;
                $this->obj->text->text_yellow('Tramite',"texto",'id_tramite',15,15,$datos,'','readonly','div-2-4');
                
                $this->obj->text->text('Fecha',"date",'fecharegistro',15,15,$datos,'required','','div-2-4');
                $this->obj->text->text('Identificacion',"texto",'idprov',15,15,$datos,'','readonly','div-2-4');
                $this->obj->text->text('Estado',"texto",'estado',15,15,$datos,'','readonly','div-2-4');
              
                
                $this->set->div_label(12,'<h6><b>Detalle Costo</b> </h6>');
           
                
                
                $resultado = $this->bd->query_sql('nom_departamento',
                    'id_departamento,nombre',
                    "ambito ='PROYECTOS'",
                    '2 asc',
                    "N");
                
                
                
                $this->obj->list->listadb($resultado,$tipo,'Cargo a Proyecto','id_asiento_ref',$datos,'required','','div-2-10');
                  
            
                $this->set->div_label(12,'<h6><b>Monto Factura</b> </h6>');
                      
                 $this->obj->text->text_blue('Base Imponible',"number",'base12',40,45,$datos,'required','readonly','div-2-4') ;
                
                $this->obj->text->text_blue('Monto Iva',"number",'iva',40,45,$datos,'required','readonly','div-2-4') ;
                
                $this->obj->text->text_blue('Base Imponible 0%',"number",'base0',40,45,$datos,'required','readonly','div-2-4') ;
                
              
                $this->obj->text->text_blue('Total',"number",'total',40,45,$datos,'required','readonly','div-2-4') ;
             
                
         $this->obj->text->texto_oculto("action",$datos); 
         
          
      
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
  
  
   //-------------
  
   //----------------------------------------------
   function BarraHerramientas(){
 
   	
    $ToolArray = array( 
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") 
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
  }  
///------------------------------------------------------------------------
  
  //---
  function div_resultado($accion,$id,$tipo,$estado){
      //inicializamos la clase para conectarnos a la bd
      
      echo '<script type="text/javascript">accion('.$id.',"'.$accion.'","'.trim($estado).'"  );</script>';
      
      if ($tipo == 0){
          
          if ($accion == 'editar'){
              $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>';
          }
          
         
          
       }
      
      if ($tipo == 1){
          
          $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Registro Actualizado</b><br>';
          
           
      }
      
     
      
      
      return $resultado;
      
  }
///------------------------------------------------------------------------
  }
 ///------------------------------------------------------------------------
 ///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
   
  $id            = $_GET['idmov'];
  
  $gestion->Formulario( $id );
  

   

     
  
 
  
 ?>
  