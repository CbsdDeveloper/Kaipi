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
        
        
        $xx = $this->bd->query_array('activo.view_bienes',
            'count(*) as nn',
            'uso  <> '.$this->bd->sqlvalue_inyeccion( 'Baja',true)
            );
        
        
        $sql = "select cuenta ,nombre_cuenta,count(*) as bienes,sum(costo_adquisicion) as total
			from activo.view_bienes where uso <> 'Baja'
			group by cuenta ,nombre_cuenta order by 3 desc"   ;

 
        $resultado= $this->bd->ejecutar($sql);
        
        $this->cabecera( );
        
        
      
        
        
        while ($y=$this->bd->obtener_fila($resultado)){
            
            $detalle =  trim($y['cuenta']).' '. trim($y['nombre_cuenta']);
            
            $p = round(($y['bienes'] / $xx['nn']) * 100,2);
            
            $porcentaje = $p.' %';
            
            
            $total_grupo =  number_format($y['total'],2);
            
             echo '<tr>
		    	<td style="text-align: left;padding: 5px"   >'.$detalle.'</td>
				<td style="text-align: right;padding: 5px"  >'.$total_grupo.'</td>
	            <td style="text-align: right;padding: 5px"  >'.$y['bienes'].'</td>
                <td style="text-align: right;padding: 5px"   >'.$porcentaje.'</td> <tr>';
            
 
        }
         
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
 
        
    }
    //----
    function cabecera( ){
        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"  bgcolor="lightblue" width="65%">Grupo</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Costo</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">Nro.Items</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="10%">%</th>
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

$gestion->consultaId( );



?>
 
  