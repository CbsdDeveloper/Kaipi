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
      private $perfil;
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
                
                $this->tabla 	  	  = 'presupuesto.pre_gestion';
                
                $this->secuencia 	     = 'NO';
                
                $this->anio       =  $_SESSION['anio'];
                
                //$this->perfil =  $this->bd->__user( $this->sesion );
                 
                $this->ATabla = array(
                    array( campo => 'partida',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'detalle',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'clasificador',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fuente',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'activo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => 'S', key => 'N'),
                    array( campo => 'funcion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => 'F', key => 'N'),
                    array( campo => 'actividad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'titulo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'grupo',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'subgrupo',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'item',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'subitem',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'orientador',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'proforma',tipo => 'NUMBER',id => '14',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'inicial',tipo => 'NUMBER',id => '15',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'aumento',tipo => 'NUMBER',id => '16',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'disminuye',tipo => 'NUMBER',id => '17',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'codificado',tipo => 'NUMBER',id => '18',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'certificado',tipo => 'NUMBER',id => '19',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'compromiso',tipo => 'NUMBER',id => '20',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'devengado',tipo => 'NUMBER',id => '21',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'pagado',tipo => 'NUMBER',id => '22',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'disponible',tipo => 'NUMBER',id => '23',add => 'S', edit => 'N', valor => '0', key => 'N'),
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'S', valor => $this->anio , key => 'N'),
                    array( campo => 'proyecto',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'competencia',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N')
                 );
               

      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado( $id ,$mensaje,$tipo){
            //inicializamos la clase para conectarnos a la bd
             
             if ($tipo == 0){
                 $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>'.$mensaje.'</b>';
                      
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
                 
             }
             
              
            return $resultado;   
 
      }
 
     
     
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
      function agregar_gasto(  $anio,$tipo,$grupo,$item,$subitem,$actividad,$detalle,$fuente ,$vinicial ,$subitemg,$proyectog,$competenciag,$orientadorg,$funciong,$partidag,$estado){
            // 530203
           $partida  = $partidag;
           $titulo   = substr($grupo,0,1);
           $subgrupo = substr($item,0,4);
           
           $mensaje ='';
           
           $this->ATabla[0][valor] =  $partida;
           $this->ATabla[1][valor] =  $tipo;
           $this->ATabla[2][valor] =  $detalle;
           $this->ATabla[3][valor] =  $item;
           $this->ATabla[4][valor] =  $fuente;
           $this->ATabla[6][valor] =  $funciong;
           $this->ATabla[7][valor] =  $actividad;
           $this->ATabla[8][valor] =  $titulo;
           $this->ATabla[9][valor] =  $grupo;
           $this->ATabla[10][valor] =  $subgrupo;
           $this->ATabla[11][valor] =  $item;
           $this->ATabla[12][valor] =  $subitemg;
           $this->ATabla[13][valor] =  $orientadorg;
          // $this->ATabla[24][valor] =  $anio;
          
           if ( $estado == 'ejecucion') {
               $this->ATabla[14][valor] =  '0.00';
               $this->ATabla[15][valor] =  '0.00';
               $this->ATabla[18][valor] =  '0.00';
               $this->ATabla[23][valor] =  '0.00';
           }else {
               $this->ATabla[15][valor] =  $vinicial;
               $this->ATabla[18][valor] =  $vinicial;
               $this->ATabla[23][valor] =  $vinicial;
           }
      
           
           $this->ATabla[25][valor] =  $proyectog;
           $this->ATabla[26][valor] =  $competenciag;
           
          
           
           
           $valida = strlen(trim($item));
           
           if ( $valida == 6 ) {
               $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
               
               $ResultadoPartida = $this->div_resultado($partida,$mensaje,1) ;
              
           }else{
               
                $mensaje = 'INGRESE LA INFORMACION DEL ITEM PRESUPUESTARIO';
                $ResultadoPartida = $this->div_resultado($partida,$mensaje,0) ;
           }
            
   
            echo $ResultadoPartida;
          
     }	
     //-------------------------------
     //--------------------------------------------------------------------------------
     function agregar_ingreso(  $anio,$tipo,$grupo,$item,$subitem,$actividad,$detalle,$fuente,$vinicial ,$estado ){
         // 530203
         $partida  = $subitem.$fuente;
         $titulo   = substr($grupo,0,1);
         $subgrupo = substr($item,0,4);
         
         $mensaje ='';
         
         $this->ATabla[0][valor] =  $partida;
         $this->ATabla[1][valor] =  $tipo;
         $this->ATabla[2][valor] =  $detalle;
         $this->ATabla[3][valor] =  $item;
         $this->ATabla[4][valor] =  $fuente;
         $this->ATabla[7][valor] =  '--';
         $this->ATabla[8][valor] =  $titulo;
         $this->ATabla[9][valor] =  $grupo;
         $this->ATabla[10][valor] =  $subgrupo;
         $this->ATabla[11][valor] =  $item;
         $this->ATabla[12][valor] =  $subitem;
         $this->ATabla[13][valor] =  '000';
     //    $this->ATabla[24][valor] =  $anio;
         
         if ( $estado == 'ejecucion') {
             $this->ATabla[15][valor] =  '0.00';
             $this->ATabla[18][valor] =  '0.00';
             $this->ATabla[23][valor] =  '0.00';
         }else {
             $this->ATabla[15][valor] =  $vinicial;
             $this->ATabla[18][valor] =  $vinicial;
             $this->ATabla[23][valor] =  $vinicial;
         }
         
         
         $valida = strlen(trim($item));
         
         if ( $valida == 6 ) {
             $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
             
             $ResultadoPartida = $this->div_resultado($partida,$mensaje,1) ;
             
         }else{
             
             $mensaje = 'INGRESE LA INFORMACION DEL ITEM PRESUPUESTARIO';
             $ResultadoPartida = $this->div_resultado($partida,$mensaje,0) ;
         }
         
         
         echo $ResultadoPartida;
         
     }	
     
      //---------------------------------------------------
   
     ///--------------------------------------------------------
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           $fecha = $_POST["fecha"];

           
           
           $trozos = explode("-", $fecha,3);
           $anio1  = $trozos[0];
           $mes1   =  (int) $trozos[1];
           
           
           $this->ATabla[3][valor] =  $anio1;
           $this->ATabla[4][valor] =  $mes1;
           $this->ATabla[6][valor] = 'Inicio de proceso de adquisicion';
           $this->ATabla[15][valor] =  '0';
           
            
               
               $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
               
               $result = $this->div_resultado('editar',$id,1,0).'['. $id.']';
 
          
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
     	$result ='No se puede eliminar el registro';
  
       echo $result;
      
   }
  //----------------------
   function periodo_ejecucion($anio ){
       
 
       
       $x = $this->bd->query_array('presupuesto.view_periodo',
                                   'anio, estado,idperiodo,detalle', 
                                   'anio='.$this->bd->sqlvalue_inyeccion($anio,true)
           );
       
       
       
       return $x['estado'];
       
   }
  //-------------------------------------------------
   function consultaId($anio,$tipo,$grupo,$item,$subitem,$actividad,$detalle,$fuente,$vinicial,$subitemg,$proyectog,$competenciag,$orientadorg,$funciong,$partidag){
       
       
       $estado = $this->periodo_ejecucion($anio );
       
       
       if ( $tipo == 'I'){
           
           $this->agregar_ingreso( $anio,$tipo,$grupo,$item,$subitem,$actividad,$detalle,$fuente ,$vinicial ,$estado);
           
       }else {
           
           $this->agregar_gasto( $anio,$tipo,$grupo,$item,$subitem,$actividad,$detalle,$fuente ,$vinicial,$subitemg,$proyectog,$competenciag,$orientadorg,$funciong,$partidag,$estado );
           
       }
       
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
     if (isset($_GET['tipo']))	{
            
         $anio        = $_GET['anio'];
         $tipo        = $_GET['tipo'];
         $grupo       = $_GET['grupo'];
         $item        = $_GET['item'];
         $subitem     = $_GET['subitem'];
         $actividad   = $_GET['actividad'];
         $detalle     = $_GET['detalle'];
         $fuente      = $_GET['fuente'];
            
         $vinicial =   $_GET['vinicial'];
         
         $subitemg=   $_GET['subitemg'];
         $proyectog=   $_GET['proyectog'];
         $competenciag=   $_GET['competenciag'];
         $orientadorg=   $_GET['orientadorg'];
         $funciong=   $_GET['funciong'];
         $partidag=   $_GET['partidag'];
         
         $gestion->consultaId($anio,$tipo,$grupo,$item,$subitem,$actividad,$detalle,$fuente,$vinicial,$subitemg,$proyectog,$competenciag,$orientadorg,$funciong,$partidag);
            
     }  
  
    
     
   
 ?>
 
  