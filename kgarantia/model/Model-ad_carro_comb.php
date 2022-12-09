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
    private $datos;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    
    //---------------------------------------------------------
    public function BusquedaDoc( $id_bien,$tipo ,$fecha1,$fecha2){
        
        // Soporte Tecnico
        
        
        $year = date('Y');
 
        $qquery = array(
            array( campo => 'id_combus',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_bien',valor => $id_bien,filtro => 'S', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_in',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'u_km_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ubicacion_salida',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ubicacion_llegada',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_comb',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'referencia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cantidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor =>$year,filtro => 'S', visor => 'S'),
            array( campo => 'estado',valor => $tipo,filtro => 'S', visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
        );
        
        
        
        // filtro para fechas
       $this->bd->__between('fecha',$fecha1,$fecha2);
        
        $resultado = $this->bd->JqueryCursorVisor('adm.view_comb_vehi',$qquery );
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Responsable </th>
                <th> Comprobante </th>
                <th> Fecha </th>
                 <th> Hora </th>
                 <th> Ubicacion </th>
                 <th> Km.Actual </th>
                 <th> Combustible </th>
                <th> Cantidad </th>
                <th> Costo </th>
  <th> SubTotal </th>
  <th> IVA </th>
                <th> Total </th>
                <th> Acciones</th></thead> </tr>';
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_combus'] ;
           
            $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLdetalle('."'del'".','.$idproducto.","."'".$id_bien."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
            $boton2 = '<button class="btn btn-xs"
                              title="Editar Registro"
                              onClick="javascript:goToURLdetalle('."'editar',".$idproducto.","."'".$id_bien."'".')">
                             <i class="glyphicon glyphicon-search"></i></button>&nbsp;&nbsp;&nbsp;';
           
            
            echo ' <tr>';
             
            $total = $fetch['cantidad'] * $fetch['costo'];
            
             
            $iva =  (12/ 100);
            $monto_iva = $total * $iva;
            
            $total_consumo = round($total,4)+ $monto_iva;
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td><b>'.$fetch['razon'].'</b></td>';
            echo ' <td>'.$fetch['referencia'].'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['hora_in'].'</td>';
            echo ' <td>'.$fetch['ubicacion_salida'].'</td>';
            echo ' <td>'.$fetch['u_km_inicio'].'</td>';
            echo ' <td>'.$fetch['tipo_comb'].'</td>';
            echo ' <td>'.number_format($fetch['cantidad'],4).'</td>';
            echo ' <td>'.number_format($fetch['costo'],4).'</td>';
            echo ' <td>'.number_format($total,2).'</td>';
            echo ' <td>'.number_format($monto_iva,2).'</td>';
            echo ' <td>'.number_format($total_consumo,4).'</td>';
            echo ' <td>'.$boton2.$boton1.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
    //-------------
    function ElimanaDoc( $id, $idprov ){
        //inicializamos la clase para conectarnos a la bd
        
        $sql = "DELETE  FROM nom_doc
                 where id_nom_doc = ".$this->bd->sqlvalue_inyeccion($id,true);
        
        $this->bd->ejecutar($sql);
        
        
        $this->BusquedaDoc( $idprov);
        
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
if (isset($_GET["idbien"]))	{
    
    
    $id 				=     $_GET["idbien"];
    $tipo				=     $_GET["tipo"];
    
    $fecha1				=     $_GET["fecha1"];
    $fecha2				=     $_GET["fecha2"];
    
    
    
    $gestion->BusquedaDoc(   trim($id),$tipo,$fecha1,$fecha2  );
    
    
}

//------ grud de datos insercion
if (isset($_GET["idcodigo"]))	{
    
    
    $id 				=     $_GET["idcodigo"];
    
    $idprov 			=     $_GET["prov"];
    
    $gestion->ElimanaDoc(    ($id) ,  trim($idprov)   );
    
    
}




?>
 
  