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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId( ){
        
        echo '<h5><b>Gestión de Registros de Emergencia</b></h5>';

        $anio = date('Y');
        
        $xx = $this->bd->query_array('ireport.lista_emergencias',
            'count(*) as nn',
            'substring(fecha_emergencia,1,4) = '.$this->bd->sqlvalue_inyeccion($anio,true) 
            );
        
 
            $sql = 'SELECT  parroquia,count(*) as nn
            from ireport.lista_emergencias
            where  substring(fecha_emergencia,1,4)  = '.$this->bd->sqlvalue_inyeccion($anio,true)."  
            group by parroquia";
 
        $resultado= $this->bd->ejecutar($sql);
        
        $this->cabecera( );
        
         
        
        while ($y=$this->bd->obtener_fila($resultado)){
            
         
            
            $detalle = trim($y['parroquia']);
 
            
            $p = round(($y['nn'] / $xx['nn']) * 100,2);
            
            $porcentaje = $p.' %';
            
            
           
            
             echo '<tr>
		    	<td style="text-align: left;padding: 5px"   >'.$detalle.'</td>
	            <td style="text-align: right;padding: 5px"  >'.$y['nn'].'</td>
                <td style="text-align: right;padding: 5px"   >'.$porcentaje.'</td> <tr>';
            
 
        }
         
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
 
         
        
       
        
    }
   
    //----
    function cabecera( ){
        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="70%">Emergencia Parroquias</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="15%">Nro.Registros</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="15%">%</th>
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

// $gestion->consultaId( );



?>
 
  