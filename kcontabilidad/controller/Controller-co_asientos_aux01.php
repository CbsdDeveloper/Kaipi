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
                 $this->bd	   =	     	new Db ;
                 $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                 $this->ruc       =  $_SESSION['ruc_registro'];
                 $this->sesion 	 =  trim($_SESSION['email']);
                 $this->hoy 	     =  $this->bd->hoy();
      }
      
      function Formulario($idasientodet){
    
       $tipo =  $this->bd->retorna_tipo();
          
 
        $datos['codigodet'] =  $idasientodet;
        
      	$proveedor_aux = $this->bd->query_array( 'view_aux',
      											 'idprov,debe,haber,razon,id_asiento',
      											  'id_asientod ='.$this->bd->sqlvalue_inyeccion($idasientodet,true)
      											);
       	
      	$idprovAux  = $proveedor_aux["idprov"];
       	$id_asiento = $proveedor_aux["id_asiento"];
       	
       	$longitud = strlen(trim($idprovAux));
 
   
 
        if ($longitud  < 9) {
      		
      		$datos = $this->bd->query_array('co_asientod',
      										'debe,haber,id_asiento',
      										'id_asientod ='.$this->bd->sqlvalue_inyeccion($idasientodet,true)
      				);
      		
      		$datos['monto']     = $datos['debe'] +  $datos['haber'];
      		$id_asiento         = $datos["id_asiento"];
      		$datos['codigodet'] = $idasientodet;
      		
      	}else{
      	        	$valida = 0;
      	        	$datos['codigodet']   = $idasientodet;
      	        	$datos['beneficiario'] =$proveedor_aux['razon'];
      	        	$datos['idprov01'] = $idprovAux;
      	        	$datos['monto'] = $proveedor_aux['debe'] + $proveedor_aux['haber'];
      	}
      	
 
		  
       	$this->obj->text->text('Referencia',"number",'codigodet',0,10,$datos,'required','readonly','div-2-10') ;
       	
       	
      	$resultado =  $this->bd->ejecutar("select '' as codigo, 'Seleccione beneficiario' as nombre union
                                            SELECT idprov as codigo,beneficiario as nombre
                                            FROM view_cxp
                                            where id_asiento = ". $this->bd->sqlvalue_inyeccion($id_asiento ,true)."
                                            UNION
                                            SELECT idprov as codigo, razon   as nombre  
                                            FROM par_ciu 
                                            WHERE modulo = 'P'  and naturaleza = 'PP' ");
      	
      	
   
      	
      	       $this->obj->list->listadb($resultado,$tipo,'Beneficiario','idprov01',$datos,'required','','div-2-10');	 
      	
      	 
                $this->obj->text->text('Monto',"number",'monto',0,10,$datos,'required','readonly','div-2-10') ;
                
                $this->obj->text->texto_oculto("",$datos); 
                
              
                
 		 
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
    
  