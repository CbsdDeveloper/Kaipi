<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
   
      private $obj;
      private $bd;
      private $set;
      
      private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();

                $this->anio       =  $_SESSION['anio'];
                
                 $this->evento_form = '../model/Model-ren_deposito.php';        
      }
     //---------------------------------------
     function Formulario( ){
      
         
        $this->set->_formulario( $this->evento_form,'inicio' ); 
   
     
        $datos      = array();

        $datos['fecha'] = date('Y-m-d');

        $datos['action'] = 'caja';


        
  
        $tipo = $this->bd->retorna_tipo();


        $this->BarraHerramientas();

      

              
                $resultado = $this->bd->ejecutar("SELECT '-' as codigo, ' -- 0. SELECCIONE BANCO--  ' as nombre
                union
                SELECT cuenta as codigo, detalle as nombre
                              FROM co_plan_ctas
                              where tipo_cuenta = 'B' and univel = 'S' and estado = 'S' and 
                                  anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true). " and 
                                  registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );



                $this->obj->list->listadb($resultado,$tipo,'Depositar en ','idbancos',$datos,'required','','div-2-10');  
  
                
                $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;


                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');

                $this->obj->text->text('Nro.Documento',"texto",'documento',15,15,$datos,'required','','div-2-4'); 

 
          
                
              
       
 		    $this->obj->text->texto_oculto("action",$datos); 
		  
          
		  $this->set->_formulario('-','fin'); 
          
        
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   

    	$eventop              = 'impresion_caja()';
   	 
      $eventoa = 'BusquedaGrillaCaja(oTableArticulo)';
   	 
    $ToolArray = array( 
              array( boton => 'GENERAR INFORMACION DE CAJA RECAUDADORA ABIERTA - PROCESO DE CIERRE', evento =>$eventoa,  grafico => 'glyphicon glyphicon-search' ,  type=>"button_info") ,
              array( boton => 'Generar CIERRE DE CAJA RECAUDADORA - BANCOS ', evento =>'', grafico => 'glyphicon glyphicon-ok' ,  type=>"submit") ,
       	     array( boton => 'Imprimir Diario Contable', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") 
                  );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 

   }   
 }   
 //------------------------------------------------------------------------
 // Llama de la clase para creacion de formulario de busqueda
 //------------------------------------------------------------------------
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   

?>