<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
       
        $this->anio       =  $_SESSION['anio'];
        
    }
    //--------------------------------------
    function historial($id){
          
        
       
        
        
        $sql = "SELECT  id_bien_dep, id_bien,cuenta,     descripcion, costo,vresidual,   vidautil,
                        anio_bien || '  ' AS anio_bien, 
                        cuotadp, diferencia ,acumulado
        FROM activo.view_bienes_depre
                where   id_bien_dep = ".$this->bd->sqlvalue_inyeccion($id,true)." order by descripcion";
                    
        
        $resultado    =  $this->bd->ejecutar($sql);
          
        echo '<table class="table table-responsive"   width="100%" style="font-size:11px" id="TablaAsignada" >
            <thead>
                <tr>
                     <th width="5%" align="center" rowspan="2">Nro.Bien</th>
                     <th width="5%" align="center" rowspan="2"> Cuenta</th>
                     <th width="35%" align="center" rowspan="2">Detalle</th>
                     <th colspan="3" align="center">Costo Bien</th>
                     <th colspan="2" align="center">Costo Proporcional Depreciacion</th>
                     <th width="10%"  align="center" rowspan="2">C = (A) - (B)</th>
                     <th width="10%" align="center" rowspan="2">Dias utilizacion</th>
                    </tr>
				 <tr>
                     <th align="center" width="10%">(A) Costo</th>
                     <th align="center" width="5%">Residual</th>
                     <th align="center" width="5%">Vida Util</th>
                     <th align="center" width="5%">Anio</th>
                     <th align="center" width="10%">(B) CDP</th>
                     <th align="center" width="10%"></th>
                    </tr>
            </thead><tbody>';
        
 

   
        
 
        while($row=pg_fetch_assoc ($resultado)) {
             
            
            $cadena =  $row['anio_bien'];
            $entero = intval($cadena);  
 
            echo '<tr>
             <td>'.$row['id_bien'].' </td>
             <td> '. $row['cuenta'].' </td>
             <td> <b>'. $row['descripcion'].' </b></td>
             <td> '. $row['costo'].' </td>
             <td> '. $row['vresidual'].' </td>
            <td > '. $row['vidautil'].' </td>
            <td > '. $entero.' </td>
              <td > '. $row['cuotadp'].' </td>
              <td > '. $row['diferencia'].' </td>
            <td> '. $row['acumulado'].' </td>
            <td> <a href="#" onClick="EliminarBiend('.$row['id_bien'].')" title="eliminar bien">  <span class="glyphicon glyphicon-trash"></span>    </a> </td>
             </tr>';
        }
        
        echo "</tbody></table>";
        
        
    }
    
}
//-------------------------

$gestion         = 	new proceso;


if (isset($_GET['id_bien_dep']))	{
    
    $id    = $_GET['id_bien_dep'];
    
    $gestion->historial($id) ;
    
}
 


?>
<script>
var $jq = jQuery.noConflict();
$jq( document ).ready(function( $ ) {
	   $jq('#TablaAsignada').DataTable();
});
 
</script>
 
