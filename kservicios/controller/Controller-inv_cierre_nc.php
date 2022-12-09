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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
				$this->formulario = 'Model-inv_cierre.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $titulo = '';
        
        $datos = array();
        
        $this->set->body_tab($titulo,'inicio');
 	     
        
        $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
        $this->set->div_panel('<b> DATOS DE FACTURA </b>');
        
        
        $this->obj->text->text('Transaccion','number','id_movimiento1',10,10,$datos ,'','readonly','div-2-10') ;
        $this->obj->text->text('<b>NRO.FACTURA</b>','texto','comprobante1',10,10,$datos ,'','readonly','div-2-4') ;
        $this->obj->text->text('Fecha','date','fecha_factura',10,10,$datos ,'required','','div-1-5') ;
        
        $this->set->div_panel('fin');	
        
        $evento ='';
          
        $this->set->div_panel9('<b> DATOS DE NOTA DE CREDITO </b>');
        
        
        $this->obj->text->texte('<b>NOTA DE CREDITO</b>',"texto",'secuencial1',9,9,$datos,'','readonly',$evento,'div-3-9');
        
        $this->obj->text->text('Establecimiento','texto','estab1',3,3, $datos ,'required','','div-3-3') ;
        
        $this->obj->text->text('Emision','texto','ptoemi1',3,3, $datos ,'required','','div-3-3') ;
        
      
        $this->obj->text->text('Fecha','date','fechaemisiondocsustento',10,10,$datos ,'required','','div-3-3') ;
        
        $this->obj->text->text('Tipo Comprobante','texto','coddocmodificado',3,3, $datos ,'required','','div-3-3') ;
        
        $this->obj->text->text('Comprobante','texto','numdocmodificado',30,30, $datos ,'required','','div-3-9') ;
        
        
        $this->obj->text->text('Autorizacion','texto','cab_autorizacion',30,30, $datos ,'','readonly','div-3-9') ;
        
        
        $this->obj->text->texto_oculto("id_diario",$datos); 
        
        $this->obj->text->texto_oculto("idcliente",$datos);
        
        
        $this->set->div_panel9('fin');
        
       
 
          $this->set->evento_formulario('-','fin'); 
          
        
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
 
             
             $evento = 'javascript:genera_nota_credito()';
            
             $eventop = 'javascript:goToURLNotaCreditoRide()';
            
             $eventocierre = 'javascript:goToURLNotaCredito()';
             
             $eventoc = 'javascript:goToURLElectronicoEnvio()';
             
             
             $titulo = '<b><span style="font-size: 12px">[ Generar Nota de Credito]</span></b> ';
             
             $ToolArray = array(
                  array( boton => 'Generar Secuencia Nota de Credito',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_warning"),
                 array( boton => 'Generar Documento electronico', evento =>$eventocierre,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success") ,
                 array( boton => 'Emitir Comprobante electronico', evento =>$eventop,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button_default"),
                 array( boton => 'Email Comprobante electronico', evento =>$eventoc,  grafico => 'glyphicon glyphicon-envelope' ,  type=>"button_default"),
             );
             
             $this->obj->boton->ToolMenuDivTitulo($ToolArray,$titulo); 
     
     
 
   
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
     
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
 
  