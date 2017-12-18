<?php
//region Espacios de nombres e importación de librerías
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use Exception;

//endregion

/**
 * Tamaño de Empresas por cantidad de Empleados
 */
class UsprohModel
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

    public function Registros($ProcedimientoID = '', $ControlID = '')
    {
        try
        {
            $query = "EXEC dbo.SPS_ABCS_USPROH @ACCION = ?";
            if ($ProcedimientoID != '') {
                $query .= ", @ProcedimientoID=?";
            }
            if ($ControlID != '') {
                $query .= ", @ControlID=?";
            }
            $params = array(
                array('S', SQLSRV_PARAM_IN),
                array(&$ProcedimientoID, SQLSRV_PARAM_IN),
                array(&$ControlID, SQLSRV_PARAM_IN),
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
            $sqlString = "EXEC DBO.SPS_ABCS_USPROH @ACCION=?, @ProcedimientoID = ?, @ControlID = ?, @DescripcionControl = ?";
            $params = array(
                array('A', SQLSRV_PARAM_IN),
                array(&$modelo['ProcedimientoID'], SQLSRV_PARAM_IN),
                array(&$modelo['ControlID'], SQLSRV_PARAM_IN),
                array(&$modelo['DescripcionControl'], SQLSRV_PARAM_IN),
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
            $sqlString = "EXEC DBO.SPS_ABCS_USPROH @ACCION=?, @ProcedimientoID = ?, @ControlID = ?, @DescripcionControl = ?";
            $params = array(
                array('C', SQLSRV_PARAM_IN),
                array(&$modelo['ProcedimientoID'], SQLSRV_PARAM_IN),
                array(&$modelo['ControlID'], SQLSRV_PARAM_IN),
                array(&$modelo['DescripcionControl'], SQLSRV_PARAM_IN),
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

    public function EliminarRegistro($ProcedimientoID, $ControlID)
    {
        try
        {
            $sqlString = "EXEC dbo.SPS_ABCS_USPROH @ACCION=?, @ProcedimientoID=?, @ControlID=?";
            $params = array(
                array('B', SQLSRV_PARAM_IN),
                array(&$ProcedimientoID, SQLSRV_PARAM_IN),
                array(&$ControlID, SQLSRV_PARAM_IN),
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
