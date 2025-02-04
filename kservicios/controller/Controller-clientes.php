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
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =  $this->bd->hoy();
				
                $this->formulario = 'Model-clientes.php'; 
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
       
        $x = $this->bd->query_array('view_registro',   // TABLA
            '*',                        // CAMPOS
            'ruc_registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true) // CONDICION
            );
        
        $datos['idciudad']  = $x['idciudad'];
        $datos['direccion'] = $x['direccion'];
        $datos['telefono']  = $x['telefono'];
        $datos['correo']    = $x['correo'];
        
        $datos['nacimiento'] = date('Y-m-d');
        
       
         

        $MATRIZ =  $this->obj->array->catalogo_tipoCiu();
	
	$this->obj->list->lista('Tipo',$MATRIZ,'tpidprov',$datos,'required','','div-2-4');
	
	$this->obj->text->text('Identificacion','texto','idprov',10,15,$datos ,'required','','div-2-4') ;
	
	
	$this->obj->text->text('Razon','texto','razon',120,120,$datos ,'required','','div-2-10') ;
	
	
	
	$this->obj->list->listadb($this->ListaDB('ciudad'),$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
	
	$this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text_blue('Telefono','texto','telefono',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text_blue('Email','texto','correo',120,120,$datos ,'required','','div-2-4') ;
	
	$this->obj->text->text('FechaNacimiento','date','nacimiento',10,10,$datos ,'required','','div-2-4') ;
	
	
	$this->obj->text->text('CIU',"number" ,'id_par_ciu' ,80,80, $datos ,'required','readonly','div-2-4') ;
	  
	$datos['estado'] = 'S';
	$datos['naturaleza'] = 'NN';
	 
	
   
 	
	$this->obj->text->texto_oculto("estado",$datos); 
	$this->obj->text->texto_oculto("naturaleza",$datos); 
		
	 $this->obj->text->texto_oculto("action",$datos); 
         $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
   //array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
     
     
    $ToolArray = array( 
              
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
    $this->obj->boton->ToolMenuDivCrm($ToolArray); 
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

