<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\ArcModel as Model;

$app->group('/archivos/', function () {

    $this->get('[{archivoid}]', function ($req, $res, $args) {
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

        // Obtener el token con los datos actualizados
        $token = $req->getAttribute('token');

        // Decodificar el token para obtener los datos del usuario
        // $data = $jwt->decode($token);
        $archivoid = isset($args['archivoid']) ? $args['archivoid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Archivos($archivoid);

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

    $this->put('nuevo', function ($req, $res, $args) {
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

        // Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $token = $req->getAttribute('token');
        $modelo = json_decode($req->getParsedBody()['json'], true)['model'];
        
        // Decodificar el token para obtener los datos del usuario
        $tokenData = $jwt->decode($token);
        $modelo['USUARIOID'] = $tokenData->USUARIOID;
        $modelo['SEDEID'] = $tokenData->SEDEID;

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->NuevoArchivo($modelo);

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

    $this->get('sticker/{municipioid}', function ($req, $res, $args) {
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

        // Obtener el token con los datos actualizados
        $token = $req->getAttribute('token');

        // Decodificar el token para obtener los datos del usuario
        // $data = $jwt->decode($token);
        $municipioid = isset($args['municipioid']) ? $args['municipioid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->GenerarSticker($municipioid);

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
