<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
// use App\Lib\Tokens;

use Exception;

class RepModel
{
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

    public function Get($usuarioid, $sedeid, $reporteid = '')
    {
        try
        {
            $result = array();
            $query = "EXEC DBO.SPS_ABCS_REP @USUARIOID=?, @SEDEID=?, @REPORTEID=?";
            $stmt = sqlsrv_prepare($this->db, $query, array(&$usuarioid, &$sedeid, &$reporteid));
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

            // $this->response->setResponse(false);
            // $this->response->message = "Pruebas de Desarrollo";
            // $this->response->setLogout(true);

            // $this->response->setToken('Ebert');

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function EjecutarConsulta($reporteid)
    {
        try
        {
            // ini_set('memory_limit', '128M');

            $result = array();
            $query = "EXEC DBO.SPS_ABCS_REP @ReporteID = ?";
            $stmt = sqlsrv_prepare($this->db, $query, array(
                array(&$reporteid, SQLSRV_PARAM_IN),
            )
            );
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

            // $this->response->setResponse(false);
            // $this->response->message = "Pruebas de Desarrollo";
            // $this->response->setLogout(true);

            // $this->response->setToken('Ebert');

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function ReportePaginado($reporteid, $filasPorPagina = '100', $nroPagina = '1')
    {
        try
        {
            $totalPaginas = 0;
            $result = array();
            $query = "EXEC DBO.SPS_EJECUTAR_CONSULTA @ReporteID = ?, @FilasPorPagina = ?, @NroPagina = ?, @TotalPaginas = ?";
            $params = array(
                array(&$reporteid, SQLSRV_PARAM_IN),
                array(&$filasPorPagina, SQLSRV_PARAM_IN),
                array(&$nroPagina, SQLSRV_PARAM_IN),
                array(&$totalPaginas, SQLSRV_PARAM_OUT),
            );

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
            sqlsrv_next_result($stmt);

            // echo('<br/>Total Paginas: '.$totalPaginas);

            // while($res = sqlsrv_next_result($stmt))
            // {
            //     $data[] = $row;
            // }
            $data = array('data' => $data, 'totalpaginas' => $totalPaginas);
            $this->response->setResponse(true);
            $this->response->result = $data;

            // $this->response->setResponse(false);
            // $this->response->message = "Pruebas de Desarrollo";
            // $this->response->setLogout(true);

            // $this->response->setToken('Ebert');

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function ActualizarQuery($reporteid, $consulta)
    {
        try
        {
            $result = array();
            $query = "EXEC DBO.SPS_ABCS_REP @ACCION=?, @REPORTEID=?, @QUERY=?";
            $params = array(
                array('C', SQLSRV_PARAM_IN),
                array(&$reporteid, SQLSRV_PARAM_IN),
                array(&$consulta, SQLSRV_PARAM_IN),
            );
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
            $this->response->setResponse(true);
            $this->response->result = true;
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function NuevoReporte($nombre, $consulta)
    {
        try
        {
            $result = array();
            $query = "EXEC DBO.SPS_ABCS_REP @ACCION=?, @NOMBRE=?, @QUERY=?";
            $params = array(
                array('A', SQLSRV_PARAM_IN),
                array(&$nombre, SQLSRV_PARAM_IN),
                array(&$consulta, SQLSRV_PARAM_IN),
            );
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
            $this->response->setResponse(true);
            $this->response->result = true;
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

    public function ExportacionExcelDesdeSQL($reporteid)
    {
        try
        {
            $urlFile = "";
            $result = array();
            $query = "EXEC DBO.SPS_REPORT_EXCEL @ReporteID = ?";
            $params = array(
                array(&$reporteid, SQLSRV_PARAM_IN)
            );

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
                $urlFile = $row['UrlFile'];
            }
           
            $this->response->setResponse(true);
            $this->response->result = $urlFile;


            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }
    }

}
