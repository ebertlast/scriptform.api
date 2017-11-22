<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\ReppModel;

$app->group('/parametros/', function () {
    $this->get('{reporteid}', function ($req, $res, $args) {
        try {
            $model = new ReppModel();
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

        // Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $token = $req->getAttribute('token');

        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Get($reporteid);

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

    $this->get('consulta/{reporteid}/{parametroid}', function ($req, $res, $args) {
        try {
            $model = new ReppModel();
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

        // Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $token = $req->getAttribute('token');

        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';
        $parametroid = isset($args['parametroid']) ? $args['parametroid'] : '';
        // echo('reporteid: '.$reporteid);
        // echo('$parametroid: '.$parametroid);
        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->GetConsulta($reporteid, $parametroid);

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

    $this->put('actualizarvalor/{reporteid}/{parametroid}/[{valor}]', function ($req, $res, $args) {
        try {
            $model = new ReppModel();
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

        // Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $token = $req->getAttribute('token');

        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';
        $parametroid = isset($args['parametroid']) ? $args['parametroid'] : '';
        $valor = isset($args['valor']) ? $args['valor'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->ActualizarValor($reporteid, $parametroid, $valor);

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
