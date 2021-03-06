<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\NaeModel as Model;

$app->group('/naturalezaempresa/', function () {

    $this->put('nuevo', function ($req, $res, $args) {
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
        
        //region Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $token = $req->getAttribute('token');
        // $jwt = new Tokens();
        // $data = $jwt->decode($token);

        $modelo = json_decode($req->getParsedBody()['json'], true)['model'];
        //endregion

        //region Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->NuevoRegistro($modelo);
        //endregion

        //region Adjuntar el token en la respuesta
        $response->setToken($token);
        //endregion

        //region Enviar respuesta
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

    $this->get('[{NaturalezaID}]', function ($req, $res, $args) {
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
        $NaturalezaID = isset($args['NaturalezaID']) ? $args['NaturalezaID'] : '';
        //endregion
        
        //region Decodificar el token para obtener los datos del usuario
        // $jwt = new Tokens();
        // $data = $jwt->decode($token);
        // $TipoRelacionID = isset($args['TipoRelacionID']) ? $args['TipoRelacionID'] : '';
        //endregion

        //region Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Registros($NaturalezaID);
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

    $this->post('actualizar', function ($req, $res, $args) {
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

        //region Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $jwt = new Tokens();
        $token = $req->getAttribute('token');
        $modelo = json_decode($req->getParsedBody()['json'], true)['model'];
        //endregion

        //region Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->ActualizarRegistro($modelo);
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

    $this->delete('{NaturalezaID}', function ($req, $res, $args) {
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

        //region Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $jwt = new Tokens();
        $token = $req->getAttribute('token');
        $NaturalezaID = isset($args['NaturalezaID']) ? $args['NaturalezaID'] : '';
        //endregion

        //region Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->EliminarRegistro($NaturalezaID);
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
