<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get the form fields and remove whitespace.
print_r($_POST);
$name = strip_tags(trim($_POST["name"]));
$name = str_replace(array("\r","\n"),array(" "," "),$name);
$subject = strip_tags(trim($_POST["msg_subject"]));
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL); 
$phone = trim($_POST["phone_number"]);
$recipient =filter_var(trim($_POST["recipientEmail"]), FILTER_SANITIZE_EMAIL); 
$message = trim($_POST["message"]);

// Build the email content.
$email_content = "Name: $name\n";
$email_content .= "Email: $email\n";
$email_content .= "Phone: $phone\n";
$email_content .= "Message:\n$message\n";

// Build the email headers.
$email_headers = "From: $name <$email>";

// Send the email.
$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 0;                                       
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com;';                    
    $mail->SMTPAuth   = true;                             
    $mail->Username   = 'poojap.elentrika@gmail.com';                 
    $mail->Password   = 'xhydwgqllzskiasj';                        
    $mail->SMTPSecure = 'tls';                              
    $mail->Port       = 587;  
  
    $mail->setFrom('poojap.elentrika@gmail.com', 'Pooja');           
    $mail->addAddress('patlepk@rknec.edu');
    $mail->addAddress('patlepk@rknec.edu', 'Pooja P');
       
    $mail->isHTML(true);                                  
    $mail->Subject = $subject;
    $mail->MsgHTML($email_content);
    // $mail->Body    = 'HTML message body '.$name.'in <b>bold'.$email.'</b> '.$phone;
    // $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
