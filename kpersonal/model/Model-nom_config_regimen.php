<?php 
session_start();   
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
                    array( campo => 'programa',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'programa_p',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N')
                );
                
              
                
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
      function consultaId($id,$regimen='-' ){
          
 	
     $qcabecera = array(
         array(etiqueta => 'Id',            campo => 'id_config_reg',ancho => '5%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
         array(etiqueta => 'Programa Rol',  campo => 'programa',    ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Regimen',       campo => 'regimen',     ancho => '20%', filtro => 'S', valor => $regimen, indice => 'N', visor => 'S'),
         array(etiqueta => 'Concepto',      campo => 'nombre',      ancho => '15%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Clasificador',  campo => 'clasificador',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Cuenta Debe',   campo => 'cuenta_debe', ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Cuenta Haber',  campo => 'cuenta_haber',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'Programa Pago', campo => 'programa_p',  ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
         array(etiqueta => 'id_regimen',    campo => 'id_regimen',  ancho => '0%', filtro => 'N', valor => '-', indice => 'N', visor => 'N'),
         array(etiqueta => 'id_config',     campo => 'id_config',   ancho => '0%', filtro => 'S', valor => $id, indice => 'N', visor => 'N'),
         array(etiqueta => 'tipo_config',   campo => 'tipo_config', ancho => '0%', filtro => 'N', valor => '-', indice => 'N', visor => 'N'),
         array(etiqueta => 'variable',      campo => 'variable',    ancho => '0%', filtro => 'N', valor => '-', indice => 'N', visor => 'N'),
         array(etiqueta => 'tipoformula',   campo => 'tipoformula', ancho => '0%', filtro => 'N', valor => '-', indice => 'N', visor => 'N'),
         array(etiqueta => 'estructura',    campo => 'estructura',  ancho => '0%', filtro => 'N', valor => '-', indice => 'N', visor => 'N')
     );
 
     $acciones = "editar,eliminar,visor";
     $funcion  = 'goToURLParametro';
     
     $this->bd->_order_by('regimen,programa');
     $this->bd->JqueryArrayTable('view_nomina_rol_reg',$qcabecera,$acciones,$funcion,'tabla_config' );
     
 
     
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
            
            $this->ATabla[9][valor] = $programa;
 
            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
        	
 
            $this->consultaId($id,$regimen ) ;
 
          
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
 
          $this->consultaId($idrubro,$regimen ) ;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
    function eliminar($id,$id_config_reg,$regimen ){
      
        $sql = "DELETE  FROM nom_config_regimen
                 where id_config_reg = ".$this->bd->sqlvalue_inyeccion($id_config_reg,true);
        
        $this->bd->ejecutar($sql);
        
        $this->consultaId($id ,$regimen) ;
      
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id_config'];
 
            if ( $accion== 'add'){
                
                $regimen        = $_GET['regimen'];
                $partida        = $_GET['partida'];
                $cuentai        = $_GET['cuentai'];
                $cuentae        = $_GET['cuentae'];
                $tipo           = $_GET['tipo'];
                $programa       = $_GET['programa'];
                
                
  
                $gestion->agregar($id,$regimen,$partida,$cuentai,$cuentae,$tipo,$programa);
                
            }
            
            if ( $accion== 'editar'){
                
                $regimen        = $_GET['regimen'];
                $partida        = $_GET['partida'];
                $cuentai        = $_GET['cuentai'];
                $cuentae        = $_GET['cuentae'];
                $tipo           = $_GET['tipo'];
                $programa       = $_GET['programa'];
                
                $id_config_reg   = $_GET['id_config_reg'];
                
                $gestion->edicion($id,$id_config_reg,$regimen,$partida,$cuentai,$cuentae,$tipo,$programa);
                
            }
            
            
            if ( $accion== 'visor'){
 
                
                $gestion->consultaId($id,$regimen);
                
            }
            
            
            if ( $accion== 'del'){
                
                $id_config_reg        = $_GET['id_config_reg'];
                
                $regimen        = $_GET['regimen'];
                
                $gestion->eliminar($id,$id_config_reg,$regimen);
                
            }
            
            
     }  
 
 ?>