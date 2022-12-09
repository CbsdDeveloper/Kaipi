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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
          
       $datos = array();
          
       $evento = '';
       
      	$datos['ffecha1'] =  date('Y-m-d', strtotime("-30 days"));
      	$datos['ffecha2'] =  date("Y-m-d");
      	
      	$tipo = $this->bd->retorna_tipo();
     
      	
      	
      	$resultado = $this->bd->ejecutar("select 0 as codigo, '[ 0. Seleccione ubicacion ]' as nombre  union
                                         select idsede as codigo, nombre
                                            from activo.view_sede_user
                                            where  sesion=". $this->bd->sqlvalue_inyeccion( $this->sesion,true).' order by 2'
      	    );
      	
       	
      	$evento = ' OnChange="BuscaPrograma(this.value)" ';
      	$this->obj->list->listadbe($resultado,$tipo,'','vidsede',$datos,'','',$evento,'div-0-3');
      	
      	
      	$MATRIZ = array(
      	    'BLD'    => 'Bienes de larga duracion',
      	    'BCA'    => 'Bienes de control administrativo'
      	);
      	$evento = '';
      	$this->obj->list->listae('',$MATRIZ,'vtipo_bien',$datos,'','',$evento,'div-0-3');
      	
      	
      	$resultado = $this->bd->ejecutar("select '-' as codigo, '[ 0. Seleccione Grupo ]' as nombre " );
      	$this->obj->list->listadbe($resultado,$tipo,'','vcuenta',$datos,'','',$evento,'div-0-3');
 
      	
      	$MATRIZ = array(
      	    '-' => '[Estado de los Bienes]',
      	    'Libre'    => 'Libre',
      	    'Asignado'    => 'Asignado',
      	    'Baja'    => 'Baja',
      	);
      	$this->obj->list->lista('',$MATRIZ,'vuso',$datos,'','','div-0-3');
      	
     
      	
      	$resultado = $this->bd->ejecutar("select 0 as codigo, '[ 0. Seleccione la unidad ]' as nombre " );
      	$this->obj->list->listadb($resultado,$tipo,'Unidad','Vid_departamento',$datos,'','','div-0-3');
      	
      	
      	$MATRIZ = array(
      	    '-'    => '[ 0. Acta Generadas ? ]',
      	    'N'    => 'NO',
      	    'S'    => 'SI'
      	);
      	$this->obj->list->lista('',$MATRIZ,'vtiene_acta',$datos,'','','div-0-3');
      	
      	$this->obj->text->text_yellow_filtro('',"texto",'vactivo',35,35,$datos,'','','div-0-3','BUSCAR DETALLE DEL BIEN');
      	
      	
      	$this->obj->text->text_yellow_filtro('',"texto",'vcodigo',35,35,$datos,'','','div-0-3','BUSCAR CODIGO DEL BIEN');
      
      }
      //----------------------------------------------
      function sql($titulo){
          
          
    
          if  ($titulo == 1){
              
              $sqlb = "Select '-' as codigo, '[Seleccione cuenta contable]' as nombre
                    union
                    SELECT  cuenta as codigo, (cuenta || '.'||  detalle) as nombre
                    FROM co_plan_ctas
                    where tipo_cuenta = 'A' and
                          univel = 'S'  order by 1";
              
          }
          
             
              
          if  ($titulo == 2){

              $sqlb = "SELECT id_modelo  as codigo ,  nombre
		          FROM  inv.ac_modelo
                 where id_modelo = 0";
               
              
          }
          
          $resultado = $this->bd->ejecutar($sqlb);
          
          
          return  $resultado;
          
      }
      
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  