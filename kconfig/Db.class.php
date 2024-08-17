<?php
date_default_timezone_set('America/Lima');

/**
 * Clase contenedora que contiene funciones de conexion y acceso a tablas y procesos para CRUD.
 * Esta clase contiene parametros para la conexion con diferentes bases de datos.
 * 
 * NOTA: Esta clase debe ir en cada archivo del proyecto.
 *
 * @return  
 **/
class Db {
	
    
    // definimos variables para el acceso y conexion de la base de datos
    
   private $servidor; 
   private $usuario;
   private $password;
   private $base_datos;
   private $tipo;
   private $link;
   private $error;
   private $stmt;
   private $array;
   private $pideSecuencia;
   private static $_instance;
   
   
   // definimos variables para consultas query de la base de datos
   
   public $limit;
   public $between_query;
   public $where_query;
   public $orderby;
   
   /**
    * Funcion constructor de la clase para conexion de la base de datos
    * Esta clase contiene parametros para la conexion con diferentes bases de datos.
    *
    * NOTA: Esta clase debe ir en cada archivo del proyecto.
    *
    * @return
    */
   public  function Db(){
   
    $host       = '127.0.0.1';
    $db         = '-';
    $user       = 'postgres';
    $password   = '-' ;
    $dbType     = 'postgres';
       
   	// include('Db.user.php');
   
   	$this->servidor	      = '192.168.1.3'; //$this->_refd($host);
   	$this->base_datos     = 'db_kaipi';//$this->_refd($db);
   	$this->usuario        = 'postgres';//$this->_refd($user);
   	$this->password       = 'Cbsd2019';//$this->_refd($password);
   	$this->tipo           = 'postgress';//$this->_refd($dbType);
 
	 
   	$this->pideSecuencia = 1;
   
   }
   
   /*Evitamos el clonaje del objeto.  */
   
   private function __clone(){ }
   
   private function __wakeup(){ }
   
   /* encargada de crear, debemos llamar desde fuera de la clase para instanciar el objeto*/
   
   public static function getInstance(){
 
      if (!(self::$_instance instanceof self)){
         self::$_instance=new self();
      }
	  
         return self::$_instance;
   }
   //------------------------------------------------------------------------
   public function __between($campo,$fecha1,$fecha2){
       
       if ($campo == '-'){
           $this->between_query = '-';
       }else{
           
           $this->between_query = "  AND ( ".$campo.' BETWEEN '."'".$fecha1."'". ' AND '."'".$fecha2."' ) ";
           
       }
        
       return 1;
   }
   //----------------------------------------------------
   public function _fnumber($numero){
       
       return   number_format($numero,2,".",",");
       
   }
   //-----------------------------------
   function _formato_fecha($fecha){
       
       $trozos = explode("-", $fecha,3);
       
       $anio = $trozos[0];
       $nmes = $trozos[1];
       $dia1 = $trozos[2];
       
       
       if ($nmes == '1')
           $cmes = 'Enero';
           elseif ($nmes == '2')
           $cmes = 'Febrero';
           elseif ($nmes == '3')
           $cmes =   'Marzo';
           elseif ($nmes == '4')
           $cmes =  'Abril';
           elseif ($nmes == '5')
           $cmes = 'Mayo';
           elseif ($nmes == '6')
           $cmes =   'Junio';
           elseif ($nmes == '7')
           $cmes =  'Julio';
           elseif ($nmes == '8')
           $cmes = 'Agosto';
           elseif ($nmes == '9')
           $cmes = 'Septiembre';
           elseif ($nmes == '10')
           $cmes =   'Octubre';
           elseif ($nmes == '11')
           $cmes =   'Noviembre';
           elseif ($nmes == '12')
           $cmes =   'Diciembre';
           
           
           return  $cmes.' '.$dia1.', '.$anio;
           
   }  
   
   //-------------------
   public  function poner_guion($string){
       
       $string =   trim($string) ;
    
       $string =  str_replace('Ã³',"ó",trim($string));
       
       $string =  str_replace('Ã',"í",trim($string));
       
        $string =  str_replace('"',"'",trim($string));
      
       $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
       $reemplazar=array("", "", "", "");
       
       $string=str_ireplace($buscar,$reemplazar,$string);
       
       
        
       return $string;
   }
   //--------------------------------
   public  function _caracteres($string){
       
       header('Content-Type: text/html; charset=UTF-8');
       
       $cadena = utf8_encode($string);
       
       //Ahora reemplazamos las letras
       $cadena = str_replace(
           array('Ã¡', 'Ã ', 'Ã¤', 'Ã¢', 'Âª', 'Ã�', 'Ã€', 'Ã‚', 'Ã„'),
           array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
           $cadena
           );
       
       $cadena = str_replace(
           array('Ã©', 'Ã¨', 'Ã«', 'Ãª', 'Ã‰', 'Ãˆ', 'ÃŠ', 'Ã‹'),
           array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
           $cadena );
       
       $cadena = str_replace(
           array('Ã­', 'Ã¬', 'Ã¯', 'Ã®', 'Ã�', 'ÃŒ', 'Ã�', 'ÃŽ'),
           array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
           $cadena );
       
       $cadena = str_replace(
           array('Ã³', 'Ã²', 'Ã¶', 'Ã´', 'Ã“', 'Ã’', 'Ã–', 'Ã”'),
           array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
           $cadena );
       
       $cadena = str_replace(
           array('Ãº', 'Ã¹', 'Ã¼', 'Ã»', 'Ãš', 'Ã™', 'Ã›', 'Ãœ'),
           array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
           $cadena );
       
       $cadena = str_replace(
           array('Ã±', 'Ã‘', 'Ã§', 'Ã‡'),
           array('n', 'N', 'c', 'C'),
           $cadena
           );
       
       $cadena = mb_convert_encoding($cadena, "HTML-ENTITIES", "UTF-8");
       return $cadena;
      
   }
   //---------------
   public function _order_by($campo){
       
       $this->orderby = ' order by '. $campo;
     
  
   }
    //---------------
    public function _catalogo_iva(){
       
        $x = $this->query_array('co_catalogo',   // TABLA
           'valor1',                             // CAMPOS
           'secuencia='.$this->sqlvalue_inyeccion(122,true) // CONDICION
           );
       
       return $x['valor1'];
       
   }
   //--------------------
   
   public function _siglas_comprobantes(){
       
       $x = $this->query_array('wk_config',   // TABLA
           'modulo',                             // CAMPOS
           'tipo='.$this->sqlvalue_inyeccion(80,true) // CONDICION
           );
       
       return $x['modulo'];
       
     
   }
   
   //---------------
   public function _catalogo_dato($idcatalogo){
       
        $x = $this->query_array('par_catalogo',   // TABLA
           'nombre',                             // CAMPOS
           'idcatalogo='.$this->sqlvalue_inyeccion($idcatalogo,true) // CONDICION
           );
       
       return $x['nombre'];
       
   }
   //---------------------
   public function _es_encargado($idprov){

       
    $x = $this->query_array('nom_accion',    
       'count(*) as nn',                           
       'idprov='.$this->sqlvalue_inyeccion(trim($idprov),true)  ." and  
        estado = 'S' and 
        finalizado = 'N' and 
        motivo = 'ENCARGO'"  
       );
   
        if (  $x['nn'] > 0 ){
            return 1;
        }else{
            return 0;
        }


   
}
   //---------------------
   public function _cierre($fecha){

       $x              = explode('-',$fecha);
       $mes  			= $x[1];
       $anio  			= $x[0];
       
       $AResultado = $this->query_array('co_periodo',
                                            'estado,mes,anio,registro', 
           'registro='.$this->sqlvalue_inyeccion($_SESSION['ruc_registro'],true).' and
            mes='.$this->sqlvalue_inyeccion($mes,true).' and 
            anio='.$this->sqlvalue_inyeccion($anio,true) 
        );
       
       return trim($AResultado['estado']);
       
   }
 //---------------
   //---------------------
   public function _periodo($anio){
      
       
       $AResultado = $this->query_array('presupuesto.pre_periodo',
           'idperiodo,estado',
           'anio='.$this->sqlvalue_inyeccion($anio,true)
           );
       
       return trim($AResultado['idperiodo']);
       
   }
   //-----------------------------
   function _mes($nmes){
       
       if ($nmes == 1)
       return  'Enero';
       elseif ($nmes == 2)
       return  'Febrero';
       elseif ($nmes == 3)
       return  'Marzo';
       elseif ($nmes == 4)
       return  'Abril';
       elseif ($nmes == 5)
       return  'Mayo';
       elseif ($nmes == 6)
       return  'Junio';
       elseif ($nmes == 7)
       return  'Julio';
       elseif ($nmes == 8)
       return  'Agosto';
       elseif ($nmes == 9)
       return  'Septiembre';
       elseif ($nmes == 10)
       return  'Octubre';
       elseif ($nmes == 11)
       return  'Noviembre';
       elseif ($nmes == 12)
       return  'Diciembre';
       
   }  
   public function obtener_row($stmt){
       
       switch ($this->tipo){
           case 'mysql':    $this->array=mysqli_fetch_assoc($stmt);
           break;
           case 'postgress':
               $this->array = pg_fetch_array($stmt);
               break;
           case 'oracle':  {
               $this->array = oci_fetch_assoc($stmt);
               
               break;
           }
           break;
       }
       return $this->array;
   }
   //---------------------------
   function _fecha_completa($fecha,$dia_var='N'){
       
       $trozos = explode("-", $fecha,3);
       
       $anio1 = $trozos[0];
       $nmes =  intval($trozos[1]);
       $dia1 =  $trozos[2]; 	
       
       if ($nmes == 1)
           $cmes =  'Enero';
           elseif ($nmes == 2)
           $cmes =  'Febrero';
           elseif ($nmes == 3)
           $cmes =  'Marzo';
           elseif ($nmes == 4)
           $cmes =  'Abril';
           elseif ($nmes == 5)
           $cmes =  'Mayo';
           elseif ($nmes == 6)
           $cmes =  'Junio';
           elseif ($nmes == 7)
           $cmes =  'Julio';
           elseif ($nmes == 8)
           $cmes =  'Agosto';
           elseif ($nmes == 9)
           $cmes =  'Septiembre';
           elseif ($nmes == 10)
           $cmes =  'Octubre';
           elseif ($nmes == 11)
           $cmes =  'Noviembre';
           elseif ($nmes == 12)
           $cmes =  'Diciembre';
           

 
           $dias      = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
           $dia_valor = $dias[(date('N', strtotime($fecha))) - 1];

         


           if ( $dia_var == 'N'){
                  return $dia1.' de '.$cmes.' del '.$anio1;
            }  else{
                return  $dia_valor.', '.$dia1.' de '.$cmes.' del '.$anio1;
               }
   }  
   //-------------------------------------
   function _primer_dia($fecha){
       
       $trozos = explode("-", $fecha,3);
       
       $anio1 = $trozos[0];
       
 
       
       if (!isset($_SESSION['anio']))	{
           $_SESSION['anio'] = $anio1;
       }
       
 
       $anio_actual = $_SESSION['anio'];
      
       
       
       if ( $anio1 == $anio_actual ){
          
          $month = date('m');
          $year = date('Y');
          return  date('Y-m-d', mktime(0,0,0, $month, 1, $year));
          
      }else
      {
            
           return   $anio_actual.'-12-01';
           
      }
 
           
   }  
   //-------------------------------------
   function _ultimo_dia($fecha){
       
       $trozos = explode("-", $fecha,3);
       
       $anio1 = $trozos[0];
       $mes   = $trozos[1];
     
       $month       = $anio1.'-'.$mes;
       $aux         = date('Y-m-d', strtotime("{$month} + 1 month"));
       $last_day    = date('Y-m-d', strtotime("{$aux} - 1 day"));
       
       
       return  $last_day;
       
        
   }  
   //-------------------------------------
   function _actual_dia($fecha){
     
       $trozos = explode("-", $fecha,3);
       
       $anio1 = $trozos[0];
         
       
       if (!isset($_SESSION['anio']))	{
           $_SESSION['anio'] = $anio1;
       }
       
       
       
       $anio_actual = $_SESSION['anio'];
       
       if ( $anio1 == $anio_actual ){
             
           return $fecha ;
           
       }else
       {
  
           
           return   $anio_actual.'-12-31';
           
           
       }
       
       
   }  
   
   
   function _anio($fecha){
       
       $trozos = explode("-", $fecha,3);
       
       $anio1 = $trozos[0];
    
       
       
       return $anio1;
       
   }  
   //-------------------------------------
   function _fecha_completa_acta($fecha){
       
       $trozos = explode("-", $fecha,3);
       
       $anio1 = $trozos[0];
       $nmes =  $trozos[1];
       $dia1 =  $trozos[2];
       
       if ($nmes == 1)
           $cmes =  'Enero';
           elseif ($nmes == 2)
           $cmes =  'Febrero';
           elseif ($nmes == 3)
           $cmes =  'Marzo';
           elseif ($nmes == 4)
           $cmes =  'Abril';
           elseif ($nmes == 5)
           $cmes =  'Mayo';
           elseif ($nmes == 6)
           $cmes =  'Junio';
           elseif ($nmes == 7)
           $cmes =  'Julio';
           elseif ($nmes == 8)
           $cmes =  'Agosto';
           elseif ($nmes == 9)
           $cmes =  'Septiembre';
           elseif ($nmes == 10)
           $cmes =  'Octubre';
           elseif ($nmes == 11)
           $cmes =  'Noviembre';
           elseif ($nmes == 12)
           $cmes =  'Diciembre';
           
           
           return $dia1.' dia(s) del mes de '.$cmes.' del '.$anio1;
           
   }  
   //-------------------------
   
   function _fecha_texto($fecha){
       
       $trozos = explode("-", $fecha,3);
       
       $anio1 = $trozos[0];
       $nmes =  $trozos[1];
       $dia1 =  $trozos[2];
       
       if ($nmes == 1)
           $cmes =  'Enero';
           elseif ($nmes == 2)
           $cmes =  'Febrero';
           elseif ($nmes == 3)
           $cmes =  'Marzo';
           elseif ($nmes == 4)
           $cmes =  'Abril';
           elseif ($nmes == 5)
           $cmes =  'Mayo';
           elseif ($nmes == 6)
           $cmes =  'Junio';
           elseif ($nmes == 7)
           $cmes =  'Julio';
           elseif ($nmes == 8)
           $cmes =  'Agosto';
           elseif ($nmes == 9)
           $cmes =  'Septiembre';
           elseif ($nmes == 10)
           $cmes =  'Octubre';
           elseif ($nmes == 11)
           $cmes =  'Noviembre';
           elseif ($nmes == 12)
           $cmes =  'Diciembre';
           
           
           return $cmes.' '.$dia1. ','.$anio1;
           
   }  
   //-----------------------------
   function _mesc($nmes){
       
       if ($nmes == '01')
           return  'Enero';
           elseif ($nmes == '02')
           return  'Febrero';
           elseif ($nmes == '03')
           return  'Marzo';
           elseif ($nmes == '04')
           return  'Abril';
           elseif ($nmes == '05')
           return  'Mayo';
           elseif ($nmes == '06')
           return  'Junio';
           elseif ($nmes == '07')
           return  'Julio';
           elseif ($nmes == '08')
           return  'Agosto';
           elseif ($nmes == '09')
           return  'Septiembre';
           elseif ($nmes == '10')
           return  'Octubre';
           elseif ($nmes == '11')
           return  'Noviembre';
           elseif ($nmes == '12')
           return  'Diciembre';
           
   }  
   //----------------------------- _diac, _mesc
   function _diac($nmes){
       
       if ($nmes == '01')
           return  'Lunes';
           elseif ($nmes == '02')
           return  'Martes';
           elseif ($nmes == '03')
           return  'Miercoles';
           elseif ($nmes == '04')
           return  'Jueves';
           elseif ($nmes == '05')
           return  'Viernes';
           elseif ($nmes == '06')
           return  'Sabado';
           elseif ($nmes == '07')
           return  'Domingo';
          
           
   } 
   //------------------
   //----------------------------- _diac, _mesc
   function _tipo_identificacion($tipo,$identificacion){
       
       $longitud = strlen(trim($identificacion));
       
       if ($tipo == 'C'){
           if($longitud == 10){
               return '02';
           }
           if($longitud == 13){
               return '01';
           }
           return '03';
       }
           
       if ($tipo == 'V'){
           if($longitud == 10){
               return '05';
           }
           if($longitud == 13){
               return '04';
           }
           return '07';
       }
           
   } 
   /*------------------------------------------------------*/
   public function  _datec($fecha,$tipo){
       
       $cadena =     str_replace('years','anios',$fecha);
    
       $cadena1 =     str_replace('mons','mes',$cadena);
       
       $cadena10 =     str_replace('mon','mes',$cadena1);
       
       $cadena21 =     str_replace('days','dia',$cadena10);
        
       $cadena2 =     str_replace('day','dia',$cadena21);
       
       $fecha_reporte = $cadena2;
     
       if($tipo == 'Y'){
           
           // $years = $afecha[0];
          //  $fecha_reporte = $years.' Anios';
           
       }
   
       if($tipo == 'M'){
       
           $arrayM = explode('anios',trim($cadena2) );
           
           $years  = $arrayM[0];
           $mes  = $arrayM[1];
        
           $posa = strpos($cadena2, 'anios');
           
           
           $anio = $years.' Anios ';
           
           $posm = strpos($mes, 'mes');
           $posd = strpos($mes, 'dia');
           
           $nohaymes = 0;
           $cadenames = '';
           
           if (!empty($posm)){
               $arrayMes  = explode('mes',trim($mes) );
               $meses     = $arrayMes[0];
               $cadenames = $meses.' Mes(es)';
           }else {
               $nohaymes = 1;
           }
               
           $cadenadia = '';
           if (!empty($posd)){
               $arrayDia  = explode('dia',trim($arrayMes[1]) );
               $dia     = $arrayDia[0];
               $cadenadia = ' '.$dia.' Dia(s)';
               
               if ($nohaymes== 1){
                   $arrayDia  = explode('dia',trim($mes) );
                   $dia     = $arrayDia[0];
                   $cadenadia = ' '.$dia.' Dia(s)';
               }
               
           }else {
               $arrayDia  = explode('dia',trim($cadena2) );
               $dia     = $arrayDia[0];
               $cadenadia = ' '.$dia.' Dia(s)';
           }
               
           if (empty($posa)){
               $anio = '';
           }
       
       
           $fecha_reporte  = $anio.$cadenames.$cadenadia;
           
       }    
       
       if($tipo == 'D'){
           
           $arrayM = explode('anios',trim($cadena2) );
           
           $years  = $arrayM[0];
           $mes  = $arrayM[1];
           
           $posa = strpos($cadena2, 'anios');
           
           
           $anio = $years.' Anios ';
           
           $posm = strpos($mes, 'mes');
           $posd = strpos($mes, 'dia');
           
           $nohaymes = 0;
           $cadenames = '';
           
           if (!empty($posm)){
               $arrayMes  = explode('mes',trim($mes) );
               $meses     = $arrayMes[0];
               $cadenames = $meses.' Mes(es)';
           }else {
               $nohaymes = 1;
           }
           
           $cadenadia = '';
           if (!empty($posd)){
               $arrayDia  = explode('dia',trim($arrayMes[1]) );
               $dia     = $arrayDia[0];
               $cadenadia = ' '.$dia.' Dia(s)';
               
               if ($nohaymes== 1){
                   $arrayDia  = explode('dia',trim($mes) );
                   $dia     = $arrayDia[0];
                   $cadenadia = ' '.$dia.' Dia(s)';
               }
               
           }else {
               $arrayDia  = explode('dia',trim($cadena2) );
               $dia     = $arrayDia[0];
               $cadenadia = ' '.$dia.' Dia(s)';
           }
           
           if (empty($posa)){
               $anio = '';
           }
           
           
           $fecha_reporte  = $anio.$cadenames;
           
       }    
       
       
       return $fecha_reporte;
   
   } 
   
