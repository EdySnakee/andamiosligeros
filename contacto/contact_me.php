<?php
// Check for empty fields
print_r($_POST);
if(
	empty($_POST['name'])     ||
   empty($_POST['email'])     ||
   empty($_POST['telefono'])  ||
   empty($_POST['celular'])   ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "Sin datos que procesar!";
   return false;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$telefono = strip_tags(htmlspecialchars($_POST['telefono']));
$celular = strip_tags(htmlspecialchars($_POST['celular']));
$message = strip_tags(htmlspecialchars($_POST['message']));
   
// Create the email and send the message
$to = 'lalo@eurekamid.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Formulario de contacto:  $name";
$email_body = "Has recibido un nuevo mensaje de tu formulario de contacto de redesanticaidas.mx.\n\n"."Aqui estan los detalles:\n\nNombre: $name\n\nEmail: $email_address\n\nTeléfono: $telefono\n\nCelular: $celular\n\nMensaje:\n$message";
$headers = "From: Contacto desde redesanticaidas.mx\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";   
mail($to,$email_subject,$email_body,$headers);
return true;         
?>