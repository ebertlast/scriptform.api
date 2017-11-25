<?php
use App\Lib\Response;
use App\Model\ConsolidadoModel as Model;

$app->group('/consolidado/', function () {
    $this->get('', function ($req, $res, $args) {
        try {
            $model = new Model();
        } catch (Exception $e) {
            $messageError = ($e->getMessage());
            $messageError = preg_replace('/[^A-Za-z0-9\-]/', ' ', $messageError);
            $response = new Response();
            $response->SetResponse(false, $messageError);
            return $res
                ->getBody()
                ->write(
                    json_encode($response, JSON_UNESCAPED_UNICODE)
                );
        }

        $response = new Response();
        // var_dump($response);
        $response = $model->EjecutarConsulta();
        // var_dump($response);
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
