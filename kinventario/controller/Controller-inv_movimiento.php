<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   // Incluimos el fichero de la clase Db
 	
    require '../../kconfig/Obj.conf.php';  // Incluimos el fichero de la clase objetos 
    
    require '../../kconfig/Set.php';       // Incluimos el fichero de la clase objetos
  
    class componente{
  
      private $obj;
      private $bd;
      private $set;
      
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
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                $this->evento_form = '../model/Model-inv_movimiento.php';        

      }
/*
Formulario de registro de datos
*/
     function Formulario( ){
         
        $datos               = array();
         
        $tipo                = $this->bd->retorna_tipo();   // retorna tipo de conexion oracle/postgres/sql

        $datos['action_iva'] =  $this->bd->_catalogo_iva(); // retorna valor iva para calculos de variables

        $datos['fecha']      =  date("Y-m-d");
         
        $MATRIZ_tipo         = array(
            'I'    => 'Ingreso'
        );

        $MATRIZ_transaccion = array(
            'compra'    => 'Compra',
            'traslado bodega'    => 'Traslado Bodega',
            'salida mercaderia'    => 'salida mercaderia',
            'devolucion'    => 'devolucion',
            'donacion'    => 'donacion' ,
            'carga inicial'    => 'Carga inicial'
        );
          
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
  		
        $this->BarraHerramientas();
        
        
                    $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                                        from view_bodega_permiso
                                                        where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                            sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)." order by 1"
                        );
                    
                    
                                $this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega',$datos,'','','div-2-4');
                                
                                $evento = 'OnChange="AsignaBodega();"';
                                $this->obj->list->listae('Referencia',$MATRIZ_tipo,'tipo',$datos,'required','',$evento,'div-2-4');
                                
                                $this->obj->text->text('Movimiento','number','id_movimiento',10,10,$datos ,'','readonly','div-2-4') ;
                                
                                $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
                            
                                $this->obj->text->text('Estado','texto','estado',10,10,$datos ,'','readonly','div-2-4') ;
                                
                                $this->obj->text->text('Aprobado','date','fechaa',10,10,$datos ,'','readonly','div-2-4') ;
                    
                
                                $this->obj->text->textautocomplete('Proveedor',"texto",'razon',40,45,$datos,'required','','div-2-4');

                                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                    
                    
                                $evento = ' onClick="BuscaTramite()" ';
                                $cadena = '<a href="#" class="btn btn-info btn-xs" '.$evento.' data-toggle="modal" data-target="#myModalTramite" role="button"> Tramite</a>';		 
                                
                                $this->obj->text->text_blue($cadena,'texto','id_tramite',10,10,$datos ,'required','','div-2-4') ;

                                   
                            $this->obj->text->text('Comprobante','texto','comprobante',10,10,$datos ,'','readonly','div-2-4') ;
                    
		 
		            $this->set->div_label(12,'<h6> Informacion Documento<h6>');
		
                            $this->obj->text->text('Factura/Documento','texto','documento',10,10,$datos ,'required','','div-2-4') ;
                        
                            $this->obj->text->text('Fecha Factura','date','fechaf',10,10,$datos ,'required','','div-2-4') ;                
                
                            $resultado = $this->bd->ejecutar_unidad();  // catalogo de unidades
                            $evento    = 'OnChange="AsignaBodega();"';
                            $this->obj->list->listadbe($resultado,$tipo,'Solicita','id_departamento',$datos,'','',$evento,'div-2-4');
                            
                            $this->obj->list->lista('Transaccion',$MATRIZ_transaccion,'transaccion',$datos,'required','','div-2-4');
                            
                            $this->obj->text->editor('Detalle','detalle',2,75,500,$datos,'required','','div-2-10') ;
  
		            $this->set->div_label(12,'<h6> Detalle de Movimientos<h6>');
		 
		                 $this->obj->text->textautocomplete('Articulo',"texto",'articulo',40,45,$datos,'','','div-2-4');
                         
                         $evento = ' onClick="InsertaProducto()" ';
                         $cboton1 = 'Agregar <a href="#" '.$evento.' ><img src="../../kimages/cnew.png"/></a>';
                        
                         $this->obj->text->text($cboton1,'texto','idproducto',10,10,$datos ,'','readonly','div-1-2') ;
                        
                         $this->obj->text->text('CodBarra','texto','idbarra',50,50,$datos ,'','','div-1-2') ;
                
                        
                        
                        $this->obj->text->texto_oculto("action",$datos); 

                    
                        $this->obj->text->texto_oculto("action_iva",$datos); 

		 
		 
		 $this->set->_formulario('-','fin'); 
      
   }
 /*
 Llama a funcion para generar el formulario
 */  
 function BarraHerramientas(){
   
     $evento = 'aprobacion()';
     
     $formulario_impresion = '../../reportes/reporteInv?tipo=50';
     $eventoi = 'url_comprobante('."'".$formulario_impresion."')";
     
     $formulario_impresion = '../view/proveedor';
     $eventop = 'modalVentana('."'".$formulario_impresion."')";
     
     $formulario_impresion = '../view/co_xpagar?transacionID=';
     $eventof = 'enlace_contabilidad('."'".$formulario_impresion."')";
     
      
     $eventoc2 = 'CopiarMovimiento()';
     
     $formulario_impresion = '../view/Productos';
     $eventopp = 'modalProducto('."'".$formulario_impresion."')";
 
     
     $eventoc = 'validaEnlace()';
     
     
     $eventoc3 ='RevertirDatos()';
     
     $ToolArray = array(
         array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
         array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
         array( boton => 'Validacion de Enlaces', evento =>$eventoc,  grafico => 'glyphicon glyphicon-warning-sign' ,  type=>"button_primary") ,
         array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
         array( boton => 'Registro de Centro Costos', evento =>$eventof,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button_success") ,
         array( boton => 'Generar Egreso de Movimiento', evento =>$eventoc2,  grafico => 'glyphicon glyphicon-list' ,  type=>"button_default") ,
         array( boton => 'Comprobante Inventarios', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
         array( boton => 'Ingreso de Producto', evento =>$eventopp,  grafico => 'glyphicon glyphicon-eye-open' ,  type=>"button_default") ,
         array( boton => 'Revertir Movimiento Transaccion', evento =>$eventoc3,  grafico => 'glyphicon glyphicon-warning-sign' ,  type=>"button_default") ,
         array( boton => 'Proveedor', evento =>$eventop,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") 
       
         
     );
 
    $this->obj->boton->ToolMenuDiv($ToolArray); 

  }  
 /*
 Llama a funcion para generar el formulario
 */  
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
 } 
 /*
 Llama a funcion para generar el formulario
 */   
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   
?>
<script type="text/javascript" src="formulario_ciu_prod_in.js"></script> 