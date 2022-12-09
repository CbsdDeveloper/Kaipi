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
        
        
        
        
        $sql = 'SELECT idvengestion, idprov, razon, estado, medio, canal,
        sesion, novedad, fecha, producto, porcentaje
                  FROM  ven_cliente_seg
                  where registro =  '.$this->bd->sqlvalue_inyeccion( trim($this->ruc), true).' and 
                       sesion ='.$this->bd->sqlvalue_inyeccion( trim($this->sesion), true).' 
                    order by idvengestion desc LIMIT 5 OFFSET 1' ;
 
   
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $numero=0;
        
        $izquierda = '<div class="media">
                       <div class="media-left">
                            <img src="../../kimages/star.png" class="media-object" style="width:20px">
                        </div>
                         <div class="media-body">';
     
        $derecha = '<div class="media">
                          <div class="media-body">';
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            if ($numero%2==0){
                echo $izquierda;
                echo '<h6 class="media-heading">'. $fetch['razon'].'</h6>
                      <p>'. $fetch['novedad'].'. '. $fetch['producto'].'</p>
                    </div>
                  </div>';
            }else{
                echo $derecha;
                echo '<h6 class="media-heading">'. $fetch['razon'].'</h6>
                      <p>'. $fetch['novedad'].'. '. $fetch['producto'].'</p></div>
                         <div class="media-right">
                            <img src="../../kimages/star.png" class="media-object" style="width:20px">
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
 
  