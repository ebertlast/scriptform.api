<?php
use App\Lib\Response;
use App\Model\UsuarioModel;
use App\Lib\Tokens;

$app->group('/usuarios/', function () {
    $this->get('[{usuario}]', function ($req, $res, $args) {
        try {
            $model = new UsuarioModel();
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
            $model = new UsuarioModel();
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

});
