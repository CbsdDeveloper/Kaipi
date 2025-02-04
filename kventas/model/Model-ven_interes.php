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
		    array( campo => 'idvengestion',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
		    array( campo => 'idprov',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'razon',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'estado',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'medio',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'canal',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'sesion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
		    array( campo => 'novedad',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
		    array( campo => 'producto',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'porcentaje',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N')
				 
		);
		
		$this->tabla 	  	  = 'ven_cliente_seg';
		
		$this->secuencia 	     = 'ven_cliente_seg_idvengestion_seq';
		
	}
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function div_resultado($accion,$id,$tipo){
		 
	    return $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
		
	}
 	//--------------------------------------------------------------------------------
	//--- busqueda de por codigo para llenar los datos
	//--------------------------------------------------------------------------------
	function consultaId($accion,$id ){
		
 		
		$qquery = array( 
		    array( campo => 'idvengestion',valor => $id,filtro => 'S', visor => 'N'),
 		    array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'medio',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'canal',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'N'),
		    array( campo => 'producto',valor => '-',filtro => 'N', visor => 'S'),
		    array( campo => 'porcentaje',valor => '-',filtro => 'N', visor => 'N')
 		);
		
		$datos = $this->bd->JqueryArrayVisorObj('ven_cliente_seg',$qquery,0 );
 		
		$result =  $this->div_resultado($accion,$id,0);
		
		echo  $result;
	}
	
 
	
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	
	function xcrud($action,$id){
		
		
		// ------------------  agregar
		if ($action == 'add'){
			
			$this->agregar();
			
		}
		// ------------------  editar
		if ($action == 'editar'){
			
			$this->edicion($id );
			
		}
		// ------------------  eliminar
		if ($action == 'del'){
			
			$this->eliminar($id );
			
		}
		
	}
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar( ){
 
 	 	    
	/*    $MATRIZ = array(
	        '0'  => 'No esta interesado',
	        '3' => 'Potencial Cliente',
	        '4' => 'Interesado En espera',
	        '5'  => 'Interesado sin confirmar',
	        '6'  => 'Interesado confirmado'
	    );
	    
	    */
	    
		$procesado = @$_POST["estado_proceso"];
		$idprov    = @$_POST["idprov"];
		$producto = @$_POST["producto"];
		$novedad = @$_POST["novedad"];
		
		$razon    = @$_POST["razon_nombre"];
		
	
		
		if ($procesado == '0'){
		    $porcentaje = 0;
		    $mov = 'No esta interesado';
		}
		elseif($procesado == '3'){
		    $porcentaje = 5;
		    $mov = 'Potencial Cliente';
		}
		elseif($procesado == '4'){
		    $porcentaje = 10;
		    $mov = 'Interesado En espera';
		}
		elseif($procesado == '5'){
		    $porcentaje = 10;
		    $mov = 'Interesado sin confirmar';
		}
		elseif($procesado == '6'){
		    $porcentaje = 25;
		    $mov = 'Interesado confirmado';
		}
		 
		
		
		 $this->ATabla[10][valor] =  $porcentaje	 ;
		 
		 $this->ATabla[3][valor] =  $procesado	 ;
		 
 		
 
		      
		 $this->ATabla[1][valor] =  trim($idprov)	 ;
		 
		 $this->ATabla[2][valor] =  trim($razon)	 ;
		 
		 
		 
		 $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
  	     
 	     $result = $this->div_resultado('editar',$id,1);
			
 	     //--- en el caso de no estar autorizado editamos como cliente y sacamos de la lista
 	     
 	     if ( $procesado == '0'){
 	         $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion($procesado,true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            id_campana='.$this->bd->sqlvalue_inyeccion(0,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
 	     }
 	     else {
 	         $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion($procesado,true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
 	     }
  	        
   	         
 	      
 	     
 	     $this->bd->ejecutar($sql);
 	     
 	     
		echo $result;
		
	}
	//--------------------------------------------------------------------------------
	//--- edicion de registros
	//--------------------------------------------------------------------------------
	function edicion($id  ){
		
	    
	    $procesado = @$_POST["estado_proceso"];
	    $idprov = @$_POST["idprov"];
	    $producto = @$_POST["producto"];
	    $novedad = @$_POST["novedad"];
	    
	    $razon    = @$_POST["razon_nombre"];
	    
	    if ($procesado == '0'){
	        $porcentaje = 0;
	        $mov = 'No esta interesado';
	    }
	    elseif($procesado == '3'){
	        $porcentaje = 5;
	        $mov = 'Potencial Cliente';
	    }
	    elseif($procesado == '4'){
	        $porcentaje = 10;
	        $mov = 'Interesado En espera';
	    }
	    elseif($procesado == '5'){
	        $porcentaje = 10;
	        $mov = 'Interesado sin confirmar';
	    }
	    elseif($procesado == '6'){
	        $porcentaje = 25;
	        $mov = 'Interesado confirmado';
	    }
	    
	        
	        $this->ATabla[10][valor] =  $porcentaje	 ;
	        
	        $this->ATabla[3][valor] =  $procesado	 ;
	        
	        
	        $this->ATabla[1][valor] =  trim($idprov)	 ;
	        
	        $this->ATabla[2][valor] =  trim($razon)	 ;
	        
	        
		        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);

		        //--- en el caso de no estar autorizado editamos como cliente y sacamos de la lista
		        if ( $procesado == '0'){
		            $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion($procesado,true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            id_campana='.$this->bd->sqlvalue_inyeccion(0,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
		        }
		        else {
		            $sql = 'update ven_cliente
                        set estado='.$this->bd->sqlvalue_inyeccion($procesado,true). ',
                            proceso='.$this->bd->sqlvalue_inyeccion($mov,true). ',
                            detalle='.$this->bd->sqlvalue_inyeccion($novedad,true). '
                        where id_campana  <> 0 and  idprov= '.$this->bd->sqlvalue_inyeccion(trim($idprov),true);
		        }
		        
		        $result =$this->div_resultado('editar',$id,1);
		 
 
		
		echo $result  ;
	}
	
	//--------------------------------------------------------------------------------
	//--- eliminar de registros
	//--------------------------------------------------------------------------------
	function eliminar($id ){
		
	   /*	 
 				    $sql = 'delete from par_ciu  where idprov='.$this->bd->sqlvalue_inyeccion($id, true);
 					$this->bd->ejecutar($sql);
 					
	                $result =  $this->bd->resultadoCRUD('ELIMINADO','',$id,'');
	    
	                echo $result;
		
		*/
 
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
	
	$accion           = $_GET['accion'];
 	$id               = $_GET['idvengestion'];
 	$idcliente        = $_GET['idcliente'];
 	
 	if ($accion == 'editar'){
  
 	        $gestion->consultaId($accion,$id);
 	        
 	}else{
 	    
 	    $result = '<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO TAREA DE GESTION</b>';
 	    
 	    echo $result;
 	}
 
}

//------ grud de datos insercion
if (isset($_POST["action"]))	{
	
	$action = @$_POST["action"];
 	$id =     @$_POST["idvengestion"];
 	
    $gestion->xcrud(trim($action),$id);
	
}



?>
 
  