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
		
	}
 
	//--------------------------------------------------------------------------------
	//---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
	//--------------------------------------------------------------------------------
	function agregar($id_asiento,$id_asientod,$idprov,$fcopiar){
		
		$proveedor_aux = $this->bd->query_array('view_aux',
            				'idprov,debe,haber,razon',
            				'id_asientod ='.$this->bd->sqlvalue_inyeccion($id_asientod,true).' and 
                             idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)
            				);
		
		$idprovAux     = $proveedor_aux["idprov"];
		$longitudProv  = strlen(trim($idprov));
		$longitud      = strlen(trim($fcopiar));
		    
		if ($idprovAux == 0) {
	   	  	
    				 //------------ seleccion de periodo
    		 		$periodo_s = $this->bd->query_array('co_asientod',
    		 									 'mes,anio,debe,haber,cuenta,id_periodo',
    		 									 'id_asientod ='.$this->bd->sqlvalue_inyeccion($id_asientod,true)
    		 								);
    		 		
    		 		$mes  			= $periodo_s["mes"];
    				$anio  			= $periodo_s["anio"];
    				$debe           = $periodo_s["debe"];
    				$haber          = $periodo_s["haber"];
    				$cuenta      = $periodo_s["cuenta"];
    				$id_periodo  = $periodo_s["id_periodo"];
    				
    				$saldo = 0;
    		 		
    				$ntotal =  $debe + $haber;
    				
    				if ($ntotal <> 0 ){
    				    
    				    if ($longitudProv < 5) {
    				        
    				        if ($longitud >  5) {
    				            $longitudProv = 7 ;
    				            $idprov       = $fcopiar;
    				        }
    				        
    				    }
    				    
    				    
    				    
    				//------------------------------------------------------------
    				$sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, registro) VALUES (".
    		              									  $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $this->bd->sqlvalue_inyeccion(trim($idprov) , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($saldo , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_periodo, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($anio, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($mes , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
    		              									  $this->hoy.",".
    		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
    				
    		      if ($longitudProv > 5) {
    		              
    				          	$this->bd->ejecutar($sql);
    				          	
    				          	$guardarAux = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO </b>';
    				          	
    				          	$this->agregar_aux($id_asiento, $idprov);
    				          	
    				          	$this->copiar_aux($id_asiento, $idprov);
    				          	
    				          	echo $guardarAux;
    				          	
    		          }
    			}  else{
     			    $guardarAux = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>Defina el valor para el auxiliar</b>';
    			    echo $guardarAux;
    			}
		    }else{
		        if ($longitudProv > 5) {
		            $this->agregar_aux($id_asiento, $idprov);
		        }
		       
		        
		        $guardarAux = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>Nro de identificacion ya registrada</b>';
		        echo $guardarAux;
		    }
		 
		
	}
 //-------------------
	function agregar_aux($id_asiento, $idprov){
	    
	    $sqlq = "UPDATE co_asiento
				  SET 	idprov    =".$this->bd->sqlvalue_inyeccion(trim($idprov), true)."
 				WHERE  id_asiento  =".$this->bd->sqlvalue_inyeccion($id_asiento, true);
	    
	    $this->bd->ejecutar($sqlq);
	    
	   
	    $sql = " UPDATE presupuesto.pre_tramite
				  SET 	idprov    =".$this->bd->sqlvalue_inyeccion(trim($idprov), true)."
 				WHERE  id_asiento_ref  =".$this->bd->sqlvalue_inyeccion($id_asiento, true);
	    
	    $this->bd->ejecutar($sql);
	    
	}
	//-------------------
	function copiar_aux($id_asiento, $idprov){
	    
	    
	    
	    
	    /*
	    $sql1 = 'SELECT id_asiento,debe, haber,aux,id_asientod
            FROM view_diario_aux
            where id_asiento= '.$this->bd->sqlvalue_inyeccion($id_asiento,true) .' and
                  aux = '.$this->bd->sqlvalue_inyeccion('S',true);
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql1);
	    
	    while ($fila=$this->bd->obtener_fila($stmt1)){
	        
	        
	        $x= $this->bd->query_array('co_asiento_aux',
	                                   'count(*) as nn', 
	                                   'id_asiento='.$this->bd->sqlvalue_inyeccion($id_asiento,true).' and 
                                        id_asientod='.$this->bd->sqlvalue_inyeccion($fila['id_asientod'],true).' and  
                                        idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
	            );
	        
	        
	        if ( $x['nn'] == 0 ){
	            $this->copiar($id_asiento,$fila['id_asientod'],$idprov);
	        }
	        
	    }
	    */
 
	}
//--------------
	function copiar($id_asiento,$id_asientod,$idprov){
	    
	    $proveedor_aux = $this->bd->query_array('view_aux',
	        'idprov,debe,haber,razon',
	        'id_asientod ='.$this->bd->sqlvalue_inyeccion($id_asientod,true).' and
                 idprov='.$this->bd->sqlvalue_inyeccion($idprov,true)
	        );
	    
	    $idprovAux = $proveedor_aux["idprov"];
	    
	    
	    $longitudProv = strlen(trim($idprov));
	    
	    if ($idprovAux == 0) {
	        
	        //------------ seleccion de periodo
	        $periodo_s = $this->bd->query_array('co_asientod',
	            'mes,anio,debe,haber,cuenta,id_periodo',
	            'id_asientod ='.$this->bd->sqlvalue_inyeccion($id_asientod,true)
	            );
	        
	        $mes  			= $periodo_s["mes"];
	        $anio  			= $periodo_s["anio"];
	        $debe          = $periodo_s["debe"];
	        $haber         = $periodo_s["haber"];
	        $cuenta      = $periodo_s["cuenta"];
	        $id_periodo  = $periodo_s["id_periodo"];
	        
	        $saldo = 0;
	        
	        $ntotal =  $debe + $haber;
	        
	        if ($ntotal > 0 ){
	            //------------------------------------------------------------
	            $sql = "INSERT INTO co_asiento_aux (id_asientod, id_asiento, idprov, cuenta, debe, haber,parcial, id_periodo,
    		              									  anio, mes, sesion, creacion, registro) VALUES (".
    		              									  $this->bd->sqlvalue_inyeccion($id_asientod  , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_asiento, true).",".
    		              									  $this->bd->sqlvalue_inyeccion(trim($idprov) , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($cuenta , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($debe , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($haber , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($saldo , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($id_periodo, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($anio, true).",".
    		              									  $this->bd->sqlvalue_inyeccion($mes , true).",".
    		              									  $this->bd->sqlvalue_inyeccion($this->sesion 	, true).",".
    		              									  $this->hoy.",".
    		              									  $this->bd->sqlvalue_inyeccion( $this->ruc  , true).")";
    		              									  
    		              									  if ($longitudProv > 5) {
    		              									      
    		              									      $this->bd->ejecutar($sql);
    		              									      
     		              									     
    		              									  }
	        }  
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
if (isset($_GET['idprov']))	{
	
	$id_asiento      = $_GET['id_asiento'];
	$codigodet       = $_GET['codigodet'];
	$idprov          = $_GET['idprov'];
	$fcopiar         = $_GET['fcopiar'];
	
	
	
	$longitudProv = strlen(trim($idprov));
	
	if ($longitudProv > 5) {
	
	    $gestion->agregar($id_asiento,$codigodet,$idprov,$fcopiar);
	
	}else  {
	   
	    $guardarAux = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>Nro de identificacion no registrado</b>';
	    
	    echo $guardarAux;
	    
	}
	   
    	
 
		
}

 


?>
 
  