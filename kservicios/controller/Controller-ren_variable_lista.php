<?php
session_start();

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
        
        $this->bd	   =	     	new Db ;
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    
    
    function Formulario( ){
        
        $datos = array();
        
        $tipo = $this->bd->retorna_tipo();
        
        $MATRIZ = array(
            'C'    => 'Texto',
            'N'    => 'Numerico',
            'F'    => 'Fecha',
            'L'    => 'Lista Corta',
            'B'    => 'Lista Catalogo',
        );

        $MATRIZ2 = array(
            '1'    => 'Columna 1',
            '2'    => 'Columna 2',
         );

         $MATRIZ3 = array(
            'N'    => 'NO',
            'S'    => 'SI',
         );

         

        $MATRIZ1 =  $this->obj->array->catalogo_sino();

      
        
                    $this->obj->list->lista('Tipo Variable',$MATRIZ,'tipo',$datos,'required','','div-2-10');
                    
                    $this->obj->text->text_yellow('Grupo Etiqueta',"texto",'etiqueta',50,50,$datos,'required','','div-2-10') ;

                    $this->obj->text->text_blue('Nombre Variable',"texto",'nombre_variable',50,50,$datos,'required','','div-2-10') ;
                     
                    $this->obj->list->lista('Imprime',$MATRIZ1,'imprime',$datos,'required','','div-2-4');
          
                    $this->obj->list->lista('Publica',$MATRIZ1,'publica',$datos,'required','','div-2-4');

                    $this->obj->list->lista('Columna',$MATRIZ2,'columna',$datos,'required','','div-2-4');

                    $this->obj->list->lista('Requerido',$MATRIZ3,'requerido',$datos,'required','','div-2-4');
        
        
        $this->set->div_label(12,'Lista de Datos');
        
        $sql = "SELECT '-' as codigo, ' --  0. CATALOGOS DISPONIBLES  -- ' as nombre UNION
                        SELECT  upper(trim(tipo)) as codigo, upper(trim(tipo)) as nombre
                        FROM par_catalogo where modulo = 'S'
                        group by tipo
                        order by 2 " ;
        
        $resultado =  $this->bd->ejecutar($sql);
        $this->obj->list->listadb($resultado,$tipo,'Lista Catalogo','id_catalogo',$datos,'required','','div-2-10');
        
         
        $this->obj->text->editor('Lista Corta (,)','lista',3,45,300,$datos,'required','','div-2-6') ;
        
        $this->obj->text->text('Variable',"texto" ,'variable' ,80,80, $datos ,'','readonly','div-1-3') ;
        
        $this->set->div_label(12,'Relacion con variable');
        
        $sql = "SELECT '-' as codigo, ' [  -  ] ' as nombre UNION
                        SELECT  upper(trim(id_catalogo)) as codigo, upper(trim(id_catalogo)) as nombre
                        FROM rentas.ren_rubros_var
                        where tipo = 'B'
                        order by 2 " ;
 
            
        $resultado =  $this->bd->ejecutar($sql);
        $this->obj->list->listadb($resultado,$tipo,'Catalogo Relacionado','relacion',$datos,'required','','div-2-10');
        
        
        $this->obj->text->texto_oculto("action_variable",$datos);
        
        $this->obj->text->texto_oculto("id_rubro_var",$datos);
        
        
    }
    
    
    //----------------------------------------------
    function header_titulo($titulo){
        
        $this->set->header_titulo($titulo);
        
    }
    
    
    
    ///------------------------------------------------------------------------
    ///------------------------------------------------------------------------
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------


$gestion   = 	new componente;


$gestion->Formulario( );

?>