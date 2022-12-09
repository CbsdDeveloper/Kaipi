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
		 Resumen de Bienes Institucionales </h4>
    </div>	
	<div class="col-md-12" style="padding: 15px">	
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
    
    function unidad_resumen( $vidsede,$fecha1,$fecha2,$cuenta){
        

        if ( $cuenta == '-'){

                $sql = "select  cuenta,nombre_cuenta,count(*) as nn
                    from activo.view_bienes
                    where idsede =  ".$this->bd->sqlvalue_inyeccion($vidsede,true)." and 
                        fecha_adquisicion between ".$this->bd->sqlvalue_inyeccion($fecha1,true).' and '.$this->bd->sqlvalue_inyeccion($fecha2,true)." and 
                        uso <> 'Baja'  
                group by cuenta,nombre_cuenta
                order by cuenta"   ;
         }else {

            $sql = "select  cuenta,nombre_cuenta,count(*) as nn
                from activo.view_bienes
                where idsede =  ".$this->bd->sqlvalue_inyeccion($vidsede,true)." and 
                    fecha_adquisicion between ".$this->bd->sqlvalue_inyeccion($fecha1,true).' and '.$this->bd->sqlvalue_inyeccion($fecha2,true)." and 
                    uso <> 'Baja'  and 
                    cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta,true)."
            group by cuenta,nombre_cuenta
            order by cuenta"   ;
     }
  
             
        $resultado= $this->bd->ejecutar($sql);
        
        echo   '<ul class="list-group">';
       
        while ($y=$this->bd->obtener_fila($resultado)){
            
            $nombre = trim($y['cuenta']).' '.trim($y['nombre_cuenta']);
            
            $vcuenta =  trim($y['cuenta']);
            
            echo   '<li class="list-group-item"><b>'.$nombre.' </b><span class="badge">'.$y['nn'].'</span></li>';
            
            $this->consultaId_unidad( $vidsede,$vcuenta,$fecha1,$fecha2);
            
        }
        
        
 
        echo   '  </ul>';
        
    }
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    
    function consultaId( $vtipo_bien,$vcuenta,$vuso ,$idd){
        
        
 
		if ( $idd == '0'){
			
            if ( trim($vuso) == '-'){
                        $sql = "select   *
                        from activo.view_bienes 
                        where cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true).' and
                            tipo_bien = '.$this->bd->sqlvalue_inyeccion(trim($vtipo_bien),true)."
                        order by clase,descripcion  asc"   ;

              }else{   

                $sql = "select   *
                        from activo.view_bienes 
                        where uso =  ".$this->bd->sqlvalue_inyeccion(trim($vuso),true).' and
                            cuenta = '.$this->bd->sqlvalue_inyeccion(trim($vcuenta),true).' and
                            tipo_bien = '.$this->bd->sqlvalue_inyeccion(trim($vtipo_bien),true)."
                        order by clase,descripcion  asc"   ;

            }
			$unidad = '';
			
		}else{
		
            if ( trim($vuso) == '-'){
              
                $sql = "select   *
           from activo.view_bienes 
            where cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true).' and 
                  id_departamento ='.$this->bd->sqlvalue_inyeccion($idd,true).' and 
                  tipo_bien = '.$this->bd->sqlvalue_inyeccion(trim($vtipo_bien),true)."
           order by clase,descripcion  asc"   ;

            }else {

                $sql = "select *
           from activo.view_bienes 
            where uso =  ".$this->bd->sqlvalue_inyeccion(trim($vuso),true).' and
                  cuenta = '.$this->bd->sqlvalue_inyeccion(trim($vcuenta),true).' and 
                  id_departamento ='.$this->bd->sqlvalue_inyeccion($idd,true).' and 
                  tipo_bien = '.$this->bd->sqlvalue_inyeccion(trim($vtipo_bien),true)."
           order by clase,descripcion  asc"   ;

            }
			
			
			 $xx = $this->bd->query_array('nom_departamento','nombre as detalle', 'id_departamento='.$this->bd->sqlvalue_inyeccion($idd,true));
			
			$unidad = trim($xx['detalle']) ;

		}	
			
        
      
   
 
        $resultado= $this->bd->ejecutar($sql);
     
        $this->cabecera( $idd);
        
        
        $xy = $this->bd->query_array('co_plan_ctas','max(detalle) as detalle', 'cuenta='.$this->bd->sqlvalue_inyeccion(trim($vcuenta),true));
        
        $detalle =  trim($vcuenta).'-'.trim($xy['detalle']) ;
		
		if ( $vtipo_bien == 'BLD'){
			
			$texto = 'BIENES DE LARGA DURACION';
			
	   }else{
		
			$texto = 'BIENES DE CONTROL ADMINISTRATIVO';
	   
	    }
			
		
		echo '<h4><b>'.$detalle.'<br>'.$vtipo_bien.' ('.$texto.')'.'<br>'.$unidad.' </b></h4>';
		
    
		$total = 0;
		$i = 1;
        while ($y=$this->bd->obtener_fila($resultado)){

              
            $informacion_activo = trim($y['descripcion']).'- Codigo Anterior '. trim($y['codigo_actual']).') '.trim($y['estado']).' ' . 
            trim($y['color']).' '.trim($y['detalle']).' Factura: '.trim($y['factura']).' Año Compra '. trim($y['anio_adquisicion']);

           
  
             echo '<tr>
                <td style="text-align: left;padding: 2px">'.$i.'</td>
		    	<td style="text-align: left;padding: 2px">'.trim($y['id_bien']).'</td>
                <td style="text-align: left;padding: 2px">'.  $informacion_activo.'</td>		    	
		    	<td style="text-align: left;padding: 2px">'.trim($y['unidad']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($y['razon']).'</td>
                 <td style="text-align: left;padding: 2px">'.trim($y['estado']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($y['serie']).'</td>
				<td style="text-align: left;padding: 2px">'.trim($y['vida_util']).'</td>
               <td style="text-align: left;padding: 2px">'.trim($y['fecha_adquisicion']).'</td>
                <td style="text-align: right;padding: 2px">'.$y['costo_adquisicion'].'</td> <tr>';
  
             $total = $total + $y['costo_adquisicion'];
             $i++;
        }
         
        echo '<tr>
		    	<td colspan="9" style="text-align: left;padding: 2px"> </td>
                <td style="text-align: right;padding: 3px"><b>'.number_format($total,2).'</b></td> <tr>';
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
 
        
    }
    //-------------------
    function consultaId_unidad( $vidsede,$vcuenta,$fecha1,$fecha2){
        
             
            $sql = "select   *
			from activo.view_bienes
             where  uso <> 'Baja' and 
                   cuenta = ".$this->bd->sqlvalue_inyeccion(trim($vcuenta),true).' and
				   fecha_adquisicion between '.$this->bd->sqlvalue_inyeccion($fecha1,true).' and '.$this->bd->sqlvalue_inyeccion($fecha2,true).' and 
                   idsede = '.$this->bd->sqlvalue_inyeccion(trim($vidsede),true)."
			order by clase,descripcion  asc"   ;
            
         
        
        $resultado1= $this->bd->ejecutar($sql);
        
        $this->cabecera( $idd);
           
        $total = 0;
        $i = 1;
        while ($yy=$this->bd->obtener_fila($resultado1)){
            
            
            $informacion_activo = trim($yy['descripcion']).'- Codigo Anterior '. trim($yy['codigo_actual']).') '.trim($yy['estado']).' ' . 
            trim($yy['color']).' '.trim($yy['detalle']).' Factura: '.trim($yy['factura']).' Año Compra '. trim($yy['anio_adquisicion']);

            echo '<tr>
                 <td style="text-align: left;padding: 2px">'.$i.'</td>
		    	<td style="text-align: left;padding: 2px">'.trim($yy['id_bien']).'</td>
                <td style="text-align: left;padding: 2px">'. $informacion_activo .'</td>
		    	<td style="text-align: left;padding: 2px">'.trim($yy['unidad']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['razon']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['estado']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($yy['serie']).'</td>
 				<td style="text-align: left;padding: 2px">'.trim($yy['vida_util']).'</td>
               <td style="text-align: left;padding: 2px">'.trim($yy['fecha_adquisicion']).'</td>
                <td style="text-align: right;padding: 3px">'.number_format($yy['costo_adquisicion'],2).'</td> <tr>';
            
            $total = $total + $yy['costo_adquisicion'];
            $i++;
        }
        
        echo '<tr>
		    	<td colspan="9" style="text-align: left;padding: 2px"> </td>
                <td style="text-align: right;padding: 3px"><b>'.number_format($total,2).'</b></td> <tr>';
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
        
        
    }
    //----
    function cabecera( $idd ){
        
	 
		 

        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="5%">Nro.</th>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="5%">Bien</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="30%">Detalle</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="15%">Unidad</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="15%">Custodio</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Estado</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Serie</th>
         <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">VUtil</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Fecha</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Costo</th>
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

 

if (isset($_GET['sede']))	{
    
    $sede    = $_GET['sede'];
   
    $fecha1        = $_GET['f1'];
    $fecha2        = $_GET['f2'];
    $cuenta        = trim($_GET['cuenta']);
	 	
 
	    $gestion->unidad_resumen($sede,$fecha1,$fecha2,$cuenta );
 
    
   
    
}
 
?>
		</div>
</body>
</html>	
  