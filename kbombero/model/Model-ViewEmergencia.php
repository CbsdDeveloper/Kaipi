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


        $sql = "update flow.wk_proceso_caso set estado = '4' where estado = '5' and modulo = 'F'";
        $this->bd->ejecutar($sql);


        $anio = date('Y');
        
        $xx = $this->bd->query_array('flow.view_proceso_caso',
            'count(*) as nn',
            'anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and 
            tipo_doc = 'proceso' "
            );
        
            $sql = 'SELECT  estado,count(*) as nn
            from flow.view_proceso_caso
            where  anio = '.$this->bd->sqlvalue_inyeccion($anio,true)." and 
                   tipo_doc = 'proceso'
            group by estado";
 
        $resultado= $this->bd->ejecutar($sql);
        
        $this->cabecera( );
        
         
        
        while ($y=$this->bd->obtener_fila($resultado)){
            
         
            
            $estado = trim($y['estado']);

            if ( $estado == '1'){
                $detalle =  '1. POR ENVIAR';
            }
            if ( $estado == '2'){
                $detalle =  '2. ENVIADOS';
            }
            if ( $estado == '3'){
                $detalle =  '3. POR AUTORIZAR';
            }
            if ( $estado == '4'){
                $detalle =  '4. AUTORIZADOS/FINALIZADOS';
            }
            if ( $estado == '5'){
                $detalle =  '5. AUTORIZADOS/FINALIZADOS';
            }
            
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
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="70%">Estado</th>
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

$gestion->consultaId( );



?>
 
  