<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\TidModel;

$app->group('/tipoidentificaciones/', function () {
    $this->get('[{tipoid}]', function ($req, $res, $args) {
        try {
            $model = new TidModel();
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
        $tipoid = isset($args['tipoid']) ? $args['tipoid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Get($tipoid);

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
