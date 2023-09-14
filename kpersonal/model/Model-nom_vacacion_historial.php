<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
     
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $tabla ;
      private $secuencia;
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'nom_config_regimen';
                
                $this->secuencia 	     = 'nom_config_regimen_id_config_reg_seq';
 
                $this->ATabla = array(
                    array( campo => 'id_config_reg',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'id_regimen',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'id_config',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'regimen',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'tipo_config',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'cuenta_debe',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'cuenta_haber',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'clasificador',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'programa',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => '-', key => 'N')
                );
                
                
                $this->anio       =  $_SESSION['anio'];
              
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function regimen( $tipo){
         
      
          $x = $this->bd->query_array('nom_regimen',
                                      'id_regimen', 
                                      'regimen='.$this->bd->sqlvalue_inyeccion($tipo,true)
              );
          
          return $x['id_regimen']; 
        
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_limpiar( ){
            //inicializamos la clase para conectarnos a la bd
       
             $resultado = '';
             echo '<script type="text/javascript">';
              
             echo  'LimpiarPantalla();';               
   
             echo '</script>';
 
            return $resultado;   
 
      }     
   
   
    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($id ,$estado){
          
 	
     $x = $this->bd->query_array('view_nomina_rol',
                                 'idprov, razon, regimen, fecha,  cargo,    tiempo,   programa,  unidad', 
                                'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)
                                );
     
 
     echo '  <div class="col-md-12" style="padding: 15px">
            <h5>'.$x['regimen'].' ('.$x['programa'].')'.'<br>'.$x['unidad'].'<br><b>'.$x['razon'].'</b><br>'.$x['cargo'].'<br>Ingreso '.$x['fecha'];
      echo ' </h5> </div>';
     
     $qcabecera = array(
         array(etiqueta => 'Id',campo => 'id_vacacion',ancho => '5%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
         array(etiqueta => 'Identificacion',campo => 'idprov',ancho => '5%', filtro => 'S', valor => $id, indice => 'N', visor => 'S'),
         array(etiqueta => 'Estado',campo => 'estado_tramites',ancho => '15%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Motivo',campo => 'motivo',ancho => '20%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Novedad',campo => 'novedad',ancho => '20%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Salida',campo => 'fecha_out',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Entrada',campo => 'fecha_in',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Nro.Dias',campo => 'dia_tomados',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Fraccion Hora/Dia',campo => 'hora_tomados',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Dia Contabiliza',campo => 'dia_acumula',ancho => '5%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'anio',campo => 'anio',ancho => '0%', filtro => 'S', valor =>  $this->anio, indice => 'N', visor => 'N'),
         array(etiqueta => 'estado_seg',campo => 'estado',ancho => '0%', filtro => 'S', valor => $estado, indice => 'N', visor => 'N'),
      );
      
      
     $acciones = "editar,eliminar,''";

     $funcion  = 'goToURLParametro';
     
     $this->bd->_order_by('id_vacacion desc');
     
     $this->bd->JqueryArrayTable('view_nomina_vacacion',$qcabecera,$acciones,$funcion,'tabla_config' );
     
 
     
     
     
     
 }	
 
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 function agregar(  $id,$regimen,$partida,$cuentai,$cuentae,$tipo,$programa ){
         
 
            $this->ATabla[1][valor] = $this->regimen($regimen);
         
            $this->ATabla[2][valor] = $id;
            $this->ATabla[3][valor] = $regimen;
            $this->ATabla[4][valor] = $tipo;
           
            $this->ATabla[5][valor] = $cuentai;
            $this->ATabla[6][valor] = $cuentae;
            $this->ATabla[7][valor] = $partida;
            $this->ATabla[8][valor] = $programa;
            
 
            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        	
 
            $this->consultaId($id ) ;
 
          
     }	
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
     function edicion( $idrubro,$id,$regimen,$partida,$cuentai,$cuentae,$tipo,$programa ){
           
 
         $this->ATabla[3][valor] = $regimen;
         $this->ATabla[4][valor] = $tipo;
         
         $this->ATabla[5][valor] = $cuentai;
         $this->ATabla[6][valor] = $cuentae;
         $this->ATabla[7][valor] = $partida;
         $this->ATabla[8][valor] = $programa;
         
 
          $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
 
          $this->consultaId($idrubro ) ;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
    function eliminar($id,$id_config_reg ){
      
        $sql = "DELETE  FROM nom_config_regimen
                 where id_config_reg = ".$this->bd->sqlvalue_inyeccion($id_config_reg,true);
        
        $this->bd->ejecutar($sql);
        
     	$this->consultaId($id ) ;
      
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
    
    $id        = $_GET['idprov'];
    
    $estado    = $_GET['estado'];
    
    $gestion->consultaId(trim($id) ,$estado);
     
     
   
 ?>