   /*------------------------------------------------------*/
   public function  _file_random($extension){
       
       $arrayextension = explode('.',$extension );
       
       $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
       $numerodeletras=12; //numero de letras para generar el texto
       $cadena = ""; //variable para almacenar la cadena generada
       for($i=0;$i<$numerodeletras;$i++)
       {
           $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres
           entre el rango 0 a Numero de letras que tiene la cadena */
       }
       return $cadena.'.'.$arrayextension[1];
       
   } 
	//---
	public function  _docIndex($extension,$anio){
       
       $arrayextension = explode('.',$extension );
       
       $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
       $numerodeletras=12; //numero de letras para generar el texto
       $cadena = ""; //variable para almacenar la cadena generada
       for($i=0;$i<$numerodeletras;$i++)
       {
           $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres
           entre el rango 0 a Numero de letras que tiene la cadena */
       }
       return $anio.'-'.$cadena.'.'.$arrayextension[1];
       
   } 
   //------------------------------------------------------------------------
   public function __betweenq($campo){
       
       if ($campo == '-'){
           $this->where_query = '-';
       }else{
           
           $this->where_query = "  AND ( ".$campo. " ) ";
           
       }
        
       return 1;
   }
   //---------------------
   public function __ciu($idprov){
       
       $AResultado = $this->query_array('par_ciu',
                                        'razon', 
                                        'idprov='.$this->sqlvalue_inyeccion(trim($idprov),true)
           );
       
       
       return trim($AResultado['razon']);
       
   }
   //---------------------------
   public function __tramite($caso){
       
       $AResultado = $this->query_array('flow.view_proceso_caso',
           '*',
           'idcaso='.$this->sqlvalue_inyeccion($caso,true)
           );
       
       return $AResultado;
       
   }
   public function catalogo_unidad($id_departamento){

    $x = $this->query_array('nom_departamento',
    'nombre,referencia,siglas,oficio,memo,notifica,informe,circular,orden',
    'id_departamento='.$this->sqlvalue_inyeccion($id_departamento,true)
    );

    return $x;

    }
   //-------------------------
   public function __user($sesion){
       
       $AResultado = $this->query_array('par_usuario',
           '*',
           'login='.$this->sqlvalue_inyeccion(trim($sesion),true)
           );
 
       
       $x = $this->query_array('nom_departamento',
           'nombre,referencia,siglas,oficio,memo,notifica,informe,circular,orden',
           'id_departamento='.$this->sqlvalue_inyeccion($AResultado['id_departamento'],true)
           );
       
       $y = $this->query_array('view_nomina_rol',
           'cargo,   genero, foto,    edad, anio_nacio,razon, lower(cargo) as cargo_min, lower(razon) as completo_min',
           'idprov='.$this->sqlvalue_inyeccion($AResultado['cedula'],true)
           );
       
       
       $AResultado['cargo'] = trim($y['cargo']);

       $AResultado['completo_min'] = ucwords(trim($y['completo_min']));
       $AResultado['cargo_min']    = ucwords(trim($y['cargo_min']));

       $AResultado['genero'] = trim($y['genero']);
       $AResultado['foto']     = trim($y['foto']);

       $AResultado['orden']     = trim($x['orden']);
       
           
       $completo_siglas =  trim($y['razon']);
       
       $parametro = explode(' ',$completo_siglas);
       
       $numero = count($parametro);
       
       if ( $numero == 4){
           $uno = substr(trim($parametro[0]),0,1);
           $dos = substr(trim($parametro[2]),0,1);
           $AResultado['sigla_nombre'] = $uno.$dos;
       }
       if ( $numero == 3){
           $uno = substr(trim($parametro[0]),0,1);
           $dos = substr(trim($parametro[1]),0,1);
           $AResultado['sigla_nombre'] = $uno.$dos;
       }
       
     
       
       
       $AResultado['unidad'] = trim($x['nombre']);
       $AResultado['referencia'] = trim($x['referencia']);
       $AResultado['siglas']     = trim($x['siglas']);
       
       $AResultado['oficio']      = $x['oficio'];
       $AResultado['memo']        = $x['memo'];
       $AResultado['notifica']    = $x['notifica'];
       $AResultado['informe']     = $x['informe'];
       $AResultado['circular']    = $x['circular'];
        
       
           return $AResultado;
       
   }
   
   //----------------
   public function __user_tthh($sesion){
       
       $AResultado = $this->query_array('view_nomina_rol',
           '*',
           'correo='.$this->sqlvalue_inyeccion(trim($sesion),true)
           );
       
       
       $x = $this->query_array('nom_departamento',
           'nombre,referencia,siglas,oficio,memo,notifica,informe,circular',
           'id_departamento='.$this->sqlvalue_inyeccion($AResultado['id_departamento'],true)
           );
       
       
       $AResultado['unidad'] = trim($x['nombre']);
       $AResultado['referencia'] = trim($x['referencia']);
       $AResultado['siglas']     = trim($x['siglas']);
       
       $AResultado['oficio']      = $x['oficio'];
       $AResultado['memo']        = $x['memo'];
       $AResultado['notifica']    = $x['notifica'];
       $AResultado['informe']     = $x['informe'];
       $AResultado['circular']    = $x['circular'];
       
       
       return $AResultado;
       
   }
   
   //-------------------
   //------------------------------------------------------------------------
   public function __limit($limit, $offset){
       
       $this->limit = ' limit '.$limit.' offset '.$offset.' ';
   
      
   }
   //-------------------   
   public function _limpiar_datos($mensaje='ACTUALIZACION'){
       
       echo '<script type="text/javascript">';
       
       echo  'LimpiarPantalla();';
       
       echo '</script>';
       
   }
   //-----------------------
   public function _resultado_CRUD($mensaje='ACTUALIZACION',$accion,$id,$tipo){
       
       
       
       $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
       
       
       if ($mensaje == 'ACTUALIZACION'){
           
           if ($tipo == 0){
               
               if ($accion == 'editar'){
                   $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
               }
               if ($accion == 'del'){
                   $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
               }
           }
           
           if ($tipo == 1){
               
               $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
               echo '<script type="text/javascript">accion('.$id.',"'.$accion.'" );</script>';
           }
           
       }
       
       //----------------------------------------
       if ($mensaje == 'ELIMINADO'){
           echo '<script type="text/javascript">LimpiarPantalla();</script>';
           $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
       }
       
       return $resultado;
       
   }
   /**
    Funcion para creacion del formulario de filtro de busquedas dinamicas
    @return
    **/
   public function resultadoCRUD($mensaje='ACTUALIZACION',$accion,$id,$tipo,$estado='X'){
       
       $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b> ';
       
       $accion_e  = "'".$accion."'";
       $estado_e  = "'".$estado."'";
       
       
        
       if ( trim($estado) == 'X'){
           $script =  '<script type="text/javascript">accion('.$id.','.$accion_e.' );</script>';
       }else{
           $script =  '<script type="text/javascript">accion('.$id.','.$accion_e.','.$estado_e.' );</script>';
       }
        
       if (trim($mensaje) == 'ACTUALIZACION'){
           
           if ($tipo == 0){
                if ($accion == 'editar'){
                    $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b> ';
                    echo $script;
               }
                if ($accion == 'del'){
                    $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b> ';
                    echo $script;
               }
            }
            if ($tipo == 1){
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.'] </b>';
                 echo $script;
           }
        }
        
       //----------------------------------------
       if ($mensaje == 'ELIMINADO'){
            echo '<script type="text/javascript">LimpiarPantalla();</script>';
            $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.'] </b>';
       }
 
       return $resultado;
        
   }
   
   public function resultadoCRUD_($mensaje,$accion,$id,$tipo,$grilla){
       
       
       
       $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
       
       
       if ($mensaje == 'ACTUALIZACION'){
           
           if ($tipo == 0){
               if ($accion == 'editar'){
                   $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'",'.$grilla.' );</script>';
               }
               if ($accion == 'del'){
                   $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                   echo '<script type="text/javascript">accion('.$id.',"'.$accion.'",'.$grilla.' );</script>';
               }
           }
           if ($tipo == 1){
               
               $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
               echo '<script type="text/javascript">accion('.$id.',"'.$accion.'",'.$grilla.' );</script>';
           }
       }
       
       //----------------------------------------
       if ($mensaje == 'ELIMINADO'){
           echo '<script type="text/javascript">LimpiarPantalla();</script>';
           $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
       }
       
       return $resultado;
       
   }
   function actual_date ()
   {
       $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
       $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
       $year_now = date ("Y");
       $month_now = date ("n");
       $day_now = date ("j");
       $week_day_now = date ("w");
       $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;
       return $date;
   }  
    
    /*Realiza la conexiÃƒÂ³n a la base de datos.*/
   public function conectar($user,$base,$acceso){
	      
       date_default_timezone_set('UTC');
       date_default_timezone_set('America/Lima');
       setlocale(LC_TIME, 'es_ES.UTF-8');
       setlocale (LC_TIME,"spanish");
       
	   
       
       $this->orderby ='';
       
   	 if (!empty($user)) {
		  $this->usuario = $this->_refd($user);
 	  }
	  if (!empty($base)) {
		  $this->base_datos = $this->_refd($base);
 	  }
	  if (!empty($acceso)) {
		  $this->password = $this->_refd($acceso);
 	  }
 
	 if (isset($_SESSION['ip']))	{
 
		$this->servidor = $this->_refd($_SESSION['ip']);
        
    }
    // $this->servidor = '192.168.1.3';
    $this->servidor = '127.0.0.1';
    $this->base_datos = 'db_kaipi';
    // $this->base_datos = 'db_kaipi';
    $this->usuario = 'postgres';
    // $this->password = 'Cbsd2019';
    $this->password = 'root';

    // echo $this->servidor;
    // echo $this->base_datos;
    // echo $this->usuario;
    // echo $this->password;
    
 		$this->link= pg_connect("host=".$this->servidor."   dbname=".$this->base_datos."  port=5432    user=".$this->usuario."  password=".$this->password);
 
 		
       $_SESSION['directorio_crm'] = '../kimages/';


 		//----- periodo presupuestario
 		$anio = date('Y');
 		
 		$x = $this->query_array('presupuesto.pre_periodo',
 		    'estado',
 		    'anio='.$this->sqlvalue_inyeccion($anio,true).' and
            registro='.$this->sqlvalue_inyeccion($_SESSION['ruc_registro'],true)
 		    );
 		
 		$_SESSION['periodo_presupuesto'] =$x['estado']  ;
 		
   }
 //--------------------  
   public function _us(){
       
       $user = '11'.trim($this->usuario );
       
       return base64_encode($user);
       
 
   }
   //--------------------
   public function _ac(){
       
       $password = '12'.trim($this->password);
       
        return base64_encode($password);
        
   }
   //--------------------
   public function _db(){
       
       $db ='13'.trim($this->base_datos);
       
       return base64_encode($db);
       
   }
  
