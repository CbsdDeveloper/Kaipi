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
        $this->bd     = 	new Db;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['login'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
       
        $this->anio       =  $_SESSION['anio'];
        
    }
    //--------------------------------------
    function historial($id){
          
        
       
        
        $sql = "SELECT  a.id_acta_det, b.tipo_bien,a.id_bien,
                        b.cuenta,b.clase,b.descripcion, b.uso,b.costo_adquisicion,b.sede, a.sesion, a.creacion,
                         b.serie,b.marca
                FROM activo.ac_movimiento_det a, activo.view_bienes b
                WHERE a.id_acta = ".$this->bd->sqlvalue_inyeccion($id,true)." and 
                      a.id_bien = b.id_bien  order by b.cuenta,b.descripcion";
                    
        
        $resultado    =  $this->bd->ejecutar($sql);
          
        echo ' <table class="table table-responsive"   width="100%" style="font-size:12px" id="TablaAsignada" >
            <thead>
                <tr>
                     <th width="5%">Id</th>
                     <th width="5%">Tipo</th>
                     <th width="5%">Codigo</th>
                     <th width="10%">Cuenta</th>
                     <th width="15%">Clase</th>
                     <th width="15%">Ubicacion</th>
                     <th width="30%">Detalle</th>
                     <th width="5%">Uso</th>
                     <th width="5%">Costo</th>
                     <th width="5%"></th>
                    </tr>
            </thead><tbody>';
        
     
 
        while($row=pg_fetch_assoc ($resultado)) {
             
 
          //  $bandera = '<input type="checkbox" onclick="myFunction('.$row['id_bien'].',this)" '.$check.'> ';
            
            $bandera =  '<button class="btn btn-xs" onClick="javascript:goToURLDetalle('.$row['id_acta_det'].')"><i class="glyphicon glyphicon-trash"></i></button>' ;
           
            
            $detalle = trim($row['descripcion']).' '.trim($row['serie']). ' '.trim($row['marca']);
            
            echo '<tr>
             <td>'.$row['id_acta_det'].' </td>
             <td> '. $row['tipo_bien'].' </td>
             <td> <b>'. $row['id_bien'].' </b></td>
             <td> '. $row['cuenta'].' </td>
             <td> '. $row['clase'].' </td>
             <td> '. $row['sede'].' </td>
            <td> '. $detalle.' </td>
            <td> '. $row['uso'].' </td>
            <td> '. $row['costo_adquisicion'].' </td>
                <td> '. $bandera.' </td>
             </tr>';
        }
        
        echo "</tbody></table>";
        
        
    }
    
}
//-------------------------

$gestion         = 	new proceso;


if (isset($_GET['id_acta']))	{
    
    $id    = $_GET['id_acta'];
    
    $gestion->historial($id) ;
    
}
 


?>
<script>
var $jq = jQuery.noConflict();
$jq( document ).ready(function( $ ) {
	   $jq('#TablaAsignada').DataTable();
});
 
</script>
 
