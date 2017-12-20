<?php
//region Espacios de nombres e importación de librerías
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\Tokens;
use Exception;

//endregion

/**
 * Usuarios del sistema
 */
class UsuarioModel
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

    public function Get($usuario)
    {
        try
        {
            $result = array();
            $accion = 'S';
            $query = "EXEC dbo.SPS_ABCS_USU @ACCION=?, @USUARIOID=?";
            $stmt = sqlsrv_prepare($this->db, $query, array(&$accion, &$usuario));
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
            $this->response->setResponse(true);
            $this->response->result = $data;

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function Registros($SEDEID = '', $USUARIOID = '')
    {
        try
        {
            $query = "EXEC dbo.SPS_ABCS_USU @ACCION=?";
            if ($SEDEID != '') {
                $query .= ", @SEDEID = ?";
            }
            if ($USUARIOID != '') {
                $query .= ", @USUARIOID = ?";
            }
            // var_dump($query);
            $params = array(
                array('S', SQLSRV_PARAM_IN),
                array(&$SEDEID, SQLSRV_PARAM_IN),
                array(&$USUARIOID, SQLSRV_PARAM_IN),
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

    public function Login($usuario, $clave, $sedeid)
    {
        try
        {
            $result = array();
            $accion = 'S';
            $query = "EXEC dbo.SPS_ABCS_USU @ACCION=?, @USUARIOID=?, @CLAVE=?, @SEDEID=?";
            $stmt = sqlsrv_prepare($this->db, $query, array(&$accion, &$usuario, &$clave, &$sedeid));
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

            if (count($data) > 0) {
                $dataACifrar = $data[0];

                // ----------------- Sección de Token
                $jwt = new Tokens();
                $dataACifrar['CLAVE'] = $clave;
                $token = $jwt->encode($dataACifrar);
                $this->response->SetToken($token);
                // ----------------- Fin Sección de Token

                $data[0]['TOKEN'] = $token;
            }
            $this->response->result = $data;

            $this->response->setResponse(true);

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function Sesion()
    {
        $this->response->result = true;
        $this->response->setResponse(true);
        return $this->response;
    }

    public function ReenviarClave($email)
    {
        try
        {
            $query = "SELECT CLAVE = CONVERT(VARCHAR(300), DECRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),CLAVE)) FROM USU WHERE EMAIL=?";
            $params = array(
                array(&$email, SQLSRV_PARAM_IN),
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
            $clave = "";
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $clave = $row['CLAVE'];
            }
            //endregion
            //region Construcción de la respuesta
            $this->response->setResponse(true);
            $this->response->result = $clave;
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
            $sqlString = "EXEC DBO.SPS_ABCS_USU @ACCION = ?, @USUARIOID=?, @CLAVE = ?, @NOMBRE = ?, @GRUPOID = ?, @ACTIVO = ?, @EMAIL = ?, @SEDEID = ?";
            $params = array(
                array('A', SQLSRV_PARAM_IN),
                array(&$modelo['USUARIOID'], SQLSRV_PARAM_IN),
                array(&$modelo['CLAVE'], SQLSRV_PARAM_IN),
                array(&$modelo['NOMBRE'], SQLSRV_PARAM_IN),
                array(&$modelo['GRUPOID'], SQLSRV_PARAM_IN),
                array(($modelo['ACTIVO']) ? "1" : "0", SQLSRV_PARAM_IN),
                array(&$modelo['EMAIL'], SQLSRV_PARAM_IN),
                array(&$modelo['SEDEID'], SQLSRV_PARAM_IN),
            );
            // var_dump($sqlString);
            // var_dump($params);
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
            $sqlString = "EXEC DBO.SPS_ABCS_USU @ACCION = ?, @USUARIOID=?, @CLAVE = ?, @NOMBRE = ?, @GRUPOID = ?, @ACTIVO = ?, @EMAIL = ?, @SEDEID = ?";
            $params = array(
                array('C', SQLSRV_PARAM_IN),
                array(&$modelo['USUARIOID'], SQLSRV_PARAM_IN),
                array(&$modelo['CLAVE'], SQLSRV_PARAM_IN),
                array(&$modelo['NOMBRE'], SQLSRV_PARAM_IN),
                array(&$modelo['GRUPOID'], SQLSRV_PARAM_IN),
                array(($modelo['ACTIVO']) ? "1" : "0", SQLSRV_PARAM_IN),
                array(&$modelo['EMAIL'], SQLSRV_PARAM_IN),
                array(&$modelo['SEDEID'], SQLSRV_PARAM_IN),
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

    public function CambiarClave($modelo)
    {
        try
        {
            $sqlString = "EXEC DBO.SPS_ABCS_USU @ACCION = ?, @USUARIOID=?, @CLAVE = ?, @SEDEID = ?";
            $params = array(
                array('C', SQLSRV_PARAM_IN),
                array(&$modelo['USUARIOID'], SQLSRV_PARAM_IN),
                array(&$modelo['CLAVE'], SQLSRV_PARAM_IN),
                array(&$modelo['SEDEID'], SQLSRV_PARAM_IN),
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
