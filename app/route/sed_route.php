<?php
use App\Lib\Response;
use App\Model\SedModel;

$app->group('/sedes/', function () {
    $this->get('[{sedeid}]', function ($req, $res, $args) {
        try {
            $model = new SedModel();
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

        return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $model->Get(isset($args['sedeid']) ? $args['sedeid'] : '')
                )
            );
    });

});
