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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
      function Formulario( $idprov ){
      
 
               $datos = $this->consultaId( $idprov );
                
                $evento = '';
          
                $this->obj->text->texte('Identificacion',"texto",'idprov',20,15,$datos,'required','readonly',$evento,'div-2-10') ; 
  
                $tipo = $this->bd->retorna_tipo();
                
                $this->obj->text->text('Razon Social',"texto",'razon',100,100,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('Direccion',"texto",'direccion',80,80,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text('Email',"email",'correo',40,45,$datos,'required','','div-2-4') ;
 
                
                    
                $this->set->div_label(12,'Informacion Financiera (Pagos)');
                
                
                
                $resultado = $this->bd->ejecutar("SELECT idcatalogo as codigo, nombre FROM par_catalogo where tipo = 'bancos' ");
                
                
                $this->obj->list->listadb($resultado,$tipo,'Entidad Bancaria','id_banco',$datos,'required','','div-2-4');
                
                
                $MATRIZ =  $this->obj->array->nom_tipo_banco();
                
                $this->obj->list->lista('Tipo Cuenta',$MATRIZ,'tipo_cta',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Nro.Cuenta',"texto",'cta_banco',30,30,$datos,'required','','div-2-4');
                
                
 
 
 
  
      
   }
 
  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
///------------------------------------------------------------------------
  function consultaId( $id ){
      
 
      
      $qquery = array(
      array( campo => 'idprov',   valor =>$id,  filtro => 'S',   visor => 'S'),
      array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
       array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'id_banco',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'tipo_cta',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'cta_banco',   valor => '-',  filtro => 'N',   visor => 'S')
      );
      
    $datos =  $this->bd->JqueryArrayVisor('par_ciu',$qquery );
      
    return $datos;
 
  }
}


$gestion   = 	new componente;

$idprov    = $_GET['idprov'] ;


$gestion->Formulario( $idprov );

?>