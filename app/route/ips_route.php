<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\IpsModel as Model;

$app->group('/ips/', function () {

    $this->get('todas', function ($req, $res, $args) {
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
        // $TipoDiscapacidadId = isset($args['TipoDiscapacidadId']) ? $args['TipoDiscapacidadId'] : '';
        //endregion

        //region Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Registros();
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

    $this->get('mixtas', function ($req, $res, $args) {
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
        $response = $model->Registros('','','1');
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

    $this->get('independientes', function ($req, $res, $args) {
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
        $response = $model->Registros('','','0');
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
