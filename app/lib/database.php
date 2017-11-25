<?php
namespace App\Lib;

use Exception;

class Database
{
    public static function StartUpMySQL($dbhost, $dbname, $dbuser = "", $dbpass = "")
    {
        try {
            $conn = new \Slim\PDO\Database("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
            return $conn;
        } catch (Exception $e) {
            throw ($e);
        }
        return $conn;
    }

    public static function StartUpAccess($database_path, $dbuser = "", $dbpass = "")
    {
        try {
            $database_path = __DIR__ . "\\CONSOLIDADO_RS_2017.accdb";
            // echo $database_path;
            if (!file_exists($database_path)) {
                $msgError = "Access database file not found!";
                throw new Exception($msgError, 1);
            }

            // Provider=Microsoft.ACE.OLEDB.12.0;Data Source=C:\myFolder\myAccessFile.accdb;Persist Security Info=False;
            // $conn = new \Slim\PDO\Database("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$database_path; Uid=$dbuser; Pwd=$dbpass;");
            // $conn = new \Slim\PDO\Database("Provider=Microsoft Access Driver (*.mdb, *accdb);Dbq=$database_path;Persist Security Info=False;");
            
            // $conn = new \Slim\PDO\Database("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; Dbq=$database_path; Uid=$dbuser; Pwd=$dbpass;");
            $strConn="odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$database_path";
            // $conn = new \Slim\PDO\Database($strConn);
            // $conn->exec("set names utf8");
            $conn = new \Slim\PDO\Database($strConn, null, null, array(
                \Slim\PDO\Database::ATTR_ERRMODE => \Slim\PDO\Database::ERRMODE_EXCEPTION,
                \Slim\PDO\Database::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
              ));
            
            return $conn;
        } catch (Exception $e) {
            throw ($e);
        }
        return $conn;
    }

    public static function StartUp($dbhost = '', $dbname = '', $dbuser = '', $dbpasswd = '')
    {
        try {
            $settings = require '../src/settings.php';
            $conf = $settings["settings"];
            if ($dbhost == '') {$dbhost = $conf['database_default']['dbhost'];}
            if ($dbname == '') {$dbname = $conf['database_default']['dbname'];}
            if ($dbuser == '') {$dbuser = $conf['database_default']['dbuser'];}
            if ($dbpasswd == '') {$dbpasswd = $conf['database_default']['dbpasswd'];}

            $serverName = $dbhost;
            $connectionInfo = ($dbuser === "") ?
            array("Database" => $dbname, "CharacterSet" => "UTF-8") :
            array("Database" => $dbname, "UID" => $dbuser, "PWD" => $dbpasswd, "CharacterSet" => "UTF-8");
            $conn = sqlsrv_connect($serverName, $connectionInfo);
            if ($conn) {
                return $conn;
            } else {
                $msgError = "Error al establecer conexión";
                foreach (sqlsrv_errors() as $error) {
                    $msgError = $msgError . "; (" . $error['code'] . ") " . $error["message"];
                }
                throw new Exception($msgError, 1);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $conn;
    }
}
