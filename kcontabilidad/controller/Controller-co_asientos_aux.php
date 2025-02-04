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
                 $this->obj     = 	   new objects;
                 $this->set     = 		    new ItemsController;
                 $this->bd	    =	     	new Db ;
                 
                 $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                 
                 $this->ruc       =  $_SESSION['ruc_registro'];
                 
                 $this->sesion 	  =  trim($_SESSION['email']);
                 
                 $this->hoy 	  =  $this->bd->hoy();
      }
      
      function Formulario($idasientodet){
    
         
        $datos = $this->bd->query_array('co_asientod',
              'debe,haber,id_asiento',
              'id_asientod ='.$this->bd->sqlvalue_inyeccion($idasientodet,true)
              );
		 
        $id_asiento = $datos["id_asiento"];
        
      	$proveedor_aux = $this->bd->query_array('view_aux',
      			'idprov,debe,haber,razon,id_asiento',
      			'id_asientod ='.$this->bd->sqlvalue_inyeccion($idasientodet,true)
      																	 );
      	$idprovAux  = $proveedor_aux["idprov"];
      
 
      	if ( empty($idprovAux) ){
       		
      		$datos['monto'] = $datos['debe'] +  $datos['haber'];
      		
      		$datos['codigodet'] = $idasientodet;
      		
      	}else{
      	        	 
      	        	$datos['codigodet']   = $idasientodet;
      	        	$datos['beneficiario'] =$proveedor_aux['razon'];
      	        	$datos['idprov'] = $idprovAux;
      	        	$datos['monto'] = $proveedor_aux['debe'] + $proveedor_aux['haber'];
      	        	$datos['fcopiar'] = $idprovAux;
      	}
      	
      	
      	$this->set->div_label(12,'Beneficiario Actual');
      	
      	$resultado = $this->bd->ejecutar("select '' as codigo, '[ 0. Copiar beneficiario ]' as nombre union
                                            select idprov as codigo, razon  as nombre
                    							       from view_aux
                    							      where  id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)." 
                                                    group by idprov,razon
                                                    order by 2 ASC");
      	
      	$tipo = $this->bd->retorna_tipo();
      	$this->obj->list->listadb($resultado,$tipo,'Copiar','fcopiar',$datos,'','','div-2-10');
   
      	
      	
      	$this->set->div_label(12,'Seleccione Beneficiario');
      	
		 		$this->obj->text->textautocomplete('Beneficiario',"texto",'beneficiario',150,150,$datos,'required','','div-2-10');
		 
                $this->obj->text->text('Identificacion',"texto",'idprov',15,15,$datos,'required','readonly','div-2-4');
		 
                $this->obj->text->text('Monto',"number",'monto',0,10,$datos,'required','readonly','div-2-4') ;
                
                $this->obj->text->texto_oculto("codigodet",$datos); 
                
  		 
                
                $acciones = "editar";
                $funcion  = "cambio";
                
                
                $x= $this->bd->query_array('view_aux','count(*) as nn, sum(monto) as monto', 
                                          'id_asientod='.$this->bd->sqlvalue_inyeccion($idasientodet,true). ' and 
                                           id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true)
                    );
                
                
                if ( $x['nn'] > 1  ) {
                 
                        $this->set->div_labelmin(12,'Detalle Auxiliares');
                        
                        
                        
                        $qcabecera = array(
                            array(etiqueta => 'id_asientod',campo => 'id_asientod',ancho => '0%', filtro => 'S', valor => $idasientodet, indice => 'N', visor => 'N'),
                            array(etiqueta => 'id_asiento',campo => 'id_asiento',ancho => '0%', filtro => 'S', valor => $id_asiento, indice => 'N', visor => 'N'),
                            array(etiqueta => 'cuenta',campo => 'cuenta',ancho => '0%', filtro => 'N', valor => '-', indice => 'N', visor => 'N'),
                            array(etiqueta => 'Referencia',campo => 'id_asiento_aux',ancho => '10%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
                            array(etiqueta => 'Identificacion',campo => 'idprov',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
                            array(etiqueta => 'Nombre',campo => 'razon',ancho => '70%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
                            array(etiqueta => 'Monto',campo => 'monto',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S') 
                        );
                        
                        $this->bd->JqueryArrayTable('view_aux',$qcabecera,$acciones,$funcion,'tabla_aux' );
                
                        echo ' <div class="col-md-12" align="right">Monto  <b>'. $x['monto'].'</b> </div>';
                     
                       
                }
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
 
  