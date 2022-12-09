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
      private $anio;
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
        
                $this->anio       =  $_SESSION['anio'];
              
      }
       //-----------------------------------------------------------------------------------------------------------
      //---------------------------------------
      
     function Formulario( ){
      
 
     	$this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
    
      	
     	$datos = array();
 
                 
                $tipo = $this->bd->retorna_tipo();
                
                echo '<div class="alert alert-warning"><div class="row">';
                 
                 
                $this->obj->text->text('Fecha',"date",'fecha_pago',15,15,$datos,'required','','div-2-4');
                
                $this->obj->text->text('Nro.Comprobante',"texto",'comprobante',15,15,$datos,'','readonly','div-2-4'); 
                
               
                $resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE BANCO ]' as nombre
                                        union
                                        SELECT cuenta as codigo, detalle as nombre
          											FROM co_plan_ctas
          											where tipo_cuenta = 'B' and univel = 'S' and
                                                          anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true). " and
                                                          registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );
                
                
                
                $this->obj->list->listadb($resultado,$tipo,'Banco','idbancos',$datos,'required','','div-2-10');  
                
                
                $this->obj->text->editor('<b>Detalle</b>','detalle_pago',3,45,300,$datos,'required','','div-2-10') ;
    
 
                
                
                $MATRIZ =   $this->obj->array->catalogo_tipo_tpago();
                
                 
                $java =  "busca_cheque($('#tipo_pago').val());return false;";
                
                $evento = ' onChange="'.$java.'" ';
                
                 $this->obj->list->listae('Forma pago',$MATRIZ,'tipo_pago',$datos,'required','',$evento,'div-2-4');
                
                
                $this->obj->text->text('Nro.Documento',"texto",'cheque',15,15,$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Generado',"texto",'pago',15,15,$datos,'','readonly','div-2-4');
                
                
            
                echo '</div></div>';
                
     
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
  }  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
 ///------------------------------------------------------------------------
 ///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
   
  $gestion->Formulario( );
 
 
 ?>