<?php
//region Espacios de nombres e importación de librerías
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use Exception;

//endregion

/**
 * Tablas Genéricas
 */
class TgenModel
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

    public function Registros($tabla, $campo, $codigo = '')
    {
        try
        {
            $query = "EXEC dbo.SPS_ABCS_TGEN @TABLA=?, @CAMPO=?, @CODIGO=?";
            $params = array(
                array(&$tabla, SQLSRV_PARAM_IN),
                array(&$campo, SQLSRV_PARAM_IN),
                array(&$codigo, SQLSRV_PARAM_IN),
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

    public function NuevoRegistro($modelo)
    {
        try
        {
            $sqlString = "EXEC DBO.SPS_ABCS_TGEN @ACCION=?, @TABLA = ?, @CAMPO = ?, @CODIGO = ?, @DESCRIPCION = ?, @VALOR1 = ?, @DATO1 = ?, @DFECHA = ?, @OPCIONESLIBRES = ?, @VALORINI = ?, @VALORFIN = ?, @VALOR2 = ?, @DATO2 = ?";
            $params = array(
                array('A', SQLSRV_PARAM_IN),
                array(&$modelo['TABLA'], SQLSRV_PARAM_IN),
                array(&$modelo['CAMPO'], SQLSRV_PARAM_IN),
                array(&$modelo['CODIGO'], SQLSRV_PARAM_IN),
                array(&$modelo['DESCRIPCION'], SQLSRV_PARAM_IN),
                array(&$modelo['VALOR1'], SQLSRV_PARAM_IN),
                array(&$modelo['DATO1'], SQLSRV_PARAM_IN),
                array(&$modelo['DFECHA'], SQLSRV_PARAM_IN),
                array(&$modelo['OPCIONESLIBRES'], SQLSRV_PARAM_IN),
                array(&$modelo['VALORINI'], SQLSRV_PARAM_IN),
                array(&$modelo['VALORFIN'], SQLSRV_PARAM_IN),
                array(&$modelo['VALOR2'], SQLSRV_PARAM_IN),
                array(&$modelo['DATO2'], SQLSRV_PARAM_IN),
            );
            //region Ejecución de Query y Obtención de Resultados
            $stmt = sqlsrv_prepare($this->db, $sqlString, $params);
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
            // $data = array();
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
            // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            //     $data[] = $row;
            // }
            //endregion
            //region Construcción de la respuesta
            $this->response->setResponse(true);
            $this->response->result = true;
            return $this->response;
            //endregion
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function ActualizarRegistro($modelo)
    {
        try
        {
            $sqlString = "EXEC DBO.SPS_ABCS_TGEN @ACCION=?, @TABLA = ?, @CAMPO = ?, @CODIGO = ?, @DESCRIPCION = ?, @VALOR1 = ?, @DATO1 = ?, @DFECHA = ?, @OPCIONESLIBRES = ?, @VALORINI = ?, @VALORFIN = ?, @VALOR2 = ?, @DATO2 = ?";
            $params = array(
                array('C', SQLSRV_PARAM_IN),
                array(&$modelo['TABLA'], SQLSRV_PARAM_IN),
                array(&$modelo['CAMPO'], SQLSRV_PARAM_IN),
                array(&$modelo['CODIGO'], SQLSRV_PARAM_IN),
                array(&$modelo['DESCRIPCION'], SQLSRV_PARAM_IN),
                array(&$modelo['VALOR1'], SQLSRV_PARAM_IN),
                array(&$modelo['DATO1'], SQLSRV_PARAM_IN),
                array(&$modelo['DFECHA'], SQLSRV_PARAM_IN),
                array(&$modelo['OPCIONESLIBRES'], SQLSRV_PARAM_IN),
                array(&$modelo['VALORINI'], SQLSRV_PARAM_IN),
                array(&$modelo['VALORFIN'], SQLSRV_PARAM_IN),
                array(&$modelo['VALOR2'], SQLSRV_PARAM_IN),
                array(&$modelo['DATO2'], SQLSRV_PARAM_IN),
            );
            //region Ejecución de Query y Obtención de Resultados
            $stmt = sqlsrv_prepare($this->db, $sqlString, $params);
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
            // $data = array();
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
            // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            //     $data[] = $row;
            // }
            //endregion
            //region Construcción de la respuesta
            $this->response->setResponse(true);
            $this->response->result = true;
            return $this->response;
            //endregion
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function EliminarRegistro($tabla, $campo, $codigo)
    {
        try
        {
            $sqlString = "EXEC dbo.SPS_ABCS_TGEN @ACCION=?, @TABLA=?, @CAMPO=?, @CODIGO=?";
            $params = array(
                array('B', SQLSRV_PARAM_IN),
                array(&$tabla, SQLSRV_PARAM_IN),
                array(&$campo, SQLSRV_PARAM_IN),
                array(&$codigo, SQLSRV_PARAM_IN),
            );
            //region Ejecución de Query y Obtención de Resultados
            $stmt = sqlsrv_prepare($this->db, $sqlString, $params);
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
            // $data = array();
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
            // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            //     $data[] = $row;
            // }
            //endregion
            //region Construcción de la respuesta
            $this->response->setResponse(true);
            $this->response->result = true;
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
