<?php
use App\Lib\Response;
use App\Lib\Tokens;
use App\Model\RepModel;

// require_once dirname(__FILE__) . '/../../vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
// use PHPExcel;
// require_once('third_party/PHPExcel.php');

$app->group('/reportes/', function () {
    $this->get('[{reporteid}]', function ($req, $res, $args) {
        try {
            $model = new RepModel();
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
        $data = $jwt->decode($token);
        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';
        $usuarioid = $data->USUARIOID;
        $sedeid = $data->SEDEID;

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Get($usuarioid, $sedeid, $reporteid);

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

    $this->get('todos/[{reporteid}]', function ($req, $res, $args) {
        try {
            $model = new RepModel();
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
        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';
        $usuarioid = '';
        $sedeid = '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->Get($usuarioid, $sedeid, $reporteid);

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

    $this->get('consulta/[{reporteid}]', function ($req, $res, $args) {
        try {
            $model = new RepModel();
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

        // Obtener el parametro para generar la consulta
        $reporteid = isset($args['reporteid']) ? $args['reporteid'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->EjecutarConsulta($reporteid);

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

    $this->get('ejecutar/{reporteid}/{filasPorPagina}/[{nroPagina}]', function ($req, $res, $args) {
        try {
            $model = new RepModel();
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
        $filasPorPagina = isset($args['filasPorPagina']) ? $args['filasPorPagina'] : '100';
        $nroPagina = isset($args['nroPagina']) ? $args['nroPagina'] : '1';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->ReportePaginado($reporteid, $filasPorPagina, $nroPagina);

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

    $this->put('actualizarquery/{reporteid}/{query}', function ($req, $res, $args) {
        try {
            $model = new RepModel();
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
        $query = isset($args['query']) ? $args['query'] : '';

        // Llamar el metodo del modelo para generar la respuesta
        $response = new Response();
        $response = $model->ActualizarQuery($reporteid, $query);

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

    $this->get('excel/[{reporteid}]', function ($req, $res, $args) {

        try {
            $model = new RepModel();
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
        $response = $model->ExportacionExcelDesdeSQL($reporteid);
        // $file = $response->result;
       
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
