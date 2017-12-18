<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\UsuarioModel as Model;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

$app->group('/usuarios/', function () {
    $this->get('[{usuario}]', function ($req, $res, $args) {
        try {
            $model = new Model();
        } catch (Exception $e) {
            $response = new Response();
            $response->SetResponse(false, $e->getMessage());
            return $res
                ->withHeader('Content-type', 'application/json')
                ->getBody()
                ->write(
                    json_encode(
                        $response
                    )
                );
        }
        $jwt = new Tokens();

        $token = $req->getAttribute('token');

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Get(isset($args['usuario']) ? $args['usuario'] : '');

        // Enviar el token en la respuesta
        $response->setToken($token);

        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $response
                )
            );
    });

    $this->get('ingresar/{usuario}/{clave}/{sedeid}', function ($req, $res, $args) {
        try {
            $model = new Model();
        } catch (Exception $e) {
            $response = new Response();
            $response->SetResponse(false, $e->getMessage());
            return $res
                ->withHeader('Content-type', 'application/json')
                ->getBody()
                ->write(
                    json_encode(
                        $response
                    )
                );
        }

        $usuario = $args['usuario'];
        $clave = $args['clave'];
        $sedeid = $args['sedeid'];

        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $model->Login($usuario, $clave, $sedeid)
                )
            );
    });

    $this->get('sesion/supervisarDEPRECATED', function ($req, $res, $args) {
        try {
            $model = new Model();
        } catch (Exception $e) {
            $response = new Response();
            $response->SetResponse(false, $e->getMessage());
            return $res
                ->withHeader('Content-type', 'application/json')
                ->getBody()
                ->write(
                    json_encode(
                        $response
                    )
                );
        }
        $token = $req->getAttribute('token');
        $respuesta = new Response();
        $respuesta->SetResponse(true);
        $respuesta->result = true;
        $respuesta->setToken($token);
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $respuesta
                )
            );
    });

    $this->get('sesion/supervisar', function ($req, $res, $args) {
        //region Firma del modelo de la clase
        try {
            $model = new Model();
        } catch (Exception $e) {
            $response = new Response();
            $response->SetResponse(false, $e->getMessage());
            return $res
                ->withHeader('Content-type', 'application/json')
                ->getBody()
                ->write(
                    json_encode(
                        $response
                    )
                );
        }
        //endregion

        //region Obtener el token con los datos actualizados
        $token = $req->getAttribute('token');
        //endregion

        //region Decodificar el token para obtener los datos del usuario
        // $jwt = new Tokens();
        // $data = $jwt->decode($token);
        //endregion

        //region Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Sesion();
        //endregion

        //region Adjuntar el token en la respuesta
        $response->setToken($token);
        //endregion

        //region Enviar la respuesta
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $response
                )
            );
        //endregion
    });

    $this->get('reenviarclave/{email}', function ($req, $res, $args) {
        //region Firma del modelo de la clase
        try {
            $model = new Model();
        } catch (Exception $e) {
            $response = new Response();
            $response->SetResponse(false, $e->getMessage());
            return $res
                ->withHeader('Content-type', 'application/json')
                ->getBody()
                ->write(
                    json_encode(
                        $response
                    )
                );
        }
        //endregion

        //region Obtener el token con los datos actualizados y parámetros
        $token = $req->getAttribute('token');
        $email = isset($args['email']) ? $args['email'] : '';
        //endregion

        //region Decodificar el token para obtener los datos del usuario
        // $jwt = new Tokens();
        // $data = $jwt->decode($token);
        // $TipoRelacionID = isset($args['TipoRelacionID']) ? $args['TipoRelacionID'] : '';
        //endregion

        //region Llamar el metodo del modelo para generar la respuesta
        $response = $model->ReenviarClave($email);
        $clave = $response->result;
        if ($clave == '') {
            $response->setResponse(false, "No tenemos registros de algún usuario con el correo electónico '$email'");
            $response->result = false;
        } else {
            $response->setResponse(true);
            $response->result = true;
            //region Envío de Email
            $conf = $this->get('settings');
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->SMTPSecure = $conf['mailer']['SMTPSecure'];
                $mail->Username = $conf['mailer']['Username'];
                $mail->Password = $conf['mailer']['Password'];
                $mail->setFrom($conf['mailer']['MailerMail'], $conf['mailer']['MailerName']);
                $mail->CharSet = "UTF-8";
                $mail->Host = $conf['mailer']['Host'];
                $mail->Host = "smtp.live.com";
                $mail->Port = 587;
                $mail->IsSMTP();
                $mail->SMTPAuth = $conf['mailer']['SMTPAuth'];
                $mail->addReplyTo($conf['mailer']['ReplyToMail'], $conf['mailer']['ReplyToName']);

                //Cuerpo del correo y destinatarios
                $mail->AddAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Reenvío de su clave ScriptForms';
                $mail->Body = "Su clave para ingresar al sistema es <b>$clave</b>";
                $mail->AltBody = "Su clave para ingresar al sistema es $clave";

                // Archivos Adjuntos
                // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                $mail->Send();
                // echo 'Message has been sent';
            } catch (Exception $e) {
                // echo 'Message could not be sent.';
                // echo 'Mailer Error: ' . $mail->ErrorInfo;
                $response->result = false;
                $response->setResponse(false, $mail->ErrorInfo);
            }
            //endregion

        }
        //endregion

        //region Adjuntar el token en la respuesta
        $response->setToken($token);
        //endregion

        //region Enviar la respuesta
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $response
                )
            );
        //endregion
    });

});
