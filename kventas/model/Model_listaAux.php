<?php
session_start( );

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php'; 

require 'interes_mensual.php';  

require '../../kconfig/Set.php'; 

class proceso{
	
 
	
	private $obj;
	private $bd;
	private $set;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $finteres;
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		 
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		$this->set     = 	new ItemsController;
		
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		$this->sesion 	 =  $_SESSION['email'];
		$this->hoy 	     =  $this->bd->hoy();
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
		$this->finteres     = 	new interes_variable( $this->obj,  $this->bd);
		
	}
   
	//--- calcula libro diario
	function GrillaMaestro( $idprov){
		
	  
	    $this->_Verifica_suma_facturas_Total( $idprov  );
	    
	    echo '<div class="panel panel-default">
              <div class="panel-heading">Detalle de Movimientos</div>
              <div class="panel-body">
               <ul class="list-group">';
	    
 
	    $sql = "SELECT estado, sum(total) as total, count(id_movimiento) as registros
                FROM rentas.view_ren_mov_arren
                where idprov = ".$this->bd->sqlvalue_inyeccion($idprov,true)." and estado <> 'anulado'
                group by estado
                order by estado";    

 
	    $stmt = $this->bd->ejecutar($sql);
	    
	    while ($x=$this->bd->obtener_fila($stmt)){
	        
	        $estado        =  trim($x['estado']);
 	        $registros     =  trim($x['registros']);
	        
	       
 	        
	        $this->GrillaPago( $idprov,$estado,$registros);
	   
	    }
	    
 	    
	    echo ' </ul>
               </div>
            </div>';
	    
 
		
	    $ViewFormCxc= '<h6><br>'.' Resumen de informacion '.$idprov.'</br></h6>';
	    
	    echo $ViewFormCxc;
	
	}
 	//---------------------------------
	function GrillaPago( $idprov,$estado,$registros){
	    
	    
 
	    
	    
	    
	    if ( $estado == 'digitado'){
	        
	        echo '<h5>&nbsp;&nbsp;</h5> ';
	        echo '<div style="overflow-y:scroll; overflow-x:hidden; height:350px;padding-right: 5px;padding-left: 5px"> ';
	        
	        $imagen  = '<img src="../../kimages/alert.png"  align="absmiddle"  />	';
	        $estado1 = $imagen. '<b>Tramites pendientes de pago </b> ('.$registros.') ';
	        echo '   <li class="list-group-item">'.$estado1.' </li>';
	        
	        $this->cabecera_estado( $estado);
	        $this->detalle_estado_digitado($estado,$idprov);
	        echo '  </div>';
	        
	    }else{
	        
	      
	        
	        echo '<div style="overflow-y:scroll; overflow-x:hidden; height:350px;padding-right: 5px;padding-left: 5px"> ';
	        
	        $imagen  = '<img src="../../kimages/ok_save.png"  align="absmiddle"  />	';
	        $cuenta1 = $imagen.'<b>Tramites pagados - facturados </b> ('.$registros.')   ';
	        echo '   <li class="list-group-item">'.$cuenta1.' </li>';
	        
	        $this->cabecera_estado( $estado);
	        $this->detalle_estado_aprobado($estado,$idprov);
	        echo '  </div>';
	    }
	        
 
	   
 
	     
	    
	}
	//---------------------------------------------------------------
	function cabecera_estado( $estado){
	    
	    $idestado = 't-'.$estado;
	    
	    echo '<table id= "'.$idestado.'" class="table table-bordered table-hover table-tabletools" border="0" width="100%">';
	    
	    if ( $estado =='digitado'){
	        
	        echo '<thead>
                <tr>
                    <th width="10%">Transaccion</th>
                    <th width="5%">Anio</th>
                    <th width="5%">Mes</th>
                    <th width="10%">Fecha</th>
                    <th width="35%">Detalle</th>
                    <th width="15%">Emitido</th>
                    <th width="5%">Interes</th>
                    <th width="5%">Total</th>
                    <th width="5%">A pagar</th>
                     <th width="5%"> </th>
                </tr></thead>';
	        
	    }else {
	        
	        echo '<thead>
                <tr>
                    <th width="10%">Transaccion</th>
                    <th width="5%">Anio</th>
                    <th width="5%">Mes</th>
                    <th width="6%">Fecha</th>
                    <th width="6%">FPago</th>
                    <th width="5%">Comprobante</th>
                    <th width="43%">Detalle</th>
                    <th width="10%">Emitido</th>
                    <th width="10%">Total</th>
                </tr></thead>';
	        
	    }
  	    
	}
