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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
				
                $this->formulario = 'Model-cli_incentivo.php'; 
              	$this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $titulo = '';
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 		
        $this->BarraHerramientas();
        
        echo '<h6> &nbsp; </h6>';
        
        $tipo = $this->bd->retorna_tipo();
		
        $datos = array();

        $MATRIZ =  $this->obj->array->catalogo_tipoCiu();
	
	$this->obj->list->lista('Tipo',$MATRIZ,'tpidprov',$datos,'required','','div-2-4');
	
	$this->obj->text->text('Identificacion','texto','idprov',10,15,$datos ,'required','','div-2-4') ;
	
	
	$this->obj->text->text('Razon','texto','razon',120,120,$datos ,'required','','div-2-10') ;
	
	
	
	$this->obj->list->listadb($this->ListaDB('ciudad'),$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
	
	$this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text('Telefono','texto','telefono',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text('Email','texto','correo',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text('FechaNacimiento','date','nacimiento',10,10,$datos ,'required','','div-2-4') ;
	
	  
	$datos['estado'] = 'S';
	$datos['naturaleza'] = 'NN';
	 
   
	$this->obj->text->texto_oculto("estado",$datos); 
	$this->obj->text->texto_oculto("naturaleza",$datos); 
		
	 $this->obj->text->texto_oculto("action",$datos); 
         $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
  
     
     $formulario_impresion = '../../reportes/reporte_rifa?';
     $eventop = 'javascript:url_comprobante('."'".$formulario_impresion."')";
     
    $ToolArray = array( 
        array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
        array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  ,
        array( boton => 'Impresion Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
                 );
                  
    $this->obj->boton->ToolMenuDiv($ToolArray); 
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  function ListaDB( $titulo){
  	
  	if ($titulo == 'ciudad'){
  		$resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre
			                     from par_catalogo
								where tipo = 'canton' and publica = 'S' order by nombre ");
  	}
  
  	
  	return $resultado;
  	
  }   
  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
?>

