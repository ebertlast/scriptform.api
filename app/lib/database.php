<?php
namespace App\Lib;
use Exception;
class Database
{
    public static function StartUpPDO($dbhost, $dbname, $dbuser="", $dbpass="") {
        try {
            $conn = new \Slim\PDO\Database("mysql:host=$dbhost;dbname=$dbname;charset=utf8",$dbuser,$dbpass);
            return $conn;
        }catch(Exception $e) {
            throw ($e);
        } 
        return $conn;
    }

    public static function StartUp($dbhost='', $dbname='', $dbuser='', $dbpasswd='') {
        try {
            $settings = require '../src/settings.php';
            $conf = $settings["settings"];
            if($dbhost==''){ $dbhost = $conf['database_default']['dbhost']; }
            if($dbname==''){ $dbname = $conf['database_default']['dbname']; }
            if($dbuser==''){ $dbuser = $conf['database_default']['dbuser']; }
            if($dbpasswd==''){ $dbpasswd = $conf['database_default']['dbpasswd']; }

            $serverName = $dbhost; 
            $connectionInfo = ($dbuser === "") ? 
                array( "Database"=>$dbname, "CharacterSet" => "UTF-8") : 
                array( "Database"=>$dbname, "UID"=>$dbuser, "PWD"=>$dbpasswd, "CharacterSet" => "UTF-8");
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            if( $conn ) {
                return $conn;
           }else{
                $msgError="Error al establecer conexión";
                foreach (sqlsrv_errors()as $error) {
                    $msgError=$msgError."; (".$error['code'].") ".$error["message"];
                }
                throw new Exception($msgError, 1);
           }
        } catch(Exception $e) {
            throw $e;
        }
        return $conn;
    }
}
