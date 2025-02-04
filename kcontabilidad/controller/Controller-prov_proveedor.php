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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-prov_proveedor.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //---------------------------------------
      
     function Formulario( ){
      
 
        $titulo ='';
        $evento ='';
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
        $datos = array();
        
                $this->BarraHerramientas();
                     
                $MATRIZ =  $this->obj->array->catalogo_tpIdProv();
                
                $this->obj->list->listae('identificacion',$MATRIZ,'tpidprov',$datos,'required','',$evento,'div-2-4');
                
                
                $evento = 'onBlur="javascript:validarCiu()"';
                
                $this->obj->text->texte('Identificacion',"texto",'idprov',20,15,$datos,'required','',$evento,'div-2-4') ; 
                
                $MATRIZ =  $this->obj->array->catalogo_naturaleza();
                
                $this->obj->list->listae('Naturaleza',$MATRIZ,'naturaleza',$datos,'required','',$evento,'div-2-4');
                
                $MATRIZ =  $this->obj->array->catalogo_activo();
                
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-4');
                
                
                $MATRIZ = array(
                		'P'    => 'Proveedor',
                		'C'    => 'Cliente',
                        'N'    => 'Nomina'
                );
                
                $this->obj->list->listae('Tipo',$MATRIZ,'modulo',$datos,'','',$evento,'div-2-4');
                
                $resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre
            			                     from par_catalogo
            								where tipo = 'canton' and publica = 'S' order by nombre ");
                
                $tipo = $this->bd->retorna_tipo();
                
                $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Razon Social',"texto",'razon',100,100,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('Direccion',"texto",'direccion',80,80,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text('Email',"email",'correo',40,45,$datos,'required','','div-2-4') ;
                
                $reg ="\d{2}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                $this->obj->text->textMask('Telefono',"tel",'telefono',18,20,$datos,'required','','',$reg,'div-2-4');
                
                $reg ="\d{3}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                
                $this->obj->text->textMask('Movil',"tel",'movil',18,20,$datos,'required','','',$reg,'div-2-4');
                // lista de valores
                
                    
                $this->set->div_label(12,'Informacion Financiera (Pagos)');
                
                
                
                $resultado = $this->bd->ejecutar("SELECT idcatalogo as codigo, nombre FROM par_catalogo where tipo = 'bancos' ");
                
                
                $this->obj->list->listadb($resultado,$tipo,'Entidad Bancaria','id_banco',$datos,'required','','div-2-4');
                
                
                $MATRIZ =  $this->obj->array->nom_tipo_banco();
                
                $this->obj->list->lista('Tipo Cuenta',$MATRIZ,'tipo_cta',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Nro.Cuenta',"texto",'cta_banco',30,30,$datos,'required','','div-2-4');
                
                
                
                $MATRIZ = array(
                    'N'    => 'NO',
                    'S'    => 'SI'
                );
                
 
                
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("contacto",$datos); 
         $this->obj->text->texto_oculto("ccorreo",$datos); 
         $this->obj->text->texto_oculto("ctelefono",$datos); 
         $this->obj->text->texto_oculto("cmovil",$datos); 
         
         $this->obj->text->texto_oculto("sifondo",$datos); 
         
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
///------------------------------------------------------------------------
  function consultaId($accion,$id ){
      
      /*	if (strlen(trim($id)) == 9){
       $id = '0'.$id;
       }
       if (strlen(trim($id)) == 12){
       $id = '0'.$id;
       }
       */
      
      $qquery = array(
      array( campo => 'idprov',   valor =>$id,  filtro => 'S',   visor => 'S'),
      array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'contacto',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'ctelefono',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'ccorreo',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'tpidprov',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'naturaleza',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'cmovil',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
      array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'id_banco',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'tipo_cta',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'cta_banco',   valor => '-',  filtro => 'N',   visor => 'S')
      );
      
      $this->bd->JqueryArrayVisor('par_ciu',$qquery );
      
      echo "<script> $('#action').val('editar');</script>";
       
      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
      
      echo "<script> $('#result').html('".$resultado."');</script>";
 
  }
}
?>
 
  