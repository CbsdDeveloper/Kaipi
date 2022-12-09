<?php 
session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
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
       function Formulario( $GET ){
            
        $id_rubro =  $GET['id'];
 
        $tipo = $this->bd->retorna_tipo();
        
        $datos = array();
        


        $sql_det1 = 'SELECT etiqueta
                    FROM rentas.ren_rubros_var
                    where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true).
                   'group by etiqueta ORDER BY etiqueta ASC' ;


        $stmt1 = $this->bd->ejecutar($sql_det1);



        while ($xx=$this->bd->obtener_fila($stmt1)){


            $etiqueta  = trim($xx['etiqueta']) ;

            $this->set->div_label(12, '<b>'. $etiqueta.'</b>');
            
            $this->crea_formulario( $etiqueta, $id_rubro );


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
  function crea_formulario(  $etiqueta, $id_rubro  ){
       

    $tipo = $this->bd->retorna_tipo();
            
        $sql_det2 = 'SELECT id_rubro_var, nombre_variable,  imprime, tipo, requerido,
                            lista,id_catalogo,variable_formula, variable,relacion,catalogo_variable,columna, etiqueta
                    FROM rentas.ren_rubros_var
                    where id_rubro = '.$this->bd->sqlvalue_inyeccion($id_rubro,true).' and 
                          etiqueta = '.$this->bd->sqlvalue_inyeccion($etiqueta,true).
                   ' ORDER BY id_rubro_var' ;
                            
 
                   $stmt2 = $this->bd->ejecutar($sql_det2);
  
      
        
        
        while ($x=$this->bd->obtener_fila($stmt2)){
            
     
            $objeto  = trim($x['variable']) ;

            $nombre_etiqueta = trim($x['nombre_variable']);

            if (   trim($x['columna']) == '1'  ){
                    $div = 'div-2-10';
            }else {
                    $div = 'div-2-4';
            }

            if (   trim($x['requerido']) == 'S'  ){
                   $reque1 = 'required';
                   $nombre_etiqueta  = '<b>'.$nombre_etiqueta .'</b>';
             }else {
                   $reque1 = '';
             }
                
            
            
            $variable = $x['id_rubro_var'].",".$id_rubro.",this.value,"."'".trim($x['nombre_variable'])."'";
            
            $evento = '';
            
            $variable = '';
            
            $datos[$objeto] = $variable;
            
            if ( trim($x['tipo']) == 'L') {
                
                $MATRIZ = $this->lista(trim($x['lista']));
                
                $this->obj->list->listae($nombre_etiqueta,$MATRIZ, $objeto, $datos, $reque1, '',$evento, $div);
                
            }
            
            if ( trim($x['tipo']) == 'C') {
                
                $this->obj->text->texte( $nombre_etiqueta,"texto",$objeto,130,130,$datos, $reque1,'',$evento,$div);
                
            }
            
            if ( trim($x['tipo']) == 'N') {
                
                $this->obj->text->texte( $nombre_etiqueta,"number",$objeto,130,130,$datos, $reque1,'',$evento,$div);
                
            }
            
            if ( trim($x['tipo']) == 'F') {
                
                $this->obj->text->texte( $nombre_etiqueta,"date",$objeto,130,130,$datos, $reque1,'',$evento,$div);
                
            }
            
            if ( trim($x['tipo']) == 'B') {
                
                $catalogo = trim(strtoupper ($x['id_catalogo']));
                
                $sql = "SELECT '0' as codigo, ' [  0. CATALOGOS DISPONIBLES ] ' as nombre UNION
                        SELECT  idcatalogo as codigo, upper(nombre) as nombre
                    FROM par_catalogo
                    where  upper(tipo)  = ".$this->bd->sqlvalue_inyeccion($catalogo,true) ."
                    order by 1 " ;
                
                 
                $relacion = trim($x['relacion']);
                 
                $valida = strlen($relacion);
                 
                if ( $valida < 2 ) {
                    $evento = '';
                    
                }else {
                    
                    $xy = $this->bd->query_array('rentas.ren_rubros_var',   
                        'variable',                  
                        'id_catalogo='.$this->bd->sqlvalue_inyeccion($relacion,true)  
                        );
                    
                    $variable = "'".trim($xy['variable'])."'";
    
                    $evento = 'Onchange="relacion_dato(this.value,'.$variable.')"';
                }
            
                $resultado =  $this->bd->ejecutar($sql);
                
                $this->obj->list->listadbe($resultado,$tipo, $nombre_etiqueta,$objeto,$datos, $reque1,'',$evento,$div);
                
            }
            
        }

       
 
    
   }  
 }    
 
 
   $gestion   = 	new componente;
   
 
   $gestion->Formulario( $_GET );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>