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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  date("Y-m-d");
                
                $this->anio       =  $_SESSION['anio'];
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario(){
      
        $tipo = $this->bd->retorna_tipo();
      
        echo '<div class="col-md-4">
               <div class="panel panel-info">
                <div class="panel-heading">Periodo Filtro</div>
                 <div class="panel-body"> ';
        
         
        $datos['ffecha1'] = $this->bd->_primer_dia($this->hoy);
        
        $datos['ffecha2'] = $this->bd->_actual_dia($this->hoy);
 
      	$this->obj->text->input_filtro("date",'ffecha1',$datos,'Fecha Inicio');
      	
      	$this->obj->text->input_filtro("date",'ffecha2',$datos,'Fecha Final');
      	
      	
      	$this->set->div_label(12,'Parametros Financieros');	 
       	
      	
      	$x = $this->bd->query_array(
      	    'web_registro',
      	    'codigo1, unidade', 
      	    'ruc_registro='.$this->bd->sqlvalue_inyeccion($this->ruc ,true)
      	    );
      	
      	
      	$datos['codigoc']  = $x['codigo1'] ;
      	$datos['unidade'] = $x['unidade'];
      	
      	$this->obj->text->text('Codigo Presupuestario',"texto",'codigoc',4,4,$datos,'required','','div-6-6');
      	
      	$this->obj->text->text('Unidad Ejecutora',"texto",'unidade',4,4,$datos,'required','','div-6-6');
      	
      	
      	echo '</div> </div> </div>';
      	
      	
      	echo '<div class="col-md-4">
               <div class="panel panel-info">
                <div class="panel-heading">Estructura Contable</div>
                 <div class="panel-body">';
      	
       	
      	$sql = "select '-' as codigo, '[ Cuentas Movimiento ]' as nombre from co_plan_ctas where cuenta = '1'
                            union select a.cuenta as codigo, a.cuenta || ' ' || b.detalle as nombre 
                           from co_diario a , co_plan_ctas b
                            where    a.registro =  b.registro and
                                     a.cuenta = b.cuenta and
                                     a.registro = ".$this->bd->sqlvalue_inyeccion($this->ruc, true).' and 
                                     a.anio = '.$this->bd->sqlvalue_inyeccion($this->anio, true).' and
                                     b.anio = '.$this->bd->sqlvalue_inyeccion($this->anio, true).' 
                            group by a.cuenta, b.detalle
                            order by 1';
      	
      	$resultado = $this->bd->ejecutar( $sql);
       	
      	
      	$this->obj->list->listadb_filtro($resultado,$tipo,'cuenta',$datos);
      	
      	$evento ='';
      	
      	$MATRIZ = array(
      	    '0'    => '[ Nivel Cuenta ]',
      	    '1'    => 'Nivel 1',
      	    '2'    => 'Nivel 2',
      	    '3'    => 'Nivel 3',
      	    '4'    => 'Nivel 4',
      	    '5'    => 'Nivel 5',
      	    '6'    => 'Nivel 6',
      	    '-1'    => 'Cuentas de Movimiento',
      	);
      	
      	$this->obj->list->lista_filtro($MATRIZ,'nivel',$datos,$evento);
       
      	
      	$MATRIZ = array(
      	    '-'    => '[ Grupo Contable ]',
      	    'A'    => 'Activo',
      	    'P'    => 'Pasivo',
      	    'T'    => 'Patrimonio',
      	    'I'    => 'Ingreso',
      	    'G'    => 'Costo',
      	    'G'    => 'Gasto'
      	);
      	
      	$this->obj->list->lista_filtro($MATRIZ,'tipo',$datos,$evento);
      	
      	echo '</div> </div> </div>';
      	
      	echo '<div class="col-md-4">
               <div class="panel panel-info">
                <div class="panel-heading">Parametros contables</div>
                 <div class="panel-body">';
      	
       	
      	$this->obj->text->input_filtro("texto",'cuentat',$datos,'Filtro por cuenta');
      	
      	$this->obj->text->input_filtro("number",'id_asiento',$datos,'Filtro por nro. asiento');
      	
 
      	$MATRIZ = array(
      	    '-'    => '[ Auxiliares ]',
      	    'N'    => 'NO',
      	    'S'    => 'SI'
       	);
      	
      	$this->obj->list->lista_filtro($MATRIZ,'auxiliares',$datos,$evento);
      	
      
      	echo '</div> </div> </div>';
      	
      	
      	
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
 
   $gestion->FiltroFormulario( );

 ?>


 
  