 //---------------------
 public function _server($ip){
	   
   	
   	 if (!empty($ip)) {
		  $this->servidor = $this->_refd($ip);
		 
 	  }
 
     
   }
   //-------------------
   public function conectar_sesion_catastro( ){
       
       
       
       
    $this->servidor    =  'catastro.ddns.net';
    $this->base_datos  =  'sigcat';
    $this->usuario     =  'kgestiona';
    $this->password    =  'kgestiona';
    
    
    
    $this->link = pg_connect("host=".$this->servidor." port=5431 dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password)
    or die("Error en la Conexion: ".pg_last_error());
    
    
    
    if(!$this->link )
    {
        die("No ha sido posible establecer la conexion con la base de datos.");
        return 0;
    }else {
        return 1;
    }
    
    
}
//----------------------------------
public function conectar_sesion_externo($servidor, $base_datos, $usuario, $password){
       
       
       
       
    $this->servidor    =  $servidor;
    $this->base_datos  =   $base_datos;
    $this->usuario     =  $usuario;
    $this->password    =  $password;
    
    
    
    $this->link = pg_connect("host=".$this->servidor." port=5432 dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password)
    or die("Error en la Conexion: ".pg_last_error());
    
    
    
    if(!$this->link )
    {
        die("No ha sido posible establecer la conexion con la base de datos.");
        return 0;
    }else {
        return 1;
    }
    
    
}
   //--------------
   public function conectar_sesion_servicios( ){
       
       
       
 	   $this->servidor    =  '127.0.0.1';
       $this->base_datos  =  'bomberos_val';
       $this->usuario     =  'dbkaipi';
       $this->password    =  'Kaipi.2021$2022';
       
       
       
       $this->link = pg_connect("host=".$this->servidor." dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password)
       or die("Error en la Conexion: ".pg_last_error());
       
       
       
       if(!$this->link )
       {
           die("No ha sido posible establecer la conexion con la base de datos.");
           return 0;
       }else {
           return 1;
       }
       
       
   }
   //------------------
   public function conectar_sesion_ventas( ){
       
       
 
       
       $this->servidor    =  '127.0.0.1';
       $this->base_datos  =  'pillaro';
       $this->usuario     =  'postgres';
       $this->password    =  'joseandres';
       
       
       
       $this->link = pg_connect("host=".$this->servidor." dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password)
       or die("Error en la Conexion: ".pg_last_error());
       
       
       
       if(!$this->link )
       {
           die("No ha sido posible establecer la conexion con la base de datos.");
           return 0;
       }else {
           return 1;
       }
       
       
   }
   //------------------
   public function conectar_sesion( ){
       
       
     //  $this->servidor    =  '186.4.189.205';
     
       $this->servidor    =  'factura100.com';
       $this->base_datos  =  'ct_facturacion_electronica';
       $this->usuario     =  'postgres';
       $this->password    =  'd3s4rr0ll0123,.';
       
      
    
     $this->link = pg_connect("host=".$this->servidor." dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password)
     or die("Error en la Conexion: ".pg_last_error());
      
      
     
     if(!$this->link )
     {
         die("No ha sido posible establecer la conexion con la base de datos.");
        return 0;
     }else {
         return 1;
     }
         
      
   }
   public function conectar_prueba( ){
       
 
       
        $this->servidor    =  '181.112.225.37';
       $this->base_datos  =  'patate';
       $this->usuario     =  'postgres';
       $this->password    =  'patata';
       
       
       $this->link = pg_connect("host=".$this->servidor." dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password);
       
       if(!$this->link )
       {
           return 0;
       }else {
           return 1;
       }
       
   }
   //-------------------------
   public function conectar_Mysql( ){
       
 
       
       $this->servidor    =  '192.168.24.11';
       $this->base_datos  =  'anetran_emapa';
       $this->usuario     =  'EPMAPA';
       $this->password    =  'EPMAPA2014';
    
       $this->link = mysqli_connect($this->servidor, $this->usuario ,'',$this->base_datos);
       
       if(!$this->link)
       {
           echo "Failed to connect to MySQL: " . mysqli_connect_error();
       }
       else
       {
           echo "ok";
       }
       
     /*  
       
       $this->link = mysql_connect($this->servidor, $this->usuario, $this->password);
       
       mysql_select_db($this->base_datos,$this->link);
       
       @mysql_query("SET NAMES 'utf8'"); 
        
       */
     
       
   }
   
   //--------------
   public function conectar_sesionWS( ){
       
      
       $this->servidor    =  '167.99.0.234';
       $this->base_datos  =  'ct_cliente';  
       $this->usuario     =  'dbkaipi';  
       $this->password    =  'Kaipi.2021$2022'; 
       
       
       
       
       $this->link = pg_connect("host=".$this->servidor." dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password);
       
 
   }
   
  
  public function close_transaccion(){
 	
    oci_close($this->link);
 
    return true;
 } 


//-------------------------------------------------------------------------
// pide secuencia para inserta informacion 
//-------------------------------------------------------------------------
 
 
 public function pideSq($sq){
 	
 	$this->pideSecuencia =$sq;
 	
 	return true;
 } 
 

 
   
       /*Realiza la conexiÃƒÂ³n a la base de datos.*/
  public function conectar_oracle($usuario,$password){
 	
    oci_close($this->link);
     
	$dbstr1 ="(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST =".$this->servidor.")(PORT = 1521)) 
		(CONNECT_DATA = 
		(SERVER = DEDICATED) 
		(SERVICE_NAME = ".$this->base_datos.") 
		))"; 
 
	   $this->usuario  = $usuario;
	   $this->password = $password;
	   
 	   $this->link = oci_connect($this->usuario,$this->password,$dbstr1,'AL32UTF8');
	   
	   if (!$this->link) {
   			return 0;
   	   }
		return $this->link;    
    } 
    public function conectar_link($link){
 	
         $this->link = $link ;
     
		return true ;    
    }   
    /*-------------------*/
    public function transaccion(){
          return $this->link; 
    }  
    /*Realiza la conexiÃƒÂ³n a la base de datos.*/
   public function conectar_db($base_datos,$acceso){
 	// editar xml
 	$this->base_datos = $this->_refd($base_datos);
	$this->password = $this->_refd($acceso);
	
   
	$dbstr1 ="(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST =".$this->servidor.")(PORT = 1521)) 
		(CONNECT_DATA = 
		(SERVER = DEDICATED) 
		(SERVICE_NAME = ".$this->base_datos.") 
		))"; 
		
	switch ($this->tipo){
	  case 'mysql':     
	  					$this->link = mysql_connect($this->servidor, $this->usuario, $this->password);
	                    mysql_select_db($this->base_datos,$this->link);
	                    @mysql_query("SET NAMES 'utf8'"); 
						break;
	  case 'postgress': 
	  					$this->link=pg_connect("host=".$this->servidor." dbname=".$this->base_datos." user=".$this->usuario." password=".$this->password);
		                break;
	  case 'oracle':    
	  					$this->link = oci_connect($this->usuario,$this->password,$dbstr1);
		                break;
	  break;
     }
   }	
   
   //Evitar el SQL Injection con un simple truco
   
   function clean_dato($val){
		  return mysql_real_escape_string($val);
		}
//------------------
 function _tipo_cliente($idprov){
 	    
 	    $ncontador = strlen(trim($idprov));  
 	    
		$tipoidentificacioncomprador = '06';
		
		if ($ncontador == 10){
		    $tipoidentificacioncomprador = '05';
		}
		
		if ($ncontador == 13){
		    $tipoidentificacioncomprador = '04';
		}
		
		if ($idprov == '9999999999999'){
		    
		    $tipoidentificacioncomprador = '07';
		}
		
		if ($idprov== '9999999999'){
		    
		    $tipoidentificacioncomprador = '07';
		    $idprov = '9999999999999';
		}
		
		return $tipoidentificacioncomprador;
 	}
		
//-----------------------------------------		
  function _especial($val){
            $direccion =  str_replace ( ',' , ' ', $val);
		    $direccion =  str_replace ( ';' , ' ',  $direccion);
		    $direccion =  str_replace ( 'Ã±' , ' ',  $direccion);
		    $direccion =  str_replace ( 'Ã‘' , ' ',  $direccion);
		    $direccion =  str_replace ( ':' , ' ',  $direccion);
		    
		    return $direccion;
		}
   
   // verifica si existe variables para acceso de informacion completa el tiÃ‚Â´po
 		function sqlstr_inyeccion($val){
		  return str_replace("'", "''", $val);
		}
		/*    verifica si existe variables para acceso de informacion 
		---------------------------------------------------------------------*/
		function sqlvalue_inyeccion($val, $quote){

		  if ($quote)
			$tmp = $this->sqlstr_inyeccion(trim($val));
		  else
			$tmp = $val;
		  if ($tmp == "")
			$tmp = "NULL";
		  elseif ($quote)
			$tmp = "'".$tmp."'";
		  return $tmp;
		}	
		
		
//------------------------		
 	public function query_sql($tabla,$campo,$condicion='',$orden='',$union=''){
  	    
 	    $elementos    = explode(',',$campo);
 	    
 	    $campo1       = $elementos[0].' as codigo';
 	    $campo2       = $elementos[1].' as nombre';
 	    
 	    $ruc         =  $_SESSION['ruc_registro'];
 	    $sesion 	 =  trim($_SESSION['email']);
 	    
 	    
 	    if ( $condicion ==''){
 	        $condicion_query = '';
 	    }else{
 	        
 	        $condicion_query = ' where '.$condicion;
 	        
 	        if ( $condicion == '1=1'){
 	            $condicion_query = ' where '."registro =". $this->sqlvalue_inyeccion($ruc,true)." and
 	                                          sesion=". $this->sqlvalue_inyeccion($sesion,true);
 	        } 
 	        
 	        if ( $condicion == '0=0'){
 	            $condicion_query = ' where '."registro =". $this->sqlvalue_inyeccion($ruc,true) ;
 	        } 
 	        
 	    }
 	    
 	    if ( $orden ==''){
 	        $orden_query =  $orden;
 	    }else {
 	        $orden_query =  'order by '. $orden;
 	    }
 	    
 	    
 	    if ( $union == ''){
 	        $union_dato = '';
 	    }else{
 	        if ( $union == 'N'){
 	            $union_dato = "select 0 as codigo, ' - 0. Seleccione Informacion -' as nombre  union ";
 	        }else {
 	            $union_dato = "select '-' as codigo, ' - 0. Seleccione Informacion -' as nombre  from   union ";
 	        }
 	       
 	    }
 	   
 	    
 	    $sql = $union_dato.'select '.$campo1.','.$campo2. ' from '.$tabla.' '.$condicion_query.' '.$orden_query;
 	    
 	   
 	   
 	    
 	    /*
 	  
 	       $resultado = $this->bd->query_sql('view_bodega_permiso',
                                                          'idbodega,nombre',
                                                          '1=1',
                                                          '2 asc');
                                                          
           
 	    */
 	    $this->stmt = pg_query($this->link, $sql);
 	    
 	    
 	    if (!$this->stmt ) {
 	        
 	        $error = error_get_last();
 	        
 	        echo "Connection failed. Error was: ". $error['message']. "\n";
  	        
 	        
 	    }
 
 	    
 	    return $this->stmt;
 }
/**
  Funcion para ejecutar la busqueda de lista de los catalogos generales del sistema
  tabla: par_catalogo
  entrada: tipo de catalogo a buscar (caracter)
  filtro: tipo (nombre del tipo de catalogo a buscar)
  @return   ( resultado de la consulta)
  **/
  public function ejecutar_unidad(){
 
       $ruc       =  trim($_SESSION['ruc_registro']);

        $sql =  "select 0 as codigo, ' --  00. Seleccione dato  -- ' as nombre  union
                 select id_departamento as codigo, nombre
                   from nom_departamento
                   where  estado=". $this->sqlvalue_inyeccion('S',true). " and 
                           ruc_registro=". $this->sqlvalue_inyeccion($ruc,true). "
                   order by 2";
     
      $this->stmt = pg_query($this->link, $sql);
  
     
     return $this->stmt;
 }
 /**
  Funcion para ejecutar la busqueda de lista de los catalogos generales del sistema
  tabla: par_catalogo
  entrada: tipo de catalogo a buscar (caracter)
  filtro: tipo (nombre del tipo de catalogo a buscar)
  @return   ( resultado de la consulta)
  **/
 public function catalogo_compras(){
 
 
     $sql =  "select '-' as codigo, ' --  00. Seleccione tipo compras  -- ' as nombre  union
              select nombre as codigo, nombre
                from  adm.adm_pac_tipo
                where  estado=". $this->sqlvalue_inyeccion('S',true). " 
                order by 2";

   
   $this->stmt = pg_query($this->link, $sql);

  
  return $this->stmt;
}

 /**
  Funcion para ejecutar la busqueda de lista de los catalogos generales del sistema
  tabla: par_catalogo
  entrada: tipo de catalogo a buscar (caracter)
  filtro: tipo (nombre del tipo de catalogo a buscar)
  @return   ( resultado de la consulta)
  **/
 public function ejecutar_catalogo($tipo,$variable='codigo'){
     
     
    if ( $variable == 'codigo'){
     $sql =  "select 0 as codigo, ' --  00. Seleccione dato  -- ' as nombre   union
              select idcatalogo as codigo, nombre
                from par_catalogo
               where tipo =" .$this->sqlvalue_inyeccion($tipo  ,true) ." and  publica = 'S' 
               order by 2";
            }else{
                $sql =  "select '-' as codigo, ' --  00. Seleccione dato  -- ' as nombre   union
                         select nombre as codigo, nombre
                           from par_catalogo
                          where tipo =" .$this->sqlvalue_inyeccion($tipo  ,true) ." and  publica = 'S' 
                          order by 2";
                       }
     
     $this->stmt = pg_query($this->link, $sql);
     
     
     if (!$this->stmt ) {
         
         $error = error_get_last();
         
         echo "Connection failed. Error was: ". $error['message']. "\n";
         
         
         
     }
     
     
     return $this->stmt;
 }
 /*
 */
 public function ejecutar_usuario($tipo='N'){
     
      

    if ( $tipo == 'S'){

               $sql =  "select '-' as codigo, ' --  00. Seleccione Responsable  -- ' as nombre   union
                        SELECT email AS codigo, completo  as nombre
                        FROM par_usuario
                        where estado = ".$this->sqlvalue_inyeccion('S',true)." AND
                                responsable = ".$this->sqlvalue_inyeccion('S',true)." 
                                ORDER BY 2";
        }else{

                $sql =  "select '-' as codigo, ' --  00. Seleccione Usuario  -- ' as nombre   union
                            SELECT email AS codigo, completo  as nombre
                            FROM par_usuario
                            where estado = ".$this->sqlvalue_inyeccion('S',true)." 
                              ORDER BY 2";
        }
     
     $this->stmt = pg_query($this->link, $sql);
     
     
     if (!$this->stmt ) {
         
         $error = error_get_last();
         
         echo "Connection failed. Error was: ". $error['message']. "\n";
         
         
         
     }
     
     
     return $this->stmt;
 }
 /**
  Funcion para ejecutar sentecia SQL
  tabla: todas
  filtro: todas
  @return (resultado de la consulta )
  **/
   public function ejecutar($sql){
         
    
       $this->stmt = pg_query($this->link, $sql);
       
       
       if (!$this->stmt ) {
           
           $error = error_get_last();
           
           echo "Connection failed. Error was: ". $error['message']. "\n";
           
   
           
       }
        
 	  
      return $this->stmt;
   }
   //------------------
   public function ejecutarLista($campo,$tabla,$where,$order){
       
       $campo_final = explode(',',$campo) ;
       
       $campo1 = $campo_final[0].' as codigo, ';

       $campo2 = $campo_final[1].' as nombre' ;
       
       
       if ( $where == '-'){
           $sql = 'select '.$campo1.$campo2. ' from '.$tabla.' '.$order;
       }else{
           $sql = 'select '.$campo1.$campo2. ' from '.$tabla.' where '.$where.' '.$order;
       }
       
    
       
       /*
       $resultado = $this->bd->ejecutarLista("codigo,detalle",
           "presupuesto.pre_catalogo",
           "estado = 'S' and  categoria = ".$this->bd->sqlvalue_inyeccion('programa'  ,true),
           "order by 2"); */
       
       $this->stmt = pg_query($this->link, $sql);
       
       
       if (!$this->stmt ) {
           
           $error = error_get_last();
           
           echo "Connection failed. Error was: ". $error['message']. "\n";
           
            
       }
       
 
       
       return $this->stmt;
   }
    /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function NroRegistros(){
    
    $numero = 0;
    
       switch ($this->tipo){
		
	     case 'mysql':     
			 			   $numero = mysql_num_rows ($this->stmt );
		 				   break;
 		 case 'postgress': {
 		     
  						   $numero = pg_num_rows($this->stmt);
						    
						   break;
 						  
 	     }
		 case 'oracle':    {
                           $numero = oci_num_rows ($this->stmt  );
 
                           break;
                         }
      					   
		 break;
		 
		 }
 	  
      return '<br><p>Nro.Registros '.$numero.'</p>';
   }
   
   ////
   public function ReferenciaTabla($Tabla,$identificador,$id){
   
   	
   	$sql = 'Select count(*) as nn from '.$Tabla.' where '.$identificador.' = '.$this->sqlvalue_inyeccion($id, true);
   	
 
   	
   	$numero = 0;
   	
   	switch ($this->tipo){
   
   		case 'mysql':
   			$stmt = mysql_query($sql,$this->link);
   			$this->array=mysql_fetch_array($stmt);
   			break;
   		case 'postgress': {
   			
   			$stmt = pg_query($this->link, $sql);
   			$this->array = pg_fetch_row($stmt);
    			
   			break;
   				
   		}
   		case 'oracle':    {
   			$stmt = oci_parse($this->link, $sql  );
    		oci_execute($stmt);
    		$this->array = oci_fetch_row($stmt);
    				
   			break;
   		}
   
   		break;
   			
   	}
   	
   	$numero = $this->array[0];
   
   	return $numero   ;
   }
   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function ejecutarSQL($sql){
    
       switch ($this->tipo){
		
	     case 'mysql':     
			 			   $this->stmt = mysql_query($sql,$this->link);
		 				   break;
 		 case 'postgress': {
  						   $this->stmt = pg_query($this->link, $sql);
						    
						   break;
 						  
 	     }
		 case 'oracle':    {
                           $stmt = oci_parse($this->link, $sql  );
                           
						   oci_execute($stmt); 
                          
						 
                           break;
                         }
      					   
		 break;
		 
		 }
 	  
      return true;
   }  
     /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function prepara_plsql($sql){
    	
	   $this->stmt = oci_parse($this->link, $sql  );
						   
      return $this->stmt;
   } 
     /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function ejecutar_plsql($stmt){
    	
	    oci_execute($stmt); 
						   
      return 1;
   }    
     /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function variables_plsql($stmt, $var,$p1){
    	
      // Bind the output parameter
  
	   oci_bind_by_name($stmt , '"'.$var.'"', $p1);
						   
      return 1;
   }   
   

 

   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function ejecutar_stmt($sql){
      switch ($this->tipo){
	     case 'mysql':    return mysql_query($sql,$this->link);
						   break;
 		 case 'postgress': return pg_query($this->link, $sql);
 						   break;
	     case 'oracle':    $stmt = oci_parse($this->link, $sql  );
						   oci_execute($stmt); 
						   return $stmt;
						   break;
		 break;
	  }
    }   
   /*MÃƒÂ©todo para ejecutar commit una sentencia sql*/
   public function commit($stmt){
      switch ($this->tipo){
	     case 'mysql':     return true;
						   break;
 		 case 'postgress': return true;
 						   break;
	     case 'oracle':    //oci_commit($stmt); 
		 				   return true;	
						   break;
		 break;
	  }

   }
   /**
    Funcion para obtener una array 
    @return
    **/
   public function obtener_fila($stmt){
       
      switch ($this->tipo){
	     case 'mysql':    $this->array=mysqli_fetch_assoc($stmt);
	                      break;
		 case 'postgress':  
						   $this->array = pg_fetch_assoc($stmt);
					       break;
		 case 'oracle':  {
						   $this->array = oci_fetch_assoc($stmt);
                             
					       break;
                         }  
		break;
	  }
      return $this->array;
   }
   /**
    Funcion para obtener una array
    @return
    **/
   public function Arrayfila($stmt){
   	
   	switch ($this->tipo){
   		case 'mysql':    
   					$this->array=mysql_fetch_array($stmt);
   					break;
   		case 'postgress':
   					$this->array = pg_fetch_row($stmt);
   					break;
   		case 'oracle':  {
   					$this->array = oci_fetch_row($stmt);
   			 
   			break;
   		}
   		break;
   	}
   	return $this->array;
   }
   
   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function JqueryUpdateSQL($tabla,$array,$confi=0){
    
	
       
   $sql = $this->contruye_sqlEdit($tabla,$array);
 
   if ( $confi == 1){
       echo $sql;
   }
  
   
    $this->error = $sql;
 
	
       switch ($this->tipo){
		
	     case 'mysql':     
			 			   mysql_query($sql,$this->link);
		 				   break;
 		 case 'postgress': {
  						   pg_query($this->link, $sql);
						    
						   break;
 						  
 	     }
		 case 'oracle':    {
                           $stmt = oci_parse($this->link, $sql  );
                           
						   oci_execute($stmt); 
                          
                           oci_free_statement($stmt);
                             
					       break;
                         }
      					   
		 break;
		 
		 }
 
      return true;
   }  
     /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function DbError()
    {
        return $this->error;
        
    }
  
    /*MÃƒÂ©todo para ejecutar una sentencia sql*/
    
   public function JqueryInsertSQL($tabla,$array,$indice=''){
    
 
   	
              $sql = $this->contruye_sqlInsert($tabla,$array);
           

              if ( $indice== '1') {
                  echo $sql.' </br> ';
              }
              
               switch ($this->tipo){
        		
        	     case 'mysql':     
        			 			   mysql_query($sql,$this->link);
        		 				   break;
        		 				   
         		 case 'postgress': {
         		 	
          						   $stmt = pg_query($this->link, $sql);
                                   
                                   $this->error = pg_result_error($stmt);
 
        						   break;
         						  
         	     }
        		 case 'oracle':    {
                                   $stmt = oci_parse($this->link, $sql  );
                                   
        						   oci_execute($stmt); 
                                  
                                   oci_free_statement($stmt);
                                     
        					       break;
                                 }
              					   
        		 break;
        		 
        		 }
        
        		 
     if ( $indice == 'N')  {
            $id = 0;
     }else{
            if ($this->pideSecuencia == 1){
            	
            	$id = $this->ultima_secuencia($tabla);
            	
            }else{
                if ( empty($indice)){
                    $id = 0;
                }else{
                    $id = $this->ultima_secuencia($indice);
                }
               
            }
     }
               return $id; 
  
          
     
   }  
  /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function JqueryDeleteSQL($tabla,$where){
    
    
        $sql = 'DELETE FROM '.$tabla.' WHERE '.$where;
    
       switch ($this->tipo){
		
	     case 'mysql':     
			 			   mysql_query($sql,$this->link);
		 				   break;
 		 case 'postgress': {
  						   pg_query($this->link, $sql);
						    
						   break;
 						  
 	     }
		 case 'oracle':    {
                           $stmt = oci_parse($this->link, $sql  );
                           
						   oci_execute($stmt); 
                          
                           oci_free_statement($stmt);
                             
					       break;
                         }
      					   
		 break;
		 
		 }
 	  
      return true;
   }       
   /**
    Funcion para desplegar la barra de herramientas guardar, nuevo, edicion y procesos en el formulario
    @return
    **/ 
   public function JqueryArrayVisor($tabla,$array,$debug=0){
	   
	   $sql = $this->contruye_sql($tabla,$array);
	   
	   if ( $debug == 1){
	       echo $sql;
	   }
 
       
      switch ($this->tipo){
		
	     case 'mysql':     {
			 			   $this->stmt = mysql_query($sql,$this->link);
                           $this->array=mysql_fetch_array($this->stmt);
                           $datos = $this->array;
		 				   break ;
                           }
 		 case 'postgress': {
  						   $this->stmt = pg_query($this->link, $sql);
                           $this->array = pg_fetch_array($this->stmt);
                           $datos = $this->array;
						   break;
 		                   }
		 case 'oracle':    {
		  
                           $this->stmt = oci_parse($this->link, $sql  );
						   
                           oci_execute($this->stmt); 
                           
                           $this->array = oci_fetch_array($this->stmt);
                           
                           oci_free_statement($this->stmt);
                          
                           $datos = $this->array;
                           
                           break;
                         }
      					   
		 break;
		 
		 }
	  
    // crear array de datos para vizualizar	 
	$this->jquery_obj_sql( $datos,$array);
	
	return  $datos ;
   
   } 
   //--------------------------------------------------------------------
   public function JqueryArrayTable($tabla,$array,$acciones,$funcion,$id,$font='12'){
       
       $accion = strlen($acciones) ;
       
       
       $sql = $this->contruye_sql_table($tabla,$array);
       
     
       $this->contruye_sql_cabecera($array,$accion,$id,$font='12');
       
       
       $stmt_ac = $this->ejecutar($sql);
  
       $longitud = count($array);
 
           
       $i = 1;
       while ($x=$this->obtener_fila($stmt_ac)){
           
           echo '<tr>';
           $cboton_edicion = '';
           $cboton_del     = '';
           $archivo_file   = '';
           
           // columnas
         
           for ($row = 0; $row <= $longitud; $row++)
           {
               
               if (  $array[$row][indice] == 'S' ){
                   
                   $variable = $array[$row][campo];
                   
                   $variable_url = $x[$variable];

                 
                   
               }
               
               if (  $array[$row][visor] == 'S' ){
                   
                   $variable = $array[$row][campo];
                   
                   if ($array[$row][campo] == 'archivo'){
                       
                       $archivo_file = $x[$variable];
                       $funcion = 'Visor';
                       $ajax = "".$funcion."("."'".$variable_url."',"."'".$archivo_file."'".")";
                       $cboton_archivo = '<td><a title="Visor busqueda del registro" class="btn btn-xs" href="'.$ajax.'">
                        <i class="glyphicon glyphicon-download-alt"></i></a></td> ';
                       
                       echo $cboton_archivo;
                       
                   }else{
                       if ($array[$row][campo] == 'idcaso'){
                           
                           $cboton_archivo= '<td><img align="absmiddle"  src="../controller/pdfa.png"/></td>';
                           
                           echo $cboton_archivo;
                           
                       }else{
                           echo '<td>'.$x[$variable].'</td>';
                       }
                    
                   }
                   
                 
                 
               }
               
              
           }
           //-------------------------------------------
          
            
           if ( $accion > 0 ){
               
               //editar,eliminar
               $tipo = explode(',', $acciones);
               
              
               
              if ($tipo[0] == 'editar' ) {
                   $ajax = ' onClick="'.$funcion."('".'editar'."','".$variable_url."')".'"';
                   $cboton_edicion = '<a title="Editar registro seleccionado" '. $ajax .' class="btn btn-xs btn-warning"  role="button" href="#">
                                     <i class="glyphicon glyphicon-edit"></i></a> ';
               }
               
               if ($tipo[1] == 'eliminar' ) {
                   $ajax = ' onClick="'.$funcion."('".'del'."','".$variable_url."')".'"';
                   $cboton_del = '<a title="Eliminar registro seleccionado" '. $ajax .' class="btn btn-xs btn-danger" role="button" href="#">
                                 <i class="glyphicon glyphicon-remove"></i></a> ';
               }
               
               if ($tipo[2] == 'visor' ) {
                   $variable_url = $i;
                   $ajax = ' onClick="'.$funcion."('".'visor'."','".$variable_url."')".'"';
                   $cboton_visor = '<a title="Visor busqueda del registro" '. $ajax .'  class="btn btn-xs btn-warning" role="button" href="#">
                        <i class="glyphicon glyphicon-search"></i></a> ';
               }

               if ($tipo[2] == 'ciu' ) {
                 $ajax = ' onClick="'.$funcion."('".'ciu'."','".$variable_url."')".'"';
                $cboton_visor = '<a title="Visor busqueda del registro" '. $ajax .'  class="btn btn-xs btn-warning" role="button" href="#">
                     <i class="glyphicon glyphicon-search"></i></a> ';
            }
               
              
               
               echo '<td>'.$cboton_visor.$cboton_edicion.$cboton_del.$cboton_archivo.'</td>';
           }
           
           echo '</tr>';
           
           $i++;
       }
       
   
       
       echo '</table>';
       
       
   } 
   //-----------------------------------------------------------------------------------------------
   public function JqueryArrayVisorObj($tabla,$array,$tipoObjeto){
   	
   	$sql = $this->contruye_sql($tabla,$array);
   	
 
   	
   	switch ($this->tipo){
   		
   		case 'mysql':     {
   			$this->stmt = mysql_query($sql,$this->link);
   			$this->array=mysql_fetch_array($this->stmt);
   			$datos = $this->array;
   			break ;
   		}
   		case 'postgress': {
   			$this->stmt = pg_query($this->link, $sql);
   			$this->array = pg_fetch_array($this->stmt);
   			$datos = $this->array;
   			break;
   		}
   		case 'oracle':    {
   			
   			$this->stmt = oci_parse($this->link, $sql  );
   			
   			oci_execute($this->stmt);
   			
   			$this->array = oci_fetch_array($this->stmt);
   			
   			oci_free_statement($this->stmt);
   			
   			$datos = $this->array;
   			
   			break;
   		}
   		
   		break;
   		
   	}
   	
    
   		// crear array de datos para vizualizar
   	$datos =  $this->jquery_obj_sqlObj( $datos,$array,$tipoObjeto);
    
   	
   	return  $datos ;
   	
   } 
 //------------------------------------------------------------------------------   
//---------------------------- busqueda de objetos para consuta jquery
//------------------------------------------------------------------------------
  /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   public function JqueryArrayVisorTab($tabla,$array,$tab){
	   
	   $sql = $this->contruye_sql($tabla,$array);
 
	   
 
       
      switch ($this->tipo){
		
	     case 'mysql':     {
			 			   $this->stmt = mysql_query($sql,$this->link);
                           $this->array=mysql_fetch_array($this->stmt);
                           $datos = $this->array;
		 				   break ;
                           }
 		 case 'postgress': {
  						   $this->stmt = pg_query($this->link, $sql);
                           $this->array = pg_fetch_array($this->stmt);
                           $datos = $this->array;
						   break;
 		                   }
		 case 'oracle':    {
		  
                           $this->stmt = oci_parse($this->link, $sql  );
						   
                           oci_execute($this->stmt); 
                           
                           $this->array = oci_fetch_array($this->stmt);
                           
                           oci_free_statement($this->stmt);
                          
                           $datos = $this->array;
                           
                           break;
                         }
      					   
		 break;
		 
		 }
	  
	  // crear array de datos para vizualizar	 
	  $this->jquery_obj_sqlTab( $datos,$array,$tab);
	
	return  $datos ;
   
   } 
 //------------------------------------------------------------------------------   
   public function JqueryArrayVisorDato($tabla,$array,$debug=0){
       
       $sql = $this->contruye_sql($tabla,$array);
       
       if ( $debug == 1){
           echo $sql;
       }
       
       switch ($this->tipo){
           
           case 'mysql':     {
               $this->stmt = mysql_query($sql,$this->link);
               $this->array=mysql_fetch_array($this->stmt);
               $datos = $this->array;
               break ;
           }
           case 'postgress': {
               $this->stmt = pg_query($this->link, $sql);
               $this->array = pg_fetch_array($this->stmt);
               $datos = $this->array;
               break;
           }
           case 'oracle':    {
               
               $this->stmt = oci_parse($this->link, $sql  );
               
               oci_execute($this->stmt);
               
               $this->array = oci_fetch_array($this->stmt);
               
               oci_free_statement($this->stmt);
               
               $datos = $this->array;
               
               break;
           }
           
           break;
           
       }
       
         
       return  $datos ;
       
   } 
//---------------------------- busqueda de objetos para consuta jquery
//------------------------------------------------------------------------------
  /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   public function JqueryArray($tabla,$array){
	   
	   $sql = $this->contruye_sql($tabla,$array);
 
 
       
      switch ($this->tipo){
		
	     case 'mysql':     {
			 			   $this->stmt = mysql_query($sql,$this->link);
                           $this->array=mysql_fetch_array($this->stmt);
                           $datos = $this->array;
		 				   break ;
                           }
 		 case 'postgress': {
  						   $this->stmt = pg_query($this->link, $sql);
                           $this->array = pg_fetch_array($this->stmt);
                           $datos = $this->array;
						   break;
 		                   }
		 case 'oracle':    {
		  
                           $this->stmt = oci_parse($this->link, $sql  );
						   
                           oci_execute($this->stmt); 
                           
                           $this->array = oci_fetch_array($this->stmt);
                           
                           oci_free_statement($this->stmt);
                          
                           $datos = $this->array;
                           
                           break;
                         }
      					   
		 break;
		 
		 }
 
	
	return  $datos ;
   
   }   
//------------------------------------------------------------------------------   
//---------------------------- busqueda de objetos para consuta jquery
//------------------------------------------------------------------------------
  /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   public function JqueryCursorVisor($tabla,$array,$debug=0){
	 
 
    $sql = $this->contruye_sql($tabla,$array);
   
    $_SESSION['sql_activo'] = $sql;
    
    if ( $debug == 1){
        echo $sql;
    }
 
    
    switch ($this->tipo){
		
	     case 'mysql':     {
			 			   $stmt = mysql_query($sql,$this->link);
                           return $stmt;
		 				   break ;
                           }
 		 case 'postgress': {
  						   $stmt = pg_query($this->link, $sql);
                           return $stmt;
						   break;
 		                   }
		 case 'oracle':    {
		  
                           $stmt = oci_parse($this->link, $sql  );
						   
                           oci_execute($stmt); 
 
                           return $stmt;
                           
                           break;
                         }
      					   
		 break;
		 
		 }
     
   } 
  /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
 public function contruye_sqlEdit($tabla,$UpdateQuery){
    
     $longitud = count($UpdateQuery);
     
     $sqlColumnas = '';
     $sqlColumnasW= '';
    
                                    
    for ($row = 0; $row <= $longitud; $row++)
    {
     
          if (  $UpdateQuery[$row][filtro] == 'N' ){
            
			 
			$valor = trim($UpdateQuery[$row][valor]);
			
			if ($valor <> '-') {
					if (substr($valor,0,3) == 'to_'){
					
						$cadena = trim($UpdateQuery[$row][valor]) ; 
					 
					 }
					 else{
					     $valor = trim($UpdateQuery[$row][valor]);
					     $cadena = $this->sqlvalue_inyeccion(trim($valor), true);  
					 }
			  
           			 $sqlColumnas =  $sqlColumnas.",".$UpdateQuery[$row][campo].'='.$cadena;
			 }		 
         }
    }
 
  
        // columnas                                       
    for ($row = 0; $row <= $longitud; $row++)
    {
     
          if (  $UpdateQuery[$row][filtro] == 'S' ){
              
             $valor = trim($UpdateQuery[$row][valor]);
              
             $cadena = $this->sqlvalue_inyeccion( trim($valor), true); 
			  
             $sqlColumnasW =  $sqlColumnasW." and ".$UpdateQuery[$row][campo].'='.trim($cadena) ;
     
           }
    }
	
    $longitudW = strlen($sqlColumnasW); 
 
    $longitud = strlen($sqlColumnas); 
   
    $sql =  'UPDATE '.$tabla.' SET '.substr($sqlColumnas,1,$longitud).' where '. substr($sqlColumnasW,5,$longitudW);
      
	 return $sql; 
   } 
   
 public function contruye_sqlInsert($tabla,$UpdateQuery){
    
     $longitud = count($UpdateQuery);
    
    // columnas             
     
   $sqlColumnas = 'INSERT INTO '.$tabla.' (';
   
   $sqlColumnasI = '';
   
   $sqlColumnasV = ''; 
            
    for ($row = 0; $row <= $longitud; $row++)
    {
            $cadena = trim($UpdateQuery[$row][campo]) ; 
            
            $sqlColumnasI = trim($sqlColumnasI).trim($cadena)."," ;
        
            $valor = trim($UpdateQuery[$row][valor]);
			
             
	 if (substr($valor,0,3) == 'to_'){
					
                    $cadenav = trim($UpdateQuery[$row][valor]) ; 
					 
	 }
	else{
	    $valor = trim($UpdateQuery[$row][valor]);
	    $cadenav = $this->sqlvalue_inyeccion(trim($valor), true);  
	}
			  
       $sqlColumnasV =  $sqlColumnasV.$cadenav.",";
             
             
    }
  
    $longitudI = strlen(trim($sqlColumnasI)); 
    
    $longitudV = strlen($sqlColumnasV); 
   
    $sql =  $sqlColumnas.substr($sqlColumnasI,0,$longitudI - 2).' ) values ( '.substr($sqlColumnasV,0,$longitudV - 6).')';
      
    return $sql;  
   }    
   
 /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   
   public function contruye_sql($tabla,$qquery){
   	 
   	$longitud = count($qquery);
   	 
   	$sqlColumnas  = '';
   	$sqlColumnasW = '';
   	
   	// columnas
   	for ($row = 0; $row <= $longitud; $row++)
   	{
   
   		 if (  $qquery[$row][visor] == 'S' ){
   			 
   							   
   			
					   			if ($qquery[$row][valor] == 'F' ){
					   				 
					   				if ($qquery[$row][valor] <> '0' ){
					   		 
					   				 
									   				$fecha = 'to_char('.$qquery[$row][campo].",'RRRR-MM-DD') AS ".$qquery[$row][campo];
									   				 
									   				$sqlColumnas =  $sqlColumnas.",".$fecha;
					   				}
					   				else{
					   					$sqlColumnas =  $sqlColumnas.",".$qquery[$row][campo];
					   				}
					   			}else{
					   				$sqlColumnas =  $sqlColumnas.",".$qquery[$row][campo];
					   			}
					   			 
   			 
   				
    	}
   	}
   	 
   	$banderaWhere = 0;
   	// columnas
   	for ($row = 0; $row <= $longitud; $row++)
   	{
   
   		if (  $qquery[$row][filtro] == 'S' ){
   			
   			$banderaWhere = 1;
   			
   			$valor = $qquery[$row][valor];
   
   			$cvalor = $this->sqlvalue_inyeccion($valor ,true);
   			 
   			if (substr($valor,0,7) == 'BETWEEN'){
   				$signo =' ';
   			}else{
   					
   				$array = explode(".", $valor);
   					
   				$filtroLike 		= $array[0];
   				$valorParcial       =  trim($array[1]);
   				 
 					
   				if ($filtroLike == 'LIKE'){
   					$signo ='  LIKE  ';
   					$cvalor = $this->sqlvalue_inyeccion($valorParcial ,true);
   						
   				}elseif($filtroLike == '<>'){
   					$signo ='  <>  ';
   					$cvalor = $this->sqlvalue_inyeccion($valorParcial ,true);
    				}
 				else{
   					$signo =' = ';
   				}
   
   			}
   
   		 	if ($this->between_query == '-'){
   			    $cadenaBetween='';
   			}else{
   			    $cadenaBetween = $this->between_query;
   			}
   			//-----------------------------------
   			if ($this->where_query == '-'){
   			    $cadenaBetweenq='';
   			}else{
   			    $cadenaBetweenq = $this->where_query;
   			}
   			
   			if (trim($valor) == 'isnull'){
   			    $signo = ' ';
   			    $cvalor = ' is null ';
   			}
   			
   			$sqlColumnasW =  $sqlColumnasW." and ".$qquery[$row][campo] .$signo.$cvalor.$cadenaBetween.$cadenaBetweenq  ;
   				
   		}
   	}
   	 
 
   	
   	$longitud = strlen($sqlColumnas);
   	 
   	$longitudW = strlen($sqlColumnasW);
   	 
   	 if ($banderaWhere == 0){
   	 	
   	     $sql = 'select '.substr($sqlColumnas,1,$longitud).' from '.$tabla .   $this->orderby. $this->limit  ;
   	 
   	 }else{
   	 
   	     $sql = 'select '.substr($sqlColumnas,1,$longitud).' from '.$tabla.' where '. substr($sqlColumnasW,5,$longitudW).   $this->orderby. $this->limit;
   	 
   	 }
 
   	 
   	return $sql;
   }
 ///-------------------------------------------------------------------------
   public function contruye_sql_table($tabla,$qquery){
       
       $longitud = count($qquery);
       
       $sqlColumnas  = '';
       
       $sqlColumnasW = '';
       
       // columnas
       for ($row = 0; $row <= $longitud; $row++)
       {
           
           if (  $qquery[$row][visor] == 'S' ){
               
                    $sqlColumnas =  $sqlColumnas.",".$qquery[$row][campo];
           
            }
       }
       
       $banderaWhere = 0;
       // columnas
       for ($row = 0; $row <= $longitud; $row++)
       {
           
           if (  $qquery[$row][filtro] == 'S' ){
               
               $banderaWhere = 1;
               
               $valor = $qquery[$row][valor];
               $array = explode(".", $valor);
               
               $filtroLike 		= $array[0];
               $valorParcial   =  trim($array[1]);
               
               if ($filtroLike == 'LIKE'){
                   $signo ='  LIKE  ';
                   $cvalor = $this->sqlvalue_inyeccion($valorParcial ,true);
                   $sqlColumnasW =  $sqlColumnasW." and ".$qquery[$row][campo] .$signo.$cvalor;
                   
                   
               }else{
                   $cvalor = $this->sqlvalue_inyeccion($valor ,true);
                   $sqlColumnasW =  $sqlColumnasW." and ".$qquery[$row][campo] .'='.$cvalor;
                   
               }
               
               
               
               
           }
       }
       
       
       
       $longitud = strlen($sqlColumnas);
       
       $longitudW = strlen($sqlColumnasW);
       
       if ($banderaWhere == 0){
           
           $sql = 'select '.substr($sqlColumnas,1,$longitud).' from '.$tabla .   $this->orderby. $this->limit  ;
           
       }else{
           
           $sql = 'select '.substr($sqlColumnas,1,$longitud).' from '.$tabla.' where '. substr($sqlColumnasW,5,$longitudW).   $this->orderby. $this->limit;
           
       }
       
       
       return $sql;
   }
 //--------------------------------------------
   public function contruye_sql_cabecera($qquery,$accion,$id,$font='12'){
       
       $longitud = count($qquery);
       
       echo '<table id="'.$id.'" style="font-size:'.$font.' px" name="'.$id.'" class="display table table-condensed table-hover datatable" border="0" width="100%"> <tr>';
 
       // columnas
       for ($row = 0; $row <= $longitud; $row++)
       {
           
           if (  $qquery[$row][visor] == 'S' ){
  
               
               echo '<td bgcolor=#ADC4DC width="'.$qquery[$row][ancho].'"><b>'.$qquery[$row][etiqueta].'</b></td>';
              ;
               
           }
       }
       
       if ($accion > 0 ){
           echo '<td bgcolor=#ADC4DC width="10%"> &nbsp;</td>';
       }
       
       echo '</tr>';
       
       
       
 
      
   }
/*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql jquery_obj_sql*/
 public function jquery_obj_sql($datos,$qquery){
    
    $longitud = count($qquery);
    
	echo '<script type="text/javascript">';
	   
    // columnas                                       
    for ($row = 0; $row <= $longitud; $row++)
    {
     
          if (  $qquery[$row][visor] == 'S' ){
            
             $variable = $datos[$qquery[$row][campo]];
 
                if ( $qquery[$row][valor] == 'D' ){
 
                         $var = (string)$variable;

                         $variable1 = str_replace(',','.',$var);
   
                         echo  '$("#'.$qquery[$row][campo].'").val('.$variable1.');';
 
                  }else {
                      
                        $variable =  $this->poner_guion($variable);
                      
                        echo  '$("#'.$qquery[$row][campo].'").val("'.trim($variable).'");';
                }
        
     
           }
    }
  
      echo   "activaTab();";   
    
      echo '</script>';
   
	 return 1; 
   } 
   /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   public function jquery_obj_sqlObj($datos,$qquery,$tipoObj){
   	
   	
   	$longitud = count($qquery);
   	
   	echo '<script>';
   	
   	// columnas
   	for ($row = 0; $row <= $longitud; $row++)
   	{
   		
   		if (  $qquery[$row][visor] == 'S' ){
   			
   			$variable = $datos[$qquery[$row][campo]];
   			
   			if ( $qquery[$row][valor] == 'D' ){
   				
   				$var = (string)$variable;
   				
   				$variable1 = str_replace(',','.',$var);
   				
   				echo  '$("#'.$qquery[$row][campo].'").val('.trim($variable1).');';
   				
   			}else {
   			    
   			    $variable =  $this->poner_guion($variable);
   			    
   				echo  '$("#'.$qquery[$row][campo].'").val("'.trim($variable).'");';
   			
   			}
   			
   			
   		}
   	}
   	
   	if ($tipoObj == 1 ){
   	    
   			echo   "activaTab();";
   			
   	}
   	
   	echo '</script>';
   	
   	return 1;
   } 
 
   /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
 public function jquery_obj_sqlTab($datos,$qquery,$tab){
    
      
    $longitud = count($qquery);
    
	 echo '<script type="text/javascript">';
	   
    // columnas                                       
    for ($row = 0; $row <= $longitud; $row++)
    {
     
          if (  $qquery[$row][visor] == 'S' ){
              
             
              
              if (  $qquery[$row][valor] == 'EDITOR' ){
        
                  $cadenaDeTexto = trim($datos[$qquery[$row][campo]]);
                  
                  $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
                  $reemplazar=array(" ", " ", " ", " ");
                  
                  $cadena=str_ireplace($buscar,$reemplazar,$cadenaDeTexto);
                  
                  echo  '$("#'.$qquery[$row][campo].'").html("'.$cadena.'");';
                  
              }else{
                  
                  if (  $qquery[$row][valor] == '-' ){
                      
                      $variable = $datos[$qquery[$row][campo]];
                      
                      $variable =  $this->poner_guion($variable);
                      
                      echo  '$("#'.$qquery[$row][campo].'").val("'.trim($variable).'");';
                      
                  }else {
                      
                      $variable = $datos[$qquery[$row][campo]];
                      
                      $variable1 = $datos[$qquery[$row][campo]];
                      
                      $filtro =  $qquery[$row][filtro];
                    
                      
                      $variable =  $this->poner_guion($variable);
                      
                      if (  trim($filtro)== 'S'){
                          
                          echo  '$("#'.$qquery[$row][campo].'").val("'.trim($variable1).'");';
                          
                      }else{
                          
                          echo  '$("#'.trim($qquery[$row][valor]).'").val("'.trim($variable).'");';
                          
                      }
                    
                      
                  }
                  
          
              }
            
         	
     
           }
    }
  
    if ($tab <>'-') {
        
      echo   "activaTabP('".$tab."');";   
      
    }
    
      echo '</script>';
   
	 return 1; 
   } 
   
    /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   public function query_array($tabla,$campo,$where,$debug='0',$order='',$limit=''){
    
      
    $sql = 'select '.$campo.' from '.$tabla.' where '.$where.$order.$limit;
 
    if( $debug == '1'){
        echo $sql;
    }
 
 
    switch ($this->tipo){
		
	     case 'mysql':     {
			 			   $this->stmt = mysql_query($sql,$this->link);
                           $this->array=mysql_fetch_array($this->stmt);
                           return $this->array;
		 				   break ;
                           }
 		 case 'postgress': {
  						   $this->stmt  = pg_query($this->link, $sql);
                           $this->array = pg_fetch_array($this->stmt);
                           return $this->array;
						   break;
 		                   }
		 case 'oracle':    {
		  
                           $this->stmt = oci_parse($this->link, $sql  );
						   
                           oci_execute($this->stmt); 
                           
                           $this->array = oci_fetch_array($this->stmt);
                           
                           oci_free_statement($this->stmt);
                          
                           return $this->array;
                           
                           break;
                         }
      					   
		 break;
		 
		 }
      
   } 
    /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   public function query_array_all($tabla,$campo,$where,$debug='0',$order='',$limit=''){
    
      
    $sql = 'select '.$campo.' from '.$tabla.' where '.$where.$order.$limit;
 
    if( $debug == '1'){
        echo $sql;
    }
 
 
    switch ($this->tipo){
		
	     case 'mysql':     {
			 			   $this->stmt = mysql_query($sql,$this->link);
                           $this->array=mysql_fetch_array($this->stmt);
                           return $this->array;
		 				   break ;
                           }
 		 case 'postgress': {
  						   $this->stmt  = pg_query($this->link, $sql);
                           $this->array = pg_fetch_all($this->stmt);
                           return $this->array;
						   break;
 		                   }
		 case 'oracle':    {
		  
                           $this->stmt = oci_parse($this->link, $sql  );
						   
                           oci_execute($this->stmt); 
                           
                           $this->array = oci_fetch_array($this->stmt);
                           
                           oci_free_statement($this->stmt);
                          
                           return $this->array;
                           
                           break;
                         }
      					   
		 break;
		 
		 }
      
   } 
      /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/ 
   public function query_cursor($tabla,$campo,$where,$grupo='',$order="",$limit="",$ofset="",$debug=0){
       
       
       if (empty($where))    {
           $sql = 'SELECT '.$campo.' FROM '.$tabla;
       }else{
           $sql = 'SELECT '.$campo.' FROM '.$tabla.' WHERE '.$where;
       }
       
       if (!empty($grupo))    {
           $sql = $sql.' GROUP BY '.$grupo ;
       }
       
       
       if (!empty($order))    {
           $sql = $sql.' ORDER BY '.$order ;
       }
       
       if (!empty($limit))    {
           $sql = $sql.' LIMIT '.$limit ;
       }
       
       if (!empty($ofset))    {
           $sql = $sql.' OFFSET '.$ofset ;
       }
       
       if ( $debug > 0 )    {
           echo $sql;
       }
       
       
       
       switch ($this->tipo){
           
           case 'mysql':     {
               $stmt = mysql_query($sql,$this->link);
               return $stmt;
               break ;
           }
           case 'postgress': {
               $stmt = pg_query($this->link, $sql);
               return $stmt;
               break;
           }
           case 'oracle':    {
               
               $stmt = oci_parse($this->link, $sql  );
               
               oci_execute($stmt);
               
               return $stmt;
               
               break;
           }
           
           break;
           
       }
       
   }  
   //--------------
   public function query_cursor_registros($tabla,$campo,$where,$group){
       
       
       $sql = 'SELECT '.$campo.' FROM '.$tabla.' WHERE '.$where.' '.$group;
       
       
       // echo $sql;
       
       switch ($this->tipo){
           
           case 'mysql':     {
               $stmt = mysql_query($sql,$this->link);
               return $stmt;
               break ;
           }
           case 'postgress': {
               $stmt = pg_query($this->link, $sql);
               $numero = pg_num_rows($stmt);
               return $numero;
               break;
           }
           case 'oracle':    {
               
               $stmt = oci_parse($this->link, $sql  );
               
               oci_execute($stmt);
               
               return $stmt;
               
               break;
           }
           
           break;
           
       }
       
   }  
    /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function UpdateSQL($tabla,$campo,$where){
    
    
        $sql = 'update '.$tabla.' set '.$campo.' where '.$where;
    
       switch ($this->tipo){
		
	     case 'mysql':     
			 			   mysql_query($sql,$this->link);
		 				   break;
 		 case 'postgress': {
  						   pg_query($this->link, $sql);
						    
						   break;
 						  
 	     }
		 case 'oracle':    {
                           $stmt = oci_parse($this->link, $sql  );
                           
						   oci_execute($stmt); 
                          
                           oci_free_statement($stmt);
                             
					       break;
                         }
      					   
		 break;
		 
		 }
 	  
      return true;
   }  
   
    /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function InsertSQL($tabla,$campo,$valor){
   
   
   $sql = 'INSERT INTO '.$tabla.' ( '.$campo.' ) VALUES (' .$valor. ')';
 
    
       switch ($this->tipo){
		
	     case 'mysql':     
			 			   mysql_query($sql,$this->link);
		 				   break;
 		 case 'postgress': {
  						   pg_query($this->link, $sql);
						    
						   break;
 						  
 	     }
		 case 'oracle':    {
                           $stmt = oci_parse($this->link, $sql  );
                           
						   oci_execute($stmt); 
                          
                           oci_free_statement($stmt);
                           
					       break;
                         }
      					   
		 break;
		 
		 }
 	  
      return true;
   }  
   /*
   */
  public function query_array_sql($sql,$debug='0'){
    
       
 
    if( $debug == '1'){
        echo $sql;
    }
 
 
    switch ($this->tipo){
		
	     case 'mysql':     {
			 			   $this->stmt = mysql_query($sql,$this->link);
                           $this->array=mysql_fetch_array($this->stmt);
                           return $this->array;
		 				   break ;
                           }
 		 case 'postgress': {
  						   $this->stmt  = pg_query($this->link, $sql);
                           $this->array = pg_fetch_array($this->stmt);
                           return $this->array;
						   break;
 		                   }
		 case 'oracle':    {
		  
                           $this->stmt = oci_parse($this->link, $sql  );
						   
                           oci_execute($this->stmt); 
                           
                           $this->array = oci_fetch_array($this->stmt);
                           
                           oci_free_statement($this->stmt);
                          
                           return $this->array;
                           
                           break;
                         }
      					   
		 break;
		 
		 }
      
   } 
   /*MÃƒÂ©todo para obtener una fila de resultados de la sentencia sql*/
   public function obtener_array($stmt){
      switch ($this->tipo){
	     case 'mysql':    $this->array=mysql_fetch_array($stmt);
	                      break;
		 case 'postgress':  
						   $this->array = pg_fetch_array($stmt);
					       break;
		break;
		 case 'oracle':  
						   $this->array = oci_fetch_array($stmt);
                           break;
		break;
	  }
      return $this->array;
   }
   /*
   */
  public function ejecutar_formula($formula, $codigo){
   
  $sql_val = "select formula.".$formula."(".$codigo.") as total where 1=1";
 

  $stmt = pg_query($this->link, $sql_val);

  $row_valida = pg_fetch_array($stmt);
 
  return  $row_valida['total']; ;

}

public function ejecutar_formula_recargo($codigo,  $data,  $anio_actual, $anio,$fechae){
   
    $formula = 'f_recargo';

    $sql_val = "select formula.".$formula."(".$codigo.','. $data.','.$anio_actual.','.$anio.','."'".$fechae."'".") as total where 1=1";
   
  
    $stmt = pg_query($this->link, $sql_val);
  
    $row_valida = pg_fetch_array($stmt);
   
    return  $row_valida['total']; ;
  
  }
   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function ejecutar_array($sql){
       
      switch ($this->tipo){
	     case 'mysql':     $stmt = mysql_query($sql,$this->link);
						   return mysql_fetch_row($stmt);
						   break; 
 		 case 'postgress': $stmt = pg_query($this->link, $sql);
						   return pg_fetch_row($stmt);
 						   break;
	     case 'oracle':    $stmt = oci_parse($this->link, $sql  );
         
						   oci_execute($stmt); 
 		
         				   return oci_fetch_row($stmt);
		
        				   break;
		 break;
	  }
    }
    /*MÃƒÂ©todo para ejecutar una sentencia sql*/
    public function _ccuenta($cuenta, $registro){
        
        $A = $this->query_array(
            'co_plan_ctas',
            'count(cuenta) as nn', 
            'registro='.$this->sqlvalue_inyeccion(trim($registro),true). ' and
             univel='.$this->sqlvalue_inyeccion('S',true).' and
             cuenta=' .$this->sqlvalue_inyeccion(trim($cuenta),true)
            );
        
        return $A['nn'];
        
    }	

  /*
  */
  public function _busca_documento($unidad,$idcaso,$anio,$sesion,$tipo,$variable='0'){
        
    $documento_array = $this->query_array('flow.wk_doc_user_temp',
                'secuencia,documento',
                'iddepartamento='.$this->sqlvalue_inyeccion($unidad,true).' and 
                idcaso=' .$this->sqlvalue_inyeccion($idcaso,true).' and 
                bandera=' .$this->sqlvalue_inyeccion(0,true).' and 
                anio=' .$this->sqlvalue_inyeccion($anio,true).' and 
                sesion=' .$this->sqlvalue_inyeccion($sesion,true).' and 
                tipo=' .$this->sqlvalue_inyeccion($tipo,true)
                );
    


    return $documento_array;
    
}	  
 
 ///------------------------------ wk_config
 public function __documento_secuencia($anio,$tipo,$unidad,$guarda=0){
         
    $documento_array = $this->query_array('nom_departamento',
        'nombre,referencia,siglas,oficio,memo,notifica,informe,circular',
        'id_departamento='.$this->sqlvalue_inyeccion($unidad,true)
        );
    
   
    $siglas     = trim($documento_array['siglas']);
    $retorna    = array();
    
    $retorna['secuencia']     = 0;
    $retorna['documento']     = '00000';
    
//emorando N° CBGADMSD-SG-2022-0001-M 

$secuencia_doc = 3;
    
    if (trim($tipo) =='Informe'){
         $retorna['secuencia']     = $documento_array['informe'] ;
         $input                    = str_pad($retorna['secuencia'], $secuencia_doc, "0", STR_PAD_LEFT);
         $retorna['documento']     = 'Informe Nro. '.$siglas.'-'.$anio.'-'.$input.'-I';
     }
    
     if (trim($tipo) =='Memo'){
         $retorna['secuencia']     = $documento_array['memo'] ;
         $input                    = str_pad($retorna['secuencia'], $secuencia_doc, "0", STR_PAD_LEFT);
         $retorna['documento']     = 'Memorando Nro. '.$siglas.'-'.$anio.'-'.$input.'-M';
     }
     
     if (trim($tipo) =='Notificacion'){
         $retorna['secuencia']     = $documento_array['notifica'] ;
         $input                    = str_pad($retorna['secuencia'], $secuencia_doc, "0", STR_PAD_LEFT);
         $retorna['documento']     = 'Memorando Circular Nro. '.$siglas.'-'.$anio.'-'.$input.'-N';
     }
     
     if (trim($tipo) =='Circular'){
         $retorna['secuencia']     = $documento_array['circular'] ;
         $input                    = str_pad($retorna['secuencia'], $secuencia_doc, "0", STR_PAD_LEFT);
         $retorna['documento']     = 'Memorando Circular Nro. '.$siglas.'-'.$anio.'-'.$input.'-MC';
     }
     
     if (trim($tipo) =='Oficio'){
         $retorna['secuencia']     = $documento_array['oficio'] ;
         $input                    = str_pad($retorna['secuencia'], $secuencia_doc, "0", STR_PAD_LEFT);
         $retorna['documento']     = 'Oficio Nro. '.$siglas.'-'.$anio.'-'.$input.'-O';
     }
     
     //---------------------------------------------------------------------------------------- 
     if ( $guarda == 1){
         if (trim($tipo) =='Informe'){
             $secuencia      = $documento_array['informe'] + 1 ;
             $tipo_secuencia = 'informe';
         }
         
         if (trim($tipo) =='Memo'){
             $secuencia      = $documento_array['memo'] + 1 ;
             $tipo_secuencia = 'memo';
         }
         
         if (trim($tipo) =='Notificacion'){
             $secuencia      = $documento_array['notifica'] + 1 ;
             $tipo_secuencia = 'notifica';
         }
         
         if (trim($tipo) =='Circular'){
             $secuencia      = $documento_array['circular'] + 1 ;
             $tipo_secuencia = 'circular';
         }
         
         if (trim($tipo) =='Oficio'){
             $secuencia      = $documento_array['oficio'] + 1 ;
             $tipo_secuencia = 'oficio';
         }
         
         $sqlima  = "update nom_departamento
                        set ".$tipo_secuencia." =".$this->sqlvalue_inyeccion($secuencia,true)."
                      where id_departamento = ".$this->sqlvalue_inyeccion($unidad,true);
         
         $this->ejecutar($sqlima);
     }
    
     ///---------------------------------------
     
    
    return  $retorna;
    
}
/*
reser va de documento
*/
    public function __documento_reserva($unidad,$secuencia, $sesion,$tipo ,$anio, $idcaso ,$documento  ){

        $documento_array = $this->query_array('flow.wk_doc_user_temp',
        'count(*) as nn',
        'iddepartamento='.$this->sqlvalue_inyeccion($unidad,true).' and 
        secuencia=' .$this->sqlvalue_inyeccion($secuencia,true).' and 
        anio=' .$this->sqlvalue_inyeccion($anio,true).' and 
        tipo=' .$this->sqlvalue_inyeccion($tipo,true)
        );

        if ( $documento_array['nn'] > 0 ){
                  
                    return 1 ;
 
        }	else  {

                $ATabla = array(
                    array( campo => 'id_temp_doc',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'secuencia',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $secuencia, key => 'N'),
                    array( campo => 'iddepartamento',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>$unidad, key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
                    array( campo => 'bandera',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '0', key => 'N'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor =>$tipo, key => 'N'),
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor =>$anio, key => 'N'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor =>$idcaso, key => 'N'),
                    array( campo => 'documento',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>$documento, key => 'N')
                    );

                    $this->_InsertSQL('flow.wk_doc_user_temp',$ATabla,'flow.wk_doc_user_temp_id_temp_doc_seq');

                    $datos = $this->__documento_secuencia($anio,$tipo,$unidad,1);

                    return 0;
        }	    
 
 }	

 
    //---------------------------------------
    public function _secuencias($anio, $tipo,$longitud,$variable='C'){
        
        /*SELECT idsecuencias, detalle, secuencia, estado, anio, tipo*/
        
        
       $A       = $this->query_array(
                    'co_secuencias',
                    'secuencia,idsecuencias,tanio',
                    'anio='.$this->sqlvalue_inyeccion($anio,true). ' and
                     tipo=' .$this->sqlvalue_inyeccion(trim($tipo),true)
                    );
        
        $contador     = $A['secuencia'] ;
        
        if (trim( $A['secuencia']) == 'N' ){
            $input_orden  = str_pad($contador, $longitud, "0", STR_PAD_LEFT);
        }else {
            $input_orden  = str_pad($contador, $longitud, "0", STR_PAD_LEFT).'-'.$anio;
        }
       
        if ( $variable == 'N'){
            $input_orden  = $contador;
        }
         
        $contador     = $A['secuencia'] + 1;
        
        $idsecuencias = $A['idsecuencias']  ;
        
        $sqlima       = "update co_secuencias 
                            set secuencia =".$this->sqlvalue_inyeccion($contador,true)."
                          where idsecuencias = ".$this->sqlvalue_inyeccion($idsecuencias,true);
        
        $this->ejecutar($sqlima);
        
        
        return $input_orden;
        
    }	

    public function _memo_caso($idcaso, $principal='N',$sesion='-'){
        
        $anio = $_SESSION['anio'];

        if ( trim($principal) =='I' ){
        
                $A = $this->query_array(
                    'flow.wk_proceso_casodoc',
                    'idcasodoc, idcaso,sesion,documento, asunto, tipodoc, 
                    para, de,   anio, mes, dia, secuencia, envia, uso, bandera, elabora',
                    'uso='.$this->sqlvalue_inyeccion(trim('I'),true). ' and
                    idcaso =' .$this->sqlvalue_inyeccion($idcaso,true)
                    );
        
                }

        return $A;
        
    }	
    
    public function _ccuenta_detalle($cuenta, $registro){
        
        $anio = $_SESSION['anio'];
        
        $A = $this->query_array(
            'co_plan_ctas',
            'detalle',
            'registro='.$this->sqlvalue_inyeccion(trim($registro),true). ' and
             cuenta=' .$this->sqlvalue_inyeccion(trim($cuenta),true). ' and
             anio =' .$this->sqlvalue_inyeccion($anio,true)
            );
        
        return $A['detalle'];
        
    }	
    ///-----------------------------------------
    public function _impresion_carpeta( $codigo ){
        
        $A = $this->query_array(
            'wk_config',
            'carpeta, modulo, carpetasub, formato, opcion, registro',
            'tipo='.$this->sqlvalue_inyeccion($codigo,true) 
            );
        
    
        $carpeta = trim($A['carpeta']);
        
        if ( $carpeta == 'local') {
            
            $url = '../reportes/'.trim($A['carpetasub']).'?a=';
            
        }else{
            
            $url = $carpeta.trim($A['carpetasub']);
        }
        
        return $url;
        
    }
   //------------------
   public function _url_externo( $codigo  ){
        
    $A = $this->query_array(
        'wk_config',
        'carpeta, modulo, carpetasub, formato, opcion, registro',
        'tipo='.$this->sqlvalue_inyeccion($codigo,true)
        );
     
     
         
        $carpeta = trim($A['modulo']);
        
    
    
    return $carpeta;
    
} 
  //----------------------------------------------------------  
    public function _carpeta_archivo( $codigo,$visor=0 ){
        
        $A = $this->query_array(
            'wk_config',
            'carpeta, modulo, carpetasub, formato, opcion, registro',
            'tipo='.$this->sqlvalue_inyeccion($codigo,true)
            );
         
         
        if ( $visor == 0) {
            
            $carpeta = trim($A['carpeta']);
            
        }else{
            
            $carpeta = trim($A['carpetasub']);
        }
        
        return $carpeta;
        
    }
   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function array_busqueda(){
      switch ($this->tipo){
	     case 'mysql':     return mysql_fetch_row($this->stmt);
						   
 		 case 'postgress': return pg_fetch_row($this->stmt);
 						   
	     case 'oracle':    return oci_fetch_row($this->stmt);
						   
		 break;
	  }
    }	
   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function array_num_row($stmt){
     
  	  $num_filas = 0;
	  
	  switch ($this->tipo){
		 case 'mysql': {    
				 if (mysql_num_rows ($stmt) > 0){
					$num_filas = 1;
				}else{
					$num_filas = 0;
				}
		 }
 		 case 'postgress':  
		 		//$num_filas = pg_num_rows($this->stmt);
	     case 'oracle':     
		 		//$num_filas = oci_num_rows($this->stmt);
		 break;
	  }
		return $num_filas ;  
    }		
	
	
   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function array_busqueda_stmt($stmt){
      switch ($this->tipo){
	     case 'mysql':     return mysql_fetch_row($stmt);
						   
 		 case 'postgress': return pg_fetch_row($stmt);
 						   
	     case 'oracle':    return oci_fetch_row($stmt);
						   
		 break;
	  }
    }		
   /*RETORNA EL TIPO DE CONEXION DE BASE DE DATOS*/
   public function retorna_tipo(){
       return $this->tipo;
   }
   
   // ULTIMA SECUENCIA DE LAS TABLA
  function ultima_secuencia($tabla) {
  	
  	   $secuencia = 0;
  	
	   switch ($this->tipo){
	   	
	     case 'mysql':{
			 				$sql_id       = "SELECT LAST_INSERT_ID() as numero FROM ".$tabla;
							$resultado = mysql_query($sql_id);
							$row = mysql_fetch_assoc($resultado );
							mysql_free_result($resultado) ;
							return 	$row['numero'];
 	                      break;
		 			  }
		 case 'postgress':  {
		     
   
		     
		               if ( $tabla == 'NO')  {
		                   return 	0 ;
		               }
		              else    {
		                  
		                  if  ($this->pideSecuencia == 0) {
		                      $sql = "SELECT last_value  as  numero FROM ".trim($tabla);
		                  }else {
		                      $sql = "SELECT last_value  as  numero FROM id_".trim($tabla);
		                  }
		                  
 		                         
		                         $stmt = pg_query($this->link, $sql);
		                         
		                         $row =  pg_fetch_array($stmt);
		                         
		                         pg_free_result($stmt);
		                         
		                         $secuencia =  $row['numero'];
		                         
		                         return 	$secuencia ;
		                         
		                    }
		            
						 break;
		 				}
		break;
	  }	
			
	return $secuencia;		   		 
  }
  //--------------------
  function ultima_secuenciaP($tabla) {
      
      $secuencia = 0;
      
      switch ($this->tipo){
          
          case 'mysql':{
              $sql_id       = "SELECT LAST_INSERT_ID() as numero FROM ".$tabla;
              $resultado = mysql_query($sql_id);
              $row = mysql_fetch_assoc($resultado );
              mysql_free_result($resultado) ;
              return 	$row['numero'];
              break;
          }
          case 'postgress':  {
              
              $sql = "SELECT last_value  as  numero FROM ".trim($tabla);
              
              $stmt = pg_query($this->link, $sql);
              
              $row =  pg_fetch_array($stmt);
              
              pg_free_result($stmt);
              
              $secuencia =  $row['numero'];
              
              return 	$secuencia ;
              
              break;
          }
          break;
      }
      
      return $secuencia;
  }
 	 // entrega secuencia con variable de secuencia 
 function oracle_secuencia($nombre_secuencia) {
			 
			$sql = "select ".$nombre_secuencia.".nextval as x1 from dual ";
		
			//ejecutamos la consulta 
			$stid = oci_parse($this->link, $sql  );
			oci_execute($stid);
			$row = oci_fetch_row($stid);
			$count = $row[0];		

			return $count ;
	 }
 	 // entrega secuencia con variable de secuencia 
  function kfecha($fecha) {
			   switch ($this->tipo){
					 case 'mysql':{
									return 	$fecha;
							  		break;
						  }
			 		  case 'postgress':  {
									return $fecha;
									 break;
							}
					 case 'oracle':  {
								 	 $WEB_FECHA_NACIO ="TO_DATE('".$fecha."', 'yyyy-mm-dd ')";
									 return $WEB_FECHA_NACIO;
									break;
							}						
			break;
	  }	
	 }	 
  /// contrador de visitas
  	 /*------------------------------------------------------*/			
 		 function KPcontador_usuario($ventana,$usuario) 
		 {
		      date_default_timezone_set('UTC');
			  
			  $fecha = date("Y/m/d");
			  $date  = "'".$fecha."'";
			  $IP_DATOS =   $_SERVER['REMOTE_ADDR'];
 			  
			// $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$IP_DATOS);
			/*  $city =    $tags['city'];
			  $region =  $tags['region'];
			  $country = $tags['country'];*/

			  $city =    "'".'Quito'."'";
			  $region =  "'".'Sierra'."'";
			  $country = "'".'Ecuador'."'";


			  $trozos = explode("/", $fecha,3); 
			/*  $anio1 = $trozos[0];	
			  $mes1 =  (int) $trozos[1]; 
			  $dia1 =  (int) $trozos[2]; 		
			  $URL =   "'".$ventana."'";
            */
 			  $canio = $trozos[0];	
			  $cmes =  $trozos[1]; 
			  $cdia =  $trozos[2]; 	
			  
 
 	   switch ($this->tipo){
			 case 'mysql':{
 				  	 $sql_id = "SELECT accion
	 						 FROM par_modulos  
							 where vinculo = ".$this->sqlvalue_inyeccion($ventana,true);

							$resultado_id = mysql_query($sql_id);
							$row = mysql_fetch_assoc($resultado_id );
							$modulo = ($row['accion']); 	
							mysql_free_result($resultado_id) ;

 				  $sql = "SELECT count(sesion) as numero 
			   			 FROM  web01_usuario  
						 where url='".$ventana."' and fecha =".$date." and sesion ='".$usuario."'";		
							
  								$resultado = mysql_query($sql);
								$row = mysql_fetch_row($resultado );
								$count = $row[0];	
						 if ($count == 0 ) {
 			 					  $sql = "insert into web01_usuario 
										(sesion,fecha,ip,url,city,region,modulo,country) values (" 
														.$this->sqlvalue_inyeccion($usuario,true).", " 
														.$this->sqlvalue_inyeccion($fecha,true).", " 
														.$this->sqlvalue_inyeccion($IP_DATOS,true).", " 
														.$this->sqlvalue_inyeccion($ventana,true).", " 
														.$this->sqlvalue_inyeccion($city,true).", " 
														.$this->sqlvalue_inyeccion($region,true).", " 
														.$this->sqlvalue_inyeccion($modulo,true).", " 														
														.$this->sqlvalue_inyeccion($country,true).")"; 
							 		
														
								//-----------------------------------
								$resultado = mysql_query($sql,$this->link);
								//mysql_free_result($resultado);
						 }
							  break;
						  }
			 case 'postgress':  {
 
				 $sql_id = "SELECT accion
	 						 FROM par_modulos  
							 where vinculo = ".$this->sqlvalue_inyeccion($ventana,true);

 						   
							$resultado_id = pg_query($sql_id);
							$row = pg_fetch_array($resultado_id );
							$modulo = ($row['accion']); 
								
							pg_free_result($resultado_id) ;
							
							
					$sql_contador = "select count(*) as valida
									 from web01_usuario a  
									 where  a.sesion = ".$this->sqlvalue_inyeccion($usuario,true)." and 
										substring(a.fecha,6,2) = ".$this->sqlvalue_inyeccion( $cmes,true)."  and 
										substring(a.fecha,1,4) = ".$this->sqlvalue_inyeccion($canio,true)."  and 
										substring(a.fecha,9,2) = ".$this->sqlvalue_inyeccion($cdia,true)."  and
										a.ip = ".$this->sqlvalue_inyeccion($IP_DATOS,true)."  and
										a.url = ".$this->sqlvalue_inyeccion($ventana,true);			
 
 					$resultado_id = pg_query($sql_contador);
					$row = pg_fetch_array($resultado_id );
					$valida = ($row['valida']); 
					pg_free_result($resultado_id) ;
					
					if ($valida == 0)		{	
							 $sql = "insert into web01_usuario 
										(sesion,fecha,ip,url,city,region,modulo,country) values (" 
														.$this->sqlvalue_inyeccion($usuario,true).", " 
														.$this->sqlvalue_inyeccion($fecha,true).", " 
														.$this->sqlvalue_inyeccion($IP_DATOS,true).", " 
														.$this->sqlvalue_inyeccion($ventana,true).", " 
														.$this->sqlvalue_inyeccion($city,true).", " 
														.$this->sqlvalue_inyeccion($region,true).", " 
														.$this->sqlvalue_inyeccion($modulo,true).", " 
														.$this->sqlvalue_inyeccion($country,true).")"; 
 							//-----------------------------------
							$stid = pg_query($this->link, $sql);
 							pg_free_result($stid);							 
					}	  
 							 break;
							}
			 case 'oracle':  {
				
 		
							
							$IDWEB01 = $this->oracle_secuencia('SE_WEB02_VISITAS');					
							$sql = "insert into web01_usuario 
										(idweb01,sesion,fecha,ip,url,city,region,country) values (" 
														.$this->sqlvalue_inyeccion($IDWEB01,true).", " 
														.$this->sqlvalue_inyeccion($usuario,true).", " 
														.$this->sqlvalue_inyeccion($fecha,true).", " 
														.$this->sqlvalue_inyeccion($IP_DATOS,true).", " 
														.$this->sqlvalue_inyeccion($ventana,true).", " 
														.$this->sqlvalue_inyeccion($city,true).", " 
														.$this->sqlvalue_inyeccion($region,true).", " 
														.$this->sqlvalue_inyeccion($country,true).")"; 
						
						 
 							//-----------------------------------
							$stid = oci_parse($this->link, $sql);
							oci_execute($stid);
							oci_free_statement($stid);
							//oci_close($conn);
							break;
							}						
			break;
	  }	
			 
 			  
		/*	  $this->resultado = mysql_query($sql);
			  $row = mysql_fetch_assoc($this->resultado);
			  $count = $row["idestadisticas"];
			  mysql_free_result($this->resultado);



			  if ($count == 0 ) {
			       $sql = "insert into `web_estadisticas` 
				   (`fecha`, `direcion`,`anio`,`dia`, `mes`,`ubicacion`) values (" 
													.$date.", " 
													.$direcion.", " 
													.$anio1.", " 
													.$dia1.", " 
													.$mes1.", " 
													.$ubicacion.")";
					$this->resultado = mysql_query($sql);
		    }	  
		   */
		   return 0;
		}	
   /// contrador de visitas
  	 /*------------------------------------------------------*/			
 		 function KPcontador($ventana) 
		 {
		      date_default_timezone_set('UTC');
			  
			  $fecha = date("Y/m/d");
			  $date  = "'".$fecha."'";
			  $IP_DATOS =   $_SERVER['REMOTE_ADDR'];
			  $direcion = "'".$IP_DATOS."'";
			  
			 // $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$IP_DATOS);
			 // $city =    "'".$tags['city']."'";
			 // $region =  "'".$tags['region']."'";
			 // $country = "'".$tags['country']."'";

			  $city =    "'".'Quito'."'";
			  $region =  "'".'Sierra'."'";
			  $country = "'".'Ecuador'."'";


			  $trozos = explode("/", $fecha,3); 
			  $anio1 = $trozos[0];	
			  $mes1 =  (int) $trozos[1]; 
			  $dia1 =  (int) $trozos[2]; 		
			  $URL =   "'".$ventana."'";
		
				
				 
 	   switch ($this->tipo){
			 case 'mysql':{
 						  
			  $sql = "SELECT count(IDWEB02) as numero 
			   			 FROM  web02_visitas  
						 where url='".$ventana."' and fecha =".$date." and IP ='".$IP_DATOS."'";		
							
  								$resultado = mysql_query($sql);
								$row = mysql_fetch_row($resultado );
								$count = $row[0];		
								/////////////////////////////////
								 if ($count == 0 ) {
								  $sql = "insert into web02_visitas 
										(FECHA,URL,ANIO,DIA,CITY,REGION,COUNTRY, MES,IP) values (" 
														.$date.", " 
														.$URL.", " 
														.$anio1.", " 
														.$dia1.", " 
														.$city.", " 
														.$region.", " 
														.$country.", " 
														.$mes1.", " 
														.$direcion.")"; 
								 }
								//-----------------------------------
								$resultado = mysql_query($sql,$this->link);
								//mysql_free_result($resultado);
							  break;
						  }
			 case 'postgress':  {
						
							  
			  $sql = "SELECT count(IDWEB02) as numero 
			   			 FROM  WEB02_VISITAS  
						 where url='".$ventana."' and fecha =".$date." and IP ='".$IP_DATOS."'";
						 
							 $stmt = pg_query($this->link, $sql);
							 $row =  pg_fetch_row($stmt);
							 $count = $row[0];		
							/////////////////////////////////
							 if ($count == 0 ) {
							  $sql = "insert into WEB02_VISITAS 
				   					(FECHA,URL,ANIO,DIA,CITY,REGION,COUNTRY, MES,IP) values (" 
													.$date.", " 
													.$URL.", " 
													.$anio1.", " 
													.$dia1.", " 
													.$city.", " 
													.$region.", " 
													.$country.", " 
													.$mes1.", " 
													.$direcion.")"; 
							 }
							//-----------------------------------
							$stid = pg_query($this->link, $sql);
 							pg_free_result($stid);							 
							  
 							 break;
							}
			 case 'oracle':  {
				
					  
			  $sql = "SELECT count(IDWEB02) as numero 
			   			 FROM  WEB02_VISITAS  
						 where url='".$ventana."' and fecha =".$date." and IP ='".$IP_DATOS."'";
						 
							$stid = oci_parse($this->link, $sql);
							oci_execute($stid);
							$row = oci_fetch_row($stid);
							$count = $row[0];	
			 
		
							
							$IDWEB02 = $this->oracle_secuencia('SE_WEB02_VISITAS');					
							/////////////////////////////////
							 if ($count == 0 ) {
							  $sql = "insert into WEB02_VISITAS 
				   					(IDWEB02,FECHA,URL,ANIO,DIA,CITY,REGION,COUNTRY, MES,IP) values (" 
													.$IDWEB02.", " 
													.$date.", " 
													.$URL.", " 
													.$anio1.", " 
													.$dia1.", " 
													.$city.", " 
													.$region.", " 
													.$country.", " 
													.$mes1.", " 
													.$direcion.")"; 
							 }
							//-----------------------------------
							$stid = oci_parse($this->link, $sql);
							oci_execute($stid);
							oci_free_statement($stid);
							//oci_close($conn);
							break;
							}						
			break;
	  }	
			 
 			  
		/*	  $this->resultado = mysql_query($sql);
			  $row = mysql_fetch_assoc($this->resultado);
			  $count = $row["idestadisticas"];
			  mysql_free_result($this->resultado);



			  if ($count == 0 ) {
			       $sql = "insert into `web_estadisticas` 
				   (`fecha`, `direcion`,`anio`,`dia`, `mes`,`ubicacion`) values (" 
													.$date.", " 
													.$direcion.", " 
													.$anio1.", " 
													.$dia1.", " 
													.$mes1.", " 
													.$ubicacion.")";
					$this->resultado = mysql_query($sql);
		    }	  
		   */
		   return 0;
		}	
		//---------------------
		function _enlaceIp($login,$enlaces)
		{
		  
  		    $fecha = date("Y-m-d");
  		    $trozos = explode("-", $fecha);
  		    $anio1 = $trozos[0];
  		    $mes1 =  (int) $trozos[1];
  		    $dia1 =  (int) $trozos[2];
  		    
  		    $IP_DATOS =   $_SERVER['REMOTE_ADDR'];
 		    $registroDato = 0; 
		    
		    //-------------------------------------------------------------------
		    $ValidaIP = $this->query_array('web02_visitas',
		        'max(contador) as registro, max(idweb02) as idweb02 ',
		        'usuario='.$this->sqlvalue_inyeccion(trim($login),true) 
		        );
		    
		    
 		    $registro = $ValidaIP['registro']  ;
 		    $id       = $ValidaIP['idweb02'] ;
 		    
 		    $time = time();
  		    
 		    $country_code = date("H:i:s", $time);
 		    $region = date("H:i:s", $time);
 		    
 		    $url = str_replace("/index.php","",$enlaces);
 		    
 		    if ( $registro > 0 ){
 		        $contador = $registro + 1;
 		    }else {
 		        $contador = 1;
 		    }
 		    
 		    $_SESSION['enlace'] = $url;
 		    
 
 		    
 		    $ATabla = array(
 		        array( campo => 'idweb02',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
 		        array( campo => 'fecha',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => $fecha, key => 'N'),
 		        array( campo => 'anio',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $anio1, key => 'N'),
 		        array( campo => 'mes',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $mes1, key => 'N'),
 		        array( campo => 'dia',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$dia1, key => 'N'),
 		        array( campo => 'ip',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $IP_DATOS, key => 'N'),
 		        array( campo => 'url',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $url, key => 'N'),
 		        array( campo => 'usuario',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => $login, key => 'N'),
 		        array( campo => 'contador',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => $contador, key => 'N'),
 		        array( campo => 'matriz',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => $enlaces, key => 'N'),
 		        array( campo => 'fechau',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $fecha, key => 'N'),
 		        array( campo => 'city',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $country_code, key => 'N'),
 		        array( campo => 'region',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => $region, key => 'N'),
 		        array( campo => 'country',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $region, key => 'N')
 		    );
		    
 		    if ( $registro > 0 ){
  		        
 		      
 		        $this->_UpdateSQL('web02_visitas',$ATabla,$id);
 		        
 		    }else{
 		        
 		        $this->_InsertSQL('web02_visitas',$ATabla,'web02_visitas_idweb02_seq');
 		        
 		       
 		    }
		
		    
		     
 		  
 		    return $registroDato;
		}	
   /*MÃƒÂ©todo para cerrar coneciones*/
   public function klibera_sql(){
      switch ($this->tipo){
	     case 'mysql':     mysql_free_result($this->stmt);
						   break; 
 		 case 'postgress': pg_free_result($this->stmt);
 						   break;
	     case 'oracle':    $this->stmt = oci_parse($this->link  );
						   oci_execute(); 
 						   oci_free_statement ($this->stmt);
						   break;
		 break;
	  }
	   return true;
    }
    /*MÃƒÂ©todo para cerrar coneciones*/ 
    
   public function libera_cursor($stmt){
    
       switch ($this->tipo){
	     case 'mysql':     mysql_free_result($stmt);
						   break; 
 		 case 'postgress': pg_free_result($stmt);
 						   break;
	     case 'oracle':    oci_free_statement($stmt);
						   break;
		 break;
	  }
	  
	   return true;
	   
    }   
// menu para desplegar en la pagina web
/* funcion pone el menu desplegable en el sistema*/					
function KPmenu_00 (){

$sql_opcion = "SELECT idmenu,nombre,vinculo FROM web_menu  where activo = 'SI' and idmenu_padre = 0 order by orden";
$this->ejecutar($sql_opcion);	

while ($row = $this->array_busqueda()) { // despliega
 $idmenup = $row[0];
 $sql_val = "SELECT  count(activo) FROM web_menu  where activo = 'SI' and idmenu_padre = ".$this->sqlvalue_inyeccion($idmenup,true);
 $path = '';
 $row_valida = $this->ejecutar_array($sql_val);
 $row_fila = reset($row_valida);	
 
 if ( $row_fila == 0 )  {
     $url = htmlspecialchars($row["2"]);
	 if ($url=='-') {
	    $url = '#';
		echo '<li><a href="'.$url.'">'.htmlspecialchars($row["1"]).' </a></li>';
	 }else{
	   if ($url <> 'index'){
		 echo '<li><a href="'.$path.$url.'">'.htmlspecialchars($row["1"]).' </a></li>';
	    }else{
		  echo '<li><a href="index">'.htmlspecialchars($row["1"]).' </a></li>';
		}
	 }
 }else {
	$sql_sub = "SELECT  nombre,vinculo 
	              FROM web_menu
				  WHERE activo = 'SI' and idmenu_padre = ".$this->sqlvalue_inyeccion($idmenup,true)." order by orden";
 									
	$url = htmlspecialchars($row["2"]);
	if ($url=='-') {
	  $url = '#';
	  echo '<li><a href="'.$url.'">'.htmlspecialchars($row["1"]).' </a>';
	 }else{
		if ($url <> 'index'){
		  echo '<li><a href="'.$path.$url.'">'.htmlspecialchars($row["1"]).' </a></li>';
		}else{
		  echo '<li><a href="index">'.htmlspecialchars($row["1"]).' </a></li>';
		}
	  }
	  echo '<ul>';
	  $smtp = $this->ejecutar_stmt($sql_sub);	
	  while ($row2 = $this->array_busqueda_stmt($smtp)) { // despliega  
        $url1 = htmlspecialchars($row2["1"]); 
		if ($url1=='-') {
		   $url1 = '#';
		   echo '<li><a href="'.$url1.'">'.htmlspecialchars($row2["0"]).' </a></li>';
		 }else{
		   echo '<li><a href="'.$url1.'">'.htmlspecialchars($row2["0"]).' </a></li>';
		 }
  	    }
		  echo '</ul> ' ;  
	   }  
	   echo '</li>'; 
 	 } 
	 $this->klibera_sql();
 	return 1;
}	 
// menu para desplegar en la pagina web
/* funcion pone el menu desplegable en el sistema*/					
function KPmenu_01 (){

$sql_opcion = "SELECT idmenu,nombre,vinculo,clase  FROM web_menu  where activo = 'SI' and idmenu_padre = 0 order by orden";
$this->ejecutar($sql_opcion);	

while ($row = $this->array_busqueda()) { // despliega
 $idmenup = $row[0];
 $sql_val = "SELECT  count(activo) FROM web_menu  where activo = 'SI' and idmenu_padre = ".$this->sqlvalue_inyeccion($idmenup,true);
 $path = '';
 $row_valida = $this->ejecutar_array($sql_val);
 $row_fila = reset($row_valida);	
 
 if ( $row_fila == 0 )  {
     $url = htmlspecialchars($row["2"]);
	 if ($url=='-') {
	    $url = '#';
		echo '<li><a href="'.$url.'" title="" >'.htmlspecialchars($row["1"]).' </a></li>';
	 }else{
	   if ($url <> 'index'){
		 echo '<li><a href="'.$path.$url.'" title="" >'.htmlspecialchars($row["1"]).' </a></li>';
	    }else{
		echo '<li><a href="index" title=""  id="current"><i class="halflings white home"></i> '.htmlspecialchars($row["1"]).'</a></li>';
  		}
	 }
 }else {
	$sql_sub = "SELECT  nombre,vinculo,clase 
	              FROM web_menu
				  WHERE activo = 'SI' and idmenu_padre = ".$this->sqlvalue_inyeccion($idmenup,true)." order by orden";
 									
	$url = htmlspecialchars($row["2"]);
	if ($url=='-') {
	  $url = '#';
	  echo '<li><a href="'.$url.'" title="" >'.htmlspecialchars($row["1"]).' </a>';
	 }else{
		if ($url <> 'index'){
		$clase = trim(htmlspecialchars($row["3"]));
		 echo '<li><a href="'.$path.$url.'"><i class="'.$clase.'"></i> '.htmlspecialchars($row["1"]).'</a>';
  	
		}else{
		  echo '<li><a href="index" title=""   id="current"><i class="halflings white home"></i> '.htmlspecialchars($row["1"]).'</a></li>';
		}
	  }
	  echo '<ul>';
	  $smtp = $this->ejecutar_stmt($sql_sub);	
	  while ($row2 = $this->array_busqueda_stmt($smtp)) { // despliega  
        $url1 = htmlspecialchars($row2["1"]); 
		if ($url1=='-') {
		   $url1 = '#';
		   echo '<li><a href="'.$url1.'">'.htmlspecialchars($row2["0"]).' </a></li>';
		 }else{
		   echo '<li><a href="'.$url1.'">'.htmlspecialchars($row2["0"]).' </a></li>';
		 }
  	    }
		  echo '</ul> ' ;  
	   }  
	   echo '</li>'; 
 	 } 
	 $this->klibera_sql();
 	return 1;
}
// menu para desplegar en la pagina web
/* funcion pone el menu desplegable en el sistema*/					
function KPmenu_02 (){

$sql_opcion = "SELECT nombre,vinculo,clase  FROM web_menu  where activo = 'SI' and idmenu_padre = 0 order by orden";
$this->ejecutar($sql_opcion);	

	while ($row = $this->array_busqueda()) { // despliega
	 $nombre = $row[0];
	 $vinculo = $row[1];
	  echo '<a href="'.$vinculo.'">'.$nombre.'</a>';
		
	 
 
  }
	 
  
	 $this->klibera_sql();
 	return 1;
}
   /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function hoy(){
    switch ($this->tipo){
	     case 'mysql':    { 
    			 			  $hoy = date("Y-m-d");   
    		 				   break;
                          } 
 		 case 'postgress': {
    		 				   $hoy = date("Y-m-d");  
    						   $cadena = "to_date('".$hoy."','yyyy/mm/dd')";
    						   return  $cadena ;
     						   break;
                           }
	     case 'oracle':    {
    						   $hoy = date("Y-m-d");  
    						   $cadena = "to_date('".$hoy."','yyyy/mm/dd')";
    						   return  $cadena ; 
    						   break;
                           }
          break;                  
   }
    return  $cadena ;
  }
  /*MÃƒÂ©todo para ejecutar una sentencia sql una fecha*/
  public function fecha($fecha){
  			  
   switch ($this->tipo){
	     case 'mysql':     $hoy = date("Y-m-d");   
		 				   $cadena = "'".$hoy."'";
		 				   break;
 		 case 'postgress': $hoy = $fecha;  
						   $cadena = "to_date('".$hoy."','yyyy/mm/dd')";
						   return  $cadena ;
 						   break;
	     case 'oracle':    $hoy = $fecha;  
                           $cadena = "to_date('".$hoy."','yyyy/mm/dd')";
						   return  $cadena ;
     					   break;
		 break;
	  }
    return  $cadena ;
   }
  //libera resultado 
   public function kfree_sql($resultado){
       
      switch ($this->tipo){
	     case 'mysql':     mysql_free_result($resultado);
						   break; 
 		 case 'postgress': pg_free_result($resultado);
 						   break;
	     case 'oracle':    $this->stmt = oci_parse($resultado);
						   oci_execute(); 
 						   oci_free_statement ($resultado);
						   break;
		 break;
	  }
	   return true;
    }	
/////////////////////////////////////////////////////////////////
function fecha_hoy()   {
		 	 // Obtenemos y traducimos el nombre del dÃƒÂ­a
			$dia=date("l");
			if ($dia=="Monday") $dia="Lunes, ";
			if ($dia=="Tuesday") $dia="Martes, ";
			if ($dia=="Wednesday") $dia="MiÃƒÂ©rcoles, ";
			if ($dia=="Thursday") $dia="Jueves, ";
			if ($dia=="Friday") $dia="Viernes, ";
			if ($dia=="Saturday") $dia="Sabado, ";
			if ($dia=="Sunday") $dia="Domingo, ";
			
			// Obtenemos el nÃƒÂºmero del dÃƒÂ­a
			$dia2=date("d");
			
			// Obtenemos y traducimos el nombre del mes
			$mes=date("F");
			if ($mes=="January") $mes="Enero";
			if ($mes=="February") $mes="Febrero";
			if ($mes=="March") $mes="Marzo";
			if ($mes=="April") $mes="Abril";
			if ($mes=="May") $mes="Mayo";
			if ($mes=="June") $mes="Junio";
			if ($mes=="July") $mes="Julio";
			if ($mes=="August") $mes="Agosto";
			if ($mes=="September") $mes="Setiembre";
			if ($mes=="October") $mes="Octubre";
			if ($mes=="November") $mes="Noviembre";
			if ($mes=="December") $mes="Diciembre";
			
			// Obtenemos el aÃƒÂ±o
			$ano=date("Y");
 			// Imprimimos la fecha completa
 			$codigo_usuario =  "$dia $dia2 de $mes de $ano";
			return $codigo_usuario;
 }	
function clave_inyeccion_grid() {
// Modificamos las variables pasadas por URL
 return 'cmkDAK4qoP5BGg1wAjfeM0pA2';
}
 
 /// contrador de visitas
  	 /*------------------------------------------------------*/			
 function KPtotal_contador($ventana) 
{
  			  $fecha = date("Y/m/d");
			  $date  = "'".$fecha."'";
			  $IP_DATOS =   $_SERVER['REMOTE_ADDR'];
			  /*	  $trozos = explode("/", $fecha,3); 
		       $anio1 = $trozos[0];	
			  $mes1 =  (int) $trozos[1]; 
			  $dia1 =  (int) $trozos[2]; 		
			  $URL =   "'".$ventana."'";*/
 				
 switch ($this->tipo){
  case 'mysql':{
 	$sql = "SELECT count(IDWEB02) as numero 
			   			 FROM  web02_visitas "; 
					//	 where url='".$ventana."' and fecha =".$date." and IP ='".$IP_DATOS."'";		
							
  	$resultado = mysql_query($sql);
	$row = mysql_fetch_row($resultado );
	$count = $row[0];		
	mysql_free_result($resultado);
	break;
  }
  case 'postgress':  {
	$sql = "SELECT count(IDWEB02) as numero 
			   			 FROM  WEB02_VISITAS  
						 where url='".$ventana."' and fecha =".$date." and IP ='".$IP_DATOS."'";
						 
	$stmt = pg_query($this->link, $sql);
	$row =  pg_fetch_row($stmt);
	$count = $row[0];		
	pg_free_result($stmt);							 
	break;
  }
  case 'oracle':  {
   $sql = "SELECT count(IDWEB02) as numero 
			   			 FROM  WEB02_VISITAS  
						 where url='".$ventana."' and fecha =".$date." and IP ='".$IP_DATOS."'";
						 
   $stid = oci_parse($this->link, $sql);
   oci_execute($stid);
   $row = oci_fetch_row($stid);
   $count = $row[0];	
   oci_free_statement($stid);
   break;
  }						
  break;
}	
  return $count ;
}	

///////////////////////////////////   
/// contrador de visitas
/*------------------------------------------------------*/			
function xml_actualiza($localhost,$user,$password,$db,$dbType) {
 
 
//$xml=new DomDocument("1.0","UTF-8");
    /*
$raiz=$xml->createElement("coneccion");
$raiz=$xml->appendChild($raiz);

primera banda-------------------------- 
	$banda=$xml->createElement("user");
	$banda=$raiz->appendChild($banda);
	
	$host=$xml->createElement("host", $localhost);
	$host=$banda->appendChild($host);
	
	$user=$xml->createElement("user", $user);
	$user=$banda->appendChild($user);
	
	$password=$xml->createElement("password", $password);
	$password=$banda->appendChild($password);

	$db=$xml->createElement("db", $db);
	$db=$banda->appendChild($db);

	$dbType=$xml->createElement("dbType", $dbType);
	$dbType=$banda->appendChild($dbType);
  			

 guardar xml--------------------------------*/  
/*  $xml->formatOut=true;
  $strings_xml=$xml->saveXML();
  $archivo = '../kconfig/db-user.xml';
  $xml->save($archivo) ;*/
  ////////////////////
 }
 /// contrador de visitas
/*------------------------------------------------------*/			
 public function _refd($clave){
  //$clave = generar_clave();
  //$clave = str_rot13(base64_encode($clave));
  $clave = trim($clave);
  $clave = base64_decode($clave);
  $clave = substr($clave,2,50);
  return trim($clave);
}
  /*MÃƒÂ©todo para ejecutar una sentencia sql*/
   public function numero($monto_in,$decimal = 2){
    
      switch ($this->tipo){
	     case 'mysql':     return $monto_in;
						   break; 
 		 case 'postgress': return $monto_in;
						   break;
	     case 'oracle':    
                          {
	                       $monto_in = number_format($monto_in, $decimal, ',', '');
                          return $monto_in;
						  break;
                         
                           }
		 break;
	  }
    }
   /// contrador de visitas
  	 /*------------------------------------------------------*/			
function KPvisitas($ventana,$ancho) 
		 {
		   
			 
 	 
		   return 0;
		}	


//-----lista con base de datos
function combodb($sql,$variable,$datos){	

  $tipo = $this->retorna_tipo();

  $resultado = $this->ejecutar($sql);
	 
  
 
				$objeto_texto = '';
				if ($tipo ==  'mysql'){
					while ($lp_row = mysql_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'postgress'){
					while($lp_row=pg_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'oracle'){
					while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
					{
								  $val     = $lp_row['CODIGO'];
								  $caption = $lp_row['NOMBRE'];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				 oci_free_statement($resultado);
				}
				 
				return  $objeto_texto ;	  
				 
 }
 
 //-----------------------------------------------------------------------------------------
 //-----------------------------------------------------------------------------------------
 
 public function _InsertSQL($tabla,$array,$secuencia,$debug=0){
 	 
 	 
 
 		$sql = $this->JqueryInsertA($tabla,$array,$secuencia);
  
 		if ( $debug == 1){
 		    echo $sql;
 		}
 	 
 		$stmt = pg_query($this->link,  $sql  );
 		
 		
 		$this->error = pg_result_error($stmt);
 		

 		if ($secuencia == '-') {
 		    
 		    $id = $this->ultima_secuencia($tabla);
 		    
 		}
 		else{
 		    if (is_numeric($secuencia)){
 		        
 		        $id = $secuencia;
 		        
 		    }else{
 		        if($secuencia== 'NO') {
 		            $id = 0;
 		        }
 		        else{
 		            $id = $this->ultima_secuenciaP($secuencia);
 		        }
 		    }
 	  }
 		
 	 
 		return   $id ;
 
  
 }
 
 public function _InsertSQL_prueba($tabla,$array,$secuencia){
     
     
     
     $sql = $this->JqueryInsertA($tabla,$array,$secuencia);
     
     
     echo $sql;
     
     $stmt = pg_query($this->link,  $sql  );
     
     
     $this->error = pg_result_error($stmt);
     
     
     if ($secuencia == '-') {
         $id = $this->ultima_secuencia($tabla);
     }
     else{
         if (is_numeric($secuencia)){
             
             $id = $secuencia;
             
         }else{
             if($secuencia== 'NO') {
                 $id = 0;
             }
             else{
                 $id = $this->ultima_secuenciaP($secuencia);
             }
         }
     }
     
     /*
      switch ($this-e>tipo){
      
      
      case 'postgress': {
      
      
      
      $stmt = pg_query($this->link,  $sql  );
      
      $this->error = pg_result_error($stmt);
      
      if ($secuencia == '-') {
      $id = $this->ultima_secuencia($tabla);
      }
      else
      {
      
      if (is_numeric($secuencia))
      {
      $id = $secuencia;
      }
      else
      {
      if($secuencia== 'NO') {
      $id = 0;
      }
      else{
      $id = $this->ultima_secuenciaP($secuencia);
      }
      
      
      }
      
      
      }
      break;
      
      }
      case 'oracle':    {
      
      $stmt = oci_parse($this->link, $sql  );
      
      oci_execute($stmt);
      
      oci_free_statement($stmt);
      
      $id = $this->secuencia;
      
      break;
      }
      
      break;
      
      }
      
      */
     return   $id ;
     
     
 }
 
 /*MÃƒÂ©todo para ejecutar una sentencia sql*/
 public function _UpdateSQL($tabla,$array,$id,$debug='0'){
 
 	
 	$sql = $this->JqueryUpdateA($tabla,$array,$id);
 
 	if ( $debug == '1'){
 	    echo $sql;
 	}
 	
 
 	
 	$stmt = pg_query($this->link, $sql);
 	
 	$this->error = pg_result_error($stmt);
 
 	return 1;
 	
 }
 public function JqueryUpdateA($tabla,$UpdateQuery,$id){
 	
 	$longitud = count($UpdateQuery);
 
 	 
 	// columnas
 	
 	$sqlColumnas = 'UPDATE   '.$tabla.' SET  ';
 	
 	$sqlColumnasI = '';
 	
 	$sqlColumnask = '';
 	
 	for ($row = 0; $row <= $longitud; $row++)
 	{
 		
 		$cadena = trim($UpdateQuery[$row][campo]) ;
 		
 		if($UpdateQuery[$row][key] == 'S') {
 			
 			$sqlColumnask = $cadena;
 			
 		}
 		
 		
 		
 		if ( $UpdateQuery[$row][edit] == 'S'){
 			
 			if ( $UpdateQuery[$row][valor] == '-'){
 				$valor = @$_POST[$UpdateQuery[$row][campo]];
 			}else{
 				$valor = $UpdateQuery[$row][valor];
 			}
 			
 		  
 			if($UpdateQuery[$row][tipo] == 'VARCHAR2') {
 				
 				$cadenav = $this->sqlvalue_inyeccion(trim($valor), true);
 				
 				$valorDato = $cadena.'= '.$cadenav.',';
 				
 			}
 			
 			if($UpdateQuery[$row][tipo] == 'NUMBER') {
 				
 				//   		$variable = $this->numero($valor,2);
 				
 				$variable = ($valor);
 				
 				
 				$cadenav = $this->sqlvalue_inyeccion(($variable), true);
 				
 				$valorDato = $cadena.'='.$cadenav.',';
 				
 			}
 			
 			if($UpdateQuery[$row][tipo] == 'DATE') {
 				
 				$cadenav			= $this->fecha($valor);
 				
 				$valorDato = $cadena.'='.$cadenav.',';
 				
 			}
 			
 			if($UpdateQuery[$row][tipo] == 'TIME') {
 			    
 			    $cadenav			= 'current_timestamp';
 			    
 			    $valorDato = $cadena.'='.$cadenav.',';
 			    
 			}
 			
 			$sqlColumnasI = 	$sqlColumnasI.$valorDato;
 			
 		}
 		
 		$longitudV = strlen(trim($sqlColumnasI));
 		
 		$valorEdicion = substr(trim($sqlColumnasI), 0,$longitudV - 1);
 		
 	}
 	
 	
 	$sql =  $sqlColumnas.$valorEdicion.' WHERE  '.$sqlColumnask.'= '. $this->sqlvalue_inyeccion(trim($id), true);
 	
 	return $sql;
 }
 //---------------------------------------------------------------------------
 //---------------------------------------------------------------------------
 
 public function JqueryInsertA($tabla,$UpdateQuery,$secuencia){
 	 
 	$longitud = count($UpdateQuery);
   	 
 	// secuencia
 	if ($secuencia =='-'){
 		$id = 0;
 	
 	}else{
 		
 		if ($this->tipo == 'oracle'){
 			$id = $this->oracle_secuencia($secuencia);
 			$this->secuencia = $id;
 		}
 		
 		if ($this->tipo == 'postgress'){
 		    if ($secuencia == 'NO' ){
 		        $id = 0;
 		        $this->secuencia = $id;
 		    }else{
 		        $id = $secuencia;
 		        $this->secuencia = $id;
 		    }
 		 
 		}
 		
 	}
 
 	// columnas
 	 
 	$sqlColumnas = 'INSERT INTO '.$tabla.' (';
 	 
 	$sqlCol= '';
 	 
 	$valorDato ='';
 
 	 
 	for ($row = 0; $row <= $longitud; $row++)
 	{
 
 					$cadena = trim($UpdateQuery[$row][campo]) ;
 		 
  					if ( $UpdateQuery[$row][add] == 'S'){
 
						 			if ( $UpdateQuery[$row][valor] == '-'){
						 							$valor = @$_POST[$UpdateQuery[$row][campo]];
						 			}else{
						 							$valor = $UpdateQuery[$row][valor];
						 			}
				 			
  									$sqlCol = $sqlCol.$cadena.',';
 
 									//--- para valores
 
						 			if($UpdateQuery[$row][tipo] == 'VARCHAR2') {
						 
						 				$cadenav = $this->sqlvalue_inyeccion(trim($valor), true);
						 
						 				$valorDato =$valorDato.$cadenav.',';
						 
						 			}
 
						 			if($UpdateQuery[$row][tipo] == 'NUMBER') {
						 
									 				if($UpdateQuery[$row][key] == 'S') {
									 					
												 					if ($id == 0){
												 						$id = $this->MaxTabla($tabla,$cadena);
												 					}
									 						
												 					$this->secuencia = $id;
												 						
												 					$cadenav = $this->sqlvalue_inyeccion(($id), true);
												 
												 					$valorDato =$valorDato.$cadenav.',';
									 				}
									 				else{
									 					$variable = $this->numero($valor,2);
									 						
									 					$cadenav = $this->sqlvalue_inyeccion(($variable), true);
									 						
									 					$valorDato =$valorDato.$cadenav.',';
									 				}
 						 			}
 									//--------------------------------------------------------------------------------
					 			if($UpdateQuery[$row][tipo] == 'DATE') {
					 
					 				$cadenav			= $this->fecha($valor);
					 
					 				$valorDato =$valorDato.$cadenav.',';
					 
					 			}
					 			
					 			if($UpdateQuery[$row][tipo] == 'TIME') {
					 			    
					 			    $cadenav			= 'current_timestamp';
					 			    
					 			    $valorDato =$valorDato.$cadenav.',';
					 			    
					 			}
 				
 				}
 
 	}
 
 	$longitudV = strlen(trim($sqlCol));
 	 
 	$Columnas = substr(trim($sqlCol), 0,$longitudV - 1).') values (';
 	 
 	$longitudV = strlen(trim($valorDato));
 
 	$ColumnasD = substr(trim($valorDato), 0,$longitudV - 1).')';
 	 
 
 	$sql = $sqlColumnas.$Columnas.	$ColumnasD ;
 
  	 
 	return $sql;
 }
 
 /**
  Funcion para ejecutar sentecia SQL
  tabla: todas
  filtro: todas
  @return (resultado de la consulta )
  **/
 public function DivMsg($accion,$key,$id,$tipo,$estado='S')
 {
 
 	echo '<script type="text/javascript">';
 
 	echo  '$("#action").val("'.$accion.'");';
 
 	echo  '$("#'.$key.'").val("'.$id.'");';
 
 	echo '</script>';
 
 
 	if ($tipo == 0){
 		 
 	    	if ($accion == 'editar')
 						$resultado = '<img src="../kimages/kedit.png"/>&nbsp;<b>Editar registro? </b>';
 			if ($accion == 'del')
 					    $resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro? </b>';
 	}
 	 
 	if ($tipo == 1){
 		$resultado = '<img src="../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b> ';
 	}
 
 	return $resultado;
 }
 
 public function validaDato($tabla,$campo,$valor){
 
 
 	$sql = 'select  count(*)  as VALIDA  from '.$tabla.' where  '.$campo.' ='. $this->sqlvalue_inyeccion($valor,true);
 
 
 
 	switch ($this->tipo){
 
 		case 'mysql':     {
 			$this->stmt = mysql_query($sql,$this->link);
 			$this->array=mysql_fetch_array($this->stmt);
 			$valor = $this->array[0];
 			
 			return $valor  ;
 			break ;
 		}
 		case 'postgress': {
 			$this->stmt = pg_query($this->link, $sql);
 			$this->array = pg_fetch_array($this->stmt);
 			$valor = $this->array[0];
 			
 			return $valor  ;
 			break;
 		}
 		case 'oracle':    {
 
 			$this->stmt = oci_parse($this->link, $sql  );
 				
 			oci_execute($this->stmt);
 			 
 			$this->array = oci_fetch_array($this->stmt);
 			 
 			oci_free_statement($this->stmt);
 
 			$valor = $this->array[0];
 			
 			return $valor  ;
 			 
 			break;
 		}
 
 		break;
 			
 	}
 	return 0;
 }
 //-------------------------------------------------------------------------------
 public function audita($transaccion,$accion,$modulo,$texto,$campo='none'){
     
     $sesion 	 =  trim($_SESSION['email']);
     
     $hoy 	     =  date('Y-m-d');
     
     $timestamp  = date('H:i:s');
     
     $ATabla = array(
         array( campo => 'id_audita',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
         array( campo => 'transaccion',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $transaccion, key => 'N'),
         array( campo => 'accion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $accion, key => 'N'),
         array( campo => 'modulo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $modulo, key => 'N'),
         array( campo => 'fecha',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
         array( campo => 'texto',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => trim($texto), key => 'N'),
         array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
         array( campo => 'fmodificacion',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => $hoy, key => 'N'),
         array( campo => 'hora',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $timestamp, key => 'N'),
         array( campo => 'tabla',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $campo, key => 'N')
     );
     
     $this->_InsertSQL('web_auditoria',$ATabla,'web_auditoria_id_audita_seq');
 
     
 }
 //----------------
 public function audita_tthh($transaccion,$mensaje){
     
    $sesion 	 =  trim($_SESSION['email']);
    
    $hoy 	     =  date('Y-m-d');
    
    $timestamp  = date('H:i:s');

   
     
    $ATabla = array(
        array( campo => 'id_chat',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
         array( campo => 'sesion',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $sesion , key => 'N'),
        array( campo => 'modulo',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => 'talento', key => 'N'),
        array( campo => 'estado',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => 'X', key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor => $hoy , key => 'N'),
        array( campo => 'mensaje',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $mensaje, key => 'N'),
        array( campo => 'alerta',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '1', key => 'N'),
        array( campo => 'agenda',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '1', key => 'N'),
        array( campo => 'tipo',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => 'MENSAJE', key => 'N'),
        array( campo => 'hora',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $timestamp , key => 'N'),
        array( campo => 'para',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $transaccion, key => 'N'),
        array( campo => 'registro',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>  $_SESSION['ruc_registro'], key => 'N'),
    );
    
    $this->_InsertSQL('web_chat_directo',$ATabla,'web_chat_directo_id_chat_seq');

    
}
 //-------------------------------------------------------------------------------
 //-------------------------------------------------------------------------------
 //-------------------------------------------------------------------------------
 function eliminar_simbolos($string){
     
     $string = trim($string);
     
     $string = str_replace(
        array('Á', 'É', 'Í', 'Ó', 'Ú'),
        array('A', 'E', 'I', 'O', 'U'),
        $string
        );
        
        $string = str_replace(
        array('á', 'é', 'í', 'ó', 'ú'),
        array('a', 'e', 'i', 'o', 'u'),
        $string
        );

     $string = str_replace(
         array('Ã¡', 'Ã ', 'Ã¤', 'Ã¢', 'Âª', 'Ã�', 'Ã€', 'Ã‚', 'Ã„'),
         array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
         $string
         );
     
     
     
     $string = str_replace(
         array('Ã©', 'Ã¨', 'Ã«', 'Ãª', 'Ã‰', 'Ãˆ', 'ÃŠ', 'Ã‹'),
         array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
         $string
         );
     
     $string = str_replace(
         array('Ã­', 'Ã¬', 'Ã¯', 'Ã®', 'Ã�', 'ÃŒ', 'Ã�', 'ÃŽ'),
         array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
         $string
         );
     
     $string = str_replace(
         array('Ã³', 'Ã²', 'Ã¶', 'Ã´', 'Ã“', 'Ã’', 'Ã–', 'Ã”'),
         array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
         $string
         );
     
     $string = str_replace(
         array('Ãº', 'Ã¹', 'Ã¼', 'Ã»', 'Ãš', 'Ã™', 'Ã›', 'Ãœ'),
         array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
         $string
         );
     
     $string = str_replace(
         array('Ã±', 'Ã‘', 'Ã§', 'Ã‡'),
         array('n', 'N', 'c', 'C',),
         $string
         );
     
     $string = str_replace(
         array("\\", "Â¨", "Âº", "-", "~",
             "#", "@", "|", "!", "\"",
             "Â·", "$", "%", "&", "/",
             "(", ")", "?", "'", "Â¡",
             "Â¿", "[", "^", "<code>", "]",
             "+", "}", "{", "Â¨", "Â´",
             ">", "< ", ";", ",", ":",
             ".", " "),
         ' ',
         $string
         );
     return $string;
 } 
 
 
 
}
?>