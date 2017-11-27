<?php
//region Espacios de nombres e importación de librerías
namespace App\Model;
use App\Lib\Database;
use App\Lib\Response;
use Exception;
//endregion

/**
 * Afiliados o Cotizantes
 */
class AfiModel
{
    //region Variables de entorno, constructor y destructor de la clase
    private $db;
    public $response;

    private $servidor;
    private $dbbase;

    public function __CONSTRUCT($servidor = '', $dbbase = '', $usuario = '', $clave = '')
    {
        try {
            $this->response = new Response();
            $this->db = Database::StartUp($servidor, $dbbase, $usuario, $clave);
            $this->servidor = $servidor;
            $this->dbbase = $dbbase;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function __DESTRUCT()
    {
        sqlsrv_close($this->db);
    }
    //endregion

    /**
     * Devuelte un registro de la tabla AFI correspondiente al afiliado que se consulta por su documento de identidad
     *
     * @param string Codigo del tipo de documento de identidad
     * @param string Número de documento de identidad
     * @return void
     */
    public function AfiliadoPorDocumento($tipoid, $numerodocumento)
    {
        try
        {
            $query = "EXEC dbo.SPS_ABCS_AFI @TipoID=?, @NumeroIdentificacion=?";
            $params = array(
                array(&$tipoid, SQLSRV_PARAM_IN),
                array(&$numerodocumento, SQLSRV_PARAM_IN),
            );
            //region Consulta y Obtención de Resultados
            $stmt = sqlsrv_prepare($this->db, $query, $params);
            if (!$stmt) {
                $error = "";
                if (($errors = sqlsrv_errors()) != null) {
                    foreach ($errors as $error) {
                        $sqlstate = "SQLSTATE: " . $error['SQLSTATE'] . "";
                        $code = "Code: " . $error['code'] . "";
                        $message = "Message: " . $error['message'] . ".";
                        $error = $sqlstate . ".- (" . $code . ") " . $message;
                    }
                }
                $this->response->setResponse(false);
                $this->response->message = $error;
                return $this->response;
            }
            $data = array();
            $result = sqlsrv_execute($stmt);
            if (!$result) {
                $error = "";
                if (($errors = sqlsrv_errors()) != null) {
                    foreach ($errors as $error) {
                        $sqlstate = "SQLSTATE: " . $error['SQLSTATE'] . "";
                        $code = "Code: " . $error['code'] . "";
                        $message = "Message: " . $error['message'] . ".";
                        $error = $sqlstate . ".- (" . $code . ") " . $message;
                    }
                }
                $this->response->setResponse(false);
                $this->response->message = $error;
                return $this->response;
            }
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $data[] = $row;
            }
            //endregion
            //region Construcción de la respuesta
            $this->response->setResponse(true);
            $this->response->result = $data;
            return $this->response;
            //endregion
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

}
