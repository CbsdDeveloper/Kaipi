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
    
    function consultaId( $fecha1,$fecha2,$vidsede,$tipo){
        

        if ( $vidsede == '0'){
            $sql = "select  cuenta,nombre_cuenta,count(*) as nn
			from activo.view_bienes
             where fecha_adquisicion between  ".$this->bd->sqlvalue_inyeccion($fecha1,true).' and 
                 '.$this->bd->sqlvalue_inyeccion($fecha2,true)." 
           group by cuenta,nombre_cuenta
        order by cuenta"   ;

        } else {

        $sql = "select  cuenta,nombre_cuenta,count(*) as nn
			from activo.view_bienes
             where idsede =  ".$this->bd->sqlvalue_inyeccion($vidsede,true).' and
                   fecha_adquisicion between  '.$this->bd->sqlvalue_inyeccion($fecha1,true).' and 
                 '.$this->bd->sqlvalue_inyeccion($fecha2,true)." 
           group by cuenta,nombre_cuenta
        order by cuenta"   ;
         }
        
      
        
        echo '<h5><b>Movimiento de compras periodo '.$fecha1.' al '.$fecha2.'<br>'.' </b></h5>';
        
        $resultado= $this->bd->ejecutar($sql);
        
        echo   '<ul class="list-group">';
       
        while ($y=$this->bd->obtener_fila($resultado)){
            
            $nombre = trim($y['cuenta']).' '.trim($y['nombre_cuenta']);
            
            $vcuenta =  trim($y['cuenta']);
            
            echo   '<li class="list-group-item"><b>'.$nombre.' </b><span class="badge">'.$y['nn'].'</span></li>';
            
            if ( $tipo == '1'){

                $this->consultaId_unidad(  $vcuenta , $fecha1,$fecha2,$vidsede);

            } else {

                $this->consultaId_clase(  $vcuenta , $fecha1,$fecha2,$vidsede);
                
            }
          
            
        }
        
        
 
        echo   '  </ul>';

     
        
    }
    //-------------------
    function consultaId_unidad( $vcuenta , $fecha1,$fecha2,$vidsede){
        
             
        if ( $vidsede == '0'){
            $sql = "select   *
       from activo.view_bienes
        where cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true)." and
              fecha_adquisicion between  ".$this->bd->sqlvalue_inyeccion($fecha1,true).' and 
             '.$this->bd->sqlvalue_inyeccion($fecha2,true)." 
       order by clase,descripcion  asc"   ;
       

        } else {

            $sql = "select  *
       from activo.view_bienes
        where cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true)." and
              idsede =  ".$this->bd->sqlvalue_inyeccion($vidsede,true).' and
              fecha_adquisicion between  '.$this->bd->sqlvalue_inyeccion($fecha1,true).' and 
             '.$this->bd->sqlvalue_inyeccion($fecha2,true)." 
       order by clase,descripcion  asc"   ;
       
         }
        

        
         
        
        $resultado1= $this->bd->ejecutar($sql);
        
        $this->cabecera();
           
        $total = 0;
        $i = 1;
        while ($yy=$this->bd->obtener_fila($resultado1)){
            
            $detalle = trim( $yy['descripcion']). ' '.trim( $yy['color']) .' ('. $yy['codigo_actual'].') Factura: '.trim($yy['factura']).' '.trim($yy['detalle'])  .' '. trim($yy['material']);


            echo '<tr>
		    	<td style="text-align: left;padding: 2px">'.trim($yy['id_bien']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($yy['clase']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.  $detalle.'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['estado']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($yy['serie']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['fecha_adquisicion']).'</td>
               <td style="text-align: left;padding: 2px">'.trim($yy['proveedor']).'</td>
               <td style="text-align: left;padding: 2px">'.trim($yy['factura']).'</td>
                 <td style="text-align: right;padding: 3px">'.number_format($yy['costo_adquisicion'],2).'</td> <tr>';
            
            $total = $total + $yy['costo_adquisicion'];
            $i++;
        }
        
        echo '<tr>
		    	<td colspan="8" style="text-align: left;padding: 2px"> </td>
                <td style="text-align: right;padding: 3px"><b>'.number_format($total,2).'</b></td> <tr>';
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
        
        
    }
    //----
    function cabecera(){
        

        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="5%">Codigo</th>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="10%">Clase</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="30%">Detalle</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Estado</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Serie</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Adquisicion</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="25%">Proveedor</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Factura</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Costo</th>
         </tr>'	;
        
         echo '<tr>';
 

    }
 /*
  */
     function cabecera1(){
        
 
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="20%">Clase</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Adquisicion</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Tramite</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="45%">Proveedor</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Factura</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Cantidad</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Costo</th>
         </tr>'	;
        
         echo '<tr>';
 

    }

function consultaId_clase( $vcuenta , $fecha1,$fecha2,$vidsede){
        
             
    if ( $vidsede == '0'){
        $sql = "select   clase,fecha_adquisicion,id_tramite,proveedor,factura,count(*) as cantidad,sum(costo_adquisicion) as costo_adquisicion
   from activo.view_bienes
    where cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true)." and
          fecha_adquisicion between  ".$this->bd->sqlvalue_inyeccion($fecha1,true).' and 
         '.$this->bd->sqlvalue_inyeccion($fecha2,true)." 
         group by clase,fecha_adquisicion,id_tramite,proveedor,factura
   order by clase,id_tramite  asc"   ;
 

    } else {

        $sql = "select   clase,fecha_adquisicion,id_tramite,proveedor,factura,count(*) as cantidad,sum(costo_adquisicion) as costo_adquisicion
   from activo.view_bienes
    where cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true)." and
          idsede =  ".$this->bd->sqlvalue_inyeccion($vidsede,true).' and
          fecha_adquisicion between  '.$this->bd->sqlvalue_inyeccion($fecha1,true).' and 
         '.$this->bd->sqlvalue_inyeccion($fecha2,true)." 
         group by clase,fecha_adquisicion,id_tramite,proveedor,factura
   order by clase,id_tramite  asc"   ;
   
     }
    
 
     
    
    $resultado1= $this->bd->ejecutar($sql);
    
    $this->cabecera1();
       
    $total = 0;
    $i = 1;
    while ($yy=$this->bd->obtener_fila($resultado1)){
        
        echo '<tr>
            <td style="text-align: left;padding: 2px">'.trim($yy['clase']).'</td>
            <td style="text-align: left;padding: 2px">'.trim($yy['fecha_adquisicion']).'</td>
            <td style="text-align: left;padding: 2px">'.(trim($yy['id_tramite'])).'</td>
            <td style="text-align: left;padding: 2px">'.trim($yy['proveedor']).'</td>
            <td style="text-align: left;padding: 2px">'.trim($yy['factura']).'</td>
           <td style="text-align: left;padding: 2px">'.trim($yy['cantidad']).'</td>
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

    $tipo =  $_GET['tipo'];
 
     
        $gestion->consultaId($fecha1,$fecha2,$vidsede ,$tipo);
 
     

}
 
?>
		</div>
</body>
</html>	
  