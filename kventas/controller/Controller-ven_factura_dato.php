<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
                
       }
     //---------------------------------------
       function Formulario( $idcategoria , $id_movimiento){
       
         
        $datos = array();
           
        $sql_det1 = 'SELECT idcategoriavar, idcategoria, nombre_variable,  imprime, tipo, lista
                    FROM web_categoria_var
                    where idcategoria = '.$this->bd->sqlvalue_inyeccion($idcategoria,true) .' and 
                          registro = '.$this->bd->sqlvalue_inyeccion($this->ruc ,true) ;
                            
        
        
        $stmt1 = $this->bd->ejecutar($sql_det1);
        
        
        while ($x=$this->bd->obtener_fila($stmt1)){
           
            $objeto  = trim($x['nombre_variable']).'_'.$x['idcategoriavar'].'_'.$idcategoria ;
            
            $variable = $x['idcategoriavar'].",".$idcategoria.",this.value,"."'".trim($x['nombre_variable'])."'";
            
            $evento = 'onChange="GuardaVariable('.$variable.')"';
            
            $variable = $this->busca_dato($id_movimiento,$x['idcategoriavar']);
            
            $datos[$objeto] = $variable;
            
            if ( trim($x['tipo']) == 'L') {
                 
                 $MATRIZ = $this->lista(trim($x['lista']));
                
                 $this->obj->list->listae( trim($x['nombre_variable']),$MATRIZ, $objeto, $datos,'required', '',$evento,'div-3-9');
                
            }else {
                
                 $this->obj->text->texte( trim($x['nombre_variable']),"texto",$objeto,130,130,$datos,'required','',$evento,'div-3-9') ;
                
            }
            
            
        }
 
      
   }
 //----------------------------------------------
   function lista($lista){
       
       $pieces = explode(",", $lista);
       
       $a = array();
       $b = array();
       
       foreach($pieces as $elemento)
       {
           
           $a[] = $elemento;
           $b[] = $elemento;
           
       }
       
       $MATRIZ = array_combine ($a ,  $b);
       
       return $MATRIZ;
       
   }  
   //-----------------------------------------------
   function busca_dato($id_movimiento,$idcategoriavar){
       
       $x =  $this->bd->query_array('inv_movimiento_var',
           'valor_variable',
           'id_movimiento='. $this->bd->sqlvalue_inyeccion($id_movimiento,true). ' and
           idcategoriavar='. $this->bd->sqlvalue_inyeccion($idcategoriavar,true)
           );
     
  
       return trim($x['valor_variable']);
       
   }  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $idcategoria   =  $_GET['idcategoria'];
   $id_movimiento =  $_GET['id_movimiento'];
   
   $gestion->Formulario( $idcategoria,$id_movimiento );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>