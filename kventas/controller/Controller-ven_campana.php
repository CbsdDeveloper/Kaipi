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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                
                $this->hoy 	     =  date("Y-m-d");    	
        
                
               $this->formulario = 'Model-ven_campana.php'; 
   
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
                
                
                $this->set->div_panel(utf8_encode  ('<b> CREAR CAMPAÑA </b>'));
                    
                    
                    
                 
                $this->obj->text->text( ('Campaña'),"number" ,'id_campana' ,80,80, $datos ,'','readonly','div-2-10') ;
                    
                    
                    $resultado =$this->bd->ejecutar("select '0' as codigo, 'Seleccionar Grupo' as nombre union
                                        select idvengrupo as codigo, grupo as nombre
            			                     from ven_cliente_grupo where estado = 'S' order by 1");
                    
                    
                    $evento = 'Onchange="ListaGrupo(this.value);"';
                    
                    $this->obj->list->listadbe($resultado,$tipo,'<b>GRUPO </b>','idvengrupo',$datos,'','',$evento,'div-2-10');
                    
                    $this->obj->text->text('Titulo',"texto" ,'titulo' ,100,100, $datos ,'required','','div-2-10') ;
                    
                    $this->obj->text->text_date('Fecha Inicio',$this->hoy  ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    
                    $this->obj->text->text_date('Fecha Cierre',$this->hoy  ,'fecha_cierre' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $evento = '';
                    
    
                    $MATRIZ = array(
                        'email grupo' => 'email grupo',
                        'telefono'  => 'telefono',
                        'whatsapp'  => 'whatsapp'
                    );
                    
                    $this->obj->list->listae('Medio',$MATRIZ,'medio',$datos,'','',$evento,'div-2-4');
                    
                    
                    $MATRIZ = array(
                        'S'  => 'Si',
                        'N' => 'No',
                        'X' => 'Finalizado'
                    );
                    
                    $this->obj->list->listae('Publicar',$MATRIZ,'publica',$datos,'','',$evento,'div-2-4');
                
                     
                    $resultado =$this->bd->ejecutar("select '0' as codigo, 'Seleccionar Responsable Ventas' as nombre union
                                        select idusuario as codigo, completo as nombre
            			                     from par_usuario   where responsable= 'S' and estado = 'S' order by 1");
                    
                    
                    $evento = '';
                    
                    $this->obj->list->listadbe($resultado,$tipo,'Responsable','idresponsable',$datos,'','',$evento,'div-2-10');
                   
                     
                    $this->set->div_panel('fin');
                       
            
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   $eventoi = "javascript:window.print();";
 
   
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
   
  
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }    

 
   $gestion   = 	new componente;
    
   $gestion->Formulario();
   
   ?>
  