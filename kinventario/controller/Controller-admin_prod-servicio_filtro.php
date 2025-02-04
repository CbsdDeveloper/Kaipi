<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';  
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php'; 
  
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
          
        
       
      	$MATRIZ = array(
      	    'B'    => 'Bien/Producto'
       	);
      
      	$datos = array();
      	
      	$this->obj->list->lista('Naturaleza',$MATRIZ,'tipo1',$datos,'','','div-2-4');
      
 
      	
 
      	$resultado = $this->bd->ejecutar("SELECT  0 AS codigo, ' [ 0. Todas las Categorias ]' as nombre union 
                                        SELECT  idcategoria AS codigo, categoria as nombre
                                            FROM public.view_producto
                                            where tipo_categoria <> 'S'
                                            group by  idcategoria, categoria 
                                            order by 2 "
      	         );
      
      	$this->obj->list->listadb($resultado,$tipo,'Categoria','idcategoria1',$datos,'','','div-2-4');
      
      	
      	
      	$resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and 
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
      	    );
                                                  
       
      	$this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega1',$datos,'','','div-2-4');
      
      	$MATRIZ = array(
      			'N'    => 'No',
      			'S'    => 'Si'
      	);
      	$this->obj->list->lista('Facturacion',$MATRIZ,'facturacion1',$datos,'','','div-2-4');
      	 
 
      	
      	$this->obj->text->text('Producto',"texto",'productob',50,50,$datos,'','','div-2-4') ;  
      	
      	
      	$this->obj->text->text('Codigo',"number",'codigobb',50,50,$datos,'','','div-2-4') ;  
      	
      
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  