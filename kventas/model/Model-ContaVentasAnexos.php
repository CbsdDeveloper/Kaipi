<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php'; 

require 'Model-asientos_saldos.php';  


class proceso{
	
 
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $ATabla;
	private $anio;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
	 
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
		$this->anio       =  $_SESSION['anio'];
		
		$this->saldos     = 	new saldo_contable(  $this->obj,  $this->bd);
		
		$this->ATabla = array(
		    array( campo => 'id_ventas',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
		    array( campo => 'id_asiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'tpidcliente',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'idcliente',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'tipocomprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
		    array( campo => 'numerocomprobantes',tipo => 'NUMBER',id => '5',add => 'S', edit => 'N', valor => '1', key => 'N'),
		    array( campo => 'basenograiva',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'baseimponible',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'baseimpgrav',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'montoiva',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretiva',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretrenta',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'secuencial',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'codestab',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '001', key => 'N'),
		    array( campo => 'fechaemision',tipo => 'DATE',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'registro',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => $this->ruc , key => 'N'),
		    array( campo => 'valorretbienes',tipo => 'NUMBER',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'valorretservicios',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
		    array( campo => 'anexo',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '1', key => 'N'),
		    array( campo => 'tipoemision',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => 'F', key => 'N'),
		    array( campo => 'formapago',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '01', key => 'N'),
		    array( campo => 'montoice',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '0', key => 'N')
		);
		
		
		 
		
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2,$idbancos,$tipofacturaf ){
		
	    
	    $array_fecha   = explode("-", $f1);
	    $mes           = $array_fecha[1];
	    $anio          = $array_fecha[0];
 	    
	    //------------ seleccion de periodo
 	        
	    if ( $tipofacturaf == '0'){
	        $c = $this->agregar($anio,$mes,$f1,$f2);
	    }
	    
	    if ( $tipofacturaf == '9'){
	        $c = $this->agregar_no($anio,$mes,$f1,$f2);
	    }
	    
 
	    $ContabilizadoVentas = '<b>ANEXO DE VENTAS GENERADO.... </b> Nro. Registros '.  $c;
  	    
	    echo $ContabilizadoVentas;
	    

 	    
	}
  
 //---------------------------------------------------------------------------------------------
	function agregar( $anio,$mes,$f1,$f2  ){
	    
 
       
	     
	             $sql ="SELECT  fechaa, 
                               idprov,    comprobante , 
                              total, montoiva, tarifa_cero, baseimponible, cantidad, carga, registros
                           FROM view_inv_ane
	                        where  carga = 0   and (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' ) 
                        order by fechaa";
	                      
	          
 	             
	             $stmt1 = $this->bd->ejecutar($sql);
	             
	             $basenograiva = '0';
	             
	             $id_asiento = -99;
	             
	             $i = 1;
 	             
	             while ($x=$this->bd->obtener_fila($stmt1)){
	                 
	                 $registros = intval($x['registros']);
	                 
	                 $this->AnexosTransacional($id_asiento,trim( $x['idprov']),
	                     $x['baseimponible'],
	                     $x['tarifa_cero'],
	                     $x['montoiva'],
	                     0,
	                     $x['comprobante'],
	                     $x['fechaa'],$registros,$basenograiva 
	                     );
 	                
	                 
	                 $i++;
	                 
	             }  
	              
	             $this->K_actualizaInventario($id_asiento,'',$f1,$f2  );
	             
	             return $i;
	  
	}
	//---------------------------------------------------------------------------------------------
	function agregar_no( $anio,$mes,$f1,$f2  ){
	    
	    
	    
	    $sql ="select sum(total) total,
                               sum(montoiva) montoiva,
                               sum(tarifa_cero) tarifa_cero,
                               sum(baseimponible) baseimponible,
                               sum(cantidad) cantidad,
                               sum(registros) registros
                           FROM view_inv_ane
	                        where  carga = 9  and (fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."' )";
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql);
	    
	  
	    
	    $id_asiento = -99;
	    
	    $i = 1;
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $registros = intval($x['registros']);
	        
	        $basenograiva = $x['total'];
	        
	        $this->AnexosTransacional($id_asiento,trim('9999999999999'),
	            '0',
	            '0',
	            '0',
	            '0',
	            '0',
	            $f1,$registros,$basenograiva
	            );
	        
	        $this->K_actualizaInventario_no($id_asiento,trim('9999999999999'),$f1,$f2  );
	        
	        $i++;
	        
	    }
	    
	    return $i;
	    
	}
 //----------------
 function K_actualizaInventario($idAsiento,$idprov,$f1,$f2  ){
 	    
 	    
 	    $sql = "UPDATE inv_movimiento
							    SET 	cab_codigo  =".$this->bd->sqlvalue_inyeccion(99, true)."
							      WHERE carga = 0 and   
                                        cab_codigo <> 99 and 
                                        ( fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."')" ;
 	    
 	    $this->bd->ejecutar($sql);
 	    
 	    
 	}	
 //--------------------	
 	function K_actualizaInventario_no($idAsiento,$idprov,$f1,$f2  ){
 	    
 	    
 	    $sql = "UPDATE inv_movimiento
							    SET 	cab_codigo  =".$this->bd->sqlvalue_inyeccion(99, true)."
							      WHERE   cab_codigo <> 99 and carga = 9 and 
                                        ( fechaa  BETWEEN "."'".$f1."'". ' AND '."'".$f2."')" ;
 	    
 	    $this->bd->ejecutar($sql);
 	    
 	    
 	}	
 //----------------------------------
 	function AnexosTransacional($id_asiento,$idprov,$baseimpgrav,$tarifacero,$montoiva,$montoice,$secuencial,$fecha,$registros,$basenograiva ){
 	    
   /* 	    $valorretbienes    = '0';
    	    $valorretservicios     =  '0';
 	        $valorrenta =  '0';
 	  */  
 	    
 	    $tpidprov  = '04';
 	    
  	    $len          = strlen($idprov);
 	    
  	    if($len == 10){
  	        
  	        $tpidprov = '05';
  	    }
  	    elseif($len == 13) {
  	      
  	        $tpidprov = '04';
  	    }
  	    else{
  	        
  	        $tpidprov = '06';
  	    }
 	 
        if ($idprov == '9999999999999')     {
 	            $tpidprov = '07';
 	    }
 	         
  	 	    
 	        $this->ATabla[5][valor] =  $registros;
 	        
 	        $this->ATabla[1][valor] =  $id_asiento;
 	        $this->ATabla[2][valor] =  $tpidprov;
 	        $this->ATabla[3][valor] =  $idprov;
 	        $this->ATabla[4][valor] =  '18';
 	        $this->ATabla[6][valor] =  $basenograiva ;
 	        
 	        $this->ATabla[7][valor] = $tarifacero;
 	        $this->ATabla[8][valor] =  $baseimpgrav;
 	        $this->ATabla[9][valor] = $montoiva;
 	        
 	        $this->ATabla[12][valor] = $secuencial;
  	        $this->ATabla[14][valor] = $fecha;
 	     
 
 	        $this->ATabla[10][valor] = '0';
 	        $this->ATabla[11][valor] =  '0';
 	        
 	       $this->bd->_InsertSQL('co_ventas',$this->ATabla,'-');
  
 
 
 	
   }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_GET["fecha1"]))	{
	
    $f1 			    =     $_GET["fecha1"];
    $f2 				=     $_GET["fecha2"];
    $idbancos           =     $_GET["idbancos"];
    $tipofacturaf           =     $_GET["tipofacturaf"];
    
    
    
    
    if ($idbancos <> '-' ) 	{
        
        $gestion->grilla( $f1,$f2,$idbancos,$tipofacturaf );
        
    }
    else{
        
        $ContabilizadoVentas = 'Seleccione el banco o caja para cierre de cuenta por cobrar';
        
        echo $ContabilizadoVentas;
    }
 
	
}



?>
 
  