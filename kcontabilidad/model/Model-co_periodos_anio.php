<?php 
session_start();   
require "../../kconfig/Db.class.php";   /*Incluimos el fichero de la clase Db*/
require "../../kconfig/Obj.conf.php"; /*Incluimos el fichero de la clase objetos*/
    
	$bd	     = new Db ;
	$obj     = 	new objects;
	 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
    $ruc_registro     = $_SESSION['ruc_registro'];
      
    $year_now = date ("Y");
    
    $result = '';
    
    $tabla 	  		    = 'co_periodo';
    
    $sesion 	 =     $_SESSION['email'];
    
    $hoy 	     =      date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
    
    
    for ($i = 1; $i <= 12; $i++) {
        
        
        $x = $bd->query_array('co_periodo',
                              'count(*) as nn', 
                              'registro='.$bd->sqlvalue_inyeccion($ruc_registro,true) . ' and '.
                              'anio='.$bd->sqlvalue_inyeccion($year_now,true) . ' and '.
                              'mes='.$bd->sqlvalue_inyeccion($i,true) 
            );
        
        if ( $x['nn']  > 0 ){
            $result = ' Periodo ya generado ';
        }else{
            
            $mesc = $obj->var->_mes($i);
            
            $ATabla = array(
                array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                array( campo => 'mes',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'N',   valor => $i,   filtro => 'N',   key => 'N'),
                array( campo => 'anio',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => $year_now,   filtro => 'N',   key => 'N'),
                array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N'),
                array( campo => 'creacion',   tipo => 'DATE',   id => '4',  add => 'S',   edit => 'N',   valor => $hoy,   filtro => 'N',   key => 'N'),
                array( campo => 'sesionm',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
                array( campo => 'modificacion',   tipo => 'DATE',   id => '6',  add => 'S',   edit => 'S',   valor => $hoy,   filtro => 'N',   key => 'N'),
                array( campo => 'mesc',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => $mesc,   filtro => 'N',   key => 'N'),
                array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'abierto',   filtro => 'N',   key => 'N'),
                array( campo => 'registro',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => $ruc_registro,   filtro => 'N',   key => 'N'),
            );
            
           
             $bd->_InsertSQL($tabla,$ATabla,'-');
             
             $result = ' Periodo ya generado con exito ';
            
            //--------------------------------
        }
        
    }
    
    
    echo $result;
    
?>