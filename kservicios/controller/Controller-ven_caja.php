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
      private $Caja;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
             	
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");
  				
                $this->evento_form = '../model/Model-ren_cajas.php' ;      
                
                $this->Caja = $this->bd->query_array('par_usuario',
                    'caja, supervisor, url,completo,tipourl',
                    'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
                    );
                
      }
     //---------------------------------------
      function Formulario( $id,$caja  ){
  
        $tipo           = $this->bd->retorna_tipo(); 
        $datos          = array();
        $datos['fecha'] =  date("Y-m-d");
        
        $this->set->_formulario( $this->evento_form,'inicio' );  
        
        $this->BarraHerramientas( $this->Caja['caja'] , $id);
        
         
        echo '<div class="col-md-9">';
        echo '<div class="col-md-12">';
               $this->obj->text->texte('Nro. Pago','number','id_renpago',30,30,$datos ,'','readonly','','div-0-12') ;
         echo '</div>';
  
        echo '<div id="DivMovimiento"> </div>';
        echo '</div>';


        echo '<div class="col-md-3"><div class="alert alert-info"><div class="row">' ;
        
                 if ( $id > 0 ){
                    $this->ciu_parametro($id);
                    $datos['action'] = 'editar';
                 }else{
                    $this->ciu_sinparametro();
                    $datos['action'] = 'add';
                }
 
 
                $this->set->div_label(12,'FORMA DE PAGO');
                
                $datos['fecha_pago'] =  date("Y-m-d");
                $this->obj->text->texte('Fecha','date','fecha_pago',30,30,$datos ,'required','','','div-0-12') ;
                
                $MATRIZ = array(
                    '-'    => ' [ Seleccione Forma de Pago ] ',
                    'efectivo'    => 'Efectivo',
                    'deposito'    => 'Deposito',
                    'trasferencia'    => 'Trasferencia',
                    'cheque'    => 'Cheque'
                );
                
                $evento = 'onChange="FormaPago(this.value)"';
                $this->obj->list->listae('',$MATRIZ,'formapago',$datos,'required','',$evento,'div-0-12');
                
                
                $evento = 'onkeyup="cambio_dato(this.value)"';
                $this->obj->text->textLong('Monto a pagar',"number",'efectivo',15,15,$datos,'','readonly',$evento,'div-0-12');
                
                
                $evento = '';
                $this->obj->text->texte('Ingrese No. Documento','texto','cuentabanco',30,30,$datos ,'','readonly','','div-0-12') ;
                
                $resultado = $this->bd->ejecutar_catalogo('bancos');
                $this->obj->list->listadbe($resultado,$tipo,'','idbanco',$datos,'','disabled',$evento,'div-0-12');
                
             
                
                $this->obj->text->texte('Fecha transaccion','date','fechadeposito',30,30,$datos ,'','readonly','','div-0-12') ;
                
                echo '<div class="col-md-12" align="center" style="padding: 5px" id="div_sucambio"></div>';
                
                echo '<div id="ver_factura"> </div>';
                
                
        echo '</div></div></div>';
        
 
     
    
        
        $this->obj->text->texto_oculto("action",$datos); 
        
        $this->set->_formulario('-','fin'); 
        
       
      
   }
 //----------------------------------------------
   function BarraHerramientas($autoriza,$id){
   
   
     if ( $autoriza == 'S') {
       
             $eventoc = 'anular()';
         
             $evento  = 'aprobacion()';
             
              $formulario_impresion = '../../reportes/reporte_caja?tipo=51';

        //     $formulario_impresion = '../../reportes/titulo_credito_cobro?tipo=51';
             
             $eventop = 'url_comprobante('."'".$formulario_impresion."')";
             
             $formulario_url = '../view/ren_tramites';
             $evento_url = 'url_e('."'".$formulario_url."')";
             
           
             
             if ( $id > 0 ) {
                 
                 $ToolArray = array(
                     array( boton => 'Regresar', evento =>$evento_url,  grafico => 'glyphicon glyphicon-share' ,  type=>"button_default") ,
                     array( boton => 'Guardar', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                     array( boton => 'Autorizar',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                     array( boton => 'Anular', evento =>$eventoc,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_default") ,
                     array( boton => 'Impresion', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
                 );
                 
             }else{
                 $ToolArray = array(
                     array( boton => 'Nuevo',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                     array( boton => 'Guardar', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                     array( boton => 'Autorizar',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                     array( boton => 'Anular', evento =>$eventoc,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_default") ,
                     array( boton => 'Impresion', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
                 );
             }
             
               
            
             
             $this->obj->boton->ToolMenuDivCrm($ToolArray); 
     
      }else{
          echo '<b>NO SE ENCUENTRA ASIGNADO COMO CAJERO(A)...</b>';
      }
    
    
    
    
   
  }  
   //----------------------------------------------
   function ciu_parametro($id){
    
       
       $datos = $this->bd->query_array('par_ciu',   // TABLA
           '*',                        // CAMPOS
           'id_par_ciu='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
           );
  
       $this->obj->text->text_yellow('','texto','idprov',13,13,$datos ,'','readonly','div-0-12') ;
         
       $this->obj->text->text_yellow('',"texto",'razon',40,45,$datos,'','readonly','div-0-12');
       
       $this->obj->text->text_yellow('',"texto",'direccion',40,45,$datos,'','readonly','div-0-12');
       
       $this->obj->text->text_yellow('','texto','correo',120,120,$datos ,' ','','div-0-12') ;
  
       echo  '<div class="col-md-12" align="center" style="padding: 7px">';
          
       echo  '<button type="button" class="btn btn-sm btn-default" onclick="ActualizaCiu()">Actualizar CIU</button>  ';
 
       echo '</div>';

       $this->obj->text->texto_oculto("id_par_ciu",$datos); 
  }  
  //-----------------------------
  function ciu_sinparametro(){
      
      $datos = array(); 
      
      $this->obj->text->textautocomplete('Ingrese la identificacion','texto','idprov',13,13,$datos ,'required','','div-0-12') ;
         
      $this->obj->text->textautocomplete('Ingrese Contribuyente',"texto",'razon',40,45,$datos,'required','','div-0-12');
      
       
      $this->obj->text->text('',"texto",'direccion',40,45,$datos,'required','','div-0-12');
      
      $this->obj->text->text('','texto','correo',120,120,$datos ,'required','','div-0-12') ;
      
      echo  '<div class="col-md-12" align="center" style="padding: 7px">';
      
      echo  '<button type="button" class="btn btn-sm btn-danger" onclick="loadCiu()">Buscar Deuda</button>  ';

      echo  '<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#myModalDocumento">Busqueda Avanzada</button> ' ;
       
      echo  '<button type="button" class="btn btn-sm btn-default" onclick="ActualizaCiu()">Actualizar CIU</button>  ';

      echo '</div>';
       
       
      $this->obj->text->texto_oculto("id_par_ciu",$datos); 
  }    
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $id 		=     $_GET["id"];
   $caja	=     $_GET["caja"];
   
   $gestion->Formulario($id,$caja );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>
 <script type="text/javascript" src="formulario_ciu.js"></script>