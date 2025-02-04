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
    function consultaId( ){
        
        echo '<h5><b>Gestión de Registros de Afectacion HAS</b></h5>';

        $anio = date('Y');
 
        $cabecera = "CASE WHEN  mes='1' THEN 'Enero' WHEN
        mes='2' THEN 'Febrero' WHEN
        mes='3' THEN 'Marzo' WHEN
        mes='4' THEN 'Abril' WHEN
        mes='5' THEN 'Mayo' WHEN
        mes='6' THEN 'Junio' WHEN
        mes='7' THEN 'Julio' WHEN
        mes='8' THEN 'Agosto' WHEN
        mes='9' THEN 'Septiembre' WHEN
        mes='10' THEN 'Octubre' WHEN
        mes='11' THEN 'Noviembre' ELSE 'Diciembre' END ";
        
        $sql = "SELECT ".$cabecera." as mes ,
                       sum(afectacion_has) as total 
                 FROM bomberos.view_emergencias
                where anio =".$this->bd->sqlvalue_inyeccion($anio ,true)."
                group by mes";
             

  
        $resultado= $this->bd->ejecutar($sql);
        
        $this->cabecera( );
        
         
        
        while ($y=$this->bd->obtener_fila($resultado)){
             
             echo '<tr>
 	            <td style="text-align: left;padding: 5px"  >'.$y['mes'].'</td>
                <td style="text-align: right;padding: 5px"   >'.$y['total'].'</td> <tr>';
            
 
        }
         
        
        $ViewGrupo.='</table>';
        
        echo $ViewGrupo;
 
         
        
       
        
    }
   
    //----
    function cabecera( ){
        
        echo    '<table  width="100%">
        <tr>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="80%">Tipo de Emergencias</th>
        <th  style="text-align: center;padding: 5px"   bgcolor="lightblue" width="20%">Total Has Afectadas</th>
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

//$gestion->consultaId( );



?>
 
  