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
                
                $this->hoy 	     =  date('Y-m-d');
                
			   $this->formulario = 'Model-inv_cierre.php'; 

                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $titulo = '';
        
        $datos = array();
        
        $this->set->body_tab($titulo,'inicio');
        
        
        $datos['fecha_factura']           =   $this->hoy ;
        $datos['fechaemisiondocsustento'] =   $this->hoy ;
 	     
        
        
        $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
        $this->set->div_panel9('<b> DATOS DE FACTURA </b>');
        
        
        $this->obj->text->text('Transaccion','number','id_movimiento1',10,10,$datos ,'','readonly','div-2-10') ;
        $this->obj->text->text('<b>NRO.FACTURA</b>','texto','comprobante1',10,10,$datos ,'','','div-2-4') ;
        $this->obj->text->text('Fecha','date','fecha_factura',10,10,$datos ,'required','','div-1-5') ;
        
        
        echo ' <div class="col-md-12" style="padding:5px"> 
                    <div class="alert alert-success">
                         <div class="row" align="center">

                                 <button type="button" onclick="busca_factura()" class="btn btn-success">Buscar factura</button>&nbsp;&nbsp;
                                  <strong> ADVERTENCIA!</strong> Digite el  NRO.FACTURA para generar la nota de credito!
 
                         </div>
                        <div align="center" id="ViewFactura"> </div>
                    </div>
                </div>';
                    
        $this->set->div_panel9('fin');	
        
         
          
        $this->set->div_panel9('<b> DATOS DE NOTA DE CREDITO </b>');
        
        
        $this->obj->text->text_yellow('<b>NOTA DE CREDITO</b>',"texto",'secuencial1',9,9,$datos,'','readonly','div-3-9');
        
        $this->obj->text->text('Establecimiento','texto','estab1',3,3, $datos ,'required','','div-3-3') ;
        
        $this->obj->text->text('Emision','texto','ptoemi1',3,3, $datos ,'required','','div-3-3') ;
        
      
        $this->obj->text->text_blue('<b>Fecha(*)</b>','date','fechaemisiondocsustento',10,10,$datos ,'required','','div-3-3') ;
        
        $this->obj->text->text('Tipo Comprobante','texto','coddocmodificado',3,3, $datos ,'required','','div-3-3') ;
        
        $this->obj->text->text_yellow('Comprobante','texto','numdocmodificado',30,30, $datos ,'required','','div-3-9') ;
        
        
        $this->obj->text->text('Autorizacion','texto','cab_autorizacion',30,30, $datos ,'','readonly','div-3-9') ;
        
        
        $this->obj->text->texto_oculto("id_diario",$datos); 
        
        $this->obj->text->texto_oculto("idcliente",$datos);
        
        
        $this->set->div_panel9('fin');
        
       
 
          $this->set->evento_formulario('-','fin'); 
          
        
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
 
      
             $evento = 'genera_nota_credito()';
            
             $eventop = 'goToURLNotaCreditoRide()';
            
             $eventocierre = 'goToURLNotaCredito()';
             
             $eventoc = 'goToURLElectronicoEnvio()';
             
             $eventon = 'goToURLNotaConta()';
             
             $eventoaa= 'goToURLNotaAnula()';

             
             
             $titulo = '<b><span style="font-size: 12px">[ Generar Nota de Credito]</span></b> ';
             
             $ToolArray = array(
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Generar Secuencia Nota de Credito',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_warning"),
                 array( boton => 'Generar Documento electronico', evento =>$eventocierre,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success") ,
                 array( boton => 'Emitir Comprobante electronico', evento =>$eventop,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button_default"),
                 array( boton => 'Email Comprobante electronico', evento =>$eventoc,  grafico => 'glyphicon glyphicon-envelope' ,  type=>"button_default"),
                 array( boton => 'ANULAR NOTA DE CREDITO', evento =>$eventoaa,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger")
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
 
  