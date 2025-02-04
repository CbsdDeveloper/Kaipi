<?php
session_start( );
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';
include('phpqrcode/qrlib.php'); 
 
class ReportePdf{

	public $obj ;
	public $bd ;
	public $ruc;
	public $empleado;
	public $Registro;
	public $sesion;
	
	public $idprov;
	

	//Constructor de la clase
	function ReportePdf(){
		//inicializamos la clase para conectarnos a la bd
		$this->obj     = 	new objects;
		
		$this->bd     = 	new Db;
	
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 = $_SESSION['login'] ;
		
		
		
	}
 
	//------------------------------------
	function _detalle_rubros($codigo,$codig_pago){
		
		//--- beneficiario
 
	    $sql_detalle = 'SELECT *
 				   FROM rentas.view_ren_detalles
				  where id_renpago = '.$this->bd->sqlvalue_inyeccion( $codig_pago,true).' and 
				  		id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($codigo, true);
	        
	    
	        
	    $stmt_detalle = $this->bd->ejecutar($sql_detalle);
	    
	    return $stmt_detalle;
 
	}
	 
	 function consultaGlp($idtramite){
		

		$sql= "select *from rentas.ren_tramites_var where id_rubro_var='53' and  id_ren_tramite=".$idtramite;

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $variables['placa']=$col['valor_variable'];
		    }


		$sql= "select *from rentas.ren_tramites_var where id_rubro_var='54' and  id_ren_tramite=".$idtramite;
		

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $variables['marca']=$col['valor_variable'];
		    }


		$sql= "select *from rentas.ren_tramites_var where id_rubro_var='55' and  id_ren_tramite=".$idtramite;

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $variables['color']=$col['valor_variable'];
		    }


		$sql= "select *from rentas.ren_tramites_var where id_rubro_var='60' and  id_ren_tramite=".$idtramite;

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $variables['cilindraje']=$col['valor_variable'];
		    }


		 
		 	$sql= "select *from rentas.ren_tramites_var where id_rubro_var='128' and  id_ren_tramite=".$idtramite;

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $variables['desde']=$col['valor_variable'];
		    }


		 	$sql= "select *from rentas.ren_tramites_var where id_rubro_var='129' and  id_ren_tramite=".$idtramite;

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $variables['hasta']=$col['valor_variable'];
		    }

		 
		 
		 

		$sql= "select *from rentas.ren_tramites_var where id_rubro_var='59' and  id_ren_tramite=".$idtramite;

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $id=$col['valor_variable'];
		    }


		 
		 
		 
		 

		$sql="select *from public.par_catalogo where idcatalogo=".$id;

		$resultado = $this->bd->ejecutar($sql);

		while($col=$this->bd->obtener_array($resultado))
		    {
		    	 $variables['transporta']=$col['nombre'];
		    }


	return $variables;


 	}
	
	//--- resumen IR
	function _titulos_pagos( $id_par_ciu, $codig_pago){
 	 
 
      	$sql = "SELECT *
    			from rentas.view_ren_movimiento_pagos  
    			where id_renpago = ".$this->bd->sqlvalue_inyeccion( $codig_pago,true)." and 
                     id_par_ciu = ".$this->bd->sqlvalue_inyeccion($id_par_ciu,true)." 
                order by id_ren_movimiento";

 
 
      	$resultado = $this->bd->ejecutar($sql);
	 
      	return $resultado;

 	}
	//-----------------------------------
	function Empresa( ){
		
		$sql = "SELECT ruc_registro, razon, contacto, correo, web, direccion, telefono, email, ciudad, estado, url, mision, vision
				FROM view_registro
				where ruc_registro =".$this->bd->sqlvalue_inyeccion(	$this->ruc, true);

		$resultado = $this->bd->ejecutar($sql);

		$this->Registro = $this->bd->obtener_array( $resultado);

		return $this->Registro['razon'];
	}
	//-------------------------------
	function _variables_adicionales($detalle,$id_ren_tramite){
  
	    
	    $sql2 			= "SELECT * 
                             FROM  rentas.view_ren_tramite_var 
                            WHERE  imprime = 'S' and 
                                   id_ren_tramite= ".$this->bd->sqlvalue_inyeccion($id_ren_tramite ,true);
	    
	    $stmt2 			= $this->bd->ejecutar($sql2);
	    $adicional 		= '';
	    
	    while ($x=$this->bd->obtener_fila($stmt2)){
	        
	        if (trim($x['id_catalogo']) == '0'){
	            
	            $adicional   = $adicional.' '.trim($x['nombre_variable']) . ': '.trim($x['valor_variable']) ;
	            
	        }else{
	            
	            $valor = $this->bd->_catalogo_dato($x['valor_variable']);
	            
	            $adicional   = $adicional.' '.trim($x['nombre_variable']) . ': '. $valor;
	        }
	        
	        
	       
	    }
	    $adicional = '';
	 
	    if ( $id_ren_tramite > 0 ){
	        
	        $detalle		= strtoupper($detalle).' '.strtoupper ($adicional);
	        
	    }
	 
	    return $detalle;
	    
	    
	}
   
//---------------------
	function _recorre($titulos ){
	    
 
	    return  $this->bd->obtener_fila( $titulos);
	}
  
	//---------------
	function _usuario_pago($sesion ){
	    
	    $datos =  $this->bd->__user($sesion);
	    
	    return  $datos['completo'];
	    
	}
//--------------------
	function _ciu($id_par_ciu){
	    
	    $x = $this->bd->query_array('par_ciu',   // TABLA
	        '*',                        // CAMPOS
	        'id_par_ciu='.$this->bd->sqlvalue_inyeccion($id_par_ciu,true) // CONDICION
	        );
	    
	   
	    return $x;
	    
	}
	//----------------------------------
	function _nombre_titulo($id){
	    
	    $x = $this->bd->query_array('rentas.view_ren_movimiento_pagos ',   // TABLA
	        '*',                        // CAMPOS
	        'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
	        );
	    
	    
	    $x['periodo'] =   $x['anio'].'-'.$x['mes'];
 
	    return $x ;
	}
	
	/*
	*/
 function QR_DocumentoDoc($codigo){
	    
	    
	    $name       = trim($_SESSION['razon']) ;
	    $sesion     = trim($_SESSION['email']);
	    
	    $datos = $this->bd->query_array('par_usuario',
	        'completo',
	        'email='.$this->bd->sqlvalue_inyeccion($sesion,true)
	        );
	    
	    $nombre     =  $datos['completo'];
	    $year       = date('Y');
	    $codigo     = str_pad($codigo,5,"0",STR_PAD_LEFT ).'-'.$year;
	    $elaborador = base64_encode($codigo);
	    
	    $hoy = date("Y-m-d H:i:s");
	    
	    // we building raw data
	    $codeContents .= 'GENERADO POR:'.$nombre."\n";
	    $codeContents .= 'FECHA: '.$hoy."\n";
	    $codeContents .= 'DOCUMENTO: '.$elaborador."\n";
	    $codeContents .= 'INSTITUCION :'.$name."\n";
	    $codeContents .= '2.4.0'."\n";
	    
 	    
	    QRcode::png($codeContents,  'logo_qr.png', QR_ECLEVEL_L, 3);
	}
 
}

?>