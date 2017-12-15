<?php
//region Espacios de nombres e importación de librerías
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use Exception;

//endregion

/**
 * Empresas Empleadoreas
 */
class EmplModel
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

    public function Registros($TipoID = '', $NumeroIdentificacion = '')
    {
        try
        {
            $query = "EXEC dbo.SPS_ABCS_EMPL @ACCION = ?";
            if ($TipoID == '') {
                $query .= ", @TipoID=?";
            }
            if ($NumeroIdentificacion == '') {
                $query .= ", @NumeroIdentificacion=?";
            }
            $params = array(
                array('S', SQLSRV_PARAM_IN),
                array(&$TipoID, SQLSRV_PARAM_IN),
                array(&$NumeroIdentificacion, SQLSRV_PARAM_IN),
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
            $sqlString = "EXEC DBO.SPS_ABCS_EMPL @ACCION=?, @TipoID = ?, @NumeroIdentificacion = ?, @RazonSocial = ?, @DireccionFiscal = ?, @Email = ?, @Telefono = ?, @MunicipioID = ?, @UsuarioID = ?, @SedeID = ?, @NaturalezaID = ?, @RegimeEmpresaID = ?, @TamanoID = ?, @TipoEmpresaID = ?";
            $params = array(
                array('A', SQLSRV_PARAM_IN),
                array(&$modelo['TipoID'], SQLSRV_PARAM_IN),
                array(&$modelo['NumeroIdentificacion'], SQLSRV_PARAM_IN),
                array(&$modelo['RazonSocial'], SQLSRV_PARAM_IN),
                array(&$modelo['DireccionFiscal'], SQLSRV_PARAM_IN),
                array(&$modelo['Email'], SQLSRV_PARAM_IN),
                array(&$modelo['Telefono'], SQLSRV_PARAM_IN),
                array(&$modelo['MunicipioID'], SQLSRV_PARAM_IN),
                array(&$modelo['UsuarioID'], SQLSRV_PARAM_IN),
                array(&$modelo['SedeID'], SQLSRV_PARAM_IN),
                array(&$modelo['NaturalezaID'], SQLSRV_PARAM_IN),
                array(&$modelo['RegimeEmpresaID'], SQLSRV_PARAM_IN),
                array(&$modelo['TamanoID'], SQLSRV_PARAM_IN),
                array(&$modelo['TipoEmpresaID'], SQLSRV_PARAM_IN),
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
            $sqlString = "EXEC DBO.SPS_ABCS_EMPL @ACCION=?, @TipoID = ?, @NumeroIdentificacion = ?, @RazonSocial = ?, @DireccionFiscal = ?, @Email = ?, @Telefono = ?, @MunicipioID = ?, @UsuarioID = ?, @SedeID = ?, @NaturalezaID = ?, @RegimeEmpresaID = ?, @TamanoID = ?, @TipoEmpresaID = ?";
            $params = array(
                array('C', SQLSRV_PARAM_IN),
                array(&$modelo['TipoID'], SQLSRV_PARAM_IN),
                array(&$modelo['NumeroIdentificacion'], SQLSRV_PARAM_IN),
                array(&$modelo['RazonSocial'], SQLSRV_PARAM_IN),
                array(&$modelo['DireccionFiscal'], SQLSRV_PARAM_IN),
                array(&$modelo['Email'], SQLSRV_PARAM_IN),
                array(&$modelo['Telefono'], SQLSRV_PARAM_IN),
                array(&$modelo['MunicipioID'], SQLSRV_PARAM_IN),
                array(&$modelo['UsuarioID'], SQLSRV_PARAM_IN),
                array(&$modelo['SedeID'], SQLSRV_PARAM_IN),
                array(&$modelo['NaturalezaID'], SQLSRV_PARAM_IN),
                array(&$modelo['RegimeEmpresaID'], SQLSRV_PARAM_IN),
                array(&$modelo['TamanoID'], SQLSRV_PARAM_IN),
                array(&$modelo['TipoEmpresaID'], SQLSRV_PARAM_IN),
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

    public function EliminarRegistro($TipoID, $NumeroIdentificacion)
    {
        try
        {
            $sqlString = "EXEC dbo.SPS_ABCS_EMPL @ACCION=?, @TipoID=?, @NumeroIdentificacion=?";
            $params = array(
                array('B', SQLSRV_PARAM_IN),
                array(&$TipoID, SQLSRV_PARAM_IN),
                array(&$NumeroIdentificacion, SQLSRV_PARAM_IN),
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
