
 <script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery(' #fo21').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
 				    jQuery('#VisorTarea').html(data);
            
			}
        })        
        return false;
    }); 
 })
</script>	
 <script src="../../keditor/ckeditor/ckeditor.js"></script>
 <script>
		CKEDITOR.replace( 'editor1', {
			height: 250,
			width: '100%',
		} );
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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
   
      
///------------------------------------------------------------------------
  //----------------------------------------------
  function principal($idproceso,$idtarea){
      
      echo ' <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Responsables</a></li>
     <li><a data-toggle="pill" href="#menu0">Requisitos</a></li>
    <li><a data-toggle="pill" href="#menu1">Documentos</a></li>
  </ul>
									      
  <div class="tab-content">
        <div id="home" class="tab-pane fade in active"> ';
      $this->departamento_responsable( $idproceso,$idtarea);
         
      echo '</div>
    
    <div id="menu0" class="tab-pane fade">';
      $this->requisitos_proceso($idproceso,$idtarea);
      echo '</div>
 
      <div id="menu1" class="tab-pane fade">';
      $this->documento_proceso($idproceso,$idtarea);
    
      echo '</div>
      </div>';
   }  
   //----------------------------------------------
   function departamento_responsable( $idproceso,$idtarea){
       
       $this->set->div_label(12,'<h5> Asignar unidad operativa<h5>');
       
       $tipo 		= $this->bd->retorna_tipo();
       
       $sql = 'SELECT  
                    unidad  ,
                    ambito_proceso ,
                     perfil  
      FROM flow.view_unidadProcesotarea
      where idproceso = '. $this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '. $this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       
       ///--- desplaza la informacion de la gestion
       $resultado  =  $this->bd->ejecutar($sql);
       
       $cabecera =  "Unidad,Ambito,Perfil";
       
       $evento   =  " ";
       $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
       
   } 
///------------------------------------------------------------------------
   //----------------------------------------------
   function documento_proceso($idproceso,$idtarea ){
       
       $this->set->div_label(12,'<h5> Emision de documentos<h5>');
       
       $tipo 		= $this->bd->retorna_tipo();
         
       $sql = 'SELECT  
                    documento  ,
                    perfil_documento ,
                    tipo ,
                    estado  
      FROM flow.view_unidadProcesodocu
      where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       
       
       ///--- desplaza la informacion de la gestion
       $resultado  = $this->bd->ejecutar($sql);
       
       $cabecera =  "Documento,Perfil,Tipo,Estado";
       
       $evento   = "";
      
       $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
  
   } 
   //----------------------------------------------
   function requisitos_proceso($idproceso,$idtarea ){
       
       $this->set->div_label(12,'<h5> Requisitos <h5>');
       
       $tipo 		= $this->bd->retorna_tipo();
         
       $sql = 'SELECT   
                    requisito  ,
                    requisito_perfil ,
                    tipo ,
                    obligatorio  
      FROM flow.view_unidadprocesorequi
      where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       
       
       ///--- desplaza la informacion de la gestion
       $resultado  = $this->bd->ejecutar($sql);
       
       $cabecera =  " Requisito,Perfil,Tipo,Obligatorio";
       
       $evento = '';
       
       $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
       
   } 
   //----------------------------------------------
   //-------------------------- 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
 
  
  if (isset($_GET['id']))	{
  	
  	
  	$id               = $_GET['id'];
  	
  	$idproceso  = $_GET['idproceso'];
  	
  	$gestion->principal( $idproceso,$id);
  	
  }
  

  
 ?>
 
  