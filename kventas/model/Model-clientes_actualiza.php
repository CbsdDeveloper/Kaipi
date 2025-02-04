<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
	//creamos la variable donde se instanciar la clase "mysql"
	
	private $obj;
	private $bd;
	
	private $ruc;
	public  $sesion;
	public  $hoy;
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
		
		$this->ruc       =     $_SESSION['ruc_registro'];
		
		$this->sesion 	 =     $_SESSION['email'];
		
		$this->hoy 	     =     date("Y-m-d");     
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->ATabla = array(
				array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
				array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'idciudad',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'SN',   filtro => 'N',   key => 'N'),
				array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => '0000',   filtro => 'N',   key => 'N'),
				array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'N',   valor => 'xx@info.com',   filtro => 'N',   key => 'N'),
				array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N'),
				array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
		         array( campo => 'registro',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
		        array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'C',   filtro => 'N',   key => 'N'),
				array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
				array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
		);
		
		$this->tabla 	  	  = 'par_ciu';
		
 
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function valida( $id){
		 
	    
	    $AResultado = $this->bd->query_array('par_ciu',
	                                         'count(idprov) as nn', 
	        'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true));
	    
	    return $AResultado["nn"];
		
	}
   
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( ){
		
		
	    $id =     trim($_POST["idprov"]);
	    
	    $bandera = 0;
	    
	    if ($id==('NO_VALIDO')){
	        $bandera = 1;
	    }
	    
	    if ($id==('YA_EXISTE')){
	        $bandera = 1;
	    }
 		 
	    if ( $bandera == 0){
	        $this->bd->_InsertSQL($this->tabla,$this->ATabla, $id );
	        $result = $this->div_resultado('editar',$id,1);
	    }else {
	        $result = '<b> IDENTIFICACION NO VALIDA O EL USUARIO YA EXISTE  </b>';
	    }
		
			
		 
	 
	 
	 	echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id,$razon,$correo ){
		
		
		$lon = strlen($id);
		if ($lon == 9 ){
			$id = '0'.$id;
		}
		if ($lon == 12 ){
			$id = '0'.$id;
		}
		
		$this->ATabla[1][valor] =  $razon;
		$this->ATabla[5][valor] =  $correo;
		
  		$this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
 
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
if (isset($_GET['idprov']))	{
	
 
    $okCliente='';
    
    $id       = trim($_GET['idprov']);
    
    if (!empty($id))  {
        
        $okCliente = $gestion->valida($id);
        
        
        if ($okCliente > 0)	{
            
            $razon  =  $_GET['razon'];
            $correo =  $_GET['correo'];
            
            $gestion->edicion($id,$razon,$correo);
            $okCliente = 'Dato Actualizado: '.$id;
        }
    

    }
    
    echo $okCliente;
    
    
}

 



?>
 
  