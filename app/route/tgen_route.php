<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\TgenModel as Model;

$app->group('/tablasgenericas/', function () {

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
        $jwt = new Tokens();

        // Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $token = $req->getAttribute('token');
        $modelo = json_decode($req->getParsedBody()['json'], true)['model'];
        // var_dump($modelo);

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->NuevoRegistro($modelo);

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

    $this->get('{tabla}/{campo}/[{codigo}]', function ($req, $res, $args) {
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
        $tabla = isset($args['tabla']) ? $args['tabla'] : '';
        $campo = isset($args['campo']) ? $args['campo'] : '';
        $codigo = isset($args['codigo']) ? $args['codigo'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Registros($tabla, $campo, $codigo);

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

        // Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $jwt = new Tokens();
        $token = $req->getAttribute('token');
        $modelo = json_decode($req->getParsedBody()['json'], true)['model'];

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->ActualizarRegistro($modelo);

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

    $this->delete('{tabla}/{campo}/{codigo}', function ($req, $res, $args) {
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

        // Obtener el token para enviarlo en la respuesta y los parametros para generar la consulta
        $jwt = new Tokens();
        $token = $req->getAttribute('token');
        $tabla = isset($args['tabla']) ? $args['tabla'] : '';
        $campo = isset($args['campo']) ? $args['campo'] : '';
        $codigo = isset($args['codigo']) ? $args['codigo'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->EliminarRegistro($tabla, $campo, $codigo);

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

    $this->get('distintoscampos/{tabla}', function ($req, $res, $args) {
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
        $tabla = isset($args['tabla']) ? $args['tabla'] : '';
        
        // Decodificar el token para obtener los datos del usuario
        // $data = $jwt->decode($token);

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->DistintosCampos($tabla);

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

    $this->get('distintastablas', function ($req, $res, $args) {
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
        $tabla = isset($args['tabla']) ? $args['tabla'] : '';
        
        // Decodificar el token para obtener los datos del usuario
        // $data = $jwt->decode($token);

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->DistintasTablas($tabla);

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
