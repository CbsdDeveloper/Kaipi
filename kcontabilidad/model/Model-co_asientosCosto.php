<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  trim($_SESSION['email']);
		$this->hoy 	     =  date('Y-m-d');
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar($idasientodetCosto,$codigo1,$codigo2,$codigo3,$codigo4){
		
	    
	    $x = $this->bd->query_array('co_asiento',   // TABLA
	        '*',                        // CAMPOS
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idasientodetCosto,true) // CONDICION
	        );
	    
	    $fecha = $x['fecha'];
	    $anio  = $x['anio'];
	    
 
	    $y = $this->bd->query_array('co_asientod',   // TABLA
	        'sum(debe) as total',                        // CAMPOS
	        'id_asiento='.$this->bd->sqlvalue_inyeccion($idasientodetCosto,true) // CONDICION
	        );
	    
	    $total = $y['total'];
	    
	    $ATabla = array(
	        array( campo => 'id_costo',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
	        array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idasientodetCosto, key => 'N'),
	        array( campo => 'codigo1',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => $codigo1, key => 'N'),
	        array( campo => 'codigo2',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => $codigo2, key => 'N'),
	        array( campo => 'codigo3',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => $codigo3, key => 'N'),
	        array( campo => 'codigo4',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '0', key => 'N'),
	        array( campo => 'costo',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => $codigo4, key => 'N'),
	        array( campo => 'fecha',tipo => 'DATE',id => '7',add => 'S', edit => 'S', valor => $fecha, key => 'N'),
	        array( campo => 'anio',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor =>$anio, key => 'N'),
	        array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
	        array( campo => 'creacion',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
	    );
	    
	    if ( $codigo4 > $total ){
	        $guardarCosto = '<br><b>EL COSTO INGRESADO ES MAYOR QUE EL VALOR DEL ASIENTO... </b>';
	    }else{
	        $this->bd->_InsertSQL('co_costo',$ATabla, 'co_costo_id_costo_seq');
	        $guardarCosto = '<br><b>DATO ACTUALIZADO PARA EL CONTROL DE COSTOS </b>';
	    }
	   
	    
	    
	   
	    
	    echo $guardarCosto;
		
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
if (isset($_GET['id_asiento']))	{
	
    $idasientodetCosto   = $_GET['id_asiento'];
	$codigo1   = $_GET['codigo1'];
	$codigo2   = $_GET['codigo2'];
	$codigo3   = $_GET['codigo3'];
	$codigo4   = $_GET['codigo4'];
 	  
	$gestion->agregar($idasientodetCosto,$codigo1,$codigo2,$codigo3,$codigo4);
 
		
}

 


?>
 
  