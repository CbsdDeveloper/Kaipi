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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');
          
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
      //---------------------------------------
      
     function Formulario( $idbien, $accion ){
      
         $datos = array();
         
         $x = $this->bd->query_array('activo.view_bienes',   // TABLA
             '*',                        // CAMPOS
             'id_bien='.$this->bd->sqlvalue_inyeccion($idbien,true) // CONDICION
             );
         
          
         $datos['valor_residual'] = $x['valor_residual'];
         $datos['vida_util']      = $x['vida_util'];
         $datos['costo_bien'] = $x['costo_adquisicion'];
   
         
         echo '<h5><b>'. trim($x['cuenta']).' '.trim($x['clase']).' '.trim($x['descripcion']).'</b></h5>'; 
         
 
         if ( $accion == 'add'){
             $datos['fecha_h']      = $this->hoy 	;
             $datos['fecha_a']      = $this->hoy 	;
             $datos['estado_h']     = 'digitado'    ;
         }
         
        $this->obj->text->text('Fecha Ingreso',"date",'fecha_h',15,15,$datos,'required','','div-2-4');
        
        $this->obj->text->text('Fecha Acta',"date",'fecha_a',15,15,$datos,'required','','div-2-4');
        
        $this->obj->text->text('Documento Acta',"texto",'documento_h',13,13,$datos,'required','','div-2-4');
        
        $this->obj->text->text('Estado',"texto",'estado_h',13,13,$datos,'required','readonly','div-2-4');
        
        
        $this->obj->text->editor('Novedad','descripcion',3,70,100,$datos,'','','div-2-10');
        
        $this->set->div_label(12,'Situacion Actual');
        
        $this->obj->text->text('Valor Residual','number','valor_residual',10,10, $datos ,'','readonly','div-2-4');
        
        $this->obj->text->text('Vida Util','number','vida_util',10,10, $datos ,'','readonly','div-2-4');
        
        $this->obj->text->text('Costo Actual','number','costo_bien',10,10, $datos ,'','readonly','div-2-4');
        
        $this->set->div_label(12,'Situacion Propuesta');
        
        $this->obj->text->text_blue('Costo Nuevo','number','costo_bien_h',10,10, $datos ,'required','','div-2-4');
        
        $this->obj->text->text_blue('Vida Util(*)','number','vida_util_h',10,10, $datos ,'required','','div-2-4');
  
        

   }
   ///------------------------------------------------------------------------
   
   function guarda_nuevo( $POST ){
       
          
       
       $ATabla = array(
           array( campo => 'id_bien_historico',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
           array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => trim($POST['bien_tmp']), key => 'N'),
           array( campo => 'fecha_h',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => $POST['fecha_h'], key => 'N'),
           array( campo => 'fecha_a',tipo => 'DATE',id => '3',add => 'S', edit => 'S', valor =>$POST['fecha_a'], key => 'N'),
           array( campo => 'documento_h',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$POST['documento_h'], key => 'N'),
           array( campo => 'detalle_h',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $POST['descripcion'], key => 'N'),
           array( campo => 'tipo_h',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => 'revalorizado', key => 'N'),
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
       
       
       $sql = 'update activo.ac_bienes
                set costo_adquisicion ='.$this->bd->sqlvalue_inyeccion( $POST['costo_bien_h'], true).',
                    vida_util ='.$this->bd->sqlvalue_inyeccion( $POST['vida_util_h'], true).' 
               where id_bien='.$this->bd->sqlvalue_inyeccion( $POST['bien_tmp'], true);
       
       $this->bd->ejecutar($sql);
       
        
   }
 
   ///------------------------------------------------------------------------
 
///------------------------------------------------------------------------
}
  

?>