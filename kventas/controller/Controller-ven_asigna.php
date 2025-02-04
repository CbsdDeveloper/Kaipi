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
                   
                $this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ven_asigna.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;       
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
                
                
                    $this->set->div_panel6('<b> ASIGNACION DE  USUARIO VENTAS </b>');
                
                    
                    $resultado =$this->bd->ejecutar("select '0' as codigo, 'Seleccionar Grupo' as nombre union
                                        select idvengrupo as codigo, grupo as nombre
            			                     from ven_cliente_grupo where estado = 'S' order by 1");
                    
                    
                    $evento = 'Onchange="ListaGrupo(this.value);"';
                    
                    $this->obj->list->listadbe($resultado,$tipo,'<b>GRUPO </b>','idvengrupo',$datos,'','',$evento,'div-2-10');
                    
                    
                    
 
                    $resultado =$this->bd->ejecutar("select '0' as codigo, 'Seleccionar Responsable Ventas' as nombre union
                                        select idusuario as codigo, completo as nombre
            			                     from par_usuario   where estado = 'S' order by 1");
                    
                    
                    $evento = 'Onchange="ListaUsuario(this.value);"';
                    
                    $this->obj->list->listadbe($resultado,$tipo,'<b>Vendedor</b>','idusuario',$datos,'','',$evento,'div-2-10');
                    
                    
                   
                    $evento = '';
                    
                    $resultado =$this->bd->ejecutar("select '-' as codigo, 'SELECCIONAR SECTOR' as nombre union
                                        select nombre as codigo, nombre as nombre
            			                     from par_catalogo
            								where tipo = 'canton' order by 1");
                    
                    
                    
                    $this->obj->list->listadbe($resultado,$tipo,'<b>Sector</b> ','sector',$datos,'','',$evento,'div-2-10');
                    
                
                    $this->set->div_panel6('fin');
                      
                    
                    $this->set->div_panel6('<b> ASIGNACION DE USUARIOS POR ZONA</b>');
                    
                  
                    echo '<div id="asignado">asignado</div>';
 
    
                    $this->set->div_panel6('fin');
                    
                    
 
         
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   $eventoi = "javascript:window.print();";
    
   $evento = "javascript:asignaa()";
   
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Asignar Grupo - Usuario Vendedor', evento =>$evento,  grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"button"),
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
   //----------------------------------------------
   
  
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }    

 
   $gestion   = 	new componente;
    
   $gestion->Formulario();
   
   ?>
  