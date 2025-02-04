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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =     date("Y-m-d");
        
          
      }
 
      //---------------------------------------
      
      function Formulario($id ,$idren_local){
      
         
         $datos = array();
 
         

         $this->set->div_panel6('<b> DETALLE DE INFORMACION PARA EMISION </b>');
        
    
         
         $eventop = 'onclick="VerFacturacion_proceso('.$idren_local.')"';
         
         $eventoc1 = 'onclick="openfac_nuevo(1)"';
         $eventoc2 = 'onclick="openfac_nuevo(2)"';
         $eventoc3 = 'onclick="openfac_nuevo(3)"';
         
         echo '<div class="btn-group" style="padding-bottom: 10px;padding-top: 15px; padding-left: 15px">
                <button type="button" class="btn btn-warning btn-sm" '.$eventop.'><i class="glyphicon glyphicon-cog"></i></button>
                <div class="btn-group">
                      <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                      Emision de Comprobantes <span class="caret"></span></button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#" '.$eventoc3.'>Emite Todo Servicio </a></li>
                        <li><a href="#" '.$eventoc1.'>Emite Luz (Energia Electrica) </a></li>
                        <li><a href="#" '.$eventoc2.'>Emite Arriendo(Periodo Mes) </a></li>
                      
                      </ul>
                    </div> 
               </div>';
        
         $this->set->div_label(12,$x['razon'].' '.$x['tipo']);	 
         
         $datos['carriendo']       = '0.00';
         $datos['cluz']            = '0.00';
         $datos['cagua']           = '0.00';
         $datos['fecha_emite']     =  $this->hoy ;
         
         $fecha = explode("-",$this->hoy);
         $mes  = $fecha[1];
         $anio = $fecha[0];
         
         $datos['cdetalle']     =  $x['tipo']. ' Nro. '.$x['numero'].' Periodo '. $mes. '-'.$anio ;
         
         
          
  
         $this->obj->text->text('<b>ARRIENDO($)</b>',"number" ,'carriendo' ,80,80, $datos ,'required','','div-4-8') ;
         $this->obj->text->text('<b>LUZ($)</b>',"number" ,'cluz' ,80,80, $datos ,'required','','div-4-8') ;
         $this->obj->text->text('<b>AGUA($)</b>',"number" ,'cagua' ,80,80, $datos ,'required','','div-4-8') ;
         
         $this->obj->text->text('Fecha Emision',"date" ,'fecha_emite' ,80,80, $datos ,'required','','div-4-8') ;
         
         $this->obj->text->editor('Detalle','cdetalle',3,45,300,$datos,'required','','div-4-8') ;
         
         
         $this->set->div_panel6('fin');

         

         /*
       $this->set->div_panel12('<b> EMISION DE COMPROBANTES PAGO </b>');
  
         

       
       $resultado = $this->bd->ejecutar("select id_movimiento as codigo, detalle  as nombre
                    							       from inv_movimiento
                    							      where estado = 'digitado' and modulo = 'arriendo' AND 
                                                            idprov=".$this->bd->sqlvalue_inyeccion($id, true).'
                                                    order by fecha desc');
       $tipo = $this->bd->retorna_tipo();
       
       $this->obj->list->listadb($resultado,$tipo,'Facturas Emitidas','idfacturas',$datos,'required','','div-2-10');
       
       
       $eventoc = 'onclick="javascript:openfac()"';
       $eventop = 'onclick="javascript:VerFacturacion_proceso('.$idren_local.')"';
       $eventoa = 'onclick="javascript:VerFacturacion_anular()"';
       
       
       echo '<div class="btn-group" style="padding-bottom: 20px;padding-top: 25px; padding-left: 230px">
              <button type="button" class="btn btn-info btn-sm" '.$eventop.'><i class="glyphicon glyphicon-cog"></i></button>
              <button type="button" class="btn btn-success btn-sm" '.$eventoc.'>Pago Comprobante electronico</button>
              <button type="button" class="btn btn-danger btn-sm" '.$eventoa.'>Anular tramite </button>
               
            </div><div id="anulado_fac"></div>';
                           
               
       $this->set->div_panel12('fin');
       
 
     
       */
       
   }
 
   
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
  if (isset($_GET['accion']))	{
      
      
      $id           = $_GET['idprov'];
      $idren_local  = $_GET['idren_local'];
      
      $gestion->Formulario(trim($id), $idren_local );
     
      
      
      
  }
   
  
 ?>
 
  