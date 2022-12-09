<?php
include('Obj.grid.php');
include('Obj.var.php');
include('Obj.ajax.php');
include('Obj.array.php');
include('Obj.list.php');
include('Obj.boton.php');
include('Obj.text.php');
include('Obj.table.php');
 
 
 class objects{
 
      private static $_instance;
  
      //creamos la variable donde se instanciar 
      public $objects_grid;
	  public $objects_var;
	  public $objects_ajax;
	  public $objects_list;
	  public $objects_table;
	   
 
	  function __construct(){
		     //inicializamos la clase para conectarnos a la bd
         $this->grid    = new objects_grid(); //instanciamos la clase
		 $this->var     = new objects_var(); //instanciamos la clase
		 $this->ajax    = new objects_ajax();
		 $this->array   = new objects_array();
		 $this->list    = new objects_list();
		 $this->boton   = new objects_boton();
		 $this->text    = new objects_text();
		 $this->table   = new objects_table();
	   }

 
       function __destruct() {
       // print "Destruyendo " . $this->name . "\n";
      }   
 
}

?>