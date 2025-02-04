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
		 Resumen de Emergencias  </h4>
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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    
    function unidad_resumen( $cat){
        
        $sql = "SELECT id, fecha_emergencia, hora_aviso, parroquia, sector, informante, categoria_emergencia, tipo_de_emergencia, nombre_y_contacto_referencia, descripcion_emergencia, ubicacion_emergencia, medidas_adoptadas, personas_heridas, personas_fallecidas, daños_ambientales, daños_bienes, organismos_apoyo, personal_desplazado, arribo_emergencia, hora_desmovilizacion, hora_llegada_base 
        FROM ireport.lista_emergencias WHERE categoria_emergencia = ".$this->bd->sqlvalue_inyeccion($cat,true)." 
        order by fecha_emergencia desc"   ;


        
        
        $xx = $this->bd->query_array('nom_departamento','nombre as detalle', 'id_departamento='.$this->bd->sqlvalue_inyeccion($idd,true));
        
        $unidad = trim($xx['detalle']) ;
        
        
        
        $texto='EMERGENCIAS POR '.$cat;
        
        echo '<h4><b>'.$unidad.'<br>'.$vtipo_bien.' ('.$texto.')'.'<br>'.' </b></h4>';
        
        $resultado= $this->bd->ejecutar($sql);
        
        echo   '<ul class="list-group">';
       
        while ($y=$this->bd->obtener_fila($resultado)){
            
            
            $this->consulta_ca( $cat);
            
        }
        
        
 
        echo   '  </ul>';
        
    }
    
    //--------------------------------------------------------------------------------
   
    //-------------------
    function consulta_ca( $cat){
        
             
            $sql = "SELECT id, fecha_emergencia, hora_aviso, parroquia, sector, informante, categoria_emergencia, tipo_de_emergencia, nombre_y_contacto_referencia, descripcion_emergencia, ubicacion_emergencia, medidas_adoptadas, personas_heridas, personas_fallecidas, daños_ambientales, daños_bienes, organismos_apoyo, personal_desplazado, arribo_emergencia, hora_desmovilizacion, hora_llegada_base 
        FROM ireport.lista_emergencias WHERE categoria_emergencia = ".$this->bd->sqlvalue_inyeccion($cat,true)." 
        order by fecha_emergencia desc"   ;
            
         
        
        $resultado1= $this->bd->ejecutar($sql);
        
        $this->cabecera( $idd);
           
        $total = 0;
        $i = 1;
        while ($yy=$this->bd->obtener_fila($resultado1)){
            
            echo '<tr>
                 <td style="text-align: left;padding: 2px">'.$i.'</td>
		    	<td style="text-align: left;padding: 2px">'.trim($yy['fecha_emergencia']).'</td>
                <td style="text-align: left;padding: 2px">'.(trim($yy['hora_aviso'])).'</td>
		    	<td style="text-align: left;padding: 2px">'.trim($yy['parroquia']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['sector']).'</td>
	    	    <td style="text-align: left;padding: 2px">'.trim($yy['informante']).'</td>
                <td style="text-align: left;padding: 2px">'.trim($yy['categoria_emergencia']).'</td>
				<td style="text-align: left;padding: 2px">'.trim($yy['tipo_de_emergencia']).'</td>
               <td style="text-align: left;padding: 2px">'.trim($yy['descripcion_emergencia']).'</td>
                <td style="text-align: right;padding: 3px">'.trim($yy['ubicacion_emergencia']).'</td> <tr>';
            
           
            $i++;
        }
        
        
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
        
        
    }
    //----
    function cabecera( $idd ){
        
		

        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="5%">Nro.</th>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="5%">Fecha</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="5%">Hora</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Parroqui</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Sector</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Informante</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Categoria</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Tipo</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Descripcion</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Ubicacion</th>
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

 

if (isset($_GET['cat']))	{
    
    $cat    = $_GET['cat'];
    
	 	 $gestion->unidad_resumen($cat);

	/*if ( $vcuenta == '99'){
	   
	}else {
	    $gestion->consultaId($vtipo_bien,$vcuenta,$vuso,$idd );
	}*/
    
   
    
}
 
?>
		</div>
</body>
</html>	
  