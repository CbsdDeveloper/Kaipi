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
        
      	$tipo = $this->bd->retorna_tipo();

        $MATRIZ = array(
    	    'N'    => 'Acta NO Generadas',
      	    'S'    => 'Actas Generadas'
      	);

        $MATRIZ1  = $this->obj->array->catalogo_anio();
        
        $MATRIZ2 =  $this->obj->array->catalogo_mes();

        $datos['cmes'] = date('m');
      
 
      	$resultado = $this->bd->ejecutar("select 0 as codigo, ' [ 0. Seleccione ubicacion ] ' as nombre union
                                            select idsede as codigo, nombre
                                            from activo.view_sede_user
                                            where  sesion=". $this->bd->sqlvalue_inyeccion( $this->sesion,true).' order by 2'
      	    );
      	
      	
      	
        $evento = ' OnChange="BuscaPrograma(this.value)" ';
      	$this->obj->list->listadbe($resultado,$tipo,'','vidsede',$datos,'','',$evento,'div-0-4');
      	
     
      	
      	$resultado = $this->bd->ejecutar("select 0 as codigo, ' [ 0. Seleccione la unidad  ] ' as nombre " );
      	$this->obj->list->listadb($resultado,$tipo,'Unidad','Vid_departamento',$datos,'','','div-0-4');
      	
      	

      	$this->obj->list->lista('',$MATRIZ,'vtiene_acta',$datos,'','','div-0-3');


        $this->obj->text->text_yellow_filtro('',"texto",'vrazon',35,35,$datos,'','','div-0-4','BUSCAR NOMBRE CUSTODIO/FUNCIONARIO');
 

        $this->obj->list->lista('',$MATRIZ1,'canio',$datos,'required','','div-0-2');
        
        
        $this->obj->list->lista('',$MATRIZ2,'cmes',$datos,'required','','div-0-2');

       
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


 
  