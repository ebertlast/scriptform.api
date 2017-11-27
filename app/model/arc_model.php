<?php
namespace App\Model;
use App\Lib\Database;
use App\Lib\Response;
use Exception;
class ArcModel
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

    public function Archivos($archivoid='')
    {
        try
        {
            $result = array();
            $query = "EXEC DBO.SPS_ABCS_ARC @ARCHIVOID = ?";
            $stmt = sqlsrv_prepare($this->db, $query, array( array(&$archivoid, SQLSRV_PARAM_IN)));
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
        }
    }

    public function ArchivosPorUsuario($usuarioid='')
    {
        try
        {
            $result = array();
            $query = "EXEC DBO.SPS_ABCS_ARC @USUARIOID = ?";
            $stmt = sqlsrv_prepare($this->db, $query, array( array(&$usuarioid, SQLSRV_PARAM_IN)));
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
        }
    }

    public function NuevoArchivo($archivo)
    {
        try
        {
            $result = array();
            $sqlString = "EXEC DBO.SPS_ABCS_ARC @ACCION=?, @ARCHIVOID = ?, @FORMULARIOID = ?, @TIPOID = ?, @NUMEROIDENTIFICACION = ?, @MUNICIPIOID = ?, @USUARIOID = ?, @SEDEID = ?, @NUEVOREGISTRO = ?, @CANTIDADBENEFICIARIOS = ?";
            $params = array(
                array('A', SQLSRV_PARAM_IN),
                array(&$archivo['ARCHIVOID'], SQLSRV_PARAM_IN),
                array(&$archivo['FORMULARIOID'], SQLSRV_PARAM_IN),
                array(&$archivo['TIPOID'], SQLSRV_PARAM_IN),
                array(&$archivo['NUMEROIDENTIFICACION'], SQLSRV_PARAM_IN),
                array(&$archivo['MUNICIPIOID'], SQLSRV_PARAM_IN),
                array(&$archivo['USUARIOID'], SQLSRV_PARAM_IN),
                array(&$archivo['SEDEID'], SQLSRV_PARAM_IN),
                array(($archivo['NUEVOREGISTRO'])?"1":"0", SQLSRV_PARAM_IN),
                array(&$archivo['CANTIDADBENEFICIARIOS'], SQLSRV_PARAM_IN)
            );
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

}