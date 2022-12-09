  <?php
//lo primero cargar la librería
require '../PHPMailerAutoload.php';
//lo segundo, crear el objeto mail
$mail = new PHPMailer();
//Vamos a meter el cuerpo (cargado desde un html externo) en una variable
$body = file_get_contents('contents.html');
//definimos el uso de smtp
$mail->isSMTP();
//definimos el servidor que aloja nuestro correo
$mail->Host = 'smtp.tuserver.com';
//activamos la autenticación smtp
$mail->SMTPAuth = true;
//Con esta línea dejamos abierta la conexión al servidor smtp
$mail->SMTPKeepAlive = true; 
//Definimos la seguridad, si nuestro server lo permite lo mejor es usar tls
$mail->SMTPSecure = 'tls';
//el puerto cambia según la seguridad. Para tls este, para ssl 456 y sin seguridad el 25
$mail->Port = 587;
//definimos usuario y contraseña
$mail->Username = 'tucorreo@tudominio.com';
$mail->Password = 'tu contraseña';
//ahora definimos remitente y si hace falta, réplica
$mail->setFrom('miwebe@midominio.com', 'Lista');
$mail->addReplyTo('miwebe@midominio.com', 'Lista');
 
$mail->Subject = "Ejemplo de lista con phpmailer";
 
//Vamos ahora a crear un objeto de conexión a la base de datos
//Tras eso, vamos a recuperar los datos que necesitamos:
$mysqli = new mysqli('server', 'username', 'password', 'db');
$mysqli->set_charset("utf8")
$result = $mysqli->query("SELECT nombre, email FROM mailinglist");
 
//ahora en bluce vamos recorriendo los resultados y enviando correos
 
while ($row = $result->fetch_array()) {
    $mail->AltBody = 'Para ver el menasje, please use un  visor de email compatible con HTML';
    $mail->msgHTML($body);
    $mail->addAddress($row['email'], $row['nombre']);
     
    if (!$mail->send()) {
        echo "Mailer Error:" . $mail->ErrorInfo . "<br />";
        break; //forzamos la salida del bucle en caso de error
    } 
    // Limpiamos los datos par próximos envíos
    $mail->clearAddresses();
    $mail->clearAttachments();
}