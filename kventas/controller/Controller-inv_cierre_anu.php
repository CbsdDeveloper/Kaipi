<script>// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
	             jQuery('#result').html(data);
 	             
	             jQuery('#result').slideUp( 300 ).delay( 0 ).fadeIn( 400 ); 
            
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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =     date("Y-m-d");    	
                
				$this->formulario = 'Model-inv_cierre.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
         
        $titulo = '';
        
        $datos = array();
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 	     
          
        
        $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
        
        $datos['novedad'] = 'Por anulacion secuencia comprobante electronico';
        $datos['fecha'] =  $this->hoy ;
        
        
         
        echo'<div class="col-md-12"><br>
               <div class="alert alert-danger">
                <div class="row">
                    <div class="col-md-6">';
                        echo '<h6 align="center">
                               <img src="../../kimages/use.png" align="absmiddle" />
                               &nbsp;Caja Abierta : '.$ACaja['completo'] .' </h6>' ;
        
            $this->obj->text->text('Transaccion','number','id_movimiento',10,10,$datos ,'','readonly','div-2-10') ;
            $this->obj->text->text('<b>NRO.FACTURA</b>','texto','comprobante',10,10,$datos ,'','','div-2-4') ;
            $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
            
            $this->obj->text->editor('Novedad','novedad',2,75,500,$datos,'','','div-2-10') ;
        
        echo '</div></div></div></div>';
      
      
         
         
       
          $this->obj->text->texto_oculto("estado",$datos); 
		  $this->obj->text->texto_oculto("action",$datos); 
          $this->set->evento_formulario('-','fin'); 
          
        
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
     if ( $autoriza == 'S') {
       
             $titulo = '';
             $evento = 'javascript:secuencia_anulada()';
             
             $ToolArray = array(
                  array( boton => 'Generar Novedad Factura - Secuencia',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
             );
             
             $this->obj->boton->ToolMenuDivTitulo($ToolArray,$titulo); 
     
      }else{
          
          echo '<b>NO SE ENCUENTRA ASIGNADO COMO CAJERO(A)...</b>';
          
      }
 
   
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
     
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
 
  