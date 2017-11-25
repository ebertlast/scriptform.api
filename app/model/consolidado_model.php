<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
// use App\Lib\Tokens;

use Exception;

class ConsolidadoModel
{
    private $db;
    public $response;

    private $servidor;
    private $dbbase;

    public function __CONSTRUCT($database_path = '', $usuario = '', $clave = '')
    {
        try {
            $this->response = new Response();
            $this->db = Database::StartUpAccess($database_path, $usuario, $clave);
            
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function __DESTRUCT()
    {
        // sqlsrv_close($this->db);
        // odbc_close($this->db);
    }

    public function EjecutarConsulta()
    {
        try
        {
            ini_set('memory_limit','16M');
            $sql = "SELECT top 10000 * ";
            $sql .= "FROM CONSOLIDADO_R3 ";

            $data = array();
            $result = array();
            try {
                $result = $this->db->query($sql);
            } catch (PDOException $e) {
                throw $e;
            }
            while ($row = $result->fetch()) {
                foreach ($row as $key => $value) {
                    $row[$key] = utf8_encode($value);
                }
                $data[] = $row;
            }

            $this->response->setResponse(true);
            $this->response->result = $data;

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } finally {
            // sqlsrv_free_stmt($stmt);
        }
    }

}
