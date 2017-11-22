<?php

use Slim\Http\Request;
use Slim\Http\Response;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Routes
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    if(false){
        $conf = $this->get('settings');
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->SMTPSecure = $conf['mailer']['SMTPSecure'];
            $mail->Username = $conf['mailer']['Username'];
            $mail->Password = $conf['mailer']['Password'];
            $mail->setFrom($conf['mailer']['MailerMail'], $conf['mailer']['MailerName']);            
            $mail->charSet = "UTF-8"; 
            $mail->Host = $conf['mailer']['Host'];
            $mail->Host = "smtp.live.com";
            $mail->Port = 587;
            $mail->IsSMTP();
            $mail->SMTPAuth = $conf['mailer']['SMTPAuth']; 
            $mail->addReplyTo($conf['mailer']['ReplyToMail'], $conf['mailer']['ReplyToName']);

            //Cuerpo del correo y destinatarios
            $mail->AddAddress("ebertunerg@gmail.com", "Ebert Manuel");
            $mail->isHTML(true);                                 
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Archivos Adjuntos
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            $mail->Send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
