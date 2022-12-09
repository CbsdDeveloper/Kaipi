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
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		
		$this->anio       =  $_SESSION['anio'];
		
	}
   
	//--- calcula libro diario
	function grilla( $f1,$f2 ,$tipo, $codigo){
		
 
	   
	    
	    $ingreso1 = $this->Bloque_Activo($f1,$f2,1,1,$tipo, $codigo);
	 
	    $ingreso2 = $this->Bloque_Activo($f1,$f2,1,2,$tipo, $codigo);
	    
	    $saldo1   = $ingreso1 + $ingreso2;
	    
	    $ingreso3 = $this->Bloque_Activo($f1,$f2,2,1,$tipo, $codigo);
	    
	    $ingreso4 = $this->Bloque_Activo($f1,$f2,2,2,$tipo, $codigo);
	    
	    $saldo2   = $ingreso3 + $ingreso4;
	    
	    $activo = $saldo1 + $saldo2;
	    
	    $pasivo1= $this->Bloque_Pasivo($f1,$f2,3,1,$tipo, $codigo);
	 
	    $pasivo2= $this->Bloque_Pasivo($f1,$f2,3,2,$tipo, $codigo);
	    
	    $saldo3 = $pasivo1+ $pasivo2;
	    
	    $pasivo3= $this->Bloque_Pasivo($f1,$f2,4,1,$tipo, $codigo);
  	    
	    $pasivo4= $this->Bloque_Pasivo($f1,$f2,4,2,$tipo, $codigo);
	    
	    $saldo4 = $pasivo3+ $pasivo4;
	    
	    $pasivo5= $this->Bloque_Pasivo($f1,$f2,5,1,$tipo, $codigo);
	    
	    
	    $activo1 = $saldo3 + $saldo4 + $pasivo5  ;
	    
 	    
	    if ( abs($activo) == abs($activo1)){
	        echo '0';
	    }else{
	        $val = $activo + $activo1;
	        echo $val;
	    }
 
	 
	}
	//----------------------------------------
	public function Bloque_Activo( $f1,$f2,$orden1,$orden2,$tipo, $codigo ){
 
	    
	    $sql = 'SELECT   orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, anio
	             FROM presupuesto.matriz_flujo
                    where seccion = '.$this->bd->sqlvalue_inyeccion('SECCION1',true) .' and 
                           orden1='.$this->bd->sqlvalue_inyeccion( $orden1 ,true) .' and 
                          anio='.$this->bd->sqlvalue_inyeccion( $this->anio  ,true) .' and 
                          orden2='.$this->bd->sqlvalue_inyeccion( $orden2 ,true).' order by orden3' ;
 	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
 
	    $t3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
          
	        $saldo = $this->suma_ejecutado($f1, $f2,trim($x["cuenta"])  ,trim($x["consigno"])  ,$tipo, $codigo    );
  
 	        $t3 = $t3 + $saldo;
	    }
	    
	     
	    return $t3;
	}
	 
	///------------------
 
	function suma_ejecutado($fecha1, $fecha2,  $cta1,$consigno,$tipo, $codigo){
		
	   
        if ( $tipo == 'asiento'){
            $cadena2 = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".
	   	    $this->bd->sqlvalue_inyeccion($fecha2,true)." )  and id_asiento= " .$this->bd->sqlvalue_inyeccion($codigo,true).' ';
            
            $ctabla = 'view_diario_conta';   
        }
        else {
            $cadena2 = ' and ( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($fecha1,true)." and ".
	   	    $this->bd->sqlvalue_inyeccion($fecha2,true)." )   ";
            $ctabla = 'view_diario_esigef';

        }

	    
	   	    $subgrupo = $cta1.'%';
	   	    $len      = strlen(trim($cta1));
	   	    $cadena   = substr($cta1, 0,3);
	   	    $bandera  = 0 ;
	   	 
	   	    if ( $consigno == '1')	   {
	   	        
	   	        $select = 'SELECT sum(haber) as monto ';
	   	        
	   	        if ( $len == 3) {
	   	            $where = ' mayor  like ' .$this->bd->sqlvalue_inyeccion( $subgrupo   ,true).$cadena2;
	   	        }else {
	   	            $where = ' subgrupo  = ' .$this->bd->sqlvalue_inyeccion( $cta1   ,true).$cadena2;
	   	        }
	   	    }
	   	    
	   	    if ( $consigno == '-1')	   {
	   	        
	   	        $select = 'SELECT sum(debe) as monto ';
	   	        
	   	        if ( $len == 3) {
	   	            $where = ' mayor  like ' .$this->bd->sqlvalue_inyeccion( $subgrupo   ,true).$cadena2;
	   	        }else {
	   	            $where = ' subgrupo  = ' .$this->bd->sqlvalue_inyeccion( $cta1   ,true).$cadena2;
	   	        }
	   	    }
	   	    
	   	    //-----------------------------------------------------------------------------
	   	    
	   	    $SQL = $select. ' FROM '.$ctabla.'  where '.$where;
	   	    
	   	    if ( $cadena == '112') {
	   	        
	   	        $select      = 'SELECT (sum(debe)  - sum(haber)) as monto ';
	   	        $SQL         =  $select. ' FROM '.$ctabla.'   where '.$where;
	   	        $resultado1  =  $this->bd->ejecutar($SQL);
	   	        $datos_sql   =  $this->bd->obtener_array( $resultado1);
	   	        $saldo       =  $datos_sql['monto']  ;
	   	        
	   	        $Asaldo = $this->bd->query_array('view_diario_esigef',
	   	                                         'sum(debe) - sum(haber) as saldoi',
	   	                                         "mayor like '112%' and 
                                                  tipo = 'A' and 
                                                  anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	            );
	   	        
	   	        $saldo = $Asaldo["saldoi"] -  $saldo;
	   	        
	   	        $bandera = 1;
	   	    }
	   	    
	   	    
	   	    if ( $cadena == '212') {
	   	        
	   	        $select      = 'SELECT (sum(debe)  - sum(haber)) as monto ';
	   	        $SQL         = $select. ' FROM '.$ctabla.'    where '.$where;
	   	        $resultado1  = $this->bd->ejecutar($SQL);
	   	        $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	        $saldo       =  $datos_sql['monto']  ;
	   	        
	   	        $Asaldo = $this->bd->query_array('view_diario_esigef',
	   	            'sum(debe) - sum(haber) as saldoi',
	   	            "mayor like '212%' and tipo = 'A' and
                     anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	            );
	   	        
	   	        $saldo = ( $saldo- $Asaldo["saldoi"] ) * -1  ;
	   	        
	   	        $bandera = 1;
	   	    }
	   	    
	   	    
	   	    if ( $cadena == '111') {
	   	        
	   	        $select = 'SELECT (sum(debe)  - sum(haber)) as monto ';
	   	        $SQL = $select. ' FROM  '.$ctabla.'     where '.$where;
	   	        
	   	        $resultado1  = $this->bd->ejecutar($SQL);
	   	        $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	        $saldo       =  $datos_sql['monto']  ;
 	   	        
	   	        $Asaldo = $this->bd->query_array('view_diario_esigef','sum(debe) - sum(haber) as saldoi',
	   	            "mayor like '111%' and 
                           tipo = 'A' and   
                           anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	            );
	   	        
	   	        $saldo = $Asaldo["saldoi"] -  $saldo;
	   	        
	   	        $bandera = 1;
	   	        
	   	    }
	   	    
	   	    
	   	    if ( $cadena == '619') {
	   	        
	   	        if ( $cta1 == '619.91') {
	 
	   	            
	   	            $datos_sql = $this->bd->query_array('view_diario_esigef','sum(debe) - sum(haber) as saldof',
	   	                "subgrupo like '619.91%' and
                        tipo is null and fecha < ".$this->bd->sqlvalue_inyeccion( $fecha2   ,true)." and 
                        anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	                );
	   	            
	   	            $saldo       =  $datos_sql['saldof'];
	   	            if (empty($datos_sql['saldof'])){
	   	                $saldo = 0;
	   	            }
	   	            
	   	          //  $fecha2
	   	            
	   	            $Asaldo = $this->bd->query_array('view_diario_esigef','sum(debe) - sum(haber) as saldoi',
	   	                "subgrupo like '619.91%' and 
                        tipo = 'A' and 
                        anio= ".$this->bd->sqlvalue_inyeccion( $this->anio    ,true)
	   	                );
	   	            
	   	            $saldo = $Asaldo["saldoi"] -  $saldo;
	   	            
 	   	            
	   	            $bandera = 1;
	   	        }
	   	    }
	   	    
 	   	
	  
 	  
	   	if ( $bandera == 0 ){
	   	    
	   	    $resultado1  = $this->bd->ejecutar($SQL);
	   	    $datos_sql   = $this->bd->obtener_array( $resultado1);
	   	    $saldo       =  $datos_sql['monto']  ;
	   	    
	   	    if ( $consigno == '-1'){
	   	        $saldo = $saldo * -1;
	   	    }
	   	}else{
 	   	    	    if ( $consigno == '-1'){
     	   	            $saldo = $saldo * -1;
     	   	    }
	   	}
	  
	    
	    
	    return $saldo;
	    
	    
	    
 
	}
	//------------------------------------------
	public function Bloque_Pasivo( $f1,$f2,$orden1,$orden2,$tipo, $codigo ){
	    
	    
	    $sql = 'SELECT   orden1, orden2, orden3, grupo, grupo2, grupo3, cuenta, sinsigno, consigno, anio
	             FROM presupuesto.matriz_flujo
                    where seccion = '.$this->bd->sqlvalue_inyeccion('SECCION2',true) .' and
                          anio='.$this->bd->sqlvalue_inyeccion( $this->anio  ,true) .' and 
                           orden1='.$this->bd->sqlvalue_inyeccion( $orden1 ,true) .' and
                          orden2='.$this->bd->sqlvalue_inyeccion( $orden2 ,true) .' order by orden3 ';
	    
	    
	    $stmt = $this->bd->ejecutar($sql);
	    
	    
	    $t3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
 	        
	        $saldo = $this->suma_ejecutado($f1, $f2,trim($x["cuenta"])  ,trim($x["consigno"]),$tipo, $codigo      );
	        
	        $t3 = $t3 + $saldo;
	    }
	    
	     
	    
	    return $t3;
	}
//----------------------------------------------------------------------------------------	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

//------ grud de datos insercion
if (isset($_POST["ffecha1"]))	{
	
	$f1 			    =     $_POST["ffecha1"];
	$f2 				=     $_POST["ffecha2"];
    $tipo 				=     $_POST["tipo"];
    $codigo 				=     $_POST["codigo"];
 
    
 
	$gestion->grilla( $f1,$f2 ,$tipo, $codigo);
  

}



?>
 
  