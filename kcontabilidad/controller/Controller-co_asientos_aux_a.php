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
                 
                 $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                 
                 $this->ruc       =  $_SESSION['ruc_registro'];
                 
                 $this->sesion 	  =  trim($_SESSION['email']);
                 
                 $this->hoy 	  =  $this->bd->hoy();
      }
      
      function Formulario($id_asiento,$cuenta){
    
         
        $datos['cuenta_aux'] = $cuenta;
      	
      	
      	$this->set->div_label(12,'Beneficiario Actual');
      	
      	$resultado = $this->bd->ejecutar("select '' as codigo, '[ 0. Copiar beneficiario ]' as nombre union
                                            select idprov as codigo, razon  as nombre
                    							       from view_aux
                    							      where  id_asiento = ".$this->bd->sqlvalue_inyeccion($id_asiento, true)." 
                                                    group by idprov,razon
                                                    order by 2 ASC");
      	
      	$tipo = $this->bd->retorna_tipo();

      	$this->obj->list->listadb($resultado,$tipo,'Copiar','fcopiar',$datos,'','','div-2-10');
   
      	
         $this->obj->text->texto_oculto("cuenta_aux",$datos); 
                
  		  
       
                 
    }
  
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
 ?> 
   <!-- pantalla de gestion -->
   <div class="row">
 	 <div class="col-md-12">
 	<?php	 	 
 	
 	      $cuenta         = $_GET['codigoAux'] ;
          $id_asiento     = $_GET['id_asiento'] ;
      

 		   $gestion   = 	new componente;
   
 		   $gestion->Formulario($id_asiento,$cuenta );
  
     ?>			 						  
  	 </div>
   </div>
   