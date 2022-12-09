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
    public function BusquedaGrilla( $user ){
        
        //idvengestion
        
        $Responsable = $this->bd->query_array('par_usuario',
            'responsable', 'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        
        $tipo = $this->bd->retorna_tipo();
        
        
        $resultado = $this->bd->ejecutar("select sesion as codigo, sesion as nombre
                								from ven_cliente  group by sesion order by sesion ");
        
        
        if ($Responsable['responsable'] == 'S'){
            
            $evento = 'onChange="filtroUser(this.value)"';
            
            $lista = $this->obj->list->listadb_ajaxe($resultado,$tipo,'idsesion',$datos,'','',$evento);
            
            echo $lista.'<br>';
        }
        
        
        
        if ($user == '-'){
           $sql = 'SELECT fecha, sesion,estado,razon,idprov,novedad,idvengestion
                  FROM  ven_cliente_seg
                  where estado   in (8,9) and
                        sesion ='.$this->bd->sqlvalue_inyeccion( trim($this->sesion), true);
     
        }else {
            $sql = 'SELECT fecha, sesion,estado,razon,idprov,novedad,idvengestion
                  FROM  ven_cliente_seg
                  where estado  in (8,9 )  and
                        sesion ='.$this->bd->sqlvalue_inyeccion( trim($user), true);
            
        }
        
        $i = 0;
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $ViewFormLista= '<ul class="list-group">';
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idprov = "'". trim($fetch['idprov']) ."'";
            
            $nombre = "'". trim($fetch['razon']) ."'";
            
            $idvengestion = $fetch['idvengestion']   ;
            
            $evento = ' onClick="VerActividad('.$idprov.','.$nombre.','.$idvengestion.')" ';
            
            $ViewFormLista .= ' <li class="list-group-item"> <a href="#" '.$evento.' >'.$fetch['razon'].'</a></li>';
            
            
            $i ++;
            
        }
        
        
        
        $ViewFormLista .= '</ul><br>Registros '. $i ;
        
        
        echo $ViewFormLista;
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


//------ poner informacion en los campos del sistema
if (isset($_GET['user']))	{
    
    $user   = $_GET[ 'user'];
    
    
}else {
    
    $user      =  '-';
    
}



$gestion->BusquedaGrilla( $user );





?>
 
  