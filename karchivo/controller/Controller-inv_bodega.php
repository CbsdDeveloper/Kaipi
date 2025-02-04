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
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-inv_bodega.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
 
     function Formulario( ){
      
       $titulo = '';
         
       $datos = array();
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
             
                $tipo = $this->bd->retorna_tipo();
                
               
                $this->set->div_panel7('<b> INFORMACION DE BODEGA</b>');
                
                	$this->obj->text->text('Id','number','idbodega',10,10, $datos ,'','readonly','div-2-4') ;
                	
                	$MATRIZ =  $this->obj->array->catalogo_sino();
                	
                	$this->obj->list->lista('Activo',$MATRIZ,'activo',$datos,'required','','div-2-4');
                	
                
                	$this->obj->text->text('Detalle Bodega','texto','nombre',50,50, $datos ,'required','','div-2-10') ;
                	
                 	$resultado = $this->bd->ejecutar("SELECT '-' AS codigo, ' RESPONSABLE BODEGA ' as nombre union
                                                        SELECT idprov AS codigo, razon as nombre
														FROM par_ciu 
                                                        where modulo = 'N' AND estado = 'S' ORDER BY 1");
                	
                	 
                	
                	$this->obj->list->listadb($resultado,$tipo,'Responsable','idprov',$datos,'','','div-2-10');
                	
                	
                  	 	
                	$this->obj->text->text('Ubicacion','texto','ubicacion',90,90, $datos ,'required','','div-2-10') ;
                	
                	$this->obj->text->editor('Detalle/Descripcion','competencias',3,45,300,$datos,'required','','div-2-10') ;
                	
                	
                	$this->obj->text->text_blue('Grupo Contable','texto','grupo',90,90, $datos ,'required','','div-2-10') ;
                	
                	

                	$this->set->div_panel7('fin');	
 
                      
                	$this->set->div_panel5('<b> ASIGNAR RESPONSABLES</b>');
                	
                	
                	
                	$resultado = $this->bd->ejecutar("SELECT ' - ' as codigo, ' [ Selecione Responsable Bodega ]' as nombre union
                                                    SELECT  email as codigo, completo as nombre
                                                    FROM  view_bodega_user
                                                    where empresas =". $this->bd->sqlvalue_inyeccion(trim($this->ruc),true)." or 
                                                          empresas= '0000000000000' order by 1" );
                                                                    	
                	
                	$evento = 'onChange="UserBodega(this.value,1);"';
                	
                	$this->obj->list->listadbe($resultado,$tipo,'Responsable','user_bodega',$datos,'required','',$evento,'div-2-10');
                   	
                	echo '<div id="ViewUser"> </div>';
                	
                    $this->set->div_panel5('fin');	
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
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
   function combodb(){
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
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
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>


 
  