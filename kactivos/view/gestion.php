<?php 
     
  $impresora='ZEBRA';
 
require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


        $id=$_POST['id'];
        $accion=$_POST['accion'];


        if(!empty($id) && $accion=='imp'){

        consultar($id);

        }

        if(!empty($id) && $accion=='impre'){


        imprimir($id,$impresora);

        }

  /* Funcion que consulta el codigo del bien*/

       function consultar($id){
        require 'conexion.php';
 
        $sql = 'SELECT *From activo.view_bienes WHERE id_bien ='.$id;


        $resultado= pg_query( $link, $sql );

        while($col = pg_fetch_object($resultado))
        {
        $variables['nombre']=$col->descripcion;
        $variables['codigo']=$col->tipo_bien.'-'.$col->cuenta.'-'.$col->id_bien;
        }

        echo  $variables['codigo'];
    
        }


 /* Funcion que imprime el codigo del bien*/

        function imprimir($id,$impresora){


        require 'conexion.php';

 
        $sql = 'SELECT *From activo.view_bienes WHERE id_bien ='.$id;


        $resultado= pg_query( $link, $sql );

        while($col = pg_fetch_object($resultado))
        {
        $variables['nombre']=$col->descripcion;
        $variables['codigo']=$col->tipo_bien.'-'.$col->cuenta.'-'.$col->id_bien;
        }
        
        $connector = new WindowsPrintConnector($impresora);
        $printer = new Printer($connector);
        
        $printer->setFont();
        // Reset
        $printer->cut();
        /* Justification */
        $justification = array(Printer::JUSTIFY_LEFT, Printer::JUSTIFY_CENTER, Printer::JUSTIFY_RIGHT);
        for ($i = 0; $i < count($justification); $i++) {
        $printer->setJustification($justification[$i]);
        $printer->text($variables['nombre']);
        }
        $printer->setJustification();
        // Reset
        $printer->cut();
        /* Barcodes - see barcode.php for more detail */
        $printer->setBarcodeHeight(80);
        $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
        $printer->barcode($variables['codigo']);
        $printer->feed();
        $printer->cut();
        /* Graphics - this demo will not work on some non-Epson printers */
        try {
        $logo = EscposImage::load("Logocbsd.png", false);
        $imgModes = array(Printer::IMG_DEFAULT, Printer::IMG_DOUBLE_WIDTH, Printer::IMG_DOUBLE_HEIGHT, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
        foreach ($imgModes as $mode) {
        $printer->graphics($logo, $mode);
        }
        } catch (Exception $e) {
        /* Images not supported on your PHP, or image file not found */
        $printer->text($e->getMessage() . "\n");
        }
        $printer->cut();
        /* Bit image */

        


}

        
            
 
   
 ?>
 
  