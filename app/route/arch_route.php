<?php
use App\Lib\Response;
use App\Model\ArchModel as Model;
use App\Lib\Tokens;

$app->group('/archivos_up_do/', function () {
    $this->post('upload', function ($req, $res, $args) {
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

        $response = new Response();
        $token = $req->getAttribute('token');
        $files = $req->getUploadedFiles();
        if (empty($files['files'])) {
            $response->setToken($token);
            $response->SetResponse(false, 'Ningún fichero encontrado en la solicitud');
            return $res
                ->withHeader('Content-type', 'application/json')
                ->getBody()
                ->write(
                    json_encode(
                        $response
                    )
                );
        }

        // $newfile = $files['files'];
        // $uploadFileName = date("Ymd_His_");
        // if ($newfile->getError() === UPLOAD_ERR_OK) {
        //     $uploadFileName .= $newfile->getClientFilename();
        //     $newfile->moveTo("./files/uploads/$uploadFileName");
        // } 
        // $response->SetResponse(true);
        // $response->result = array('filename' => $uploadFileName);

        $response = $model->GuardarArchivos($files);
        
        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $response
            )
        );

        // $response = $model->GuardarArchivos($files);

        $response->setToken($token);
        $response->SetResponse(false, "Ebert, fichero encontrado en la solicitud ($nombreArchivoNuevo)");
        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $response
                )
            );
    });

    $this->get('[{archivoid}]', function ($req, $res, $args) {
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

});