//------------------------------------------	
	function detalle_estado_digitado( $estado,$idprov){
	 
	    $sql = 'SELECT  id_movimiento,
                         anio ,
                        mes ,
                        fecha  ,
                        comprobante ,
                        detalle ,
                        sesion ,
                        total , cab_codigo
                 FROM rentas.view_ren_mov_arren
                where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and
                      estado = '. $this->bd->sqlvalue_inyeccion(trim($estado) , true).' order by anio desc, mes desc';
	    
	    
	    $stmt_ac = $this->bd->ejecutar($sql);
	    
	    $total_1 = 0;
	    $total_2 = 0;
	    $total_3 = 0;
	    
	    while ($x=$this->bd->obtener_fila($stmt_ac)){
	        
	        if ($x['cab_codigo'] == 1){
	            $check ='checked';
	        }else{
	            $check =' ';
	        }
	        
	        $bandera = '<input type="checkbox" onclick="myFunction('.$x['id_movimiento'].',this)" '.$check.'> ';
	        
	        $id_movimiento =  trim($x['id_movimiento']);
	        
	        $costo = $this->finteres->_arriendo_facturacion($id_movimiento) ;
	        
	        $total = $costo + $x['total'];
	        
	        echo '<tr>
                    <td>'.$x['id_movimiento'].'</td>
                    <td>'.$x['anio'].'</td>
                    <td>'.$x['mes'].'</td>
                    <td>'.$x['fecha'].'</td>
                    <td>'.$x['detalle'].'</td>
                    <td>'.$x['sesion'].'</td>
                    <td align="right" >'.$costo.'</td>
                    <td align="right" >'.$x['total'].'</td>
                    <td align="right" >'.$total.'</td>  
	                <td align="right" >'.$bandera.'</td> ';
 	        echo '</tr>';
 	         
	        $total_1 = $total_1 + $costo ;
	        $total_2 = $total_2 + $x['total'] ;
	        $total_3 = $total_3 + $total;
	    }
	    
	    
	
	    
	    echo '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right" ><b>'.$total_1.'</b></td>
                    <td align="right" ><b>'.$total_2.'</b></td>
                    <td align="right" ><b>'.$total_3.'</b></td> ';
	    echo '</tr>';
	    
	    
	    echo '</table>';
	    
	   
	    
	    
	}

	//------------------------------------------
	function detalle_estado_aprobado( $estado,$idprov){
	    
	    $sql = 'SELECT  id_movimiento,
                         anio ,
                        mes ,
                        fecha  ,
                        fechaa ,
                        comprobante ,
                        detalle ,
                        sesion ,
                        total
                 FROM rentas.view_ren_mov_arren
                where idprov = '. $this->bd->sqlvalue_inyeccion($idprov , true).' and
                      estado = '. $this->bd->sqlvalue_inyeccion(trim($estado) , true).' order by anio desc, mes desc';
	    
	    
	    $stmt_ac = $this->bd->ejecutar($sql);
	    
 	    $total_2 = 0;
 	    
 	    //;
 	    
 	    
	    while ($x=$this->bd->obtener_fila($stmt_ac)){
	 
	        
	        $enlace = ' <a href="#" onClick="openfacDetalle('.$x['id_movimiento'].')" title="Verificar Informacion">'.$x['comprobante'].'</a>';
	        
	            echo '<tr>
                    <td>'.$x['id_movimiento'].'</td>
                    <td>'.$x['anio'].'</td>
                    <td>'.$x['mes'].'</td>
                    <td>'.$x['fecha'].'</td>
                    <td>'.$x['fechaa'].'</td>
                   <td>'.$enlace.'</td>                 
                   <td>'.$x['detalle'].'</td>
                    <td>'.$x['sesion'].'</td>
                    <td align="right" >'.$x['total'].'</td> ';
	        echo '</tr>';
	        
 	        $total_2 = $total_2 + $x['total'] ;
 	    }
	    
	    echo '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td><td></td>
                    <td align="right" ><b>'.$total_2.'</b></td> ';
	    echo '</tr>';
	    
	    
	    echo '</table>';
	    
	    
	    
	    
	}
//---------
	function _Verifica_suma_facturas_Total( $idprov  ){
	    
	    
	    $sql_det1 = "select   id_movimiento
                        FROM inv_movimiento
                        where idprov = ".$this->bd->sqlvalue_inyeccion(trim($idprov),true)."  and    estado = 'digitado'";
	    
	    
	    
	    $stmt1 = $this->bd->ejecutar($sql_det1);
	    
	    
	    while ($x=$this->bd->obtener_fila($stmt1)){
	        
	        $id = $x['id_movimiento'];
	        
	        $ATotal = $this->bd->query_array(
	            'inv_movimiento_det',
	            'sum( total) as t1, sum(monto_iva) as t2, sum(tarifa_cero) as t3, sum(baseiva) as t4',
	            ' id_movimiento ='.$this->bd->sqlvalue_inyeccion($id,true)
	            );
	        
	        
	        
	        $sqlEdit = "update inv_movimiento
				     set  iva = ".$this->bd->sqlvalue_inyeccion($ATotal['t2'],true).",
                          base0 = ".$this->bd->sqlvalue_inyeccion($ATotal['t3'],true).",
                          base12 = ".$this->bd->sqlvalue_inyeccion($ATotal['t4'],true).",
                          total = ".$this->bd->sqlvalue_inyeccion($ATotal['t1'],true)."
 				 		 WHERE  id_movimiento=".$this->bd->sqlvalue_inyeccion( $id, true);
	        
	        $this->bd->ejecutar($sqlEdit);
	        
	        
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

 
 
//------ grud de datos insercion
if (isset($_GET["idprov"]))	{
	
 
    $idprov				=   $_GET["idprov"];
  
    $gestion->GrillaMaestro( trim($idprov));
 
	
}
 
?>