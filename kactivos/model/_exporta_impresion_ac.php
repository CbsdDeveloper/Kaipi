<?php
session_start( );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('../view/Head.php')  ?> 
	
	<style>
 

table, td, th {
  border: 1px solid #999999;
}

table {
  width: 100%;
  border-collapse: collapse;
}
</style>
	
 
</head>
<body> 	
	<div class="col-md-12" style="padding-left: 15px;padding-right: 15px">	
		<h4> <b><?php echo $_SESSION['razon']  ?></b><br>
	    <?php echo $_SESSION['ruc_registro']  ?> <br>
		 Resumen de Compras de bienes por periodo </h4>
    </div>	
	<div class="col-md-12" style="padding: 10px">	
<?php
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
    private $ATabla;
    private $tabla ;
    private $secuencia;
    
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
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    
    function unidad_resumen( $vtipo_bien, $idd){
        
        $sql = "select  cuenta,nombre_cuenta,count(*) as nn
			from activo.view_bienes
             where id_departamento =  ".$this->bd->sqlvalue_inyeccion($idd,true)." and 
                   uso <> 'Baja' and 
                   tipo_bien = ".$this->bd->sqlvalue_inyeccion(trim($vtipo_bien),true)."
           group by cuenta,nombre_cuenta
        order by cuenta"   ;
        
        
        $xx = $this->bd->query_array('nom_departamento','nombre as detalle', 'id_departamento='.$this->bd->sqlvalue_inyeccion($idd,true));
        
        $unidad = trim($xx['detalle']) ;
        
        if ( $vtipo_bien == 'BLD'){
            $texto = 'BIENES DE LARGA DURACION';
        }else{
            $texto = 'BIENES DE CONTROL ADMINISTRATIVO';
            
        }
        
        
        echo '<h4><b>'.$unidad.'<br>'.$vtipo_bien.' ('.$texto.')'.'<br>'.' </b></h4>';
        
        $resultado= $this->bd->ejecutar($sql);
        
        echo   '<ul class="list-group">';
       
        while ($y=$this->bd->obtener_fila($resultado)){
            
            $nombre = trim($y['cuenta']).' '.trim($y['nombre_cuenta']);
            
            $vcuenta =  trim($y['cuenta']);
            
            echo   '<li class="list-group-item"><b>'.$nombre.' </b><span class="badge">'.$y['nn'].'</span></li>';
            
            $this->consultaId_unidad( $vtipo_bien,$vcuenta,$idd);
            
        }
        
        
 
        echo   '  </ul>';
        
    }
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    
    function consultaId( $fecha1,$fecha2,$vidsede){
        
    
			  $sql = "select   id_tramite,fecha_adquisicion, idproveedor,proveedor,factura, cantidad, costo
			from activo.view_bienes_tramite 
             where idsede =  ".$this->bd->sqlvalue_inyeccion($vidsede,true).' and
                   fecha_adquisicion between  '.$this->bd->sqlvalue_inyeccion($fecha1,true).' and 
				   '.$this->bd->sqlvalue_inyeccion($fecha2,true)." 
 			order by fecha_adquisicion"   ;
			
      
			  
	    echo '<h4>'.$fecha1.' al '.$fecha2.'</h4>';
 
        $resultado= $this->bd->ejecutar($sql);
     
        $this->cabecera( );
        
          
		$total = 0;
		 
        while ($y=$this->bd->obtener_fila($resultado)){
  
             echo '<tr>
		    	<td style="text-align: left;padding: 2px">'.trim($y['id_tramite']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($y['fecha_adquisicion']).'</td>
		    	<td style="text-align: left;padding: 2px">'.trim($y['idproveedor']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($y['proveedor']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($y['factura']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($y['cantidad']).'</td>
                <td style="text-align: right;padding: 3px">'.$y['costo'].'</td> <tr>';
  
             $total = $total + $y['costo'];
             
        }
         
        echo '<tr>
		    	<td colspan="6" style="text-align: left;padding: 2px"> </td>
                <td style="text-align: right;padding: 3px"><b>'.number_format($total,2).'</b></td> <tr>';
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
 
        
    }
    //-------------------
    function consultaId_unidad( $vtipo_bien,$vcuenta,$idd){
        
             
            $sql = "select   id_bien,forma_ingreso,clase,razon as unidad,descripcion,estado,serie ,anio_adquisicion,
                 vida_util,fecha_adquisicion,costo_adquisicion,valor_residual
			from activo.view_bienes
             where  uso <> 'Baja' and 
                   cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true).' and
				   id_departamento ='.$this->bd->sqlvalue_inyeccion($idd,true).' and
                   tipo_bien = '.$this->bd->sqlvalue_inyeccion(trim($vtipo_bien),true)."
			order by clase,descripcion  asc"   ;
            
         
        
        $resultado1= $this->bd->ejecutar($sql);
        
        $this->cabecera( $idd);
           
        $total = 0;
        $i = 1;
        while ($yy=$this->bd->obtener_fila($resultado1)){
            
            echo '<tr>
		    	<td style="text-align: left;padding: 2px">'.trim($yy['id_bien']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($yy['clase']).'</td>
		    	<td style="text-align: left;padding: 2px">'.trim($yy['unidad']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.utf8_decode(trim($yy['descripcion'])).'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['estado']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($yy['serie']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['anio_adquisicion']).'</td>
				<td style="text-align: left;padding: 2px">'.trim($yy['vida_util']).'</td>
               <td style="text-align: left;padding: 2px">'.trim($yy['fecha_adquisicion']).'</td>
                <td style="text-align: right;padding: 3px">'.number_format($yy['costo_adquisicion'],2).'</td> <tr>';
            
            $total = $total + $yy['costo_adquisicion'];
            $i++;
        }
        
        echo '<tr>
		    	<td colspan="6" style="text-align: left;padding: 2px"> </td>
                <td style="text-align: right;padding: 3px"><b>'.number_format($total,2).'</b></td> <tr>';
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
        
        
    }
    //----
    function cabecera(   ){
        

        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="10%">Tramite</th>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="10%">Fecha</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Identificacion</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="40%">Proveedor</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Factura</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Nro.Bienes</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Total</th>
         </tr>'	;
        
    }

        
 
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 

if (isset($_GET['f1']))	{
    
    $fecha1        = $_GET['f1'];
    $fecha2        = $_GET['f2'];
    $vidsede       = $_GET['sede'];
 
    $gestion->consultaId($fecha1,$fecha2,$vidsede );
 
    
}
 
?>
		</div>
</body>
</html>	
  