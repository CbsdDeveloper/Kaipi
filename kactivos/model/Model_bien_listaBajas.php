<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class Model_bien_listaBajas{
    
     
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
    function Model_bien_listaBajas( ){
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
          
        
        
        $datos = $this->bd->query_array('activo.ac_movimiento','*', 'id_acta='.$this->bd->sqlvalue_inyeccion($id,true));
        
        $fecha = $datos['fecha'];
        
        $sql = "SELECT  a.id_acta_det, b.tipo_bien,a.id_bien,
                        b.cuenta,b.clase,b.descripcion, b.uso,b.costo_adquisicion,b.sede, a.sesion, a.creacion,
                         b.serie,b.marca,b.fecha_adquisicion,b.valor_residual,b.valor_depreciacion
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
                     <th width="10%">Clase</th>
                     <th width="30%">Detalle</th>
                     <th width="10%">Fecha Adquisicion</th>
                     <th width="5%">Utilizado(Dias)</th>
                     <th width="5%">Costo</th>
                     <th width="5%">V.Residual</th>
                     <th width="5%">CPD</th>
                     <th width="5%"></th>
                    </tr>
            </thead><tbody>';
        
     
 
        while($row=pg_fetch_assoc ($resultado)) {
             
            
            $fecha_fin = $row['fecha_adquisicion'];
            
            $dias = (strtotime($fecha)-strtotime($fecha_fin))/86400;
            $dias = abs($dias); 
            $dias = floor($dias);
            
            $dias_var        = round($dias/365,2);
 
  
          //  $bandera = '<input type="checkbox" onclick="myFunction('.$row['id_bien'].',this)" '.$check.'> ';
            
            $bandera =  '<button class="btn btn-xs" onClick="javascript:goToURLDetalle('.$row['id_acta_det'].')"><i class="glyphicon glyphicon-trash"></i></button>' ;
           
            
            $detalle = trim($row['descripcion']).' '.trim($row['serie']). ' '.trim($row['marca']);
            
            echo '<tr>
             <td>'.$row['id_acta_det'].' </td>
             <td> '. $row['tipo_bien'].' </td>
             <td> <b>'. $row['id_bien'].' </b></td>
             <td> '. $row['cuenta'].' </td>
             <td> '. $row['clase'].' </td>
             <td> '. $detalle.' </td>
             <td> '. $row['fecha_adquisicion'].' </td>
             <td> '. number_format($dias,0).' / '.$dias_var.' </td>
            <td> '. number_format($row['costo_adquisicion'],2).' </td>
            <td> '. $row['valor_residual'].' </td>
            <td> '. number_format($row['valor_depreciacion'],2).' </td>
            <td> '. $bandera.' </td>
             </tr>';
        }
        
        echo "</tbody></table>";
        
        
    }
    
}
//-------------------------

$gestion         = 	new Model_bien_listaBajas;


if (isset($_GET['id_acta']))	{
    
    $id    = $_GET['id_acta'];
    
    $gestion->historial($id) ;
    
}
 


?>
 
