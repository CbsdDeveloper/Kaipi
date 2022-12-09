<?php   
/*
$fechaUno=new DateTime('07:56:23');
$fechaDos=new DateTime('08:30:00');

$dateInterval = $fechaUno->diff($fechaDos);

echo $dateInterval->format('Total: %H horas %i minutos %s segundos').PHP_EOL;


$entrada=new DateTime('07:56:23');
$salida=new DateTime('08:30:00');
 

$diferencia = $entrada->diff($salida);

echo $diferencia->format("%H:%i"); 

*/

$email_a = 'jose@kaipi.com';

if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
    echo "Esta dirección de correo ($email_a) es válida.";
}else {
    echo "Esta dirección de correo ($email_a) es No válida.";
}

     
 ?>