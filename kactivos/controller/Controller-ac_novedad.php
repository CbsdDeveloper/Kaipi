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
      private $anio;

      
      private $ATabla;
      private $ATabla_custodio ;
      
      private $ATabla_carro ;
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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');

                
                $this->anio       =  $_SESSION['anio'];
          
                $this->ATabla = array(
                    array( campo => 'id_bien',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'idbodega',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'tipo_bien',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',        id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'forma_ingreso',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'identificador',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'descripcion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'origen_ingreso',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'Compra', key => 'N'),
                    array( campo => 'tipo_documento',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => 'Factura', key => 'N'),
                    array( campo => 'clase_documento',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tipo_comprobante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_comprobante',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'codigo_actual',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'costo_adquisicion',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'depreciacion',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => 'N', key => 'N'),
                    array( campo => 'serie',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_modelo',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_marca',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'clasificador',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'cuenta',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'valor_residual',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'anio_depre',tipo => 'NUMBER',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'cantidad',tipo => 'NUMBER',id => '23',add => 'S', edit => 'N', valor => '1', key => 'N'),
                    array( campo => 'vida_util',tipo => 'NUMBER',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'color',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'dimension',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'uso',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'N', valor => 'Libre', key => 'N'),
                    array( campo => 'fecha_adquisicion',tipo => 'DATE',id => '28',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'clase',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'N', valor =>  $this->sesion 	, key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '31',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
                    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '32',add => 'S', edit => 'S', valor =>  $this->sesion 	, key => 'N'),
                    array( campo => 'modificacion',tipo => 'DATE',id => '33',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'material',tipo => 'VARCHAR2',id => '34',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'detalle',tipo => 'VARCHAR2',id => '35',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'detalle_ubica',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idsede',tipo => 'NUMBER',id => '37',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idproveedor',tipo => 'VARCHAR2',id => '38',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'factura',tipo => 'NUMBER',id => '39',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_tramite',tipo => 'NUMBER',id => '40',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tiempo_garantia',tipo => 'VARCHAR2',id => '41',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'garantia',tipo => 'VARCHAR2',id => '42',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '43',add => 'S', edit => 'N', valor => 'BIENES', key => 'N'),
                    array( campo => 'baja_c',tipo => 'VARCHAR2',id => '44',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idbien_re',tipo => 'NUMBER',id => '45',add => 'S', edit => 'N', valor => '-', key => 'N')
                 );
                
                
                
                 
                
                $this->tabla 	  	  = 'activo.ac_bienes';
                
                $this->secuencia 	     = 'activo.ac_bienes_id_bien_seq';
                
                
                $this->ATabla_custodio = array(
                    array( campo => 'id_bien_custodio',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '4',add => 'S', edit => 'N', valor =>  $this->hoy, key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor =>$this->sesion , key => 'N'),
                    array( campo => 'modificacion',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
                    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
                    array( campo => 'tipo_ubicacion',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tiene_acta',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => 'N', key => 'N'),
                    array( campo => 'ubicacion_fisica',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => 'N', key => 'N')
                );
                
                
                
                 
                
                 
                $this->ATabla_carro = array(
                    array( campo => 'id_bien_vehiculo',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'clase_ve',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'motor_ve',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'chasis_ve',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'placa_ve',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'anio_ve',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'color_ve',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                );

      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
      //---------------------------------------
      
     function Formulario( $idbien, $accion ){
      
         $datos = array();


         $tipo = $this->bd->retorna_tipo();
         
         $x = $this->bd->query_array('activo.view_bienes',   // TABLA
             '*',                        // CAMPOS
             'id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true) // CONDICION
             );
         
          
         $datos['valor_residual'] = $x['valor_residual'];
         $datos['vida_util']      = $x['vida_util'];
         $datos['costo_bien'] = $x['costo_adquisicion'];
         
          $datos['vida_util_h']      = $x['vida_util'];
         $datos['costo_bien_h']     = $x['costo_adquisicion'];
         
         $datos['estado_h']     = $x['estado'];
         
          
         echo '<h5><b>'. trim($x['cuenta']).' '.trim($x['clase']).' '.trim($x['descripcion']).'</b></h5>'; 
         
 
         if ( $accion == 'add'){
             $datos['fecha_h']      = $this->hoy 	;
             $datos['fecha_a']      = $this->hoy 	;
             $datos['estado_h']     = 'digitado'    ;
             $datos['documento_h']     = '000000'    ;
              
         }
         
         $this->set->div_label(12,'Situacion Actual');
         
                        $this->obj->text->texto_oculto("fecha_a",$datos); 
                        $this->obj->text->texto_oculto("documento_h",$datos); 

                        $this->obj->text->texto_oculto("costo_bien_h",$datos);
                        
                        $this->obj->text->texto_oculto("vida_util_h",$datos);
                        
                        
                        $this->obj->text->text('Fecha Ingreso',"date",'fecha_h',15,15,$datos,'required','','div-2-10');
                            
                        $this->obj->text->editor('Novedad','descripcion',3,350,350,$datos,'','','div-2-10');
                        
                    
                        $MATRIZ = array(
                            '-'    => 'No Aplica',
                            'Reclasificacion'    => 'Reclasificacion',
                            'Mantenimiento'    => 'Mantenimiento',
                            'Reparacion'    => 'Reparacion',
                            'Perdida'    => 'Perdida',
                            'Defectuoso'    => 'Defectuoso',
                            'Reposicion'    => 'Reposición (*)'
                        );
                        
                        
                        $this->obj->list->lista('Tipo',$MATRIZ,'tipo_h',$datos,'required','','div-2-10');
                        
                        
                        $MATRIZ = array(
                            'Bueno'    => 'Bueno',
                            'Malo'    => 'Malo',
                            'Regular'    => 'Regular'
                        );
                        
                        
                        $this->obj->list->lista('Estado',$MATRIZ,'estado_h',$datos,'required','','div-2-4');
                        
                        $this->obj->text->text('Valor Residual','number','valor_residual',10,10, $datos ,'','readonly','div-2-4');
                        
                        $this->obj->text->text('Vida Util','number','vida_util',10,10, $datos ,'','readonly','div-2-4');
                        
                        $this->obj->text->text('Costo Actual','number','costo_bien',10,10, $datos ,'','readonly','div-2-4');
                        
        $this->set->div_label(12,'Categorización y cambio de cuenta');

                        $MATRIZ = array(
                            ''    => '-- Seleccione el tipo de Bien -- ',
                            'BLD'    => 'Bienes de larga duracion',
                            'BCA'    => 'Bienes de control administrativo'
                        );
                        $evento = 'onChange="selecciona_tipo(this.value)"';
                        $this->obj->list->listae('Tipo Bien',$MATRIZ,'tipo_bien',$datos,'','',$evento,'div-2-10');
                        
                         
                        
                        $this->obj->text->textautocomplete('Catalogo',"texto",'clase_esigef',40,45,$datos,'','','div-2-10');
                        
                        $evento = '';
                    
                        $this->obj->text->texto_oculto("identificador",$datos); 
                       
                
                        
                        
                        $this->obj->text->textautocomplete('<b>Clase Bien</b>',"texto",'clase',40,45,$datos,'','','div-2-10');
                        
                        
                        $resultado = $this->sql(1);
                        $this->obj->list->listadbe($resultado,$tipo,'<b>Enlace Contable</b>','cuenta',$datos,'required','',$evento,'div-2-4');
                        
                        $this->obj->text->text('Item',"texto",'clasificador',20,20,$datos,'required','readonly','div-2-4') ;
                        
  
        

   }
   //------------
     //----------------------------------------------
  function sql($titulo){
      
    if  ($titulo == 1){ 
        
            $sqlb = "Select '-' as codigo, '[01. Seleccione cuenta contable ]' as nombre   
                  union
                  SELECT  cuenta as codigo, (cuenta || '.'||  detalle) as nombre
                  FROM  co_plan_ctas
                  where tipo_cuenta = 'A' and univel = 'S' and
                        anio =".$this->bd->sqlvalue_inyeccion($this->anio , true)." and
                        estado =".$this->bd->sqlvalue_inyeccion('S', true).' order by 1';
                 
    }
    

    
    if  ($titulo == 2){
        
        
        $sqlb = "SELECT idmodelo  as codigo ,  nombre
                FROM  web_modelo
               where idmodelo = 0";
        

        
    }
    

    
    $resultado = $this->bd->ejecutar($sqlb);
    
    
    return  $resultado;
    
}  
   ///------------------------------------------------------------------------
   
   function guarda_nuevo( $POST ){
       
          
    if ( trim( $POST['tipo_h'])  == 'Reclasificacion'){
        $documento = $POST['cuenta'];
    }else {
        $documento = $POST['documento_h'];
    }
     

    $descripcion = trim($POST['descripcion']);

    if ( trim( $POST['tipo_h'])  == 'Reposicion'){
       $idbien_nuevo = $this->copiar($POST['bien_tmp']);
       $descripcion =  $descripcion.'... Codigo Bien nuevo asignado es: '. $idbien_nuevo;
    }
    
       
       $ATabla = array(
           array( campo => 'id_bien_historico',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
           array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => trim($POST['bien_tmp']), key => 'N'),
           array( campo => 'fecha_h',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => $POST['fecha_h'], key => 'N'),
           array( campo => 'fecha_a',tipo => 'DATE',id => '3',add => 'S', edit => 'S', valor =>$POST['fecha_a'], key => 'N'),
           array( campo => 'documento_h',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$documento, key => 'N'),
           array( campo => 'detalle_h',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $descripcion, key => 'N'),
           array( campo => 'tipo_h',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => $POST['tipo_h'], key => 'N'),
           array( campo => 'estado_h',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$POST['estado_h'], key => 'N'),
           array( campo => 'costo_bien',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => $POST['costo_bien'], key => 'N'),
           array( campo => 'costo_bien_h',tipo => 'NUMBER',id => '9',add => 'S', edit => 'N', valor => $POST['costo_bien_h'], key => 'N'),
           array( campo => 'vida_util_h',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor => $POST['vida_util_h'], key => 'N'),
           array( campo => 'sesion',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
           array( campo => 'creacion',tipo => 'DATE',id => '12',add => 'S', edit => 'N', valor =>  $this->hoy, key => 'N'),
           array( campo => 'sesionm',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
           array( campo => 'modificacion',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
           array( campo => 'vida_util',tipo => 'NUMBER',id => '15',add => 'S', edit => 'N', valor => $POST['vida_util'], key => 'N')
       );
       
    
       
       $this->bd->_InsertSQL('activo.ac_bienes_historico',$ATabla, 'activo.ac_bienes_historico_id_bien_historico_seq');
       
       if ( trim( $POST['tipo_h'])  == 'Reclasificacion'){
        
        $sql = 'update activo.ac_bienes
                set tipo_bien ='.$this->bd->sqlvalue_inyeccion( $POST['tipo_bien'], true).',
                    clase ='.$this->bd->sqlvalue_inyeccion( $POST['clase'], true).',
                    cuenta ='.$this->bd->sqlvalue_inyeccion( $POST['cuenta'], true).',
                    clasificador ='.$this->bd->sqlvalue_inyeccion( $POST['clasificador'], true).',
                    identificador ='.$this->bd->sqlvalue_inyeccion( $POST['identificador'], true).' 
            where id_bien='.$this->bd->sqlvalue_inyeccion( $POST['bien_tmp'], true);
  

      }else {

        if ( trim( $POST['tipo_h'])  == 'Reposicion'){

                    $sql = 'update activo.ac_bienes
                    set uso ='.$this->bd->sqlvalue_inyeccion( 'Baja', true).',
                        baja_c ='.$this->bd->sqlvalue_inyeccion( 'P', true).',
                        idbien_re='.$this->bd->sqlvalue_inyeccion( $idbien_nuevo, true).",
                        detalle = detalle || ' Bien dado de Baja por reposición Nro. Bien referencia (".$idbien_nuevo.")' ".',
                        estado ='.$this->bd->sqlvalue_inyeccion( 'Malo', true).' 
                where id_bien='.$this->bd->sqlvalue_inyeccion( $POST['bien_tmp'], true);

        }else {
                $sql = 'update activo.ac_bienes
                set costo_adquisicion ='.$this->bd->sqlvalue_inyeccion( $POST['costo_bien_h'], true).',
                    estado ='.$this->bd->sqlvalue_inyeccion( $POST['estado_h'], true).',
                    vida_util ='.$this->bd->sqlvalue_inyeccion( $POST['vida_util_h'], true).' 
            where id_bien='.$this->bd->sqlvalue_inyeccion( $POST['bien_tmp'], true);
        }
    }
       
   
       
       $this->bd->ejecutar($sql);
       
        
   }
    ///------------------------------------------------------------------------
    function copiar( $idbien ){
        
        
        $x = $this->bd->query_array('activo.ac_bienes',' tipo, idbodega, tipo_bien, fecha, forma_ingreso, identificador, descripcion, 
               cantidad, origen_ingreso, tipo_documento, clase_documento, tipo_comprobante, 
               fecha_comprobante, codigo_actual, estado, costo_adquisicion, depreciacion, 
               serie, id_modelo, id_marca, clasificador, cuenta, valor_contable, 
               valor_residual, valor_libros, valor_depreciacion, anio_depre, vida_util, 
               color, dimension, id_bien, uso, fecha_adquisicion, clase, sesion, creacion, 
               sesionm, modificacion, material, detalle, bandera, idsede, detalle_ubica, 
               idproveedor, factura, movimiento, garantia, tiempo_garantia, id_tramite', 
            'id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true)
            );
        
 
 
        $this->ATabla[2][valor]         =   trim($x["tipo_bien"]);
        $this->ATabla[3][valor]         =   trim($x["fecha"]);
        $this->ATabla[4][valor]         =   trim($x["forma_ingreso"]);
        
        $this->ATabla[5][valor]         =   trim($x["identificador"]);
        $this->ATabla[6][valor]         =   trim($x["descripcion"]);
        $this->ATabla[7][valor]         =   trim($x["origen_ingreso"]);
        $this->ATabla[8][valor]         =   trim($x["tipo_documento"]);
        
        
        $this->ATabla[9][valor]         =   trim('Acta de Finiquito');
        $this->ATabla[10][valor]         =   trim($x["tipo_comprobante"]);
        $this->ATabla[11][valor]         =   trim($x["fecha_comprobante"]);
        $this->ATabla[12][valor]         =   trim($x["codigo_actual"]);
        
        $this->ATabla[13][valor]         =   trim($x["estado"]);
        $this->ATabla[14][valor]         =   trim($x["costo_adquisicion"]);
        $this->ATabla[15][valor]         =   trim($x["depreciacion"]);
        $this->ATabla[16][valor]         =   trim($x["serie"]);
    
        
        $this->ATabla[17][valor]         =   trim($x["id_modelo"]);
        $this->ATabla[18][valor]         =   trim($x["id_marca"]);
        $this->ATabla[19][valor]         =   trim($x["clasificador"]);
        $this->ATabla[20][valor]         =   trim($x["cuenta"]);
        
        
        $this->ATabla[21][valor]         =   trim($x["valor_residual"]);
        $this->ATabla[22][valor]         =   trim($x["anio_depre"]);
        $this->ATabla[23][valor]         =   trim($x["cantidad"]);
        $this->ATabla[24][valor]         =   trim($x["vida_util"]);
        
        $this->ATabla[25][valor]         =   trim($x["color"]);
        $this->ATabla[26][valor]         =   trim($x["dimension"]);
        $this->ATabla[27][valor]         =   'Libre';
        $this->ATabla[28][valor]         =   trim($x["fecha_adquisicion"]);
 
        
        $this->ATabla[29][valor]         =   trim($x["clase"]);
 
 
        $this->ATabla[34][valor]         =   trim($x["material"]);
        $this->ATabla[35][valor]         =   trim($x["detalle"]);
        $this->ATabla[36][valor]         =   trim($x["detalle_ubica"]);
        $this->ATabla[37][valor]         =   trim($x["idsede"]);
      
        $this->ATabla[38][valor]         =   trim($x["idproveedor"]);
        $this->ATabla[39][valor]         =   trim($x["factura"]);
        $this->ATabla[40][valor]         =   trim($x["id_tramite"]);
        $this->ATabla[41][valor]         =   trim($x["tiempo_garantia"]);
        
        $this->ATabla[42][valor]         =   trim($x["garantia"]);
     
        $this->ATabla[45][valor]         =   trim($idbien);
  

        
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
 
        
        $y = $this->bd->query_array('activo.ac_bienes_custodio',
                                    'id_bien_custodio, id_bien, idprov, id_departamento, creacion, sesion, 
                                    modificacion, sesionm, tipo_ubicacion, tiene_acta, ubicacion_fisica',
                                   'id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true)
            );
        
        $this->ATabla_custodio[1][valor] =  $id;
        
        //-------------------------------------------------
 
        $this->ATabla_custodio[2][valor]         =   trim($y["idprov"]);
        $this->ATabla_custodio[3][valor]         =   trim($y["id_departamento"]);
        $this->ATabla_custodio[8][valor]         =   trim($y["tipo_ubicacion"]);
        $this->ATabla_custodio[10][valor]         =   trim($y["ubicacion_fisica"]);
        
        
        
        $this->bd->_InsertSQL('activo.ac_bienes_custodio',$this->ATabla_custodio, 'activo.ac_bienes_custodio_id_bien_custodio_seq');
        

        return  $id ;
        
 
        
    }
 
///------------------------------------------------------------------------
}
  

?>
<script type="text/javascript">

jQuery.noConflict(); 

jQuery(document).ready(function() {


	jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#razon").focusout(function(){
	 
	 var itemVariable = $("#razon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU_json.php',
											type:  'GET' ,
											beforeSend: function () {
												$("#idprov").val('...');
											},
											dataType: "json",
											success:  function (response) {
 
												var str = response.a;
												var prov = str.trim()
								
												 $("#idprov").val(prov);   
 
 												 $("#id_departamento").val( response.b ); 

 												 $("#idsede").val( response.c ); 
 												
												 
											} 
									});
	 
    });
 
 
 jQuery('#clase_esigef').typeahead(
		 {
	    minLength : 5,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/Model-ac_busca_indicador.php', { query: query  }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});


 
 jQuery('#clase').typeahead(
		 {
	    minLength : 5,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/Model-ac_busca_clase.php', { query: query   }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

 jQuery('#marca').typeahead(
		 {
	    minLength : 2,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/Model-ac_busca_marca.php', { query: query  }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 //-----------------------------------------
 $("#clase_esigef").focusout(function(){
	 
   var referencia = $("#clase_esigef").val();  

		var parametros = {
									"referencia" : referencia 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/Model_ac_auto_indicador.php',
									dataType: "json",
									success:  function (response) {
 										
											 $("#identificador").val( response.a );  
											 
											 $("#cuenta").val( response.b );  

											 $("#clasificador").val( response.c );  

											 $("#cuenta_parametro").val( response.b );  
 
											 $("#clase").val( response.d );   

											 VerVariables(response.b );
									} 
							});
	
});
 //-----------------------------------------
 $("#marca").focusout(function(){
	 
        var referencia = $("#marca").val();  
        var idmarca    = 0;  
        
		var parametros = {
									"referencia" : referencia 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/Model_ac_auto_marca.php',
									dataType: "json",
									success:  function (response) {
 											 $("#id_marca").val( response.a );  
											 ListaModelo( response.a ) 
 											   
									} 
							});
       //-------------------------------------------------------------------
 				
    });

//------------------------------------
 jQuery('#proveedor').typeahead(
		 {
	    minLength : 5,
	    highlight : true,
	    source:  function (query, process) {
        return jQuery.get('../model/AutoCompleteCIU.php', { query: query   }, function (data) {
        		console.log(data);
        		data = jQuery.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

 jQuery("#proveedor").focusout(function(){
	 
	 var itemVariable = $("#proveedor").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											success:  function (response) {
												var str = response;
 								
												$("#idproveedor").val(str);   
													  
											} 
									});
	 
    });
    //-------------------------------------------------------------------
				
 
 
	
});


 

</script>
   
  