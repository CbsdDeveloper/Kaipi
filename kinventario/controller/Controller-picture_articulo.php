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
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $tipourl, $url,$id ){
      
      
          $ACarpeta = $this->bd->query_array('wk_config',
              'carpetasub',
              'tipo='.$this->bd->sqlvalue_inyeccion($tipourl,true)
              ); 
      	
      	 
          $folder = trim($ACarpeta['carpetasub']);
      	 
          $archivo = $folder.$url;
          
          if (empty($url)){
              $archivo = 'no.png' ;
          }
      	 
          $VisorArticulo = '<center><img src='.$archivo.'  width="120" height="150" /> </center>';
          
          $tipo = $this->bd->retorna_tipo();
          
          echo $VisorArticulo;
          
          $datos  = $this->bd->query_array('web_producto',
              'producto, referencia,    cuenta_inv,   costo,  saldo,   lifo, cuenta_gas,  partida , promedio, fifo',
              'idproducto='.$this->bd->sqlvalue_inyeccion($id,true)
              ); 
      
          echo '<h5>'.$datos['producto'].'<br>' .'Costo '.$datos['costo'].'<br>' .'Saldo '.$datos['saldo'].'<br>' .'</h5>';
          
          
          $datos['cuenta_inventario'] =   trim($datos['cuenta_inv']) ;
          $datos['idproductop'] = $id;
          
          
          
          $this->set->div_label(12,'INFORMACION ENLACE FINANCIERO');
          
          $union = "Select '-' as codigo, ' [ No aplica ] ' as nombre union" ;
          
          $resultado = $this->bd->ejecutar($union." select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								from co_plan_ctas
                                                    where univel = 'S' and
                                                          registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                          tipo_cuenta in ('V') ORDER BY 1");
          
          $this->obj->list->listadb($resultado,$tipo,'Cuenta de Inventarios','cuenta_inventario',$datos,'','','div-3-9');
          
          
          $resultado = $this->bd->ejecutar($union." select  trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
                    								         from co_plan_ctas
                                                             where univel = 'S' and   
                                                                   registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                                   tipo_cuenta in ('V') ORDER BY 1" );
          
          $this->obj->list->listadb($resultado,$tipo,'Cuenta Costo','cuenta_gas',$datos,'','','div-3-9');
          
          
         
          
          $this->obj->text->texto_oculto("idproductop",$datos); 
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   if (isset($_GET['id']))	{
       
       
       $tipourl        = $_GET['tipourl'];
       $url            = $_GET['url'];
       
       $id            = $_GET['id'];
       
       $gestion->FiltroFormulario( $tipourl, $url,$id);
       
   }
 

 ?>


 
  