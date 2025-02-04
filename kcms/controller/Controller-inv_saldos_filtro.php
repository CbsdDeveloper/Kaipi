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
 
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase   bnaturaleza,bidciudad
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
       $tipo = $this->bd->retorna_tipo();
          
       $datos = array();
 
       $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)." order by 1"
           );
       
       
       $this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega1',$datos,'','','div-2-4');
       
       
      
      	$MATRIZ = array(
      	    '-'  => 'No Aplica',
      	    'S'    => 'Si',
      	    'N'    => 'No'
      	);
       	
      	
      	$this->obj->list->lista('Facturacion?',$MATRIZ,'facturacion',$datos,'required','','div-2-4');
      	
        	
       	
      	$resultado =$this->bd->ejecutar("SELECT idcategoria as codigo, nombre
            			                     from view_res_inv_CATE
                                            WHERE  tipo_categoria <> 'S' and 
                                                   registro =  ". $this->bd->sqlvalue_inyeccion($this->ruc,true)."
                                            GROUP BY idcategoria, nombre 
                                            ORDER BY 2 asc ");
      	
      	$this->obj->list->listadb($resultado,$tipo,'Categoria','idcategoria',$datos,'required','','div-2-4');
      	
      	$MATRIZ = array(
      	    '-'  => 'No Aplica',
      	    '(saldo = 0 )'         => 'Articulos sin Saldo',
      	    '(saldo < minimo )'    => 'Articulos con Stock Minimo '
        	);
      	
         	
      	$this->obj->list->lista('Minimo Stock',$MATRIZ,'nivel',$datos,'required','','div-2-4');
 
      	$this->obj->text->text('Producto','texto','nombre_producto',100,100,$datos ,'','','div-2-4') ;
      	
      	
      	$this->obj->text->text('Codigo','number','codigog',100,100,$datos ,'','','div-2-4') ;
      	
      	$datos['tipo'] =  'B';
       	
      	
      	
      	$this->obj->text->texto_oculto("tipo",$datos); 
 
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  