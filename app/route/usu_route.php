<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\UsuarioModel as Model;

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

});
