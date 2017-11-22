<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\RepuModel;

$app->group('/reportes/usuarios/', function () {
    $this->get('{reporteid}', function ($req, $res, $args) {
        try {
            $model = new RepuModel();
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
        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->GetUsuarios($reporteid);

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

    $this->delete('{reporteid}/{usuarioid}/{sedeid}', function ($req, $res, $args) {
        try {
            $model = new RepuModel();
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
        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';
        $usuarioid = isset($args['usuarioid']) ? $args['usuarioid'] : '';
        $sedeid = isset($args['sedeid']) ? $args['sedeid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->EliminarUsuario($reporteid, $usuarioid, $sedeid);

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

    $this->put('{reporteid}/{usuarioid}/{sedeid}', function ($req, $res, $args) {
        try {
            $model = new RepuModel();
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
        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';
        $usuarioid = isset($args['usuarioid']) ? $args['usuarioid'] : '';
        $sedeid = isset($args['sedeid']) ? $args['sedeid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->AgregarUsuario($reporteid, $usuarioid, $sedeid);

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

});
