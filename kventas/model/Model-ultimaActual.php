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
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla( ){
        
        
        
        
        $sql = 'SELECT fecha, sesion,detalle, acceso,razon
                  FROM  ven_cliente
                  where registro =  '.$this->bd->sqlvalue_inyeccion( trim($this->ruc), true).' and 
                        estado <>'.$this->bd->sqlvalue_inyeccion( 'S', true).' 
                    order by fecha desc LIMIT 5 OFFSET 1' ;
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $numero=0;
        
        $izquierda = '<div class="media">
                       <div class="media-left">
                            <img src="../../kimages/if_comment_user_36887.png" class="media-object" style="width:32px">
                        </div>
                         <div class="media-body">';
     
        $derecha = '<div class="media">
                          <div class="media-body">';
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            if ($numero%2==0){
                echo $izquierda;
                echo '<h6 class="media-heading">'. $fetch['sesion'].'</h6>
                      <p>'. $fetch['razon'].'. '. $fetch['detalle'].'</p>
                    </div>
                  </div>';
            }else{
                echo $derecha;
                echo '<h6 class="media-heading">'. $fetch['sesion'].'</h6>
                      <p>'. $fetch['razon'].'. '. $fetch['detalle'].'</p></div>
                         <div class="media-right">
                            <img src="../../kimages/if_comment_user_36887.png" class="media-object" style="width:32px">
                        </div>
                   </div>';
            }
 
            $numero ++;
        }
        
        
   
        
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------

    $gestion   = 	new proceso;

 
    $gestion->BusquedaGrilla( );
    
 


?>
 
  