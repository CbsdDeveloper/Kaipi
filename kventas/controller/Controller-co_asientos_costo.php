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
          
          $datos['idasientodetCosto'] = $idasientodet;
    
          $tipo = $this->bd->retorna_tipo();
          
          
          $datos = $this->consultaId($idasientodet);
          
          
          $resultado = $this->bd->ejecutar("select 0 as codigo, '-' as nombre union SELECT idcatalogo as codigo,  nombre  
                                              FROM  par_catalogo
                                              where publica = 'S' and tipo ='proyecto-costo'  order by 1");
                                                   
          
          $this->obj->list->listadb($resultado,$tipo,'Centro Costos','codigo1',$datos,'required','','div-2-10');
   
       
          $resultado = $this->bd->ejecutar("select 0 as codigo, '-' as nombre union SELECT idcatalogo as codigo,  nombre
                                              FROM  par_catalogo
                                              where publica = 'S' and tipo ='tipo-costo'  order by 1");
          
          
          $this->obj->list->listadb($resultado,$tipo,'Tipo Costo','codigo2',$datos,'required','','div-2-10');
                
    //-----------------------------------------------------------------------------------------------
    
          $resultado = $this->bd->ejecutar("select 0 as codigo, '-' as nombre union SELECT idcatalogo as codigo,  nombre
                                              FROM  par_catalogo
                                              where publica = 'S' and tipo ='categoria-costo'  order by 1");
          
          
          $this->obj->list->listadb($resultado,$tipo,'Grupo Costo','codigo3',$datos,'required','','div-2-10');
          
          
          $resultado = $this->bd->ejecutar("select 0 as codigo, '-' as nombre union SELECT idcatalogo as codigo,  nombre
                                              FROM  par_catalogo
                                              where publica = 'S' and tipo ='detalle-costo' order by 1 ");
          
          
          $this->obj->list->listadb($resultado,$tipo,'Detalle Costo','codigo4',$datos,'required','','div-2-10');
          
          
          $this->obj->text->texto_oculto("idasientodetCosto",$datos); 
          
 		 
    }
 //--------------------------
    function consultaId( $idasientodet ){
        
     
        $qquery = array(
            array( campo => 'id_asientod',   valor => $idasientodet,  filtro => 'S',   visor => 'N'),
            array( campo => 'codigo1',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codigo2',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codigo3',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codigo4',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
        
        $datos = $this->bd->JqueryArrayVisorDato('co_asientod',$qquery );
        
        return $datos;
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