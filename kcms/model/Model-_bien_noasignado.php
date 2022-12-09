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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
       
        $this->anio       =  $_SESSION['anio'];
        
    }
    //--------------------------------------
    function historial($id){
          
        
       
        
        $sql = "SELECT  id_bien,tipo_bien,cuenta,clase,descripcion,costo_adquisicion,bandera,serie,marca
        FROM activo.view_bienes
                where   uso = ".$this->bd->sqlvalue_inyeccion('Libre',true)." and 
                        tiene_acta = ".$this->bd->sqlvalue_inyeccion('N',true)." and 
                        anio  = ".$this->bd->sqlvalue_inyeccion($this->anio,true)." and 
                        idprov = ".$this->bd->sqlvalue_inyeccion($id,true)." order by descripcion";
                    
        
        $resultado    =  $this->bd->ejecutar($sql);
          
        echo ' <table class="table table-responsive"   width="100%" style="font-size:11px" id="TablaAsignada" >
            <thead>
                <tr>
                     <th width="5%">Id Bien</th>
                     <th width="5%">Tipo</th>
                     <th width="30%">Detalle</th>
                     <th width="5%">Cuenta</th>
                     <th width="15%">Clase</th>
                     <th width="10%">Serie</th>
                     <th width="10%">Marca</th>
                      <th width="10%">Costo</th>
                     <th width="10%"></th>
                    </tr>
            </thead><tbody>';
        
 

   
        
 
        while($row=pg_fetch_assoc ($resultado)) {
             
            if ($row['bandera'] == 'S'){
                $check ='checked';
            }else{
                $check =' ';
            }
            
            $bandera = '<input type="checkbox" onclick="myFunction('.$row['id_bien'].',this)" '.$check.'> ';
            
            echo '<tr>
             <td>'.$row['id_bien'].' </td>
             <td> '. $row['tipo_bien'].' </td>
             <td> <b>'. $row['descripcion'].' </b></td>
             <td> '. $row['cuenta'].' </td>
             <td> '. $row['clase'].' </td>
            <td> '. $row['serie'].' </td>
            <td> '. $row['marca'].' </td>
              <td> '. $row['costo_adquisicion'].' </td>
                <td> '. $bandera.' </td>
             </tr>';
        }
        
        echo "</tbody></table>";
        
        
    }
    
}
//-------------------------

$gestion         = 	new proceso;


if (isset($_GET['idprov']))	{
    
    $id    = $_GET['idprov'];
    
    $gestion->historial($id) ;
    
}
 


?>
<script>
var $jq = jQuery.noConflict();
$jq( document ).ready(function( $ ) {
	   $jq('#TablaAsignada').DataTable();
});
 
</script>
 
