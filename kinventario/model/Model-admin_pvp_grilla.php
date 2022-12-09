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
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($PK_codigo,$idcategoria1,$idbodega1 ,$facturacion1,$productob,$idproductob){
        
        // Soporte Tecnico
        
        $filtro1 = 'N';
        $filtro2 = 'N';
        $filtro3 = 'N';
        
        if ($idcategoria1 <> 0){
            $filtro1 = 'S';
        }
        if ($idbodega1 <> 0){
            $filtro2 = 'S';
        }
        if ($facturacion1 <> '-'){
            $filtro3 = 'S';
        }
        
        $len = strlen(trim($productob));
        
        if ($len >= 3 ){
            $filtro1 = 'N';
            $filtro2 = 'S';
            $filtro3 = 'N';
            $filtro4 = 'S';
            $cadena1 = 'LIKE.'.'%'.trim($productob).'%';
        }else{
            $filtro4 = 'N';
        }
        
        
        if ($idproductob > 0 ) {
            $filtro1 = 'N';
            $filtro2 = 'S';
            $filtro3 = 'N';
            $filtro4 = 'N';
            
            $filtro5 = 'S';
        }else{
            
            $filtro5 = 'N';
            
        }
        
        $qquery = array(
            array( campo => 'idproducto',   valor => $idproductob,  filtro => $filtro5,   visor => 'S'),
            array( campo => 'producto',   valor => $cadena1,  filtro => $filtro4,   visor => 'S'),
            array( campo => 'referencia',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'codigo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'promedio',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'lifo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'costo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'saldo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'tipo',   valor => $PK_codigo ,  filtro => 'S',   visor => 'N'),
            array( campo => 'idcategoria',   valor => $idcategoria1,  filtro => $filtro1,   visor => 'N'),
            array( campo => 'idbodega',   valor => $idbodega1 ,  filtro => $filtro2,   visor => 'N'),
            array( campo => 'facturacion',   valor =>$facturacion1 ,  filtro => $filtro3,   visor => 'N'),
            array( campo => 'registro',   valor => $this->ruc ,  filtro => 'S',   visor => 'N'),
        );
        
 
        
        $resultado = $this->bd->JqueryCursorVisor('web_producto',$qquery );
        
    
        
        echo '<table id="jsontable" class="display table-condensed table-bordered" cellspacing="0" width="130%">
          <thead> <tr>
                <th> Id Producto </th>
                <th> Producto </th>
                <th> Codigo Externo </th>
                <th> Saldo </th>
                 <th> Costo </th>
                 <th> lifo </th>
                 <th> Promedio </th>
                 <th> PVP Normal </th>
                <th> % </th>
                <th> % </th>
                <th> Al Por Mayor </th>
                <th> % </th>
                <th> % </th>
                <th> Venta Comision </th>
                <th> % </th>
                <th> % </th>
                <th> Venta Con Tarjeta </th></thead> </tr>';
        
 
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
          
            $idproducto =  $fetch['idproducto'] ;
            
            $evento1 = ' onChange="go_actualiza_dato('.$idproducto.',this.value,0);" ';
            
            $p1 = '<input  type="text" '.$evento1.' style="border:rgba(193,193,193,1.00)"
                                                                  value="'.$fetch['codigo'].'">';
            
            $monto1 =  $this->_precio( $idproducto,'Normal');
            
            $evento2 = ' onChange="go_actualiza_dato('.$idproducto.',this.value,1);" ';
            
            $p2 = '<input  type="number" '.$evento2.' style="text-align:right;
                                                                 border:rgba(193,193,193,1.00)"
                                                                 step="0.01"
                                                                 min="0"
                                                                 max="999999999"
                                                                 value="'.$monto1.'">';
            
            $evento3 = ' onChange="go_actualiza_dato('.$idproducto.',this.value,2);" ';
            
            $monto2 =  $this->_precio( $idproducto,'PorMayor');
            $p3 = '<input  type="number" '.$evento3.' style="text-align:right;
                                                                 border:rgba(193,193,193,1.00)"
                                                                 step="0.01"
                                                                 min="0"
                                                                 max="999999999"
                                                                 value="'.$monto2.'">';
            
            $evento4 = ' onChange="go_actualiza_dato('.$idproducto.',this.value,3);" ';
            $monto3 = $this->_precio( $idproducto,'VentaComision');
            $p4 = '<input  type="number" '.$evento4.' style="text-align:right;
                                                                 border:rgba(193,193,193,1.00)"
                                                                 step="0.01"
                                                                 min="0"
                                                                 max="999999999"
                                                                 value="'.$monto3.'">';
            
            
            $evento5 = ' onChange="go_actualiza_dato('.$idproducto.',this.value,4);" ';
            $monto4 =  $this->_precio( $idproducto,'VentaTarjeta');
            $p5 = '<input  type="number" '.$evento5.' style="text-align:right;
                                                                 border:rgba(193,193,193,1.00)"
                                                                 step="0.01"
                                                                 min="0"
                                                                 max="999999999"
                                                                 value="'.$monto4.'">';
            
            
            if ( $fetch['costo'] > 0  ){
                
                $p1_1 = round(((($monto1 - $fetch['costo']) / $fetch['costo']) * 100),2)  ;
                
                $p3_1 = round(((($monto2 - $fetch['costo']) / $fetch['costo']) * 100),2)  ;
                
                $p4_1 = round(((($monto3 - $fetch['costo']) / $fetch['costo']) * 100),2)  ;
                
            }else {
                $p1_1 = '0';
                $p3_1 = '0';
                $p4_1 = '0';
            }
           
            
            if ( $fetch['promedio'] > 0  ){
                
                $p1_2 = round(((($monto1 - $fetch['promedio']) / $fetch['promedio']) * 100),2)  ;
                
                $p3_2 = round(((($monto2 - $fetch['promedio']) / $fetch['promedio']) * 100),2)  ;
                
                $p4_2 = round(((($monto3 - $fetch['promedio']) / $fetch['promedio']) * 100),2)  ;
                
            }else{
                $p1_2 = '0';
                $p3_2 = '0';
                $p4_2 = '0';
            }
            
            
            
           
            
            
            echo ' <tr>';
           
                echo ' <td>'.$idproducto.'</td>';
                echo ' <td>'.$fetch['producto'].'</td>';
                echo ' <td>'.$p1.'</td>';
                echo ' <td>'.$fetch['saldo'].'</td>';
                echo ' <td>'.$fetch['costo'].'</td>';
                echo ' <td>'.$fetch['lifo'].'</td>';
                echo ' <td>'.$fetch['promedio'].'</td>';
                echo ' <td>'.$p2.'</td>';
                echo ' <td>'.$p1_1.'</td>';
                echo ' <td>'.$p1_2.'</td>';
                echo ' <td>'.$p3.'</td>';
                echo ' <td>'.$p3_1.'</td>';
                echo ' <td>'.$p3_2.'</td>';
                echo ' <td>'.$p4.'</td>';
                echo ' <td>'.$p4_1.'</td>';
                echo ' <td>'.$p4_2.'</td>';
                echo ' <td>'.$p5.'</td>';
                    
 
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
     }
     
  //---------------
     function _precio( $id_producto,$detalle){
         
         
         $AResultado = $this->bd->query_array(
             'inv_producto_vta',
             'monto',
             'id_producto='.$this->bd->sqlvalue_inyeccion(trim($id_producto),true). ' and
             detalle='.$this->bd->sqlvalue_inyeccion(trim($detalle),true)
             );
         
         $dato = $AResultado['monto'];
         
         if( empty($dato)){
             $dato = 0;
         }
         
         return $dato;
         
     }
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ consulta grilla de informacion
if (isset($_GET['GrillaCodigo']))	{
    
    $PKcodigo      = $_GET['GrillaCodigo'];
    $idcategoria1  = $_GET['idcategoria1'];
    $idbodega1     = $_GET['idbodega1'];
    $facturacion1  = $_GET['facturacion1'];
    
    
    $productob   =  $_GET['productob'];
    $idproductob =  $_GET['idproductob'];
    
    
    $gestion->BusquedaGrilla($PKcodigo,$idcategoria1,$idbodega1 ,$facturacion1,$productob,$idproductob);
    
}

?>
<script>

   jQuery.noConflict(); 

   jQuery(document).ready(function() {

	   jQuery('#jsontable').dataTable( {
			    "aoColumnDefs": [
			      { "sClass": "highlight", "aTargets": [ 1] },
			      { "sClass": "sal", "aTargets": [ 3 ] },
			      { "sClass": "ye1", "aTargets": [ 4 ] },
			      { "sClass": "ye2", "aTargets": [ 5 ] },
			      { "sClass": "ye3", "aTargets": [ 6 ] },
			      { "sClass": "ye0", "aTargets": [ 7 ] },
			      { "sClass": "ye1", "aTargets": [ 8 ] },
			      { "sClass": "ye3", "aTargets": [ 9 ] },
			      { "sClass": "ye0", "aTargets": [ 10 ] },
			      { "sClass": "ye1", "aTargets": [ 11 ] },
			      { "sClass": "ye3", "aTargets": [ 12 ] },
			      { "sClass": "ye0", "aTargets": [ 13 ] },
			      { "sClass": "ye1", "aTargets": [ 14 ] },
			      { "sClass": "ye3", "aTargets": [ 15 ] }
			    ]
			  } );
		  
	    
       
    } ); 
</script> 


 