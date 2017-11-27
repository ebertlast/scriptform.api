<?php
//region Espacios de nombres e importación de librerías
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use Exception;

//endregion

/**
 * Archivos
 */
class ArchModel
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
    function PrepareImageDBString($filepath)
    {
        $out = 'null';
        $handle = @fopen($filepath, 'rb');
        if ($handle)
        {
            $content = @fread($handle, filesize($filepath));
            $content = bin2hex($content);
            @fclose($handle);
            $out = "0x".$content;
        }
        return $out;
    }

    function RandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function GuardarArchivos($archivos)
    {
        $archivoASubir = $archivos['files'];
        $nombreLocalArchivo = date("Ymd_His_");
        $ubicacionLocal="";
        if ($archivoASubir->getError() === UPLOAD_ERR_OK) {
            $nombreLocalArchivo .= $archivoASubir->getClientFilename();
            $ubicacionLocal="./files/uploads/$nombreLocalArchivo";
            $archivoASubir->moveTo($ubicacionLocal);
        } else {
            $error = "Documento no ha podido ser subido a nuestro servidor";
            $this->response->setResponse(false);
            $this->response->message = $error;
            return $this->response;
        }
        // $this->response->setResponse(true);
        // $this->response->result = array('filename' => $nombreLocalArchivo);
        // return $this->response;

        try
        {
            $out = $this->PrepareImageDBString($ubicacionLocal);
            $archivoid=$this->RandomString();
            $query = "EXEC dbo.SPS_ABCS_ARCH @ACCION=?, @ARCHIVOID=?, @NOMBRE=?, @ARCHIVO=?";
            $params = array(
                array('A', SQLSRV_PARAM_IN),
                array(&$archivoid, SQLSRV_PARAM_IN),
                array(&$nombreLocalArchivo, SQLSRV_PARAM_IN),
                array(&$out, SQLSRV_PARAM_IN)
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
            // while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            //     $data[] = $row;
            // }
            //endregion
            //region Construcción de la respuesta
            // $this->response->setResponse(true);
            // $this->response->result = $data;
            // return $this->response;
            return $this->Archivos($archivoid);
            //endregion
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            sqlsrv_free_stmt($stmt);
        }

    }

    public function Archivos($archivoid='')
    {
        try
        {
            // echo $out;
            $query = "EXEC dbo.SPS_ABCS_ARCH @ARCHIVOID=?";
            $params = array(
                array(&$archivoid, SQLSRV_PARAM_IN)
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
