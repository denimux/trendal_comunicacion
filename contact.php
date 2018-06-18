
<?php

$data = array();

$Nombre = $_POST['name'];
$Correo = $_POST['email'];
$Asunto = $_POST['subject'];
$Mensaje = $_POST['message'];
$Telefono = $_POST['phone'];

// Retrieve the email template required
$message = file_get_contents('templates/email.html');



require("includes/class.phpmailer.php");
$mail = new PHPMailer();

$mail->From     = ("contacto@trendal.com.mx"); //Dirección desde la que se enviarán los mensajes. Debe ser la misma de los datos de el servidor SMTP.
$mail->FromName = $Nombre;
$mail->setFrom = $Correo;
$mail->addReplyTo($Correo, $Nombre);
$mail->AddAddress("mcomi@hotmail.com"); // Dirección a la que llegaran los mensajes.
$mail->AddAddress("alfonso@trendal.com.mx");
$mail->AddAddress("manuel@trendal.com.mx");
$mail->AddAddress("lucia@trendal.com.mx");
//$mail->AddCC("mcomi@hotmail.com");

// Aquí van los datos que apareceran en el correo que reciba

$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject  =  "Contacto desde trendal.com.mx";
// $mail->Body     =  "Nombre: $Nombre \n<br />".
// "Email: $Correo \n<br />".
// "Empresa: $Empresa \n<br />".
// "Interés: $Interes \n<br />".
// "Tel: $Telefono \n<br />".
// "Mensaje: $Mensaje \n<br />";
//Set the message
// Replace the % with the actual information
$image = '<img src="cid:logo" alt="" width="100%;">';

$message = str_replace('$image$', $image, $message);
$message = str_replace('$nombre$', $Nombre, $message);
$message = str_replace('$correo$', $Correo, $message);
$message = str_replace('$telefono$', $Telefono, $message);
$message = str_replace('$asunto$', $Asunto, $message);
$message = str_replace('$mensaje$', $Mensaje, $message);


$mail->AddEmbeddedImage('img/logo.png', 'logo', 'logo.png');
$mail->MsgHTML($message);
$mail->AltBody = strip_tags($message);
// Datos del servidor SMTP

$mail->IsSMTP();
$mail->Host = "p3plcpnl0540.prod.phx3.secureserver.net";  // Servidor de Salida.
$mail->SMTPAuth = true;
$mail->Username = "contacto@trendal.com.mx";  // Correo Electrónico
$mail->Password = "Trendalcontrasena1"; // Contraseña

header('Content-type: application/json; charset=utf-8');
if (!$mail->send()){
  $data['success'] = false;
  echo $message;
  echo "Mailer Error: " . $mail->ErrorInfo;
  echo json_encode($data);
} else {
  $data['success'] = true;
  echo json_encode($data);
}

?>
