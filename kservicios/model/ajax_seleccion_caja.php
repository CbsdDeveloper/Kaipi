<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $anio;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    
    function proceso( ){
         
        $this->obj     = 	new objects;
        $this->bd     = 	new Db;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date('Y-m-d');
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
    }
   
    //------------------------------------------
    function Actualiza_datos($id,$estado){
        

        if ( $estado == 'S'){

            $seleccion = 1;

        }else
        {

            $seleccion = 0;

        } 

        $sql = 'UPDATE   co_asiento
                SET      opago = '.$this->bd->sqlvalue_inyeccion($seleccion, true).' 
                WHERE id_asiento ='.$this->bd->sqlvalue_inyeccion($id, true);

        $this->bd->ejecutar($sql);
 

        $x = $this->bd->query_array('rentas.view_diario_caja ',   
        'sum(debe) as total',                  
        'opago='.$this->bd->sqlvalue_inyeccion('1',true) ." and estado_pago= 'N' "
        );


        echo $x['total'];
 
     }
         
    
}
//------------------------------------------------------------------------
// Llama de la clase para creacion de formulario de busqueda
//------------------------------------------------------------------------
$gestion         = 	new proceso;


 
$id         = $_GET['id'];
$estado     = trim($_GET['estado']);

 
        $gestion->Actualiza_datos($id,$estado) ;
 
 


?>