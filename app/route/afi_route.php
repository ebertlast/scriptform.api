<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\AfiModel as Model;

$app->group('/afiliados/', function () {
    $this->get('{tipoid}/{numeroidentificacion}', function ($req, $res, $args) {
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

        $jwt = new Tokens();

        // Obtener el token con los datos actualizados
        $token = $req->getAttribute('token');

        // Decodificar el token para obtener los datos del usuario
        // $data = $jwt->decode($token);
        $tipoid = isset($args['tipoid']) ? $args['tipoid'] : '';
        $numeroidentificacion = isset($args['numeroidentificacion']) ? $args['numeroidentificacion'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->AfiliadoPorDocumento($tipoid,$numeroidentificacion);

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
