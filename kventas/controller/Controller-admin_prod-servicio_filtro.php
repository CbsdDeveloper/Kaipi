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
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $tipo = $this->bd->retorna_tipo();
          
       $anio = date("Y"); 
       
       
      	$MATRIZ = array(
      	    'B'    => 'Bien/Producto'
       	);
      
 
       $datos = array();
      	
      	$this->obj->list->lista('Naturaleza',$MATRIZ,'tipo1',$datos,'','','div-2-4');
      
      
      	$resultado =$this->bd->ejecutar("select '0' as codigo,'[Toda Categoria]' as nombre union select idcategoria as codigo, nombre
            			                     from view_res_inv_CATE
                                            WHERE   ANIO = ".$anio."  GROUP BY idcategoria, NOMBRE 
                                            order by nombre ");
      	

      
      	$this->obj->list->listadb($resultado,$tipo,'Categoria','idcategoria1',$datos,'','','div-2-4');
      
      	
      	
      	$resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and 
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
      	    );
                                                  
       
      	$this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega1',$datos,'','','div-2-4');
      
      	$MATRIZ = array(
      			'S'    => 'Si',
      			'N'    => 'No'
      	);
      	$this->obj->list->lista('Facturacion',$MATRIZ,'facturacion1',$datos,'','','div-2-4');
      	 
 
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  