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
        
        $datos = array();
        
         	
        
        
        $MATRIZ = array(
            '2021'    => '2021',
            '2020'    => '2020',
            '2022'    => '2022',
            '2023'    => '2023'
        );
        $this->obj->list->lista('Periodo',$MATRIZ,'periodo1',$datos,'','','div-2-4');
       	
        
        $datos['fecha1'] = date('Y-m-d'); 
      
        $this->obj->text->text('Fecha','date','fecha1',10,15,$datos ,'required','','div-2-4') ;
        
        $MATRIZ = array(
            'agua'    => 'Agua Potable',
            'arriendo'    => 'Arriendos',
            'registros'    => 'Registro'
        );
        $this->obj->list->lista('Modulo',$MATRIZ,'novedad1',$datos,'','','div-2-4');
        
      
      	
      	$MATRIZ = array(
       	    'aprobado'    => 'Aprobado',
      	    'anulado'    => 'Anulado',
      	    'notacredito'    => 'Nota Credito'
      	);
       	$this->obj->list->lista('Estado',$MATRIZ,'estado1',$datos,'','','div-2-4');
      
       	
     //  	$this->obj->list->listadb($this->ListaDB('cajero'),$tipo,'Cajero','cajero',$datos,'required','','div-2-4');
       	
       	
       	$this->obj->text->texto_oculto("cajero",$datos); 
       	
       	
       	$this->obj->text->text('Cliente ',"texto",'razon1',90,95,$datos,'required','','div-2-4') ;
 
      
       	$this->obj->text->text('Identificacion',"texto",'idprov1',90,95,$datos,'required','','div-2-4') ;
      
      }
      //---------------------------------------------
      function ListaDB( $titulo){
          
          $ACaja = $this->bd->query_array('par_usuario',
              'caja, supervisor, url,completo,tipourl',
              'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
              );
          
 
          
          if ($ACaja['supervisor'] == 'S'){
              $resultado = $this->bd->ejecutar("select email as codigo, completo as nombre
			                     from par_usuario
								where caja = 'S'  and estado = 'S' ");
          }else{
              $resultado = $this->bd->ejecutar("select email as codigo, completo as nombre
			                     from par_usuario
								where estado = 'S' and email = " .$this->bd->sqlvalue_inyeccion($this->sesion,true));
          }
          
           
          
          return $resultado;
          
      }  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  