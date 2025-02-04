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
    function consultaId( $lista  ){
        
        echo '<h5><b>Gestión de Registros de Emergencia</b></h5>';

        $anio = date('Y');
        
        
        
 
            $sql = 'SELECT  fecha_emergencia, parroquia,informante,descripcion_emergencia,medidas_adoptadas,afectacion_has
            from ireport.lista_emergencias
            where  substring(fecha_emergencia,1,4)  = '.$this->bd->sqlvalue_inyeccion($anio,true)."  and 
                   tipo_de_emergencia = ".$this->bd->sqlvalue_inyeccion($lista,true)."
            order by fecha_emergencia";
 
        $resultado= $this->bd->ejecutar($sql);
        
        $this->cabecera( );
        
         
        
        while ($y=$this->bd->obtener_fila($resultado)){
            
 
             
             echo '<tr>
                <td style="padding: 5px"  >'.$y['fecha_emergencia'].'</td>
                <td style="padding: 5px"  >'.$y['parroquia'].'</td>
                <td style="padding: 5px"  >'.$y['informante'].'</td>
                <td style="padding: 5px"  >'.$y['descripcion_emergencia'].'</td>
                <td style="padding: 5px"  >'.$y['medidas_adoptadas'].'</td>
                <td style="padding: 5px"  >'.$y['afectacion_has'].'<tr>';
            
 
        }
         
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
 
         
        
       
        
    }
   
    //----
    function cabecera( ){
        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Fecha</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="15%">Parroquia</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="15%">Informante</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="25%">Descripcion</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="25%">Novedad</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Afectacion Has</th>
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

$lista =  ($_GET['lista']);

$gestion->consultaId( $lista  );



?>
 
  