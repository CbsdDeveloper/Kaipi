<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
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
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =     $_SESSION['email'];
        
        $this->hoy 	     =     date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'nro_memo',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor =>'orden', key => 'N'),
            array( campo => 'asunto',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => 'orden', key => 'N')
        );
        
 
        
        $this->tabla 	  	  = 'presupuesto.pre_tramite';
        $this->secuencia 	  = 'presupuesto.pre_tramite_id_tramite_seq';
 
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        
        return $this->bd->resultadoCRUD('ACTUALIZACION',$accion,$id,$tipo);
        
    }
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($id_cotizacion ){
        
        
        $sql = "SELECT nro_memo, asunto,fcertifica,comprobante,fcompromiso,id_asiento_ref,idprov,proveedor,correo
              FROM presupuesto.view_pre_tramite
             WHERE id_tramite =".$this->bd->sqlvalue_inyeccion($id_cotizacion,true) ;
        
        $resultado = $this->bd->ejecutar($sql);
        
        $dataProv  = $this->bd->obtener_array( $resultado);
        
        return $dataProv;
        
        
 
        
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
 
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id );
            
        }
       
        
    }
     
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion(  $id_cotizacion,$editor2,$memo ){
        
         $this->ATabla[1][valor] =   $memo       ;
         $this->ATabla[2][valor] =   $editor2	     ;
         
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,trim($id_cotizacion));
        
        $data = 'Generado';
       
        echo $data;
    }
    //------------------------------------
    function _comprobante_(    ){
        
        $anio 	     =     date("Y");
        
        
        $ADatos = $this->bd->query_array(
            'ven_registro',
            " orden::int + 1 as secuencia",
            'idven_registro='.$this->bd->sqlvalue_inyeccion( 1,true)
            );
        
        $contador = $ADatos['secuencia'] ;
        
        $comprobante =str_pad($contador, 6, "0", STR_PAD_LEFT).'-'.$anio;
        
        
        $sql = 'update ven_registro
                        set orden='.$this->bd->sqlvalue_inyeccion($contador,true).'
                        where idven_registro = '.$this->bd->sqlvalue_inyeccion('1',true);
        
        $this->bd->ejecutar($sql);
        
        
        return $comprobante ;
        
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
 
    
     $id_cotizacion   = $_POST['id_certifica'];
     $editor2         = $_POST['editor2'];
     $memo            = $_POST['memo'];
     
     $accion = $_POST['accion'];
     
     if ( $accion == 'edit') {
               
             $gestion->edicion( $id_cotizacion,$editor2,$memo);
             
         
     }
     
   
     if (isset($_GET['accion']))	{
         
         $accion         = $_GET['accion'];
         
         $id_cotizacion  = $_GET['id_certifica'];
         
         $AResultado = $gestion->consultaId( $id_cotizacion);
          
         $nro_memo = trim( $AResultado['nro_memo'] );
         
         $fcertifica =  ( $AResultado['fcertifica'] );
         
         $fcompromiso =  ( $AResultado['fcompromiso'] );
     
         $asunto   =  htmlspecialchars( trim($AResultado['asunto'])) ;
         
         $comprobante =  trim( $AResultado['comprobante'] );
         
         $idasiento1=  trim( $AResultado['id_asiento_ref'] );
         
        
         
         $idprov=  trim( $AResultado['idprov'] );
         
         $proveedor=  trim( $AResultado['proveedor'] );
         
          
         echo json_encode(
             array("a"=> $asunto ,
                   "b"=> $nro_memo,
                   "c"=> $fcertifica,
                   "d"=> $comprobante,
                 "e"=> $fcompromiso,
                 "f"=> $idasiento1,
                 "g"=> $idprov,
                 "h"=> $proveedor
             )
             
             );
         
         
         
     }  
     
      
 
 
 
 

?>
 
  