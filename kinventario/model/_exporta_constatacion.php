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
		 CONSTATACIÓN FISICA DE EXISTENCIAS </h4>
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
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
     
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    
    function consultaId(  $vcuenta ){
        
        $anio       =  $_SESSION['anio'];
        
	   	 $xx = $this->bd->query_array('co_plan_ctas','detalle', 
	   	     'anio ='.$this->bd->sqlvalue_inyeccion($anio,true). ' and 
             cuenta='.$this->bd->sqlvalue_inyeccion($vcuenta,true)
	   	     );
			
		 $unidad = trim($xx['detalle']) ;
 
	    $sql =  $_SESSION['sql_activo'];
			
 
        $resultado= $this->bd->ejecutar($sql);
     
        $this->cabecera( $anio);
        
        
         
        $detalle =  trim($vcuenta).'-'.$unidad;
		
	 
			
		
		echo '<h4><b>'.$detalle.'<br>'.' </b></h4>';
		
    
 		$i = 1;
        while ($y=$this->bd->obtener_fila($resultado)){

           
  
             echo '<tr>
 		    	<td style="text-align: left;padding: 2px">'.trim($y['idproducto']).'</td>
               	<td style="text-align: left;padding: 2px">'.trim($y['cuenta_inv']).'</td>	
		    	<td style="text-align: left;padding: 2px">'.trim($y['producto']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($y['unidad']).'</td>
                 <td style="text-align: center;padding: 2px">'.round(trim($y['saldo']),2).'</td>
	    	    <td style="text-align: left;padding: 2px">&nbsp;</td>
				<td style="text-align: left;padding: 2px">&nbsp;&nbsp;&nbsp;</td>
                </tr>';
           
             $i++;
        }
         
     
        
        echo '</table><br><p>&nbsp;</p>';
        
        
        $usuarios = $this->bd->__user(trim($this->sesion));
        
      
        
        echo 'ELABORADO:<br><b>'.$usuarios['completo'].'<br>'.$usuarios['unidad'].'</b>';
        
         
 
        
    }
    //-------------------
    
    //----
    function cabecera( $idd ){
        
	 
		 

        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="5%">Codigo.</th>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="10%">Cuenta</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="25%">Articulo/Producto</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Unidad</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Saldo Actual</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Cantidad</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="30%">Novedad</th>
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

 
 
    $vcuenta       = $_GET['cue'];
   
 
	    $gestion->consultaId($vcuenta);
	 
   
 
 
?>
		</div>
</body>
</html>	
  