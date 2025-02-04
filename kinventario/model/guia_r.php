<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
/*

$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;

     $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
     
     insert into spo_cabecera (coddoc,estab,ptoemi,secuencial,
                               dirpartida,
                               razonsocialcomprador,tipoidentificacioncomprador,identificacioncomprador,
                               rise,fechaemision,fechafintransporte,
                               placa,gad,ruc)
     values ('06','001','001','000000001',
             '10 de agosto',
         'Fernando Pulupa Pasquel','05','1716566391',
         '123456','2018-09-24','2018-09-25',
         'AAA-0001','05','1716566391001');
     
     --razonsocialcomprador es razon social chofer
     --tipoidentificacioncomprador es tipo identifiacion chofer
     --identificacioncomprador es identifiacion chofer
     --rise en caaso de aplicar
     --fechaemision es fechainicion transporte
     
     
     insert into spo_destinatario (des_cabecera,identificaciondestinatario,razonsocialdestinatario,
         dirdestinatario,motivotraslado,docaduanerounico,
         codestabdestino,ruta,coddocsustento,
         numdocsustento,numautdocsustento,fechaemisiondocsustento)
     values (121525,'1716566391','Fernando',
         '10 de agosto','Cambio de casa',null
         ,null,'Quito - Cayambe','01',
         '001-001-000000456','2409201801170117498700120010010000004561256890712','2018-09-24');
     
     --docaduanerounico no obligatorio
     --codestabdestino no obligatorio
     
     insert into spo_destinatario_detalle (dde_destinatario,codigointerno,codigoadicional,descripcion,cantidad)
     values (1,'AAAA','AAAA','Descropcipon',1)
     
     
     insert into spo_destinatario_detalle_adicional (dda_destinatario_detalle,dda_nombre,dda_valor)
     values (1,'Marcha','Chevrolet')
     
     
     
     insert into spo_informacion_adicional (iad_cabecera,ida_nombre,ida_valor)
     values (121525,'E-Mail','fensefernando@gmail.com')
    
    ?>					 
 
 */
 