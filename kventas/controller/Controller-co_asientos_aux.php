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
                 $this->obj     = 	   new objects;
                 $this->set     = 		    new ItemsController;
                 $this->bd	   =	     	new Db ;
                 $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                 $this->ruc       =  $_SESSION['ruc_registro'];
                 $this->sesion 	 =  $_SESSION['email'];
                 $this->hoy 	     =  $this->bd->hoy();
      }
      
      function Formulario($idasientodet){
    
		  	
      	$proveedor_aux = $this->bd->query_array('view_aux',
      																		'idprov,debe,haber,razon',
      																		'id_asientod ='.$this->bd->sqlvalue_inyeccion($idasientodet,true)
      																	 );
       	
      	$idprovAux= $proveedor_aux["idprov"];
 
      	if ( empty($idprovAux) ){
      		
      		$datos = $this->bd->query_array('co_asientod',
      																	'debe,haber',
      																   'id_asientod ='.$this->bd->sqlvalue_inyeccion($idasientodet,true)
      				);
      		$datos['monto'] = $datos['debe'] +  $datos['haber'];
      		
      		$datos['codigodet'] = $idasientodet;
      		
      	}else{
      	        	$valida = 0;
      	        	$datos['codigodet']   = $idasientodet;
      	        	$datos['beneficiario'] =$proveedor_aux['razon'];
      	        	$datos['idprov'] = $idprovAux;
      	        	$datos['monto'] = $proveedor_aux['debe'] + $proveedor_aux['haber'];
      	}
      	
      	
      	
		 		 $this->obj->text->textautocomplete('Beneficiario',"texto",'beneficiario',15,15,$datos,'required','','div-2-10');
		 
                $this->obj->text->text('Identificacion',"texto",'idprov',15,15,$datos,'required','readonly','div-2-10');
		 
                $this->obj->text->text('Monto',"number",'monto',0,10,$datos,'required','readonly','div-2-10') ;
                
                $this->obj->text->texto_oculto("codigodet",$datos); 
                
 		 
    }
  
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
 ?> 
   <!-- pantalla de gestion -->
   <div class="row">
 	 <div class="col-md-12">
 	<?php	 	 
 	
 	      $idasientodet     = $_GET['codigoAux'] ;
 	
 		   $gestion   = 	new componente;
   
 		   $gestion->Formulario($idasientodet);
  
     ?>			 						  
  	 </div>
   </div>
   <script type="text/javascript">

   jQuery.noConflict(); 
   
   jQuery('#beneficiario').typeahead({
	    source:  function (query, process) {
        return $.get('../model/ajax_BusquedaCiu.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 $("#beneficiario").focusout(function(){
	 var itemVariable = $("#beneficiario").val();  
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/ajax_Beneficiario.php',
											type:  'GET' ,
											beforeSend: function () {
													$("#idprov").val('...');
											},
											success:  function (response) {
													 $("#idprov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
	   
	       
</script>
 
  