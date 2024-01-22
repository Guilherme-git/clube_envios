<?php

namespace API\Utils;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class Utils
{
    public static function getHeader()
    {
        return getallheaders();
    }

    public static function DBConnection()
    {
        return new Adapter([
            'driver'   => 'PDO_Mysql',
            'database' => 'clube_envios',
            'username' => 'root',
            'password' => '',
        ]);
    }

    public static function timezone()
    {
        return date_default_timezone_set('America/Sao_Paulo');
    }

    public static function validateToken()
    {
        self::timezone();

        $headers = self::getHeader();

        if(!isset($headers["token"])) {
            return [
                "status" => 400,
                "detail" => 'É necessário informar o token!'
            ];
        }
        $sql    = new Sql(self::DBConnection());
        $token = $sql->select();
        $token->from('access_token');
        $token->columns(["access_token","expires_in"]);
        $token->where(['access_token' => $headers["token"]]);
        $selectString = $sql->buildSqlString($token);
        $verifyToken  = self::DBConnection()->query($selectString, self::DBConnection()::QUERY_MODE_EXECUTE)->toArray();

        if(count($verifyToken) == 0) {
            return [
                "status" => 400,
                "detail" => 'Token inválido!'
            ];
        }
        if(strtotime(date("Y-m-d H:i:s")) > $verifyToken[0]["expires_in"]) {
            return [
                "status" => 400,
                "detail" => "Token expirado!"
            ];
        }

    }
}